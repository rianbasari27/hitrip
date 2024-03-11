<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Perlengkapan_pending extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }
        //this page only for admin
        if (!($_SESSION['bagian'] == 'Admin' || $_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Logistik' || $_SESSION['bagian'] == 'Manifest')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
    }

    public function index()
    {
        $this->load->view('staff/list/perlengkapan_pending');
    }
    public function pending_batal()
    {
        if (!($_SESSION['bagian'] == 'Admin' || $_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Logistik')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->load->model('logistik');
        $hapus = $this->logistik->hapusPending($_GET['id']);
        if (!$hapus) {
            $this->alert->set('danger', 'Error. Item Gagal Dihapus.');
        } else {
            $this->alert->set('success', 'Item berhasil dihapus');
        }

        redirect(base_url() . 'staff/perlengkapan_pending');
    }
    public function load_pending()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'perlengkapan_member';
        // Primary key of table
        $primaryKey = 'id_perlmember';

        $columns = array(
            array('db' => '`pm`.`id_member`', 'dt' => 'DT_RowId', 'field' => 'id_member'),
            array('db' => '`pm`.`id_jamaah`', 'dt' => 'id_jamaah', 'field' => 'id_jamaah'),
            array('db' => '`pm`.`id_paket`', 'dt' => 'id_paket', 'field' => 'id_paket'),
            array('db' => '`ag`.`nama_agen`', 'dt' => 'nama_agen', 'field' => 'nama_agen'),
            array('db' => '`pm`.`lunas`', 'dt' => 'lunas', 'field' => 'lunas'),
            array('db' => '`j`.`first_name`', 'dt' => 'first_name', 'field' => 'first_name'),
            array('db' => '`j`.`second_name`', 'dt' => 'second_name', 'field' => 'second_name'),
            array('db' => '`j`.`last_name`', 'dt' => 'last_name', 'field' => 'last_name'),
            array('db' => '`j`.`no_wa`', 'dt' => 'no_wa', 'field' => 'no_wa'),
            array('db' => '`j`.`referensi`', 'dt' => 'referensi', 'field' => 'referensi'),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`second_name`,' ',`j`.`last_name`) AS `whole_name`", 'dt' => "whole_name", 'field' => "whole_name"),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`last_name`) AS `two_name`", 'dt' => "two_name", 'field' => "two_name"),
            array('db' => '`pm`.`paspor_no`', 'dt' => 'paspor_no', 'field' => 'paspor_no'),
            array('db' => '`pm`.`parent_id`', 'dt' => 'parent_id', 'field' => 'parent_id'),
            array('db' => '`pm`.`id_agen`', 'dt' => 'id_agen', 'field' => 'id_agen'),
            array('db' => '`ag`.`nama_agen`', 'dt' => 'nama_agen', 'field' => 'nama_agen'),
            array('db' => '`perl`.`tanggal_ambil`', 'dt' => 'tanggal_ambil', 'field' => 'tanggal_ambil'),
            array('db' => '`perl`.`jenis_ambil`', 'dt' => 'jenis_ambil', 'field' => 'jenis_ambil'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $joinQuery = "FROM `{$table}` AS `perl` JOIN program_member AS pm ON (pm.id_member = perl.id_member) JOIN `jamaah` AS `j` ON (`j`.`id_jamaah` = `pm`.`id_jamaah`) LEFT JOIN agen AS ag ON (ag.id_agen = pm.id_agen)";
        $extraCondition = 'perl.status = "Pending"';
        if ($_GET['jenis_ambil'] != '') {
            if ($_GET['jenis_ambil'] == 'pengiriman') {
                $condition = " AND perl.jenis_ambil = 'pengiriman'";
            } else {
                $condition = " AND perl.jenis_ambil = 'langsung'";
            }
            $extraCondition = $extraCondition . $condition ;
        }
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition, 'perl.id_member, perl.tanggal_ambil');

        //prepare extra data
        $this->load->model('registrasi');
        $this->load->model('logistik');
        $this->load->model('paketUmroh');
        $groupCtr = 0;
        $groupArr = array();
        foreach ($data['data'] as $key => $d) {

            //handle status perlengkapan per member
            $data['data'][$key]['status_perlengkapan'] = $this->logistik->getStatusPerlengkapanMember($d['DT_RowId']);

            $data['data'][$key]['DT_RowAttr'] = array(
                'id_jamaah' => $d['id_jamaah']
            );

            //determine WG status
            $wg = $this->registrasi->getWG($d['DT_RowId']);
            $data['data'][$key]['wg'] = $wg;

            //set group class
            $parent_id = $d['parent_id'];
            if (!empty($parent_id)) {
                //check in array
                if (!isset($groupArr[$parent_id])) {
                    $groupCtr = $groupCtr + 1;
                    $groupArr[$parent_id] = $groupCtr;
                }
                $data['data'][$key]['DT_RowClass'] = 'group-color-' . $groupArr[$parent_id];
            }
            $paket = $this->paketUmroh->getPackage($d['id_paket'], false);
            if (!empty($paket)) {
                $data['data'][$key]['nama_paket'] = $paket->nama_paket . " ( " . date('d F Y', strtotime($paket->tanggal_berangkat)) . " )";
            } else {
                $data['data'][$key]['nama_paket'] = 'Tidak terdaftar pada program' ;
            }
            
            // ambil nama konsultan
            $this->load->model('agen');
            $agen = $this->agen->getAgen($d['id_agen']);

            if ($d['referensi'] == 'Agen') {
                $data['data'][$key]['referensi'] = $agen[0]->nama_agen;
                $data['data'][$key]['no_wa'] = $agen[0]->no_wa;
            } else {
                $data['data'][$key]['referensi'] = $d['referensi'];
                $data['data'][$key]['no_wa'] = $d['no_wa'];
            }
        }
        echo json_encode($data);
    }

    public function hapus()
    {
        if (!($_SESSION['bagian'] == 'Admin' || $_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Logistik')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id_member', 'id_member', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->model('logistik');
        $pending = $this->logistik->getPendingBooking($_GET['id_member']);
        foreach ($pending['items'] as $p) {
            $hapusPerl = $this->logistik->hapusPending($p->id_perlmember);
        }
        if (!$hapusPerl) {
            $this->alert->set('danger', 'Error. Item Gagal Dihapus.');
        } else {
            $this->alert->set('success', 'Item berhasil dihapus');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function kelola()
    {
        if (!($_SESSION['bagian'] == 'Admin' || $_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Logistik')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id_member', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/perlengkapan_peserta');
        }
        $this->load->model('registrasi');
        $member = $this->registrasi->getMember($_GET['id_member']);
        if (empty($member)) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/perlengkapan_peserta');
        }
        $idPaket = $member[0]->id_paket;

        $this->load->model('logistik');
        $logistikPaket = $this->logistik->getPerlengkapanPaket($idPaket, 'Siap Diambil');

        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage($idPaket, false);

        $jamaah = $this->registrasi->getJamaah($member[0]->id_jamaah);

        $pendingBooking = $this->logistik->getPendingBooking($member[0]->id_member);
        if ($pendingBooking) {
            if ($pendingBooking['items'][0]->jenis_ambil == 'pengiriman') {
                $jenisAmbil = 'pengiriman';
                $noKirim = $pendingBooking['items'][0]->no_pengiriman;
                $alamatKirim = $pendingBooking['items'][0]->alamat_pengiriman;
            }
            if ($pendingBooking['items'][0]->jenis_ambil == 'langsung' || $pendingBooking['items'][0]->jenis_ambil == '' || $pendingBooking['items'][0]->jenis_ambil == null ) {
                $jenisAmbil = 'langsung';
                $noKirim = "-";
                $alamatKirim = "Jln. KH.M Yusuf Raya No.18A-B Mekar Jaya, Depok, Jawa Barat";
            }
        }
        $data = array(
            'member' => $member[0],
            'logistikPaket' => $logistikPaket,
            'pendingBooking' => $pendingBooking,
            'jamaah' => $jamaah,
            'paket' => $paket,
            'noKirim' => $noKirim,
            'alamatKirim' => $alamatKirim,
            'jenisAmbil' => $jenisAmbil

        );
        $this->load->view('staff/kelola_booking', $data);
    }

    public function statusPending() {
        if (!($_SESSION['bagian'] == 'Admin' || $_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Logistik')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->form_validation->set_rules('status', 'status', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/perlengkapan_peserta');
        }

        if(!isset($_POST['items'])) {
            $this->alert->set('danger', 'Tidak ada barang yg dipilih');
            redirect($_SERVER['HTTP_REFERER']);
        }

        
        $items = $_POST['items'];
        $status = $_POST['status'];
        $this->load->model('logistik');
        $pendingAmbil = $this->logistik->setStatusPending($items, $status);
        if (!$pendingAmbil) {
            $this->alert->set('danger', 'Error. Item Gagal DiAmbil.');
        } else {
            $this->alert->set('success', 'Item berhasil Diambil');
            // send notifikasi whatsapp
            if ($_POST['jenis_ambil'] == 'pengiriman') {
                $this->load->model('whatsapp');
                $send = $this->whatsapp->sendPengirimanPerlengkapan($_POST['idm'], $_POST['noWa']);
            }
        }
        redirect(base_url() . 'staff/perlengkapan_pending/status_siap');
    }

    public function load_status()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'perlengkapan_member';
        // Primary key of table
        $primaryKey = 'id_perlmember';

        $columns = array(
            array('db' => '`pm`.`id_member`', 'dt' => 'DT_RowId', 'field' => 'id_member'),
            array('db' => '`pm`.`id_jamaah`', 'dt' => 'id_jamaah', 'field' => 'id_jamaah'),
            array('db' => '`pm`.`id_paket`', 'dt' => 'id_paket', 'field' => 'id_paket'),
            array('db' => '`ag`.`nama_agen`', 'dt' => 'nama_agen', 'field' => 'nama_agen'),
            array('db' => '`pm`.`lunas`', 'dt' => 'lunas', 'field' => 'lunas'),
            array('db' => '`j`.`first_name`', 'dt' => 'first_name', 'field' => 'first_name'),
            array('db' => '`j`.`second_name`', 'dt' => 'second_name', 'field' => 'second_name'),
            array('db' => '`j`.`last_name`', 'dt' => 'last_name', 'field' => 'last_name'),
            array('db' => '`j`.`referensi`', 'dt' => 'referensi', 'field' => 'referensi'),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`second_name`,' ',`j`.`last_name`) AS `whole_name`", 'dt' => "whole_name", 'field' => "whole_name"),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`last_name`) AS `two_name`", 'dt' => "two_name", 'field' => "two_name"),
            array('db' => '`j`.`no_wa`', 'dt' => 'no_wa', 'field' => 'no_wa'),
            array('db' => '`pm`.`paspor_no`', 'dt' => 'paspor_no', 'field' => 'paspor_no'),
            array('db' => '`pm`.`parent_id`', 'dt' => 'parent_id', 'field' => 'parent_id'),
            array('db' => '`pm`.`id_agen`', 'dt' => 'id_agen', 'field' => 'id_agen'),
            array('db' => '`ag`.`nama_agen`', 'dt' => 'nama_agen', 'field' => 'nama_agen'),
            array('db' => '`perl`.`tanggal_ambil`', 'dt' => 'tanggal_ambil', 'field' => 'tanggal_ambil'),
            array('db' => '`perl`.`jenis_ambil`', 'dt' => 'jenis_ambil', 'field' => 'jenis_ambil'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $joinQuery = "FROM `{$table}` AS `perl` JOIN program_member AS pm ON (pm.id_member = perl.id_member) JOIN `jamaah` AS `j` ON (`j`.`id_jamaah` = `pm`.`id_jamaah`) LEFT JOIN agen AS ag ON (ag.id_agen = pm.id_agen)";
        $extraCondition = 'perl.status = "Siap"';
        if ($_GET['jenis_ambil'] != '') {
            if ($_GET['jenis_ambil'] == 'pengiriman') {
                $condition = " AND perl.jenis_ambil = 'pengiriman'";
            } else {
                $condition = " AND perl.jenis_ambil = 'langsung'";
            }
            $extraCondition = $extraCondition . $condition ;
        }
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition, 'perl.id_member, perl.tanggal_ambil');

        //prepare extra data
        $this->load->model('registrasi');
        $this->load->model('logistik');
        $this->load->model('paketUmroh');
        $groupCtr = 0;
        $groupArr = array();
        foreach ($data['data'] as $key => $d) {

            //handle status perlengkapan per member
            $data['data'][$key]['status_perlengkapan'] = $this->logistik->getStatusPerlengkapanMember($d['DT_RowId']);

            $data['data'][$key]['DT_RowAttr'] = array(
                'id_jamaah' => $d['id_jamaah']
            );

            // ambil nama konsultan
            $this->load->model('agen');
            $agen = $this->agen->getAgen($d['id_agen']);

            if ($d['referensi'] == 'Agen') {
                $data['data'][$key]['referensi'] = $agen[0]->nama_agen;
                $data['data'][$key]['no_wa'] = $agen[0]->no_wa;
            } else {
                $data['data'][$key]['referensi'] = $d['referensi'];
                $data['data'][$key]['no_wa'] = $d['no_wa'];
            }

            //determine WG status
            $wg = $this->registrasi->getWG($d['DT_RowId']);
            $data['data'][$key]['wg'] = $wg;

            //set group class
            $parent_id = $d['parent_id'];
            if (!empty($parent_id)) {
                //check in array
                if (!isset($groupArr[$parent_id])) {
                    $groupCtr = $groupCtr + 1;
                    $groupArr[$parent_id] = $groupCtr;
                }
                $data['data'][$key]['DT_RowClass'] = 'group-color-' . $groupArr[$parent_id];
            }
            $paket = $this->paketUmroh->getPackage($d['id_paket'], false);
            $data['data'][$key]['nama_paket'] = $paket->nama_paket . " ( " . date('d F Y', strtotime($paket->tanggal_berangkat)) . " )";
        }

        echo json_encode($data);
    }
    public function status_siap()
    {
        $this->load->view('staff/list/pending_siap');
    }

    public function kelola_ambil()
    {
        if (!($_SESSION['bagian'] == 'Admin' || $_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Logistik')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id_member', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/perlengkapan_peserta');
        }
        $this->load->model('registrasi');
        $member = $this->registrasi->getMember($_GET['id_member']);
        if (empty($member)) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/perlengkapan_peserta');
        }
        $idPaket = $member[0]->id_paket;

        $this->load->model('logistik');
        $logistikPaket = $this->logistik->getPerlengkapanPaket($idPaket, 'Siap Diambil');

        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage($idPaket, false);

        $jamaah = $this->registrasi->getJamaah($member[0]->id_jamaah);

        $pendingBooking = $this->logistik->getPendingBookingStatus($member[0]->id_member);
        if ($pendingBooking) {
            if ($pendingBooking['items'][0]->jenis_ambil == 'pengiriman') {
                $jenisAmbil = 'pengiriman';
                $noKirim = $pendingBooking['items'][0]->no_pengiriman;
                $alamatKirim = $pendingBooking['items'][0]->alamat_pengiriman;
            }
            if ($pendingBooking['items'][0]->jenis_ambil == 'langsung' || $pendingBooking['items'][0]->jenis_ambil == '' || $pendingBooking['items'][0]->jenis_ambil == null ) {
                $jenisAmbil = 'langsung';
                $noKirim = "-";
                $alamatKirim = "Jln. KH.M Yusuf Raya No.18A-B Mekar Jaya, Depok, Jawa Barat";
            }
        }
        $data = array(
            'member' => $member[0],
            'logistikPaket' => $logistikPaket,
            'pendingBooking' => $pendingBooking,
            'jamaah' => $jamaah,
            'paket' => $paket,
            'noKirim' => $noKirim,
            'alamatKirim' => $alamatKirim,
            'jenisAmbil' => $jenisAmbil

        );
        $this->load->view('staff/kelola_ambil', $data);
    }

    public function detail_dl() {
        if (!isset($_SESSION['login'])) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id_member', 'id member', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->load->model('registrasi');
        $this->load->model('logistik');
        $data = $this->logistik->getPengirimanData($_GET['id_member']);
        $data['id_member'] = $_GET['id_member'];
        $data['html'] = $this->load->view('staff/detail_kirim_html', $data, true);
        $this->load->view('staff/detail_kirim_view', $data);
    }

    public function detail_status()
    {
        if (!($_SESSION['bagian'] == 'Admin' || $_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Logistik')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id_member', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/perlengkapan_peserta');
        }
        $this->load->model('registrasi');
        $member = $this->registrasi->getMember($_GET['id_member']);
        if (empty($member)) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/perlengkapan_peserta');
        }
        $idPaket = $member[0]->id_paket;

        $this->load->model('logistik');
        $logistikPaket = $this->logistik->getPerlengkapanPaket($idPaket, 'Siap Diambil');

        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage($idPaket, false);

        $jamaah = $this->registrasi->getJamaah($member[0]->id_jamaah);

        $pendingBooking = $this->logistik->getPendingBookingStatus($member[0]->id_member);
        if ($pendingBooking) {
            if ($pendingBooking['items'][0]->jenis_ambil == 'pengiriman') {
                $jenisAmbil = $pendingBooking['items'][0]->jenis_ambil;
                $noKirim = $pendingBooking['items'][0]->no_pengiriman;
                $alamatKirim = $pendingBooking['items'][0]->alamat_pengiriman;
            }
            if ($pendingBooking['items'][0]->jenis_ambil == 'langsung' || $pendingBooking['items'][0]->jenis_ambil == '' || $pendingBooking['items'][0]->jenis_ambil == null ) {
                $jenisAmbil = 'langsung';
                $noKirim = "-";
                $alamatKirim = "Jln. KH.M Yusuf Raya No.18A-B Mekar Jaya, Depok, Jawa Barat";
            }
        }
        $data = array(
            'member' => $member[0],
            'logistikPaket' => $logistikPaket,
            'pendingBooking' => $pendingBooking,
            'jamaah' => $jamaah,
            'paket' => $paket,
            'noKirim' => $noKirim,
            'alamatKirim' => $alamatKirim,
            'jenisAmbil' => $jenisAmbil,

        );
        $this->load->view('staff/status_booking', $data);
    }

    public function detail_pdf()
    {
        // require composer autoload
        require_once APPPATH . 'third_party/mpdf/vendor/autoload.php';

        $url = urldecode($_REQUEST['url']);
        $serverHost = parse_url(base_url(), PHP_URL_HOST);
        $accessHost = parse_url($url, PHP_URL_HOST);
        // To prevent anyone else using your script to create their PDF files
        if ($serverHost != $accessHost) {
            die("Access denied");
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        // forward current cookies to curl
        $cookies = array();
        foreach ($_COOKIE as $key => $value) {
            if ($key != 'Array') {
                $cookies[] = $key . '=' . $value;
            }
        }
        
        
        curl_setopt($ch, CURLOPT_COOKIE, implode(';', $cookies));
        // Stop session so curl can use the same session without conflicts
        session_write_close();
        $html = curl_exec($ch);
        curl_close($ch);
        // Session restart
        session_start();

        $mpdf = new \mPDF();

        $mpdf->useSubstitutions = true; // optional - just as an example
        $mpdf->CSSselectMedia = 'mpdf'; // assuming you used this in the document header
        $filename = 'SPP_'. $_GET['nama'] . '.pdf';
        $mpdf->setBasePath($url);
        $mpdf->WriteHTML($html);

        $mpdf->Output($filename, 'D');
    }

    public function hapus_status()
    {
        if (!($_SESSION['bagian'] == 'Admin' || $_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Logistik')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id_member', 'id_member', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->model('logistik');
        $pending = $this->logistik->getPendingBookingStatus($_GET['id_member']);
        $items = [];
        foreach ($pending['items'] as $p) {
            $items[] = $p->id_perlmember;
        }
        $hapusPerl = $this->logistik->setStatusPending($items, 'Pending');
        if (!$hapusPerl) {
            $this->alert->set('danger', 'Error. Item Gagal Dihapus.');
        } else {
            $this->alert->set('success', 'Item berhasil dihapus');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
}
        
    /* End of file  staff/Perlengkapan_pending.php */