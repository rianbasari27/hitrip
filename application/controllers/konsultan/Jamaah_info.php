<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Jamaah_info extends CI_Controller
{    
    public function __construct()
    {
        parent::__construct();
        $this->load->model("auth");
        $this->load->library("secret_key");
        $this->load->model('konsultanAuth');
        if (!$this->konsultanAuth->is_user_logged_in()) {
            redirect(base_url() . 'konsultan/login');
        }
    }
    
    public function index() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'ID', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url().'konsultan/home');
        }
        $id_member = $this->secret_key->validate($_GET['id']);
        if (!$id_member) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url().'konsultan/home');
        }
        $check = $this->auth->checkMemberAgen($_SESSION['id_agen'], $id_member);
        if ($check == false) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url().'konsultan/home');
        }
        $this->load->model("registrasi");
        $this->load->model('logistik');
        $this->load->model('paketUmroh');
        $this->load->library('wa_number');
        $member = $this->registrasi->getMember($id_member);
        $jamaah = $this->registrasi->getJamaah($member[0]->id_jamaah);
        $perlengkapan = $this->logistik->getStatusPerlengkapanMember($id_member);
        $paket_umroh = $this->paketUmroh->getPackage($member[0]->id_paket, false, false);
        $parentMembers = null;
        if ($member[0]->parent_id != null) {
            $parentMembers = $this->registrasi->getGroupMembers($member[0]->parent_id);
            // $parentMembers = array_values($parentMem);
            foreach ($parentMembers as $key => $pm) {
                if ($pm->jamaahData->tempat_lahir != null && 
                    $pm->jamaahData->tanggal_lahir != null &&
                    $pm->jamaahData->jenis_kelamin != null &&
                    $pm->jamaahData->no_wa != null) {
                    unset($parentMembers[$key]);
                }
            }
        }

        $id_secret = $this->secret_key->generate($member[0]->id_member);

        $formattedNumber = $this->wa_number->convert($jamaah->no_wa);
        $this->load->model('tarif');
        $tarif = $this->tarif->calcTariff($member[0]->id_member);
        
        $groupMembers = null;
        $statusBisaAmbil = true;
        if ($jamaah->member[0]->parent_id != null) {
            $groupMembers = $this->registrasi->getGroupMembers($jamaah->member[0]->parent_id);
            $statusBisaAmbil = true;
            foreach ($groupMembers as $key => $gm) {
                $tempat_lahir = $groupMembers[$key]->jamaahData->tempat_lahir;
                $tanggal_lahir = $groupMembers[$key]->jamaahData->tanggal_lahir;
                $jenis_kelamin = $groupMembers[$key]->jamaahData->jenis_kelamin;
                $no_wa = $groupMembers[$key]->jamaahData->no_wa;
                if ($tempat_lahir == null || $tanggal_lahir == null || $jenis_kelamin == null || $no_wa == null) {
                    $statusBisaAmbil = false;
                }
            }
        }

        $data = [
            "id_secret" => $id_secret,
            "member" => $member[0],
            "jamaah" => $jamaah,
            "perlengkapan" => $perlengkapan,
            "paket_umroh" => $paket_umroh,
            "statusBisaAmbil" => $statusBisaAmbil,
            "formattedNumber" => $formattedNumber,
            "parentMembers" => $parentMembers,
            'noVA' => $tarif['nomorVAOpen']
        ];


        return $this->load->view('konsultan/jamaah_info_view', $data);
    }

    public function dp_notice_old()
    {
        $this->load->model('tarif');
        $tarif = $this->tarif->getRiwayatBayar($_GET['id']);
        $this->load->model('registrasi');
        $member = $this->registrasi->getMember($_GET['id']);

        //jika sudah bayar redirect ke home
        if ($tarif['totalBayar'] > 0) {
            redirect(base_url() . 'konsultan/jamaah_info?id='. $_GET['id']);
        }
        $data = $tarif['tarif'];
        $data['countDown'] = date("M d, Y H:i:s", strtotime($member[0]->dp_expiry_time));
        $this->load->view('konsultan/bayar_dp', $data);
    }

    public function dp_notice()
    {
        $this->load->model('tarif');
        $id_member = $this->secret_key->validate($_GET['id']);
        if (!$id_member) {
            $this->alert->setJamaah('red','Oops...','Access Denied!');
            redirect(base_url() . 'konsultan/home');
        }
        $tarif = $this->tarif->getRiwayatBayar($id_member);
        $this->load->model('registrasi');
        $member = $this->registrasi->getMember($id_member);
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage($member[0]->id_paket, false, false);
        //jika sudah bayar redirect ke home
        if ($tarif['totalBayar'] > 0) {
            redirect(base_url() . 'konsultan/jamaah_info?id='. $_GET['id']);
        }
        $data = $tarif['tarif'];
        $data['tgl_regist'] = $member[0]->tgl_regist;
        $data['countDown'] = date("M d, Y H:i:s", strtotime($member[0]->dp_expiry_time));
        $data['currentPaket'] = $paket;
        $data['idMember'] = $id_member;
        // echo '<pre>';
        // print_r($data);
        // exit();
        $this->load->view('konsultan/metode_bayar_dp', $data);
    }

    public function getTempatLahir()
    {
        $term = $this->input->get('term');
        $this->load->model('region');
        $kota = $this->region->getRegionAutoComplete($term);
        echo json_encode($kota);
    }

    public function incomplete_data() {
        $id_member = $this->secret_key->validate($_GET['id']);
        $this->load->model('registrasi');
        $data = $this->registrasi->getJamaah(null, null, $id_member);
        if ($data->tanggal_lahir != null &&
            $data->tempat_lahir != null &&
            $data->no_wa != null && 
            $data->jenis_kelamin != null) {
            redirect(base_url() . 'konsultan/jamaah_info?id='.$_GET['id']);
        }
        $this->load->view('konsultan/lengkapi_data_view', $data);
    }

    public function proses_lengkapi_data() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id_member', 'ID', 'trim|required');
        $this->form_validation->set_rules('no_wa', 'Nomor WA', 'required|numeric');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'trim|required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'trim|required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata(['form' => $_POST]);
            $this->alert->setJamaah('red', 'Ups...', validation_errors('<li>', '</li>'));
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->load->model('registrasi');
        $jamaah = $this->registrasi->getJamaah(null, null, $_POST['id_member']);
        $_POST['id_paket'] = $jamaah->member[0]->id_paket;
        $_POST['id_agen'] = $_SESSION['id_agen'];
        // $_POST['id_jamaah'] = $jamaah->id_jamaah;
        $_POST['ktp_no'] = $jamaah->ktp_no;
        $_POST['verified'] = 0;
        unset($_POST['id_member']);
        $input = $this->registrasi->daftar($_POST, null, true);
        // echo '<pre>';
        // print_r($input);
        // exit();
        $this->alert->setJamaah('green', 'Berhasil', 'Data berhasil diupdate');
        redirect(base_url() . 'konsultan/jamaah_info?id='.$jamaah->member[0]->idSecretMember);
        
    }

    public function bsi_dp()
    {
        $this->load->model('tarif');
        $id_member = $this->secret_key->validate($_GET['id']);
        if (!$id_member) {
            $this->alert->setJamaah('red','Oops...','Access Denied!');
            redirect(base_url() . 'konsultan/home');
        }
        $tarif = $this->tarif->getRiwayatBayar($id_member);
        $this->load->model('registrasi');
        $member = $this->registrasi->getMember($id_member);
        //jika sudah bayar redirect ke home
        if ($tarif['totalBayar'] > 0) {
            redirect(base_url() . 'konsultan/jamaah_info?id='. $_GET['id']);
        }
        $data = $tarif['tarif'];
        // echo '<pre>';
        // print_r($data);
        // exit();
        $data['countDown'] = date("M d, Y H:i:s", strtotime($member[0]->dp_expiry_time));
        $this->load->view('konsultan/bsi_dp_view', $data);
    }
    public function duitku_dp()
    {
        $this->load->model('tarif');
        $tarif = $this->tarif->getRiwayatBayar($_GET['id']);
        $this->load->model('registrasi');
        $member = $this->registrasi->getMember($_GET['id']);
        //jika sudah bayar redirect ke home
        if ($tarif['totalBayar'] > 0) {
            redirect(base_url() . 'konsultan/jamaah_info?id='. $_GET['id']);
        }
        $data = $tarif['tarif'];
        $data['countDown'] = date("M d, Y H:i:s", strtotime($member[0]->dp_expiry_time));
        $this->load->model('duitku');
        //get pending transaction
        $invoice = $this->duitku->getPendingTransaction($_GET['id']);
        if (empty($invoice)) {
            // if no pending transaction, create new payment invoice
            $dStart = strtotime(date('Y-m-d H:i:s'));
            $dEnd = strtotime($member[0]->dp_expiry_time);
            $dDiff = round(abs($dStart - $dEnd) / 60);
            $expired = null;
            if ($dDiff > 0) {
                $expired = $dDiff;
            }
            $invoice = $this->duitku->createInvoice($_GET['id'], $data['dp_display'], $expired, 'bayar', $_GET['metode']);
        } else {
            $invoice = $invoice[0];
        }
        redirect($invoice['paymentUrl']);
    }

    public function pindah_paket(){
        // filter paket by month
        $this->load->model('paketUmroh');
        if (isset($_GET['month'])) {
            $month = $_GET['month'];
        } else {
            $month = null;
        }
        
        $this->load->model('registrasi');
        $member = $this->registrasi->getMember($_GET['id']);
        $paket = $this->paketUmroh->getPackage(null, true, true, true, $month, true);
        // echo '<pre>';
        // print_r($paket);
        // exit();
        foreach ($paket as $key => $p) {
            // echo '<pre>';
            // print_r($member[0]->id_paket);
            // exit();
            if ($p->id_paket == $member[0]->id_paket) {
                // echo '<pre>';
                // print_r($member[0]->id_paket);
                // exit();
                unset($paket[$key]);
                // continue;
            } else {
                $paket[$key]->detail_link = base_url().'konsultan/jamaah_info/proses_pindah_paket?idb='.$p->id_paket.'&idm='.$member[0]->id_member.'&idl='.$member[0]->id_paket;
            }
        }
        $currentPaket = $this->paketUmroh->getPackage($member[0]->id_paket, false, false);
        $availableMonths = $this->paketUmroh->getAvailableMonths(true, true, true);
        // foreach ($paket as $key => $p) {
        //     $paket[$key]->detailLink = base_url() . "konsultan/detail_paket?id=" . $p->id_paket;
        // }


        if (!$_GET['id']) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $jamaah = $this->registrasi->getJamaah($member[0]->id_jamaah, null, $_GET['id']);
        if (!$jamaah) {
            $this->alert->set('danger', 'Jamaah Tidak Ditemukan');
            redirect($_SERVER['HTTP_REFERER']);
        }
        // echo '<pre>';
        // print_r($paket);
        // exit();
        $jamaah->paketTersedia = $paket;
        $data = [
            'paket' => $paket,
            'availableMonths' => $availableMonths,
            'monthSelected' => $month,
            'currentPaket' => $currentPaket
        ];
        $this->load->view('konsultan/pindah_paket_view', $data);
    }

    public function proses_pindah_paket(){
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('idm', 'idm', 'required');
        $this->form_validation->set_rules('idb', 'idb', 'required');
        $this->form_validation->set_rules('idl', 'idl', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Proses Pindah Paket Gagal!');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->model('registrasi');
        $member = $this->registrasi->getMember($_GET['idm']);
        $parent = $this->registrasi->getGroupMembers($member[0]->parent_id);
        $get_parent = [];
        if ($member[0]->parent_id != null) {
            foreach ($parent as $key => $p) {
                // echo '<pre>';
                // print_r($p->memberData);
                // exit();
                // ;
                $get_parent[] = $parent[$key]->memberData;
            } 
        } else {
            $get_parent = $this->registrasi->getMember($member[0]->id_member);
        }
        
        // echo '<pre>';
        // print_r($get_parent);
        // exit();




        
        // $parent =  ;
        // if ($member[0]->parent_id != null) {
        //     $parent = $this->registrasi->getGroupMembers($member[0]->parent_id);
        // } else {
        //     $member = $this->registrasi->getMember($member[0]->id_member);
        //     $parent->memberData = $member[0];
        // }
        // echo '<pre>';
        // print_r($parent);
        // exit();
        foreach ($get_parent as $key => $item) {
            $this->db->where('id_member', $item->id_member);
            $this->db->set('id_paket', $_GET['idb']);
            $this->db->update('program_member');
        }

        // $this->load->model('registrasi');
        // $pindah = $this->registrasi->pindahPaket($_POST['idMember'], $_POST['idPaketLama'], $_POST['idPaketBaru']);
        // if (!$pindah['status']) {
        //     $this->alert->set('danger', $pindah['msg']);
        //     redirect($_SERVER['HTTP_REFERER']);
        // }
        // $this->alert->set('success', $pindah['msg']);
        // $this->load->model('registrasi');
        // $jamaah = $this->registrasi->getMember($_POST['idMember']);
        redirect(base_url() . "konsultan/jamaah_info/dp_notice?id=" . $_GET['idm']);
    }

    public function batal_bayar() {
        $this->load->model('registrasi');
        $member = $this->registrasi->getMember($_GET['id']);
        if ($member[0]->parent_id != null) {
            $this->registrasi->deleteProgramMember(null, $member[0]->parent_id);
        } else {
            $this->registrasi->deleteProgramMember($_GET['id']);
        }
        // echo '<pre>';
        // print_r($member);
        // exit();
        $this->alert->setJamaah('green', 'Sukses', 'Pembayaran berhasil dibatalkan');
        redirect(base_url() . 'konsultan/home');
    }
    
}

?>