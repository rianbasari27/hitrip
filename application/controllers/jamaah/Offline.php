<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Offline extends CI_Controller
{

    public function index()
    {
        $this->load->view('jamaahv2/offline_view');
    }
}
