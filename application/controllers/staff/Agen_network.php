<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Agen_network extends CI_Controller
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
    }

    public function index()
    {
        if (empty($_GET['id'])) {
            $this->alert->set('danger', 'Konsultan tidak ditemukan');
            redirect(base_url() . 'staff/kelola_agen');
        }
        $this->load->model('agen');
        $agenData = $this->agen->getAgen($_GET['id']);
        if (empty($agenData)) {
            $this->alert->set('danger', 'Konsultan tidak ditemukan');
            redirect(base_url() . 'staff/kelola_agen');
        }
        $uplineData = $this->agen->getUpline($_GET['id']);

        $data = [
            'agen' => $agenData[0],
            'upline' => $uplineData
        ];
        $this->load->library('wa_number');

        $this->load->view('staff/agen_network_view', $data, FALSE);
    }

    public function atur_network($page, $agenId)
    {
        $this->load->model('agen');
        $agenData = $this->agen->getAgen($agenId);
        if (empty($agenData)) {
            $this->alert->set('danger', 'Konsultan tidak ditemukan');
            redirect(base_url() . 'staff/kelola_agen');
        }
        $agenData = $agenData[0];
        $agenData->uplineData = new stdClass();
        if (!empty($agenData->upline_id)) {
            $uplineData = $this->agen->getAgen($agenData->upline_id);
            if (!empty($uplineData)) {
                $agenData->uplineData = $uplineData[0];
            }
        }
        $agenData->pageTitle = ucfirst($page);
        if ($page == 'upline') {
            $agenData->submitForm = base_url() . "staff/agen_network/proses_upline";
        } elseif ($page == 'downline') {
            $agenData->submitForm = base_url() . "staff/agen_network/proses_downline";
        }
        $this->load->view('staff/agen_atur_upline', $agenData);
    }
    public function hapus_upline($idAgen)
    {
        $this->load->model('agen');
        $hapus = $this->agen->hapusUpline($idAgen);
        if ($hapus) {
            $this->alert->set('success', 'Upline berhasil dihapus');
        }
        redirect(base_url() . 'staff/agen_network?id=' . $idAgen);
    }
    public function proses_downline()
    {
        if (empty($_POST['id_upline']) || empty($_POST['id_agen'])) {
            $this->alert->set('danger', 'Error, terjadi kesalahan');
            redirect(base_url() . 'staff/kelola_agen');
        }
        $idAgen = $_POST['id_agen'];
        $idDownline = $_POST['id_upline'];
        $this->load->model('agen');
        $set = $this->agen->setDownline($idAgen, $idDownline);
        if ($set) {
            $this->alert->set('success', 'Downline berhasil ditambahkan');
        } else {
            $this->alert->set('danger', 'Error, Downline gagal ditambahkan');
        }
        redirect(base_url() . 'staff/agen_network?id=' . $idAgen);
    }
    public function proses_upline()
    {
        if (empty($_POST['id_upline']) || empty($_POST['id_agen'])) {
            $this->alert->set('danger', 'Error, terjadi kesalahan');
            redirect(base_url() . 'staff/kelola_agen');
        }
        $idAgen = $_POST['id_agen'];
        $idUpline = $_POST['id_upline'];
        $this->load->model('agen');
        $set = $this->agen->setUpline($idAgen, $idUpline);
        if ($set) {
            $this->alert->set('success', 'Upline berhasil di update');
        } else {
            $this->alert->set('danger', 'Error, Upline gagal di update');
        }
        redirect(base_url() . 'staff/agen_network?id=' . $idAgen);
    }
    public function load_downline()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'agen';
        // Primary key of table
        $primaryKey = 'id_agen';

        $columns = array(
            array('db' => 'id_agen', 'dt' => 'DT_RowId'),
            array('db' => 'nama_agen', 'dt' => 'nama_agen'),
            array('db' => 'no_agen', 'dt' => 'no_agen'),
            array('db' => 'no_wa', 'dt' => 'no_wa'),
            array('db' => 'kota', 'dt' => 'kota'),
            array('db' => 'provinsi', 'dt' => 'provinsi'),
            array('db' => 'kecamatan', 'dt' => 'kecamatan'),
            array('db' => 'alamat', 'dt' => 'alamat'),
            array('db' => 'claimed_point', 'dt' => 'claimed_point'),
            array('db' => 'unclaimed_point', 'dt' => 'unclaimed_point'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $idAgen = $_GET['id_agen'];
        $extraCondition = "upline_id = $idAgen";
        echo json_encode(
            SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, null, $extraCondition)
        );
    }
    public function hapus_downline($idAgen, $idDownline)
    {
        $this->load->model('agen');
        $hapus = $this->agen->hapusDownline($idDownline);
        if ($hapus) {
            $this->alert->set('success', 'Downline berhasil di hapus');
        }
        redirect(base_url() . 'staff/agen_network?id=' . $idAgen);
    }
}
        
    /* End of file  Agen_network.php */
