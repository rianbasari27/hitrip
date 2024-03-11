<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Paket_layanan extends CI_Controller
{
    public function index()
    {        
        $this->load->view('jamaahv2/paket_layanan_view');
    }
    public function main_menu()
    {        
        $this->load->view('jamaahv2/include/menu-main');
    }
    public function colors()
    {        
        $this->load->view('jamaahv2/include/menu-colors');
    }
    public function share()
    {        
        $this->load->view('jamaahv2/include/menu-share');
    }
}