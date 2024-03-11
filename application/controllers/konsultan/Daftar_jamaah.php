<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Daftar_jamaah extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('konsultanAuth');
        if (!$this->konsultanAuth->is_user_logged_in()) {
            redirect(base_url() . 'konsultan/login');
        }
    }

    public function getSeasonPackage() {
        if ($_GET['month'] == "00") {
            $_GET['month'] = null;
        }

        if ($_GET['musim'] == "0000") {
            $_GET['musim'] = null;
        }

        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage(null, true, true, true, $_GET['month'], true, null, $_GET['musim']);

        $seasonArr = [];
        if ($_GET['musim'] != null) {
            foreach ($paket as $pkt) {
                $this->load->library('date');
                $dateHijri = $this->date->gregorianToHijri($pkt->tanggal_berangkat);
                $dateHijri = explode('-', $dateHijri);

                $yearHijri = $dateHijri[0];
                if (!isset($seasonArr[$yearHijri])) {
                    $seasonArr[$yearHijri] = [];
                }

                $seasonArr[$yearHijri][] = $pkt;
            }
            echo json_encode($seasonArr[$_GET['musim']]);
        } else {
            echo json_encode($paket);
        }

    }

    public function getMonthSeasonPackage() {
        if ($_GET['month'] == "00") {
            $_GET['month'] = null;
        }

        if ($_GET['musim'] == "0000") {
            $_GET['musim'] = null;
        }

        $this->load->model('paketUmroh');
        $availableMonths = $this->paketUmroh->getAvailableMonths(null, true, false, $_GET['musim']);
        echo json_encode($availableMonths);
    }

    public function getMonthPackage() {
        if ($_GET['month'] == "00") {
            $_GET['month'] = null;
        }

        if ($_GET['musim'] == "0000") {
            $_GET['musim'] = null;
        }

        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage(null, true, true, true, $_GET['month'], true, null, $_GET['musim']);

        echo json_encode($paket);
    }

    public function index()
    {
        $this->load->model('agen');
        $agen = $this->agen->getAgen($_SESSION['id_agen']);
        if ($agen[0]->active != 1) {
            redirect(base_url() . 'konsultan/home/pemb_notice');
        }
        $this->load->model('paketUmroh');
        if (isset($_GET['month'])) {
            $month = $_GET['month'];
        } else {
            $month = null;
        }

        $musim = null;
        $getMusim = 'all';
        if (isset($_GET['musim'])) {
            if ($_GET['musim'] != 'all') {
                $musim = $_GET['musim'];
                $getMusim = NULL;
            } else {
                $getMusim = 'all';
            }
        }
        
        $paket = $this->paketUmroh->getPackage(null, true, true, true, $month, true);
        $packageAllSeason = $this->paketUmroh->getPackage(null, true, true, true, null, true);

        // mengambil banyaknya musim
        $seasonArr = [];
        foreach ($packageAllSeason as $pkt) {
            $this->load->library('date');
            $dateHijri = $this->date->gregorianToHijri($pkt->tanggal_berangkat);
            $dateHijri = explode('-', $dateHijri);

            $yearHijri = $dateHijri[0];
            if (!isset($seasonArr[$yearHijri])) {
                $seasonArr[$yearHijri] = [$yearHijri];
            }
        }
        
        $availableMonths = $this->paketUmroh->getAvailableMonths(true, true, true, $musim);
        if (empty($paket)) {
            $paket = [];
        }
        foreach ($paket as $key => $p) {
            $this->load->library('secret_key');
            $idAgen = $this->secret_key->generate($_SESSION['id_agen']);
            $paket[$key]->detailLink = base_url() . "konsultan/detail_paket?id=" . $p->id_paket . "&idg=" . $idAgen;
        }
        $data = [
            'paket' => $paket,
            'musim' => $musim,
            'getMusim' => $getMusim,
            'seasonArr' => $seasonArr,
            'availableMonths' => $availableMonths,
            'monthSelected' => $month
        ];

        $this->load->view('konsultan/list_daftar_paket', $data);
    }

    public function daftar()
    {
        if (!isset($_GET['id'])) {
            $this->alert->setJamaah('red', 'Ups...', 'Paket tidak ditemukan');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->load->view('konsultan/terms', ['id' => $_GET['id']]);
    }

    public function start()
    {
        $parent_id = null;
        $id = null;
        $ktp_no = null;
        $jamaah = null;
        $parentMembers = null;
        // $agenMembers = null;
        $this->load->model('registrasi');
        if (isset($_GET['parent'])) {
            $parent = $this->registrasi->getMember($_GET['parent']);
            if (empty($parent)) {
                $this->alert->setJamaah('red', 'Ups...', 'Akun Induk Tidak Ditemukan');
                redirect(base_url() . 'konsultan/home');
            }
            $jamaah = $this->registrasi->getJamaah(null, null, $_GET['parent']);
            $parentMem = $this->registrasi->getGroupMembers($_GET['parent']);
            if ($parentMem != null) {
                $parentMembers = array_values($parentMem);
            }
            $parent = $parent[0];
            $parent_id = $parent->id_member;
            $id = $parent->id_paket;
            $ktp_no = $jamaah->ktp_no;
        }
        // else if (isset($_GET['agen_parent'])) {
        //     $agen_parent = $this->registrasi->getMember($_GET['agen_parent']);
        //     if (empty($agen_parent)) {
        //         $this->alert->setJamaah('red', 'Ups...', 'Akun Induk Tidak Ditemukan');
        //         redirect(base_url() . 'konsultan/home');
        //     }
        //     $jamaah = $this->registrasi->getJamaah(null, null, $_GET['agen_parent']);
        //     $agenMembers = $this->registrasi->getAgenGroupMembers($_GET['agen_parent']);
        //     // echo '<pre>';
        //     // print_r($agenMembers);
        //     // exit();
        //     $ap = $agen_parent[0];
        //     $agen_parent = $ap->id_member;
        //     $id = $ap->id_paket;
        //     $ktp_no = $jamaah->ktp_no;
        // }
        else if (!isset($_GET['id'])) {
            $this->alert->setJamaah('red', 'Ups...', 'Paket tidak ditemukan');
            redirect(base_url() . 'konsultan/home');
        }
        // Start agen parent
        // if (isset($_GET['agen_parent'])) {
        //     $agen_parent = $this->registrasi->getMember($_GET['agen_parent']);
        //     if (empty($agen_parent)) {
        //         $this->alert->setJamaah('red', 'Ups...', 'Akun Induk Tidak Ditemukan');
        //         redirect(base_url() . 'konsultan/home');
        //     }
        //     $agen_parent = $agen_parent[0];
        //     $agen_parent = $agen_parent->id_member;
        // }
        if ($id == null) {
            $id = $_GET['id'];
        }

        $this->load->model('PaketUmroh');
        $paket = $this->PaketUmroh->getPackage($id, true, true);
        if (empty($paket)) {
            $this->alert->setJamaah('red', 'Ups...', 'Paket tidak ditemukan');
            redirect(base_url() . 'konsultan/home');
        }
        $this->load->model('registrasi');
        $paket->availableKamar = $this->registrasi->getAvailableKamar($id);
        $this->load->model('agen');
        $agen = $this->agen->getAgen($_SESSION['id_agen'], false, false, false, true);
        $data = array(
            'paket' => $paket,
            'agen' => $agen[0],
            'parent_id' => $parent_id,
            'ktp_no' => $ktp_no,
            // 'agenMembers' => $agenMembers,
            'parentMembers' => $parentMembers,
            'jamaah' => $jamaah,
        );
        $this->load->view('konsultan/registrasi', $data);
    }

    public function daftar_program()
    {
        if (!isset($_GET['id'])) {
            $this->alert->setJamaah('red', 'Ups...', 'Paket tidak ditemukan');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->load->view('konsultan/terms_program', ['id' => $_GET['id']]);
    }

    public function start_program()
    {
        $this->load->model('agen');
        $agen = $this->agen->getAgen($_SESSION['id_agen']);

        $this->load->model('registrasi');
        $jamaah = $this->registrasi->getJamaah(null, $agen[0]->no_agen);
        if (!empty($jamaah) && !empty($jamaah->member)) {
            $this->load->model('tarif');
            $pembayaran = $this->tarif->getPembayaran($jamaah->member[0]->id_member);
            if ($pembayaran['totalBayar'] == 0) {
                $this->load->library('secret_key');
                $id_secret = $this->secret_key->generate($jamaah->member[0]->id_member);
                redirect(base_url() . 'konsultan/jamaah_info/bsi_dp?id=' . $id_secret);
            }
        }

        $id_program = $_GET['id'];
        if ($id_program == null) {
            redirect(base_url() . 'konsultan/home');
        }
        $this->load->model('paketUmroh');
        $program = $this->paketUmroh->getPackage($id_program, true, false, false, null, true);
        if (empty($program)) {
            $this->alert->setJamaah('red', 'Ups...', 'Program tidak ditemukan');
            redirect(base_url() . 'konsultan/home');
        }
        $this->load->model('agen');
        $agen = $this->agen->getAgen($_SESSION['id_agen']);
        $data = [
            'program' => $program,
            'agen' => $agen[0],
        ];
        $this->load->view('konsultan/registrasi_program_view', $data);
    }

    // public function start_new() {

    // }

    public function getTempatLahir()
    {
        $term = $this->input->get('term');
        $this->load->model('region');
        $kota = $this->region->getRegionAutoComplete($term);
        echo json_encode($kota);
    }

    public function proses()
    {
        unset($_POST['agen']);
        $_POST['referensi'] = 'Agen';
        $_POST['id_agen'] = $_SESSION['id_agen'];

        //cek paket
        if (empty($_POST['id_paket'])) {
            $this->alert->setJamaah('red', 'Ups...', 'Paket tidak ditemukan');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $id = $_POST['id_paket'];
        if (isset($_POST['no_wa'])) {
            if ($_POST['no_wa'] == '+62') {
                unset($_POST['no_wa']);
            }
        }

        // cek umur untuk sharing bed
        $this->load->library('calculate');
        $age = $this->calculate->age($_POST['tanggal_lahir']);
        if ($_POST['sharing_bed']) {
            if ($age > 6 || $age < 2) {
                $this->alert->setJamaah('red', 'Ups...', 'Umur tidak sesuai untuk sharing bed');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }

        $id = $_POST['id_paket'];
        $this->load->model('PaketUmroh');
        $paket = $this->PaketUmroh->getPackage($id, true, true);
        if (empty($paket)) {
            $this->alert->setJamaah('red', 'Ups...', 'Paket tidak ditemukan');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->form_validation->set_rules('first_name', 'Nama Depan', 'trim|required|alpha_numeric_spaces', array(
            'alpha_numeric_spaces' => 'Nama depan tidak boleh mengandung simbol atau karakter khusus'
        ));
        $this->form_validation->set_rules('ktp_no', 'Nomor KTP', 'required');
        // if (!isset($_POST['parent_id'])) {
        // $this->form_validation->set_rules('no_wa', 'Nomor WA', 'required|numeric');
        // $this->form_validation->set_rules('referensi', 'Referensi', 'trim|required');
        // $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'trim|required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'trim|required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'trim|required');
        // }
        // $this->form_validation->set_rules('nama_ahli_waris', 'Nama Ahli Waris', 'trim|required|alpha_numeric_spaces', array(
        //     'alpha_numeric_spaces' => 'Nama ahli waris tidak boleh mengandung simbol atau karakter khusus'
        // ));
        // $this->form_validation->set_rules('no_ahli_waris', 'Nomor Ahli Waris', 'trim|required');
        // $this->form_validation->set_rules('alamat_ahli_waris', 'Alamat Ahli Waris', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata(['form' => $_POST]);
            $this->alert->setJamaah('red', 'Ups...', validation_errors('<li>', '</li>'));
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->model('registrasi');

        //check if ktp_no already in an active package
        $isMember = $this->registrasi->getJamaah(null, $_POST['ktp_no'], null);
        if (isset($isMember->member[0])) {
            $member = $isMember->member[0];
            //check date
            $curDate = date('Y-m-d');
            $tglBerangkat = $member->paket_info->tanggal_berangkat;
            if ($tglBerangkat > $curDate) {
                // $this->alert->setJamaah('red', 'Upsie...', $_SESSION['alert_message']);
                $this->load->view('konsultan/already_member');
                return false;
                // redirect($_SERVER['HTTP_REFERER']);
            }
        }

        $parent_id = null;
        if (isset($_POST['parent_id'])) {
            $parent_id = $_POST['parent_id'];
            unset($_POST['parent_id']);
        }

        $sharing_bed = $_POST['sharing_bed'];
        unset($_POST['sharing_bed']);

        $id_member = $this->registrasi->daftar($_POST, true);

        // set sharing_bed
        $this->db->where('id_member', $id_member);
        $this->db->set('sharing_bed', $sharing_bed);
        $this->db->update('program_member');

        $this->load->model('va_model');
        $this->va_model->createVAOpen($id_member);
        if (!$id_member) {
            $this->alert->setJamaah('red', 'Ups...', $_SESSION['alert_message']);
            redirect($_SERVER['HTTP_REFERER']);
        }
        if ($id_member == true && $parent_id != null) {
            $this->registrasi->setParent($id_member, $parent_id);
        }

        $this->load->model('customer');
        if ($parent_id == null) {
            $sessKtp = $_POST['ktp_no'];
        } else {
            $sessKtp = $_SESSION['ktp_no'];
        }
        // $this->customer->setSession($sessKtp);

        // if ($parent_id != null) {
        //     redirect(base_url() . 'konsultan/daftar_jamaah/start?parent='. $parent_id);
        // } else {
        redirect(base_url() . 'konsultan/daftar_jamaah/next?ktp=' . $_POST['ktp_no']);
        // }
    }

    public function proses_program()
    {
        // echo '<pre>';
        // print_r($_POST);
        // exit();
        //cek paket
        if (empty($_POST['id_paket'])) {
            $this->alert->setJamaah('red', 'Ups...', 'Paket tidak ditemukan');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $id = $_POST['id_paket'];

        $this->load->model('PaketUmroh');
        $paket = $this->PaketUmroh->getPackage($id, true, false, false, null, true);
        if (empty($paket)) {
            $this->alert->setJamaah('red', 'Ups...', 'Paket tidak ditemukan');
            redirect($_SERVER['HTTP_REFERER']);
        }
        // $this->form_validation->set_rules('first_name', 'Nama Lengkap', 'trim|required|alpha_numeric_spaces', array(
        //     'alpha_numeric_spaces' => 'Nama depan tidak boleh mengandung simbol atau karakter khusus'
        // ));
        $this->form_validation->set_rules('first_name', 'Nama Lengkap', 'trim|required');
        // if (!isset($_POST['parent_id'])) {
        // $this->form_validation->set_rules('no_wa', 'Nomor WA', 'required|numeric');
        // $this->form_validation->set_rules('referensi', 'Referensi', 'trim|required');
        // $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'trim|required');
        // $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'trim|required');
        // $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'trim|required');
        // }
        // $this->form_validation->set_rules('nama_ahli_waris', 'Nama Ahli Waris', 'trim|required|alpha_numeric_spaces', array(
        //     'alpha_numeric_spaces' => 'Nama ahli waris tidak boleh mengandung simbol atau karakter khusus'
        // ));
        // $this->form_validation->set_rules('no_ahli_waris', 'Nomor Ahli Waris', 'trim|required');
        // $this->form_validation->set_rules('alamat_ahli_waris', 'Alamat Ahli Waris', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata(['form' => $_POST]);
            $this->alert->setJamaah('red', 'Ups...', validation_errors('<li>', '</li>'));
            redirect($_SERVER['HTTP_REFERER']);
        }

        $data_agen = [
            "jenis_kelamin" => $_POST['jenis_kelamin'],
            "ukuran_baju" => $_POST['ukuran_baju'],
        ];
        $this->load->model('agen');
        $agen = $this->agen->editAgen($_SESSION['id_agen'], $data_agen);
        // echo '<pre>';
        // print_r($agen);
        // exit();

        $this->load->model('registrasi');

        unset($_POST['ukuran_baju']);
        $id_member = $this->registrasi->daftar($_POST, true);
        $this->load->model('va_model');
        $this->va_model->createVAOpen($id_member);
        if (!$id_member) {
            $this->alert->setJamaah('red', 'Ups...', $_SESSION['alert_message']);
            redirect($_SERVER['HTTP_REFERER']);
        }
        // if ($id_member == true && $parent_id != null) {
        //     $this->registrasi->setParent($id_member, $parent_id);
        // }

        // $this->load->model('customer');
        // if ($parent_id == null) {
        //     $sessKtp = $_POST['ktp_no'];
        // } else {
        //     $sessKtp = $_SESSION['ktp_no'];
        // }
        // $this->customer->setSession($sessKtp);

        // if ($parent_id != null) {
        //     redirect(base_url() . 'konsultan/daftar_jamaah/start?parent='. $parent_id);
        // } else {
        $this->load->library('secret_key');
        $id_secret = $this->secret_key->generate($id_member);
        redirect(base_url() . 'konsultan/jamaah_info/bsi_dp?id=' . $id_secret);
        // }
    }

    public function next()
    {
        $this->load->model('registrasi');
        $jamaah = $this->registrasi->getJamaah(null, $_GET['ktp']);
        $data = $jamaah->member[0];
        $family = $this->registrasi->getGroupMembers($data->parent_id);
        $data->family = $family;

        $this->load->view('konsultan/register_step2', $data);
    }

    public function registrasi_next()
    {
        $this->load->model('registrasi');
        $this->load->model('Whatsapp');
        $member = $this->registrasi->getMember($_GET['id']);
        if ($member[0]->parent_id != null) {
            if ($member[0]->id_agen != null || $member[0]->id_agen != '' || $member[0]->id_agen != 0) {
                $noHp = $member[0]->agen->no_wa;
                if ($noHp != null || $noHp != '') {
                    $this->Whatsapp->otomatisSendDP($member[0]->parent_id, 'belum_dp_new', $noHp);
                } else {
                    $this->Whatsapp->otomatisSendDP($member[0]->parent_id, 'belum_dp_new');
                }
            } else {
                $this->Whatsapp->otomatisSendDP($member[0]->parent_id, 'belum_dp_new');
            }
        } else {
            if ($member[0]->id_agen != null || $member[0]->id_agen != '' || $member[0]->id_agen != 0) {
                $noHp = $member[0]->agen->no_wa;
                if ($noHp != null || $noHp != '') {
                    $this->Whatsapp->otomatisSendDP($member[0]->id_member, 'belum_dp_new', $noHp);
                } else {
                    $this->Whatsapp->otomatisSendDP($member[0]->id_member, 'belum_dp_new');
                }
            } else {
                $this->Whatsapp->otomatisSendDP($member[0]->id_member, 'belum_dp_new');
            }
        }
        // $this->alert->setJamaah('green', 'Selamat', 'Anda berhasil mendaftarkan jamaah');
        // redirect(base_url() . 'konsultan/jamaah_info/dp_notice?id='.$member[0]->idSecretMember);
        redirect(base_url() . 'konsultan/daftar_jamaah/success?id=' . $member[0]->idSecretMember);
    }

    public function success()
    {
        if (isset($_SESSION['id_agen'])) {
            $this->alert->setJamaah('green', 'Selamat', 'Anda berhasil mendaftarkan jamaah');
            redirect(base_url() . 'konsultan/jamaah_info/dp_notice?id=' . $_GET['id']);
        }
    }

    public function cek_wa($str)
    {
        $match = preg_match("/(\+62|0|62)8[0-9]{7,12}?$/", $str);
        if ($match == 1) {
            return true;
        } else {
            $this->form_validation->set_message('cek_wa', '{field} harus diawali dengan 0 atau +62');
            return false;
        }
    }
}