<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Komisi extends CI_Controller
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

    public function index() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied.');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->model('agen');
        $agen = $this->agen->getAgen($_GET['id']);

        $data = array (
            'agen' => $agen[0]
        );

        $this->load->view('staff/komisi_langsung_view', $data);
    }

    public function load_komisi()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'komisi_langsung';
        // Primary key of table
        $primaryKey = 'id_komisi';

        $columns = array(
            array('db' => '`k`.`id_komisi`', 'dt' => 'DT_RowId', 'field' => 'id_komisi'),
            array('db' => '`k`.`id_konsultan`', 'dt' => 'id_konsultan', 'field' => 'id_konsultan'),
            array('db' => '`k`.`id_member`', 'dt' => 'id_member', 'field' => 'id_member'),
            array('db' => '`k`.`nominal`', 'dt' => 'nominal', 'field' => 'nominal'),
            array('db' => '`k`.`ket`', 'dt' => 'ket', 'field' => 'ket'),
            array('db' => '`k`.`tanggal`', 'dt' => 'tanggal', 'field' => 'tanggal'),
            array('db' => '`j`.`first_name`', 'dt' => 'first_name', 'field' => 'first_name'),
            array('db' => '`j`.`second_name`', 'dt' => 'second_name', 'field' => 'second_name'),
            array('db' => '`j`.`last_name`', 'dt' => 'last_name', 'field' => 'last_name'),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`second_name`,' ',`j`.`last_name`) AS `whole_name`", 'dt' => "whole_name", 'field' => "whole_name"),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`last_name`) AS `two_name`", 'dt' => "two_name", 'field' => "two_name"),
            array('db' => '`pu`.`id_paket`', 'dt' => 'id_paket', 'field' => 'id_paket'),
            array('db' => '`pu`.`nama_paket`', 'dt' => 'nama_paket', 'field' => 'nama_paket'),
            array('db' => '`pu`.`tanggal_berangkat`', 'dt' => 'tanggal_berangkat', 'field' => 'tanggal_berangkat'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $id_agen = $_GET['id_agen'];
        $joinQuery = "FROM `{$table}` AS `k` LEFT JOIN `program_member` AS `pm` ON (`pm`.`id_member` = `k`.`id_member`) LEFT JOIN `jamaah` AS `j` ON (`j`.`id_jamaah` = `pm`.`id_jamaah`) LEFT JOIN `paket_umroh` AS `pu` ON (`pu`.`id_paket` = `pm`.`id_paket`)";
        $extraCondition = "`k`.`id_konsultan` = $id_agen " ;
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition);
        foreach ($data['data'] as $key => $d) {
            $this->load->library('money');
            $this->load->library('date');
            $nominal = $this->money->format($d['nominal']);
            $tanggal_dihitung_komisi = $this->date->convert_date_indo($d['tanggal']);
            $tanggal_berangkat = $this->date->convert_date_indo($d['tanggal_berangkat']);

            $data['data'][$key]['nominal'] = $nominal;
            $data['data'][$key]['tanggal'] = $tanggal_dihitung_komisi;
            $data['data'][$key]['tanggal_berangkat'] = $tanggal_berangkat;

        }
        echo json_encode($data);
    }

    public function poin_pribadi() {
        $this->load->model('agen');
        $agen = $this->agen->getAgen($_GET['id']);
        $this->load->view('staff/poin_pribadi_view', $agen[0]);
    }

    public function proses_tambah_poin() {
        $this->form_validation->set_rules("id_agen", "Id Agen", "trim|required|integer");
        $this->form_validation->set_rules("poin", "Jumlah Poin", "trim|required|integer");
        $this->form_validation->set_rules("musim", "Musim", "trim|required");
        $this->form_validation->set_rules("keterangan", "Keterangan", "trim|required");
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata(['form' => $_POST]);
            $this->alert->set('danger', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        }
        
        $this->load->model('komisiConfig');
        $result = $this->komisiConfig->addKomisiPoinPribadi($_POST);
        if (!$result) {
            $this->session->set_flashdata(['form' => $_POST]);
            $this->alert->set('danger', 'Error, Terjadi kesalahan pada sistem.');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->alert->set('success', 'Berhasil menambahkan data');
        redirect(base_url() . 'staff/kelola_agen/profile?id=' . $_POST['id_agen']);
    }
}