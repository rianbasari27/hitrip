<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';
require 'vendor/autoload.php';

class Customer extends CI_Model
{
    

    public function checkSession()
    {
        if (isset($_SESSION['ktp_no'])) {
            return true;
        } else {
            return false;
        }
    }

    public function hash_password($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function registerUser($username, $nama, $email, $password, $no_wa) {
        $data = array(
            'username' => $username,
            'password' => $this->hash_password($password),
            'name' => $nama,
            'email' => $email,
            'no_wa' => $no_wa
        );
        return $this->db->insert('user', $data);
    }

    public function sendEmail($email) {
        $this->db->where('email', $email);
        $user = $this->db->get('user')->row();
        if (!$user) {
            $this->alert->setJamaah('red', 'Oops', 'Email tidak terdaftar!');
            return false;
        }
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'rianbasari27@gmail.com';
            $mail->Password   = 'tkhvsvcvsaebqpbn';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;            
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                    )
            );

            $mail->setFrom('rianbasari27@gmail.com', 'Admin Hi-Trip');
            $mail->addAddress($email, $user->name);
            
            $mail->isHTML(true);
            $link = base_url("jamaah/login/reset_password?mail=$email");
            $mail->Subject = 'Reset My Password';
            $mail->Body    = "Klik link berikut untuk reset Password, <a href='$link'>Klik untuk reset Password<a>";


