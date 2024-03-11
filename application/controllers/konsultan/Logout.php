<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Logout extends CI_Controller
{

    public function index()
    {

        $this->load->model('konsultanAuth');
        $this->konsultanAuth->logout();
        redirect(base_url() . 'jamaah/home');
    }
}
