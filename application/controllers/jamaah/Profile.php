<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{    
    public function index()
    {        
        $this->load->view('jamaahv2/profile_view');
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