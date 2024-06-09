<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Kuitansi_dl extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function download()
    {
        if (!isset($_SESSION['login'])) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->model('tarif');
        $data = $this->tarif->getKuitansiData($_GET['id']);
        $strpos = strpos(strtolower($data['nama_paket']), ' ');
        $firstWord= substr($data['nama_paket'], 0, $strpos);
        $data['jenisPaket'] = false;
        $data['logo'] = 'asset/appkit/images/hitrip/hitrip-logo.png';
        $lunas = $data['riwayat']['tarif']['dataMember'][$data['riwayat']['id_member']]['detailJamaah']->member[0]->lunas;
        if ($lunas == 0) {
            $data['logoLunas'] = 'belum_dp_stamp.png';
        } else if ($lunas == 2) {
            $data['logoLunas'] = 'sudah_cicil_stamp.png';
        } else {
            $data['logoLunas'] = 'lunas_stamp.png';
        }
        foreach ($data['riwayat']['tarif']['dataMember'] as $key => $dm) {
        $data['potongan'] = [];
        $data['extraFee'] = [];
            foreach ($dm['extraFee'] as $fee) {
                if (!empty($fee)) {
                    //ambil extrafee
                    if ($fee->nominal > 0 ) {
                        $data['extraFee'][] = $fee;
                    }
                    //ambil potongan
                    if ($fee->nominal < 0 ) {
                        $data['potongan'][] = $fee;
                    }
                }
            }
            $data['riwayat']['tarif']['dataMember'][$key]['potongan'] = $data['potongan'];
            $data['riwayat']['tarif']['dataMember'][$key]['biayaExtra'] = $data['extraFee'];
        }
        $id_paket = $data['riwayat']['tarif']['dataMember'][$data['riwayat']['id_member']]['detailJamaah']->member[0]->id_paket;
        $this->db->where('id_paket', $id_paket);
        $this->db->order_by('id_member', 'asc');
        $query = $this->db->get('program_member');
        $result = $query->result();
        if (empty($result)) {
            return false;
        }
        $daftar = [];
        foreach ($result as $key => $r) {
            foreach ($data['riwayat']['tarif']['dataMember'] as $idMember => $dm) {
                if ($r->id_member == $idMember) {
                    $daftar[] = $key + 1;
                }
            }
        }
        $strpos = strpos(strtolower($data['nama_paket']), ' ');
        $firstWord= substr($data['nama_paket'], 0, $strpos);
        $data['jenisPaket'] = false;
        $data['logo'] = 'asset/login/images/LOGO-VENTOUR.png';
        if (strtolower($firstWord) == "low" || strtolower($firstWord) == "lcu") {
            $data['jenisPaket'] = true;
            $data['logo'] = 'asset/login/images/LOGO-LCU.png';
        }
        $data['registNumber'] = implode(", ", $daftar);


        
        //cek infant
        foreach ($data['riwayat']['tarif']['dataMember'] as $key => $d) {
            $this->load->library('calculate');
            $age = $this->calculate->ageDiff($d['detailJamaah']->tanggal_lahir, $d['detailJamaah']->member[0]->paket_info->tanggal_berangkat);
            if ($age !== null) {
                if ($age < 2) {
                    $kategori = 'Infant';
                }
                else if ($age >= 2 && $age <= 6 && $d['detailJamaah']->member[0]->sharing_bed == 1) {
                    $kategori = "Sharing Bed";
                } else {
                    $kategori = '';
                }
            } else {
                $kategori = '';
            }
            $data['riwayat']['tarif']['dataMember'][$key]['detailJamaah']->member[0]->kategori = $kategori;
        }

        $data['id'] = $_GET['id'];
        $data['html'] = $this->load->view('staff/kuitansi_html_view', $data, true);
        $this->load->view('staff/kuitansi_view', $data);
    }

    public function download_agen()
    {
        if (!isset($_SESSION['login'])) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->model('tarif');
        $data = $this->tarif->getKuitansiDataAgen($_GET['id']);
        $strpos = strpos(strtolower($data['nama_paket']), ' ');
        $firstWord= substr($data['nama_paket'], 0, $strpos);
        $data['jenisPaket'] = false;
        $data['logo'] = 'asset/login/images/LOGO-VENTOUR.png';
        if (strtolower($firstWord) == "low" || strtolower($firstWord) == "lcu") {
            $data['jenisPaket'] = true;
            $data['logo'] = 'asset/login/images/LOGO-LCU.png';
        }
        $lunas = $data['riwayat']['tarif']['dataMember'][$data['riwayat']['id_member']]['detailAgen'][0]->program[0]->lunas;
        if ($lunas == 0) {
            $data['logoLunas'] = 'belum_dp_stamp.png';
        } else if ($lunas == 2) {
            $data['logoLunas'] = 'sudah_cicil_stamp.png';
        } else {
            $data['logoLunas'] = 'lunas_stamp.png';
        }
        // foreach ($data['riwayat']['tarif']['dataMember'] as $key => $dm) {
        // $data['potongan'] = [];
        // $data['extraFee'] = [];
        //     foreach ($dm['extraFee'] as $fee) {
        //         if (!empty($fee)) {
        //             //ambil extrafee
        //             if ($fee->nominal > 0 ) {
        //                 $data['extraFee'][] = $fee;
        //             }
        //             //ambil potongan
        //             if ($fee->nominal < 0 ) {
        //                 $data['potongan'][] = $fee;
        //             }
        //         }
        //     }
        //     $data['riwayat']['tarif']['dataMember'][$key]['potongan'] = $data['potongan'];
        //     $data['riwayat']['tarif']['dataMember'][$key]['biayaExtra'] = $data['extraFee'];
        // }
        $strpos = strpos(strtolower($data['nama_paket']), ' ');
        $firstWord= substr($data['nama_paket'], 0, $strpos);
        $data['jenisPaket'] = false;
        $data['logo'] = 'asset/login/images/LOGO-VENTOUR.png';
        if (strtolower($firstWord) == "low" || strtolower($firstWord) == "lcu") {
            $data['jenisPaket'] = true;
            $data['logo'] = 'asset/login/images/LOGO-LCU.png';
        }

        $data['id'] = $_GET['id'];
        $data['html'] = $this->load->view('staff/kuitansi_konsultan_view', $data, true);
        $this->load->view('staff/kuitansi_konsultan', $data);
    }

    public function download_wa()
    {
        // if (isset($_GET['id'])) {
        //     $pos = strpos($GET['id'], '');
        //     $id = substr($_GET['id'],0,$pos);
        //     $secret_key = substr($_GET['id'], $pos+1);
        //     $secret_id = md5($id.'ventourapp');
        // } else {
        //     $this->load->view('jamaahv2/forbidden_view');
        // }
        $this->load->library('Secret_key') ;
        $idSecret = $this->Secret_key->validate($_GET['id']);
        if ($idSecret == false) {
            $this->load->view('jamaahv2/forbidden_view');
        } else {
            $this->load->model('tarif');
            $result = $this->tarif->getPembayaran($idSecret);
            $total = count($result['data']);
            $id_pembayaran = $result['data'][$total-1]->id_pembayaran;
            $data = $this->tarif->getKuitansiData($id_pembayaran);
            $lunas = $data['riwayat']['tarif']['dataMember'][$data['riwayat']['id_member']]['detailJamaah']->member[0]->lunas;
            if ($lunas == 0) {
                $data['logoLunas'] = 'belum_dp_stamp.png';
            } else if ($lunas == 2) {
                $data['logoLunas'] = 'sudah_cicil_stamp.png';
            } else {
                $data['logoLunas'] = 'lunas_stamp.png';
            }
            $data['id'] = $id_pembayaran;
            $data['html'] = $this->load->view('staff/kuitansi_html_view', $data, true);
            $this->load->view('staff/kuitansi_view', $data);
        }
    }

    public function download_surat_pernyataan()
    {
        redirect(base_url() .'Surat_Keputusan_Mundur_sebagai_Jemaah_Umroh_(Automated).pdf' );
    }

}