            $mail->send();
            return true;
        } catch (Exception $e) {
            echo '<pre>';
            print_r($e);
            exit();
            return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    // public function sendMail($email) {
    //     $this->db->where('email', $email);
    //     $user = $this->db->get('user')->row();
    //     if($user) {
    //         //$link="<a href='localhost:8080/phpmailer/reset_pass.php?key=".$email."&reset=".$pass."'>Click To Reset password</a>";
    //         require_once APPPATH . 'third_party/phpmail/class.phpmailer.php';
    //         require_once APPPATH . 'third_party/phpmail/class.smtp.php';
    //         $mail = new PHPMailer();
    //         $link = base_url("jamaah/login/reset_password?mail=$email");
    //         $body = "Klik link berikut untuk reset Password, <a href='$link'>Klik untuk reset Password<a>"; //isi dari email
    //         // $mail->CharSet =  "utf-8";
    //         $mail->IsSMTP();
    //         // enable SMTP authentication
    //         $mail->SMTPDebug  = 1;
    //         $mail->SMTPAuth = true;                  
    //         // GMAIL username
    //         $mail->Username = "rianbasari27@gmail.com";
    //         // GMAIL password
    //         $mail->Password = "zwbzqlcibdrmifmd";
    //         $mail->SMTPSecure = "ssl";  
    //         // sets GMAIL as the SMTP server
    //         $mail->Host = "smtp.gmail.com";
    //         // set the SMTP port for the GMAIL server
    //         $mail->Port = "465";
    //         $mail->From='rianbasari27@gmail.com';
    //         $mail->FromName='Admin Hi Trip';
            
    //         $mail->AddAddress($email, 'User Sistem');
    //         $mail->Subject  =  'Reset Password';
    //         $mail->IsHTML(true);
    //         $mail->MsgHTML($body);
    //         if($mail->Send()) {
    //             return true;
    //         } else
    //         {
    //           return $mail->ErrorInfo;
    //         }
    //     }
    //     else {
    //         return false; 
    //     }
    // }

    public function resetPassword($email, $password) {
        $password = $this->hash_password($password);

        $this->db->where('email', $email);
        $this->db->set('password', $password);
        if (!$this->db->update('user')) {
            return false ;
        }

        return true;
    }


    public function verifyLoginUser($username, $password) {

        $user = $this->log_user_in(['user_id' => $username]);
        if (!$user) {
            $data = [
                'type' => 'red',
                'title' => 'Mohon Maaf',
                'message' => 'Username belum terdaftar',
            ];
            return $data;
        }
        //verify login
        if (password_verify($password, $user->password)) {
            $this->remember_me($username);
            $data = [
                'type' => 'green',
                'title' => 'Selamat',
                'message' => 'Anda berhasil masuk',
            ];
            return $data;
        } else {
            $data = [
                'type' => 'red',
                'title' => 'Mohon Maaf',
                'message' => 'Password anda salah',
            ];
            return $data;
        }
    }

    public function login($ktp_no)
    {
        $this->load->model('registrasi');
        $result = $this->registrasi->getJamaah(null, $ktp_no);
        if (empty($result)) {
            $this->alert->set('danger', 'Nomor KTP Tidak Terdaftar');
            $this->alert->setJamaah('red', 'Ups...', 'Nomor KTP Tidak Terdaftar.');
            return false;
        }
        if (empty($result->member)) {
            $this->alert->set('danger', 'Jamaah tidak terdaftar pada program');
            $this->alert->setJamaah('red', 'Ups...', 'Jamaah tidak terdaftar pada program');
            return false;
        }
        if (!$this->log_user_in(['user_id' => $ktp_no])) {
            $this->alert->set('danger', 'Jamaah tidak terdaftar pada program');
            $this->alert->setJamaah('red', 'Ups...', 'Jamaah tidak terdaftar pada program yang sedang aktif.');
            return false;
        }
        //implements remember me functionality
        $this->remember_me($ktp_no);
        return true;
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
            set_cookie('remember_me', $tokenData['token'], $expired_seconds);
            // set_cookie('remember_me', $tokenData['token'], $expired_seconds, base_url(), '/');
            // setcookie('remember_me', $tokenData['token'], $expired_seconds);
        }
    }
    public function logout()
    {
        if ($this->is_user_logged_in()) {

            // delete the user token
            $this->delete_user_token($_SESSION['username']);

            // remove the remember_me cookie
            if (isset($_COOKIE['remember_me'])) {
                unset($_COOKIE['remember_me']);
                $this->load->helper('cookie');
                delete_cookie('remember_me');
            }

            // remove all session data
        }
        session_destroy();
    }
    public function is_user_logged_in()
    {
        // check the session
        if (isset($_SESSION['username'])) {
            return true;
        }

        // check the remember_me in cookie
        if (isset($_COOKIE['remember_me'])) {
            $token = htmlspecialchars($_COOKIE['remember_me']);
            if ($token && $this->token_is_valid($token)) {
                $user = $this->find_user_by_token($token);

                if ($user) {
                    return $this->log_user_in($user);
                }
            }
        }
        return false;
    }
    public function setSession($ktp_no)
    {
        // prevent session fixation attack
        // session_destroy();
        // KEIKUTSERTAAN DALAM PAKET, Hanya ambil data paket yg belum lewat tanggalnya saja

        $this->load->model('registrasi');

        $result = $this->registrasi->getJamaah(null, $ktp_no);
        $idMember = null;
        $paket = [];
        $family = [];
        if (!empty($result->member)) {
            $member = $result->member[0];
            $curDate = date('Y-m-d');
            $paketDate = $member->paket_info->tanggal_pulang;
            if ($curDate <= $paketDate) {
                // maka paket masih berlaku
                $idMember = $member->id_member;
                $paket = (array) $member->paket_info;
            }
            $family = $this->registrasi->getGroupMembers($member->parent_id);
        }
        $this->session->set_userdata(array(
            'id_user' => $result->id_user,
            'email' => $result->email,
            'name' => $result->name,
            // 'id_member' => $idMember,
            // 'paket' => $paket,
            // 'ktp_no' => $ktp_no,
            // 'first_name' => $result->first_name,
            // 'second_name' => $result->second_name,
            // 'last_name' => $result->last_name,
            // 'family' => $family,
        ));
        return $result;
    }
    public function log_user_in($user)
    {
        // prevent session fixation attack
        $this->session->sess_regenerate(true);
        // KEIKUTSERTAAN DALAM PAKET, Hanya ambil data paket yg belum lewat tanggalnya saja

        $this->load->model('registrasi');
        $result = $this->registrasi->getUser(null, $user['user_id']);
        // $idMember = null;
        // $paket = [];
        // $family = [];
        // if (empty($result->member)) {
        //     return false;
        // }
        // $member = $result->member[0];
        // $curDate = date('Y-m-d');
        // $paketDate = $member->paket_info->tanggal_pulang;
        // if ($curDate <= $paketDate) {
        //     // maka paket masih berlaku
        //     $idMember = $member->id_member;
        //     $paket = (array) $member->paket_info;
        // } else {
        //     return false;
        // }
        // $family = $this->registrasi->getGroupMembers($member->parent_id);

        $this->session->set_userdata(array(
            'username' => $result->username,
            'email' => $result->email,
            'name' => $result->name,
            // 'id_member' => $idMember,
            // 'paket' => $paket,
            // 'ktp_no' => $user['user_id'],
            // 'first_name' => $result->first_name,
            // 'second_name' => $result->second_name,
            // 'last_name' => $result->last_name,
            // 'family' => $family,
        ));
        return $result;
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

    public function checkAuthId($id_member)
    {
        $loggedIdMember = $_SESSION['id_member'];
        if ($loggedIdMember == $id_member) {
            return true;
        }
        $this->load->model('registrasi');
        $member = $this->registrasi->getMember($id_member);
        if (empty($member)) {
            $this->alert->set('danger', 'Forbidden');
            return false;
        }
        $member = $member[0];
        if ($member->parent_id == $loggedIdMember) {
            return true;
        } else {
            $this->alert->set('danger', 'Forbidden');
            return false;
        }
        echo '<pre>';
        print_r($member);
        echo exit();
    }



    public function insert_user_token($user_id, $selector, $hashed_validator, $expiry)
    {
        $data = [
            'user_id' => $user_id,
            'selector' => $selector,
            'hashed_validator' => $hashed_validator,
            'expiry' => $expiry
        ];
        return $this->db->insert('user_tokens', $data);
    }
    public function find_user_token_by_selector($selector)
    {
        $this->db->where('selector', $selector);
        $this->db->where('expiry >= now()');
        return $this->db->get('user_tokens')->row_array();
    }
    public function delete_user_token($user_id)
    {
        $this->db->where('user_id', $user_id);
        return $this->db->delete('user_tokens');
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
        return $this->db->get('user_tokens')->row_array();
    }
    public function isSplashSeen()
    {
        if (isset($_COOKIE['splash_seen'])) {
            //extend expiry time
            $this->setSplashSeen();
            return true;
        } else {
            return false;
        }
    }
    public function setSplashSeen()
    {
        $this->load->helper('cookie');
        set_cookie('splash_seen', '1', (30 * 24 * 60 * 60));
    }

    public function setAds()
    {
        $this->load->helper('cookie');
        set_cookie('ads', '1', (3 * 60 * 60));
    }
    
    public function isAdsSeen()
    {
        if (isset($_COOKIE['ads'])) {
            //extend expiry time
            $this->setAds();
            return true;
        } else {
            return false;
        }
    }

    public function getStatus($member)
    {
        if ($member->lunas == 0) {
            $DPStatus = true;
        } else {
            $DPStatus = false;
        }

        if ($member->lunas == 1 || $DPStatus == true) {
            $lunasStatus = false;
        } else {
            $lunasStatus = true;
        }

        $this->load->model('tarif');
        $bayar = $this->tarif->getPembayaran($member->id_member);
        $unconfirmedPay = false;
        foreach ($bayar['data'] as $byr) {
            if ($byr->verified != 2) {
                $unconfirmedPay = true;
                break;
            }
        }
        if ($member->verified != 1 && $unconfirmedPay == true) {
            $dataStatus = true;
        } else {
            $dataStatus = false;
        }

        if ($unconfirmedPay == true) {
            $displayBroadcast = true;
        } else {
            $displayBroadcast = false;
        }

        $result = array(
            'DPStatus' => $DPStatus,
            'dataStatus' => $dataStatus,
            'lunasStatus' => $lunasStatus,
            'displayBroadcast' => $displayBroadcast
        );
        return $result;
    }

    public function valid($id_member, $valid)
    {
        $this->db->where('id_member', $id_member);
        $this->db->set('valid', $valid);
        $query = $this->db->update('program_member');
        if ($query == true) {
            $this->load->model('logs');
            $this->logs->addLog('pm', $id_member);
            return true;
        } else {
            return false;
        }
    }
}