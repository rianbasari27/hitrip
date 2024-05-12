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
        if (!($_SESSION['bagian'] == 'Master Admin')) {
            $this->alert->toast('danger', 'Mohon Maaf', 'Anda tidak memiliki akses');
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
        echo json_encode($data);
    }

    public function tambah()
    {
        $this->load->view('staff/paket_tambah_view');
    }

    public function proses_tambah()
    {
        $this->form_validation->set_rules('nama_paket', 'Nama Paket', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('tanggal_berangkat', 'Tanggal Keberangkatan', 'trim|required');
        $this->form_validation->set_rules('negara', 'Negara', 'trim|required');
        $this->form_validation->set_rules('area_trip', 'Area Trip', 'trim|required');
        $this->form_validation->set_rules('harga', 'Harga', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            redirect(base_url() . 'staff/paket/tambah');
        }

        $data = $_POST;

        $data['harga'] = str_replace(",", "", $data['harga']);
        $data['harga_triple'] = str_replace(",", "", $data['harga_triple']);
        $data['harga_double'] = str_replace(",", "", $data['harga_double']);
        $data['default_diskon'] = str_replace(",", "", $data['default_diskon']);
        $data['jumlah_seat'] = str_replace(",", "", $data['jumlah_seat']);
        if (!empty($_FILES['banner_image']['name'])) {
            $data['files']['banner_image'] = $_FILES['banner_image'];
        }
        if (!empty($_FILES['paket_flyer']['name'])) {
            $data['files']['paket_flyer'] = $_FILES['paket_flyer'];
        }
        if (!empty($_FILES['itinerary']['name'])) {
            $data['files']['itinerary'] = $_FILES['itinerary'];
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
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->toast('danger', 'Mohon Maaf', 'Anda tidak memiliki akses');
            redirect(base_url() . 'staff/paket');
        }

        $this->load->library('date');
        $this->load->model('paketUmroh');
        $data = $this->paketUmroh->getPackage($_GET['id'], false);
        if (empty($data)) {
            $this->alert->toast('danger', 'Mohon Maaf', 'Paket tidak ditemukan');
            redirect(base_url() . 'staff/paket');
        }
        $this->load->view('staff/paket_view', $data);
    }

    public function upload()
    {
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->toast('danger', 'Mohon Maaf', 'Anda tidak memiliki akses');
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
            $this->alert->toast('danger', 'Mohon Maaf', 'Anda tidak memiliki akses');
            redirect(base_url() . 'staff/paket');
        }

        $this->load->model('paketUmroh');
        $result = $this->paketUmroh->deleteDokumen($_GET['id'], $_GET['field']);
        if ($result) {
            $this->alert->toast('success', 'Selamat', $_GET['field'] . ' berhasil dihapus');
        } else {
            $this->alert->toast('danger', 'Mohon Maaf', $_GET['field'] . ' gagal dihapus');
        }
        redirect(base_url() . 'staff/paket/lihat?id=' . $_GET['id']);
    }

    public function hapus()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->toast('danger', 'Mohon Maaf', 'Anda tidak memiliki akses');
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
            $this->alert->toast('danger', 'Mohon Maaf', 'Anda tidak memiliki akses');
            redirect(base_url() . 'staff/paket');
        }
        $this->load->model('paketUmroh');
        $data = $this->paketUmroh->getPackage($_GET['id']);
        $this->load->view('staff/hotel_tambah_view', $data);
    }

    public function proses_tambah_hotel()
    {
        $this->form_validation->set_rules('id_paket', 'ID Paket', 'trim|required|numeric');
        $this->form_validation->set_rules('nama_hotel', 'Nama Hotel', 'trim|required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->alert->toast('danger', 'Mohon Maaf', 'Anda tidak memiliki akses');
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
            $this->alert->toast('danger', 'Mohon Maaf', 'Anda tidak memiliki akses');
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
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->toast('danger', 'Mohon Maaf', 'Anda tidak memiliki akses');
            redirect(base_url() . 'staff/paket');
        }
        $this->load->model('paketUmroh');
        $data = $this->paketUmroh->getPackage($_GET['id'], false);
        $this->load->view('staff/ubah_paket_view', $data);
    }

    public function proses_ubah()
    {
        $this->form_validation->set_rules('id', 'ID Paket', 'trim|required|numeric');
        $this->form_validation->set_rules('nama_paket', 'Nama Paket', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('tanggal_berangkat', 'Tanggal Keberangkatan', 'trim|required');
        $this->form_validation->set_rules('harga', 'Harga', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->toast('danger', 'Mohon Maaf', 'Anda tidak memiliki akses');
            redirect(base_url() . 'staff/paket');
        }

        //add new package
        $this->load->model('paketUmroh');
        $data = $_POST;

        $data['harga'] = str_replace(",", "", $data['harga']);
        $data['harga_triple'] = str_replace(",", "", $data['harga_triple']);
        $data['harga_double'] = str_replace(",", "", $data['harga_double']);
        $data['default_diskon'] = str_replace(",", "", $data['default_diskon']);
        $data['jumlah_seat'] = str_replace(",", "", $data['jumlah_seat']);
        if (!($id = $this->paketUmroh->editPackage($data['id'], $data))) {
            $this->alert->toast('danger', 'Mohon Maaf', 'Paket gagal di ubah');
            redirect(base_url() . 'staff/paket/tambah');
        } else {
            $this->alert->toast('success', 'Selamat', 'Paket berhasil di ubah');
            redirect(base_url() . 'staff/paket/lihat?id=' . $id);
        }
    }
}