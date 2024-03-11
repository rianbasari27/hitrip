<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Riwayat_bayar extends CI_Controller
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
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->setJamaah('red', 'Error!', 'Access Denied');
            redirect(base_url() . 'konsultan/home');
            return false;
        }
        $id_member = $this->secret_key->validate($_GET['id']);
        if (!$id_member) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url().'konsultan/home');
        }
        $check = $this->auth->checkMemberAgen($_SESSION['id_agen'], $id_member);
        if (!$check) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url().'konsultan/home');
        }
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->setJamaah('red', 'Error!', 'Access Denied');
            redirect(base_url() . 'konsultan/home');
            return false;
        }
        $id_member = $this->secret_key->validate($_GET['id']);
        if (!$id_member) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url().'konsultan/home');
        }
        $check = $this->auth->checkMemberAgen($_SESSION['id_agen'], $id_member);
        if (!$check) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url().'konsultan/home');
        }
        $this->load->model('tarif');
        $tarif = $this->tarif->getRiwayatBayar($_GET['id']);
        //jika sudah bayar redirect ke home
        if ($tarif['totalBayar'] > 0) {
            $this->load->view('konsultan/pembayaran_view', $tarif['tarif']);
        } else {
            $this->load->model('registrasi');
            $member = $this->registrasi->getMember($_GET['id']);
            $tarif['tarif']['countDown'] = date("M d, Y H:i:s", strtotime($member[0]->dp_expiry_time));
            $this->load->view('konsultan/bayar_dp', $tarif['tarif']);
        }
    }

    public function riwayat()
    {
        $idMember = $this->secret_key->validate($_GET['id']);
        if (!$idMember) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url().'konsultan/home');
        }
        $this->load->model('tarif');
        $data = $this->tarif->getRiwayatBayar($idMember);
        // echo '<pre>';
        // print_r($data);
        // exit();
        $this->load->view('konsultan/riwayat_bayar', $data);
    }

    public function bayar()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied');
            redirect(base_url() . 'konsultan/home');
            return false;
        }
        $id_member = $this->secret_key->validate($_GET['id']);
        if (!$id_member) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url().'konsultan/home');
        }
        $check = $this->auth->checkMemberAgen($_SESSION['id_agen'], $id_member);
        if (!$check) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url().'konsultan/home');
        }

        $this->load->model('tarif');
        $tarif = $this->tarif->getRiwayatBayar($_GET['id']);
        $this->load->view('konsultan/bayar_view', $tarif);
    }
    public function duitku_bayar_baru()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied');
            redirect(base_url() . 'konsultan/home');
            return false;
        }
        $id_member = $this->secret_key->validate($_GET['id']);
        if (!$id_member) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url().'konsultan/home');
        }
        $check = $this->auth->checkMemberAgen($_SESSION['id_agen'], $id_member);
        if (!$check) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url().'konsultan/home');
        }

        $this->load->model('tarif');
        $tarif = $this->tarif->getRiwayatBayar($id_member);
        $tarif['metode'] = $_GET['metode'];
        $this->load->view('konsultan/bayar_baru_duitku_view', $tarif);
    }
    
    public function proses_bayar_duitku()
    {
        $this->form_validation->set_rules('nominal', 'Nominal', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }
        
        $this->load->model('duitku');
        $invoice = $this->duitku->createInvoice($_GET['id'], str_replace(",", "", $_POST['nominal']), null, 'bayar', $_POST['metode']);
        if (!$invoice) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        redirect($invoice['paymentUrl']);
    }
    public function bayar_duitku()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied');
            redirect(base_url() . 'konsultan/home');
            return false;
        }
        $id_member = $this->secret_key->validate($_GET['id']);
        if (!$id_member) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url().'konsultan/home');
        }
        $check = $this->auth->checkMemberAgen($_SESSION['id_agen'], $id_member);
        if (!$check) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url().'konsultan/home');
        }
        
        $this->load->model('tarif');
        $tarif = $this->tarif->getRiwayatBayar($id_member);
        $this->load->model('duitku');
        $transPending = $this->duitku->getPendingTransaction($id_member);
        $tarif['transPending'] = $transPending;
        $this->load->view('konsultan/bayar_duitku_view', $tarif);
    }
    public function metode()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied');
            redirect(base_url() . 'konsultan/home');
            return false;
        }
        $id_member = $this->secret_key->validate($_GET['id']);
        if (!$id_member) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url().'konsultan/home');
        }
        $check = $this->auth->checkMemberAgen($_SESSION['id_agen'], $id_member);
        if (!$check) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url().'konsultan/home');
        }

        $this->load->model('tarif');
        $tarif = $this->tarif->getRiwayatBayar($id_member);
        $tarif['idSecretMember'] = $_GET['id'];
        $this->load->view('konsultan/metode_bayar_view', $tarif);
    }
}