<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Paket extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }
        //this page only for admin
        if (!($_SESSION['bagian'] == 'Admin' || $_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Finance' || $_SESSION['bagian'] == 'Manifest')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
    }

    public function index()
    {
        $this->load->model('paketUmroh');
        if (isset($_GET['month'])) {
            $month = $_GET['month'];
        } else {
            $month = 0;
        }

        $this->load->library('Date');
        $nama_bulan = $this->date->getMonth($month);
        $monthPackage = $this->paketUmroh->getAvailableMonths(false);
        $data = array(
            'month' => $month,
            'monthPackage' => $monthPackage,
            'nama_bulan' => $nama_bulan
        );
        $this->load->view('staff/paket_list_view', $data);
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
            array('db' => 'jumlah_seat', 'dt' => 2),
            array(
                'db' => 'harga',
                'dt' => 3,
                'formatter' => function ($d, $row) {
                    return number_format($d);
                }
            ),
            array(
                'db' => 'harga_triple',
                'dt' => 4,
                'formatter' => function ($d, $row) {
                    return number_format($d);
                }
            ),
            array(
                'db' => 'harga_double',
                'dt' => 5,
                'formatter' => function ($d, $row) {
                    return number_format($d);
                }
            ),
            array(
                'db' => 'publish',
                'dt' => 6,
                'formatter' => function ($d, $row) {
                    if ($d == 1) {
                        return "Ya";
                    } else {
                        return "Tidak";
                    }
                }
            ),
            array('db' => 'published_at', 'dt' => 7),
        );
        $month = $_GET['month'];
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        if (isset($_GET['month'])) {
            if ($_GET['month'] != 0) {
                $extraCondition = "MONTH(tanggal_berangkat) =" . $month;
            } else {
                $extraCondition = null;
            }
        } elseif (!isset($_GET['month'])) {
            $extraCondition = null;
        }

        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, null, $extraCondition);

        $this->load->model('bcast');
        foreach ($data['data'] as $key => $item) {
            $broadcast = $this->bcast->getPesan(null, $data['data'][$key]['DT_RowId']);
            if ($broadcast != null) {
                $data['data'][$key]['status_bcast'] = 1;
            } else {
                $data['data'][$key]['status_bcast'] = 0;
            }
        }

        echo json_encode($data);
    }

    public function tambah()
    {
        if (!($_SESSION['bagian'] == 'Admin' || $_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Finance')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->load->view('staff/paket_tambah_view');
    }

    public function proses_tambah()
    {
        if (!($_SESSION['bagian'] == 'Admin' || $_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Finance')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->form_validation->set_rules('nama_paket', 'Nama Paket', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('tanggal_berangkat', 'Tanggal Keberangkatan', 'trim|required');
        $this->form_validation->set_rules('isi_kamar', 'Isi Kamar', 'trim|required|numeric');
        $this->form_validation->set_rules('minimal_dp', 'Minimal DP', 'trim|required');
        $this->form_validation->set_rules('harga', 'Harga', 'trim|required');
        $this->form_validation->set_rules('denda', 'Nominal Denda', 'trim|required');
        $this->form_validation->set_rules('maskapai', 'Maskapai', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect(base_url() . 'staff/paket/tambah');
        }

        $data = $_POST;

        $data['minimal_dp'] = str_replace(",", "", $data['minimal_dp']);
        $data['dp_display'] = str_replace(",", "", $data['dp_display']);
        $data['harga'] = str_replace(",", "", $data['harga']);
        $data['harga_triple'] = str_replace(",", "", $data['harga_triple']);
        $data['harga_double'] = str_replace(",", "", $data['harga_double']);
        $data['default_diskon'] = str_replace(",", "", $data['default_diskon']);
        $data['komisi_langsung_fee'] = str_replace(",", "", $data['komisi_langsung_fee']);
        $data['denda'] = str_replace(",", "", $data['denda']);
        if (!empty($_FILES['banner_image']['name'])) {
            $data['files']['banner_image'] = $_FILES['banner_image'];
        }
        //add new package
        $this->load->model('paketUmroh');
        if (!($id = $this->paketUmroh->addPackage($data))) {
            redirect(base_url() . 'staff/paket/tambah');
        } else {
            redirect(base_url() . 'staff/paket/lihat?id=' . $id);
        }
    }

    public function lihat()
    {
        if (!($_SESSION['bagian'] == 'Admin' || $_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Finance')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/paket');
        }

        $this->load->library('date');
        $this->load->model('paketUmroh');
        $data = $this->paketUmroh->getPackage($_GET['id'], false);
        $this->db->where('id_paket', $_GET['id']);
        $this->db->order_by('id_log', 'desc');
        $discount_log = $this->db->get('discount_log')->row();
        if ($discount_log) {
            $data->waktu_diskon_start = $discount_log->tanggal_mulai != "0000-00-00" ? $this->date->convert_date_indo($discount_log->tanggal_mulai) : '';
            $data->waktu_diskon_end = $discount_log->tanggal_berakhir != "0000-00-00" ? $this->date->convert_date_indo($discount_log->tanggal_berakhir) : '';
            $data->deskripsi_diskon = $discount_log->deskripsi_diskon;
        } else {
            $data->waktu_diskon_start = '';
            $data->waktu_diskon_end = '';
            $data->deskripsi_diskon = '';
        }
        if (empty($data)) {
            $this->alert->set('danger', 'Paket tidak ditemukan');
            redirect(base_url() . 'staff/paket');
        }
        $this->load->view('staff/paket_view', $data);
    }

    public function upload()
    {

        if (!($_SESSION['bagian'] == 'Admin' || $_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Finance')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/paket');
        }
        $this->load->model('paketUmroh');
        $up = $this->paketUmroh->uploadDokumen($_FILES, $_POST['id']);
        redirect(base_url() . 'staff/paket/lihat?id=' . $_POST['id']);
    }

    public function delete_upload()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
        $this->form_validation->set_rules('field', 'field', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/paket');
        }

        $this->load->model('paketUmroh');
        $result = $this->paketUmroh->deleteDokumen($_GET['id'], $_GET['field']);
        if ($result) {
            $this->alert->set('success', "Data berhasil dihapus");
        } else {
            $this->alert->set('danger', "Data gagal dihapus");
        }
        redirect(base_url() . 'staff/paket/lihat?id=' . $_GET['id']);
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
            redirect(base_url() . 'staff/paket');
        }

        $this->load->model('paketUmroh');
        $data = $this->paketUmroh->deletePackage($_GET['id']);
        redirect(base_url() . 'staff/paket');
    }

    public function tambah_hotel()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/paket');
        }
        $this->load->model('paketUmroh');
        $data = $this->paketUmroh->getPackage($_GET['id']);
        $this->load->view('staff/hotel_tambah_view', $data);
    }

    public function proses_tambah_hotel()
    {
        $this->form_validation->set_rules('id_paket', 'ID Paket', 'trim|required|numeric');
        $this->form_validation->set_rules('nama_hotel', 'Nama Hotel', 'trim|required|alpha_numeric_spaces');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect(base_url() . 'staff/paket');
        }

        $data = $_POST;
        if (!empty($_FILES['foto']['name'])) {
            $data['files']['foto'] = $_FILES['foto'];
        }
        //add new hotel
        $this->load->model('paketUmroh');
        $this->paketUmroh->addHotel($data);
        redirect(base_url() . 'staff/paket/lihat?id=' . $data['id_paket']);
    }

    public function hapus_hotel()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect(base_url() . 'staff/paket');
        }

        //hapus hotel
        $this->load->model('paketUmroh');
        if (!($id_paket = $this->paketUmroh->deleteHotel($_GET['id']))) {
            redirect(base_url() . 'staff/paket');
        } else {
            redirect(base_url() . 'staff/paket/lihat?id=' . $id_paket);
        }
    }

    public function ubah_paket()
    {
        if (!($_SESSION['bagian'] == 'Admin' || $_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Finance')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect(base_url() . 'staff/paket');
        }
        $this->load->model('paketUmroh');
        $data = $this->paketUmroh->getPackage($_GET['id'], false);
        $this->db->where('id_paket', $_GET['id']);
        $this->db->order_by('id_log', 'desc');
        $discount = $this->db->get('discount_log')->row();
        if ($discount) {
            $data->waktu_diskon_start = $discount->tanggal_mulai;
            $data->waktu_diskon_end = $discount->tanggal_berakhir;
            $data->deskripsi_diskon = $discount->deskripsi_diskon;
        } else {
            $data->waktu_diskon_start = '';
            $data->waktu_diskon_end = '';
            $data->deskripsi_diskon = '';
        }
        // echo '<pre>';
        // print_r($data);
        // exit();
        $this->load->view('staff/ubah_paket_view', $data);
    }

    public function proses_ubah()
    {
        $this->form_validation->set_rules('id', 'ID Paket', 'trim|required|numeric');
        $this->form_validation->set_rules('nama_paket', 'Nama Paket', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('tanggal_berangkat', 'Tanggal Keberangkatan', 'trim|required');
        $this->form_validation->set_rules('isi_kamar', 'Isi Kamar', 'trim|required|numeric');
        $this->form_validation->set_rules('harga', 'Harga', 'trim|required');
        $this->form_validation->set_rules('denda', 'Nominal Denda', 'trim|required');
        $this->form_validation->set_rules('maskapai', 'Maskapai', 'trim|required|in_list[BELUM TERSEDIA,SAUDIA,QATAR,OMAN,EMIRATES,LION AIR,SRILANKAN,GARUDA INDONESIA,ETIHAD,TURKISH AIRLINE]');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect(base_url() . 'staff/paket');
        }

        //add new package
        $this->load->model('paketUmroh');
        $data = $_POST;

        $data['minimal_dp'] = str_replace(",", "", $data['minimal_dp']);
        $data['dp_display'] = str_replace(",", "", $data['dp_display']);
        $data['harga'] = str_replace(",", "", $data['harga']);
        $data['harga_triple'] = str_replace(",", "", $data['harga_triple']);
        $data['harga_double'] = str_replace(",", "", $data['harga_double']);
        $data['default_diskon'] = str_replace(",", "", $data['default_diskon']);
        $data['komisi_langsung_fee'] = str_replace(",", "", $data['komisi_langsung_fee']);
        $data['denda'] = str_replace(",", "", $data['denda']);

        if (!empty($_FILES['banner_image']['name'])) {
            $data['files']['banner_image'] = $_FILES['banner_image'];
        }
        if (!($id = $this->paketUmroh->editPackage($data['id'], $data))) {
            redirect(base_url() . 'staff/paket/tambah');
        } else {
            redirect(base_url() . 'staff/paket/lihat?id=' . $id);
        }
    }
}
