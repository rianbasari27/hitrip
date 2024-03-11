<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Administrasi extends CI_Controller {

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
            redirect(base_url() . 'home');
        }
        $auth = $this->customer->checkAuthId($id_member);
        if ($auth == false) {
            redirect(base_url() . 'home');
        }
        $member = $this->registrasi->getMember($id_member);
        $member = $member[0];
        $status = $this->customer->getStatus($member);
        $dataStatus = $status['dataStatus'];
        if ($dataStatus == false) {
            $this->alert->set('danger', 'Forbidden Access');
            redirect(base_url() . 'home');
        }
        $jamaah = $this->registrasi->getJamaah($member->id_jamaah);
        $this->load->model('agen');
        $agenList = $this->agen->getAgen();
        $idPaket = $member->id_paket;
        $this->load->model('paketUmroh');
        $paketInfo = $this->paketUmroh->getPackage($idPaket, false, false, false);
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
        $data = array(
            'jamaah' => $jamaah,
            'member' => $member,
            'agenList' => $agenList,
            'kamarOption' => $kamarOption
        );
        $this->load->view('jamaah/administrasi_view', $data);
    }

    public function proses() {
        $id_member = null;
        if (isset($_POST['id_member'])) {
            $id_member = $_POST['id_member'];
        }
        if ($id_member == null) {
            redirect(base_url() . 'home');
        }
        $auth = $this->customer->checkAuthId($id_member);
        if ($auth == false) {
            redirect(base_url() . 'home');
        }

        $data = $_POST;
        if (!empty($_FILES['paspor_scan']['name'])) {
            $data['files']['paspor_scan'] = $_FILES['paspor_scan'];
        }
        if (!empty($_FILES['ktp_scan']['name'])) {
            $data['files']['ktp_scan'] = $_FILES['ktp_scan'];
        }
        if (!empty($_FILES['foto_scan']['name'])) {
            $data['files']['foto_scan'] = $_FILES['foto_scan'];
        }
        if (!empty($_FILES['visa_scan']['name'])) {
            $data['files']['visa_scan'] = $_FILES['visa_scan'];
        }
        if (!empty($_FILES['tiket_scan']['name'])) {
            $data['files']['tiket_scan'] = $_FILES['tiket_scan'];
        }

        $this->load->model('registrasi');
        $result = $this->registrasi->updateMember($data);
        $redir_string = base_url() . 'home?id=' . $_POST['id_member'];
        redirect($redir_string);
    }

    public function hapus_upload() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id_member', 'id_member', 'trim|required|integer');
        $this->form_validation->set_rules('field', 'field', 'required');

        if ($this->form_validation->run() == FALSE) {
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

    public function agen_autocomplete() {
        $term = $_GET['r']['term'];
        $this->load->model('agen');
        $data = $this->agen->getAgen($term, 10);
        echo json_encode($data);
    }

}
