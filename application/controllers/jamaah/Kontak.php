<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Kontak extends CI_Controller
{
    public function index()
    {
        $arr = [];
        for ($i = 0 ; $i < 7 ; $i++) {
            $arr[$i] = [
                'days' => date('l', strtotime("+$i days"))
            ];
        }
        $this->load->view('jamaahv2/kontak_kami', $data = ['arr' => $arr]);
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