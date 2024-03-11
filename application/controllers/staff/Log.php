<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }

        //this page only for admin
        if (!($_SESSION['bagian'] == 'Master Admin')) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/dashboard');
        }
    }

    public function index() {
        //tbl id : s = staff
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('tbl', 'tbl', 'trim|required|alpha_numeric');
        $this->form_validation->set_rules('id', 'id', 'trim|required|alpha_numeric');
        
        $this->load->model('logs');
        
        $data = $this->logs->logView($_GET['tbl'], $_GET['id']);
        // echo '<pre>';
        // print_r($data);
        // exit();

        $this->load->view('staff/log_view',$data);
    
    }

    public function detail()  {
        if (!($_SESSION['bagian'] == 'Master Admin')) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id_log', 'id_log', 'trim|required|alpha_numeric');

        $this->load->model('logs');
        $data = $this->logs->tableLogView($_GET['id_log']);

        $this->load->view('staff/detail_log_view',$data);
    }

}