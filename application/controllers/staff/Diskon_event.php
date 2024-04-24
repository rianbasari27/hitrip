<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Diskon_event extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }
        //this page only for admin
        if (!($_SESSION['bagian'] == 'Master Admin')) {
            $this->alert->toast('danger', 'Mohon Maaf', 'Anda tidak memiliki akses');
            redirect(base_url() . 'staff/dashboard');
        }
    }

    public function index()
    {
        $this->load->view('staff/diskon_event_list');
    }

    public function load_diskon()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'diskon';
        // Primary key of table
        $primaryKey = 'id_diskon';

        $columns = array(
            array('db' => 'id_diskon', 'dt' => 'DT_RowId'),
            array('db' => 'nama_diskon', 'dt' => '1'),
            array(
                'db' => 'nominal', // Kolom nominal untuk format Rupiah
                'dt' => 2,
                'formatter' => function($d, $row) {
                    return 'Rp ' . number_format($d, 0, ',', '.');
                }
            ),
            array('db' => 'kuota', 'dt' => 3,
                'formatter' => function($d, $row) {
                    return number_format($d);
            }),
            array('db' => 'tgl_mulai', 'dt' => 4),
            array('db' => 'tgl_berakhir', 'dt' => 5),
            array(
                'db' => 'aktif',
                'dt' => 6,
                'formatter' => function ($d, $row) {
                    if ($d == 1) {
                        return "Aktif";
                    } else {
                        return "Tidak Aktif";
                    }
                }
            ),
        );
        
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        
        echo json_encode(
            SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
        );
        
    }

    public function tambah()
    {
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage(null, true);
        $data = array (
            'paket' => $paket
        );
        $this->load->view('staff/tambah_diskon_event', $data);
    }

    public function proses_tambah()
    {
        $this->form_validation->set_rules('nama_diskon', 'Nama Promo', 'trim|required');
        $this->form_validation->set_rules('nominal', 'Nominal', 'trim|required');
        $this->form_validation->set_rules('tgl_mulai', 'Tanggal Mulai', 'trim|required');
        $this->form_validation->set_rules('tgl_berakhir', 'Tanggal Berakhir', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->toast('danger', 'Mohon Maaf', "Pastikan untuk mengisi semua data");
            redirect($_SERVER['HTTP_REFERER']);
        }

        $data = $_POST;
        $data['nominal'] = str_replace(",", "", $data['nominal']);
        $data['kuota'] = str_replace(",", "", $data['kuota']);
        //add new Diskon

        if (!empty($_FILES['banner_promo']['name'])) {
            $data['files']['banner_promo'] = $_FILES['banner_promo'];
        }

        $this->load->model('paketUmroh');
        if (!($id = $this->paketUmroh->addDiskonEvent($data))) {
            redirect(base_url() . 'staff/diskon_event/tambah');
        } else {
            redirect(base_url() . 'staff/diskon_event');
        }
    }

    public function edit() 
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|numeric');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->toast('danger', 'Mohon Maaf', "Promo tidak ditemukan");
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->load->model('paketUmroh');
        $discountEvent = $this->paketUmroh->getDiskonEvent($_GET['id']);
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage(null, true);
        $data = array (
            'paket' => $paket,
            'diskon' => $discountEvent
        );
        $this->load->view('staff/edit_diskon_event', $data);
    }

    public function proses_edit() 
    {
        $this->form_validation->set_rules('id_diskon', 'ID Diskon', 'trim|required|numeric');
        $this->form_validation->set_rules('nama_diskon', 'Nama Promo', 'trim|required');
        $this->form_validation->set_rules('nominal', 'Nominal', 'trim|required');
        $this->form_validation->set_rules('tgl_mulai', 'Tanggal Mulai', 'trim|required');
        $this->form_validation->set_rules('tgl_berakhir', 'Tanggal Berakhir', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->toast('danger', 'Mohon Maaf', "Pastikan untuk mengisi semua data");
            redirect($_SERVER['HTTP_REFERER']);
        }
        $_POST['nominal'] = str_replace(",", "", $_POST['nominal']);
        $_POST['kuota'] = str_replace(",", "", $_POST['kuota']);

        $this->load->model('paketUmroh');
        if (!($data = $this->paketUmroh->editDiskonEvent($_POST))) {
            $this->alert->toast('danger', 'Mohon Maaf', "Promo Gagal Diubah");
        } else {
            $this->alert->toast('success', 'Selamat', "Promo Berhasil Diubah");
        }
        
        redirect(base_url() . 'staff/diskon_event');
    }

    public function hapus() 
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied.');
            redirect(base_url() . 'staff/diskon_event');
        }

        $this->load->model('paketUmroh');
        if (($this->paketUmroh->hapusDiskonEvent($_GET['id']))) {
            $this->alert->toast('success', 'Selamat' ,'Promo Berhasil Dihapus');
        } else {
            $this->alert->toast('danger', 'Mohon Maaf' ,'Promo Gagal Dihapus');
        }
        
        redirect(base_url() . 'staff/diskon_event');
    }

    public function upload()
    {
        $this->form_validation->set_rules('id_diskon', 'id_diskon', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->toast('danger', 'Mohon Maaf', 'Anda tidak memiliki akses');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->load->model('paketUmroh');
        $up = $this->paketUmroh->uploadBannerDiskon($_FILES, $_POST['id_diskon']);
        $this->alert->toast('success', 'Selamat', 'Upload gambar berhasil');
        redirect($_SERVER['HTTP_REFERER']);
    }
}