<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }
        //this page only for admin
        if (!($_SESSION['bagian'] == 'Admin' || $_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Logistik')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
    }

    public function index()
    {

        $this->load->view('staff/list_barang');
    }

    public function tambah()
    {
        if (!($_SESSION['bagian'] == 'Admin' || $_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Logistik')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->load->view('staff/tambah_barang');
    }

    public function proses_tambah()
    {
        if (!($_SESSION['bagian'] == 'Admin' || $_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Logistik')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->form_validation->set_rules('nama_barang', 'nama_barang', 'trim|required');
        $this->form_validation->set_rules('stok', 'stok', 'trim|required|integer');
        $this->form_validation->set_rules('stok_unit', 'stok_unit', 'trim|required');
        $this->form_validation->set_rules('deskripsi', 'deskripsi', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect(base_url() . 'staff/barang');
        }
        $data = $_POST;
        if (!empty($_FILES['pic']['name'])) {
            $data['files']['pic'] = $_FILES['pic'];
        }

        $this->load->model('logistik');
        $tambah = $this->logistik->addBarang($data);
        if ($tambah == false) {
            $this->alert->set('danger', 'Barang gagal ditambahkan');
        } else {
            $this->alert->set('success', 'Barang berhasil ditambahkan');
        }
        redirect(base_url() . 'staff/barang');
    }

    public function lihat()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/barang');
        }
        $this->load->model('logistik');
        $data = $this->logistik->getBarang($_GET['id']);
        $this->load->view('staff/lihat_barang', $data[0]);
    }

    public function hapus()
    {
        if (!($_SESSION['bagian'] == 'Master Admin' || $_SESSION['email'] == 'ramang.purchase@ventour.co.id' || $_SESSION['email'] == 'sutan@ventour.co.id')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/barang');
        }
        $this->load->model('logistik');
        $data = $this->logistik->deleteBarang($_GET['id']);
        if ($data == true) {
            $this->alert->set('success', 'Barang Berhasil Dihapus');
        } else {
            $this->alert->set('danger', 'Barang Gagal Dihapus');
        }
        redirect(base_url() . 'staff/barang');
    }

    public function ubah()
    {
        if (!($_SESSION['bagian'] == 'Admin' || $_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Logistik')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/barang');
        }
        $this->load->model('logistik');
        $data = $this->logistik->getBarang($_GET['id']);
        if (empty($data[0])) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/barang');
        }
        $this->load->view('staff/ubah_barang', $data[0]);
    }

    public function proses_ubah()
    {
        if (!($_SESSION['bagian'] == 'Admin' || $_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Logistik')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->form_validation->set_rules('id_logistik', 'id_logistik', 'trim|required|integer');
        $this->form_validation->set_rules('nama_barang', 'nama_barang', 'trim|required');
        $this->form_validation->set_rules('stok', 'stok', 'trim|required|integer');
        $this->form_validation->set_rules('stok_unit', 'stok_unit', 'trim|required');
        $this->form_validation->set_rules('deskripsi', 'deskripsi', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect(base_url() . 'staff/barang');
        }
        $this->load->model('logistik');
        $data = $this->logistik->editBarang($_POST['id_logistik'], $_POST);
        if ($data == true) {
            $this->alert->set('success', 'Barang Berhasil Diubah');
        } else {
            $this->alert->set('danger', 'Barang Gagal Diubah');
        }
        redirect(base_url() . 'staff/barang');
    }

    public function load_barang()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'logistik';
        // Primary key of table
        $primaryKey = 'id_logistik';

        $columns = array(
            array('db' => 'id_logistik', 'dt' => 'DT_RowId'),
            array('db' => 'nama_barang', 'dt' => 'nama_barang'),
            array('db' => 'stok', 'dt' => 'stok'),
            array('db' => 'stok_kantor', 'dt' => 'stok_kantor'),
            array('db' => 'stok_bandung', 'dt' => 'stok_bandung'),
            array('db' => 'stok_unit', 'dt' => 'stok_unit')
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns);

        foreach ($data['data'] as $key => $d) {
            $data['data'][$key]['total_stok'] = $d['stok'] + $d['stok_kantor'] + $d['stok_bandung'];
            $data['data'][$key]['status'] = 'Stok Aman';
            if ($data['data'][$key]['total_stok'] < 1000) {
                $data['data'][$key]['status'] = 'Stok Menipis';
            }
            if ($data['data'][$key]['total_stok'] < 500 ) {
                $data['data'][$key]['status'] = 'Harus Order';
            }
        }
        echo json_encode($data);
    }

    public function ganti_pic()
    {
        if (!isset($_POST)) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/barang');
        }
        if (!isset($_POST['id_logistik'])) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/barang');
        }
        $this->load->model('logistik');
        $this->logistik->changePic($_POST['id_logistik'], $_FILES['file']);
        redirect(base_url() . 'staff/barang/lihat?id=' . $_POST['id_logistik']);
    }

    public function delete_pic()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/barang');
        }

        $this->load->model('logistik');
        $result = $this->logistik->hapusPic($_GET['id']);
        if ($result) {
            $this->alert->set('success', "Gambar berhasil dihapus");
        } else {
            $this->alert->set('danger', "Gambar gagal dihapus");
        }
        redirect(base_url() . 'staff/barang/lihat?id=' . $_GET['id']);
    }

    public function ganti_pic_detail()
    {
        if (!isset($_POST)) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/barang');
        }
        if (!isset($_POST['id_logistik'])) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/barang');
        }
        $this->load->model('logistik');
        $this->logistik->changePic($_POST['id_logistik'], $_FILES['file']);
        redirect(base_url() . 'staff/barang/lihat_detail');
    }

    public function lihat_detail()
    {
        $this->load->model('logistik');
        $logistik = $this->logistik->getBarang();
        $data = array(
            'logistik' => $logistik
        );
        $this->load->view('staff/detail_barang_view', $data);
    }

    public function in_barang() {
        if (!($_SESSION['bagian'] == 'Master Admin' || $_SESSION['email'] == 'ramang.purchase@ventour.co.id' || $_SESSION['email'] == 'qonita@ventour.co.id' || $_SESSION['email'] == 'ilham@ventour.co.id' || $_SESSION['email'] == 'sutan@ventour.co.id')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect(base_url() . 'staff/barang');
        }

        $this->load->model('logistik');
        $logistik = $this->logistik->getBarang($_GET['id']);
        $this->load->view('staff/barang_masuk_view', $logistik[0]);
    }

    public function proses_in_barang() {
        $this->form_validation->set_rules('id_logistik', 'id_logistik', 'trim|required|integer');
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'trim|required');
        $this->form_validation->set_rules('stok', 'stok', 'trim|required|integer');
        $this->form_validation->set_rules('barang_masuk', 'Barang Masuk', 'trim|required|integer');
        $this->form_validation->set_rules('note', 'Notes / Catatan', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect(base_url() . 'staff/barang/in_barang?id='.$_POST['id_logistik']);
        }

        if ($_POST['tempat'] == 'Gudang') {
            $logistik['stok'] = $_POST['stok'] + $_POST['barang_masuk'];
        }else if ($_POST['tempat'] == 'Bandung') {
            $logistik['stok_bandung'] = $_POST['stok'] + $_POST['barang_masuk'];
        } else {
            $logistik['stok_kantor'] = $_POST['stok'] + $_POST['barang_masuk'];
        }
        $this->load->model('logistik');
        $inBarang = $this->logistik->editbarang($_POST['id_logistik'], $logistik);

        // add mutasi
        $data = $_POST;
        $data['jumlah'] = $data['barang_masuk'];
        $data['stok_before'] = $data['stok'];
        $data['id_staff'] = $_SESSION['id_staff'];
        $data['id_agen'] = $_SESSION['id_agen'];
        $data['id_member'] = $_SESSION['id_member'];
        unset($data['barang_masuk']);
        unset($data['nama_barang']);
        unset($data['stok']);

        $mutasi = $this->logistik->addMutasi($data, $data['id_logistik']);
        if($mutasi != true) {
            $this->alert->set('danger', 'Barang gagal ditambah');
            redirect(base_url() . 'staff/barang');
        } else {
            $this->alert->set('success', 'Barang Berhasil ditambah');
            redirect(base_url() . 'staff/barang');
        }
    }

    public function out_barang() {
        if (!($_SESSION['bagian'] == 'Master Admin' || $_SESSION['email'] == 'ramang.purchase@ventour.co.id' || $_SESSION['email'] == 'qonita@ventour.co.id' || $_SESSION['email'] == 'ilham@ventour.co.id' || $_SESSION['email'] == 'sutan@ventour.co.id')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        if (!($_SESSION['bagian'] == 'Master Admin' || $_SESSION['email'] == 'ramang.purchase@ventour.co.id')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect(base_url() . 'staff/barang');
        }

        $this->load->model('logistik');
        $logistik = $this->logistik->getBarang($_GET['id']);
        $this->load->view('staff/barang_keluar_view', $logistik[0]);
    }

    public function proses_out_barang() {
        $this->form_validation->set_rules('id_logistik', 'id_logistik', 'trim|required|integer');
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'trim|required');
        $this->form_validation->set_rules('stok', 'stok', 'trim|required|integer');
        $this->form_validation->set_rules('barang_keluar', 'Barang Keluar', 'trim|required|integer');
        $this->form_validation->set_rules('note', 'Notes / Catatan', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect(base_url() . 'staff/barang/in_barang?id='.$_POST['id_logistik']);
        }
        
        if ($_POST['tempat'] == 'Gudang') {
            $logistik['stok'] = $_POST['stok'] - $_POST['barang_keluar'];
        } elseif ($_POST['tempat'] == 'Bandung') {
            $logistik['stok_bandung'] = $_POST['stok'] - $_POST['barang_keluar'];
        } else {
            $logistik['stok_kantor'] = $_POST['stok'] - $_POST['barang_keluar'];
        }
        
        $this->load->model('logistik');
        $inBarang = $this->logistik->editbarang($_POST['id_logistik'], $logistik);

        // add mutasi
        $data = $_POST;
        $data['jumlah'] = $data['barang_keluar'];
        $data['stok_before'] = $data['stok'];
        $data['id_staff'] = $_SESSION['id_staff'];
        $data['id_agen'] = $_SESSION['id_agen'];
        $data['id_member'] = $_SESSION['id_member'];
        unset($data['barang_keluar']);
        unset($data['nama_barang']);
        unset($data['stok']);

        // echo '<pre>';
        // print_r($data);
        // exit();
        $mutasi = $this->logistik->addMutasi($data, $data['id_logistik']);
        if($mutasi != true) {
            $this->alert->set('danger', 'Barang gagal ditambah');
            redirect(base_url() . 'staff/barang');
        } else {
            $this->alert->set('success', 'Barang Berhasil ditambah');
            redirect(base_url() . 'staff/barang');
        }
    }


    public function mutasi() {
        $this->load->model('logistik');
        if (isset($_GET['month'])) {
            $month = $_GET['month'];
        } else {
            $month = 0;
        }

        if (isset($_GET['id'])) {
            $id_logistik = $_GET['id'];
        } else {
            $id_logistik = null;
        }

        $this->load->library('Date');
        $nama_bulan = $this->date->getMonth($month);
        $mutasiMonth = $this->logistik->getMutasiMonth();
        $data = [
            "mutasiMonth" => $mutasiMonth,
            'month' => $month,
            'nama_bulan' => $nama_bulan,
            'id_logistik' => $id_logistik
        ];
        $this->load->view('staff/mutasi_view', $data);
    }

    public function hapus_mutasi()
    {
        if (!($_SESSION['email'] == 'ramang.purchase@ventour.co.id' || $_SESSION['email'] == 'sutan@ventour.co.id' || $_SESSION['bagian'] == 'Master Admin')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/barang/mutasi');
        }
        $this->load->model('logistik');
        $data = $this->logistik->deleteMutasi($_GET['id']);
        if ($data == true) {
            $this->alert->set('success', 'Daftar Mutasi Berhasil Dihapus');
        } else {
            $this->alert->set('danger', 'Daftar Mutasi Gagal Dihapus');
        }
        redirect(base_url() . 'staff/barang/mutasi');
    }

    public function load_mutasi()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'mutasi_barang';
        // Primary key of table
        $primaryKey = 'id_mutasi';

        $columns = array(
            array('db' => '`m`.`id_mutasi`', 'dt' => 'DT_RowId', 'field' => 'id_mutasi'),
            array('db' => '`m`.`id_logistik`', 'dt' => 'id_logistik', 'field' => 'id_logistik'),
            array('db' => '`m`.`id_paket`', 'dt' => 'id_paket', 'field' => 'id_paket'),
            array('db' => '`m`.`id_staff`', 'dt' => 'id_staff', 'field' => 'id_staff'),
            array('db' => '`m`.`id_perlmember`', 'dt' => 'id_perlmember', 'field' => 'id_perlmember'),
            array('db' => '`m`.`id_agen`', 'dt' => 'id_agen', 'field' => 'id_agen'),
            array('db' => '`m`.`id_member`', 'dt' => 'id_member', 'field' => 'id_member'),
            array('db' => '`m`.`jumlah`', 'dt' => 'jumlah', 'field' => 'jumlah'),
            array('db' => '`m`.`status`', 'dt' => 'status', 'field' => 'status'),
            array('db' => '`m`.`note`', 'dt' => 'note', 'field' => 'note'),
            array('db' => '`m`.`tanggal`', 'dt' => 'tanggal', 'field' => 'tanggal'),
            array('db' => '`m`.`tempat`', 'dt' => 'tempat', 'field' => 'tempat'),
            array('db' => '`l`.`nama_barang`', 'dt' => 'nama_barang', 'field' => 'nama_barang'),
            array('db' => '`m`.`stok_before`', 'dt' => 'stok_before', 'field' => 'stok_before'),
            array('db' => '`l`.`stok`', 'dt' => 'stok', 'field' => 'stok'),
            array('db' => '`l`.`stok_kantor`', 'dt' => 'stok_kantor', 'field' => 'stok_kantor'),
            array('db' => '`l`.`stok_unit`', 'dt' => 'stok_unit', 'field' => 'stok_unit'),
            array('db' => '`pu`.`nama_paket`', 'dt' => 'nama_paket', 'field' => 'nama_paket'),
            array('db' => '`pu`.`tanggal_berangkat`', 'dt' => 'tanggal_berangkat', 'field' => 'tanggal_berangkat'),
            array('db' => '`s`.`nama`', 'dt' => 'nama', 'field' => 'nama'),
            array('db' => '`a`.`nama_agen`', 'dt' => 'nama_agen', 'field' => 'nama_agen'),
            array('db' => '`j`.`first_name`', 'dt' => 'first_name', 'field' => 'first_name'),
            array('db' => '`j`.`second_name`', 'dt' => 'second_name', 'field' => 'second_name'),
            array('db' => '`j`.`last_name`', 'dt' => 'last_name', 'field' => 'last_name'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $joinQuery = "FROM `{$table}` AS `m`"
            . "JOIN `logistik` AS `l` ON (`l`.`id_logistik` = `m`.`id_logistik`)"
            . " LEFT JOIN `paket_umroh` AS `pu` ON (`pu`.`id_paket` = `m`.`id_paket`)"
            . " LEFT JOIN `staff` AS `s` ON (`s`.`id_staff` = `m`.`id_staff`)"
            . " LEFT JOIN `agen` AS `a` ON (`a`.`id_agen` = `m`.`id_agen`)"
            . " LEFT JOIN `program_member` AS `pm` ON (`pm`.`id_member` = `m`.`id_member`)"
            . " LEFT JOIN `jamaah` AS `j` ON (`j`.`id_jamaah` = `pm`.`id_jamaah`)";
        if (isset($_GET['month'])) {
            if ($_GET['month'] != 0 ) {
                $month = $_GET['month'];
                $extraCondition = "MONTH(tanggal) = $month ";
                if($_GET['id'] != null) {
                    $id_logistik = $_GET['id'];
                    $extraCondition = "`m`.`id_logistik` = $id_logistik AND MONTH(tanggal) = $month";
                } else {
                    $extraCondition = $extraCondition;
                }
            } else {
                $extraCondition = "";
                if($_GET['id'] != null) {
                    $id_logistik = $_GET['id'];
                    $extraCondition = "`m`.`id_logistik` = $id_logistik";
                } else {
                    $extraCondition = "";
                }
            }
        } else {
            $extraCondition = "";
        }

        if ($_GET['date_start'] == null && $_GET['date_end'] == null && $_GET['status'] == null && $_GET['tempat'] == null) {
            if ($extraCondition != "") {
                $condition = " AND `m`.`tanggal` >= CURDATE()";
            } else {
                $condition = "`m`.`tanggal` >= CURDATE()";
            }
            $extraCondition = $extraCondition . $condition;
        }

        if ($_GET['date_start'] != '') {
            $date_start = $_GET['date_start'];
            if ($extraCondition != "") {
                $condition = " AND m.tanggal >= '$date_start 00:00:00'";
            } else {
                $condition = " m.tanggal >= '$date_start 00:00:00'";
            }
            $extraCondition = $extraCondition . $condition;
        }
        if ($_GET['date_end'] != '') {
            $date_end = $_GET['date_end'];
            if ($extraCondition != "") {
                $condition = " AND m.tanggal <= '$date_end 23:59:59'";
            } else {
                $condition = " m.tanggal <= '$date_end 23:59:59'";
            }
            $extraCondition = $extraCondition . $condition;
        }

        if ($_GET['status'] != '') {
            $status = $_GET['status'];
            if ($extraCondition != "") {
                $condition = " AND m.status = '$status'";
            } else {
                $condition = " m.status = '$status'";
            }
            $extraCondition = $extraCondition . $condition;
        }

        if ($_GET['tempat'] != '') {
            $tempat = $_GET['tempat'];
            if ($extraCondition != "") {
                $condition = " AND m.tempat = '$tempat'";
            } else {
                $condition = " m.tempat = '$tempat'";
            }
            $extraCondition = $extraCondition . $condition;
        }
        
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition);

        foreach ($data['data'] as $key => $dt) {
            if ($dt['status'] == 'masuk') {
                $data['data'][$key]['stok_after'] = $dt['stok_before'] + $dt['jumlah'];
                $data['data'][$key]['status_in'] = $dt['jumlah'];
                $data['data'][$key]['status_out'] = 0;
            }
            
            if ($dt['status'] == 'keluar') {
                $data['data'][$key]['stok_after'] = $dt['stok_before'] - $dt['jumlah'];
                $data['data'][$key]['status_out'] = $dt['jumlah'];
                $data['data'][$key]['status_in'] = 0;
            }
            
            if ($dt['tempat'] == null || $dt['tempat'] == '') {
                $data['data'][$key]['tempat'] = 'Kantor';
            }

            if ($dt['id_staff'] != NULL) {
                $data['data'][$key]['nama_penginput'] = $dt['nama'];
            }

            if ($dt['id_agen'] != NULL) {
                $data['data'][$key]['nama_penginput'] = $dt['nama_agen'];
            }

            if ($dt['id_member'] != NULL) {
                $data['data'][$key]['nama_penginput'] = $dt['first_name'] . " " . $dt['second_name'] . " " . $dt['last_name'];
            }

            // if ($dt['id_perlmember'] != null && $dt['id_perlmember'] != 0) {
            //     $this->db->where('id_perlmember', $dt['id_perlmember']);
            //     $data = $this->db->get('perlengkapan_member')->row();

            //     $this->load->model('registrasi');
            //     $jamaah = $this->registrasi->getJamaah(null, null, $data->id_member);
            //     $nama = implode(' ', array_filter([$jamaah->first_name, $jamaah->second_name, $jamaah->last_name]));

            //     if ($dt['note'] == null) {
            //         $data['data'][$key]['note'] = "$nama pending booking";
            //     }
            // }
        }
        echo json_encode($data);
    }

    public function transfer() {
        if (!($_SESSION['bagian'] == 'Master Admin' || $_SESSION['email'] == 'sutan@ventour.co.id' || $_SESSION['email'] == 'ramang.purchase@ventour.co.id' || $_SESSION['email'] == 'qonita@ventour.co.id' || $_SESSION['email'] == 'ilham@ventour.co.id')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect(base_url() . 'staff/barang');
        }

        $this->load->model('logistik');
        $logistik = $this->logistik->getBarang($_GET['id']);
        $this->load->view('staff/transfer_barang_view', $logistik[0]);
    }

    public function proses_transfer() {
        $this->form_validation->set_rules('id_logistik', 'id_logistik', 'trim|required|integer');
        $this->form_validation->set_rules('tempat_dari', 'Barang Asal', 'trim|required');
        $this->form_validation->set_rules('tempat_ke', 'Tempat Tujuan', 'trim|required');
        $this->form_validation->set_rules('jumlah', 'Jumlah Barang', 'trim|required|integer');
        $this->form_validation->set_rules('note', 'Keterangan', 'trim|required');

        $stock_gudang = $_POST['stok'] - $_POST['jumlah'];
        $stock_kantor = $_POST['stok_kantor'] - $_POST['jumlah'];
        // echo '<pre>';
        // print_r($stock_kantor);
        // exit();
        
        if ($_POST['tempat_dari'] == 'Gudang' && $_POST['tempat_ke'] == 'Kantor') {
            if ($stock_gudang < 0) {
                $this->alert->set('danger', 'Jumlah yang diminta melebihi stok yang tersedia.');
                redirect(base_url() . 'staff/barang/transfer?id=' . $_POST['id_logistik']);
                return; 
            }
        } else if ($_POST['tempat_dari'] == 'Gudang' && $_POST['tempat_ke'] == 'Bandung') {
            if ($stock_gudang < 0) {
                $this->alert->set('danger', 'Jumlah yang diminta melebihi stok yang tersedia.');
                redirect(base_url() . 'staff/barang/transfer?id=' . $_POST['id_logistik']);
                return; 
            }
        } else if ($_POST['tempat_dari'] == 'Kantor' && $_POST['tempat_ke'] == 'Bandung') {
            if ($stock_kantor < 0) {
                $this->alert->set('danger', 'Jumlah yang diminta melebihi stok yang tersedia.');
                redirect(base_url() . 'staff/barang/transfer?id=' . $_POST['id_logistik']);
                return; 
            }
        } else {
            if ($stock_kantor < 0) {
                $this->alert->set('danger', 'Jumlah yang diminta melebihi stok yang tersedia.');
                redirect(base_url() . 'staff/barang/transfer?id=' . $_POST['id_logistik']);
                return; 
            }
        }
        
        // if (($_POST['stok_kantor'] - $_POST['jumlah']) < 0) {
        //     $this->alert->set('danger', 'Jumlah yang diminta melebihi stok yang tersedia.');
        //     redirect(base_url() . 'staff/barang/transfer?id=' . $_POST['id_logistik']);
        //     return; 
        // }

        // if ($this->form_validation->run() == FALSE) {
        //     $this->alert->set('danger', validation_errors());
        //     redirect(base_url() . 'staff/barang/transfer?id='.$_POST['id_logistik']);
        // }

        $this->load->model('logistik');
        $barang = $this->logistik->getBarang($_POST['id_logistik']);
        if ($_POST['tempat_dari'] == 'Gudang' && $_POST['tempat_ke'] == 'Kantor') {
            $logistik['stok'] = $barang[0]->stok - $_POST['jumlah'];
            $logistik['stok_kantor'] = $barang[0]->stok_kantor + $_POST['jumlah'];
        } else if ($_POST['tempat_dari'] == 'Gudang' && $_POST['tempat_ke'] == 'Bandung') {
            $logistik['stok'] = $barang[0]->stok - $_POST['jumlah'];
            $logistik['stok_bandung'] = $barang[0]->stok_bandung + $_POST['jumlah'];
        } else if ($_POST['tempat_dari'] == 'Bandung' && $_POST['tempat_ke'] == 'Gudang') {
            $logistik['stok_bandung'] = $barang[0]->stok_bandung - $_POST['jumlah'];
            $logistik['stok'] = $barang[0]->stok + $_POST['jumlah'];
        } else if ($_POST['tempat_dari'] == 'Bandung' && $_POST['tempat_ke'] == 'Kantor') {
            $logistik['stok_bandung'] = $barang[0]->stok_bandung - $_POST['jumlah'];
            $logistik['stok_kantor'] = $barang[0]->stok_kantor + $_POST['jumlah'];
        } else if ($_POST['tempat_dari'] == 'Kantor' && $_POST['tempat_ke'] == 'Bandung') {
            $logistik['stok_kantor'] = $barang[0]->stok_kantor - $_POST['jumlah'];
            $logistik['stok_bandung'] = $barang[0]->stok_bandung + $_POST['jumlah'];
        } else {
            $logistik['stok'] = $barang[0]->stok + $_POST['jumlah'];
            $logistik['stok_kantor'] = $barang[0]->stok_kantor - $_POST['jumlah'];
        }

        $this->logistik->editbarang($_POST['id_logistik'], $logistik);

        //add mutasi
        if ($_POST['tempat_dari'] == 'Gudang' && $_POST['tempat_ke'] == 'Kantor') {
            $out_gudang = [
                'id_logistik' => $_POST['id_logistik'],
                'stok_before' => $_POST['stok'],
                'status' => 'keluar',
                'tempat' => $_POST['tempat_dari'],
                'jumlah' => $_POST['jumlah'],
                'note' => $_POST['note'],
                'id_staff' => $_SESSION['id_staff'],
            ];
            $mutasi_out_gudang = $this->logistik->addMutasi($out_gudang, $out_gudang['id_logistik']);

            $in_kantor = [
                'id_logistik' => $_POST['id_logistik'],
                'stok_before' => $_POST['stok_kantor'],
                'status' => 'masuk',
                'tempat' => $_POST['tempat_ke'],
                'jumlah' => $_POST['jumlah'],
                'note' => $_POST['note'],
                'id_staff' => $_SESSION['id_staff'],
            ];
            $mutasi_in_kantor = $this->logistik->addMutasi($in_kantor, $in_kantor['id_logistik']);

        } else if ($_POST['tempat_dari'] == 'Gudang' && $_POST['tempat_ke'] == 'Bandung') {
            $out_gudang = [
                'id_logistik' => $_POST['id_logistik'],
                'stok_before' => $_POST['stok'],
                'status' => 'keluar',
                'tempat' => $_POST['tempat_dari'],
                'jumlah' => $_POST['jumlah'],
                'note' => $_POST['note'],
                'id_staff' => $_SESSION['id_staff'],
            ];
            $mutasi_out_gudang = $this->logistik->addMutasi($out_gudang, $out_gudang['id_logistik']);

            $in_bandung = [
                'id_logistik' => $_POST['id_logistik'],
                'stok_before' => $_POST['stok_bandung'],
                'status' => 'masuk',
                'tempat' => $_POST['tempat_ke'],
                'jumlah' => $_POST['jumlah'],
                'note' => $_POST['note'],
                'id_staff' => $_SESSION['id_staff'],
            ];
            $mutasi_in_bandung = $this->logistik->addMutasi($in_bandung, $in_bandung['id_logistik']);

        } else if ($_POST['tempat_dari'] == 'Kantor' && $_POST['tempat_ke'] == 'Bandung') {
            $out_kantor = [
                'id_logistik' => $_POST['id_logistik'],
                'stok_before' => $_POST['stok_kantor'],
                'status' => 'keluar',
                'tempat' => $_POST['tempat_dari'],
                'jumlah' => $_POST['jumlah'],
                'note' => $_POST['note'],
                'id_staff' => $_SESSION['id_staff'],
            ];
            $mutasi_out_kantor = $this->logistik->addMutasi($out_kantor, $out_kantor['id_logistik']);

            $in_bandung = [
                'id_logistik' => $_POST['id_logistik'],
                'stok_before' => $_POST['stok_bandung'],
                'status' => 'masuk',
                'tempat' => $_POST['tempat_ke'],
                'jumlah' => $_POST['jumlah'],
                'note' => $_POST['note'],
                'id_staff' => $_SESSION['id_staff'],
            ];
            $mutasi_in_bandung = $this->logistik->addMutasi($in_bandung, $in_bandung['id_logistik']);

        } else if ($_POST['tempat_dari'] == 'Bandung' && $_POST['tempat_ke'] == 'Kantor') {
            $out_bandung = [
                'id_logistik' => $_POST['id_logistik'],
                'stok_before' => $_POST['stok_bandung'],
                'status' => 'keluar',
                'tempat' => $_POST['tempat_dari'],
                'jumlah' => $_POST['jumlah'],
                'note' => $_POST['note'],
                'id_staff' => $_SESSION['id_staff'],
            ];
            $mutasi_out_bandung = $this->logistik->addMutasi($out_bandung, $out_bandung['id_logistik']);

            $in_kantor = [
                'id_logistik' => $_POST['id_logistik'],
                'stok_before' => $_POST['stok_kantor'],
                'status' => 'masuk',
                'tempat' => $_POST['tempat_ke'],
                'jumlah' => $_POST['jumlah'],
                'note' => $_POST['note'],
                'id_staff' => $_SESSION['id_staff'],
            ];
            $mutasi_in_kantor = $this->logistik->addMutasi($in_kantor, $in_kantor['id_logistik']);

        } else if ($_POST['tempat_dari'] == 'Bandung' && $_POST['tempat_ke'] == 'Gudang') {
            $out_bandung = [
                'id_logistik' => $_POST['id_logistik'],
                'stok_before' => $_POST['stok_bandung'],
                'status' => 'keluar',
                'tempat' => $_POST['tempat_dari'],
                'jumlah' => $_POST['jumlah'],
                'note' => $_POST['note'],
                'id_staff' => $_SESSION['id_staff'],
            ];
            $mutasi_out_bandung = $this->logistik->addMutasi($out_bandung, $out_bandung['id_logistik']);

            $in_gudang = [
                'id_logistik' => $_POST['id_logistik'],
                'stok_before' => $_POST['stok'],
                'status' => 'masuk',
                'tempat' => $_POST['tempat_ke'],
                'jumlah' => $_POST['jumlah'],
                'note' => $_POST['note'],
                'id_staff' => $_SESSION['id_staff'],
            ];
            $mutasi_in_gudang = $this->logistik->addMutasi($in_gudang, $in_gudang['id_logistik']);

        } else {
            $in_gudang = [
                'id_logistik' => $_POST['id_logistik'],
                'stok_before' => $_POST['stok'],
                'status' => 'masuk',
                'tempat' => $_POST['tempat_dari'],
                'jumlah' => $_POST['jumlah'],
                'note' => $_POST['note'],
                'id_staff' => $_SESSION['id_staff'],
            ];
            $mutasi_in_gudang = $this->logistik->addMutasi($in_gudang, $in_gudang['id_logistik']);

            $out_kantor = [
                'id_logistik' => $_POST['id_logistik'],
                'stok_before' => $_POST['stok_kantor'],
                'status' => 'keluar',
                'tempat' => $_POST['tempat_ke'],
                'jumlah' => $_POST['jumlah'],
                'note' => $_POST['note'],
                'id_staff' => $_SESSION['id_staff'],
            ];
            $mutasi_out_kantor = $this->logistik->addMutasi($out_kantor, $out_kantor['id_logistik']);
        }

        if($mutasi_in_gudang != true && $mutasi_in_kantor != true && $mutasi_out_gudang != true && $mutasi_out_kantor != true && $mutasi_in_bandung != true && $mutasi_out_bandung != true) {
            $this->alert->set('danger', 'Barang gagal ditambah');
            redirect(base_url() . 'staff/barang');
        } else {
            $this->alert->set('success', 'Barang Berhasil ditambah');
            redirect(base_url() . 'staff/barang');
        }
    }
}