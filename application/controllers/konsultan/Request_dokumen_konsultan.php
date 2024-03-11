<?php

use Google\Service\AndroidPublisher\PrepaidPlan;

defined('BASEPATH') or exit('No direct script access allowed');

class Request_dokumen_konsultan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("auth");
        $this->load->library("secret_key");
        $this->load->model('konsultanAuth');
        if (!$this->konsultanAuth->is_user_logged_in()) {
            redirect(base_url() . 'konsultan/login');
        }
    }

    public function index()
    {
        $this->load->model('registrasi');
        $sudahAmbil = $this->registrasi->getRequestDokumen($_GET['id']);
        $member = $this->registrasi->getMember($_GET['id']);
        $jamaah = $this->registrasi->getJamaah($member[0]->id_jamaah, null, $member[0]->id_member);
        $id_request = null;
        if ($sudahAmbil) {
            foreach ($sudahAmbil['dateGroup'] as $key => $ambil) {
                $this->load->library('secret_key');
                $id_secret = $this->secret_key->generate($ambil[0]->id_request);
                $sudahAmbil['dateGroup'][$key][0]->idSecretRequest = $id_secret ; 
            }
        }
        $data = array(
            'sudahAmbil' => $sudahAmbil,
            'id_member' => $member[0]->id_member,
            'id_secret' => $member[0]->idSecretMember,
            'nama_jamaah' => $jamaah->first_name . " " . $jamaah->second_name . " " . $jamaah->last_name,
        );
        $this->load->view('konsultan/request_konsultan_view', $data);
    }

    public function input()
    {  
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('idm', 'idm', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->setJamaah('red','Oops...', 'Access Denied');
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
        $data_jamaah = $this->registrasi->getJamaah(null, null ,$_GET['idm']);
        if (empty($data_jamaah)) {
            $this->alert->setJamaah('red','Maaf', 'Data Tidak Ditemukan');
            redirect(base_url() . 'konsultan/home');
            return false;
        }
        $dataReq = $this->registrasi->getMember($_GET['idm']);
        if (empty($dataReq)) {
            $this->alert->setJamaah('red','Maaf', 'Data Tidak Ditemukan');
            redirect(base_url() . 'konsultan/home');
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
        $this->load->view('konsultan/input_req_konsultan', $data = array(
            'jamaah' => $data_jamaah,
            'dataReq' => $dataReq,
            'kota' => $kota,
            'member' => $data_jamaah->member
        ));
    }

    public function hapus()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('idr', 'idr', 'trim|required');
        $this->form_validation->set_rules('idm', 'idm', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->setJamaah('red','Oops...', 'Access Denied');
            redirect(base_url().'konsultan/home');
        }
        $id_request = $this->secret_key->validate($_GET['idr']);
        $id_member = $this->secret_key->validate($_GET['idm']);
        $checkRequest = $this->auth->checkRequest($id_member, $id_request);
        if (!$checkRequest) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url().'konsultan/home');
        }
        $this->load->model('registrasi');
        $data = $this->registrasi->deleteRequest($id_request);
        if ($data == true) {
            $this->alert->setJamaah('green','Success', 'Data Berhasil Dihapus');
        } else {
            $this->alert->setJamaah('red','Oops...', 'Data Gagal Dihapus');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function getTempatLahir()
    {
        $term = $this->input->get('term');
        $this->load->model('region');
        $kota = $this->region->getRegionAutoComplete($term);
        echo json_encode($kota);
    }

    public function proses_input_req(){   
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'trim|required');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'trim|required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'trim|required');
        $this->form_validation->set_rules('no_ktp', 'No KTP', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->setJamaah('red', 'Mohon Maaf!!!', 'Tolong isi yang diwajibkan');
            redirect($_SERVER['HTTP_REFERER']);
            return false;
        }
        
        $data = $_POST;
        // validate
        $this->load->library('secret_key');
        $id_member = $this->secret_key->validate($data['id_member']);
        if (!$id_member) {
            $this->alert->setJamaah('red', 'Oops..', 'Access Denied');
            redirect(base_url(). 'konsultan/home');
        }
        
        // check member
        $this->load->model('auth');
        $check = $this->auth->checkMemberAgen($_SESSION['id_agen'], $id_member);
        if (!$check) {
            $this->alert->setJamaah('red', 'Oops..', 'Access Denied');
            redirect(base_url(). 'konsultan/home');
        }
        
        $data['id_member'] = $id_member;
        $data['tgl_request'] = date('Y-m-d H:i:s');
        $this->load->model('registrasi');
        $result = $this->registrasi->inputRequest($data);
        if ($result == true) {
            $this->alert->setJamaah('green', 'Success', 'Berhasil request dokumen');
            redirect(base_url() . 'konsultan/request_dokumen_konsultan?id='. $_POST['id_member']);
        } else {
            $this->alert->setJamaah('red', 'Oops..', 'Data gagal di input');
            redirect(base_url() . 'konsultan/request_dokumen_konsultan?id='. $_POST['id_member']);
        }
    }

    public function getImigrasi() {
        $term = $this->input->get('term');
        $this->load->model('region');
        $hasil = $this->region->getKantorImigrasi($term);
        echo json_encode($hasil);
    }

    public function getImigrasiId() {
        $kantor = $this->input->get('namaKantor');
        $this->load->model('region');
        $region = $this->region->getTtdBasah($kantor);
        if ($region == 1) {
            echo json_encode(true);
        } else {
            return $region;
        }
    }

    public function dl_imigrasi()
    {
        if (isset($_GET['idr'])) {
            $this->load->model('registrasi');
            $data = $this->registrasi->getImigrasi($_GET['idr'], null);
            $filename = $data[0]->imigrasi;

            if (file_exists(SITE_ROOT . $filename)) {
                redirect(base_url() . $filename);
            } else {
                $this->alert->setJamaah('red', 'Ups...', 'File tidak tersedia');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function dl_kemenag()
    {
        if (isset($_GET['idr'])) {
            $this->load->model('registrasi');
            $data = $this->registrasi->getImigrasi($_GET['idr'], $_GET['idm']);
            $filename = $data[0]->kemenag;

            if (file_exists(SITE_ROOT . $filename)) {
                redirect(base_url() . $filename);
            } else {
                $this->alert->setJamaah('red', 'Ups...', 'File tidak tersedia');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
}