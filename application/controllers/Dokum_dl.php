<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dokum_dl extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("auth");
        $this->load->library("secret_key");
    }

    public function download()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('idr', 'idr', 'trim|required|integer');
        $this->form_validation->set_rules('idm', 'idm', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/request_dokumen');
        }
        $this->load->model('tarif');
        $data = $this->tarif->getRequestData($_GET['idr']);
        $this->load->library('date');
        $tgl_berangkat = $this->date->convert_date_indo($data['tanggal_berangkat']);
        $tgl_plg = $this->date->convert_date_indo($data['tanggal_pulang']);
        $tgl_now = $this->date->convert_date_indo(date('Y-m-d'));
        $tahun = date('Y');
        $bulan = $this->date->convert_romawi(date('m', strtotime($data['tgl_request'])));
        $data['tanggal_berangkat'] = $tgl_berangkat ;
        $data['tanggal_pulang'] = $tgl_plg ;
        $data['tanggal_now'] = $tgl_now ;
        $data['bulan'] = $bulan ;
        $data['tahun'] = $tahun ;
        $data['id'] = $_GET['idm'];
        $data['html'] = $this->load->view('staff/dokumen_html_view', $data, true);
        $data['imi'] = $this->load->view('staff/req_imigrasi', $data, true);
        $this->load->view('staff/dokum_view', $data);
    }

    public function download_kemenag()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('idr', 'idr', 'trim|required|integer');
        $this->form_validation->set_rules('idm', 'idm', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/request_dokumen');
        }
        $this->load->model('tarif');
        $data = $this->tarif->getRequestData($_GET['idr']);
        $this->load->library('date');
        $tgl_berangkat = $this->date->convert_date_indo($data['tanggal_berangkat']);
        $tgl_plg = $this->date->convert_date_indo($data['tanggal_pulang']);
        $tgl_now = $this->date->convert_date_indo(date('Y-m-d'));
        $tahun = date('Y');
        $bulan = $this->date->convert_romawi(date('m', strtotime($data['tgl_request'])));
        $data['tanggal_berangkat'] = $tgl_berangkat ;
        $data['tanggal_pulang'] = $tgl_plg ;
        $data['tanggal_now'] = $tgl_now ;
        $data['tahun'] = $tahun ;
        $data['bulan'] = $bulan ;
        $data['id'] = $_GET['idm'];
        $data['html'] = $this->load->view('staff/dokumen_html_view1', $data, true);
        $data['kemenag'] = $this->load->view('staff/req_kemenag', $data, true);
        $this->load->view('staff/kemenag_view', $data);
    }

    public function download_agen() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('idr', 'idr', 'trim|required');
        $this->form_validation->set_rules('idm', 'idm', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'konsultan/home');
        }
        $id_member = $this->secret_key->validate($_GET['idm']);
        $id_request = $this->secret_key->validate($_GET['idr']);
        if (!$id_member) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url().'konsultan/home');
        }
        $check = $this->auth->checkMemberAgen($_SESSION['id_agen'], $id_member);
        if (!$check) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url().'konsultan/home');
        }
        $checkRequest = $this->auth->checkRequest($id_member, $id_request);
        if (!$checkRequest) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url().'konsultan/home');
        }
        
        $this->load->model('tarif');
        $data = $this->tarif->getRequestData($id_request);
        $this->load->library('date');
        $tgl_berangkat = $this->date->convert_date_indo($data['tanggal_berangkat']);
        $tgl_plg = $this->date->convert_date_indo($data['tanggal_pulang']);
        $tgl_now = $this->date->convert_date_indo(date('Y-m-d'));
        $tahun = date('Y');
        $bulan = $this->date->convert_romawi(date('m', strtotime($data['tgl_request'])));
        $data['tanggal_berangkat'] = $tgl_berangkat ;
        $data['tanggal_pulang'] = $tgl_plg ;
        $data['tanggal_now'] = $tgl_now ;
        $data['bulan'] = $bulan ;
        $data['tahun'] = $tahun ;
        $data['id'] = $_GET['idm'];
        $data['html'] = $this->load->view('staff/dokumen_html_view', $data, true);
        $data['imi'] = $this->load->view('staff/req_imigrasi', $data, true);
        $this->load->view('staff/dokum_view', $data);
    }
    
    public function kemenag_agen()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('idr', 'idr', 'trim|required');
        $this->form_validation->set_rules('idm', 'idm', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Oops...', 'Access Denied');
            redirect(base_url() . 'konsultan/home');
        }

        $id_member = $this->secret_key->validate($_GET['idm']);
        $id_request = $this->secret_key->validate($_GET['idr']);
        if (!$id_member) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url().'konsultan/home');
        }
        $check = $this->auth->checkMemberAgen($_SESSION['id_agen'], $id_member);
        if (!$check) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url().'konsultan/home');
        }
        $checkRequest = $this->auth->checkRequest($id_member, $id_request);
        if (!$checkRequest) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url().'konsultan/home');
        }

        $this->load->model('tarif');
        $data = $this->tarif->getRequestData($id_request);
        $this->load->library('date');
        $tgl_berangkat = $this->date->convert_date_indo($data['tanggal_berangkat']);
        $tgl_plg = $this->date->convert_date_indo($data['tanggal_pulang']);
        $tgl_now = $this->date->convert_date_indo(date('Y-m-d'));
        $tahun = date('Y');
        $bulan = $this->date->convert_romawi(date('m', strtotime($data['tgl_request'])));
        $data['tanggal_berangkat'] = $tgl_berangkat ;
        $data['tanggal_pulang'] = $tgl_plg ;
        $data['tanggal_now'] = $tgl_now ;
        $data['bulan'] = $bulan ;
        $data['tahun'] = $tahun ;
        $data['id'] = $_GET['idm'];
        $data['html'] = $this->load->view('staff/dokumen_html_view1', $data, true);
        $data['kemenag'] = $this->load->view('staff/req_kemenag', $data, true);
        $this->load->view('staff/kemenag_view', $data);
    }

    public function download_jamaah_imigrasi() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('idr', 'idr', 'trim|required');
        $this->form_validation->set_rules('idm', 'idm', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger','Oops..', 'Access Denied');
            redirect(base_url() . 'jamaah/home_user');
        }
        // validate id_member
        $id_member = $this->secret_key->validate($_GET['idm']);
        if (!$id_member) {
            $this->alert->setJamaah('red', 'Oops..', 'Access Denied!');
            redirect(base_url().'jamaah/home_user');
        }

        // validate id_request
        $id_request = $this->secret_key->validate($_GET['idr']);
        if (!$id_request) {
            $this->alert->setJamaah('red', 'Oops..', 'Access Denied!');
            redirect(base_url().'jamaah/home_user');
        }

        // check id_member
        $check = $this->auth->checkMember($_SESSION['id_member'], $id_member);
        if (!$check) {
            $this->alert->setJamaah('red', 'Oops..', 'Access Denied!');
            redirect(base_url().'jamaah/home_user');
        }

        //check id_request
        $checkRequest = $this->auth->checkRequest($id_member, $id_request);
        if (!$checkRequest) {
            $this->alert->setJamaah('red', 'Oops..', 'Access Denied!');
            redirect(base_url().'jamaah/home_user');
        }
        
        $this->load->model('tarif');
        $data = $this->tarif->getRequestData($id_request);
        $this->load->library('date');
        $tgl_berangkat = $this->date->convert_date_indo($data['tanggal_berangkat']);
        $tgl_plg = $this->date->convert_date_indo($data['tanggal_pulang']);
        $tgl_now = $this->date->convert_date_indo(date('Y-m-d'));
        $tahun = date('Y');
        $bulan = $this->date->convert_romawi(date('m', strtotime($data['tgl_request'])));
        $data['tanggal_berangkat'] = $tgl_berangkat ;
        $data['tanggal_pulang'] = $tgl_plg ;
        $data['tanggal_now'] = $tgl_now ;
        $data['bulan'] = $bulan ;
        $data['tahun'] = $tahun ;
        $data['id'] = $_GET['idm'];
        $data['html'] = $this->load->view('staff/dokumen_html_view', $data, true);
        $data['imi'] = $this->load->view('staff/req_imigrasi', $data, true);
        $this->load->view('staff/dokum_view', $data);
    }

    public function download_jamaah_kemenag()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('idr', 'idr', 'trim|required');
        $this->form_validation->set_rules('idm', 'idm', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger','Oops..', 'Access Denied');
            redirect(base_url() . 'jamaah/home_user');
        }
        // validate id_member
        $id_member = $this->secret_key->validate($_GET['idm']);
        if (!$id_member) {
            $this->alert->setJamaah('red', 'Oops..', 'Access Denied!');
            redirect(base_url().'jamaah/home_user');
        }

        // validate id_request
        $id_request = $this->secret_key->validate($_GET['idr']);
        if (!$id_request) {
            $this->alert->setJamaah('red', 'Oops..', 'Access Denied!');
            redirect(base_url().'jamaah/home_user');
        }

        // check id_member
        $check = $this->auth->checkMember($_SESSION['id_member'], $id_member);
        if (!$check) {
            $this->alert->setJamaah('red', 'Oops..', 'Access Denied!');
            redirect(base_url().'jamaah/home_user');
        }

        //check id_request
        $checkRequest = $this->auth->checkRequest($id_member, $id_request);
        if (!$checkRequest) {
            $this->alert->setJamaah('red', 'Oops..', 'Access Denied!');
            redirect(base_url().'jamaah/home_user');
        }

        $this->load->model('tarif');
        $data = $this->tarif->getRequestData($id_request);
        $this->load->library('date');
        $tgl_berangkat = $this->date->convert_date_indo($data['tanggal_berangkat']);
        $tgl_plg = $this->date->convert_date_indo($data['tanggal_pulang']);
        $tgl_now = $this->date->convert_date_indo(date('Y-m-d'));
        $tahun = date('Y');
        $bulan = $this->date->convert_romawi(date('m', strtotime($data['tgl_request'])));
        $data['tanggal_berangkat'] = $tgl_berangkat ;
        $data['tanggal_pulang'] = $tgl_plg ;
        $data['tanggal_now'] = $tgl_now ;
        $data['bulan'] = $bulan ;
        $data['tahun'] = $tahun ;
        $data['id'] = $_GET['idm'];
        $data['html'] = $this->load->view('staff/dokumen_html_view1', $data, true);
        $data['kemenag'] = $this->load->view('staff/req_kemenag', $data, true);
        $this->load->view('staff/kemenag_view', $data);
    }

    public function download_surat_cuti() {
        
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required');
        $this->form_validation->set_rules('idm', 'idm', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->setJamaah('red', 'Oops..', 'Access Denied');
            redirect(base_url() . 'jamaah/home_user');
        }

        // validate id_member
        $id_member = $this->secret_key->validate($_GET['idm']);
        if (!$id_member) {
            $this->alert->setJamaah('red', 'Oops..', 'Access Denied!');
            redirect(base_url().'jamaah/home_user');
        }

        // validate id_request
        $id_request = $this->secret_key->validate($_GET['id']);
        if (!$id_request) {
            $this->alert->setJamaah('red', 'Oops..', 'Access Denied!');
            redirect(base_url().'jamaah/home_user');
        }

        // check id_member
        $check = $this->auth->checkMember($_SESSION['id_member'], $id_member);
        if (!$check) {
            $this->alert->setJamaah('red', 'Oops..', 'Access Denied!');
            redirect(base_url().'jamaah/home_user');
        }

        //check id_request
        $checkRequest = $this->auth->checkCuti($_SESSION['id_member'], $id_request);
        if (!$checkRequest) {
            $this->alert->setJamaah('red', 'Oops..', 'Access Denied!');
            redirect(base_url().'jamaah/home_user');
        }

        $this->load->model('registrasi');
        $cuti = $this->registrasi->getDataCuti($id_request);
        $jamaah = $this->registrasi->getJamaah(null, null, $id_member);
        $this->load->library('date');
        $tgl_mulai = $this->date->convert_date_indo($cuti->tanggal_mulai);
        $tgl_selesai = $this->date->convert_date_indo($cuti->tanggal_selesai);
        $tgl_now = $this->date->convert_date_indo(date('Y-m-d'));
        $tahun = date('Y');
        $bulan = $this->date->convert_romawi(date('m', strtotime($cuti->tanggal_dibuat)));
        $data['tanggal_mulai'] = $tgl_mulai ;
        $data['tanggal_selesai'] = $tgl_selesai ;
        $data['tanggal_now'] = $tgl_now ;
        $data['bulan'] = $bulan ;
        $data['tahun'] = $tahun ;
        $data['id'] = $id_request;
        $data['jabatan'] = $cuti->jabatan;
        $data['keterangan'] = $cuti->keterangan;
        $data['jenis_nomor'] = $cuti->jenis_nomor;
        $data['nomor_induk'] = $cuti->nomor_induk;
        $data['header_surat'] = $cuti->header_surat;
        $data['nama'] = $jamaah->first_name . ' ' . $jamaah->second_name . ' ' . $jamaah->last_name;
        $data['html'] = $this->load->view('jamaahv2/surat_cuti_html', $data, true);
        $data['izin'] = $this->load->view('jamaahv2/surat_izin_html', $data, true);
        $this->load->view('jamaahv2/surat_cuti_view', $data);
    }

    public function download_cuti_agen() {
        
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('idr', 'idr', 'trim|required');
        $this->form_validation->set_rules('idm', 'idm', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied');
            redirect(base_url() . 'konsultan/home');
        }
        
        $id_member = $this->secret_key->validate($_GET['idm']);
        $id_request = $this->secret_key->validate($_GET['idr']);
        if (!$id_member) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url().'konsultan/home');
        }
        if (!$id_request) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url().'konsultan/home');
        }
        $check = $this->auth->checkMemberAgen($_SESSION['id_agen'], $id_member);
        if (!$check) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url().'konsultan/home');
        }
        $checkRequest = $this->auth->checkCuti($id_member, $id_request);
        if (!$checkRequest) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url().'konsultan/home');
        }

        $this->load->model('registrasi');
        $cuti = $this->registrasi->getDataCuti($id_request);
        $jamaah = $this->registrasi->getJamaah(null, null, $cuti->id_member);
        // echo '<pre>';
        // print_r($jamaah);
        // exit();
        $this->load->library('date');
        $tgl_mulai = $this->date->convert_date_indo($cuti->tanggal_mulai);
        $tgl_selesai = $this->date->convert_date_indo($cuti->tanggal_selesai);
        $tgl_now = $this->date->convert_date_indo(date('Y-m-d'));
        $bulan = $this->date->convert_romawi(date('m', strtotime($cuti->tanggal_dibuat)));
        $data['tanggal_mulai'] = $tgl_mulai ;
        $data['tanggal_selesai'] = $tgl_selesai ;
        $data['tanggal_now'] = $tgl_now ;
        $data['bulan'] = $bulan ;
        $data['id'] = $id_request;
        $data['jabatan'] = $cuti->jabatan; 
        $data['keterangan'] = $cuti->keterangan; 
        $data['jenis_nomor'] = $cuti->jenis_nomor;
        $data['nomor_induk'] = $cuti->nomor_induk;
        $data['header_surat'] = $cuti->header_surat;
        $data['nama'] = $jamaah->first_name . ' ' . $jamaah->second_name . ' ' . $jamaah->last_name;
        // echo '<pre>';
        // print_r($data);
        // exit();
        $data['html'] = $this->load->view('jamaahv2/surat_cuti_html', $data, true);
        $data['izin'] = $this->load->view('jamaahv2/surat_izin_html', $data, true);
        $this->load->view('jamaahv2/surat_cuti_view', $data);
    }
}