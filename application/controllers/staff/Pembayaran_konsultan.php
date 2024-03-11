<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran_konsultan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }
        //this page only for admin
        if (!($_SESSION['bagian'] == 'PR' || $_SESSION['email'] == 'master@ventour.co.id')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->load->model('agen');
        $this->load->model('agenPaket');
    }

    public function index()
    {
        $program = $this->agenPaket->getAgenPackage(null, false, false, false);
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        } else {
            $id = $program[0]->id;
        }

        $selectedProgram = $this->agenPaket->getAgenPackage($id, false, false, false);
        $nama_paket = $selectedProgram->nama_paket;
        $jumlahTerdaftar = count($this->agenPaket->getPeserta($id));
        $this->load->view('staff/list_bayar_konsultan', $data = array(
            'program' => $program,
            'id' => $id,
            'nama_paket' => $nama_paket,
            'selectedProgram' => $selectedProgram,
            'jumlahTerdaftar' => $jumlahTerdaftar
        ));
    }

    public function load_data()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'agen_peserta_paket';
        // Primary key of table
        $primaryKey = 'id_agen_peserta';

        $columns = array(
            array('db' => '`agp`.`id_agen_peserta`', 'dt' => 'DT_RowId', 'field' => 'id_agen_peserta'),
            array('db' => '`agp`.`id_agen`', 'dt' => 'id_agen', 'field' => 'id_agen'),
            array('db' => '`agp`.`id_agen_paket`', 'dt' => 'id_agen_paket', 'field' => 'id_agen_paket'),
            array('db' => '`agp`.`harga_setelah_diskon`', 'dt' => 'harga_setelah_diskon', 'field' => 'harga_setelah_diskon'),
            array('db' => '`agp`.`lunas`', 'dt' => 'lunas', 'field' => 'lunas'),
            array('db' => '`a`.`nama_agen`', 'dt' => 'nama_agen', 'field' => 'nama_agen'),
            array('db' => '`a`.`upline_id`', 'dt' => 'upline_id', 'field' => 'upline_id'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $id = $_GET['id'];
        $joinQuery = "FROM `{$table}` AS `agp` LEFT JOIN `agen` AS `a` ON (`a`.`id_agen` = `agp`.`id_agen`) LEFT JOIN `agen_paket` AS `ap` ON (`ap`.`id` = `agp`.`id_agen_paket`)";
        $extraCondition = "`agp`.`id_agen_paket`=" . $id;
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition);

        //prepare extra data
        $this->load->model('registrasi');
        $groupCtr = 0;
        $groupArr = array();
        foreach ($data['data'] as $key => $d) {
            $data['data'][$key]['DT_RowAttr'] = array(
                'id_agen' => $d['id_agen']
            );

            //format money
            if (!empty($d['harga_setelah_diskon'])) {
                $data['data'][$key]['total_harga'] = 'Rp. ' . number_format($d['harga_setelah_diskon'], 0, ',', '.') . ',-';
            }

            $this->load->model('tarif');
            $this->tarif->calcTariffAgen($d['DT_RowId']);

            //format lunas
            if ($d['lunas'] == 1) {
                $lns = 'Lunas';
            } else if ($d['lunas'] == 2) {
                $lns = 'Sudah Cicil';
            } else if ($d['lunas'] == 3) {
                $lns = 'Kelebihan Bayar';
            } else {
                $lns = 'Belum Bayar';
            }

            $data['data'][$key]['lunas'] = $lns;

            if ($d['upline_id'] != null) {
                $upline = $this->agen->getUpline($d['id_agen']);
                $nama_upline = $upline->nama_agen;
            } else {
                $nama_upline = "Tidak ada upline";
            }

            $data['data'][$key]['nama_upline'] = $nama_upline;
        }
        echo json_encode($data);
    }

    public function bayar()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('iap', 'ID', 'trim|required|numeric');
        if ($this->form_validation->run() == false) {
            $this->alert->set('danger', 'Access Denied!');
            redirect(base_url() . 'staff/pembayaran_konsultan');
        }

        $this->load->model('agen');
        $this->load->model('agenPaket');
        $peserta = $this->agenPaket->getPeserta(null, $_GET['iap']);
        if (empty($peserta[0])) {
            $this->alert->set('danger', 'Konsultan tidak ditemukan');
            redirect(base_url() . 'staff/dashboard');
        }
        $peserta = $peserta[0];
        $agen = $this->agen->getAgen($peserta->id_agen);
        $agen = $agen[0];
        // $program = $this->agenPaket->getAgenPackage('')
        // echo '<pre>';
        // print_r($agen);
        // exit();
        if (!$agen) {
            $this->alert->set('danger', 'Konsultan tidak ditemukan');
            redirect(base_url() . 'staff/dashboard');
        }

        // if (!$data->member[0]->va_open) {
        //     $this->load->model('va_model');
        //     $data->member[0]->va_open = $this->va_model->createVAOpen($data->member[0]->id_member);
        // }

        $this->load->model('tarif');
        $sisaBayar = $this->tarif->getSisaPembayaranKonsultan($_GET['iap']);

        $data = [
            'agen' => $agen,
            'peserta' => $peserta,
            'sisaBayar' => $sisaBayar
        ];

        $this->load->view('staff/va_agen_view', $data);
    }
    public function proses_pembayaran()
    {
        if (empty($_POST['metode'])) {
            $this->alert->set('danger', 'Access Denied!');
            redirect(base_url() . 'staff/pembayaran_konsultan');
        }
        $metode = $_POST['metode'];
        if ($metode == 'manual') {
            $this->proses_manual();
        }
        if ($metode == 'duitku') {
            $this->proses_duitku();
        }
    }
    public function proses_duitku()
    {
        $this->form_validation->set_rules('id_agen_peserta', 'id peserta', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/');
        }
        $this->load->model('tarif');
        $sisaBayar = $this->tarif->getSisaPembayaranKonsultan($_POST['id_agen_peserta']);
        $this->load->model('duitku');
        $this->duitku->createInvoice($_POST['id_agen_peserta'], $sisaBayar, 'no', 'bayar_konsultan');
        redirect(base_url() . 'staff/pembayaran_konsultan/bayar?iap=' . $_POST['id_agen_peserta']);
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
        $id_agen_peserta = $_GET['id_agen_peserta'];
        $extraCondition = "`merchantUserId`=" . $id_agen_peserta;
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
        $id_agen_peserta = $_GET['id_agen_peserta'];
        $extraCondition = "`id_member`=" . $id_agen_peserta;
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, null, $extraCondition);

        foreach ($data['data'] as $key => $d) {
            $data['data'][$key]['nominal_tagihan'] = 'Rp. ' . number_format($d['nominal_tagihan'], 0, ',', '.') . ',-';
        }

        echo json_encode($data);
    }

    public function load_manual()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'pembayaran';
        // Primary key of table
        $primaryKey = 'id_pembayaran';

        $columns = array(
            array('db' => 'id_pembayaran', 'dt' => 'id_pembayaran', 'field' => 'id_pembayaran'),
            array('db' => 'jumlah_bayar', 'dt' => 'jumlah_bayar', 'field' => 'jumlah_bayar'),
            array('db' => 'tanggal_bayar', 'dt' => 'tanggal_bayar', 'field' => 'tanggal_bayar'),
            array('db' => 'cara_pembayaran', 'dt' => 'cara_pembayaran', 'field' => 'cara_pembayaran'),
            array('db' => 'id_member', 'dt' => 'id_member', 'field' => 'id_member'),
            array('db' => 'nomor_referensi', 'dt' => 'nomor_referensi', 'field' => 'nomor_referensi'),
            array('db' => 'keterangan', 'dt' => 'keterangan', 'field' => 'keterangan'),
            array('db' => 'verified', 'dt' => 'verified', 'field' => 'verified'),
            array('db' => 'jenis', 'dt' => 'jenis', 'field' => 'jenis'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $id_agen_peserta = $_GET['id_agen_peserta'];
        $extraCondition = "`id_member`=" . $id_agen_peserta . " AND `jenis`= 'bayar_konsultan'";
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, null, $extraCondition);
        foreach ($data['data'] as $key => $d) {
            $data['data'][$key]['jumlah_bayar'] = 'Rp. ' . number_format($d['jumlah_bayar'], 0, ',', '.') . ',-';
        }

        echo json_encode($data);
    }

    public function proses_manual()
    {
        $this->form_validation->set_rules('id_agen_peserta', 'id peserta', 'trim|required|integer');
        $this->form_validation->set_rules('tanggal_bayar', 'tanggal_bayar', 'required');
        $this->form_validation->set_rules('jumlah_bayar', 'jumlah_bayar', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/');
        }

        // only use required field (matched with table 'pembayaran' in db)
        $_POST['jumlah_bayar'] = str_replace(",", "", $_POST['jumlah_bayar']);
        $data = [
            'id_agen_peserta' => $_POST['id_agen_peserta'],
            'tanggal_bayar' => $_POST['tanggal_bayar'],
            'jumlah_bayar' => $_POST['jumlah_bayar'],
        ];

        if (!empty($_POST['cara_pembayaran'])) {
            $data['cara_pembayaran'] = $_POST['cara_pembayaran'];
        }
        if (!empty($_POST['nomor_referensi'])) {
            $data['nomor_referensi'] = $_POST['nomor_referensi'];
        }
        if (!empty($_POST['keterangan'])) {
            $data['keterangan'] = $_POST['keterangan'];
        }
        if (!empty($_POST['verified'])) {
            $data['verified'] = $_POST['verified'];
        }
        if (!empty($_FILES['scan_bayar']['name'])) {
            $data['files']['scan_bayar'] = $_FILES['scan_bayar'];
        }
        $this->load->model('tarif');

        $this->tarif->setPembayaran($data, 'bayar_konsultan');

        // $this->load->library('user_agent');
        // redirect($this->agent->referrer());
        redirect(base_url() . 'staff/pembayaran_konsultan/bayar?iap=' . $_POST['id_agen_peserta']);
    }

    public function riwayat_bayar()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            echo 'Access Denied';
            return false;
        }
        $this->load->model('tarif');
        $data = $this->tarif->getRiwayatBayarAgen($_GET['id']);

        $this->load->view('staff/riwayat_bayar_konsultan', $data);
    }

    public function verifikasi()
    {
        $this->load->model('agenPaket');
        $program = $this->agenPaket->getAgenPackage(null,false,false,false);

        if (isset($_GET['id']) && $_GET['id'] !== 'all') {
            $id = $_GET['id'];
            $selectedPaket = $this->agenPaket->getAgenPackage($id, false, false, false);
            $nama_paket = $selectedPaket->nama_paket;
        } else {
            $id = 0;
            $nama_paket = 'Semua Program';
        }

        $this->load->view('staff/list_verifikasi_konsultan', $data = array(
            'program' => $program,
            'id' => $id,
            'nama_paket' => $nama_paket,
        ));
    }

    public function load_verifikasi()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'pembayaran';
        // Primary key of table
        $primaryKey = 'id_member';

        $columns = array(
            array('db' => '`app`.`id_agen_peserta`', 'dt' => 'DT_RowId', 'field' => 'id_agen_peserta'),
            array('db' => '`byr`.`id_pembayaran`', 'dt' => 'id_pembayaran', 'field' => 'id_pembayaran'),
            array('db' => '`byr`.`jumlah_bayar`', 'dt' => 'jumlah_bayar', 'field' => 'jumlah_bayar'),
            array('db' => '`byr`.`tanggal_bayar`', 'dt' => 'tanggal_bayar', 'field' => 'tanggal_bayar'),
            array('db' => '`byr`.`verified`', 'dt' => 'verified', 'field' => 'verified'),
            array('db' => '`byr`.`scan_bayar`', 'dt' => 'scan_bayar', 'field' => 'scan_bayar'),
            array('db' => '`byr`.`jenis`', 'dt' => 'jenis', 'field' => 'jenis'),
            array('db' => '`byr`.`cara_pembayaran`', 'dt' => 'cara_pembayaran', 'field' => 'cara_pembayaran'),
            array('db' => '`byr`.`keterangan`', 'dt' => 'keterangan', 'field' => 'keterangan'),
            array('db' => '`pkt`.`nama_paket`', 'dt' => 'nama_paket', 'field' => 'nama_paket'),
            array('db' => '`pkt`.`harga`', 'dt' => 'harga', 'field' => 'harga'),
            array('db' => '`pkt`.`id`', 'dt' => 'id', 'field' => 'id'),
            array('db' => '`a`.`id_agen`', 'dt' => 'id_agen', 'field' => 'id_agen'),
            array('db' => '`a`.`nama_agen`', 'dt' => 'nama_agen', 'field' => 'nama_agen'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $id = $_GET['id'];
        $joinQuery = "FROM `{$table}` AS `byr`"
            . "JOIN `agen_peserta_paket` AS `app` ON (`byr`.`id_member` = `app`.`id_agen_peserta`)"
            . " JOIN `agen` AS `a` ON (`a`.`id_agen` = `app`.`id_agen`)"
            . " JOIN `agen_paket` AS `pkt` ON(`pkt`.`id` = `app`.`id_agen_paket`)";
        $extraCondition = "`byr`.`jenis` = 'bayar_konsultan'";
        // $extraCondition = $_GET['id_paket'] != 0 ? " AND `pkt`. `id_paket`=" . $id_paket : "";
        if ($_GET['id'] != 0) {
            $condition = " AND pkt.id = '$id'";
            $extraCondition = $extraCondition . $condition;
        }
        // $extraCondition = "`pkt`. `id_paket`=" . $id_paket;
        
        // echo '<pre>';
        // print_r($_GET);
        // exit();
        if ($_GET['date_start'] != '') {
            $date_start = $_GET['date_start'];
            if ($extraCondition != "") {
                $condition = " AND byr.tanggal_bayar >= '$date_start 00:00:00'";
            } else {
                $condition = " byr.tanggal_bayar >= '$date_start 00:00:00'";
            }
            $extraCondition = $extraCondition . $condition;
        }
        if ($_GET['date_end'] != '') {
            $date_end = $_GET['date_end'];
            if ($extraCondition != "") {
                $condition = " AND byr.tanggal_bayar <= '$date_end 00:00:00'";
            } else {
                $condition = " byr.tanggal_bayar <= '$date_end 00:00:00'";
            }
            $extraCondition = $extraCondition . $condition;
        }
        // if ($_GET['date_start'] != '' && $_GET['date_end'] != '') {
        //     $date_start = $_GET['date_start'];
        //     $date_end = $_GET['date_end'];
        //     $condition = " AND byr.tanggal_bayar >= $date_start AND byr.tanggal_bayar <= $date_end";
        //     $extraCondition = $extraCondition . $condition;
        // }
        if ($_GET['payments_method'] != '') {
            $payments_method = $_GET['payments_method'];
            if ($extraCondition != "") {
                $condition = " AND byr.cara_pembayaran LIKE '$payments_method%'";
            } else {
                $condition = " byr.cara_pembayaran LIKE '$payments_method%'";
            }
            $extraCondition = $extraCondition . $condition;
        }
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition);
        //prepare extra data
        $this->load->model('registrasi');
        $this->load->model('tarif');
        $groupCtr = 0;
        $groupArr = array();
        // echo '<pre>';
        // print_r($data['data']);
        // exit();
        foreach ($data['data'] as $key => $d) {
            $data['data'][$key]['harga'] = 'Rp. ' . number_format($data['data'][$key]['harga'], 0, ',', '.') . ',-';
            $data['data'][$key]['DT_RowAttr'] = array(
                'id_agen' => $d['id_agen'],
                'id_pembayaran' => $d['id_pembayaran'],
                'verified' => $d['verified']
            );
            $bayar = $this->tarif->getRiwayatBayarAgen($d['DT_RowId']);
            $data['data'][$key]['notes'] = "";
            if (!empty($bayar['data'])) {
                $no = 0;
                foreach ($bayar['data'] as $byr) {
                    $no++;
                    if ($d['id_pembayaran'] == $byr->id_pembayaran) {
                        if ($d['keterangan'] == "Bayar DP") {
                            $data['data'][$key]['notes'] = "Bayar DP";
                        } elseif ($d['keterangan'] == "Pelunasan") {
                            $data['data'][$key]['notes'] = "Pelunasan";
                        } elseif ($d['keterangan'] == "Cicilan") {
                            $data['data'][$key]['notes'] = "Payments " . $no ;
                        } else {
                            $data['data'][$key]['notes'] = $d['keterangan'];
                        }

                        break;
                    }
                }
            }
            //determine WG status
            $wg = $this->registrasi->getWG($d['DT_RowId']);
            $data['data'][$key]['wg'] = $wg;
            //set verification class
            if ($d['verified'] == 1) {
                $data['data'][$key]['DT_RowClass'] = 'group-color-10';
            } elseif ($d['verified'] == 2) {
                $data['data'][$key]['DT_RowClass'] = 'group-color-11';
            }
            //format money
            if (!empty($d['jumlah_bayar'])) {
                $data['data'][$key]['jumlah_bayar'] = 'Rp. ' . number_format($d['jumlah_bayar'], 0, ',', '.') . ',-';
            }
        }
        echo json_encode($data);
    }

    public function hapusPembayaran()
    {
        if (!($_SESSION['bagian'] == 'Master Admin')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }

        $this->load->model('tarif');
        $data = $this->tarif->hapusPembayaranAgen($_GET['id'], $_GET['iap']);
        if ($data == true) {
            $this->alert->set('success', 'Data Pembayaran Berhasil Dihapus');
        } else {
            $this->alert->set('danger', 'Data Pembayaran Gagal Dihapus');
        }
        redirect(base_url() . 'staff/pembayaran_konsultan/verifikasi');
    }

    public function verifikasi_data()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('idg', 'idg', 'trim|required|integer');
        $this->form_validation->set_rules('iap', 'iap', 'trim|required|integer');
        $this->form_validation->set_rules('idb', 'idb', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/pembayaran_konsultan/verifikasi');
        }
        $refund = null;
        if (isset($_GET['refund'])) {
            $refund = $_GET['refund'];
        }
        $this->load->model('agen');
        $agen = $this->agen->getAgen($_GET['idg']);
        if (empty($agen)) {
            $this->alert->set('danger', 'Data Tidak Ditemukan');
            redirect(base_url() . 'staff/pembayaran_konsultan/verifikasi');
        }

        $this->load->model('agenPaket');
        $peserta = $this->agenPaket->getPeserta(null, $_GET['iap']);
        $this->load->model('tarif');
        $dataBayar = $this->tarif->getPembayaran($_GET['iap'], false, $_GET['idb']);

        if (empty($dataBayar['data'])) {
            $this->alert->set('danger', 'Data Tidak Ditemukan');
            redirect(base_url() . 'staff/pembayaran_konsultan/verifikasi');
        }
        $data = array(
            'peserta' => $peserta[0],
            'refund' => $refund,
            'agen' => $agen[0],
            'dataBayar' => $dataBayar
        );
        $this->load->view('staff/verifikasi_konsultan_view', $data);
    }

    public function proses_verifikasi()
    {
        $this->form_validation->set_rules('id_pembayaran', 'id_pembayaran', 'trim|required|integer');
        $this->form_validation->set_rules('verified', 'verified', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/pembayaran_konsultan/verifikasi');
        }
        $this->load->model('tarif');

        $ver = $this->tarif->verifikasi($_POST['id_pembayaran'], $_POST['verified']);
        if (!$ver) {
            $this->alert->set('danger', 'Data Pembayaran Tidak Ada');
        } else {
            $this->alert->set('success', 'Data Pembayaran Berhasil diverifikasi');
        }
        
        $this->load->model('tarif');
        $this->tarif->calcTariffAgen($_POST['iap']);
        redirect(base_url() . 'staff/pembayaran_konsultan/verifikasi');
    }

    public function hapus_data() {
        if (!($_SESSION['bagian'] == 'PR' || $_SESSION['email'] == 'master@ventour.co.id')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }

        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('iap', 'iap', 'required|trim|numeric');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->agenPaket->deleteProgramMember($_GET['iap']);
        redirect(base_url() . 'staff/pembayaran_konsultan');
    }

}