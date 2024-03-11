<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Req_cuti_konsultan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //check if logged in redirect to user page
        $this->load->model("auth");
        $this->load->library("secret_key");
        $this->load->model('konsultanAuth');
        if (!$this->konsultanAuth->is_user_logged_in()) {
            redirect(base_url() . 'konsultan/login');
        }
        // $id_member = $_SESSION['id_member'];
        // $this->load->helper(array('url', 'download'));
        // $this->load->model('registrasi');
        // $member = $this->registrasi->getMember($id_member);
        // $member = $member[0];

        // $this->load->model('jamaahDashboard');
        // $status = $this->jamaahDashboard->getStatus($member);
        // if ($status['DPStatus'] == true) {
        //     redirect(base_url() . 'jamaah/daftar/dp_notice');
        // }
    }

    public function index() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->setJamaah('red', 'Error!', 'Access Denied');
            redirect(base_url() . 'konsultan/home');
            return false;
        }
        $id_member = $this->secret_key->validate($_GET['id']);
        if (!$id_member) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url().'konsultan/home');
        }
        $check = $this->auth->checkMemberAgen($_SESSION['id_agen'], $id_member);
        if (!$check) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url().'konsultan/home');
        }
        $this->load->model('registrasi');
        $member = $this->registrasi->getMember($id_member);
        // echo '<pre>';
        // print_r($member);
        // exit();
        $data = $this->registrasi->getJamaah($member[0]->id_jamaah);
        $data->member_select = 0;
        if (!empty($_GET['id_member'])) {
            foreach ($data->member as $key => $mbr) {
                if ($mbr->id_member == $_GET['id_member']) {
                    $data->member_select = $key;
                    break;
                }
            }
        }
        if (!empty($data->member[$data->member_select]->parent_id)) {
            $data->child = $this->registrasi->getGroupMembers($data->member[$data->member_select]->parent_id);
        }
        $this->load->view('konsultan/req_cuti_konsultan_view', $data);
    }

    public function list_surat_cuti() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('idm', 'id', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->setJamaah('red', 'Error!', 'Access Denied');
            redirect(base_url() . 'konsultan/home');
            return false;
        }
        $id_member = $this->secret_key->validate($_GET['idm']);
        if (!$id_member) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url().'konsultan/home');
        }
        $check = $this->auth->checkMemberAgen($_SESSION['id_agen'], $id_member);
        if (!$check) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url().'konsultan/home');
        }

        $this->load->model('registrasi');
        $sudahAmbil = $this->registrasi->getSuratCuti($id_member);
        $jamaah = $this->registrasi->getJamaah(null, null, $id_member);
        $data = array(
            'sudahAmbil' => $sudahAmbil,
            'id_member' => $jamaah->member[0]->idSecretMember,
            'nama_jamaah' => $jamaah->first_name . " " . $jamaah->second_name . " " . $jamaah->last_name
        );
        $this->load->view('konsultan/list_surat_cuti_konsultan', $data);
    }

    public function buat_surat() {
        {  
            $this->form_validation->set_data($this->input->get());
            $this->form_validation->set_rules('idm', 'idm', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $this->alert->setJamaah('red','404', 'Access Denied');
                redirect(base_url() . 'konsultan/home');
                return false;
            }
            $this->load->model('registrasi');
            $data_jamaah = $this->registrasi->getJamaah(null, null ,$_GET['idm']);
            if (empty($data_jamaah)) {
                $this->alert->setJamaah('red','Maaf', 'Data Tidak Ditemukan');
                redirect(base_url() . 'jamaah/home');
                return false;
            }
            $dataReq = $this->registrasi->getMember($_GET['idm']);
            if (empty($dataReq)) {
                $this->alert->setJamaah('red','Maaf', 'Data Tidak Ditemukan');
                redirect(base_url() . 'jamaah/home');
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
            $this->load->model('region');
            $kota = $this->region->getKabupaten();
            $this->load->view('konsultan/buat_surat_cuti_konsultan', $data = array(
                'jamaah' => $data_jamaah,
                'dataReq' => $dataReq,
                'kota' => $kota,
                'member' => $data_jamaah->member,
                'selectedPaket' => $selectedPaket
            ));
        }
    }

    public function proses_tambah_cuti() {
        $data = $_POST;
        // echo '<pre>';
        // print_r($data);
        // exit();
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'trim|required');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');
        $this->form_validation->set_rules('jenis_nomor', 'Jenis Nomor Induk', 'trim|required');
        $this->form_validation->set_rules('nomor_induk', 'Nomor Induk', 'trim|required|numeric');
        $this->form_validation->set_rules('tanggal_mulai', 'Tanggal Mulai Cuti', 'trim|required');
        $this->form_validation->set_rules('tanggal_selesai', 'Tanggal Selesai Cuti', 'trim|required');
        $this->form_validation->set_rules('header_surat', 'Bagian Kepala Surat', 'trim|required');
        if ($data['jenis_nomor'] == 'Other') {
            $this->form_validation->set_rules('lainnya', 'Jenis Nomor Induk', 'trim|required');
        }
        if ($this->form_validation->run() == FALSE) {
            $this->alert->setJamaah('red', 'Mohon Maaf', 'Tolong isi yang diwajibkan');
            redirect($_SERVER['HTTP_REFERER']);
            return false;
        }
        if ($data['jenis_nomor'] == 'Other') {
            $data['jenis_nomor'] = $data['lainnya'];
            unset($data['lainnya']);
        } else {
            unset($data['lainnya']);
        }
        $data['header_surat'] = str_replace('`', '<br>', $_POST['header_surat']);
        // echo '<pre>';
        // print_r($data);
        // exit();
        // $data['tgl_request'] = date('Y-m-d H:i:s');
        $this->load->model('registrasi');
        $result = $this->registrasi->inputSuratCuti($data);
        $redir_string = base_url() . 'konsultan/req_cuti_konsultan?id='.$data['id_member'];
        if (isset($_POST['id_member'])) {
            $redir_string = $redir_string;
        }
        redirect($redir_string);        
    }

    public function hapus()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('idr', 'idr', 'trim|required');
        $this->form_validation->set_rules('idm', 'idm', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url() . 'konsultan/home');
        }
        //validate
        $this->load->library('secret_key');
        $id_cuti = $this->secret_key->validate($_GET['idr']);
        if (!$id_cuti) {
            $this->alert->setJamaah('red','Oops..',  'Access Denied');
            redirect(base_url() . 'konsultan/home');
        }

        $this->load->library('secret_key');
        $id_member = $this->secret_key->validate($_GET['idm']);
        if (!$id_member) {
            $this->alert->setJamaah('red','Oops..',  'Access Denied');
            redirect(base_url() . 'konsultan/home');
        }

        //check id_req_cuti
        $this->load->model('auth');
        $check = $this->auth->checkCuti($id_member, $id_cuti);
        if (!$check) {
            $this->alert->setJamaah('red','Oops..',  'Access Denied');
            redirect(base_url() . 'konsultan/home');
        }

        $this->load->model('registrasi');
        $data = $this->registrasi->deleteSuratCuti($id_cuti);
        if ($data == true) {
            $this->alert->setJamaah('green', 'Data Berhasil Dihapus');
        } else {
            $this->alert->setJamaah('red', 'Data Gagal Dihapus');
        }
        redirect(base_url() . 'konsultan/home');
    }

}