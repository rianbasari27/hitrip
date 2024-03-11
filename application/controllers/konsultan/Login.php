<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('konsultanAuth');
        if ($this->konsultanAuth->is_user_logged_in()) {
            redirect(base_url() . 'konsultan/home');
        }
    }

    public function index()
    {
        // header("Content-Security-Policy: connect-src frame-src script-src style-src unsafe-inline ");
        header("Cross-Origin-Opener-Policy: same-origin-allow-popups");
        // header("Set-Cookie: SameSite=None; Secure");
        $this->load->view('konsultan/login_view');
    }
    public function proses()
    {
        if (!isset($_POST['clientId']) && !isset($_POST['g_csrf_token'])) {
            redirect(base_url() . 'konsultan/login');
        }
        $this->load->model('konsultanAuth');
        $login = $this->konsultanAuth->login();
        if (!$login) {
            redirect(base_url() . 'konsultan/login');
        } else {
            redirect(base_url() . 'konsultan/home');
        }
    }
}
        
    /* End of file  Login.php */
