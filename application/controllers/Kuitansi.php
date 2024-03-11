<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Kuitansi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('customer');
        $this->load->model('registrasi');
        if ($this->customer->checkSession() == false) {
            redirect(base_url() . 'login');
        }
    }

    public function index()
    {
        $id_member = null;
        if (isset($_GET['id'])) {
            $id_member = $_GET['id'];
        }
        if ($id_member == null) {
            $id_member = $_SESSION['id_member'];
        }
        $auth = $this->customer->checkAuthId($id_member);
            redirect(base_url() . 'home');
        
        $member = $this->registrasi->getMember($id_member);
        $member = $member[0];
        $jamaah = $this->registrasi->getJamaah($member->id_jamaah);
        if (empty($jamaah)) {
            $this->alert->set('danger', 'Data Tidak Ditemukan');
            redirect(base_url() . 'home');
        }
        $status = $this->customer->getStatus($member);
        $DPStatus = $status['DPStatus'];
        if ($DPStatus == true) {
            $this->alert->set('danger', 'Forbidden Access');
            redirect(base_url() . 'home');
        }

        $this->load->model('tarif');
        $pays = $this->tarif->getPembayaran($member->id_member, 1);
        $data = array(
            'memberData' => $member,
            'jamaahData' => $jamaah,
            'pays' => $pays
        );
        $this->load->view('jamaah/list_bayar', $data);
    }

    // public function download()
    // {
    //     $this->form_validation->set_data($this->input->get());
    //     $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
    //     if ($this->form_validation->run() == FALSE) {
    //         $this->alert->set('danger', 'Access Denied');
    //         redirect(base_url() . 'home');
    //     }

    //     $this->load->model('tarif');
    //     $data = $this->tarif->getKuitansiData($_GET['id']);
    //     $data['id'] = $_GET['id'];
    //     $html = $this->load->view('jamaah/kuitansi_html_view', $data, true);
    //     $data['html'] = $html;

    //     $this->load->view('jamaah/kuitansi_direct_view', $data);
    // }
    // public function download_html(){
    //     $this->form_validation->set_data($this->input->get());
    //     $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
    //     if ($this->form_validation->run() == FALSE) {
    //         $this->alert->set('danger', 'Access Denied');
    //         redirect(base_url() . 'home');
    //     }
    //     $this->load->model('tarif');
    //     $data = $this->tarif->getKuitansiData($_GET['id']);
    //     $this->load->view('jamaah/kuitansi_html_view', $data);

    // }

}
