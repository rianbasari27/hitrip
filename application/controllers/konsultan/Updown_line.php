<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Updown_line extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('konsultanAuth');
        if (!$this->konsultanAuth->is_user_logged_in()) {
            redirect(base_url() . 'konsultan/login');
        }
    }

    public function index()
    {
        $this->load->model('agen');
        $agen = $this->agen->getAgen($_SESSION['id_agen']);
        if ($agen[0]->active != 1) {
            redirect(base_url() . 'konsultan/home/pemb_notice');
        }
        $idAgen = $_SESSION['id_agen'];
        $upline = $this->agen->getUpline($idAgen);
        $this->load->library('wa_number');

        $this->load->view('konsultan/updownline_view', $upline, FALSE);
    }
    public function load_downline()
    {
        include APPPATH . 'third_party/ssp.class.php';

        if (!isset($_GET['_'])) {
            redirect(base_url() . 'konsultan/updown_line');
        }
        $table = 'agen';
        // Primary key of table
        $primaryKey = 'id_agen';

        $columns = array(
            array('db' => 'id_agen', 'dt' => 'DT_RowId', 'field' => 'id_agen'),
            array('db' => 'agen_pic', 'dt' => 'agen_pic', 'field' => 'agen_pic'),
            array('db' => 'nama_agen', 'dt' => 'nama_agen', 'field' => 'nama_agen'),
            array('db' => 'no_wa', 'dt' => 'no_wa', 'field' => 'no_wa')
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $idAgen = $_GET['id_agen'];
        $extraCondition = "upline_id = $idAgen";
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, null, $extraCondition);

        $this->load->library('wa_number');

        foreach ($data['data'] as $key => $dt) {
            $noWa = $dt['no_wa'];
            if (!empty($noWa)) {
                $data['data'][$key]['no_wa'] = $this->wa_number->convert($dt['no_wa']);
            }
            $this->load->model('agen');
            $jamaahAgen = $this->agen->getJamaahAgen($dt['DT_RowId'], false, true);
            $data['data'][$key]['total_jamaah'] = count($jamaahAgen);
        }
        echo json_encode($data);
    }

    public function tambah_downline()
    {
        $this->load->model('agen');
        $this->load->model('agenPaket');
        $agen = $this->agen->getAgen($_SESSION['id_agen']);
        $program = $this->agenPaket->getAgenPackage(null, false, true, true, '1');

        if (empty($program)) {
            $this->alert->setJamaah('red', 'Oops!', 'Mohon maaf saat ini program tidak tersedia');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->load->model('region');
        $province = $this->region->getProvince();
        $regency = $this->region->getRegency(null, $province[0]->id);
        $districts = $this->region->getDistrict(null, $regency[0]->id);
        $data = array(
            "agen" => $agen[0],
            "program" => $program,
            'provinsi' => $province,
            'kabupaten' => $regency,
            'kecamatan' => $districts,
        );
        $this->load->view('konsultan/registrasi_downline_view', $data);
    }

    public function proses_tambah()
    {
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

        $this->load->model('agen');
        $this->load->model('agenPaket');
        $program = $this->agenPaket->getAgenPackage($_POST['id_agen_paket'], false, true, true, '1');
        if (empty($program)) {
            $this->session->set_flashdata(['form' => $_POST]);
            $this->alert->setJamaah('danger', 'Program sudah tidak tersedia, Seat Habis!!');
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
            redirect(base_url() . 'konsultan/updown_line');
        } else {
            $this->alert->setJamaah('green', 'Selamat', 'Berhasil mendaftarkan downline anda');
            redirect(base_url() . 'konsultan/updown_line');
        }
    }

    public function get_paket()
    {
        $term = $_GET['term'];
        $this->load->model('agenPaket');
        $data = $this->agenPaket->getAgenPackage($term);
        echo json_encode($data);
    }
}
        
    /* End of file  Updown_line.php */
