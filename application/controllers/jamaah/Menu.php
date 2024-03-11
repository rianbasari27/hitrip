<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{

    public function main_menu()
    {
        $this->load->view('jamaah/include/menu-main');
        
    }
    public function colors()
    {
        $this->load->view('jamaah/include/menu-colors');
    }
    public function share()
    {
        $this->load->view('jamaah/include/menu-share');
    }
}
        
    /* End of file  Jamaah/Menu.php */
