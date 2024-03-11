<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Broadcast_agen extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }
        //this page only for admin
        if (!($_SESSION['bagian'] == 'Admin' || $_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'PR')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
    }

    public function index() {

        $this->load->model('bcast');
        $pesan = $this->bcast->getPesanAgen(null, null, null, 1);
        foreach ($pesan as $key => $p) {
            $getlink1 = explode('|', $pesan[$key]->link1);
            $getlink2 = explode('|', $pesan[$key]->link2);
            $getlink3 = explode('|', $pesan[$key]->link3);
            $pesan[$key]->nama_link1 = isset($getlink1[0]) ? $getlink1[0] : null;
            $pesan[$key]->nama_link2 = isset($getlink2[0]) ? $getlink2[0] : null;
            $pesan[$key]->nama_link3 = isset($getlink3[0]) ? $getlink3[0] : null;
            $pesan[$key]->link1 = isset($getlink1[1]) ? $getlink1[1] : null;
            $pesan[$key]->link2 = isset($getlink2[1]) ? $getlink2[1] : null;
            $pesan[$key]->link3 = isset($getlink3[1]) ? $getlink3[1] : null;
        }
        $this->load->model('agen');
        $agen = $this->agen->getAgen();
        $id_agen = "";
        foreach ($agen as $key => $a) {
            $id_agen = $id_agen . $a->id_agen ." ";
        }
        $hasil = explode(" ", $id_agen);
        $count = count($hasil);
        unset($hasil[$count-1]);
        $a = implode(",", $hasil);
        $data = array(
            'pesan' => $pesan,
            'agen' => $agen,
            'a' => $a
        );
        $this->load->view('staff/broadcast_agen_view', $data);
    }

    public function load_agen() {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'agen';
        $primaryKey = 'id_agen';

        $columns = array(
            array('db' => 'id_agen', 'dt' => 'id_agen', 'field' => 'id_agen'),
            array('db' => 'no_agen', 'dt' => 'no_agen', 'field' => 'no_agen'),
            array('db' => 'nama_agen', 'dt' => 'nama_agen', 'field' => 'nama_agen'),
            array('db' => 'email', 'dt' => 'email', 'field' => 'email'),
            array('db' => 'no_wa', 'dt' => 'no_wa', 'field' => 'no_wa'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns);
        echo json_encode($data);
    }

    // public function load_id_agens() {
    //     $this->load->model('agen');
    //     $result = $this->agen->getAgen();
    //     $data = array();
    
    //     foreach ($result as $row) {
    //         $data[] = array(
    //             "id_agen" => $row->id_agen,
    //         );
    //     }
    //     echo json_encode(array("data" => $data));
    // }

    public function proses_tambah() {
        $this->form_validation->set_rules('pesan', 'Pesan', 'required|trim');
        $this->form_validation->set_rules('judul', 'Judul', 'required|trim');
        $this->form_validation->set_rules('id_agen[]', 'Pilih Konsultan', 'required|trim');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect(base_url() . 'staff/broadcast_agen');
        }
        $data = $_POST;

        $this->load->model('bcast');
        $data['pesan'] = str_replace('`', '<br>', $data['pesan']);
        $data['link1'] = ($data['nama_link1'] != null && $data['link1'] != null) ? implode("|", [$data['nama_link1'], $data['link1']]) : null;
        $data['link2'] = ($data['nama_link2'] != null && $data['link2'] != null) ? implode("|", [$data['nama_link2'], $data['link2']]) : null;
        $data['link3'] = ($data['nama_link3'] != null && $data['link3'] != null) ? implode("|", [$data['nama_link3'], $data['link3']]) : null;
        
        if (!empty($_FILES['flyer_image']['name'])) {
            $data['flyer_image'] = $_FILES['flyer_image'];
        }
        unset($data['nama_link1']);
        unset($data['nama_link2']);
        unset($data['nama_link3']);
        // echo '<pre>';
        // print_r($data);
        // exit();
        $this->bcast->addPostAgen($data);
        $this->alert->set('success', 'Pesan berhasil di broadcast');
        redirect(base_url() . 'staff/broadcast_agen');
    }

    public function status(){
        $this->form_validation->set_rules('id_broadcast', 'id_broadcast', 'trim|required|numeric');
        $this->form_validation->set_rules('tampilkan', 'Status', 'trim|required|numeric');
        $this->form_validation->set_rules('color', 'Warna Background', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect(base_url() . 'staff/broadcast_agen');
        }

        $data = $_POST;

        $this->load->model('bcast');
        $bcast = $this->bcast->getPesanAgen($data['id_broadcast']);
        $id_agen = $bcast[0]->id_agen;
        $data['pesan'] = str_replace('`', '<br>', $data['pesan']);
        $data['link1'] = implode("|", [$data['nama_link1'], $data['link1']]);
        $data['link2'] = implode("|", [$data['nama_link2'], $data['link2']]);
        $data['link3'] = implode("|", [$data['nama_link3'], $data['link3']]);

        if (!empty($_FILES['flyer_image']['name'])) {
            $data['flyer_image'] = $_FILES['flyer_image'];
        }

        unset($data['nama_link1']);
        unset($data['nama_link2']);
        unset($data['nama_link3']);
        $this->bcast->updateTampilkanAgen($data['id_broadcast'], $data);
        $this->alert->set('success', 'Status berhasil diubah');
        redirect(base_url() . 'staff/broadcast_agen?id='.$id_agen);
    }

    public function hapus() {
        // $this->form_validation->set_data($this->input->get());
        // $this->form_validation->set_rules('id', 'id', 'trim|required|numeric');
        // if ($this->form_validation->run() == FALSE) {
        //     $this->alert->set('danger', validation_errors());
        //     redirect(base_url() . 'staff/broadcast_agen');
        // }

        $this->load->model('bcast');
        $bcast = $this->bcast->getPesanAgen($_GET['id_broadcast']);
        $this->bcast->deletePostAgen($_GET['id_broadcast']);
        $id_broadcast = $bcast->id_broadcast;
        $this->alert->set('success', 'Status berhasil dihapus');
        redirect(base_url() . 'staff/broadcast_agen?id='.$id_broadcast);
    }

    public function hapus_flyer()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'ID', 'trim|required|integer');
        // $this->form_validation->set_rules('field', 'field', 'required');

        if ($this->form_validation->run() == FALSE) {
            return false;
        }
        $this->load->model('bcast');
        $result = $this->bcast->deleteFlyer($_GET['id']);
        if ($result == true) {
            echo json_encode(true);
        } else {
            return false;
        }
    }

}