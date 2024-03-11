<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Member extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }
        //this page only for admin
        if (!($_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Manifest' || $_SESSION['bagian'] == 'Finance')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
    }

    public function index()
    {
        if (!($_SESSION['bagian'] == 'Master Admin')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->load->view('staff/member_view');
    }
    public function pindah_paket($idJamaah = null, $idMember = null){
        if (!($idJamaah && $idMember)) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->load->model('registrasi');
        $jamaah = $this->registrasi->getJamaah($idJamaah, null, $idMember);
        if (!$jamaah) {
            $this->alert->set('danger', 'Jamaah Tidak Ditemukan');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage(null, false, false, true);
        $jamaah->paketTersedia = $paket;
        $this->load->view('staff/pindah_paket_view', $jamaah);
    }
    public function proses_pindah_paket(){
        $this->form_validation->set_rules('idMember', 'idMember', 'required');
        $this->form_validation->set_rules('idPaketLama', 'idPaketLama', 'required');
        $this->form_validation->set_rules('idPaketBaru', 'idPaketBaru', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Proses Pindah Paket Gagal!');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->model('registrasi');
        $pindah = $this->registrasi->pindahPaket($_POST['idMember'], $_POST['idPaketLama'], $_POST['idPaketBaru']);
        if (!$pindah['status']) {
            $this->alert->set('danger', $pindah['msg']);
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->alert->set('success', $pindah['msg']);
        $this->load->model('registrasi');
        $jamaah = $this->registrasi->getMember($_POST['idMember']);
        redirect(base_url() . "staff/info/detail_jamaah?id=" . $jamaah[0]->id_jamaah . "&id_member=" . $jamaah[0]->id_member);
    }

    public function tambah()
    {
        if (!($_SESSION['bagian'] == 'Master Admin')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->load->view('staff/member_tambah_view');
    }

    public function proses_tambah()
    {
        if (!($_SESSION['bagian'] == 'Master Admin')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('bagian', 'Bagian', 'trim|required|in_list[Admin,Manifest,Finance,Logistik,PR,Store]');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect(base_url() . 'staff/member/tambah');
        }

        $this->load->model('staff');
        //add new staff
        $this->staff->addStaff($_POST['nama'], $_POST['email'], $_POST['bagian']);
        redirect(base_url() . 'staff/member/tambah');
    }

    public function load_member()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'staff';
        // Primary key of table
        $primaryKey = 'id_staff';

        $columns = array(
            array('db' => 'id_staff', 'dt' => 'DT_RowId'),
            array('db' => 'nama', 'dt' => 0),
            array('db' => 'email', 'dt' => 1),
            array('db' => 'bagian', 'dt' => 2)
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        echo json_encode(
            SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
        );
    }

    public function reset()
    {
        if (!($_SESSION['bagian'] == 'Master Admin')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/member');
        }

        $this->load->model('staff');
        $this->staff->resetPassword($_GET['id']);
        redirect(base_url() . 'staff/member');
    }

    public function edit()
    {
        if (!($_SESSION['bagian'] == 'Master Admin')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/member');
        }
        $this->load->model('staff');
        $data = $this->staff->checkId($_GET['id']);
        if (!isset($data->id_staff)) {
            $this->alert->set('danger', 'Staff tidak ditemukan');
            redirect(base_url() . 'staff/member');
        }
        $this->load->view('staff/edit_member_view', $data);
    }

    public function proses_edit()
    {
        if (!($_SESSION['bagian'] == 'Master Admin')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->form_validation->set_rules('id_staff', 'ID Staff', 'trim|required|integer');
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('bagian', 'Bagian', 'trim|required|in_list[Admin,Manifest,Finance,Logistik,PR]');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect(base_url() . 'staff/member/edit?id=' . $_POST['id_staff']);
        }
        $data = array(
            'nama' => $_POST['nama'],
            'email' => $_POST['email'],
            'bagian' => $_POST['bagian'],
        );

        $this->load->model('staff');
        $this->staff->editStaff($_POST['id_staff'], $data);
        redirect(base_url() . 'staff/member');
    }

    public function hapus()
    {
        if (!($_SESSION['bagian'] == 'Master Admin')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/member');
        }

        $this->load->model('staff');
        $data = $this->staff->deleteStaff($_GET['id']);
        redirect(base_url() . 'staff/member');
    }
}