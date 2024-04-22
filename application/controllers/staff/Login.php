<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('login_lib');
        if($this->login_lib->checkSession() == true){
            redirect(base_url().'staff/dashboard');
        }
    }

    public function index() {
        $this->load->view('staff/login_view');
    }

    public function login_process() {
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('pass', 'Password', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            redirect(base_url() . 'staff/login');
            return 0;
        }
        $email = $_POST['email'];
        $password = $_POST['pass'];
        $this->load->library('login_lib');
        $result = $this->login_lib->verifyLogin($email, $password);
        if($result){
            $sess = $this->login_lib->setSession($email);
            redirect(base_url() . 'staff/dashboard');
        
        }else{
            $this->session->set_flashdata('error', 'Email atau Password Salah');
            redirect(base_url() . 'staff/login');
        
        }
    
        
    }


    public function register_master() {
        $this->load->library('login_lib');
        $email = 'master@hitrip.co.id';
        $password = 'masterhitrip';
        $nama = 'Master Admin';
        $bagian = 'Master Admin';
        $this->login_lib->registerUser($email, $nama, $bagian, $password);
    }

}