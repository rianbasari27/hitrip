<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Req_dokumen extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //check if logged in redirect to user page
        $this->load->model('customer');
        if (!$this->customer->is_user_logged_in()) {
            redirect(base_url() . 'jamaah/home');
        }
        $id_member = $_SESSION['id_member'];
        $this->load->helper(array('url', 'download'));
        $this->load->model('registrasi');
        $member = $this->registrasi->getMember($id_member);
        $member = $member[0];

        $this->load->model('jamaahDashboard');
        $status = $this->jamaahDashboard->getStatus($member);
        if ($status['DPStatus'] == true) {
            redirect(base_url() . 'jamaah/daftar/dp_notice');
        }
    }
    public function index()
    {
        $this->load->model('registrasi');
        $data = $this->registrasi->getJamaah($_SESSION['id_jamaah']);
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
        $this->load->view('jamaahv2/dokum_req', $data);
    }
    public function input()
    {  
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('idm', 'idm', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->setJamaah('red','Oops..', 'Access Denied');
            redirect(base_url() . 'jamaah/home_user');
        }

        // validate
        $this->load->library('secret_key');
        $id_member = $this->secret_key->validate($_GET['idm']);
        if (!$id_member) {
            $this->alert->setJamaah('red', 'Oops..', 'Access Denied');
            redirect(base_url(). 'jamaah/home_user');
        }
        
        // check member
        $this->load->model('auth');
        $check = $this->auth->checkMember($_SESSION['id_member'], $id_member);
        if (!$check) {
            $this->alert->setJamaah('red', 'Oops..', 'Access Denied');
            redirect(base_url(). 'jamaah/home_user');
        }

        $this->load->model('registrasi');
        $data_jamaah = $this->registrasi->getJamaah(null, null ,$id_member);
        if (empty($data_jamaah)) {
            $this->alert->setJamaah('red', 'Oops..', 'Access Denied');
            redirect(base_url(). 'jamaah/home_user');
        }
        $dataReq = $this->registrasi->getMember($id_member);
        if (empty($dataReq)) {
            $this->alert->setJamaah('red', 'Oops..', 'Access Denied');
            redirect(base_url(). 'jamaah/home_user');
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
        $this->load->view('jamaahv2/input_req', $data = array(
            'jamaah' => $data_jamaah,
            'dataReq' => $dataReq,
            'kota' => $kota,
            'member' => $data_jamaah->member
        ));
    }

    public function proses_input_req(){   
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'trim|required');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'trim|required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'trim|required');
        $this->form_validation->set_rules('no_ktp', 'No KTP', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->setJamaah('red', 'Mohon Maaf', 'Tolong isi yang diwajibkan');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $data = $_POST;
        // validate
        $this->load->library('secret_key');
        $id_member = $this->secret_key->validate($data['id_member']);
        if (!$id_member) {
            $this->alert->setJamaah('red', 'Oops..', 'Access Denied');
            redirect(base_url(). 'jamaah/home_user');
        }
        
        // check member
        $this->load->model('auth');
        $check = $this->auth->checkMember($_SESSION['id_member'], $id_member);
        if (!$check) {
            $this->alert->setJamaah('red', 'Oops..', 'Access Denied');
            redirect(base_url(). 'jamaah/home_user');
        }
        
        $data['id_member'] = $id_member;
        $data['tgl_request'] = date('Y-m-d H:i:s');
        $this->load->model('registrasi');
        $result = $this->registrasi->inputRequest($data);
        if ($result == true) {
            $this->alert->setJamaah('green', 'Success', 'Berhasil request dokumen');
            redirect(base_url() . 'jamaah/req_dokumen');
        } else {
            $this->alert->setJamaah('red', 'Oops..', 'Data gagal di input');
            redirect(base_url() . 'jamaah/req_dokumen');
        }
    }

    // public function tampil_req()
    // {
    //     $this->load->model('registrasi');
    //     $data_jamaah = $this->registrasi->getJamaah($_GET['idj'], null, null);
    //     if (empty($data_jamaah)) {
    //         $this->alert->set('danger', 'Data Tidak Ditemukan');
    //         redirect(base_url() . 'jamaah/home');
    //         return false;
    //     }
    //     $dataReq = $this->registrasi->getMember($_GET['idm']);
    //     if (empty($dataReq)) {
    //         $this->alert->set('danger', 'Data Tidak Ditemukan');
    //         redirect(base_url() . 'staff/request_dokumen');
    //         return false;
    //     }

    //     $this->load->model('tarif');
    //     $data_member = $this->tarif->getRequest($_GET['idm']);
    //     if (empty($data_member['data'])) {
    //         $this->alert->set('danger', 'Data Tidak Ditemukan');
    //         redirect(base_url() . 'staff/request_dokumen');
    //     }
        
    //     $this->load->model('paketUmroh');
    //     $paket = $this->paketUmroh->getPackage($dataReq[0]->id_paket, false);
    //     $this->load->view('jamaahv2/download_request', $data = array(
    //         'jamaah' => $data_jamaah,
    //         'member' => $data_member['data'],
    //         'paket' => $paket,
    //         'dataReq' => $dataReq[0]
    //     ));
    // }

    public function hapus()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('idr', 'idr', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->setJamaah('red','Oops..', 'Access Denied');
            redirect(base_url() . 'jamaah/home_user');
        }

        // validate
        $this->load->library('secret_key');
        $id_request = $this->secret_key->validate($_GET['idr']);
        if (!$id_request) {
            $this->alert->setJamaah('red','Oops..', 'Access Denied');
            redirect(base_url() . 'jamaah/home_user');
        }

        // check id_request
        $this->load->model('auth');
        $check = $this->auth->checkRequest($_SESSION['id_member'], $id_request) ;
        if (!$check) {
            $this->alert->setJamaah('red','Oops..', 'Access Denied');
            redirect(base_url() . 'jamaah/home_user');
        }

        $this->load->model('registrasi');
        $data = $this->registrasi->deleteRequest($_GET['idr']);
        if ($data == true) {
            $this->alert->setJamaah('green','Success', 'Data Berhasil Dihapus');
        } else {
            $this->alert->setJamaah('red','Oops..', 'Data Gagal Dihapus');
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

    public function viewRequest()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('idm', 'idm', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->alert->setJamaah('red', 'Oops..', 'Access Denied');
            redirect(base_url(). 'jamaah/home_user');
        }

        // validate
        $this->load->library('secret_key');
        $id_member = $this->secret_key->validate($_GET['idm']);
        if (!$id_member) {
            $this->alert->setJamaah('red', 'Oops..', 'Access Denied');
            redirect(base_url(). 'jamaah/home_user');
        }
        
        // check member
        $this->load->model('auth');
        $check = $this->auth->checkMember($_SESSION['id_member'], $id_member);
        if (!$check) {
            $this->alert->setJamaah('red', 'Oops..', 'Access Denied');
            redirect(base_url(). 'jamaah/home_user');
        }

        $this->load->model('registrasi');
        $sudahAmbil = $this->registrasi->getRequestDokumen($id_member);
        foreach ($sudahAmbil['dateGroup'] as $key => $ambil) {
            $this->load->library('secret_key');
            $id_secret = $this->secret_key->generate($ambil[0]->id_request);
            $sudahAmbil['dateGroup'][$key][0]->idSecretRequest = $id_secret ; 
        }
        $jamaah = $this->registrasi->getJamaah(null, null, $id_member);
        $data = array(
            'sudahAmbil' => $sudahAmbil,
            'id_member' => $jamaah->member[0]->id_member,
            'idSecretMember' => $jamaah->member[0]->idSecretMember,
            'nama_jamaah' => $jamaah->first_name . " " . $jamaah->second_name . " " . $jamaah->last_name
        );
        $this->load->view('jamaahv2/pilih_request', $data);
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
            $data = $this->registrasi->getImigrasi($_GET['idr'], null);
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