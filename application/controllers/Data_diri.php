<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Data_diri extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('customer');
        $this->load->model('registrasi');
        if ($this->customer->checkSession() == false) {
            redirect(base_url() . 'login');
        }
    }

    public function index() {
        $id_member = null;
        if (isset($_GET['id'])) {
            $id_member = $_GET['id'];
        }
        if ($id_member == null) {
            $id_member = $_SESSION['id_member'];
        }
        $auth = $this->customer->checkAuthId($id_member);
        if ($auth == false) {
            redirect(base_url() . 'home');
        }
        $member = $this->registrasi->getMember($id_member);
        $member = $member[0];
        $jamaah = $this->registrasi->getJamaah($member->id_jamaah);
        if (empty($jamaah)) {
            $this->alert->set('danger', 'Data Tidak Ditemukan');
            redirect(base_url() . 'home');
        }
        $status = $this->customer->getStatus($member);
        $dataStatus = $status['dataStatus'];
        if($dataStatus == false){
            $this->alert->set('danger', 'Forbidden Access');
            redirect(base_url() . 'home');
        }
        $paket = $this->paketUmroh->getPackage($member->id_paket, false);
        $this->load->model('region');
        $province = $this->region->getProvince();
        $provinceList = $province;

        $this->load->view('jamaah/data_diri_view', array(
            'member' => $member,
            'jamaah' => $jamaah,
            'paket' => $paket,
            'provinceList' => $provinceList
        ));
    }
    
    public function proses(){
        if(!isset($_POST['id_member'])){
            $this->alert->set('danger', 'Forbidden Access');
            redirect(base_url() . 'home');
        }
        $data = $_POST;
        unset($data['id_member']);
        $id_member = $_POST['id_member'];
        $auth = $this->customer->checkAuthId($id_member);
        if ($auth == false) {
            redirect(base_url() . 'home');
        }
        $member = $this->registrasi->getMember($id_member);
        $member = $member[0];
        
        $status = $this->customer->getStatus($member);
        if($status['dataStatus'] == false){
            $this->alert->set('danger', 'Forbidden Access');
            redirect(base_url() . 'home');
        }
        $result = $this->registrasi->daftar($data);
        redirect(base_url() . 'home?id='.$id_member);
    }

    public function getRegencies() {
        $provId = $this->input->get('provId');
        $this->load->model('region');
        $regency = $this->region->getRegency(null, $provId);
        echo json_encode($regency);
    }

    public function getDistricts() {
        $regId = $this->input->get('regId');
        $this->load->model('region');
        $districts = $this->region->getDistrict(null, $regId);
        echo json_encode($districts);
    }

    public function getTempatLahir() {
        $term = $this->input->get('term');
        $this->load->model('region');
        $kota = $this->region->getRegionAutoComplete($term);
        echo json_encode($kota);
    }

    public function getCountries() {
        $term = $this->input->get('term');
        $this->load->model('region');
        $negara = $this->region->getCountriesAutoComplete($term);
        echo json_encode($negara);
    }

    public function getJamaah() {
        $ktp = $this->input->get('ktp');
    }

}
