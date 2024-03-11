<?php
require_once(APPPATH . 'libraries/google-api-client/vendor/autoload.php');
defined('BASEPATH') or exit('No direct script access allowed');

class KonsultanAuth extends CI_Model
{

    public function is_user_logged_in()
    {
        // check the session
        if (isset($_SESSION['id_agen'])) {
            return true;
        }

        // check the remember_me in cookie
        if (isset($_COOKIE['remember_me_konsultan'])) {
            $token = htmlspecialchars($_COOKIE['remember_me_konsultan']);
            if ($token && $this->token_is_valid($token)) {
                $user = $this->find_user_by_token($token);

                if ($user) {
                    $this->load->model('agen');
                    $agen = $this->agen->getAgen($user['user_id']);
                    if (!empty($agen)) {
                        return $this->log_user_in($agen[0]);
                    }
                }
            }
        }
        return false;
    }

    public function token_is_valid($token)
    {
        $this->load->library('token');
        $tokenData = $this->token->parse_token($token);
        $tokens = $this->find_user_token_by_selector($tokenData[0]);
        if (!$tokens) {
            return false;
        }

        return password_verify($tokenData[1], $tokens['hashed_validator']);
    }
    public function find_user_by_token($token)
    {
        $this->load->library('token');

        $tokens = $this->token->parse_token($token);

        if (!$tokens) {
            return null;
        }

        $this->db->where('selector', $tokens[0]);
        $this->db->where('expiry > now()');
        return $this->db->get('agen_tokens')->row_array();
    }
    public function find_user_token_by_selector($selector)
    {
        $this->db->where('selector', $selector);
        $this->db->where('expiry >= now()');
        return $this->db->get('agen_tokens')->row_array();
    }
    public function login()
    {
        //check csrf from google
        if (!$this->checkCsrf()) {
            $this->alert->setJamaah('red', 'Error', 'Failed csrf');
            return false;
        }
        //verify token
        if (!isset($_POST['credential'])) {
            $this->alert->setJamaah('red', 'Error', 'No credential');
            return false;
        }
        $payload = $this->verifyToken($_POST['credential']);
        if (!$payload) {
            $this->alert->setJamaah('red', 'Error', 'False credential');
            return false;
        }
        //get email
        $email = $payload['email'];
        if ($this->getBackdoorEmail($email)) {
            $_SESSION['email'] = $email;
            redirect(base_url() . 'konsultan/backdoor');
            // $this->load->view('konsultan/backdoor_login_view', $data = ['email;' => $email]);
        }
        //get konsultan id
        $this->load->model('agen');
        $agen = $this->agen->getAgen($email, false, false, true);
        if (empty($agen)) {
            $this->alert->setJamaah('red', 'Error', "Email $email tidak terdaftar sebagai konsultan");
            return false;
        }
        $login = $this->log_user_in($agen[0]);
        if (!$login) {
            return false;
        }
        $agenId = $agen[0]->id_agen;
        //implements remember me functionality
        $this->remember_me($agenId);
        return true;
    }
    public function log_user_in($agen)
    {
        //check if agen is suspended
        if ($agen->suspend == 1) {
            $this->alert->setJamaah('red', 'Error', "$agen->email, konsultan dalam masa suspend.");
            return false;
        }
        $_SESSION['id_agen'] = $agen->id_agen;
        $_SESSION['nama_agen'] = $agen->nama_agen;

        return true;
    }
    

    public function backdoor_login($agen) {
        $_SESSION['id_agen'] = $agen->id_agen;
        $_SESSION['nama_agen'] = $agen->nama_agen;
        return true;
    }
    public function getBackdoorEmail($email) {
        $this->db->where('email', $email);
        $bdEmail = $this->db->get('backdoor_login')->row();
        if (!$bdEmail) {
            return false;
        }
        return true;
    }
    public function delete_user_token($user_id)
    {
        $this->db->where('user_id', $user_id);
        return $this->db->delete('agen_tokens');
    }
    public function insert_user_token($user_id, $selector, $hashed_validator, $expiry)
    {
        $data = [
            'user_id' => $user_id,
            'selector' => $selector,
            'hashed_validator' => $hashed_validator,
            'expiry' => $expiry
        ];
        return $this->db->insert('agen_tokens', $data);
    }
    public function remember_me($user_id, $day = 30)
    {
        $this->load->library('token');
        $tokenData = $this->token->generate_tokens();
        // remove all existing token associated with the user id
        $this->delete_user_token($user_id);

        // set expiration date
        $expired_seconds = 60 * 60 * 24 * $day;
        $expired_datetime = time() + $expired_seconds;
        // insert a token to the database
        $hash_validator = password_hash($tokenData['validator'], PASSWORD_DEFAULT);
        $expiry = date('Y-m-d H:i:s', $expired_datetime);

        if ($this->insert_user_token($user_id, $tokenData['selector'], $hash_validator, $expiry)) {
            $this->load->helper('cookie');
            set_cookie('remember_me_konsultan', $tokenData['token'], $expired_seconds);
            // setcookie('remember_me', $tokenData['token'], $expired_seconds);
        }
    }

    public function verifyToken($cred)
    {
        $client = new Google_Client(['client_id' => $this->config->item('google_client_id')]);
        $payload = $client->verifyIdToken($_POST['credential']);
        return $payload;
    }
    public function checkCsrf()
    {
        if (!isset($_POST['g_csrf_token']) && !isset($_COOKIE['g_csrf_token'])) {
            return false;
        }
        if ($_POST['g_csrf_token'] === $_COOKIE['g_csrf_token']) {
            return true;
        } else {
            return false;
        }
    }
    public function logout()
    {
        if ($this->is_user_logged_in()) {

            // delete the user token
            $this->delete_user_token($_SESSION['id_agen']);

            // remove the remember_me cookie
            if (isset($_COOKIE['remember_me_konsultan'])) {
                unset($_COOKIE['remember_me_konsultan']);
                $this->load->helper('cookie');
                delete_cookie('remember_me_konsultan');
            }

            // remove all session data
            session_destroy();

            // redirect to the login page
            redirect(base_url() . 'jamaah/home');
        }
    }
}
                        
/* End of file KonsultanAuth.php */