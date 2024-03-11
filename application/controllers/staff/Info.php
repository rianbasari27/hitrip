<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Info extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }
        //this page is for everybody unless specified
    }

    public function lihat_jamaah()
    {
        $this->load->view('staff/lihat_jamaah_paket');
    }

    public function load_paket()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'paket_umroh';
        // Primary key of table
        $primaryKey = 'id_paket';

        $columns = array(
            array('db' => 'id_paket', 'dt' => 'DT_RowId'),
            array('db' => 'nama_paket', 'dt' => 0),
            array('db' => 'tanggal_berangkat', 'dt' => 1),
            array(
                'db' => 'harga',
                'dt' => 2,
                'formatter' => function ($d, $row) {
                    return number_format($d);
                }
            ),
            array(
                'db' => 'harga_triple',
                'dt' => 3,
                'formatter' => function ($d, $row) {
                    return number_format($d);
                }
            ),
            array(
                'db' => 'harga_double',
                'dt' => 4,
                'formatter' => function ($d, $row) {
                    return number_format($d);
                }
            ),
            array(
                'db' => 'publish',
                'dt' => 5,
                'formatter' => function ($d, $row) {
                    if ($d == 1) {
                        return "Ya";
                    } else {
                        return "Tidak";
                    }
                }
            )
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

    public function rincian_harga()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            echo 'Access Denied';
            return false;
        }
        $this->load->model('tarif');
        $data = $this->tarif->calcTariff($_GET['id']);
        $this->load->view('staff/rincian_harga', $data);
    }

    public function riwayat_bayar()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            echo 'Access Denied';
            return false;
        }
        $this->load->model('tarif');
        $data = $this->tarif->getRiwayatBayar($_GET['id']);

        $this->load->view('staff/riwayat_bayar_new', $data);
    }

    public function detail_jamaah()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/jamaah');
        }

        $this->load->model('registrasi');
        $data = $this->registrasi->getJamaah($_GET['id']);
        if (empty($data)) {
            $this->alert->set('danger', 'Data Tidak Ditemukan');
            redirect(base_url() . 'staff/jamaah');
        }

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
        $this->load->view('staff/detail_view', $data);
    }

    public function pdf()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
        $this->form_validation->set_rules('paket', 'paket', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/jamaah');
        }
        $this->load->model('registrasi');
        $jamaahInfo = $this->registrasi->getJamaah($_GET['id']);
        $memberInfo = $jamaahInfo->member[$_GET['paket']];

        if (!empty($memberInfo->parent_id)) {
            $family = $this->registrasi->getGroupMembers($memberInfo->parent_id);
        } else {
            $family = array();
        }

        $data = array(
            'identitas' => $jamaahInfo,
            'infoPaket' => $memberInfo,
            'family' => $family
        );
        $this->load->library('Pdf');
        $this->load->view('staff/dl_info_jamaah', $data);
    }

    public function validasi() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id_member', 'id_member', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            return false;
        }
        $this->load->model('customer');
        $data = $this->customer->valid($_GET['id_member'], $_GET['valid']);
        if ($data == true) {
            echo json_encode(true);
        } else {
            return false;
        }
    }
}