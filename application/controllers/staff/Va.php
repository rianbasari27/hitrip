<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Va extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }
        //this page for master admin, manifest and finance
        if (!($_SESSION['bagian'] == 'Manifest' || $_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Finance' || $_SESSION['bagian'] == 'Admin')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
    }

    public function index()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('idm', 'idm', 'trim|required|integer');


        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->load->model('registrasi');
        $data = $this->registrasi->getJamaah(null, null, $_GET['idm']);
        if (!$data) {
            $this->alert->set('danger', 'Jamaah tidak ditemukan');
            redirect(base_url() . 'staff/dashboard');
        }
        if (!$data->member[0]->va_open) {
            $this->load->model('va_model');
            $data->member[0]->va_open = $this->va_model->createVAOpen($data->member[0]->id_member);
        }
        $groupMembers = [];
        if ($data->member[0]->parent_id) {
            $groupMembers = $this->registrasi->getGroupMembers($data->member[0]->parent_id);
        }
        $data->groupMembers = $groupMembers;

        $this->load->model('tarif');
        $data->pembayaran = $this->tarif->getRiwayatBayar($_GET['idm']);
        $this->load->view('staff/va_view', $data, FALSE);
    }
    public function create()
    {
        $this->form_validation->set_rules('id_member', 'id_member', 'trim|required|integer');
        // $this->form_validation->set_rules('expiryDays', 'expiryDays', 'trim|required|integer');
        // $this->form_validation->set_rules('expiryHours', 'expiryHours', 'trim|required|integer');
        // $this->form_validation->set_rules('metode', 'metode', 'required');
        $this->form_validation->set_rules('nominal_tagihan', 'Nominal Pembayaran', 'required|integer');
        // $this->form_validation->set_rules('informasi', 'informasi', 'required');


        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->model('duitku');
        $invoice = $this->duitku->createInvoice($_POST['id_member'], $_POST['nominal_tagihan']);

        redirect($_SERVER['HTTP_REFERER']);
    }
    public function load_duitku()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'duitku';
        // Primary key of table
        $primaryKey = 'merchantOrderId';
        $columns = array(
            array('db' => 'reference', 'dt' => 0, 'field' => 'reference'),
            array('db' => 'productDetail', 'dt' => 1, 'field' => 'productDetail'),
            array('db' => 'dateCreated', 'dt' => 2, 'field' => 'dateCreated'),
            array('db' => 'dateExpired', 'dt' => 3, 'field' => 'dateExpired'),
            array('db' => 'paymentAmount', 'dt' => 4, 'field' => 'paymentAmount'),
            array('db' => 'paymentCode', 'dt' => 5, 'field' => 'paymentCode'),
            array('db' => 'resultCode', 'dt' => 6, 'field' => 'resultCode'),
            array('db' => 'paymentUrl', 'dt' => 7, 'field' => 'paymentUrl'),
            array('db' => 'datePaid', 'dt' => 8, 'field' => 'datePaid'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $id_member = $_GET['id_member'];
        $extraCondition = "`merchantUserId`=" . $id_member;
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, null, $extraCondition);

        foreach ($data['data'] as $key => $d) {
            $data['data'][$key][4] = 'Rp. ' . number_format($d[4], 0, ',', '.') . ',-';
        }

        echo json_encode($data);
    }
    public function load_va()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'virtual_account';
        // Primary key of table
        $primaryKey = 'nomor_va';

        $columns = array(
            array('db' => 'nomor_va', 'dt' => 'nomor_va', 'field' => 'nomor_va'),
            array('db' => 'informasi', 'dt' => 'informasi', 'field' => 'informasi'),
            array('db' => 'tanggal_create', 'dt' => 'tanggal_create', 'field' => 'tanggal_create'),
            array('db' => 'tanggal_expired', 'dt' => 'tanggal_expired', 'field' => 'tanggal_expired'),
            array('db' => 'id_member', 'dt' => 'id_member', 'field' => 'id_member'),
            array('db' => 'nominal_tagihan', 'dt' => 'nominal_tagihan', 'field' => 'nominal_tagihan'),
            array('db' => 'metode', 'dt' => 'metode', 'field' => 'metode'),
            array('db' => 'waktu_transaksi', 'dt' => 'waktu_transaksi', 'field' => 'waktu_transaksi'),
            array('db' => 'status_pembayaran', 'dt' => 'status_pembayaran', 'field' => 'status_pembayaran'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $id_member = $_GET['id_member'];
        $extraCondition = "`id_member`=" . $id_member;
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, null, $extraCondition);

        foreach ($data['data'] as $key => $d) {
            $data['data'][$key]['nominal_tagihan'] = 'Rp. ' . number_format($d['nominal_tagihan'], 0, ',', '.') . ',-';
        }

        echo json_encode($data);
    }
}
        
    /* End of file  staff/Va.php */
