<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Voucher extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //check if logged in redirect to user page
        $this->load->model('customer');
        if (!$this->customer->is_user_logged_in()) {
            redirect(base_url() . 'jamaah/home');
        }
    }

    public function index()
    {
        $this->load->view('jamaahv2/voucher_view');
    }

    public function proses()
    {
        if (!isset($_POST['kode_voucher'])) {
            redirect(base_url() . 'jamaah/voucher');
        }
        $kodeVoucher = $_POST['kode_voucher'];
        $this->load->model('voucherModel');
        $apply = $this->voucherModel->applyVoucher($kodeVoucher, $_SESSION['id_member']);
        $this->load->view('jamaahv2/voucher_view', $apply);
    }
}
