<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Bayar extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }
        //this page for master admin, manifest and finance
        if (!($_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Finance')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
    }

    public function index()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('idm', 'idm', 'trim|required|integer');


        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/jamaah');
        }
        $this->load->model('registrasi');
        $this->load->model('paketUmroh');
        $this->load->model('tarif');
        $jamaah = $this->registrasi->getJamaah(null, null, $_GET['idm']);
        $member = $jamaah->member;
        $paket = $this->paketUmroh->getPackage($member[0]->id_paket, false);
        $groupMembers = [];
        if ($member[0]->parent_id) {
            $groupMembers = $this->registrasi->getGroupMembers($member[0]->parent_id);
        }
        $pembayaran = $this->tarif->getRiwayatBayar($_GET['idm']);
        // echo '<pre>';
        // print_r($groupMembers);
        // echo exit();
        $this->load->view('staff/manifest_bayar', array(
            'member' => $member[0],
            'jamaah' => $jamaah,
            'paket' => $paket,
            'groupMembers' => $groupMembers,
            'pembayaran' => $pembayaran
        ));
    }

    public function proses_bayar()
    {
        $this->form_validation->set_rules('id_member', 'id member', 'trim|required|integer');
        $this->form_validation->set_rules('id_jamaah', 'id jamaah', 'trim|required|integer');
        $this->form_validation->set_rules('tanggal_bayar', 'tanggal_bayar', 'required');
        $this->form_validation->set_rules('jumlah_bayar', 'jumlah_bayar', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/jamaah');
        }

        $data = $_POST;
        $data['tanggal_bayar'] = date('Y-m-d H:i:s', strtotime($_POST['tanggal_bayar']));
        $data['jumlah_bayar'] = str_replace(",", "", $data['jumlah_bayar']);
        if (!empty($_FILES['scan_bayar']['name'])) {
            $data['files']['scan_bayar'] = $_FILES['scan_bayar'];
        }
        $this->load->model('tarif');
        $this->tarif->setPembayaran($data);

        redirect(base_url() . 'staff/info/detail_jamaah?id=' . $data['id_jamaah'] . '&id_member=' . $data['id_member']);
    }

    public function hapus_pembayaran()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('idm', 'id member', 'trim|required|integer');
        $this->form_validation->set_rules('idp', 'id pembayaran', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            echo 'access denied';
            return false;
        }
        $this->load->model('tarif');
        $this->tarif->hapusPembayaran($_GET['idp'], $_GET['idm']);
        redirect(base_url() . 'staff/info/riwayat_bayar?id=' . $_GET['idm']);
    }

    public function refund()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('idj', 'idj', 'trim|required|integer');
        $this->form_validation->set_rules('idm', 'idm', 'trim|required|integer');


        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/jamaah');
        }
        $this->load->model('registrasi');
        $this->load->model('paketUmroh');
        $jamaah = $this->registrasi->getJamaah($_GET['idj']);
        $member = $this->registrasi->getMember($_GET['idm']);
        $paket = $this->paketUmroh->getPackage($member[0]->id_paket, false);
        $groupMembers = [];
        if ($member[0]->parent_id) {
            $groupMembers = $this->registrasi->getGroupMembers($member[0]->parent_id);
        }
        // echo '<pre>';
        // print_r($groupMembers);
        // echo exit();
        $this->load->view('staff/refund_bayar', array(
            'member' => $member[0],
            'jamaah' => $jamaah,
            'paket' => $paket,
            'groupMembers' => $groupMembers,
        ));
    }

    public function proses_refund()
    {
        $this->form_validation->set_rules('id_member', 'id member', 'trim|required|integer');
        $this->form_validation->set_rules('id_jamaah', 'id jamaah', 'trim|required|integer');
        $this->form_validation->set_rules('tanggal_bayar', 'tanggal_bayar', 'required');
        $this->form_validation->set_rules('jumlah_bayar', 'jumlah_bayar', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/jamaah');
        }

        $data = $_POST;
        $data['jumlah_bayar'] = str_replace(",", "", $data['jumlah_bayar']);
        $data['jumlah_bayar'] = -$data['jumlah_bayar'];
        $data['jenis'] = 'refund';

        if (!empty($_FILES['scan_bayar']['name'])) {
            $data['files']['scan_bayar'] = $_FILES['scan_bayar'];
        }
        $this->load->model('tarif');
        $this->tarif->setPembayaran($data, 'refund');

        // $this->load->library('user_agent');
        // redirect($this->agent->referrer());
        redirect(base_url() . 'staff/finance/verifikasi_refund?id_paket=all');
    }
}
