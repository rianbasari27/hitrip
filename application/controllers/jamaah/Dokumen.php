<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dokumen extends CI_Controller
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
        $this->load->view('jamaahv2/dokumen_view', $data);
    }

    public function update_data()
    {   
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('idm', 'idm', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->setJamaah('red', 'Oops..' , 'Access Denied');
            redirect(base_url() . 'jamaah/home_user');
        }

        // validate id member
        $this->load->library('secret_key');
        $id_member = $this->secret_key->validate($_GET['idm']);
        if (!$id_member) {
            $this->alert->setJamaah('red', 'Oops..' , 'Access Denied');
            redirect(base_url() . 'jamaah/home_user');
        }

        // check parent or id_member
        $this->load->model('auth');
        $check = $this->auth->checkMember($_SESSION['id_member'], $id_member);
        if (!$check) {
            $this->alert->setJamaah('red', 'Oops..' , 'Access Denied');
            redirect(base_url() . 'jamaah/home_user');
        }

        $this->load->model('registrasi');
        $data_member = $this->registrasi->getMember($id_member);
        if (empty($data_member)) {
            $this->alert->setJamaah('red', 'Oops..', 'Data Tidak Ditemukan');
            redirect(base_url() . 'jamaah/home_user');
            return false;
        }
        $data_jamaah = $this->registrasi->getJamaah($data_member[0]->id_jamaah);
        if (empty($data_jamaah)) {
            $this->alert->setJamaah('red', 'Oops..', 'Data Tidak Ditemukan');
            redirect(base_url() . 'jamaah/home_user');
            return false;
        }
        // echo '<pre>';
        // print_r($data_member);
        // exit();
        // if ($data_member[0]->paket_info->tanggal_berangkat <=) {
            
        // }
        $idPaket = $data_member[0]->id_paket;
        $this->load->model('paketUmroh');
        $paketInfo = $this->paketUmroh->getPackage($idPaket, false, false, false);
        if (empty($paketInfo)) {
            $this->alert->setJamaah('red', 'Oops..', 'Data Tidak Ditemukan');
            redirect(base_url() . 'jamaah/home_user');
            return false;
        }
        //option for pilihan kamar
        $kamarOption = array();
        if (!empty($paketInfo->harga) || $paketInfo->harga != '0') {
            $kamarOption[] = 'Quad';
        }
        if (!empty($paketInfo->harga_triple) || $paketInfo->harga_triple != '0') {
            $kamarOption[] = 'Triple';
        }
        if (!empty($paketInfo->harga_double) || $paketInfo->harga_double != '0') {
            $kamarOption[] = 'Double';
        }


        $this->load->model('agen');
        $agenList = $this->agen->getAgen(null, false, false, false, true);
        $this->load->model('region');
        $province = $this->region->getProvince();

        if ($data_member[0]->valid == 1) {
            $this->alert->setJamaah('yellow', 'Mohon maaf!', 'Anda tidak dapat mengubah data karena sudah divalidasi oleh staff.');
            redirect(base_url().'jamaah/dokumen');
        }

        $this->load->library('calculate');
        $age = $this->calculate->ageDiff($data_jamaah->tanggal_lahir, $data_member[0]->paket_info->tanggal_berangkat);
        $countdown = $this->calculate->dateDiff($paketInfo->tanggal_berangkat, date('Y-m-d'));
        $data = array(
            'jamaah' => $data_jamaah,
            'member' => $data_member[0],
            'agenList' => $agenList,
            'kamarOption' => $kamarOption,
            'provinceList' => $province,
            'age' => $age,
            'countdown' => $countdown
        );
        $this->load->view('jamaahv2/update_jamaah', $data);
    }
    public function getCountries()
    {
        $term = $this->input->get('term');
        $this->load->model('region');
        $negara = $this->region->getCountriesAutoComplete($term);
        echo json_encode($negara);
    }

    public function proses_update_data()
    {
        $this->load->model('registrasi');
        $member = $this->registrasi->getMember($_POST['id_member']);
        $dateStart = date_create($_POST['paspor_expiry_date']);
        $dateEnd = date_create($member[0]->paket_info->tanggal_berangkat);
        $datediff = date_diff($dateEnd, $dateStart);
        $month = $datediff->y * 12;
        if ($_POST['paspor_expiry_date'] < $member[0]->paket_info->tanggal_berangkat) {
            if (($datediff->m + $month) > 7 ) {
                $this->alert->setJamaah('red', 'Oops..' , 'Paspor Expiry Date tidak boleh kurang dari 7 bulan dari tanggal keberangkatan.');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }

        // cek umur untuk sharing bed
        $this->load->library('calculate');
        $age = $this->calculate->age($_POST['tanggal_lahir']);
        if ($_POST['sharing_bed']) {
            if ($age > 6 || $age < 2) {
                $this->alert->setJamaah('red', 'Ups...', 'Umur tidak sesuai untuk sharing bed');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }

        $jamaah = $_POST;
        $unsetJamaah = ['id_member', 'id_paket' ,'paspor_no', 'paspor_name', 'paspor_issue_date', 'paspor_expiry_date', 'paspor_issuing_city', 'paspor_scan', 'paspor_scan2',
                        'ktp_scan', 'foto_scan', 'visa_scan', 'kk_scan', 'paspor_check', 'buku_kuning_check', 'foto_check', 'id_agen', 'pilihan_kamar', 'verified1', 
                        'pernah_umroh', 'dp_notif', 'sharing_bed'];
        if ($jamaah['second_name'] != null) {
            $jamaah['second_name'] = $jamaah['second_name'];
        } else {
            $jamaah['second_name'] = null;
        }
        if ($jamaah['last_name'] != null) {
            $jamaah['last_name'] = $jamaah['last_name'];
        } else {
            $jamaah['last_name'] = null;
        }
        foreach ($unsetJamaah as $uj) {
            unset($jamaah[$uj]);
        }
        
        if (!empty($_FILES['upload_penyakit']['name'])) {
            $jamaah['files']['upload_penyakit'] = $_FILES['upload_penyakit'];
        }

        $this->load->model('registrasi');
        if (empty($dataMember)) {
            $registerFrom = null;
        } else {
            $registerFrom = $dataMember[0]->register_from;
        }
        
        $result = $this->registrasi->daftar($jamaah, $registerFrom, true);
        $this->registrasi->setAhliWaris($_POST['id_member']);

        $member = $_POST;
        $unsetMember = ['ktp_no','first_name', 'second_name', 'last_name', 'nama_ayah', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'status_perkawinan', 'verified',
                      'no_wa', 'no_rumah', 'email', 'alamat_tinggal', 'provinsi', 'kabupaten_kota', 'kecamatan', 'kewarganegaraan', 'pekerjaan', 'pendidikan_terakhir',
                      'penyakit', 'referensi', 'office', 'upload_penyakit', 'no_ahli_waris', 'nama_ahli_waris', 'alamat_ahli_waris'];

        foreach ($unsetMember as $um) {
            unset($member[$um]);
        }
        
        $data = (array) $member;
        if (!empty($_FILES['paspor_scan']['name'])) {
            $data['files']['paspor_scan'] = $_FILES['paspor_scan'];
        }
        if (!empty($_FILES['paspor_scan2']['name'])) {
            $data['files']['paspor_scan2'] = $_FILES['paspor_scan2'];
        }
        if (!empty($_FILES['ktp_scan']['name'])) {
            $data['files']['ktp_scan'] = $_FILES['ktp_scan'];
        }
        if (!empty($_FILES['foto_scan']['name'])) {
            $data['files']['foto_scan'] = $_FILES['foto_scan'];
        }
        if (!empty($_FILES['kk_scan']['name'])) {
            $data['files']['kk_scan'] = $_FILES['kk_scan'];
        }
        if (!empty($_FILES['visa_scan']['name'])) {
            $data['files']['visa_scan'] = $_FILES['visa_scan'];
        }
        if (!empty($_FILES['vaksin_scan']['name'])) {
            $data['files']['vaksin_scan'] = $_FILES['vaksin_scan'];
        }

        if ($jamaah['referensi'] != 'Agen') {
            $data['id_agen'] = null;
        }

        $this->load->model('registrasi');
        $result = $this->registrasi->updateMember($data);
        $redir_string = base_url() . 'jamaah/dokumen';
        if (isset($_POST['id_member'])) {

            $redir_string = $redir_string;
        }
        $this->alert->setJamaah('green', 'Berhasil', 'Data berhasil diupdate');
        redirect($redir_string);
    }

    public function hapus_upload()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id_member', 'id_member', 'trim|required');
        $this->form_validation->set_rules('field', 'field', 'required');
        if ($this->form_validation->run() == FALSE) {
            return false;
        }

        // validate id member
        $this->load->library('secret_key');
        $id_member = $this->secret_key->validate($_GET['id_member']);
        if (!$id_member) {
            return false ;
        }

        // check parent or id_member
        $this->load->model('auth');
        $check = $this->auth->checkMember($_SESSION['id_member'], $id_member);
        if (!$check) {
            return false;
        }

        $this->load->model('registrasi');
        $result = $this->registrasi->deleteUpload($_GET['id_member'], $_GET['field']);
        if ($result == true) {
            echo json_encode(true);
        } else {
            return false;
        }
    }

    public function hapus_surat_dokter()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id_jamaah', 'id_jamaah', 'trim|required|integer');
        $this->form_validation->set_rules('field', 'field', 'required');

        if ($this->form_validation->run() == FALSE) {
            return false;
        }
        $this->load->model('registrasi');
        $result = $this->registrasi->deleteSuratDokter($_GET['id_jamaah'], $_GET['field']);
        if ($result == true) {
            echo json_encode(true);
        } else {
            return false;
        }
    }

    public function getTempatLahir()
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

    public function agen_autocomplete()
    {

        $term = $_GET['r']['term'];
        $this->load->model('agen');
        $data = $this->agen->getAgen($term, 10);
        echo json_encode($data);
    }

    public function agen_complete()
    {
        // POST data
        $postData = $this->input->post();
        // Get data
        $this->load->model('agen');
        $data = $this->agen->getUsers($postData);
        echo json_encode($data);
    }

    public function getAgenJSON()
    {
        $this->load->model('agen');
        $data = $this->agen->getAgen();
        $hasil = [];
        foreach ($data as $key => $dt) {
            $hasil[$key]['value'] = $dt->id_agen;
            $hasil[$key]['text'] = $dt->nama_agen . " - " . $dt->no_agen;
        }
        echo json_encode($hasil);
    }
}