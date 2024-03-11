<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Agen_paket extends CI_Controller
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
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function index() {
        $this->load->model('agenPaket');
        $this->load->library('Date');
        $monthPackage = $this->agenPaket->getAvailMonths(false);
        $data = array (
            'monthPackage' => $monthPackage
        );
        $this->load->view('staff/agen_paket_list', $data);
    }

    public function tambah() {
        $this->load->view('staff/tambah_agen_paket');
    }

    public function proses_tambah() {
        $this->form_validation->set_rules('nama_paket', 'Nama Program', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('harga', 'Harga', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect(base_url() . 'staff/agen_paket/tambah');
        }
        $data = $_POST;
        $data['harga'] = str_replace(",","",$data['harga']);
        $data['diskon_member_baru'] = str_replace(",","",$data['diskon_member_baru']);
        $data['diskon_member_lama'] = str_replace(",","",$data['diskon_member_lama']);
        $data['diskon_eks_jamaah'] = str_replace(",","",$data['diskon_eks_jamaah']);
        if (!empty($_FILES['agen_banner_image']['name'])) {
            $data['agen_banner_image'] = $_FILES['agen_banner_image'];
        }
        //add new package
        $this->load->model('agenPaket');
        if (!($id = $this->agenPaket->addAgenPackage($data))) {
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            redirect(base_url() . 'staff/agen_paket/lihat?id=' . $id);
        }
    }

    public function load_paket()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'agen_paket';
        // Primary key of table
        $primaryKey = 'id';

        $columns = array(
            array('db' => 'id', 'dt' => 'DT_RowId'),
            array('db' => 'nama_paket', 'dt' => 0),
            array(
                'db' => 'harga',
                'dt' => 1,
                'formatter' => function ($d, $row) {
                    return number_format($d);
                }
            ),
            array(
                'db' => 'active',
                'dt' => 2,
                'formatter' => function ($d, $row) {
                    if ($d == 1) {
                        return "Ya";
                    } else {
                        return "Tidak";
                    }
                }
            ),
            array('db' => 'published_at', 'dt' => 3),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, null);

        // $this->load->model('bcast');
        // foreach ($data['data'] as $key => $item) {
        //     $broadcast = $this->bcast->getPesan(null, $data['data'][$key]['DT_RowId']);
        //     if ($broadcast != null) {
        //         $data['data'][$key]['status_bcast'] = 1;
        //     } else {
        //         $data['data'][$key]['status_bcast'] = 0;
        //     }
        // }

        echo json_encode($data);
    }

    public function lihat()
    {
        if (!($_SESSION['email'] == 'master@ventour.co.id' || $_SESSION['bagian'] == 'PR')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->model('agenPaket');
        $data = $this->agenPaket->getAgenPackage($_GET['id'], false);
        if (empty($data)) {
            $this->alert->set('danger', 'Paket tidak ditemukan');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->load->view('staff/agen_paket_view', $data);
    }

    public function ubah()
    {
        if (!($_SESSION['email'] == 'master@ventour.co.id' || $_SESSION['bagian'] == 'PR')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->load->model('agenPaket');
        $data = $this->agenPaket->getAgenPackage($_GET['id'], false);
        if (empty($data)) {
            $this->alert->set('danger', 'Paket tidak ditemukan');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->view('staff/agen_ubah_paket', $data);
    }

    public function proses_ubah()
    {
        $this->form_validation->set_rules('id', 'ID Program', 'trim|required|numeric');
        $this->form_validation->set_rules('nama_paket', 'Nama Paket', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('harga', 'Harga', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        }

        //add new package
        $this->load->model('agenPaket');
        $data = $_POST;
        $data['harga'] = str_replace(",","",$data['harga']);
        $data['diskon_member_baru'] = str_replace(",","",$data['diskon_member_baru']);
        $data['diskon_member_lama'] = str_replace(",","",$data['diskon_member_lama']);
        $data['diskon_eks_jamaah'] = str_replace(",","",$data['diskon_eks_jamaah']);
        if (!empty($_FILES['agen_gambar_banner']['name'])) {
            $data['agen_gambar_banner'] = $_FILES['agen_gambar_banner'];
        }

        if (!($id = $this->agenPaket->editAgenPackage($data['id'], $data))) {
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            redirect(base_url() . 'staff/agen_paket/lihat?id=' . $id);
        }
    }

    public function upload()
    {

        if (!($_SESSION['email'] == 'master@ventour.co.id' || $_SESSION['bagian'] == 'PR')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->load->model('agenPaket');
        $up = $this->agenPaket->uploadDokumen($_FILES, $_POST['id']);
        redirect(base_url() . 'staff/agen_paket/lihat?id=' . $_POST['id']);
    }

    public function delete_upload() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
        $this->form_validation->set_rules('field', 'field', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->model('agenPaket');
        $result = $this->agenPaket->deleteDokumen($_GET['id'], $_GET['field']);
        if ($result) {
            $this->alert->set('success', "Data berhasil dihapus");
        } else {
            $this->alert->set('danger', "Data gagal dihapus");
        }
        redirect(base_url() . 'staff/agen_paket/lihat?id=' . $_GET['id']);
        
    }

    public function list_event() {
        $this->load->view('staff/agen_event_list');
    }

    public function load_event()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'agen_event';
        // Primary key of table
        $primaryKey = 'id';

        $columns = array(
            array('db' => '`ae`.`id`', 'dt' => 'DT_RowId', 'field' => 'id'),
            array('db' => '`ae`.`id_paket`', 'dt' => 'id_paket', 'field' => 'id_paket'),
            array('db' => '`ap`.`nama_paket`', 'dt' => 'nama_paket', 'field' => 'nama_paket'),
            array('db' => '`ap`.`harga`', 'dt' => 'harga', 'field' => 'harga'),
            array('db' => '`ae`.`tanggal`', 'dt' => 'tanggal', 'field' => 'tanggal'),
            array('db' => '`ae`.`tanggal_selesai`', 'dt' => 'tanggal_selesai', 'field' => 'tanggal_selesai'),
            array('db' => '`ae`.`pax`', 'dt' => 'pax', 'field' => 'pax'),
            array('db' => '`ae`.`lokasi`', 'dt' => 'lokasi', 'field' => 'lokasi'),
            array('db' => '`ae`.`publish`', 'dt' => 'publish', 'field' => 'publish'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $joinQuery = "FROM `{$table}` AS `ae` LEFT JOIN `agen_paket` AS `ap` ON (`ap`.`id` = `ae`.`id_paket`)";
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery);
        foreach ($data['data'] as $key => $d) {
            $data['data'][$key]['harga'] = 'Rp. ' . number_format($data['data'][$key]['harga'], 0, ',', '.') . ',-';

            //get data
            $this->load->model('agenPaket');
            $paket = $this->agenPaket->getAgenEvent(null, $d['id_paket']);

            foreach ($paket as $pkt => $p) {
                if ($d['DT_RowId'] == $p->id) {
                    // ganti romawi
                    $this->load->library('date');
                    $data['data'][$key]['batch'] = 'Batch '. $this->date->convert_romawi($pkt+1);
                }
            }
            $data['data'][$key]['DT_RowAttr'] = array(
                'id_paket' => $d['id_paket'],
                'nama' => $d['nama_paket'] . ' ' . $data['data'][$key]['batch']
            );
        }
        echo json_encode($data);
    }

    public function tambah_event() {
        $this->load->model('agenPaket');
        $agenPaket = $this->agenPaket->getAgenPackage();
        $data = [
            'agenPaket' => $agenPaket
        ];

        $this->load->view('staff/tambah_agen_event', $data);

    }

    public function proses_tambah_event() {
        $this->form_validation->set_rules('id_paket', 'Nama Program', 'trim|required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
        $this->form_validation->set_rules('pax', 'Jumlah Pax', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect(base_url() . 'staff/agen_paket/tambah_event');
        }

        //proses tambah agen_event
        $this->load->model('agenPaket');
        if (!($id = $this->agenPaket->addAgenEvent($_POST))) {
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            redirect(base_url() . 'staff/agen_paket/list_event');
        }
    }

    public function ubah_event() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', "trim|required|integer");
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', "Access Denied");
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->load->model('agenPaket');
        $agenEvent= $this->agenPaket->getAgenEvent($_GET['id']);
        $agenPaket = $this->agenPaket->getAgenPackage();
        $data = [
            'agenEvent' => $agenEvent[0],
            'agenPaket' => $agenPaket
        ];
        $this->load->view('staff/ubah_agen_event', $data);

    }

    public function proses_ubah_event() {
        $this->form_validation->set_rules('id', 'ID', 'trim|required|integer');
        $this->form_validation->set_rules('id_paket', 'Nama Program', 'trim|required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
        $this->form_validation->set_rules('pax', 'Jumlah Pax', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        }

        //proses tambah agen_event
        $this->load->model('agenPaket');
        if (!($id = $this->agenPaket->updateAgenEvent($_POST))) {
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            redirect(base_url() . 'staff/agen_paket/list_event');
        }
    }

    public function insert() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }

        // get program_member
        $this->load->model('agenPaket');
        $agenEvent = $this->agenPaket->getAgenEvent($_GET['id']);
        $agenPesertaEvent = $this->agenPaket->getAgenPesertaEvent($agenEvent[0]->id);
        $limit = $agenEvent[0]->pax - (count($agenPesertaEvent));
        
        
        $this->load->model('agenPaket');
        $agenPaket = $this->agenPaket->addPesertaAgenEvent($_GET['id_paket'], $agenEvent[0]->id, $limit);
        if ($agenPaket['msg'] == 'success') {
            $this->alert->set("$agenPaket[msg]", "$agenPaket[desc]");
            redirect(base_url() . 'staff/agen_paket/list_event');
        } else {
            $this->alert->set("$agenPaket[msg]", "$agenPaket[desc]");
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function list_konsultan_event() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        } else {
            $id = '';
        }

        $this->load->model('agenPaket');
        $agenPaket = $this->agenPaket->getAgenPesertaEvent(null, null, null, 'id_paket');
        $data = [
            'id' => $id,
            'agenPaket' => $agenPaket,
            'nama_paket' => $_GET['nama']
        ];
        $this->load->view('staff/list_konsultan_event', $data);
    }

    public function load_event_peserta()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'agen_peserta_event';
        // Primary key of table
        $primaryKey = 'id';

        $columns = array(
            array('db' => '`ape`.`id`', 'dt' => 'DT_RowId', 'field' => 'id'),
            array('db' => '`ape`.`id_event`', 'dt' => 'id_event', 'field' => 'id_event'),
            array('db' => '`ape`.`id_peserta`', 'dt' => 'id_peserta', 'field' => 'id_peserta'),
            array('db' => '`app`.`id_agen`', 'dt' => 'id_agen', 'field' => 'id_agen'),
            array('db' => '`a`.`nama_agen`', 'dt' => 'nama_agen', 'field' => 'nama_agen'),
            array('db' => '`ae`.`tanggal`', 'dt' => 'tanggal', 'field' => 'tanggal'),
            array('db' => '`ae`.`tanggal_selesai`', 'dt' => 'tanggal_selesai', 'field' => 'tanggal_selesai'),
            // array('db' => '`app`.`id_paket`', 'dt' => 'id_paket', 'field' => 'id_paket'),
            array('db' => '`ap`.`nama_paket`', 'dt' => 'nama_paket', 'field' => 'nama_paket'),

        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $joinQuery = "FROM `{$table}` AS `ape`"
        . "LEFT JOIN `agen_event` AS `ae` ON (`ae`.`id` = `ape`.`id_event`)"
        . "LEFT JOIN `agen_paket` AS `ap` ON (`ap`.`id` = `ae`.`id_paket`)"
        . "LEFT JOIN `agen_peserta_paket` AS `app` ON (`app`.`id_agen_peserta` = `ape`.`id_peserta`)"
        . "LEFT JOIN `agen` AS `a` ON (`a`.`id_agen` = `app`.`id_agen`)";
        $extraCondition = "`ape`.`id_event` = $_GET[id]";
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition);
        foreach ($data['data'] as $key => $d) {
            $data['data'][$key]['DT_RowAttr'] = array(
                'id_agen' => $d['id_agen'],
                'id_peserta' => $d['id_peserta']
            );
        }
        echo json_encode($data);
    }

    public function hapus() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->model('agenPaket');
        $event = $this->agenPaket->deleteAgenEvent($_GET['id']);
        if ($event) {
            $this->alert->set('success', 'Event berhasil dihapus');
        } else {
            $this->alert->set('danger', 'Event gagal dihapus');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function hapus_event_peserta() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
        $this->form_validation->set_rules('idp', 'idp', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->model('agenPaket');
        $event = $this->agenPaket->deleteAgenPesertaEvent($_GET['id'], $_GET['idp']);
        if ($event) {
            $this->alert->set('success', 'Data Konsultan berhasil dihapus');
        } else {
            $this->alert->set('danger', 'Data Konsultan gagal dihapus');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
}