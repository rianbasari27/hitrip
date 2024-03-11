<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Daftar_konsultan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //check if logged in redirect to user page
        $this->load->model('customer');
        if ($this->customer->is_user_logged_in()) {
            redirect(base_url() . 'jamaah/home_user');
        }
        $this->load->model('konsultanAuth');
        if ($this->konsultanAuth->is_user_logged_in()) {
            redirect(base_url() . 'konsultan/home');
        }

        $this->load->model('agen');
        $this->load->model('agenPaket');
    }

    public function index() {
        $agen = $this->agen->getAgen();
        $program = $this->agenPaket->getAgenPackage(null, true, true, true, '0');
        if (empty($program)) {
            $this->alert->setJamaah('merah', 'Oops!', 'Mohon maaf saat ini program tidak tersedia');
            redirect($_SERVER['HTTP_REFERER']);
        }
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
        $this->load->view('konsultan/registrasi_konsultan_view', $data);
    }

    public function proses_tambah() {
        $this->form_validation->set_rules('id_agen_paket', 'Pilih Program', 'trim|required');
        $this->form_validation->set_rules('upline_id', 'Nama Upline', 'trim|required');
        $this->form_validation->set_rules('nama_agen', 'Nama Lengkap', 'trim|required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'trim|required');
        $this->form_validation->set_rules('email', 'Gmail', 'trim|required');
        $this->form_validation->set_rules('no_wa', 'No WhatsApp', 'trim|required');
        $this->form_validation->set_rules('ukuran_baju', 'Ukuran Baju', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
        $this->form_validation->set_rules('no_ktp', 'Nomor KTP', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata(['form' => $_POST]);
            $this->alert->setJamaah('red', 'Ups...', validation_errors('<li>', '</li>'));
            redirect($_SERVER['HTTP_REFERER']);
        }

        $program = $this->agenPaket->getAgenPackage($_POST['id_agen_paket'], true, true, true, '0');
        if (empty($program)) {
            $this->session->set_flashdata(['form' => $_POST]);
            $this->alert->setJamaah('danger', 'Program sudah tidak tersedia, Seat Habis!!') ;
            redirect($_SERVER['HTTP_REFERER']);
        }

        if (isset($_FILES['foto_diri']['name'])) {
            $_POST['files']['foto_diri'] = $_FILES['foto_diri'];
        }
        if (isset($_FILES['foto_diri2']['name'])) {
            $_POST['files']['foto_diri2'] = $_FILES['foto_diri2'];
        }


        $hasil = $this->agenPaket->addProgramMember($_POST, false);
        if ($hasil['status'] != 'success') {
            $this->session->set_flashdata(['form' => $_POST]);
            $this->alert->setJamaah('red', 'Oops!', 'Pendaftaran gagal !');
            redirect(base_url() . $_SERVER['HTTP_REFERER']);
        }
        
        $agen = $this->agen->getAgen($hasil['id_agen']);
        if ($agen == null) {
            $this->alert->setJamaah('red', 'Oops!', 'Konsultan tidak terdaftar.');
            redirect(base_url() . 'konsultan/home');
        }
        $login = $this->konsultanAuth->backdoor_login($agen[0]);
        if (!$login) {
            return false;
        } else {
            $this->alert->setJamaah('success', 'Selamat', 'Berhasil mendaftar sebagai konsultan');
            redirect(base_url() . 'konsultan/home');
        }
    }

    public function agen_autocomplete()
    {
        $term = $_GET['term'];
        $this->load->model('agen');
        $data = $this->agen->getAgenByName($term);
        echo json_encode($data);
    }

    public function get_paket() {
        $term = $_GET['term'];
        $this->load->model('agenPaket');
        $data = $this->agenPaket->getAgenPackage($term);
        echo json_encode($data);
    }

}