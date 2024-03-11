<?php

class Login_lib {

    protected $CI;

    // We'll use a constructor, as you can't directly call a function
    // from a property definition.
    public function __construct() {
        // Assign the CodeIgniter super-object
        $this->CI = & get_instance();
    }

    public function hash_password($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function registerUser($email, $nama, $bagian, $password) {
        $data = array(
            'email' => $email,
            'password' => $this->hash_password($password),
            'nama' => $nama,
            'bagian' => $bagian
        );
        return $this->CI->db->insert('staff', $data);
    }

    public function verifyLogin($email, $password) {
        //get email from db
        $data = $this->CI->db->get_where('staff', array('email' => $email));
        $result = $data->result();

        if (empty($result)) {
            return false;
        }
        $user = $result[0];
        //verify login
        if (password_verify($password, $user->password)) {
            return true;
        } else {
            return false;
        }
    }

    public function setSession($email) {
        $data = $this->CI->db->get_where('staff', array('email' => $email));
        $result = $data->result_array();
        $filteredResult = $result[0];
        unset($filteredResult['password']);
        $filteredResult['login'] = true;
        $this->CI->session->set_userdata($filteredResult);
    }

    public function refreshSession() {
        $email = $_SESSION['email'];
        $data = $this->CI->db->get_where('staff', array('email' => $email));
        $result = $data->result_array();
        $filteredResult = $result[0];
        unset($filteredResult['password']);
        $filteredResult['login'] = true;
        $this->CI->session->set_userdata($filteredResult);
    }

    public function checkSession() {
        if (isset($_SESSION['login']) && $_SESSION['login'] && isset($_SESSION['id_staff'])) {
            return true;
        } else {
            return false;
        }
    }

}