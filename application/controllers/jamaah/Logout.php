<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Logout extends CI_Controller
{

    public function index()
    {

        $this->load->model('customer');
        $this->customer->logout();
        $this->alert->setJamaah('green', 'Selamat', 'Anda berhasil Logout :)');
        redirect(base_url() . 'jamaah/home');
    }
}
        
    /* End of file  jamaah/Logout.php */
