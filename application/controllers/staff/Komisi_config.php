<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Komisi_config extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }
        //this page only for admin
        if (!($_SESSION['bagian'] == 'Admin' || $_SESSION['bagian'] == 'Master Admin' )) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
    } 

    public function index() {
        // $data = array(
        //     'id_config' => array(
        //         1 => 2,
        //         4 => 5,
        //         5 => 6,
        //         2 => 3,
        //         3 => 4
        //     ),
        //     'syarat' => array(
        //         1 => 10,
        //         4 => 10,
        //         5 => 30,
        //         2 => 1,
        //         3 => 1
        //     ),
        //     'value' => array(
        //         1 => 1000000,
        //         4 => 1000000,
        //         5 => 2000000,
        //         2 => 500000,
        //         3 => 100000
        //     )
        // );
        
        // foreach ($data as $key => $subArray) {
        //     echo "Array '$key':<br>";
        //     foreach ($subArray as $subKey => $value) {
        //         echo "[$subKey] => $value<br>";
        //     }
        //     echo "<br>";
        // }
        // return;
        $this->load->model('komisiConfig');
        $komisi = $this->komisiConfig->getKomisiConfig(null);
        $data = array(
            'komisi' => $komisi
        );
        // echo '<pre>';
        // print_r($komisi);
        // exit();
        return $this->load->view('staff/komisi_config_view', $data);
    }

    public function load_komisi() {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'komisi_config';
        $primaryKey = 'id_config';

        $columns = array(
            array('db' => 'id_config', 'dt' => 'id_config', 'field' => 'id_config'),
            array('db' => 'nama', 'dt' => 'nama', 'field' => 'nama'),
            array('db' => 'syarat', 'dt' => 'syarat', 'field' => 'syarat'),
            array('db' => 'value', 'dt' => 'value', 'field' => 'value'),
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

    public function update()
    {
        if (!($_SESSION['bagian'] == 'Admin' || $_SESSION['bagian'] == 'Master Admin')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect(base_url() . 'staff/komisi_config');
        }
        $this->load->model('komisiConfig');
        $komisi = $this->komisiConfig->getKomisiConfig($_GET['id'], false);
        $data = array(
            "komisi" => $komisi[0]
        );

        $this->load->view('staff/ubah_komisi_config', $data);
    }

    public function proses_update() {
        $id_config = $_POST['id_config'];
        $syarat = $_POST['syarat'];
        $value = $_POST['value'];
        
        $this->load->model('komisiConfig');
        for ($i=0; $i < count($id_config); $i++) { 
            $data = array(
                'syarat' => $syarat[$i],
                'value' => $value[$i]
            );
            $this->komisiConfig->updateKomisiConfig($id_config[$i], $data);
        }
        $this->alert->set('success', 'Status berhasil diubah');
        redirect(base_url() . 'staff/komisi_config');
    }
     
}