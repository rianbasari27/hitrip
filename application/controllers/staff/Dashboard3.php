<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard3 extends CI_Controller
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
        $this->load->model('logistik');
        // $s = $this->logistik->getStatusPerlengkapanMember();
        // echo '<pre>';
        // print_r($s);
        // exit();
        // $this->load->model('dashboard');
        // $d = $this->dashboard->getDetailPerlengkapan();
        // $p = $this->dashboard->getInfoSeat();
        // echo '<pre>';
        // print_r($d);
        // exit();
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

        $this->load->model('dashboard');
        $info_seat = $this->dashboard->getInfoSeat();
        $detail_perl = $this->dashboard->getDetailPerlengkapan();
        // echo '<pre>';
        // print_r($detail_perl);
        // exit();
        

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


        $perlengkapan = $this->paketUmroh->getPackage(null, true);
        // if ($perlengkapan) {
            // foreach ($perlengkapan as $key => $perl) {
            //     $jamaah = $this->registrasi->getMember(null, null, $perl->id_paket);
            //     if (empty($jamaah)) {
            //         $perlengkapan[$key]->totalJamaah = 0;
            //     } else {
            //         $perlengkapan[$key]->totalJamaah = count($jamaah);
            //     }
            //     $this->load->model('logistik');
            //     $data = $this->logistik->getStatusPengambilan($perl->id_paket);
            //     $perlengkapan[$key]->sudahSemua =  $data['sudahSemua'];
            //     $perlengkapan[$key]->sudahSebagian = $data['sudahSebagian'];
            //     $perlengkapan[$key]->belumSemua = $data['belumAmbil'];
            // }
            
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
            'info_seat' => $info_seat,
            'detail_perl' => $detail_perl,
            'perlengkapan' =>$perlengkapan
        );
        $this->load->view('staff/dash_view3', $data);
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