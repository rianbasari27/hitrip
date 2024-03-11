<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Daftar_agen extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }
        //this page only for admin
        if (!($_SESSION['bagian'] == 'PR' || $_SESSION['bagian'] == 'Master Admin')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->load->model('agen');
        $this->load->model('agenPaket');
    }

    public function index() {
        $agen = $this->agen->getAgen();
        $program = $this->agenPaket->getAgenPackage(null, true, true, true);
        $this->load->model('region');
        $province = $this->region->getProvince();
        $regency = $this->region->getRegency(null, $province[0]->id);
        $districts = $this->region->getDistrict(null, $regency[0]->id);
        $data = array (
            "agen" => $agen,
            "program" => $program,
            'provinsi' => $province,
            'kabupaten' => $regency,
            'kecamatan' => $districts,
        );
        $this->load->view('staff/registrasi_konsultan_view', $data);
    }

    public function proses_tambah() {
        $this->form_validation->set_rules('id_agen_paket', 'Pilih Program', 'trim|required');
        $this->form_validation->set_rules('nama_agen', 'Nama Konsultan', 'trim|required');
        $this->form_validation->set_rules('no_agen', 'Nomor Konsultan', 'trim|required');
        $this->form_validation->set_rules('no_ktp', 'Nomor KTP', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->alert->set('danger', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        }

        $program = $this->agenPaket->getAgenPackage($_POST['id_agen_paket'],false, false, true);
        if (empty($program)) {
            $this->alert->set('danger', 'Program sudah tidak tersedia, Seat Habis!!') ;
        }

        $nama_agen = preg_replace('/\(\d+\)/', '', $_POST['nama_agen']);
        $_POST['nama_agen'] = trim($nama_agen);
        if ($_POST['status'] == 1 ) {
            $update = true;
        } else {
            $update = false;
        }
        $hasil = $this->agenPaket->addProgramMember($_POST, $update);
        $this->alert->set($hasil['status'], $hasil['msg']);
        redirect($_SERVER['HTTP_REFERER']);
    }

}
