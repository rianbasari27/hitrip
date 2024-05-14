<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Daftar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('customer');
        if (!$this->customer->is_user_logged_in()) {
            $this->alert->toastAlert('red', 'Anda perlu login!');
            redirect(base_url() . 'jamaah/home');
        }
    }

    public function index()
    {
        if (!isset($_GET['id'])) {
            $this->alert->setJamaah('red', 'Ups...', 'Paket tidak ditemukan');
            redirect($_SERVER['HTTP_REFERER']);
        }
        if (isset($_GET['idg'])) {
            $id_agen = $_GET['idg'];
        } else {
            $id_agen = null;
        }
        $this->load->view('jamaahv2/terms', ['id' => $_GET['id'], 'idg' => $id_agen]);
    }

    public function start()
    {
        $parent_id = null;
        $id = null;
        $ktp_no = null;
        $userGroup = null;
        $parentMembers = null;
        // $this->load->model('agen');
        // if ($_GET['idg'] != null) {
        //     $this->load->library('secret_key');
        //     $idAgen = $this->secret_key->validate($_GET['idg']);
        //     $agen = $this->agen->getAgen($idAgen);
        // } else {
        //     $agen = null;
        // }

        $this->load->model('registrasi');
        $user = $this->registrasi->getUser($_SESSION['id_user']);
        if ($user->member != null) {
            foreach ($user->member as $m) {
                if ($m->id_paket == $_GET['id']) {
                    $this->alert->toastAlert('red', 'Anda sudah terdaftar di paket ini');
                    redirect(base_url() . 'jamaah/order/paket_aktif?id=' . $_GET['id'] . '&idm=' . $m->id_member);   
                }
            }
        }

        if (isset($_GET['parent'])) {
            $parent = $this->registrasi->getMember($_GET['parent']);
            if (empty($parent)) {
                $this->alert->toastAlert('red', 'Akun Induk Tidak Ditemukan');
                redirect(base_url() . 'jamaah/home');
            }
            $user = $this->registrasi->getUser(null, null, $_GET['parent']);
            $parentMem = $this->registrasi->getGroupMembers($_GET['parent']);
            if ($parentMem != null) {
                $parentMembers = array_values($parentMem);
            }
            $parent = $parent[0];
            $parent_id = $parent->id_member;
            $id = $parent->id_paket;
            $ktp_no = $user->ktp_no;
            if ($parent->id_agen != null) {
                $agen = $this->agen->getAgen($parent->id_agen);
            } else {
                $agen = null;
            }
        } else if (!isset($_GET['id'])) {
            $this->alert->toastAlert('red', 'Paket tidak ditemukan');
            redirect(base_url() . 'jamaah/home');
        }
        if (!isset($_GET['id'])) {
            $this->alert->toastAlert('red', 'Paket tidak ditemukan');
            redirect(base_url() . 'jamaah/home');
        }
        if ($id == null) {
            $id = $_GET['id'];
        }

        $this->load->model('PaketUmroh');
        $paket = $this->PaketUmroh->getPackage($id, true, true);
        if (empty($paket)) {
            $this->alert->setJamaah('red', 'Ups...', 'Paket tidak ditemukan');
            redirect(base_url() . 'jamaah/home');
        }
        $this->load->model('registrasi');
        $paket->availableKamar = $this->registrasi->getAvailableKamar($id);
        $this->load->model('agen');
        // $agenList = $this->agen->getAgen(null, false, false, false, true);

        $data = array(
            'paket' => $paket,
            // 'agenList' => $agenList,
            'parent_id' => $parent_id,
            // 'agen' => $agen,
            'ktp_no' => $ktp_no,
            'parentMembers' => $parentMembers,
            'user' => $user,
        );
        $this->load->view('jamaah/registrasi', $data);
    }

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
        //cek paket
        if (empty($_POST['id_paket'])) {
            $this->alert->toastAlert('red', 'Paket tidak ditemukan');
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
                $this->alert->toastAlert('red', 'Umur tidak sesuai untuk sharing bed');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }


        $this->load->model('PaketUmroh');
        $paket = $this->PaketUmroh->getPackage($id, true, true);
        if (empty($paket)) {
            $this->alert->toastAlert('red', 'Paket tidak ditemukan');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->form_validation->set_rules('name', 'Nama Depan', 'trim|required|alpha_numeric_spaces', array(
            'alpha_numeric_spaces' => 'Nama depan tidak boleh mengandung simbol atau karakter khusus'
        ));
        $this->form_validation->set_rules('no_ktp', 'Nomor KTP', 'required');
        $this->form_validation->set_rules('referensi', 'Referensi', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        // if ($_POST['referensi'] == 'Agen') {
        //     $this->form_validation->set_rules('id_agen', 'Konsultan', 'required');
        // }
        // if ($_POST['referensi'] == 'Walk_in' || $_POST['referensi'] == 'Socmed' || $_POST['referensi'] == 'Iklan') {
        //     $this->form_validation->set_rules('office', 'Referensi Kantor', 'required');
        // }
        // if (!isset($_POST['parent_id'])) {
        //     $this->form_validation->set_rules('no_wa', 'Nomor WA', 'trim|required');
        //     $this->form_validation->set_rules('referensi', 'Referensi', 'trim|required');
        //     $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'trim|required');
        //     $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'trim|required');
        //     $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'trim|required');
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
        // $isMember = $this->registrasi->getUser($_POST['id_user']);
        // if (isset($isMember->member[0])) {
        //     $member = $isMember->member[0];
        //     //check date
        //     $curDate = date('Y-m-d');
        //     $tglBerangkat = $member->paket_info->tanggal_berangkat;
        //     if ($tglBerangkat > $curDate) {
        //         $this->load->view('jamaahv2/already_member', $isMember);
        //         return false;
        //     }
        // }

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
            $this->alert->setJamaah('red', 'Ups...', "Gagal melakukan pendaftaran");
            redirect($_SERVER['HTTP_REFERER']);
        }
        if ($id_member == true && $parent_id != null) {
            $this->registrasi->setParent($id_member, $parent_id);
        }

        $this->load->model('customer');
        if ($parent_id == null) {
            $sessKtp = $_POST['no_ktp'];
        } else {
            $sessKtp = $_SESSION['no_ktp'];
        }
        $this->customer->setSession($sessKtp);
        // $this->load->library('secret_key');
        // $idAgen = $this->secret_key->generate($_POST['id_agen']);
        // if ($parent_id != null) {
        //     redirect(base_url() . 'jamaah/daftar/start?parent='. $parent_id . '&idg=' . $idAgen);
        // } else {
        redirect(base_url() . "jamaah/daftar/next?id=" . $paket->id_paket );
        // }
        // redirect(base_url() . "jamaah/daftar/next?idg=$_POST[id_agen]");
    }
    public function cek_wa($str)
    {
        $match = preg_match("/(\+|62)[0-9]{7,12}?$/", $str);

        if ($match == 1) {
            return true;
        } else {
            $this->form_validation->set_message('cek_wa', '{field} harus diawali dengan 62 atau +');
            return false;
        }
    }
    public function next()
    {
        if (!isset($_SESSION['id_member'])) {
            $this->alert->toastAlert('red', 'Maaf, Anda belum terdaftar.');
            redirect(base_url() . 'jamaah/home');
        }
        // if (isset($_GET['idg'])) {
        //     $id_agen = $_GET['idg'];
        // } else {
        //     $id_agen = null;
        // }
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage($_GET['id']);
        $data = [
            'userData' => $_SESSION,
            'paket' => $paket
        ];
        // $data['id_agen'] = $id_agen;
        $this->load->view('jamaahv/register_step2', $data);
    }

    public function registrasi_next()
    {
        $this->load->model('registrasi');
        $this->load->model('Whatsapp');
        $member = $this->registrasi->getMember($_SESSION['id_member']);
        // if ($member[0]->parent_id != null) {
        //     if ($member[0]->id_agen != null || $member[0]->id_agen != '' || $member[0]->id_agen != 0) {
        //         $noHp = $member[0]->agen->no_wa;
        //         if ($noHp != null || $noHp != '') {
        //             $this->Whatsapp->otomatisSendDP($member[0]->parent_id, 'belum_dp_new', $noHp);
        //         } else {
        //             $this->Whatsapp->otomatisSendDP($member[0]->parent_id, 'belum_dp_new');
        //         }
        //     } else {
        //         $this->Whatsapp->otomatisSendDP($member[0]->parent_id, 'belum_dp_new');
        //     }
        // } else {
        //     if ($member[0]->id_agen != null || $member[0]->id_agen != '' || $member[0]->id_agen != 0) {
        //         $noHp = $member[0]->agen->no_wa;
        //         if ($noHp != null || $noHp != '') {
        //             $this->Whatsapp->otomatisSendDP($member[0]->id_member, 'belum_dp_new', $noHp);
        //         } else {
        //             $this->Whatsapp->otomatisSendDP($member[0]->id_member, 'belum_dp_new');
        //         }
        //     } else {
        //         $this->Whatsapp->otomatisSendDP($member[0]->id_member, 'belum_dp_new');
        //     }
        // }
        redirect(base_url() . 'jamaah/daftar/dp_notice');
    }

    public function dp_notice()
    {
        $this->load->model('tarif');
        $this->load->model('registrasi');
        $member = $this->registrasi->getMember(null, $_SESSION['id_user']);
        // echo '<pre>';
        // print_r($member);
        // exit();
        $tarif = $this->tarif->getRiwayatBayar($member[0]->id_member);
        // $statusLengkap = true;
        //jika sudah bayar redirect ke home
        if ($tarif['totalBayar'] > 0) {
            redirect(base_url() . 'jamaah/order');
        }
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage($member[0]->id_paket, false);
        $tarif = $tarif['tarif'];
        $tarif['tgl_regist'] = $member[0]->tgl_regist;
        // $tarif['nama'] = implode(' ', array_filter([$r->first_name, $r->second_name, $r->last_name]));
        $tarif['countDown'] = date("M d, Y H:i:s", strtotime($member[0]->dp_expiry_time));
        $tarif['currentPaket'] = $paket;

        $method = null;
        $this->load->library('bank');
        if (isset($_GET['method'])) {
            if ($_GET['method'] == null) {
                redirect(base_url() . 'jamaah/daftar/dp_notice');
            }
            $method = $this->bank->getBankName($_GET['method']);
            if ($method['bankName'] == 'unknown') {
                redirect(base_url() . 'jamaah/daftar/dp_notice');
            }
        }
        $data = [
            'tarif' => $tarif,
            'method' => $method,
        ];
        $this->load->view('jamaah/metode_bayar_dp', $data);
    }

    public function dp_notice_old()
    {
        $this->load->model('tarif');
        $tarif = $this->tarif->getRiwayatBayar($_SESSION['id_member']);
        $this->load->model('registrasi');
        $member = $this->registrasi->getMember($_SESSION['id_member']);
        //jika sudah bayar redirect ke home
        if ($tarif['totalBayar'] > 0) {
            redirect(base_url() . 'jamaah/home');
        }
        $data = $tarif['tarif'];
        $data['countDown'] = date("M d, Y H:i:s", strtotime($member[0]->dp_expiry_time));
        $this->load->view('jamaahv2/bayar_dp', $data);
    }

    public function pembayaran() {
        $this->load->view('jamaah/pembayaran_view');
    }

    public function incomplete_data()
    {
        // $id_member = $this->secret_key->validate($_SESSION['id_member']);
        // $this->load->model('registrasi');
        // $data = $this->registrasi->getJamaah(null, null, $_SESSION['id_member']);
        $this->load->model('registrasi');
        $member = $this->registrasi->getMember($_SESSION['id_member']);
        if ($member[0]->parent_id == null) {
            redirect(base_url() . 'jamaah/daftar/lengkapi_data?id=' . $member[0]->idSecretMember);
        }
        $parentMembers = $this->registrasi->getGroupMembers($member[0]->parent_id);
        $uncheckJamaah =
            [
                'id_jamaah', 'token', 'first_name', 'second_name', 'last_name', 'ktp_no', 'nama_ayah', 'status_perkawinan',
                'no_rumah', 'email', 'alamat_tinggal', 'provinsi', 'kecamatan', 'kabupaten_kota', 'kewarganegaraan', 'pekerjaan', 'pendidikan_terakhir', 'penyakit', 'upload_penyakit', 'referensi', 'office', 'nama_ahli_waris', 'no_ahli_waris', 'alamat_ahli_waris', 'verified', 'log', 'member'
            ];
        foreach ($parentMembers as $key => $pm) {
            $dataJamaah = (array) $pm->jamaahData;
            foreach ($uncheckJamaah as $unj) {
                unset($dataJamaah[$unj]);
            }
            foreach ($dataJamaah as $dj) {
                if ($dj != null || $dj != '') {
                    $valid = 1;
                } else {
                    $valid = 0;
                    break;
                }
            }
            if ($valid == 0) {
                break;
            }
        }
        if ($valid == 1) {
            redirect(base_url() . 'jamaah/home');
        }
        $data['parentMembers'] = $parentMembers;
        $this->load->view('jamaahv2/lengkapi_data_view', $data);
    }

    public function lengkapi_data()
    {
        $this->load->library('secret_key');
        $id_member = $this->secret_key->validate($_GET['id']);
        $this->load->model('registrasi');
        $data = $this->registrasi->getJamaah(null, null, $id_member);
        // if ($data->tanggal_lahir != null &&
        //     $data->tempat_lahir != null &&
        //     $data->no_wa != null && 
        //     $data->jenis_kelamin != null) {
        //     redirect(base_url() . 'konsultan/jamaah_info?id='.$_GET['id']);
        // }
        $this->load->view('jamaahv2/lengkapi_data', $data);
    }

    public function proses_lengkapi_data()
    {
        if ($_POST['no_wa'] == '+62') {
            $_POST['no_wa'] = NULL;
        }
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
        if ($jamaah->member[0]->agen != null) {
            $_POST['id_agen'] = $jamaah->member[0]->agen->id_agen;
        }
        // $_POST['id_jamaah'] = $jamaah->id_jamaah;
        $_POST['ktp_no'] = $jamaah->ktp_no;
        $_POST['verified'] = 0;
        unset($_POST['id_member']);
        $input = $this->registrasi->daftar($_POST, null, true);
        // echo '<pre>';
        // print_r($input);
        // exit();
        $this->alert->setJamaah('green', 'Berhasil', 'Data berhasil diupdate');
        redirect(base_url() . 'jamaah/home');
    }

    public function bsi_dp()
    {
        $this->load->model('tarif');
        $tarif = $this->tarif->getRiwayatBayar($_SESSION['id_member']);
        $this->load->model('registrasi');
        $member = $this->registrasi->getMember($_SESSION['id_member']);
        //jika sudah bayar redirect ke home
        if ($tarif['totalBayar'] > 0) {
            redirect(base_url() . 'jamaah/home');
        }
        $data = $tarif['tarif'];
        $data['countDown'] = date("M d, Y H:i:s", strtotime($member[0]->dp_expiry_time));
        $this->load->view('jamaahv2/bsi_dp_view', $data);
    }
    public function duitku_dp($metode)
    {
        $this->load->model('tarif');
        $tarif = $this->tarif->getRiwayatBayar($_SESSION['id_member']);
        $this->load->model('registrasi');
        $member = $this->registrasi->getMember($_SESSION['id_member']);
        //jika sudah bayar redirect ke home
        if ($tarif['totalBayar'] > 0) {
            redirect(base_url() . 'jamaah/home');
        }
        $data = $tarif['tarif'];
        $data['countDown'] = date("M d, Y H:i:s", strtotime($member[0]->dp_expiry_time));
        $this->load->model('duitku');
        //get pending transaction
        $invoice = $this->duitku->getPendingTransaction($_SESSION['id_member']);
        if (empty($invoice)) {
            // if no pending transaction, create new payment invoice
            $dStart = strtotime(date('Y-m-d H:i:s'));
            $dEnd = strtotime($member[0]->dp_expiry_time);
            $dDiff = round(abs($dStart - $dEnd) / 60);
            $expired = null;
            if ($dDiff > 0) {
                $expired = $dDiff;
            }
            $invoice = $this->duitku->createInvoice($_SESSION['id_member'], $data['dp_display'], $expired, 'bayar', $metode);
        } else {
            $invoice = $invoice[0];
        }
        redirect($invoice['paymentUrl']);
    }

    public function pindah_paket()
    {
        $this->load->model('paketUmroh');
        if (isset($_GET['month'])) {
            $month = $_GET['month'];
        } else {
            $month = null;
        }

        $this->load->model('registrasi');
        $member = $this->registrasi->getMember($_GET['id']);
        $paket = $this->paketUmroh->getPackage(null, true, true, true, $month, true);
        foreach ($paket as $key => $p) {
            if ($p->id_paket == $member[0]->id_paket) {
                unset($paket[$key]);
            } else {
                $paket[$key]->detail_link = base_url() . 'jamaah/daftar/proses_pindah_paket?idb=' . $p->id_paket . '&idm=' . $member[0]->id_member . '&idl=' . $member[0]->id_paket;
            }
        }
        $currentPaket = $this->paketUmroh->getPackage($member[0]->id_paket);
        $availableMonths = $this->paketUmroh->getAvailableMonths(true, true, true);


        if (!$_GET['id']) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $jamaah = $this->registrasi->getJamaah($member[0]->id_jamaah, null, $_GET['id']);
        if (!$jamaah) {
            $this->alert->set('danger', 'Jamaah Tidak Ditemukan');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $jamaah->paketTersedia = $paket;
        $data = [
            'paket' => $paket,
            'availableMonths' => $availableMonths,
            'monthSelected' => $month,
            'currentPaket' => $currentPaket
        ];
        $this->load->view('jamaahv2/pindah_paket_view', $data);
    }

    public function proses_pindah_paket()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('idm', 'ID Member', 'required');
        $this->form_validation->set_rules('idb', 'Paket Baru', 'required');
        $this->form_validation->set_rules('idl', 'Paket Lama', 'required');

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
                $get_parent[] = $parent[$key]->memberData;
            }
        } else {
            $get_parent = $this->registrasi->getMember($member[0]->id_member);
        }
        foreach ($get_parent as $key => $item) {
            $this->db->where('id_member', $item->id_member);
            $this->db->set('id_paket', $_GET['idb']);
            $this->db->update('program_member');
        }
        redirect(base_url() . "jamaah/daftar/dp_notice?id=" . $_GET['idm']);
    }

    public function batal_bayar()
    {
        $this->load->model('registrasi');
        $member = $this->registrasi->getMember($_GET['id']);
        if ($member[0]->parent_id != null) {
            $groupMember = $this->registrasi->getGroupMembers($member[0]->parent_id);
            foreach ($groupMember as $key => $gm) {
                $this->registrasi->deleteJamaah($gm->jamaahData->id_jamaah);
            }
        } else {
            $this->registrasi->deleteJamaah($member[0]->id_jamaah);
        }

        $this->load->model('customer');
        $this->customer->logout();
        redirect(base_url() . 'jamaah/daftar/batal_bayar_next');
    }
    // 
    public function batal_bayar_next()
    {
        $this->alert->setJamaah('green', 'Sukses', 'Pembayaran berhasil dibatalkan');
        redirect(base_url() . 'jamaah/home');
    }
}
        
    /* End of file  Jamaah/Daftar.php */