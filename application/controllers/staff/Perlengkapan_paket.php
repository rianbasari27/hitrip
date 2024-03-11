<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Perlengkapan_paket extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }
        //this page only for admin
        if (!($_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Logistik')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
    }

    public function index()
    {
        $this->load->view('staff/list_perlengkapan_paket');
    }

    public function atur()
    {
        if (!($_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Logistik')) 
        {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/perlengkapan_paket');
        }


        $this->load->model('paketUmroh');
        $paketInfo = $this->paketUmroh->getPackage($_GET['id'], false);

        if (empty($paketInfo)) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/perlengkapan_paket');
        }
        $this->load->model('logistik');
        $perlengkapanPaket = $this->logistik->getPerlengkapanPaket($_GET['id']);
        $data = array(
            'paketInfo' => $paketInfo,
            'perlengkapanPaket' => $perlengkapanPaket
        );
        $this->load->view('staff/atur_perlengkapan_paket', $data);
    }

    public function proses_atur()
    {
        $this->form_validation->set_rules('idPaket', 'idPaket', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/perlengkapan_paket');
        }
        $this->load->model('logistik');
        $data = $_POST;
        $idPaket = $data['idPaket'];
        unset($data['idPaket']);
        $insert = $this->logistik->addPerlengkapanPaket($_POST['idPaket'], $data);
        if ($insert == false) {
            $this->alert->set('danger', 'Perlengkapan Paket gagal di update');
        } else {
            $this->alert->set('success', 'Perlengkapan Paket Berhasil di Update');
        }
        redirect(base_url() . 'staff/perlengkapan_paket');
    }

    public function atur_status()
    {
        if (!($_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Logistik')) 
        {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/perlengkapan_paket');
        }
        $this->load->model('logistik');
        $perlengkapan = $this->logistik->getPerlengkapanPaket($_GET['id']);

        if (empty($perlengkapan)) {
            $this->alert->set('danger', 'Atur Perlengkapan Terlebih Dahulu!');
            redirect(base_url() . 'staff/perlengkapan_paket');
        }
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage($_GET['id'], false);

        $data = array(
            'perlengkapan' => $perlengkapan,
            'paket' => $paket
        );

        $this->load->view('staff/status_perlengkapan_paket', $data);
    }

    public function proses_status()
    {
        $this->form_validation->set_rules('status', 'status', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Status tidak dipilih');
            redirect(base_url() . 'staff/perlengkapan_paket');
        }

        if (!isset($_POST['id_perlpaket'])) {
            $this->alert->set('danger', 'Tidak ada perlengkapan yang dipilih');
            redirect(base_url() . 'staff/perlengkapan_paket');
        }

        if (empty($_POST['id_perlpaket'])) {
            $this->alert->set('danger', 'Tidak ada perlengkapan yang dipilih');
            redirect(base_url() . 'staff/perlengkapan_paket');
        }

        $this->load->model('logistik');
        $set = $this->logistik->setStatusPerlengkapanPaket($_POST['id_perlpaket'], $_POST['status']);
        if ($set == false) {
            $this->alert->set('danger', 'Status gagal diubah');
        } else {
            $this->alert->set('success', 'Status berhasil diubah');
        }
        redirect(base_url() . 'staff/perlengkapan_paket');
    }



    public function load_perlengkapan()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'paket_umroh';
        // Primary key of table
        $primaryKey = 'id_paket';

        $columns = array(
            array('db' => '`pu`.`id_paket`', 'dt' => 'DT_RowId', 'field' => 'id_paket'),
            array('db' => '`pu`.`id_paket`', 'dt' => 'id_paket', 'field' => 'id_paket'),
            array('db' => '`pu`.`nama_paket`', 'dt' => 'nama_paket', 'field' => 'nama_paket'),
            array('db' => '`pu`.`tanggal_berangkat`', 'dt' => 'tanggal_berangkat', 'field' => 'tanggal_berangkat'),
            array('db' => 'SUM(`pp`.`jumlah_pria`) AS sumpria', 'dt' => 'sumpria', 'field' => 'sumpria'),
            array('db' => 'SUM(`pp`.`jumlah_wanita`) AS sumwanita', 'dt' => 'sumwanita', 'field' => 'sumwanita'),
            array('db' => 'SUM(`pp`.`jumlah_anak_pria`) AS sumanakpria', 'dt' => 'sumanakpria', 'field' => 'sumanakpria'),
            array('db' => 'SUM(`pp`.`jumlah_anak_wanita`) AS sumanakwanita', 'dt' => 'sumanakwanita', 'field' => 'sumanakwanita'),
            array('db' => 'SUM(`pp`.`jumlah_bayi`) AS sumbayi', 'dt' => 'sumbayi', 'field' => 'sumbayi')
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $joinQuery = "FROM `{$table}` AS `pu` LEFT JOIN `perlengkapan_paket` AS `pp` ON (`pp`.`id_paket` = `pu`.`id_paket`)";
        $groupBy = "`pu`.`id_paket`";
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, null, $groupBy);

        echo json_encode($data);
    }
}