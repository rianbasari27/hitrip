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
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
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
            array(
                'db' => 'nominal', // Kolom nominal untuk format Rupiah
                'dt' => 0,
                'formatter' => function($d, $row) {
                    return 'Rp ' . number_format($d, 0, ',', '.');
                }
            ),
            array('db' => 'tgl_mulai', 'dt' => 1),
            array('db' => 'tgl_berakhir', 'dt' => 2),
            array(
                'db' => 'aktif',
                'dt' => 3,
                'formatter' => function ($d, $row) {
                    if ($d == 1) {
                        return "Aktif";
                    } else {
                        return "Tidak Aktif";
                    }
                }
            )
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
        $this->form_validation->set_rules('nominal', 'Nominal', 'trim|required');
        $this->form_validation->set_rules('tgl_mulai', 'Tanggal Mulai', 'trim|required');
        $this->form_validation->set_rules('tgl_berakhir', 'Tanggal Berakhir', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect(base_url() . 'staff/diskon_event/tambah');
        }

        $data = $_POST;
        //add new voucher
        $data['nominal'] = str_replace(",", "", $data['nominal']);
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
        $this->form_validation->set_rules('nominal', 'Nominal', 'trim|required');
        $this->form_validation->set_rules('tgl_mulai', 'Tanggal Mulai', 'trim|required');
        $this->form_validation->set_rules('tgl_berakhir', 'Tanggal Berakhir', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        }

        $_POST['nominal'] = str_replace(",", "", $_POST['nominal']);
        $this->load->model('paketUmroh');
        if (!($data = $this->paketUmroh->editDiskonEvent($_POST))) {
            $this->alert->set('danger', 'Discount Event Gagal Diubah');
        } else {
            $this->alert->set('success', 'Discount Event Berhasil Diubah');
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
        if (!($this->paketUmroh->hapusDiskonEvent($_GET['id']))) {
            $this->alert->set('success', 'Discount Event Berhasil Dihapus');
        } else {
            $this->alert->set('success', 'Discount Event Gagal Dihapus');
        }
        
        redirect(base_url() . 'staff/diskon_event');
    }
}