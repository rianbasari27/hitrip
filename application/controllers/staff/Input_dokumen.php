<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Input_dokumen extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }
//this page for master admin, manifest and finance
        if (!($_SESSION['bagian'] == 'Manifest' || $_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Admin' || $_SESSION['bagian'] == 'Finance')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
    }
    public function index()
    {
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage(null, false, false, true);
        if (isset($_GET['id_paket'])) {
            $id_paket = $_GET['id_paket'];
        } else {
            $id_paket = $paket[0]->id_paket;
        }

        $selectedPaket = $this->paketUmroh->getPackage($id_paket, false, false, false);

        $nama_paket = $selectedPaket->nama_paket . ' (' . date_format(date_create($selectedPaket->tanggal_berangkat), "d F Y") . ')';


        $this->load->view('staff/input_view', $data = array(
            'paket' => $paket,
            'id_paket' => $id_paket,
            'nama_paket' => $nama_paket
        )); 
        // echo '<pre>' ;
        // print_r($id_member);
        // exit();
    }
    public function load_jamaah()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'jamaah';
        // Primary key of table
        $primaryKey = 'id_jamaah';

        $columns = array(
            array('db' => '`j`.`id_jamaah`', 'dt' => 'DT_RowId', 'field' => 'id_jamaah'),
            array('db' => '`j`.`first_name`', 'dt' => 'first_name', 'field' => 'first_name'),
            array('db' => '`j`.`second_name`', 'dt' => 'second_name', 'field' => 'second_name'),
            array('db' => '`j`.`last_name`', 'dt' => 'last_name', 'field' => 'last_name'),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`second_name`,' ',`j`.`last_name`) AS `whole_name`", 'dt' => "whole_name", 'field' => "whole_name"),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`last_name`) AS `two_name`", 'dt' => "two_name", 'field' => "two_name"),
            array('db' => '`j`.`referensi`', 'dt' => 'referensi', 'field' => 'referensi'),
            array('db' => '`j`.`no_wa`', 'dt' => 'no_wa', 'field' => 'no_wa'),
            array('db' => '`j`.`penyakit`', 'dt' => 'penyakit', 'field' => 'penyakit'),
            array('db' => '`j`.`upload_penyakit`', 'dt' => 'upload_penyakit', 'field' => 'upload_penyakit'),
            array('db' => '`j`.`tanggal_lahir`', 'dt' => 'tanggal_lahir', 'field' => 'tanggal_lahir'),
            array('db' => '`j`.`kabupaten_kota`', 'dt' => 'kabupaten_kota', 'field' => 'kabupaten_kota'),
            array('db' => 'GROUP_CONCAT(CONCAT("- ",`pu`.`nama_paket`,"<br>(",DATE_FORMAT(`pu`.`tanggal_berangkat`,"%e %b %Y"),")") SEPARATOR ",<br>") AS all_paket', 'dt' => 'all_paket', 'field' => 'all_paket'),
            array('db' => '`pu`.`nama_paket`', 'dt' => 'nama_paket', 'field' => 'nama_paket'),
            array('db' => '`pu`.`tanggal_berangkat`', 'dt' => 'tanggal_berangkat', 'field' => 'tanggal_berangkat'),
            array('db' => '`pu`.`id_paket`', 'dt' => 'id_paket', 'field' => 'id_paket'),
            array('db' => '`pu`.`harga`', 'dt' => 'harga', 'field' => 'harga'),
            array('db' => '`pm`.`total_harga`', 'dt' => 'total_harga', 'field' => 'total_harga'),
            array('db' => '`pm`.`id_member`', 'dt' => 'id_member', 'field' => 'id_member'),
            array('db' => '`pm`.`parent_id`', 'dt' => 'parent_id', 'field' => 'parent_id'),
            array('db' => '`pm`.`lunas`', 'dt' => 'lunas', 'field' => 'lunas'),
            array('db' => '`pm`.`id_agen`', 'dt' => 'id_agen', 'field' => 'id_agen')
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $id_paket = $_GET['id_paket'];
        $joinQuery = "FROM `{$table}` AS `j` JOIN `program_member` AS `pm` ON (`j`.`id_jamaah` = `pm`.`id_jamaah`)"
            . "JOIN `paket_umroh` AS `pu` ON (`pu`.`id_paket` = `pm`.`id_paket`)";
        $extraCondition = "`pu`. `id_paket`=" . $id_paket ;
        if (isset($_GET['klasifikasi'])) {
            $klasifikasi = $_GET['klasifikasi'];
            if ($klasifikasi == 'Lansia') {
                $conditions = ' AND TIMESTAMPDIFF(YEAR, `j`.`tanggal_lahir`, CURDATE()) >= 60';
            } else {
                $conditions = '';
            }
            $extraCondition = $extraCondition . $conditions ;
        }
        $groupBy = "`j`.`id_jamaah`";
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition, $groupBy);
        
        foreach ($data['data'] as $key => $item) {
            $this->load->model('agen');
            $agen = $this->agen->getAgen($item['id_agen']);

            $data['data'][$key]['reference'] = $item['referensi'];
            if ($item['referensi'] == 'Agen') {
                $data['data'][$key]['referensi'] = $agen[0]->nama_agen;
                $data['data'][$key]['no_wa_agen'] = $agen[0]->no_wa;
            }

            $data['data'][$key]['DT_RowAttr'] = array(
                'id_member' => $item['id_member']
            );
            $this->load->model('tarif');
            $bayar = $this->tarif->getPembayaran($item['id_member']);
            $total_biaya = 0;
            if ($item['parent_id'] == null || $item['parent_id'] == 0 || $item['parent_id'] == '') {
                $total_biaya = $item['total_harga'];
                
            } else {
                $this->db->where('parent_id', $item['parent_id']);
                $members = $this->db->get('program_member')->result();
                foreach ($members as $th) {
                    $total_biaya += $th->total_harga;
                }
            }
            $outstanding = $total_biaya - $bayar['totalBayar'];

            // if ($item['referensi'] !== 'Agen' || $item['referensi'] === null || $item['referensi'] === '') {
            //     $data['data'][$key]['nama_agen'] = '-';
            //     $data['data'][$key]['no_wa'] = '-';
            // } else {
            //     $data['data'][$key]['nama_agen'] = $nama_agen;
            //     $data['data'][$key]['no_wa'] = $no_wa;
            // }
            $data['data'][$key]['nilai_outstanding'] = number_format($outstanding);
        }

        echo json_encode($data);
    }
    public function lihat_jamaah()
    {
        $this->load->view('staff/request_dokumen_view');
    }
    public function inputForm(){
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('idj', 'idj', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/input_dokumen');
            return false;
        }
        $this->load->model('registrasi');
        $data_jamaah = $this->registrasi->getJamaah($_GET['idj']);
        if (empty($data_jamaah)) {
            $this->alert->set('danger', 'Data Tidak Ditemukan');
            redirect(base_url() . 'staff/input_dokumen');
            return false;
        }
        $dataReq = $this->registrasi->getMember(null, $_GET['idj']);
        if (empty($dataReq)) {
            $this->alert->set('danger', 'Data Tidak Ditemukan');
            redirect(base_url() . 'staff/input_dokumen');
            return false;
        }
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage(null, false, false, true);
        if (isset($_GET['id_paket'])) {
            $id_paket = $_GET['id_paket'];
        } else {
            $id_paket = $paket[0]->id_paket;
        }

        $selectedPaket = $this->paketUmroh->getPackage($id_paket, false, false, false);

        $nama_paket = $selectedPaket->nama_paket . ' (' . date_format(date_create($selectedPaket->tanggal_berangkat), "d F Y") . ')';


        $this->load->view('staff/form_request', $data = array(
            'jamaah' => $data_jamaah,
            'dataReq' => $dataReq,
            'member' => $data_jamaah->member
        ));
        // echo '<pre>' ;
        // print_r($data);
        // exit();
    }
    public function proses_input_req(){   
        $data = $_POST;
        // echo '<pre>' ;
        // print_r($data) ;
        // exit();
        $this->load->model('registrasi');
        $result = $this->registrasi->inputRequest($data);
        if ($result == true) {
            $this->alert->set('success', 'Berhasil request dokumen');
            redirect(base_url() . 'staff/request_dokumen');
        } else {
            $this->alert->set('danger', 'Data gagal di input');
            redirect(base_url() . 'staff/request_dokumen');
        }
    }
}