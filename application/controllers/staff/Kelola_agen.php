<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Kelola_agen extends CI_Controller
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
        $this->load->view('staff/agen_view');
    }

    public function jamaah_agen()
    {
        $this->load->model('komisiConfig');
        $musimGroup = $this->komisiConfig->groupByMusim();
        $data = [ 
            'musimGroup' => $musimGroup
        ];
        $this->load->view('staff/lihat_jamaah_agen', $data);
    }
    public function tambah()
    {

        //get all available paket
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage(null, false, true, true);


        $this->load->model('region');
        $province = $this->region->getProvince();
        $regency = $this->region->getRegency(null, $province[0]->id);
        $districts = $this->region->getDistrict(null, $regency[0]->id);
        $this->load->model('agen');
        $agenList = $this->agen->getAgen();
        $this->load->view('staff/agen_tambah', $data = array(
            'paket' => $paket,
            'provinsi' => $province,
            'kabupaten' => $regency,
            'kecamatan' => $districts,
            'agenList' => $agenList
        ));
    }

    public function getKota()
    {
        $term = $this->input->get('term');
        $this->load->model('region');
        $kota = $this->region->getRegionAutoComplete($term);
        echo json_encode($kota);
    }
    public function getRegencies()
    {
        $provId = $this->input->get('provId');
        $this->load->model('region');
        $regency = $this->region->getRegency(null, $provId);
        echo json_encode($regency);
    }

    public function getDistricts()
    {
        $regId = $this->input->get('regId');
        $this->load->model('region');
        $districts = $this->region->getDistrict(null, $regId);
        echo json_encode($districts);
    }

    public function getTempatLahir()
    {
        $term = $this->input->get('term');
        $this->load->model('region');
        $kota = $this->region->getRegionAutoComplete($term);
        echo json_encode($kota);
    }

    public function getCountries()
    {
        $term = $this->input->get('term');
        $this->load->model('region');
        $negara = $this->region->getCountriesAutoComplete($term);
        echo json_encode($negara);
    }

    public function proses_tambah()
    {
        if (!isset($_POST)) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $data = (array) $_POST;
        if (!empty($_FILES['mou_doc']['name'])) {
            $data['files']['mou_doc'] = $_FILES['mou_doc'];
        }
        $this->load->model('agen');
        $tambah = $this->agen->tambahAgen($data);
        if ($tambah['status'] == 'success') {
            $this->alert->set('success', 'Agen berhasil ditambahkan.');
        } else {
            $this->alert->set('danger', $tambah['msg']);
        }
        redirect(base_url() . 'staff/kelola_agen/tambah');
    }

    public function atur_poin()
    {
        if (empty($_GET['id'])) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/kelola_agen');
        }
        $this->load->model('agen');
        $data = $this->agen->getAgen($_GET['id']);
        if (empty($data)) {
            $this->alert->set('danger', 'Data tidak ditemukan');
            redirect(base_url() . 'staff/kelola_agen');
        }
        $data = $data[0];
        $this->load->view('staff/atur_poin', $data);
    }

    public function proses_atur_poin()
    {
        $this->form_validation->set_rules('id_agen', 'id agen', 'trim|required|integer');
        $this->form_validation->set_rules('unclaimed_point', 'Unclaimed Points', 'trim|required|integer');
        $this->form_validation->set_rules('claimed_point', 'Claimed Points', 'trim|required|integer');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/kelola_agen');
        }

        $this->load->model('poinAgen');
        $atur = $this->poinAgen->aturUlang($_POST['id_agen'], $_POST['unclaimed_point'], $_POST['claimed_point'], $_POST['keterangan']);
        if ($atur == false) {
            $this->alert->set('danger', 'Pengaturan Poin Gagal');
        } else {
            $this->alert->set('success', 'Pengaturan Poin Berhasil');
        }
        redirect(base_url() . 'staff/kelola_agen/profile?id=' . $_POST['id_agen']);
    }

    public function histori_poin()
    {
        if (empty($_GET['id'])) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/kelola_agen');
        }
        $this->load->model('poinAgen');
        $history = $this->poinAgen->getHistory($_GET['id']);
        if ($history['status'] == 'error') {
            $this->alert->set('danger', $history['msg']);
            redirect(base_url() . 'staff/kelola_agen');
        }
        $this->load->model('agen');
        $profile = $this->agen->getAgen($_GET['id']);
        $data = array(
            'history' => $history['data'],
            'profile' => $profile[0]
        );
        $this->load->view('staff/histori_poin', $data);
    }

    public function klaim()
    {
        if (empty($_GET['id'])) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/kelola_agen');
        }
        $this->load->model('agen');
        $data = $this->agen->getAgen($_GET['id']);
        if (empty($data)) {
            $this->alert->set('danger', 'Data tidak ditemukan');
            redirect(base_url() . 'staff/kelola_agen');
        }
        $data = $data[0];
        $this->load->view('staff/agen_klaim_reward', $data);
    }

    public function proses_klaim()
    {
        $this->form_validation->set_rules('id_agen', 'id agen', 'trim|required|integer');
        $this->form_validation->set_rules('point', 'Unclaimed Points', 'trim|required|integer');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/kelola_agen');
        }

        $this->load->model('poinAgen');
        $klaim = $this->poinAgen->klaimReward($_POST['id_agen'], $_POST['point'], $_POST['keterangan']);
        if ($klaim['status'] == 'error') {
            $this->alert->set('danger', $klaim['msg']);
            redirect(base_url() . 'staff/kelola_agen/klaim?id=' . $_POST['id_agen']);
        } else {
            $this->alert->set('success', $klaim['msg']);
            redirect(base_url() . 'staff/kelola_agen/profile?id=' . $_POST['id_agen']);
        }
    }

    public function jamaah()
    {
        if (!isset($_GET['id'])) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $id = $_GET['id'];
        $this->load->model('agen');
        $agen = $this->agen->getAgen($id);
        if (empty($agen)) {
            $this->alert->set('danger', 'Agen tidak terdaftar');
            redirect(base_url() . 'staff/kelola_agen');
        }
        $agen = $agen[0];

        $this->load->library('date');
        $musim = $this->date->getMusim($_GET['musim']);
        $agen->musim = $musim;
        $this->load->view('staff/jamaah_agen', $agen);
    }

    public function profile()
    {
        if (empty($_GET['id'])) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }

        $this->load->model('agen');
        $data = $this->agen->getAgen($_GET['id']);
        if (empty($data)) {
            $this->alert->set('danger', 'Data tidak ditemukan');
            redirect(base_url() . 'staff/kelola_agen');
        }
        $data = $data[0];
        if ($data->tanggal_terdaftar == null || $data->tanggal_terdaftar == '0000-00-00') {
            $data->tanggal_terdaftar = '-';
        } else {
            $data->tanggal_terdaftar = date_format(date_create($data->tanggal_terdaftar), "d M Y");
        }

        $this->load->model('komisiConfig');
        $poin = $this->komisiConfig->getTotalPoin($_GET['id']);
        $data->poin = $poin;

        $this->load->view('staff/agen_profile', $data);
    }

    public function ubah_profile()
    {
        if (!isset($_GET['id'])) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->load->model('agen');
        $data = $this->agen->getAgen($_GET['id']);
        if (empty($data)) {
            $this->alert->set('danger', 'Data tidak ditemukan');
            redirect(base_url() . 'staff/kelola_agen');
        }
        $this->load->model('region');
        $province = $this->region->getProvince();
        $regency = $this->region->getRegency(null, $province[0]->id);
        $districts = $this->region->getDistrict(null, $regency[0]->id);
        $this->load->view('staff/agen_ubah_profile', $data = array(
            'provinsi' => $province,
            'kabupaten' => $regency,
            'kecamatan' => $districts,
            'dataAgen' => $data[0]
        ));
    }

    public function hapus_pic()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id_agen', 'id_agen', 'trim|required|integer');
        $this->form_validation->set_rules('field', 'field', 'required');

        if ($this->form_validation->run() == FALSE) {
            return false;
        }
        $this->load->model('agen');
        $result = $this->agen->deletePic($_GET['id_agen'], $_GET['field']);
        if ($result == true) {
            echo json_encode(true);
        } else {
            return false;
        }
    }

    public function proses_ubah()
    {
        if (!isset($_POST)) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/kelola_agen');
        }
        if (!isset($_POST['id_agen'])) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/kelola_agen');
        }
        $id_agen = $_POST['id_agen'];
        unset($_POST['id_agen']);
        $this->load->model('agen');

        $update = $this->agen->editAgen($id_agen, $_POST);

        if ($update['status'] == 'success') {
            $this->alert->set('success', 'Data berhasil diubah.');
        } else {
            $this->alert->set('danger', $update['msg']);
        }
        redirect(base_url() . 'staff/kelola_agen/profile?id=' . $id_agen);
    }

    public function ganti_pic()
    {
        if (!isset($_POST)) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/kelola_agen');
        }
        if (!isset($_POST['id_agen'])) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/kelola_agen');
        }
        $this->load->model('agen');
        $this->agen->changePic($_POST['id_agen'], $_FILES['file']);
        redirect(base_url() . 'staff/kelola_agen/profile?id=' . $_POST['id_agen']);
    }

    public function upload_mou()
    {
        if (!isset($_POST)) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/kelola_agen');
        }
        if (!isset($_POST['id_agen'])) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/kelola_agen');
        }
        $this->load->model('agen');
        $this->agen->changeMou($_POST['id_agen'], $_FILES['file']);
        redirect(base_url() . 'staff/kelola_agen/profile?id=' . $_POST['id_agen']);
    }

    public function dl_mou()
    {
        if (isset($_GET['id_agen'])) {
            $this->load->model('agen');
            $data = $this->agen->getAgen($_GET['id_agen']);
            $filename = $data[0]->mou_doc;

            if (file_exists(SITE_ROOT . $filename)) {
                redirect(base_url() . $filename);
            } else {
                $this->alert->setJamaah('red', 'Ups...', 'File tidak tersedia');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function hapus_mou()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id_agen', 'id_agen', 'trim|required|integer');
        $this->form_validation->set_rules('field', 'field', 'required');

        if ($this->form_validation->run() == FALSE) {
            return false;
        }
        $this->load->model('agen');
        $result = $this->agen->deleteMou($_GET['id_agen'], $_GET['field']);
        if ($result == true) {
            echo json_encode(true);
        } else {
            return false;
        }
    }

    public function suspend()
    {
        if (!isset($_GET['id'])) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/kelola_agen');
        }
        $this->load->model('agen');
        $suspend = $this->agen->setSuspend($_GET['id']);
        $this->alert->set($suspend['status'], $suspend['msg']);
        redirect(base_url() . 'staff/kelola_agen/profile?id=' . $_GET['id']);
    }

    public function hapus()
    {
        if (!isset($_GET['id'])) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/kelola_agen');
        }
        $this->load->model('agen');
        $hapus = $this->agen->hapusAgen($_GET['id']);
        $this->alert->set($hapus['status'], $hapus['msg']);
        redirect(base_url() . 'staff/kelola_agen');
    }

    public function load_agen()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'agen';
        $tableAlias = 'main_agen';
        // Primary key of table
        $primaryKey = 'id_agen';
        $this->load->library('date');
        $musim = $this->date->getMusim();
        $tglAwal = $musim['tglAwal'];
        $tglAkhir = $musim['tglAkhir'];
        $columns = array(
            array('db' => 'id_agen', 'dt' => 'DT_RowId'),
            array('db' => 'nama_agen', 'dt' => 'nama_agen'),
            array('db' => 'tanggal_terdaftar', 'dt' => 'tanggal_terdaftar'),
            array('db' => 'no_agen', 'dt' => 'no_agen'),
            array('db' => 'no_wa', 'dt' => 'no_wa'),
            array('db' => 'email', 'dt' => 'email'),
            array('db' => 'nama_bank', 'dt' => 'nama_bank'),
            array('db' => 'no_rekening', 'dt' => 'no_rekening'),
            array('db' => 'kota', 'dt' => 'kota'),
            array('db' => 'provinsi', 'dt' => 'provinsi'),
            array('db' => 'kecamatan', 'dt' => 'kecamatan'),
            array('db' => 'alamat', 'dt' => 'alamat'),
            array('db' => "(SELECT nama_agen FROM agen WHERE id_agen = main_agen.upline_id)", 'as' => 'upline_name', 'dt' => 'upline_name'),
            array('db' => "(SELECT count(*) FROM program_member pm JOIN paket_umroh pu ON pu.id_paket = pm.id_paket WHERE id_agen = $tableAlias.id_agen AND tanggal_berangkat >= '$tglAwal' AND tanggal_berangkat <='$tglAkhir')", 'as' => 'jumlah_jamaah', 'dt' => 'jumlah_jamaah'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );

        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, null, '', '', '', $tableAlias);
        echo json_encode($data);
    }

    public function load_agen_jamaah()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'agen';
        $tableAlias = 'main_agen';
        // Primary key of table
        $primaryKey = 'id_agen';
        $this->load->library('date');
        if ($_GET['musim'] != '') {
            $musim = $this->date->getMusim($_GET['musim']);
        } else {
            $musim = $this->date->getMusim();
        }
        $tglAwal = $musim['tglAwal'];
        $tglAkhir = $musim['tglAkhir'];
        $columns = array(
            array('db' => 'id_agen', 'dt' => 'DT_RowId'),
            array('db' => 'nama_agen', 'dt' => 'nama_agen'),
            array('db' => 'tanggal_terdaftar', 'dt' => 'tanggal_terdaftar'),
            array('db' => 'no_agen', 'dt' => 'no_agen'),
            array('db' => 'no_wa', 'dt' => 'no_wa'),
            array('db' => 'email', 'dt' => 'email'),
            array('db' => 'nama_bank', 'dt' => 'nama_bank'),
            array('db' => 'no_rekening', 'dt' => 'no_rekening'),
            array('db' => 'kota', 'dt' => 'kota'),
            array('db' => 'provinsi', 'dt' => 'provinsi'),
            array('db' => 'kecamatan', 'dt' => 'kecamatan'),
            array('db' => 'alamat', 'dt' => 'alamat'),
            array('db' => "(SELECT nama_agen FROM agen WHERE id_agen = main_agen.upline_id)", 'as' => 'upline_name', 'dt' => 'upline_name'),
            array('db' => "(SELECT count(*) FROM program_member pm JOIN paket_umroh pu ON pu.id_paket = pm.id_paket WHERE id_agen = $tableAlias.id_agen AND tanggal_berangkat >= '$tglAwal' AND tanggal_berangkat <='$tglAkhir')", 'as' => 'jumlah_jamaah', 'dt' => 'jumlah_jamaah'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );

        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, null, '', '', '', $tableAlias);
        echo json_encode($data);
    }

    public function load_peserta()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'program_member';
        // Primary key of table
        $primaryKey = 'id_member';

        $columns = array(
            array('db' => '`pm`.`id_member`', 'dt' => 'DT_RowId', 'field' => 'id_member'),
            array('db' => '`pm`.`id_jamaah`', 'dt' => 'id_jamaah', 'field' => 'id_jamaah'),
            array('db' => '`j`.`first_name`', 'dt' => 'first_name', 'field' => 'first_name'),
            array('db' => '`j`.`second_name`', 'dt' => 'second_name', 'field' => 'second_name'),
            array('db' => '`j`.`last_name`', 'dt' => 'last_name', 'field' => 'last_name'),
            array('db' => '`j`.`kabupaten_kota`', 'dt' => 'kabupaten_kota', 'field' => 'kabupaten_kota'),
            array('db' => '`pm`.`paspor_no`', 'dt' => 'paspor_no', 'field' => 'paspor_no'),
            array('db' => '`j`.`no_wa`', 'dt' => 'no_wa', 'field' => 'no_wa'),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`second_name`,' ',`j`.`last_name`) AS `whole_name`", 'dt' => "whole_name", 'field' => "whole_name"),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`last_name`) AS `two_name`", 'dt' => "two_name", 'field' => "two_name"),
            array('db' => '`pu`.`nama_paket`', 'dt' => 'nama_paket', 'field' => 'nama_paket'),
            array(
                'db' => '`pu`.`tanggal_berangkat`', 'dt' => 'tanggal_berangkat', 'formatter' => function ($d, $row) {
                    return date_format(date_create($d), "d M Y");
                }, 'field' => 'tanggal_berangkat'
            )
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $id_agen = $_GET['id_agen'];
        $this->load->library('date');
        if ($_GET['musim'] == '') {
            $musim = $this->date->getMusim();
        } else {
            $musim = $this->date->getMusim($_GET['musim']);
        }
        $joinQuery = "FROM `{$table}` AS `pm` LEFT JOIN `jamaah` AS `j` ON (`j`.`id_jamaah` = `pm`.`id_jamaah`) LEFT JOIN `paket_umroh` AS `pu` ON (`pu`.`id_paket` = `pm`.`id_paket`)";
        $extraCondition = "`id_agen`='" . $id_agen . "' AND `pu`.`tanggal_berangkat` >= '" . $musim['tglAwal'] . "' AND `pu`.`tanggal_berangkat` <= '" . $musim['tglAkhir']  ."'";
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition);

        //prepare extra data
        $this->load->model('registrasi');
        $groupCtr = 0;
        $groupArr = array();
        foreach ($data['data'] as $key => $d) {
            $data['data'][$key]['DT_RowAttr'] = array(
                'id_jamaah' => $d['id_jamaah']
            );

            //determine WG status
            $wg = $this->registrasi->getWG($d['DT_RowId']);
            $data['data'][$key]['wg'] = $wg;
        }
        echo json_encode($data);
    }
    public function agen_autocomplete()
    {
        $term = $_GET['term'];
        $this->load->model('agen');
        $data = $this->agen->getAgenByName($term);
        echo json_encode($data);
    }

    public function lihat_poin() {
        $this->load->model('komisiConfig');
        $musimGroup = $this->komisiConfig->groupByMusim($_GET['id']);
        $data = [ 
            'id_agen' => $_GET['id'],
            'musimGroup' => $musimGroup
        ];
        $this->load->view('staff/lihat_poin_agen', $data );
    }

    public function load_poin() {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'komisi_poin_pribadi';
        // Primary key of table
        $primaryKey = 'id_poin';

        $columns = array(
            array('db' => '`kpp`.`id_poin`', 'dt' => 'DT_RowId', 'field' => 'id_poin'),
            array('db' => '`pm`.`id_jamaah`', 'dt' => 'id_jamaah', 'field' => 'id_jamaah'),
            array('db' => '`j`.`first_name`', 'dt' => 'first_name', 'field' => 'first_name'),
            array('db' => '`j`.`second_name`', 'dt' => 'second_name', 'field' => 'second_name'),
            array('db' => '`j`.`last_name`', 'dt' => 'last_name', 'field' => 'last_name'),
            array('db' => '`j`.`no_wa`', 'dt' => 'no_wa', 'field' => 'no_wa'),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`second_name`,' ',`j`.`last_name`) AS `whole_name`", 'dt' => "whole_name", 'field' => "whole_name"),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`last_name`) AS `two_name`", 'dt' => "two_name", 'field' => "two_name"),
            array('db' => '`pu`.`nama_paket`', 'dt' => 'nama_paket', 'field' => 'nama_paket'),
            array('db' => '`kpp`.`id_member`', 'dt' => 'id_member', 'field' => 'id_member'),
            array('db' => '`kpp`.`id_agen`', 'dt' => 'id_agen', 'field' => 'id_agen'),
            array('db' => '`kpp`.`poin`', 'dt' => 'poin', 'field' => 'poin'),
            array('db' => '`kpp`.`tanggal_insert`', 'dt' => 'tanggal_insert', 'field' => 'tanggal_insert'),
            array('db' => '`kpp`.`keterangan`', 'dt' => 'keterangan', 'field' => 'keterangan'),
            array('db' => '`kpp`.`musim`', 'dt' => 'musim', 'field' => 'musim'),
            array(
                'db' => '`pu`.`tanggal_berangkat`', 'dt' => 'tanggal_berangkat', 'formatter' => function ($d, $row) {
                    return date_format(date_create($d), "d M Y");
                }, 'field' => 'tanggal_berangkat'
            )
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $id_agen = $_GET['id_agen'];
        $this->load->library('date');
        if ($_GET['musim'] == '') {
            $musim = $this->date->getMusim();
        } else {
            $musim = $this->date->getMusim($_GET['musim']);
        }
        $joinQuery = "FROM `{$table}` AS `kpp` LEFT JOIN `program_member` AS `pm` ON (`pm`.`id_member` = `kpp`.`id_member`) LEFT JOIN `paket_umroh` AS `pu` ON (`pu`.`id_paket` = `pm`.`id_paket`) LEFT JOIN `jamaah` AS `j` ON (`j`.`id_jamaah` = `pm`.`id_jamaah`) LEFT JOIN `agen` AS `a` ON (`a`.`id_agen` = `kpp`.`id_agen`)";
        $extraCondition = "`kpp`.`id_agen`='" . $id_agen . "' AND `pu`.`tanggal_berangkat` >= '" . $musim['tglAwal'] . "' AND `pu`.`tanggal_berangkat` <= '" . $musim['tglAkhir']  ."'";
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition);
        echo json_encode($data);
    }
}