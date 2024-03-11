<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Request_dokumen extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }
//this page for master admin, manifest and finance
        if (!($_SESSION['bagian'] == 'Manifest' || $_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Admin')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
    }
    public function index(){
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage(null, false, false, true);
        if (isset($_GET['id_paket'])) {
            $id_paket = $_GET['id_paket'];
        } else {
            $id_paket = $paket[0]->id_paket;
        }

        $selectedPaket = $this->paketUmroh->getPackage($id_paket, false, false, false);

        $nama_paket = $selectedPaket->nama_paket . ' (' . date_format(date_create($selectedPaket->tanggal_berangkat), "d F Y") . ')';

        $this->load->view('staff/request_dokumen_view', $data = array(
            'paket' => $paket,
            'id_paket' => $id_paket,
            'nama_paket' => $nama_paket
        ));        
    }

    public function lihat_jamaah()
    {
        $this->load->view('staff/request_dokumen_view');
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

    public function load_request(){
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'request_dokumen';
        // Primary key of table
        $primaryKey = 'id_request';

        $columns = array(
            array('db' => '`pm`.`id_member`', 'dt' => 'DT_RowId', 'field' => 'id_member'),
            array('db' => '`req`.`id_request`', 'dt' => 'id_request', 'field' => 'id_request'),
            array('db' => '`pm`.`id_jamaah`', 'dt' => 'id_jamaah', 'field' => 'id_jamaah'),
            array('db' => '`j`.`first_name`', 'dt' => 'first_name', 'field' => 'first_name'),
            array('db' => '`j`.`second_name`', 'dt' => 'second_name', 'field' => 'second_name'),
            array('db' => '`j`.`last_name`', 'dt' => 'last_name', 'field' => 'last_name'),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`second_name`,' ',`j`.`last_name`) AS `whole_name`", 'dt' => "whole_name", 'field' => "whole_name"),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`last_name`) AS `two_name`", 'dt' => "two_name", 'field' => "two_name"),
            array('db' => '`pkt`.`id_paket`', 'dt' => 'id_paket', 'field' => 'id_paket'),
            array('db' => '`pkt`.`nama_paket`', 'dt' => 'nama_paket', 'field' => 'nama_paket'),    
            array('db' => '`req`.`tgl_request`', 'dt' => 'tgl_request', 'field' => 'tgl_request'),
            array('db' => '`j`.`no_wa`', 'dt' => 'no_wa', 'field' => 'no_wa'),                      
            array('db' => '`req`.`tambah_nama`', 'dt' => 'tambah_nama', 'field' => 'tambah_nama'),
            array('db' => '`req`.`nama_2_suku`', 'dt' => 'nama_2_suku', 'field' => 'nama_2_suku'),
            array('db' => '`req`.`status`', 'dt' => 'status', 'field' => 'status'),
            array('db' => '`pkt`.`tanggal_berangkat`', 'dt' => 'tanggal_berangkat', 'field' => 'tanggal_berangkat'),            
            array('db' => '`pm`.`parent_id`', 'dt' => 'parent_id', 'field' => 'parent_id'),
            array('db' => '`req`.`imigrasi`', 'dt' => 'imigrasi', 'field' => 'imigrasi')
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $joinQuery = "FROM `{$table}` AS `req`"
            . "JOIN `program_member` AS `pm` ON (`req`.`id_member` = `pm`.`id_member`)"
            . " JOIN `jamaah` AS `j` ON (`j`.`id_jamaah` = `pm`.`id_jamaah`)"
            . " LEFT JOIN `paket_umroh` AS `pkt` ON(`pkt`.`id_paket` = `pm`.`id_paket`)";
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery);

        //prepare extra data
        $this->load->model('registrasi');
        $groupCtr = 0;
        $groupArr = array();
        foreach ($data['data'] as $key => $d) {
            $data['data'][$key]['DT_RowAttr'] = array(
                'id_jamaah' => $d['id_jamaah'],
                'id_request' => $d['id_request'],
                'status' => $d['status']
            );

            //determine WG status
            $wg = $this->registrasi->getWG($d['DT_RowId']);
            $data['data'][$key]['wg'] = $wg;
            //set verification class
            if ($d['status'] == 2) {
                $data['data'][$key]['DT_RowClass'] = 'group-color-10';
            } elseif ($d['status'] == 1) {
                $data['data'][$key]['DT_RowClass'] = 'group-color-11';
            }        
        }
        echo json_encode($data);
    }
    // public function input() {
    //     $this->load->view('staff/input_request');
    //     // echo '<pre>';
    //     // print_r($data);
    //     // exit();
    // }
    // public function input_form(){
    //     $this->form_validation->set_data($this->input->get());
    //     $this->form_validation->set_rules('idj', 'idj', 'trim|required|integer');
    //     $this->form_validation->set_rules('idm', 'idm', 'trim|required|integer');
    //     if ($this->form_validation->run() == FALSE) {
    //         $this->alert->set('danger', 'Access Denied');
    //         redirect(base_url() . 'staff/request_dokumen');
    //         return false;
    //     }
    //     $this->load->model('registrasi');
    //     $data_jamaah = $this->registrasi->getJamaah($_GET['idj']);
    //     if (empty($data_jamaah)) {
    //         $this->alert->set('danger', 'Data Tidak Ditemukan');
    //         redirect(base_url() . 'staff/request_dokumen');
    //         return false;
    //     }
    //     $dataReq = $this->registrasi->getMember($_GET['idm']);
    //     if (empty($dataReq)) {
    //         $this->alert->set('danger', 'Data Tidak Ditemukan');
    //         redirect(base_url() . 'staff/request_dokumen');
    //         return false;
    //     }     
    //     $this->load->model('tarif');
    //     $data_member = $this->tarif->getRequest($_GET['idm']);
    //     if (empty($data_member['data'])) {
    //         $this->alert->set('danger', 'Data Tidak Ditemukan');
    //         redirect(base_url() . 'staff/request_dokumen');
    //     }
    //     $this->load->model('paketUmroh');
    //     $paket = $this->paketUmroh->getPackage($dataReq[0]->id_paket, false);
    //     $this->load->view('staff/input_request', $data = array(
    //         'jamaah' => $data_jamaah,
    //         'member' => $data_member['data'],
    //         'paket' => $paket,
    //         'dataReq' => $dataReq[0]
    //     ));
    // }
    public function req(){
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('idr', 'idr', 'trim|required|integer');
        $this->form_validation->set_rules('idm', 'idm', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/request_dokumen');
            return false;
        }
        $this->load->model('registrasi');
        $data_jamaah = $this->registrasi->getJamaah(null, null,$_GET['idm']);
        if (empty($data_jamaah)) {
            $this->alert->set('danger', 'Data Tidak Ditemukan');
            redirect(base_url() . 'staff/request_dokumen');
            return false;
        }
        $dataReq = $this->registrasi->getMember($_GET['idm']);
        if (empty($dataReq)) {
            $this->alert->set('danger', 'Data Tidak Ditemukan');
            redirect(base_url() . 'staff/request_dokumen');
            return false;
        }     
        $this->load->model('tarif');
        $data_member = $this->tarif->getRequest($_GET['idr']);
        if (empty($data_member['data'])) {
            $this->alert->set('danger', 'Data Tidak Ditemukan');
            redirect(base_url() . 'staff/request_dokumen');
        }
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage($dataReq[0]->id_paket, false);
        $this->load->view('staff/verif_dokum_view', $data = array(
            'jamaah' => $data_jamaah,
            'member' => $data_member['data'],
            'paket' => $paket,
            'dataReq' => $dataReq[0],
            'id_request' => $_GET['idr']
        ));
    }
    public function proses_update_req(){
        $member = $_POST;
        if (!empty($_FILES['imigrasi']['name'])) {
            $member['files']['imigrasi'] = $_FILES['imigrasi'];
        }
        if (!empty($_FILES['kemenag']['name'])) {
            $member['files']['kemenag'] = $_FILES['kemenag'];
        }
        $this->load->model('registrasi');
        $result = $this->registrasi->updateImigrasi($member);         
        $redir_string = base_url() . 'staff/request_dokumen';
        if (isset($_POST['id_member'])) {
            $redir_string = $redir_string ;
        }
        redirect($redir_string);
    }

    public function hapus()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/request_dokumen');
        }
        $this->load->model('registrasi');
        $data = $this->registrasi->deleteRequest($_GET['id']);
        if ($data == true) {
            $this->alert->set('success', 'Data Request Berhasil Dihapus');
        } else {
            $this->alert->set('danger', 'Data Request Gagal Dihapus');
        }
        redirect(base_url() . 'staff/request_dokumen');
    }

    public function dl_imigrasi()
    {
        if (isset($_GET['idr'])) {
            $this->load->model('registrasi');
            $data = $this->registrasi->getImigrasi($_GET['idr'], null);
            $filename = $data[0]->imigrasi;

            if (file_exists(SITE_ROOT . $filename)) {
                redirect(base_url() . $filename);
            } else {
                $this->alert->setJamaah('red', 'Ups...', 'File tidak tersedia');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function dl_kemenag()
    {
        if (isset($_GET['idr'])) {
            $this->load->model('registrasi');
            $data = $this->registrasi->getImigrasi($_GET['idr'], null);
            $filename = $data[0]->kemenag;

            if (file_exists(SITE_ROOT . $filename)) {
                redirect(base_url() . $filename);
            } else {
                $this->alert->setJamaah('red', 'Ups...', 'File tidak tersedia');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
}