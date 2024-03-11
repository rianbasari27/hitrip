<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard2 extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }
    }

    public function index()
    {
        $this->load->model('paketUmroh');
        $this->load->model('registrasi');
        $paket = $this->paketUmroh->getPackage(null, true);
        $nextTrip = [];
        $totalJamaah = 0;
        $member = [];
        if (!empty($paket)) {
            $nextTrip = $paket[0];
            $this->load->library('calculate');
            $nextTrip->countdown = $this->calculate->dateDiff($nextTrip->tanggal_berangkat, date('Y-m-d'));

            $member = $this->registrasi->getMember(null, null, $nextTrip->id_paket);
            if ($member) {
                $totalJamaah = count($member);
            }
        }

        $packagePublished = $this->paketUmroh->getPackage(null, true, 'yes');
        if ($packagePublished) {
            $packagePublished = count($packagePublished);
        } else {
            $packagePublished = 0;
        }
        $packageUnPublished = $this->paketUmroh->getPackage(null, true, 'no');
        if ($packageUnPublished) {
            $packageUnPublished = count($packageUnPublished);
        } else {
            $packageUnPublished = 0;
        }


        // if ($paket) {
        //     foreach ($paket as $key => $p) {
        //         $jamaah = $this->registrasi->getMember(null, null, $p->id_paket);
        //         if (empty($jamaah)) {
        //             $paket[$key]->totalJamaah = 0;
        //         } 
        //         else {
        //             // $paket[$key]->totalJamaah($jamaah) = jumlah_seat($jamaah)-sisa_seat($jamaah);
        //             $paket[$key]->totalJamaah = count($jamaah);
        //         }
        //         $jamaahBelumBayar = $this->registrasi->getMemberCustom(array(
        //             'id_paket' => $p->id_paket,
        //             'lunas' => "0"
        //         ));
        //         $jamaahLunas = $this->registrasi->getMemberCustom(array(
        //             'id_paket' => $p->id_paket,
        //             'lunas' => "1"
        //         ));
        //         $jamaahCicil = $this->registrasi->getMemberCustom(array(
        //             'id_paket' => $p->id_paket,
        //             'lunas' => "2"
        //         ));
        //         $jamaahLebihBayar = $this->registrasi->getMemberCustom(array(
        //             'id_paket' => $p->id_paket,
        //             'lunas' => "3"
        //         ));

        //         $paket[$key]->totalBelumBayar = count($jamaahBelumBayar);
        //         $paket[$key]->totalLunas = count($jamaahLunas);
        //         $paket[$key]->totalCicil = count($jamaahCicil);
        //         $paket[$key]->totalLebih = count($jamaahLebihBayar);
        //     }
        //     // echo '<pre>';
        //     // print_r("test");
        //     // exit();
        // }


        // $perlengkapan = $this->paketUmroh->getPackage(null, true);
        // if ($perlengkapan) {
        //     foreach ($perlengkapan as $key => $perl) {
        //         // ambil jamaah per paket
        //         $jamaah = $this->registrasi->getMember(null, null, $perl->id_paket);
        //         if (empty($jamaah)) {
        //             $perlengkapan[$key]->totalJamaah = 0;
        //         } else {
        //             // $paket[$key]->totalJamaah($jamaah) = jumlah_seat($jamaah)-sisa_seat($jamaah);
        //             $perlengkapan[$key]->totalJamaah = count($jamaah);
        //         }

        //         // ambil status perlengkapan jamaah
        //         $this->load->model('logistik');
        //         $data = $this->logistik->getStatusPengambilan($perl->id_paket);
        //         $perlengkapan[$key]->sudahSemua =  $data['sudahSemua'];
        //         $perlengkapan[$key]->sudahSebagian = $data['sudahSebagian'];
        //         $perlengkapan[$key]->belumSemua = $data['belumAmbil'];
        //     }


        // }


        $newRegistrar = null;
        $berkas = null;
        if (in_array($_SESSION['bagian'], array('Manifest', 'Master Admin', 'Finance'))) {
            $newRegistrar = $this->registrasi->getNewRegistrar(5);
            if (!empty($nextTrip)) {
                $berkas = $this->registrasi->getBerkasBelumLengkap($nextTrip->id_paket);
            }
        }
        $unverified = null;
        if (in_array($_SESSION['bagian'], array('Finance', 'Master Admin'))) {
            $this->load->model('tarif');
            $unverified = $this->tarif->getUnverified();
        }
        $statusPerlengkapan = null;
        $statusPengambilan = null;
        if (!empty($nextTrip)) {
            if (in_array($_SESSION['bagian'], array('Logistik', 'Master Admin'))) {
                $this->load->model('logistik');
                $statusPerlengkapan = $this->logistik->getStatusPerlengkapanPaket($nextTrip->id_paket);
                $statusPengambilan = $this->logistik->getStatusPengambilan($nextTrip->id_paket);
            }
        }
        $data = array(
            'paket' => $paket,
            'nextTrip' => $nextTrip,
            'totalJamaah' => $totalJamaah,
            'packagePublished' => $packagePublished,
            'packageUnpublished' => $packageUnPublished,
            'newRegistrar' => $newRegistrar ? $newRegistrar : [],
            'berkas' => $berkas,
            'unverified' => $unverified,
            'statusPerlengkapan' => $statusPerlengkapan,
            'statusPengambilan' => $statusPengambilan,
            // 'perlengkapan' =>$perlengkapan
        );
        $this->load->view('staff/dash_view2', $data);
    }

    public function load_informasi_seat() {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'paket_umroh';
        // Primary key of table
        $primaryKey = 'id_paket';
        $columns = array(
            array('db' => 'id_paket', 'dt' => 'id_paket', 'field' => 'id_paket'),
            array('db' => 'nama_paket', 'dt' => 'nama_paket', 'field' => 'nama_paket'),
            array('db' => 'tanggal_berangkat', 'dt' => 'tanggal_berangkat', 'field' => 'tanggal_berangkat'),
            array('db' => 'publish', 'dt' => 'publish', 'field' => 'publish'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $extraCondition = "`tanggal_berangkat` >= '" . date('Y-m-d') ."'";
        
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, NULL, $extraCondition);
        $this->load->model('paketUmroh');
        $this->load->model('registrasi');
        // $this->load->model('tarif');
        foreach ($data['data'] as $key => $d) {
            //sisa_seat status
            $paket = $this->paketUmroh->getPackage($d['id_paket'], false);
            $data['data'][$key]['sisa_seat'] = $paket->sisa_seat;
            $jamaahBelumBayar = $this->registrasi->getMemberCustom(array(
                'id_paket' => $d['id_paket'],
                'lunas' => "0"
            ));
            $jamaahLunas = $this->registrasi->getMemberCustom(array(
                'id_paket' => $d['id_paket'],
                'lunas' => "1"
            ));
            $jamaahCicil = $this->registrasi->getMemberCustom(array(
                'id_paket' => $d['id_paket'],
                'lunas' => "2"
            ));
            $jamaahLebihBayar = $this->registrasi->getMemberCustom(array(
                'id_paket' => $d['id_paket'],
                'lunas' => "3"
            ));
            $data['data'][$key]['total_belum_bayar'] = count($jamaahBelumBayar);
            $data['data'][$key]['total_lunas'] = count($jamaahLunas);
            $data['data'][$key]['total_cicil'] = count($jamaahCicil);
            $data['data'][$key]['total_lebih'] = count($jamaahLebihBayar);
        }
        // echo '<pre>';
        // print_r($data['data']);
        // exit();
        echo json_encode($data);
    }

    public function load_detail_perlengkapan() {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'paket_umroh';
        // Primary key of table
        $primaryKey = 'id_paket';
        $columns = array(
            array('db' => 'id_paket', 'dt' => 'id_paket', 'field' => 'id_paket'),
            array('db' => 'nama_paket', 'dt' => 'nama_paket', 'field' => 'nama_paket'),
            array('db' => 'tanggal_berangkat', 'dt' => 'tanggal_berangkat', 'field' => 'tanggal_berangkat'),
            array('db' => 'jumlah_seat', 'dt' => 'jumlah_seat', 'field' => 'jumlah_seat'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $extraCondition = "`tanggal_berangkat` >= '" . date('Y-m-d') ."'";
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, NULL, $extraCondition);
        $this->load->model('paketUmroh');
        $this->load->model('registrasi');
        // $this->load->model('tarif');
        foreach ($data['data'] as $key => $d) {
            //sisa_seat status
            $paket = $this->paketUmroh->getPackage($d['id_paket'], false);
            $data['data'][$key]['sisa_seat'] = $paket->sisa_seat;
            $jamaah = $this->registrasi->getMember(null, null, $d['id_paket']);
            if (empty($jamaah)) {
                $data['data'][$key]['total_jamaah'] = 0;
            } 
            else {
                // $data['data'][$key]['total_jamaah']($jamaah) = jumlah_seat($jamaah)-sisa_seat($jamaah);
                $data['data'][$key]['total_jamaah'] = count($jamaah);
            }
            $this->load->model('logistik');
            $perlengkapan = $this->logistik->getStatusPengambilan($d['id_paket']);
            
            $data['data'][$key]['sudah_semua'] = $perlengkapan['sudahSemua'];
            $data['data'][$key]['sudah_sebagian'] = $perlengkapan['sudahSebagian'];
            $data['data'][$key]['belum_ambil'] = $perlengkapan['belumAmbil'];
        }
        
        
        echo json_encode($data);
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