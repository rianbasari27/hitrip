<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Perlengkapan_office extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }
        $this->load->model('logistik_office');
        //this page only for admin
        if (!($_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == "Logistik")) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
    }
    public function index(){
        $listJenis = $this->logistik_office->getListJenis();
        $this->load->view('staff/barang_office', $data = [ "listJenis" => $listJenis]);

    }

    public function load_barang() {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'barang_perlengkapan_office';
        // Primary key of table
        $primaryKey = 'id_barang';
        $columns = array(
            array('db' => 'id_barang', 'dt' => 'DT_RowId', 'field' => 'id_barang'),
            array('db' => 'nama', 'dt' => 'nama', 'field' => 'nama'),            
            array('db' => 'jenis', 'dt' => 'jenis', 'field' => 'jenis'),
            array('db' => 'stock', 'dt' => 'stock', 'field' => 'stock'),
            array('db' => 'status', 'dt' => 'status', 'field' => 'status'),
            array('db' => 'foto_status', 'dt' => 'foto_status', 'field' => 'foto_status'),
            array('db' => 'keterangan', 'dt' => 'keterangan', 'field' => 'keterangan'),
            array('db' => 'lokasi', 'dt' => 'lokasi', 'field' => 'lokasi'),
            array('db' => 'satuan', 'dt' => 'satuan', 'field' => 'satuan'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        // $joinQuery = "FROM `{$table}` AS `byr`"
        //     . "JOIN `program_member` AS `pm` ON (`byr`.`id_member` = `pm`.`id_member`)";

        if ($_GET['jenis'] != '') {
            $jenis = $_GET['jenis'];
            $extraCondition = "jenis = '$jenis'";
        } else {
            $extraCondition = "";
        }
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, null, $extraCondition);

        foreach ($data['data'] as $key => $d) {
            // $data['data'][$key]['DT_RowAttr'] = array(
            //     'id_perlkantor' => $d['id_perlkantor']
            // );

            $list = '';
            $dataRequest = $this->logistik_office->getBarangDiPinjam($d['DT_RowId']);
            if (!empty($dataRequest)) {
                foreach ($dataRequest as $r) {
                    $this->load->model('staff');
                    $request = $this->staff->getStaff($r->id_staff_request);
                    if ($request) {
                        $nama_staff = $request->nama;
                    } else {
                        $nama_staff = '';
                    }
                    $list .= "- {$nama_staff} ({$r->tempat})\n";
                }
            }

            $data['data'][$key]['pemegang'] = $list;
        }
        echo json_encode($data);
    }

    public function tambah()
    {
        $this->load->view('staff/tambah_barang_office');
    }

    public function proses_tambah()
    {   
        $this->form_validation->set_rules('nama', 'Nama Barang', 'trim|required');
        $this->form_validation->set_rules('stock', 'Jumlah', 'trim|required');
        if ($this->form_validation->run() == FALSE ) {
            $this->alert->set('danger', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        }

        if (!empty($_FILES['foto_status']['name'])) {
            $_POST['foto_status'] = $_FILES['foto_status'];
        }
        
        $_POST['harga'] = str_replace(',','', $_POST['harga']);
        $data = $this->logistik_office->addBarangOffice($_POST);
        if ($data == false) {
            $this->alert->set('danger', 'Barang gagal Ditambahkan');
        } else {
            $this->alert->set('success', 'Barang berhasil Ditambahkan');
        }
        redirect(base_url() . 'staff/perlengkapan_office');
    }

    public function request() {
        $barang = null ;
        if (isset($_GET['id'])) {
            $this->form_validation->set_data($this->input->get());
            $this->form_validation->set_rules('id', 'id', 'trim|required');
            if ($this->form_validation->run() == FALSE ) {
                $this->alert->set('danger', 'Access Denied!');
                redirect($_SERVER['HTTP_REFERER']);
            }

            $barang = $this->logistik_office->getBarangOffice($_GET['id']);
        }

        if ($barang == null) {
            $action = base_url() . "staff/perlengkapan_office/proses_request_baru";
        } else {
            $action = base_url() . "staff/perlengkapan_office/proses_request";
        }

        $data = [
            'barang' => $barang,
            'action' => $action
        ];

        $this->load->view('staff/request_barang_office', $data);
    }

    public function proses_request_baru()
    {   
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('stock', 'Jumlah', 'trim|required');
        if ($this->form_validation->run() == FALSE ) {
            $this->alert->set('danger', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        }

        $result = $this->logistik_office->addRequestOrder($_POST, "baru", "Request");
        if (!$result) {
            $this->alert->set('danger', 'Request barang gagal');
        } else {
            $this->alert->set('success', 'Request barang berhasil');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function proses_request()
    {   
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('stock', 'Jumlah', 'trim|required');
        if ($this->form_validation->run() == FALSE ) {
            $this->alert->set('danger', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        }

        $result = $this->logistik_office->addRequestOrder($_POST, "lama", "Request");
        if (!$result) {
            $this->alert->set('danger', 'Request barang gagal');
        } else {
            $this->alert->set('success', 'Request barang berhasil');
        }
        redirect(base_url() . 'staff/perlengkapan_office');
    }

    public function minta() {
        $barang = null ;
        if (isset($_GET['id'])) {
            $this->form_validation->set_data($this->input->get());
            $this->form_validation->set_rules('id', 'id', 'trim|required');
            if ($this->form_validation->run() == FALSE ) {
                $this->alert->set('danger', 'Access Denied!');
                redirect($_SERVER['HTTP_REFERER']);
            }

            $barang = $this->logistik_office->getBarangOffice($_GET['id']);
        }

        $action = base_url() . "staff/perlengkapan_office/proses_minta";

        $data = [
            'barang' => $barang,
            'action' => $action
        ];

        $this->load->view('staff/minta_barang_office', $data);
    }

    public function proses_minta()
    {   
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('stock', 'Jumlah', 'trim|required');
        if ($this->form_validation->run() == FALSE ) {
            $this->alert->set('danger', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        }

        $result = $this->logistik_office->addRequestOrder($_POST, "lama", "Permintaan");
        if (!$result) {
            $this->alert->set('danger', 'Permintaan barang gagal');
        } else {
            $this->alert->set('success', 'Permintaan barang berhasil');
        }
        redirect(base_url() . 'staff/perlengkapan_office');
    }

    public function ubah() 
    {
        $data = $this->logistik_office->getBarangOffice($_GET['id']);
        $this->load->view('staff/edit_barang_office', $data[0]);
    }

    public function proses_ubah()
    {
        $this->form_validation->set_rules('id_barang', 'id', 'trim|required');
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('stock', 'Jumlah', 'trim|required');
        if ($this->form_validation->run() == FALSE ) {
            $this->alert->set('danger', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        }

        $_POST['harga'] = str_replace(',','', $_POST['harga']);
        $update = $this->logistik_office->updateBarangOffice($_POST);
        if (!$update) {
            $this->alert->set('danger', 'Barang gagal Di Ubah');
        } else {
            $this->alert->set('success', 'Barang berhasil Di Ubah');
        }

        redirect(base_url() . 'staff/perlengkapan_office/lihat?id='. $_POST['id_barang']);
    }

    public function lihat() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required');
        if ($this->form_validation->run() == FALSE ) {
            $this->alert->set('danger', 'Access Denied!');
            redirect($_SERVER['HTTP_REFERER']);
        }

        
        $barang = $this->logistik_office->getBarangOffice($_GET['id']);
        $data = [
            "barang" => $barang[0]
        ];
        $this->load->view('staff/lihat_barang_office', $data);
    }

    public function upload_image()
    {

        if($this->logistik_office->uploadGambarStatus($_FILES, $_POST['id'])) {
            $this->alert->set('success', 'Gambar berhasil di upload') ;
        } else {
            $this->alert->set('danger', 'Gambar gagal di upload') ;
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_image()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/perlengkapan_office');
        }

        $result = $this->logistik_office->deleteGambarStatus($_GET['id']);
        if ($result) {
            $this->alert->set('success', "Gambar berhasil dihapus");
        } else {
            $this->alert->set('danger', "Gambar gagal dihapus");
        }
        redirect(base_url() . 'staff/perlengkapan_office/lihat?id=' . $_GET['id']);
    }

    public function in_barang() {
        $data = $this->logistik_office->getBarangOffice($_GET['id']);
        $this->load->view("staff/barang_masuk_office_view", $data[0]);
    }

    public function proses_in_barang() {
        $this->form_validation->set_rules('id_barang', 'id_barang', 'trim|required|integer');
        $this->form_validation->set_rules('jumlah', 'jumlah', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }

        // tambah kedalam tabel order_perlengkapan_office
        $add = $this->logistik_office->addOrderPerlengkapanOffice($_POST);
        if (!$add) {
            $this->alert->set('danger', 'IN Barang gagal!');
            redirect($_SERVER['HTTP_REFERER']);
        }

        //update stok barang
        $updateStock = $this->logistik_office->setStokBarangOffice($_POST['id_barang'], $_POST['jumlah']);
        if ($updateStock['type'] == "danger") {
            $this->alert->set("$updateStock[type]", "$updateStock[msg]");
            redirect($_SERVER['HTTP_REFERER']);
        }

        //jika success
        $this->alert->set('success', 'Proses IN barang berhasil, stok bertambah');
        redirect(base_url() . 'staff/perlengkapan_office');
    }

    public function out_barang() {
        $data = $this->logistik_office->getBarangOffice($_GET['id']);
        $this->load->view("staff/barang_keluar_office_view", $data[0]);
    }

    public function proses_out_barang() {
        $this->form_validation->set_rules('id_barang', 'id_barang', 'trim|required|integer');
        $this->form_validation->set_rules('jumlah', 'jumlah', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $barang = $this->logistik_office->getBarangOffice($_POST['id_barang']);
        $stok_before = $barang[0]->stock;

        $_POST['stok_before'] = $stok_before;

        //update stok barang
        $updateStock = $this->logistik_office->setStokBarangOffice($_POST['id_barang'], $_POST['jumlah'], "kurang");
        if ($updateStock['type'] == "danger") {
            $this->alert->set("$updateStock[type]", "$updateStock[msg]");
            redirect($_SERVER['HTTP_REFERER']);
        }

        // tambah kedalam tabel order_perlengkapan_office
        if ($updateStock) {
            $add = $this->logistik_office->addKeluarPerlengkapanOffice($_POST);
            if (!$add) {
                $this->alert->set('danger', 'OUT Barang gagal!');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }

        //jika success
        $this->alert->set('success', 'Proses OUT barang berhasil, stok berkurang');
        redirect(base_url() . 'staff/perlengkapan_office');
    }


    public function pinjam(){
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $barang = $this->logistik_office->getBarangOffice($_GET['id']);

        $this->load->model('staff');
        $staff = $this->staff->getUser();
        $data = [
            'staff'=>$staff, 
            'barang'=>$barang[0]
        ];
        $this->load->view('staff/pinjam_barang', $data);
    }
    public function proses_pinjam()
    {              
        $this->form_validation->set_rules('id_barang', 'id_barang', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $_POST['tanggal_request'] = date('Y-m-d H:i:s', strtotime($_POST['tanggal_request']));
        $add = $this->logistik_office->addRequestPinjamPerlengkapanOffice($_POST);
        if ($add['type'] == "danger") {
            $this->alert->set("$add[type]", "$add[msg]");
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->alert->set('success', 'Peminjaman Barang Berhasil');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function list_request() {
        $statusRequest = $this->logistik_office->getStatusRequest();
        $this->load->view('staff/list_request_office_view', $data = [ "statusRequest" => $statusRequest]);
    }

    public function load_request() {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'request_order_perlengkapan_office';
        // Primary key of table
        $primaryKey = 'id_req_order';
        $columns = array(
            array('db' => '`ropo`.`id_req_order`', 'dt' => 'DT_RowId', 'field' => 'id_req_order'),
            array('db' => '`bpo`.`id_barang`', 'dt' => 'id_barang', 'field' => 'id_barang'),
            array('db' => 'bpo.nama AS nama_barang', 'dt' => 'nama', 'field' => 'nama_barang'),      
            array('db' => '`bpo`.`jenis`', 'dt' => 'jenis', 'field' => 'jenis'),
            array('db' => '`bpo`.`stock`', 'dt' => 'stock', 'field' => 'stock'),
            array('db' => '`bpo`.`status`', 'dt' => 'status', 'field' => 'status'),
            array('db' => '`bpo`.`foto_status`', 'dt' => 'foto_status', 'field' => 'foto_status'),
            array('db' => '`bpo`.`keterangan`', 'dt' => 'keterangan', 'field' => 'keterangan'),
            array('db' => '`ropo`.`jumlah`', 'dt' => 'jumlah', 'field' => 'jumlah'),
            array('db' => '`ropo`.`tanggal`', 'dt' => 'tanggal', 'field' => 'tanggal'),
            array('db' => '`ropo`.`id_staff_request`', 'dt' => 'id_staff_request', 'field' => 'id_staff_request'),
            array('db' => '`ropo`.`keterangan_tambahan`', 'dt' => 'keterangan_tambahan', 'field' => 'keterangan_tambahan'),
            array('db' => '`ropo`.`info`', 'dt' => 'info', 'field' => 'info'),
            array('db' => '`ropo`.`status_request`', 'dt' => 'status_request', 'field' => 'status_request'),
            array('db' => '`ropo`.`divisi`', 'dt' => 'divisi', 'field' => 'divisi'),
            array('db' => 's.nama AS nama_staff', 'dt' => 'nama_staff', 'field' => 'nama_staff')
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $joinQuery = "FROM `{$table}` AS `ropo`"
            . "JOIN `barang_perlengkapan_office` AS `bpo` ON (`bpo`.`id_barang` = `ropo`.`id_barang`)"
            . " LEFT JOIN `staff` AS `s` ON (`s`.`id_staff` = `ropo`.`id_staff_request`)";

        if ($_GET['status_request'] != '') {
            $status_request = $_GET['status_request'];
            $extraCondition = "status_request = '$status_request'";
        } else {
            $extraCondition = "";
        }
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition);
        foreach ($data['data'] as $key => $d) {
            // $data['data'][$key]['DT_RowAttr'] = array(
            //     'id_perlkantor' => $d['id_perlkantor']
            // );

            if ($d['status_request'] == 0 ) {
                $status = "Belum Di Order";
            } else if ($d['status_request'] == 1) {
                $status = "Sudah Di Order";
            } else if ($d['status_request'] == 2) {
                $status = "Belum Di Acc";
            } else if ($d['status_request'] == 3) {
                $status = "Sudah Di Acc";
            }

            $data['data'][$key]['status'] = $status;
        }
        echo json_encode($data);
    }

    public function order() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $orderRequest = $this->logistik_office->getRequestPerlengkapanOrder($_GET['id']);
        $orderRequest = $orderRequest[0];

        $dataOrder = [
            "id_barang" => $orderRequest->id_barang,
            "jumlah" => $orderRequest->jumlah,
            "id_staff_order" => $_SESSION['id_staff'],
            "id_request_order" => $orderRequest->id_req_order,
        ];

        $add = $this->logistik_office->addOrderPerlengkapanOffice($dataOrder);
        if (!$add) {
            $this->alert->set('danger', 'Order Request Barang gagal!');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $updateStock = $this->logistik_office->setStokBarangOffice($dataOrder['id_barang'], $dataOrder['jumlah']);
        if ($updateStock['type'] == "danger") {
            $this->alert->set("$updateStock[type]", "$updateStock[msg]");
            redirect($_SERVER['HTTP_REFERER']);
        }

        //ganti status di tabel request
        $setStatusRequest = $this->logistik_office->setStatusRequest($dataOrder['id_request_order'], 1);

        //jika success
        $this->alert->set('success', 'Proses Order barang berhasil, stok bertambah');
        redirect(base_url() . 'staff/perlengkapan_office');
    }

    public function terima() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $orderRequest = $this->logistik_office->getRequestPerlengkapanOrder($_GET['id']);
        $orderRequest = $orderRequest[0];

        $dataOrder = [
            "id_barang" => $orderRequest->id_barang,
            "jumlah" => $orderRequest->jumlah,
            "id_staff_order" => $_SESSION['id_staff'],
            "id_request_order" => $orderRequest->id_req_order,
        ];

        $add = $this->logistik_office->addOrderPerlengkapanOffice($dataOrder, "kurang");
        if ($add == false) {
            $this->alert->set('danger', 'Order Request Barang gagal!');
            redirect($_SERVER['HTTP_REFERER']);
        } else if ($add['type'] == "danger") {
            $this->alert->set("$add[type]", "$add[msg]");
            redirect($_SERVER['HTTP_REFERER']);
        }

        $updateStock = $this->logistik_office->setStokBarangOffice($dataOrder['id_barang'], $dataOrder['jumlah'], "kurang");
        if ($updateStock['type'] == "danger") {
            $this->alert->set("$updateStock[type]", "$updateStock[msg]");
            redirect($_SERVER['HTTP_REFERER']);
        }

        //ganti status di tabel request
        $setStatusRequest = $this->logistik_office->setStatusRequest($dataOrder['id_request_order'], 3);

        //jika success
        $this->alert->set('success', 'Proses Order barang berhasil, stok bertambah');
        redirect(base_url() . 'staff/perlengkapan_office');
    }

    public function list_pinjam() {
        $statusRequest = $this->logistik_office->getStatusRequest();
        $this->load->view('staff/list_pinjam_office_view', $data = [ "statusRequest" => $statusRequest]);
    }

    public function load_pinjam() {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'request_pinjam_perlengkapan_office';
        // Primary key of table
        $primaryKey = 'id_req_pinjam';
        $columns = array(
            array('db' => '`rppo`.`id_req_pinjam`', 'dt' => 'DT_RowId', 'field' => 'id_req_pinjam'),
            array('db' => '`rppo`.`id_barang`', 'dt' => 'id_barang', 'field' => 'id_barang'),
            array('db' => '`rppo`.`jumlah_request`', 'dt' => 'jumlah_request', 'field' => 'jumlah_request'),
            array('db' => '`rppo`.`tanggal_request`', 'dt' => 'tanggal_request', 'field' => 'tanggal_request'),
            array('db' => '`rppo`.`tempat`', 'dt' => 'tempat', 'field' => 'tempat'),
            array('db' => '`rppo`.`id_staff_request`', 'dt' => 'id_staff_request', 'field' => 'id_staff_request'),
            array('db' => '`rppo`.`jumlah_approve`', 'dt' => 'jumlah_approve', 'field' => 'jumlah_approve'),
            array('db' => '`rppo`.`tanggal_approve`', 'dt' => 'tanggal_approve', 'field' => 'tanggal_approve'),
            array('db' => '`rppo`.`id_staff_approval`', 'dt' => 'id_staff_approval', 'field' => 'id_staff_approval'),
            array('db' => '`rppo`.`status`', 'dt' => 'status', 'field' => 'status'),
            array('db' => '`rppo`.`nama_peminjam`', 'dt' => 'nama_peminjam', 'field' => 'nama_peminjam'),
            array('db' => '`rppo`.`keperluan`', 'dt' => 'keperluan', 'field' => 'keperluan'),
            array('db' => '`rppo`.`lama_pinjam`', 'dt' => 'lama_pinjam', 'field' => 'lama_pinjam'),
            array('db' => 'bpo.nama AS nama_barang', 'dt' => 'nama', 'field' => 'nama_barang'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );

        $joinQuery = "FROM `{$table}` AS `rppo`"
        . "JOIN `barang_perlengkapan_office` AS `bpo` ON (`bpo`.`id_barang` = `rppo`.`id_barang`)";
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery);
        foreach ($data['data'] as $key => $d) {
            // $data['data'][$key]['DT_RowAttr'] = array(
            //     'id_perlkantor' => $d['id_perlkantor']
            // );

            $this->load->model('staff');
            $request = $this->staff->getStaff($d['id_staff_request']);
            if ($request) {
                $data['data'][$key]['nama_staff_request'] = $request->nama;
            } else {
                $data['data'][$key]['nama_staff_request'] = '';
            }

            $approval = $this->staff->getStaff($d['id_staff_approval']);
            if ($approval) {
                $data['data'][$key]['nama_staff_approval'] = $approval->nama;
            } else {
                $data['data'][$key]['nama_staff_approval'] = '';
            }

            if ($d['status'] == 0) {
                $data['data'][$key]['status_pinjam'] = "Ga di Approve";
            } else if ($d['status'] == 1) {
                $data['data'][$key]['status_pinjam'] = "Masih Request";
            } else if ($d['status'] == 2) {
                $data['data'][$key]['status_pinjam'] = "Sudah Di Serahkan";
            } else if ($d['status'] == 3) {
                $data['data'][$key]['status_pinjam'] = "Sudah Dikembalikan Sebagian";
            } else if ($d['status'] == 4) {
                $data['data'][$key]['status_pinjam'] = "Sudah Dikembalikan Seluruhnya";
            }

            $jumlah_dikembalikan = '';
            $sudahDikembalikan = $this->logistik_office->getSumKembaliPerlengkapan($d['DT_RowId']);
            if (!empty($sudahDikembalikan)) {
                $jumlah_dikembalikan = $sudahDikembalikan;
            }

            $data['data'][$key]['jumlah_dikembalikan'] = $jumlah_dikembalikan;
        }
        echo json_encode($data);
    }

    public function serahkan_barang() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied.');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $requestPinjam = $this->logistik_office->getRequestPinjamPerlengkapanOffice($_GET['id']);
        if (!$requestPinjam) {
            $this->alert->set('danger', 'Access Denied.');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $barang = $this->logistik_office->getBarangOffice($requestPinjam[0]->id_barang);
        if (!$barang) {
            $this->alert->set('danger', 'Access Denied.');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->model('staff');
        $staff = $this->staff->getStaff($requestPinjam[0]->id_staff_request);
        if (!$staff) {
            $this->alert->set('danger', 'Nama Peminjam tidak ada ');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $data = [
            "requestPinjam" => $requestPinjam[0],
            "barang" => $barang[0],
            "staff" => $staff
        ];

        $this->load->view('staff/serahkan_barang_view', $data);
    }

    public function proses_serah() {
        $this->form_validation->set_rules('id_req_pinjam', 'id_req_pinjam', 'trim|required|integer');
        $this->form_validation->set_rules('id_barang', 'id_barang', 'trim|required|integer');
        $this->form_validation->set_rules('jumlah_approve', 'jumlah_approve', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        }

        $result = $this->logistik_office->updateRequestPinjamPerlengkapanOffice($_POST);
        if ($result['type'] == "danger") {
            $this->alert->set("$result[type]", "$result[msg]");
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->alert->set("success", "Barang telah diserahkan");
        redirect(base_url() . "staff/perlengkapan_office/list_pinjam");
    }

    public function proses_tolak() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        }

        $result = $this->logistik_office->setStatusPinjam($_GET['id'], 0);
        if (!$result) {
            $this->alert->set("danger", "Access Denied");
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->alert->set("success", "Request peminjaman berhasil ditolak");
        redirect(base_url() . "staff/perlengkapan_office/list_pinjam");
    }

    public function list_kembali() {
        $statusRequest = $this->logistik_office->getStatusRequest();
        $this->load->view('staff/list_kembali_office_view', $data = [ "statusRequest" => $statusRequest]);
    }

    public function load_kembali() {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'kembali_perlengkapan_office';
        // Primary key of table
        $primaryKey = 'id_kembali';
        $columns = array(
            array('db' => '`kpo`.`id_kembali`', 'dt' => 'DT_RowId', 'field' => 'id_kembali'),
            array('db' => '`bpo`.`id_barang`', 'dt' => 'id_barang', 'field' => 'id_barang'),
            array('db' => 'bpo.nama AS nama_barang', 'dt' => 'nama', 'field' => 'nama_barang'),      
            array('db' => '`bpo`.`jenis`', 'dt' => 'jenis', 'field' => 'jenis'),
            array('db' => '`bpo`.`stock`', 'dt' => 'stock', 'field' => 'stock'),
            array('db' => '`bpo`.`status`', 'dt' => 'status', 'field' => 'status'),
            array('db' => '`bpo`.`foto_status`', 'dt' => 'foto_status', 'field' => 'foto_status'),
            array('db' => '`bpo`.`keterangan`', 'dt' => 'keterangan', 'field' => 'keterangan'),
            array('db' => '`kpo`.`id_req_pinjam`', 'dt' => 'id_req_pinjam', 'field' => 'id_req_pinjam'),
            array('db' => '`kpo`.`tanggal_kembali`', 'dt' => 'tanggal_kembali', 'field' => 'tanggal_kembali'),
            array('db' => '`kpo`.`jumlah`', 'dt' => 'jumlah', 'field' => 'jumlah'),
            array('db' => '`rppo`.`id_req_pinjam`', 'dt' => 'id_req_pinjam', 'field' => 'id_req_pinjam'),
            array('db' => '`rppo`.`tanggal_request`', 'dt' => 'tanggal_request', 'field' => 'tanggal_request'),
            array('db' => '`rppo`.`id_staff_request`', 'dt' => 'id_staff_request', 'field' => 'id_staff_request'),
            array('db' => 's.nama AS nama_staff', 'dt' => 'nama_staff', 'field' => 'nama_staff')
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $joinQuery = "FROM `{$table}` AS `kpo`"
            . "JOIN `request_pinjam_perlengkapan_office` AS `rppo` ON (`rppo`.`id_req_pinjam` = `kpo`.`id_req_pinjam`)"
            . "JOIN `barang_perlengkapan_office` AS `bpo` ON (`bpo`.`id_barang` = `rppo`.`id_barang`)"
            . " LEFT JOIN `staff` AS `s` ON (`s`.`id_staff` = `kpo`.`id_staff_penerima`)";

        if ($_GET['status_request'] != '') {
            $status_request = $_GET['status_request'];
            $extraCondition = "status_request = '$status_request'";
        } else {
            $extraCondition = "";
        }
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition);
        foreach ($data['data'] as $key => $d) {
            // $data['data'][$key]['DT_RowAttr'] = array(
            //     'id_perlkantor' => $d['id_perlkantor']
            // );


            $data['data'][$key]['nama_pemegang'] = '';
            $this->load->model('staff');
            $staff = $this->staff->getStaff($d['id_staff_request']);
            if (!empty($staff)) {
                $data['data'][$key]['nama_pemegang'] = $staff->nama;
            }
        }
        echo json_encode($data);
    }

    public function kembali_barang() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied.');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $requestPinjam = $this->logistik_office->getRequestPinjamPerlengkapanOffice($_GET['id']);
        if (!$requestPinjam) {
            $this->alert->set('danger', 'Access Denied.');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $barang = $this->logistik_office->getBarangOffice($requestPinjam[0]->id_barang);
        if (!$barang) {
            $this->alert->set('danger', 'Access Denied.');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $data = [
            "requestPinjam" => $requestPinjam[0],
            "barang" => $barang[0]
        ];

        $this->load->view('staff/kembali_barang_view', $data);
    }

    public function proses_kembali() {
        $this->form_validation->set_rules('id_req_pinjam', 'id_req_pinjam', 'trim|required|integer');
        $this->form_validation->set_rules('jumlah', 'jumlah', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        }

        
        //insert
        $result = $this->logistik_office->addKembaliPerlengkapanOffice($_POST);
        if ($result['type'] == "danger") {
            $this->alert->set("$result[type]", "$result[msg]");
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->alert->set("success", "Pengembalian Berhasil");
        redirect(base_url() . "staff/perlengkapan_office/list_pinjam");
    }

    public function hapus() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $result = $this->logistik_office->deleteBarangOffice($_GET['id']);
        if (!$result) {
            $this->alert->set('danger', 'Error, Terjadi kesalahan pada sistem!');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->alert->set('success', 'Barang berhasil dihapus');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function staff_autocomplete()
    {
        $term = $_GET['term'];
        $this->load->model('staff');
        $data = $this->staff->getStaffByName($term);
        echo json_encode($data);
    }

    public function mutasi() {
        if (isset($_GET['id'])) {
            $id_barang = $_GET['id'];
        } else {
            $id_barang = NULL;
        }

        $this->load->view('staff/mutasi_barang_office', $data = [ "id_barang" => $id_barang ]);
    } 

    public function load_mutasi_all() {
        require_once APPPATH . 'third_party/ssp.class.php';
        
        // Primary key of table
        $primaryKey = 'id_barang';
        
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );

        $columns = array(
            array('db' => 'id_barang', 'dt' => 'id_barang', 'field' => 'id_barang'),
            array('db' => 'jumlah', 'dt' => 'jumlah', 'field' => 'jumlah'),
            array('db' => 'id_staff', 'dt' => 'id_staff', 'field' => 'id_staff'),
            array('db' => 'jenis', 'dt' => 'jenis', 'field' => 'jenis'),
            array('db' => 'tanggal_mutasi', 'dt' => 'tanggal_mutasi', 'field' => 'tanggal_mutasi'),
            array('db' => 'tanggal_back', 'dt' => 'tanggal_back', 'field' => 'tanggal_back'),
            array('db' => 'id_tabel', 'dt' => 'id_tabel', 'field' => 'id_tabel'),
            array('db' => 'stock_before', 'dt' => 'stock_before', 'field' => 'stock_before'),
            array('db' => 'stock_after', 'dt' => 'stock_after', 'field' => 'stock_after'),
        );

        $joinQuery = "(
            SELECT *
            FROM (
                (SELECT `id_barang`, `jumlah_request` AS `jumlah`, `id_staff_request` AS `id_staff`, `tanggal_request` AS `tanggal_mutasi`, 'pinjam' AS `jenis`, '-' AS `tanggal_back`, `id_req_pinjam` AS `id_tabel`, `stok_before` AS `stock_before`, `stok_after` AS `stock_after` FROM `request_pinjam_perlengkapan_office`) 
                UNION 
                (SELECT `id_barang`, `jumlah` AS `jumlah`, `id_staff` AS `id_staff`, `tanggal_keluar` AS `tanggal_mutasi`, 'keluar' AS `jenis`, '-' AS `tanggal_back`, `id_keluar` AS `id_tabel`, `stok_before` AS `stock_before`, `stok_after` AS `stock_after` FROM `keluar_perlengkapan_office`) 
                UNION 
                (SELECT `id_barang`, `jumlah` AS `jumlah`, `id_staff_order` AS `id_staff`, `tanggal` AS `tanggal_mutasi`, 'order' AS `jenis`, '-' AS `tanggal_back`, `id_order` AS `id_tabel`, `stok_before` AS `stock_before`, `stok_after` AS `stock_after` FROM `order_perlengkapan_office`) 
                UNION 
                (SELECT `ropo`.`id_barang`, `kpo`.`jumlah` AS `jumlah`, `kpo`.`id_staff_penerima` AS `id_staff`, `kpo`.`tanggal_kembali` AS `tanggal_mutasi`, 'kembali' AS `jenis`, `kpo`.`tanggal_kembali` AS `tanggal_back`, `id_kembali` AS `id_tabel`, `kpo`.`stok_before` AS `stock_before`, `kpo`.`stok_after` AS `stock_after`
                    FROM `kembali_perlengkapan_office` AS `kpo` 
                    JOIN `request_pinjam_perlengkapan_office` AS `ropo` ON `ropo`.`id_req_pinjam` = `kpo`.`id_req_pinjam`)
            ) AS tbl
        ) AS inner_tbl";
        $extraCondition = null ;
        if($_GET['id_barang'] != NULL) {
            $extraCondition = "id_barang = $_GET[id_barang]";
        }

        $data = SSP::simple($_GET, $sql_details, $joinQuery, $primaryKey, $columns, null, $extraCondition);
        foreach ($data['data'] as $key => $d) {
            $no_file = ($key +1) . "/" . date("m", strtotime($d['tanggal_mutasi'])) . "/" . date('y', strtotime($d['tanggal_mutasi']));
            
            $data['data'][$key]['no_file'] = $no_file;

            $barang = $this->logistik_office->getBarangOffice($d['id_barang']);
            $barang = $barang[0];

            $data['data'][$key]['nama_barang'] = $barang->nama;
            $data['data'][$key]['jenis'] = $barang->jenis;

            $this->load->model('staff');
            $staff = $this->staff->getStaff($d['id_staff']);
            $data['data'][$key]['status'] = $d['jenis'];
            $data['data'][$key]['in'] = '';
            $data['data'][$key]['out'] = '';
            $data['data'][$key]['pic'] = '';
            $data['data'][$key]['divisi'] = '';


            if (!empty($staff)) {
                $data['data'][$key]['pic'] = $staff->nama;
                $data['data'][$key]['divisi'] = $staff->bagian;
            }

            if ($d['jenis'] == "kembali") {
                $data['data'][$key]['status'] = "Pengembalian";
                $data['data'][$key]['in'] = $d['jumlah'];
                $data['data'][$key]['out'] = '-';
            } else if ($d['jenis'] == "order") {
                $order = $this->logistik_office->getOrderPerlengkapanOffice($d['id_tabel']);
                if ($order[0]->id_request_order == null) {
                    $status = "Barang Masuk";
                } else {
                    $status = "Request";
                }
                $data['data'][$key]['status'] = $status;
                $data['data'][$key]['in'] = $d['jumlah'];
                $data['data'][$key]['out'] = '-';
            } else if ($d['jenis'] == "pinjam") {
                $pinjam = $this->logistik_office->getRequestPinjamPerlengkapanOffice($d['id_tabel']);
                $data['data'][$key]['status'] = "Peminjaman";
                $data['data'][$key]['in'] = "-";
                $data['data'][$key]['out'] = $d['jumlah'];
                $data['data'][$key]['pic'] = $pinjam[0]->nama_peminjam;
            } else {
                $data['data'][$key]['status'] = "Barang Keluar";
                $data['data'][$key]['in'] = "-";
                $data['data'][$key]['out'] = $d['jumlah'];
            }
        }

        echo json_encode($data) ;
    }  
}