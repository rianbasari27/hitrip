<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //check if logged in redirect to user page
        $this->load->model('customer');
        if (!$this->customer->is_user_logged_in()) {
            redirect(base_url() . 'jamaah/home');
        }
        $this->load->model('tarif');
        $tarif = $this->tarif->getRiwayatBayar($_SESSION['id_member']);
        //get basename
        $functionCall = basename($_SERVER['REQUEST_URI']);
        $exceptionFunctions = ['bayar_duitku', 'duitku_bayar_baru', 'proses_bayar_duitku'];
        if ($tarif['totalBayar'] <= 0 && !in_array($functionCall, $exceptionFunctions)) {
            redirect(base_url() . 'jamaah/daftar/dp_notice');
        }
    }

    public function index()
    {
        $this->load->model('tarif');
        $tarif = $this->tarif->getRiwayatBayar($_SESSION['id_member']);
        //jika sudah bayar redirect ke home
        if ($tarif['totalBayar'] > 0) {
            $this->load->view('jamaahv2/pembayaran_view');
        } else {
            $this->load->model('registrasi');
            $member = $this->registrasi->getMember($_SESSION['id_member']);
            $tarif['tarif']['countDown'] = date("M d, Y H:i:s", strtotime($member[0]->dp_expiry_time));
            $this->load->view('jamaahv2/bayar_dp', $tarif['tarif']);
        }
    }
    public function riwayat()
    {
        $idMember = $_SESSION['id_member'];
        $this->load->model('tarif');
        $data = $this->tarif->getRiwayatBayar($idMember);
        // echo '<pre>';
        // print_r($data);
        // exit();
        $this->load->view('jamaahv2/riwayat_bayar', $data);
    }
    public function bayar()
    {
        $this->load->model('tarif');
        $tarif = $this->tarif->getRiwayatBayar($_SESSION['id_member']);
        $this->load->view('jamaahv2/bayar_view', $tarif);
    }
    public function duitku_bayar_baru($metode)
    {
        if($metode == 'all') {
            $metode = null;
        }
        $this->load->model('tarif');
        $tarif = $this->tarif->getRiwayatBayar($_SESSION['id_member']);
        $tarif['metode'] = $metode;
        $this->load->view('jamaahv2/bayar_baru_duitku_view', $tarif);
    }
    public function proses_bayar_duitku()
    {
        $this->form_validation->set_rules('nominal', 'Nominal', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->model('duitku');
        $invoice = $this->duitku->createInvoice($_SESSION['id_member'], str_replace(",", "", $_POST['nominal']), null, 'bayar', $_POST['metode']);
        if (!$invoice) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        redirect($invoice['paymentUrl']);
    }
    public function bayar_duitku()
    {
        $this->load->model('tarif');
        $tarif = $this->tarif->getRiwayatBayar($_SESSION['id_member']);
        $this->load->model('duitku');
        $transPending = $this->duitku->getPendingTransaction($_SESSION['id_member']);
        $tarif['transPending'] = $transPending;
        $this->load->view('jamaahv2/bayar_duitku_view', $tarif);
    }
    public function metode()
    {
        $this->load->model('tarif');
        $tarif = $this->tarif->getRiwayatBayar($_SESSION['id_member']);
        $this->load->model('duitku');
        $transPending = $this->duitku->getPendingTransaction($_SESSION['id_member']);
        $tarif['transPending'] = $transPending;
        // echo '<pre>';
        // print_r($tarif['transPending']);
        // exit();
        $this->load->view('jamaahv2/metode_bayar_view', $tarif);
    }
}