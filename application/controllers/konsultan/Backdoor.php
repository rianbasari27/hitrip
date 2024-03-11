<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Backdoor extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('agen');
        $this->load->model('konsultanAuth');
        if (!isset($_SESSION['email'])) {
            redirect(base_url() . 'konsultan/home');
        }
    }

    public function index() {
        $this->load->view('konsultan/backdoor_login_view');
    }

    public function login_proses() {
        $id = $_POST['id_agen'];
        $agen = $this->agen->getAgen($id);
        if ($agen == null) {
            $this->alert->setJamaah('red', 'Oops!', 'Konsultan tidak terdaftar.');
            redirect(base_url() . 'konsultan/backdoor');
        }
        $login = $this->konsultanAuth->backdoor_login($agen[0]);
        if (!$login) {
            return false;
        } else {
            redirect(base_url() . 'konsultan/home');
        }
        
    }

    public function show_ip() {

    }
}