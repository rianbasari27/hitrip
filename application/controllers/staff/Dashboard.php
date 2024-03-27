<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $this->load->library('login_lib');
        // if ($this->login_lib->checkSession() == false) {
        //     redirect(base_url() . 'staff/login');
        // }
    }
    
    public function index()
    {
        // $this->load->model('paketUmroh');
        // $this->load->model('registrasi');
        // $this->load->model('logistik');
        // $paket = $this->paketUmroh->getPackage(null, true);
        // $nextTrip = [];
        // $totalJamaah = 0;
        // $member = [];
        // if (!empty($paket)) {
        //     $nextTrip = $paket[0];
        //     $this->load->library('calculate');
        //     $nextTrip->countdown = $this->calculate->dateDiff($nextTrip->tanggal_berangkat, date('Y-m-d'));

        //     $member = $this->registrasi->getMember(null, null, $nextTrip->id_paket);
        //     if ($member) {
        //         $totalJamaah = count($member);
        //     }
        // }

        // $packagePublished = $this->paketUmroh->getPackage(null, true, 'yes');
        // if ($packagePublished) {
        //     $packagePublished = count($packagePublished);
        // } else {
        //     $packagePublished = 0;
        // }
        // $packageUnPublished = $this->paketUmroh->getPackage(null, true, 'no');
        // if ($packageUnPublished) {
        //     $packageUnPublished = count($packageUnPublished);
        // } else {
        //     $packageUnPublished = 0;
        // }

        // $this->load->model('dashboardModel');
        // $info_seat = null;
        // if (in_array($_SESSION['bagian'], array('Finance', 'Master Admin', 'Manifest'))) {
        // $info_seat = $this->dashboardModel->getInfoSeat();
        // }
        // $detail_perl = null;
        // if (in_array($_SESSION['bagian'], array('Logistik', 'Master Admin'))) {
        // $detail_perl = $this->dashboardModel->getDetailPerlengkapan();
        // }


        // // $perlengkapan = $this->paketUmroh->getPackage(null, true);

        // $newRegistrar = null;
        // $berkas = null;
        // if (in_array($_SESSION['bagian'], array('Manifest', 'Master Admin', 'Finance'))) {
        //     $newRegistrar = $this->registrasi->getNewRegistrar(5);
        //     if (!empty($nextTrip)) {
        //         $berkas = $this->registrasi->getBerkasBelumLengkap($nextTrip->id_paket);
        //     }
        // }
        // $unverified = null;
        // if (in_array($_SESSION['bagian'], array('Finance', 'Master Admin'))) {
        //     $this->load->model('tarif');
        //     $unverified = $this->tarif->getUnverified();
        // }
        // $statusPerlengkapan = null;
        // $statusPengambilan = null;
        // if (!empty($nextTrip)) {
        //     if (in_array($_SESSION['bagian'], array('Logistik', 'Master Admin'))) {
        //         $this->load->model('logistik');
        //         $statusPerlengkapan = $this->logistik->getStatusPerlengkapanPaket($nextTrip->id_paket);
        //         $statusPengambilan = $this->logistik->getStatusPengambilan($nextTrip->id_paket);
        //     }
        // }
        // $data = array(
        //     'paket' => $paket,
        //     'nextTrip' => $nextTrip,
        //     'totalJamaah' => $totalJamaah,
        //     'packagePublished' => $packagePublished,
        //     'packageUnpublished' => $packageUnPublished,
        //     'newRegistrar' => $newRegistrar ? $newRegistrar : [],
        //     'berkas' => $berkas,
        //     'unverified' => $unverified,
        //     'statusPerlengkapan' => $statusPerlengkapan,
        //     'statusPengambilan' => $statusPengambilan,
        //     'info_seat' => $info_seat,
        //     'detail_perl' => $detail_perl,
        //     // 'perlengkapan' =>$perlengkapan
        // );
        $this->load->view('staff2/dash_view');
    }

    public function load_jamaah() {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'program_member';
        // Primary key of table
        $primaryKey = 'id_member';
        $columns = array(
            array('db' => '`pm`.`id_member`', 'dt' => 'DT_RowId', 'field' => 'id_member'),
            array('db' => '`pm`.`id_paket`', 'dt' => 'id_paket', 'field' => 'id_paket'),
            array('db' => '`pm`.`lunas`', 'dt' => 'lunas', 'field' => 'lunas'),
            array('db' => '`pm`.`register_from`', 'dt' => 'register_from', 'field' => 'register_from'),
            array('db' => '`pm`.`tgl_regist`', 'dt' => 'tgl_regist', 'field' => 'tgl_regist'),
            array('db' => '`j`.`id_jamaah`', 'dt' => 'id_jamaah', 'field' => 'id_jamaah'),
            array('db' => '`j`.`first_name`', 'dt' => 'first_name', 'field' => 'first_name'),
            array('db' => '`j`.`second_name`', 'dt' => 'second_name', 'field' => 'second_name'),
            array('db' => '`j`.`last_name`', 'dt' => 'last_name', 'field' => 'last_name'),
            array('db' => '`j`.`no_wa`', 'dt' => 'no_wa', 'field' => 'no_wa'),
            array('db' => '`pkt`.`nama_paket`', 'dt' => 'nama_paket', 'field' => 'nama_paket'),
            array('db' => '`pkt`.`tanggal_berangkat`', 'dt' => 'tanggal_berangkat', 'field' => 'tanggal_berangkat'),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`second_name`,' ',`j`.`last_name`) AS `whole_name`", 'dt' => "whole_name", 'field' => "whole_name"),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`last_name`) AS `set_name`", 'dt' => "set_name", 'field' => "set_name")
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $joinQuery = "FROM `{$table}` AS `pm`"
        . " JOIN `jamaah` AS `j` ON(`j`.`id_jamaah` = `pm`.`id_jamaah`)"
        . " JOIN `paket_umroh` AS `pkt` ON (`pkt`.`id_paket` = `pm`.`id_paket`)"
        . " LEFT JOIN `agen` AS `a` ON (`a`.`id_agen` = `pm`.`id_agen`)";
        $extraCondition = "`pkt`.`tanggal_berangkat` >= '" . date('Y-m-d') ."' AND DATE(`pm`.`tgl_regist`) = '". date('Y-m-d') . "'";
        
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition);
        foreach ($data['data'] as $key => $d) {
            $data['data'][$key]['full_name'] = implode(' ', [$d['first_name'], $d['second_name'], $d['last_name']]);
        }
        echo json_encode($data) ;
    }

    public function chat()
    {
        $this->load->model('chat');
        $messages = $this->chat->getMessages(50);
        $this->load->view('staff/dashboard_chat', array('pesan' => $messages));
    }

    public function send_chat()
    {
        $this->form_validation->set_rules('message', 'message', 'required');
        if ($this->form_validation->run() == FALSE) {
            redirect(base_url() . 'staff/dashboard/chat');
        }
        $this->load->model('chat');
        $id_staff = $_SESSION['id_staff'];
        $message = $_POST['message'];
        $send = $this->chat->send($id_staff, $message);
        redirect(base_url() . 'staff/dashboard/chat');
    }

    public function delete_chat()
    {
        $id_staff = $_SESSION['id_staff'];
        $this->load->model('chat');
        $del = $this->chat->deleteLastSent($id_staff);
        redirect(base_url() . 'staff/dashboard/chat');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url() . 'staff/login');
    }
}
