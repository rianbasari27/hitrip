<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Voucher extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("auth");
        $this->load->library("secret_key");
        $this->load->model('konsultanAuth');
        if (!$this->konsultanAuth->is_user_logged_in()) {
            redirect(base_url() . 'konsultan/login');
        }
    }

    public function index()
    {
        $this->load->view('konsultan/voucher_view');
    }

    public function proses()
    {
        if (!isset($_POST['kode_voucher'])) {
            redirect(base_url() . 'konsultan/voucher');
        }
        $kodeVoucher = $_POST['kode_voucher'];
        $this->load->model('voucherModel');
        $apply = $this->voucherModel->applyVoucher($kodeVoucher, $_SESSION['id_member']);
        $this->load->view('konsultan/voucher_view', $apply);
    }
}