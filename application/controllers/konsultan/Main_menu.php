<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Main_menu extends CI_Controller
{

    public function index()
    {
        $this->load->model('agen');
        $agen = $this->agen->getAgen($_SESSION['id_agen']);
        $this->load->view('konsultan/include/menu-main',$agen[0]);
    }
    public function colors()
    {
        $this->load->view('konsultan/include/menu-colors');
    }
    public function share()
    {
        $this->load->view('konsultan/include/menu-share');
    }
}
        
    /* End of file  Main_menu.php */