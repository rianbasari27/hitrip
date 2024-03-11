<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Store extends CI_Controller
{
    public function index() {
        $this->load->view('staff/list_produk_view');
    }

    public function tambah() {
        if (!($_SESSION['bagian'] == 'Master Admin')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->load->view('staff/add_product_view');
    }
}