<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
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
        $this->load->model('customer');
        $dirname = SITE_ROOT. "/uploads/ads/";
        $dir = scandir($dirname);
        unset($dir[0]);
        unset($dir[1]);
        $no = 2;
        $view = null;
        foreach($dir as $direct) {
            $adsList = $dir;
            if(isset($adsList[$no])) {
                $view = $adsList[$no++];
            } else {
                $view = null;
            }
        }
        // echo '<pre>';
        // print_r($dir);
        // exit();
        
        //cek apakah sudah pernah menampilkan ads
        if ($this->customer->isAdsSeen()) {
            $view = null;
        }
        $this->customer->setAds();

        $this->load->model('agen');
        $this->load->model('bcast');
        $agen = $this->agen->getRowAgen($_SESSION['id_agen']);
        $broadcast = $this->bcast->getPesanAgen(null, $_SESSION['id_agen'], 1);
        $countBc = count($broadcast);
        foreach ($broadcast as $key => $bc) {
            $bc1 = explode("|", $bc->link1);
            $bc2 = explode("|", $bc->link2);
            $bc3 = explode("|", $bc->link3);
            $broadcast[$key]->nama_link1 = isset($bc1[0]) ? $bc1[0] : null;
            $broadcast[$key]->nama_link2 = isset($bc2[0]) ? $bc2[0] : null;
            $broadcast[$key]->nama_link3 = isset($bc3[0]) ? $bc3[0] : null;
            $broadcast[$key]->link1 = isset($bc1[1]) ? $bc1[1] : null;
            $broadcast[$key]->link2 = isset($bc2[1]) ? $bc2[1] : null;
            $broadcast[$key]->link3 = isset($bc3[1]) ? $bc3[1] : null;
        }
        $jamaahAgen = $this->agen->getJamaahAgen($_SESSION['id_agen']);
        $totalJamaah = 0;
        $sudah_berangkat = 0;
        $belum_berangkat = 0;
        foreach ($jamaahAgen as $item) {
            if (!empty($item->jamaah)) {
                if ($item->jamaah->tanggal_berangkat > '2023-06-19') {
                    $totalJamaah = $totalJamaah + 1;
                    if ($item->jamaah->tanggal_berangkat <= date('Y-m-d')) {
                        $sudah_berangkat = $sudah_berangkat + 1;
                    }

                    if ($item->jamaah->tanggal_berangkat > date('Y-m-d')) {
                        $belum_berangkat = $belum_berangkat + 1;
                    }

                }
            }
        }

        $this->load->model('agenPaket');
        $program = $this->agenPaket->getAgenPackage(null, true, true, true, '0');
        // echo '<pre>';
        // print_r($program);
        // exit();
        
        $this->load->model('registrasi');
        $jamaah = $this->registrasi->getJamaah(null, $agen->no_agen);
        if (isset($jamaah->member[0])) {
            $lunas = $jamaah->member[0]->lunas;
        } else {
            $lunas = 0;
        }
        // echo '<pre>';
        // print_r($jamaah);
        // exit();
        $totalBayar = 0;
        $id_secret_pembayaran = null;
        if (!empty($jamaah != null) && !empty($jamaah->member)) {
            $this->load->model('tarif');
            $pembayaran = $this->tarif->getPembayaran($jamaah->member[0]->id_member);
            // echo '<pre>';
            // print_r($pembayaran);
            // exit();
            if (!empty($pembayaran['data'])) {
                $id_secret_pembayaran = $pembayaran['data'][0]->id_secret;
                $totalBayar = $pembayaran['totalBayar'];
            }
        }
        if ($agen->active != 1) {
            redirect(base_url() . 'konsultan/home/pemb_notice');
        }

        $this->load->model('agenPaket');
        $this->load->model('tarif');
        $agenPaket = $this->agenPaket->getProgramMember(null, null, $_SESSION['id_agen']);
        if ($agenPaket) {
            foreach ($agenPaket as $key => $a) {
                $pembayaranAgen = $this->tarif->getPembayaranKonsultan($a->id_agen_peserta);
                $agenPaket[$key]->pembayaran = $pembayaranAgen;
            }
        }

        // get pembayaran konsultan untuk program
        // $pembayaran = $this->tarif->getPembayaranAgen($agenP)
        $data = array (
            'agen' => $agen,
            'jamaahAgen' => $jamaahAgen,
            'broadcast' => $broadcast,
            'countBc' => $countBc,
            'totalJamaah' => $totalJamaah,
            'belum_berangkat' => $belum_berangkat,
            'sudah_berangkat' => $sudah_berangkat,
            'view' => $view,
            'program' => $program,
            'jamaah' => $jamaah,
            'lunas' => $lunas,
            'totalBayar' => $totalBayar,
            'id_pembayaran' => $id_secret_pembayaran,
            'agenPaket' => $agenPaket
        );
        // echo '<pre>';
        // print_r($data);
        // exit();
        $this->load->view('konsultan/dash_konsultan', $data);
    }

    public function load_jamaah() {
        include APPPATH . 'third_party/ssp.class.php';
        include APPPATH . 'libraries/Wa_number.php'; 

        // echo '<pre>';
        // print_r($_GET);
        // exit();
        $table = 'program_member';
        // Primary key of table
        $primaryKey = 'id_member';

        $columns = array(
            array('db' => '`pm`.`id_member`', 'dt' => 'DT_RowId', 'field' => 'id_member'),
            array('db' => '`pm`.`id_paket`', 'dt' => 'id_paket', 'field' => 'id_paket'),
            array('db' => '`pm`.`id_jamaah`', 'dt' => 'id_jamaah', 'field' => 'id_jamaah'),
            array('db' => '`a`.`id_agen`', 'dt' => 'id_agen', 'field' => 'id_agen'),
            array('db' => '`j`.`first_name`', 'dt' => 'first_name', 'field' => 'first_name'),
            array('db' => '`j`.`second_name`', 'dt' => 'second_name', 'field' => 'second_name'),
            array('db' => '`j`.`last_name`', 'dt' => 'last_name', 'field' => 'last_name'),
            array('db' => '`j`.`jenis_kelamin`', 'dt' => 'jenis_kelamin', 'field' => 'jenis_kelamin'),
            array('db' => '`j`.`tanggal_lahir`', 'dt' => 'tanggal_lahir', 'field' => 'tanggal_lahir'),
            // array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`second_name`,' ',`j`.`last_name`) AS `whole_name`", 'dt' => "whole_name", 'field' => "whole_name"),
            array('db' => '`j`.`kabupaten_kota`', 'dt' => 'kabupaten_kota', 'field' => 'kabupaten_kota'),
            array('db' => '`pm`.`paspor_no`', 'dt' => 'paspor_no', 'field' => 'paspor_no'),
            array('db' => '`pm`.`lunas`', 'dt' => 'lunas', 'field' => 'lunas'),
            array('db' => '`pm`.`dp_expiry_time`', 'dt' => 'dp_expiry_time', 'field' => 'dp_expiry_time'),
            array('db' => '`pu`.`nama_paket`', 'dt' => 'nama_paket', 'field' => 'nama_paket'),
            array('db' => '`pu`.`tanggal_berangkat`', 'dt' => 'tanggal_berangkat', 'formatter' => function($d, $row) {
                return date_format(date_create($d), "d M Y");
            }
            , 'field' => 'tanggal_berangkat'),
            array('db' => '`pm`.`verified`', 'dt' => 'verified_member', 'field' => 'verified'),
            array('db' => '`j`.`verified`', 'dt' => 'verified_jamaah', 'field' => 'verified'),
            // array('db' => "CONCAT(`pu`.`nama_paket`,' (',`pu`.`tanggal_berangkat`,')') AS `paket_berangkat`", 'dt' => "paket_berangkat", 'field' => "paket_berangkat"),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $id_agen = $_SESSION['id_agen'];
        $joinQuery = "FROM `{$table}` AS `pm` LEFT JOIN `jamaah` AS `j` ON (`j`.`id_jamaah` = `pm`.`id_jamaah`) LEFT JOIN `paket_umroh` AS `pu` ON (`pu`.`id_paket` = `pm`.`id_paket`) LEFT JOIN `agen` AS `a` ON (`a`.`id_agen` = `pm`.`id_agen`)";
        $extraCondition = "`pm`.`id_agen`='" . $id_agen . "' AND `pu`.`tanggal_berangkat` >= '" . date('Y-m-d') . "'";

        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition);

        //prepare extra data
        $this->load->model('registrasi');
        $this->load->library('secret_key');
        $groupCtr = 0;
        $groupArr = array();
        // echo '<pre>';
        // print_r($data['data']);
        // exit();
        foreach ($data['data'] as $key => $d) {
            $data['data'][$key]['DT_RowAttr'] = array(
                'id_jamaah' => $d['id_jamaah'],
                'id_secret' => $this->secret_key->generate($d['DT_RowId'])
            );

            //determine WG status
            $wg = $this->registrasi->getWG($d['DT_RowId']);
            $data['data'][$key]['wg'] = $wg;

            // echo '<pre>';
            // print_r($d);
            // exit();
            $jamaah = $this->registrasi->getJamaah(null, null, $d['DT_RowId']);
            // echo '<pre>';
            // print_r($jamaah);
            // exit();
            $this->registrasi->cekVerified($d['DT_RowId']);
            if ($jamaah->verified == 1 && $jamaah->member[0]->verified == 1) {
                $document = 1;
            } else {
                $document = 0;
            }

            $data['data'][$key]['dokumen'] = $document;

            $this->load->model('logistik');
            $perlengkapan = $this->logistik->getStatusPerlengkapanMember($d['DT_RowId']);
            if ($perlengkapan == "Sudah Semua") {
                $perlengkapan = 1;
            } else {
                $perlengkapan = 0;
            }
            $data['data'][$key]['perlengkapan'] = $perlengkapan;

            $data['data'][$key]['status_perlengkapan'] = $this->logistik->getStatusPerlengkapanMember($d['DT_RowId']);
            $sudahAmbil = $this->logistik->getPerlengkapanSudahAmbil($d['DT_RowId']);
            $arrPerlengkapan= [];
            foreach ($sudahAmbil['items'] as $ambil) {
                $arrPerlengkapan[] = $ambil->nama_barang;
            }
            $data['data'][$key]['data_perlengkapan'] = $arrPerlengkapan;
            $data['data'][$key]['count'] = count($sudahAmbil['items']);

            $siapAmbil = $this->logistik->getAmbilList($d['DT_RowId'], true);
            if (empty($siapAmbil)) {
                $status = 0;
            } else {
                $status = 1;
            }

            $pendingBooking = $this->logistik->getPendingBooking($d['DT_RowId']);
            $siapBooking = $this->logistik->getPendingBookingStatus($d['DT_RowId']);
            if (!empty($pendingBooking['items'])) {
                $status = 2;
            }
            if (!empty($siapBooking['items'])) {
                $status = 2;
            }
        
            $data['data'][$key]['status_perl'] = $status;
        }
        // echo '<pre>';
        // print_r($data['data']);
        // exit();
        echo json_encode($data);
    }
    public function load_perlengkapan() {
        include APPPATH . 'third_party/ssp.class.php';
        include APPPATH . 'libraries/Wa_number.php'; 

        // echo '<pre>';
        // print_r($_GET);
        // exit();
        $table = 'program_member';
        // Primary key of table
        $primaryKey = 'id_member';

        $columns = array(
            array('db' => '`pm`.`id_member`', 'dt' => 'DT_RowId', 'field' => 'id_member'),
            array('db' => '`pm`.`id_paket`', 'dt' => 'id_paket', 'field' => 'id_paket'),
            array('db' => '`pm`.`id_jamaah`', 'dt' => 'id_jamaah', 'field' => 'id_jamaah'),
            array('db' => '`a`.`id_agen`', 'dt' => 'id_agen', 'field' => 'id_agen'),
            array('db' => '`j`.`first_name`', 'dt' => 'first_name', 'field' => 'first_name'),
            array('db' => '`j`.`second_name`', 'dt' => 'second_name', 'field' => 'second_name'),
            array('db' => '`j`.`last_name`', 'dt' => 'last_name', 'field' => 'last_name'),
            array('db' => '`j`.`jenis_kelamin`', 'dt' => 'jenis_kelamin', 'field' => 'jenis_kelamin'),
            array('db' => '`j`.`tanggal_lahir`', 'dt' => 'tanggal_lahir', 'field' => 'tanggal_lahir'),
            // array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`second_name`,' ',`j`.`last_name`) AS `whole_name`", 'dt' => "whole_name", 'field' => "whole_name"),
            array('db' => '`j`.`kabupaten_kota`', 'dt' => 'kabupaten_kota', 'field' => 'kabupaten_kota'),
            array('db' => '`pm`.`paspor_no`', 'dt' => 'paspor_no', 'field' => 'paspor_no'),
            array('db' => '`pm`.`lunas`', 'dt' => 'lunas', 'field' => 'lunas'),
            array('db' => '`pm`.`dp_expiry_time`', 'dt' => 'dp_expiry_time', 'field' => 'dp_expiry_time'),
            array('db' => '`pu`.`nama_paket`', 'dt' => 'nama_paket', 'field' => 'nama_paket'),
            array('db' => '`pu`.`tanggal_berangkat`', 'dt' => 'tanggal_berangkat', 'formatter' => function($d, $row) {
                return date_format(date_create($d), "d M Y");
            }
            , 'field' => 'tanggal_berangkat'),
            array('db' => '`pm`.`verified`', 'dt' => 'verified_member', 'field' => 'verified'),
            array('db' => '`j`.`verified`', 'dt' => 'verified_jamaah', 'field' => 'verified'),
            // array('db' => "CONCAT(`pu`.`nama_paket`,' (',`pu`.`tanggal_berangkat`,')') AS `paket_berangkat`", 'dt' => "paket_berangkat", 'field' => "paket_berangkat"),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $id_agen = $_SESSION['id_agen'];
        $joinQuery = "FROM `{$table}` AS `pm` LEFT JOIN `jamaah` AS `j` ON (`j`.`id_jamaah` = `pm`.`id_jamaah`) LEFT JOIN `paket_umroh` AS `pu` ON (`pu`.`id_paket` = `pm`.`id_paket`) LEFT JOIN `agen` AS `a` ON (`a`.`id_agen` = `pm`.`id_agen`)";
        $extraCondition = "`pm`.`id_agen`='" . $id_agen . "' AND `pu`.`tanggal_berangkat` >= '" . date('Y-m-d') . "' AND `j`.`tanggal_lahir` IS NOT NULL ";

        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition);

        //prepare extra data
        $this->load->model('registrasi');
        $this->load->library('secret_key');
        $groupCtr = 0;
        $groupArr = array();
        // echo '<pre>';
        // print_r($data['data']);
        // exit();
        foreach ($data['data'] as $key => $d) {
            $data['data'][$key]['DT_RowAttr'] = array(
                'id_jamaah' => $d['id_jamaah'],
                'id_secret' => $this->secret_key->generate($d['DT_RowId'])
            );

            //determine WG status
            $wg = $this->registrasi->getWG($d['DT_RowId']);
            $data['data'][$key]['wg'] = $wg;

            // echo '<pre>';
            // print_r($d);
            // exit();
            if ($d['verified_member'] == 1 && $d['verified_jamaah'] == 1) {
                $document = 1;
            } else {
                $document = 0;
            }

            $data['data'][$key]['dokumen'] = $document;

            $this->load->model('logistik');
            $perlengkapan = $this->logistik->getStatusPerlengkapanMember($d['DT_RowId']);
            if ($perlengkapan == "Sudah Semua") {
                $perlengkapan = 1;
            } else {
                $perlengkapan = 0;
            }
            $data['data'][$key]['perlengkapan'] = $perlengkapan;

            $data['data'][$key]['status_perlengkapan'] = $this->logistik->getStatusPerlengkapanMember($d['DT_RowId']);
            $sudahAmbil = $this->logistik->getPerlengkapanSudahAmbil($d['DT_RowId']);
            $arrPerlengkapan= [];
            foreach ($sudahAmbil['items'] as $ambil) {
                $arrPerlengkapan[] = $ambil->nama_barang;
            }
            $data['data'][$key]['data_perlengkapan'] = $arrPerlengkapan;
            $data['data'][$key]['count'] = count($sudahAmbil['items']);

            $siapAmbil = $this->logistik->getAmbilList($d['DT_RowId'], true);
            if (empty($siapAmbil)) {
                $status = 0;
            } else {
                $status = 1;
            }

            $pendingBooking = $this->logistik->getPendingBooking($d['DT_RowId']);
            $siapBooking = $this->logistik->getPendingBookingStatus($d['DT_RowId']);
            if (!empty($pendingBooking['items'])) {
                $status = 2;
            }
            if (!empty($siapBooking['items'])) {
                $status = 2;
            }
        
            $data['data'][$key]['status_perl'] = $status;
        }
        echo json_encode($data);
    }

    public function pemb_notice() {
        $this->load->model('agen');
        $this->load->model('agenPaket');
        $this->load->model('tarif');
        $agen = $this->agen->getAgen($_SESSION['id_agen']);
        $agen = $agen[0];
        if ($agen->active == 1 && $agen->program[0]->lunas == 1) {
            redirect(base_url() . 'konsultan/home/program_queue?id=' . $_GET['id']);
        }
        $detail_program = $agen->program[0]->detail_program;

        $this->load->model('registrasi');
        $jamaah = $this->registrasi->getJamaah(null, $agen->no_ktp, null);
        $isExJamaah = false;
        if (!empty($jamaah->member)) {
            $isExJamaah = true;
        }
        // echo '<pre>';
        // print_r($agen);
        // exit();
        $tarif = $this->tarif->calcTariffAgen($agen->program[0]->id_agen_peserta);
        $data = [
            'agen' => $agen,
            'detail_program' => $detail_program,
            'isExJamaah' => $isExJamaah,
            'tarif' => $tarif,
        ];
        $this->load->view('konsultan/pemb_notice_view', $data);
    }

    public function bsi_dp_agen()
    {
        $this->load->model('agen');
        $agen = $this->agen->getAgen($_SESSION['id_agen']);
        $agen = $agen[0];
        
        $this->load->model('tarif');
        $tarif = $this->tarif->getRiwayatBayarAgen($agen->program[0]->id_agen_peserta);
        //jika sudah bayar redirect ke home
        if ($tarif['sisaTagihan'] = 0) {
            redirect(base_url() . 'konsultan/home');
        }
        $data = $tarif['tarif'];
        $this->load->view('konsultan/bsi_dp_agen_view', $data);
    }

    public function duitku_dp_agen($metode)
    {
        $this->load->model('agen');
        $agen = $this->agen->getAgen($_SESSION['id_agen']);
        $agen = $agen[0];
        
        $this->load->model('tarif');
        $tarif = $this->tarif->getRiwayatBayarAgen($agen->program[0]->id_agen_peserta);
        //jika sudah bayar redirect ke home
        if ($tarif['sisaTagihan'] == 0) {
            redirect(base_url() . 'konsultan/home');
        }
        $this->load->model('duitku');
        //get pending transaction
        $invoice = $this->duitku->getPendingTransactionAgen($agen->program[0]->id_agen_peserta);
        if (empty($invoice)) {
            $invoice = $this->duitku->createInvoice($agen->program[0]->id_agen_peserta, $tarif['sisaTagihan'], 'no', 'bayar_konsultan', $metode);
        } else {
            $invoice = $invoice[0];
        }
        redirect($invoice['paymentUrl']);
    }

    public function daftar_program()
    {
        if (!isset($_GET['id'])) {
            $this->alert->setJamaah('red', 'Ups...', 'Program tidak ditemukan');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->load->model('agenPaket');
        $this->load->model('agen');
        $agen = $this->agen->getAgen($_SESSION['id_agen']);
        $program = $this->agenPaket->getAgenPackage($_GET['id']);
        $peserta = $this->agenPaket->getPeserta($program->id, null, $_SESSION['id_agen']);
        // echo '<pre>';
        // print_r($peserta);
        // exit();
        if (!empty($peserta)) {
            $this->load->model('tarif');
            $pembayaran = $this->tarif->getPembayaranAgen($peserta[0]->id_agen_peserta);
            if ($pembayaran['totalBayar'] == 0) {
                redirect(base_url() . 'konsultan/home/pemb_notice?id=' . $peserta[0]->id_agen_peserta);
            }
        }
        if (!empty($peserta)) {
            if ($agen[0]->active == 1 && $agen[0]->program[0]->lunas == 1) {
                redirect(base_url() . 'konsultan/home/program_queue?id=' . $peserta[0]->id_agen_peserta);
            }
        }
        redirect(base_url() . 'konsultan/home/detail_program?id=' . $_GET['id']);
        // $this->load->view('konsultan/terms_program', $data);
    }
    
    public function start_program() {
        $this->load->model('agenPaket');
        $this->load->model('agen');
        $this->load->model('registrasi');
        $agen = $this->agen->getAgen($_SESSION['id_agen']);
        $program = $this->agenPaket->getAgenPackage($_GET['id']);
        $program->event = $this->agenPaket->getAgenEvent(null, $_GET['id']);
        
        // $peserta = $this->agenPaket->getPeserta($program->id, null, $agen[0]->id_agen);
        // if (!empty($peserta)) {
        //     $this->load->model('tarif');
        //     $pembayaran = $this->tarif->getPembayaranAgen($peserta[0]->id_agen_peserta);
        //     if ($pembayaran['totalBayar'] == 0) {
        //         $this->load->library('secret_key');
        //         $id_secret = $this->secret_key->generate($peserta[0]->id_agen_peserta);
        //         redirect(base_url() . 'konsultan/home/bsi_dp?id=' . $id_secret);
        //     }
        // }

        $id_program = $_GET['id'];
        if ($id_program == null) {
            redirect(base_url() . 'konsultan/home');
        }
        
        $data = [
            'agen' => $agen[0],
            'program' => $program,
        ];
        $this->load->view('konsultan/registrasi_program_view', $data);
    }

    public function proses_daftar_program() {
        //cek program
        if (empty($_POST['id_agen_paket'])) {
            $this->alert->setJamaah('red', 'Ups...', 'Program tidak ditemukan');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $id = $_POST['id_agen_paket'];

        $this->load->model('agenPaket');
        $program = $this->agenPaket->getAgenPackage($id, true, true, true, '0');
        if (empty($program)) {
            $this->alert->setJamaah('red', 'Ups...', 'Program tidak ditemukan');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->form_validation->set_rules('nama_agen', 'Nama Konsultan', 'trim|required');
        $this->form_validation->set_rules('no_ktp', 'Nomor KTP', 'trim|required');
        $this->form_validation->set_rules('ukuran_baju', 'Ukuran Baju', 'trim|required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata(['form' => $_POST]);
            $this->alert->setJamaah('red', 'Ups...', validation_errors('<li>', '</li>'));
            redirect($_SERVER['HTTP_REFERER']);
        }

        $data_agen = [
            "jenis_kelamin" => $_POST['jenis_kelamin'],
            "ukuran_baju" => $_POST['ukuran_baju'],
        ];
        $this->load->model('agen');
        $agen = $this->agen->editAgen($_POST['id_agen'], $data_agen);
        // echo '<pre>';
        // print_r($_POST);
        // exit();
        
        unset($_POST['jenis_kelamin']);
        unset($_POST['ukuran_baju']);
        if (!$this->agenPaket->addProgramMember($_POST, true)) {
            $this->alert->setJamaah('red', 'Ups...', 'Pendaftaran tidak dapat dilakukan');
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $peserta = $this->agenPaket->getPeserta($program->id, null, $_POST['id_agen']);
            redirect(base_url() . 'konsultan/home/pemb_notice?id=' . $peserta[0]->id_agen_peserta);
        }
    }

    public function program_queue() {
        if (empty($_GET['id'])) {
            $this->alert->setJamaah('red', 'Ups...', 'Anda tidak terdaftar');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->load->model('agen');
        $this->load->model('agenPaket');
        $peserta = $this->agenPaket->getPeserta(null, $_GET['id']);
        if (empty($peserta)) {
            $this->alert->setJamaah('red', 'Ups...', 'Anda tidak terdaftar sebagai Peserta');
            redirect($_SERVER['HTTP_REFERER']);
        }
        // echo '<pre>';
        // print_r($id_peserta);
        // exit();
        if ($peserta[0]->sudah_ikut == 1) {
            redirect(base_url() . 'konsultan/home/detail_program?id=' . $peserta[0]->id_agen_paket);
        }
        $agen = $this->agen->getAgen($_SESSION['id_agen']);
        $program = $agen[0]->program[0];
        $this->load->view('konsultan/program_queue_view', ['program' => $program]);
    }

    public function detail_program() {
        if (empty($_GET['id'])) {
            $this->alert->setJamaah('red', 'Ups...', 'Program tidak ditemukan');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->load->model('agenPaket');
        $this->load->model('tarif');
        $program = $this->agenPaket->getAgenPackage($_GET['id']);
        $program->event = $this->agenPaket->getAgenEvent(null, $_GET['id']);
        if (empty($program->event)) {
            $this->alert->setJamaah('red', 'Ups...', 'Program tidak ditemukan');
            redirect($_SERVER['HTTP_REFERER']);
        }
        // echo '<pre>';
        // print_r($program);
        // exit();
        $peserta = $this->agenPaket->getPeserta($_GET['id'], null, $_SESSION['id_agen']);
        $pembayaran = null;
        if (!empty($peserta)) {
            $pesertaEvent = $this->agenPaket->getAgenPesertaEvent(null, $program->event[0]->id, $peserta[0]->id_agen_peserta);
            $pembayaran = $this->tarif->getPembayaranAgen($pesertaEvent[0]->id_peserta);
        }
        $p = $this->agenPaket->getAgenPesertaEvent(null, $program->id);
        $total_peserta = count($this->agenPaket->getAgenPesertaEvent(null, $program->event[0]->id));
        // echo '<pre>';
        // print_r($p);
        // exit();
        $data = [
            'program' => $program,
            'total_peserta' => $total_peserta,
            'pembayaran' => $pembayaran,
        ];
        $this->load->view('konsultan/detail_program_view', $data);
    }
}
        
    /* End of file  Home.php */