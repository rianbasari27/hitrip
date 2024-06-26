<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Voucher extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }
        //this page only for admin
        if (!($_SESSION['bagian'] == 'Admin' || $_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Finance')) {
            $this->alert->toast('danger', 'Mohon Maaf', 'Anda tidak memiliki akses');
            redirect(base_url() . 'staff/dashboard');
        }
    }

    public function index()
    {
        $this->load->view('staff/voucher_list_view');
    }

    public function tambah()
    {
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage(null, true);
        $data = array (
            'paket' => $paket
        );
        $this->load->view('staff/tambah_voucher_view', $data);
    }

    public function load_voucher()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'voucher';
        // Primary key of table
        $primaryKey = 'id_voucher';

        $columns = array(
            array('db' => 'id_voucher', 'dt' => 'DT_RowId'),
            array('db' => 'kode_voucher', 'dt' => 1),
            array('db' => 'nominal', 'dt' => 2),
            array('db' => 'kuota', 'dt' => 3),
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

    public function proses_tambah()
    {
        $this->form_validation->set_rules('kode_voucher', 'Kode Voucher', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('nominal', 'Nominal', 'trim|required');
        $this->form_validation->set_rules('kuota', 'Kuota', 'trim|required');
        $this->form_validation->set_rules('tgl_mulai', 'Tanggal Mulai', 'trim|required');
        $this->form_validation->set_rules('tgl_berakhir', 'Tanggal Berakhir', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->toast('danger', 'Mohon Maaf', "Pastikan untuk mengisi semua data");
            redirect($_SERVER['HTTP_REFERER']);
        }

        $data = $_POST;
        $data['nominal'] = str_replace(",", "", $data['nominal']);
        $data['kuota'] = str_replace(",", "", $data['kuota']);
        //add new voucher
        $this->load->model('voucherModel');
        if (!($id = $this->voucherModel->addVoucher($data))) {
            redirect(base_url() . 'staff/voucher/tambah');
        } else {
            redirect(base_url() . 'staff/voucher');
        }
    }

    public function edit() 
    {
        $this->load->model('voucherModel');
        $v = $this->voucherModel->getVoucher($_GET['id']);
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage(null, false);
        $listVoucher = $this->voucherModel->getVoucherPaketArray($_GET['id']);
        $data = array (
            'paket' => $paket,
            'listVoucher' => $listVoucher,
            'voucher' => $v
        );
        $this->load->view('staff/edit_voucher_view', $data);
    }

    public function proses_edit() 
    {
        $this->form_validation->set_rules('kode_voucher', 'Kode Voucher', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('nominal', 'Nominal', 'trim|required|numeric');
        $this->form_validation->set_rules('kuota', 'Kuota', 'trim|required|numeric');
        $this->form_validation->set_rules('tgl_mulai', 'Tanggal Mulai', 'trim|required');
        $this->form_validation->set_rules('tgl_berakhir', 'Tanggal Berakhir', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->toast('danger', 'Mohon Maaf', "Pastikan untuk mengisi semua data");
            redirect(base_url() . 'staff/voucher/tambah');
        }

        $this->load->model('voucherModel');
        if (!($data = $this->voucherModel->editVoucher($_POST))) {
            $this->alert->toast('success', 'Selamat', "Voucher Berhasil Diubah");
            redirect(base_url() . 'staff/voucher');
        } else {
            $this->alert->toast('danger', 'Mohon Maaf', "Voucher Gagal Diubah");
            redirect(base_url() . 'staff/voucher');
        }
    }
      
    public function hapus() 
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->toast('danger', 'Mohon Maaf', "ID Voucher tidak ditemukan");
            redirect(base_url() . 'staff/voucher');
        }

        $this->load->model('voucherModel');
        if (!($data = $this->voucherModel->hapusVoucher($_GET['id']))) {
            $this->alert->toast('success', 'Selamat', "Voucher Berhasil Dihapus");
            redirect(base_url() . 'staff/voucher');
        } else {
            $this->alert->toast('danger', 'Mohon Maaf', "Voucher Gagal Dihapus");
            redirect(base_url() . 'staff/voucher');
        }
    }
}