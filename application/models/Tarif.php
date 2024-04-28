<?php

class Tarif extends CI_Model
{

    public function getUnverified()
    {
        $this->db->where('verified !=', 1);
        $this->db->where('verified !=', 2);
        $this->db->order_by('tanggal_bayar', 'desc');
        $query = $this->db->get('pembayaran');

        $pembayaran = $query->result();
        if (empty($pembayaran)) {
            return array();
        }
        $data = array();
        $this->load->model('registrasi');
        foreach ($pembayaran as $key => $p) {
            $member = $this->registrasi->getMember($p->id_member);
            if (empty($member)) {
                continue;
            }
            $data[$key]['pembayaran'] = $p;
            $jamaah = $this->registrasi->getJamaah($member[0]->id_jamaah);
            unset($jamaah->member);
            $data[$key]['jamaah'] = $jamaah;
            $data[$key]['paket'] = $member[0]->paket_info;
        }



        return $data;
    }

    public function calcTariff($id_member)
    {
        //get data member
        $this->db->where('id_member', $id_member);
        $query = $this->db->get('program_member');
        $data_member = $query->row();
        if (empty($data_member)) {
            return false;
        }

        //now get all family members
        $members = [];
        if ($data_member->parent_id) {
            $this->db->where('parent_id', $data_member->parent_id);
            $query = $this->db->get('program_member');
            $members = $query->result();
        } else {
            $members[] = $data_member;
        }

        $totalHargaFamily = 0;
        $totalDpFamily = 0;
        $totalDpFamilyDisplay = 0;
        $result['idMember'] = $id_member;
        $result['parentId'] = $data_member->parent_id;

        $this->load->model('va_model');
        $noVA = $this->va_model->getVAOpen($id_member);
        if (!$noVA) {
            //if empty, create
            $this->va_model->createVAOpen($id_member);
            $noVA = $this->va_model->getVAOpen($id_member);
        }
        $result['nomorVAOpen'] = $noVA;
        if (!$result['nomorVAOpen']) {
            $result['nomorVAOpenLuarBSI'] = '';
        } else {
            $result['nomorVAOpenLuarBSI'] = $this->config->item('va_general_code') . $this->config->item('ventour_institution_code') . $result['nomorVAOpen'];
        }

        foreach ($members as $member) {
            $result['memberIds'][] = $member->id_member;

            $pilihan_kamar = $member->pilihan_kamar;

            //get data paket
            $this->db->where('id_paket', $member->id_paket);
            $query = $this->db->get('paket_umroh');
            $data_paket = $query->row();
            if (empty($data_paket)) {
                return false;
            }

            //get extra fee
            $this->db->where('id_member', $member->id_member);
            $query = $this->db->get('extra_fee');
            $data_extra_fee = $query->result();


            //sum extra fee
            $extra_fee = 0;
            if (!empty($data_extra_fee)) {
                foreach ($data_extra_fee as $def) {
                    $extra_fee = $extra_fee + $def->nominal;
                }
            }


            //get calculation variables

            if ($pilihan_kamar == 'Triple') {
                $harga = $data_paket->harga_triple;
            } elseif ($pilihan_kamar == 'Double') {
                $harga = $data_paket->harga_double;
            } else {
                $harga = $data_paket->harga;
            }

            // get Jamaah
            $this->db->where('id_user', $member->id_user);
            $user = $this->db->get('user')->row();

            //get usia
            if ($user->tanggal_lahir != null && $user->tanggal_lahir != '' && $user->tanggal_lahir != '0000-00-00') {
            $this->load->library('calculate');
            $age = $this->calculate->ageDiff($user->tanggal_lahir, $data_paket->tanggal_berangkat);
                if ($age !== null) {
                    if ($age < 2) {
                        $harga = $harga * 35 / 100;
                    }
                    if ($age >= 2 && $age <= 6 && $member->sharing_bed == 1) {
                        $harga = $harga * 85 / 100;
                    }
                }
            }

            $dendaProgresif = $data_paket->denda_kurang_3;
            $pernahUmroh = $member->pernah_umroh;
            $kenaDenda = 0;
            $total_harga = $harga + $extra_fee + $data_paket->extra_fee;


            // get dp jamaah
            $min_dp = $data_paket->minimal_dp;
            $totalDpFamily = $totalDpFamily + $min_dp;
            $totalDpFamilyDisplay = $totalDpFamilyDisplay + $data_paket->dp_display;

            if ($pernahUmroh == 1) {
                $total_harga = $total_harga + $dendaProgresif;
                $kenaDenda = $dendaProgresif;
            }
            $totalHargaFamily = $totalHargaFamily + $total_harga;
            //update database
            $this->db->where('id_member', $member->id_member);
            $this->db->set('total_harga', $total_harga);
            $this->db->update('program_member');

            $result['dataMember'][$member->id_member] = array(
                'id_member' => $member->id_member,
                'baseFee' => array(
                    'pilihanKamar' => $pilihan_kamar,
                    'harga' => $harga
                ),
                'dendaProgresif' => $kenaDenda,
                'extraFeeProgram' => $data_paket->extra_fee,
                'deskripsiExtraFeeProgram' => $data_paket->deskripsi_extra_fee,
                'extraFee' => $data_extra_fee,
                'totalHarga' => $total_harga
            );
        }
        $result['vaOpenAdminFee'] = $this->config->item('bsi_admin_fee');
        $dp = $totalDpFamily;
        if (empty($dp) || $dp == 0) {
            $dp = $this->config->item('dp_fee');
        }

        $dp_display = $totalDpFamilyDisplay;
        if (empty($dp_display) || $dp_display == 0) {
            $dp_display = $this->config->item('dp_display');
        }
        $result['dp'] = $dp;
        $result['dp_display'] = $dp_display;
        $result['dpPlusBSIAdmin'] = $result['dp_display'] + $result['vaOpenAdminFee'];
        $result['totalHargaFamily'] = $totalHargaFamily;
        $this->cekLunas($result);

        return $result;
    }

    public function calcTariffAgen($id_agen_peserta)
    {
        //get data member
        $this->db->where('id_agen_peserta', $id_agen_peserta);
        $query = $this->db->get('agen_peserta_paket');
        $data_member = $query->row();
        if (empty($data_member)) {
            return false;
        }

        //now get all family members
        $members = [];
        $members[] = $data_member;

        $result['idMember'] = $id_agen_peserta;

        $this->load->model('va_model');
        $noVA = $this->va_model->getVAOpenAgen($id_agen_peserta);
        if (!$noVA) {
            //if empty, create
            $this->va_model->createVAOpen($id_agen_peserta, 'konsultan');
            $noVA = $this->va_model->getVAOpenAgen($id_agen_peserta);
        }
        $result['nomorVAOpen'] = $noVA;
        if (!$result['nomorVAOpen']) {
            $result['nomorVAOpenLuarBSI'] = '';
        } else {
            $result['nomorVAOpenLuarBSI'] = $this->config->item('va_general_code') . $this->config->item('ventour_institution_code') . $result['nomorVAOpen'];
        }

        foreach ($members as $member) {
            $result['memberIds'][] = $member->id_agen_peserta;

            // $pilihan_kamar = $member->pilihan_kamar;

            //get data paket
            $this->db->where('id', $member->id_agen_paket);
            $query = $this->db->get('agen_paket');
            $data_paket = $query->row();
            if (empty($data_paket)) {
                return false;
            }
            $total_harga = $data_member->harga_setelah_diskon;
            $diskon = $data_member->harga - $data_member->harga_setelah_diskon;
            $deskripsi_diskon = $data_member->deskripsi_diskon;

            $result['dataMember'][$member->id_agen_peserta] = array(
                'id_member' => $member->id_agen_peserta,
                'baseFee' => array(
                    'harga' => $data_member->harga
                ),
                'diskon' => $diskon,
                'deskripsiDiskon' => $deskripsi_diskon,
                'totalHarga' => $total_harga
            );
        }
        $result['vaOpenAdminFee'] = $this->config->item('bsi_admin_fee');
        $dp = $total_harga;
        if (empty($dp) || $dp == 0) {
            $dp = $this->config->item('dp_fee');
        }

        $dp_display = $total_harga + 2000;
        if (empty($dp_display) || $dp_display == 0) {
            $dp_display = $this->config->item('dp_display');
        }
        $result['dp'] = $dp;
        $result['dp_display'] = $dp_display;
        $result['dpPlusBSIAdmin'] = $result['dp'] + $result['vaOpenAdminFee'];
        $result['total_harga'] = $total_harga;
        $this->cekLunasAgen($result);
        return $result;
    }

    public function getPaymentsForPackage($idPaket)
    {
        $this->db->where('id_paket', $idPaket);
        $this->db->order_by('parent_id', 'asc');
        $query = $this->db->get('program_member');
        $result = $query->result();
        if (empty($result)) {
            return false;
        }
        $this->load->model('registrasi');
        $maxCicil = 0;
        $sums = array();
        $sumKurang = 0;
        $totalTagihan = 0;
        $sumTotal = 0;
        $sumExclude = 0;
        $currentGroup = null;
        foreach ($result as $key => $r) {
            $userData = $this->registrasi->getUser($r->id_user);
            if ($userData->member[0]->pilihan_kamar != 'Quad') {
                $sumExclude = $sumExclude + $userData->member[0]->total_harga - $userData->member[0]->paket_info->harga;
            }
            $extraFee = $this->getExtraFee($userData->member[0]->id_member);
            if (!empty($extraFee)) {
                foreach ($extraFee as $fee) {
                    if ($fee->nominal > 0) {
                        $sumExclude = $sumExclude + $fee->nominal;
                    }
                }
            }
            $totalTagihan = $totalTagihan + $r->total_harga;
            unset($userData->member);
            $payments = $this->getPembayaran($r->id_member, true);
            $tarif = $this->calcTariff($r->id_member);
            $kurangBayar = $tarif['totalHargaFamily'] - $payments['totalBayar'];
            // $kurangBayar = $r->total_harga - $payments['totalBayar'];
            if ($r->parent_id != null && $r->parent_id != $r->id_member) {
                $payments['data'] = [];
                $payments['totalBayar'] = null;
                $r->total_harga = 0;
                $kurangBayar = null;
            }
            $jmlCicil = sizeof($payments['data']);
            if ($jmlCicil > $maxCicil) {
                $maxCicil = $jmlCicil;
            }
            for ($i = 0; $i <= $maxCicil; $i++) {
                if (!isset($payments['data'][$i])) {
                    break;
                }

                if (isset($sums[$i])) {
                    $sums[$i] = $sums[$i] + $payments['data'][$i]->jumlah_bayar;
                } else {
                    $sums[$i] = $payments['data'][$i]->jumlah_bayar;
                }
            }

            $result[$key]->user = $userData;
            $result[$key]->payments = $payments;

            $result[$key]->payments['kurangBayar'] = $kurangBayar;
            $sumTotal = $sumTotal + $payments['totalBayar'];
            $sumKurang = $sumKurang + $kurangBayar;
        }
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage($idPaket, false);

        $data = array(
            'list' => $result,
            'sumTotal' => $sumTotal,
            'sumKurang' => $sumKurang,
            'sumExclude' => $sumExclude,
            'sumCicil' => $sums,
            'maxCicil' => $maxCicil,
            'paket' => $paket,
            'totalTagihan' => $totalTagihan
        );
        // echo '<pre>';
        // print_r($data);
        // exit();

        return $data;
    }

    public function cekLunas($tarifData)
    {
        $id_member = $tarifData['idMember'];
        $totalHargaFamily = $tarifData['totalHargaFamily'];

        //get data pembayaran
        $pembayaran = $this->getPembayaran($id_member, 1);
        $totalBayar = $pembayaran['totalBayar'];
        if ($totalBayar == 0) {
            $status = 0;
        } elseif ($totalBayar == $totalHargaFamily) {
            $status = 1; //lunas
        } elseif ($totalBayar < $totalHargaFamily) {
            $status = 2; //cicil
        } elseif ($totalBayar > $totalHargaFamily) {
            $status = 3; //kelebihan bayar
        }

        foreach ($tarifData['memberIds'] as $m) {
            $stringArr[] = "id_member = " . $m;
        }
        $whereStrings = "(" . implode(" OR ", $stringArr) . ")";

        //update database
        $this->db->set('lunas', $status);
        $this->db->where($whereStrings);
        $this->db->update('program_member');
        return true;
    }

    public function cekLunasAgen($tarifData)
    {
        $id_member = $tarifData['idMember'];
        $total_harga = $tarifData['total_harga'];

        //get data pembayaran
        $pembayaran = $this->getPembayaranAgen($id_member, 1);
        $totalBayar = $pembayaran['totalBayar'];
        if ($totalBayar == 0) {
            $status = 0;
        } elseif ($totalBayar == $total_harga) {
            $status = 1; //lunas
        } elseif ($totalBayar < $total_harga) {
            $status = 2; //cicil
        } elseif ($totalBayar > $total_harga) {
            $status = 3; //kelebihan bayar
        }

        //update database
        $this->db->set('lunas', $status);
        $this->db->where('id_agen_peserta', $id_member);
        $this->db->update('agen_peserta_paket');
        return true;
    }

    public function getDP($data_paket, $member)
    {
        $this->load->library('calculate');
        $dateDiff = $this->calculate->dateDiff($data_paket->tanggal_berangkat, date('Y-m-d', strtotime($member->tgl_regist)));
        if ($dateDiff <= 45 && $dateDiff >= 41) {
            $min_dp = $data_paket->dp45;
        } else if ($dateDiff <= 40 && $dateDiff >= 36) {
            $min_dp = $data_paket->dp40;
        } else if ($dateDiff <= 35 && $dateDiff >= 26) {
            $min_dp = $data_paket->dp35;
        } else if ($dateDiff <= 25 && $dateDiff >= 21) {
            $min_dp = $data_paket->dp25;
        } else if ($dateDiff <= 20 && $dateDiff >= 16) {
            $min_dp = $data_paket->dp20;
        } else if ($dateDiff <= 15 && $dateDiff >= 11) {
            $min_dp = $data_paket->dp15;
        } else if ($dateDiff <= 10 && $dateDiff >= 0) {
            $min_dp = $data_paket->dp10;
        } else {
            $min_dp = $data_paket->minimal_dp;
        }

        if ($min_dp >= $member->total_harga) {
            $min_dp = $member->total_harga;
        }

        return $min_dp;
    }


    public function getRiwayatBayar($idMember, $tglBayar = null)
    {
        $data = $this->getPembayaran($idMember, true, null, $tglBayar);

        $tarif = $this->calcTariff($idMember);

        $this->load->model('registrasi');
        foreach ($tarif['dataMember'] as $key => $dm) {
            $tarif['dataMember'][$key]['detailJamaah'] = $this->registrasi->getUser(null, null, null, $dm['id_member']);
        }


        $data['sisaTagihan'] = $tarif['totalHargaFamily'] - $data['totalBayar'];
        $data['tarif'] = $tarif;

        return $data;
    }

    public function getRiwayatBayarAgen($idAgenPeserta, $tglBayar = null)
    {
        $this->load->model('agenPaket');
        $this->load->model('agen');
        $agenPaket = $this->agenPaket->getPeserta(null, $idAgenPeserta);
        $data = $this->getPembayaranAgen($idAgenPeserta, true, null, $tglBayar);

        $tarif = $this->calcTariffAgen($idAgenPeserta);

        $this->load->model('registrasi');
        foreach ($tarif['dataMember'] as $key => $dm) {
            $tarif['dataMember'][$key]['detailAgen'] = $this->agen->getAgen($agenPaket[0]->id_agen);
            $tarif['dataMember'][$key]['detailMember'] = $agenPaket;
        }
        $data['sisaTagihan'] = $tarif['total_harga'] - $data['totalBayar'];
        $data['tarif'] = $tarif;

        return $data;
    }

    public function getPembayaranById($id)
    {
        $this->db->where('id_pembayaran', $id);
        $query = $this->db->get('pembayaran');
        return $query->row();
    }
    public function getReq($id)
    {
        $this->db->where('id_request', $id);
        $query = $this->db->get('request_dokumen');
        return $query->row();
    }

    public function getPembayaran($id_member, $verified = false, $id_pembayaran = null, $tglBayar = null)
    {

        $this->db->where('id_member', $id_member);
        $member = $this->db->get('program_member')->row();

        //get family members
        $parentId = $member->parent_id;
        if ($parentId != null && $parentId != 0) {
            $this->db->where('parent_id', $parentId);
            $members = $this->db->get('program_member')->result();
        } else {
            $members[] = $member;
        }
        //make the where strings
        $whereStringsArr = [];
        foreach ($members as $m) {
            $whereStringsArr[] = "id_member = " . $m->id_member;
        }
        $whereStrings = "(" . implode(" OR ", $whereStringsArr) . ")";
        $this->db->where($whereStrings);
        if ($verified !== false) {
            $this->db->where('verified', $verified);
        }
        if ($tglBayar) {
            $this->db->where('tanggal_bayar <=', $tglBayar);
        }
        // $this->db->where('id_member', 'bayar');
        $this->db->order_by('tanggal_bayar', 'asc');
        $query = $this->db->get('pembayaran');
        $pembayaran = $query->result();
        $total = 0;
        $dataBayar = array();
        if (!empty($pembayaran)) {
            foreach ($pembayaran as $key => $p) {
                $this->load->library('secret_key');
                $pembayaran[$key]->id_secret = $this->secret_key->generate($p->id_pembayaran);
                if ($id_pembayaran != null) {
                    if ($p->id_pembayaran == $id_pembayaran) {
                        $dataBayar = $p;
                    }
                } else {
                    $dataBayar[] = $p;
                }
                if ($p->verified == 1) {
                    $total = $total + $p->jumlah_bayar;
                }
            }
        }

        $result = array(
            'id_member' => $id_member,
            'data' => $dataBayar,
            'totalBayar' => $total
        );
        return $result;
    }

    public function getPembayaranAgen($id_agen_peserta, $verified = false, $id_pembayaran = null, $tglBayar = null)
    {

        $this->db->where('id_agen_peserta', $id_agen_peserta);
        $member = $this->db->get('agen_peserta_paket')->row();

        //get family members
        $members[] = $member;

        //make the where strings
        $whereStringsArr = [];
        foreach ($members as $m) {
            $whereStringsArr[] = "id_member = " . $m->id_agen_peserta;
        }
        $whereStrings = "(" . implode(" OR ", $whereStringsArr) . ")";
        $this->db->where($whereStrings);
        if ($verified !== false) {
            $this->db->where('verified', $verified);
        }
        if ($tglBayar) {
            $this->db->where('tanggal_bayar <=', $tglBayar);
        }
        // $this->db->where('id_member', 'bayar');
        $this->db->where('jenis', 'bayar_konsultan');
        $this->db->order_by('tanggal_bayar', 'asc');
        $query = $this->db->get('pembayaran');
        $pembayaran = $query->result();
        $total = 0;
        $dataBayar = array();
        if (!empty($pembayaran)) {
            foreach ($pembayaran as $key => $p) {
                $this->load->library('secret_key');
                $pembayaran[$key]->id_secret = $this->secret_key->generate($p->id_pembayaran);
                if ($id_pembayaran != null) {
                    if ($p->id_pembayaran == $id_pembayaran) {
                        $dataBayar = $p;
                    }
                } else {
                    $dataBayar[] = $p;
                }
                if ($p->verified == 1) {
                    $total = $total + $p->jumlah_bayar;
                }
            }
        }

        $result = array(
            'id_member' => $id_agen_peserta,
            'data' => $dataBayar,
            'totalBayar' => $total
        );
        return $result;
    }

    public function getPembayaranStore($order_id, $verified = false, $id_pembayaran = null, $tglBayar = null)
    {

        $this->db->where('order_id', $order_id);
        $member = $this->db->get('store_orders')->row();

        //get family members
        $members[] = $member;

        //make the where strings
        $whereStringsArr = [];
        foreach ($members as $m) {
            $whereStringsArr[] = "id_member = " . $m->order_id;
        }
        $whereStrings = "(" . implode(" OR ", $whereStringsArr) . ")";
        $this->db->where($whereStrings);
        if ($verified !== false) {
            $this->db->where('verified', $verified);
        }
        if ($tglBayar) {
            $this->db->where('tanggal_bayar <=', $tglBayar);
        }
        // $this->db->where('id_member', 'bayar');
        $this->db->where('jenis', 'store');
        $this->db->order_by('tanggal_bayar', 'asc');
        $query = $this->db->get('pembayaran');
        $pembayaran = $query->result();
        $total = 0;
        $dataBayar = array();
        if (!empty($pembayaran)) {
            foreach ($pembayaran as $key => $p) {
                $this->load->library('secret_key');
                $pembayaran[$key]->id_secret = $this->secret_key->generate($p->id_pembayaran);
                if ($id_pembayaran != null) {
                    if ($p->id_pembayaran == $id_pembayaran) {
                        $dataBayar = $p;
                    }
                } else {
                    $dataBayar[] = $p;
                }
                if ($p->verified == 1) {
                    $total = $total + $p->jumlah_bayar;
                }
            }
        }

        $result = array(
            'id_member' => $order_id,
            'data' => $dataBayar,
            'totalBayar' => $total
        );
        return $result;
    }

    public function getHargaPaketParent($id_parent)
    {
        $this->db->select_sum('total_harga');
        $this->db->where('parent_id', $id_parent);
        $result = $this->db->get('program_member')->row();
        return $result;
    }

    public function getRequest($id_request, $status = false)
    {

        $this->db->where('id_request', $id_request);
        $request = $this->db->get('request_dokumen')->row();
        $result = array(
            'id_member' => $request->id_member,
            'data' => $request
        );
        return $result;
    }

    public function verifikasi($id_pembayaran, $verified)
    {
        // ambil data sesudahnya
        $this->db->where('id_pembayaran', $id_pembayaran);
        $before = $this->db->get('pembayaran')->row();
        //////////////////////////////////

        $this->db->where('id_pembayaran', $id_pembayaran);
        $this->db->set('verified', $verified);
        $this->db->update('pembayaran');

        // ambil data sesudahnya
        $this->db->where('id_pembayaran', $id_pembayaran);
        $after = $this->db->get('pembayaran')->row();
        //////////////////////////////////
        $this->load->model('logs');
        $this->logs->addLogTable($id_pembayaran, 'by', $after, $before);

        //calc tarif
        //get id member
        $this->db->where('id_pembayaran', $id_pembayaran);
        $query = $this->db->get('pembayaran');
        $dataBayar = $query->row();
        if (empty($dataBayar)) {

            return false;
        }
        $this->calcTariff($dataBayar->id_member);
        return true;
    }
    public function verifDokumen($id_member, $status)
    {
        $this->db->where('id_member', $id_member);
        $this->db->set('status', $status);
        $this->db->update('request_dokumen');
        //calc tarif
        //get id member
        $this->db->where('id_member', $id_member);
        $query = $this->db->get('request_dokumen');
        $dataReq = $query->row();
        if (empty($dataReq)) {
            return false;
        }
        $this->calcTariff($dataReq->id_member);
        return true;
    }

    public function getExtraFee($id_member, $status = null)
    {
        $this->db->where('id_member', $id_member);
        if ($status == 'Quad') {
            $this->db->where('keterangan LIKE', '%quad%');
        }
        $query = $this->db->get('extra_fee');
        $result = $query->result();
        return $result;
    }

    public function setExtraFee($id_member, $nominal, $ket, $id_voucher = null)
    {

        $ins = $this->db->insert('extra_fee', array(
            'id_member' => $id_member,
            'nominal' => $nominal,
            'keterangan' => $ket,
            'id_voucher' => $id_voucher
        ));
        if (!$ins) {
            return false;
        }
        $id = $this->db->insert_id();

        // ambil data sesudahnya
        $this->db->where('id_fee', $id);
        $after = $this->db->get('extra_fee')->row();
        //////////////////////////////////

        $this->load->model('logs');
        $this->logs->addLog('pm', $id_member);
        $this->logs->addLogTable($id, 'ef', null, $after);
        $this->logs->addLog('ef', $id);
        $this->calcTariff($id_member);
        return true;
    }

    public function deleteExtraFee($idFee, $idMember)
    {
        // ambil data sesudahnya
        $this->db->where('id_fee', $idFee);
        $before = $this->db->get('extra_fee')->row();
        //////////////////////////////////
        $this->db->where('id_fee', $idFee);
        $del = $this->db->delete('extra_fee');
        if (!$del) {
            return false;
        }
        $this->load->model('logs');
        $this->logs->addLogTable($idFee, 'ef', $before, null);
        $this->calcTariff($idMember);
        return true;
    }

    public function setPembayaran($data, $jenis = 'bayar') //jenis : bayar, bayar_konsultan, store
    {
        if ($jenis == 'bayar_konsultan') {

            $idPeserta = $data['id_agen_peserta'];
            $data['id_member'] = $idPeserta;
            unset($data['id_agen_peserta']);
        } 
        if ($jenis == "store") {
            $idOrder = $data['order_id'];
            $data['id_member'] = $idOrder;
            unset($data['order_id']);
        }
        $data['jenis'] = $jenis;

        if (isset($data['files']['scan_bayar'])) {

            if ($jenis == 'bayar_konsultan') {
                $idScan = $data['id_agen_peserta'];
                $doc = 'bayar_konsultan';
            }else if ($jenis == 'store') {
                $idScan = $data['order_id'];
                $doc = 'bayar_store';
            } else {
                $idScan = $data['id_user'];
                $doc = 'bayar';
            }

            $this->load->library('scan');
            $hasil = $this->scan->check($data['files']['scan_bayar'], $doc, $idScan);
            if ($hasil !== false) {
                $data['scan_bayar'] = $hasil;
            } else {
                return false;
            }
            unset($data['files']);
        }
        if (isset($data['id_user'])) {
            unset($data['id_user']);
        }

        $insert = $this->db->insert('pembayaran', $data);
        if (!$insert) {
            return false;
        }

        $id = $this->db->insert_id();

        // ambil data sesudahnya
        $this->db->where('id_pembayaran', $id);
        $after = $this->db->get('pembayaran')->row();
        //////////////////////////////////

        $this->load->model('logs');
        $this->logs->addLogTable($id, 'by', null, $after);
        if ($jenis == 'bayar_konsultan') {
            $this->cekLunasKonsultan($idPeserta);
        } else if ($jenis == 'store') {
            $this->cekBayarStore($idOrder);
        } else {
            $this->calcTariff($data['id_member']);
        }
        $this->alert->toast('success', 'Selamat', 'Pembayaran berhasil di input');

        // send notification
        // if ($jenis != 'bayar_konsultan' && $jenis != "store") {
        //     if ($data['verified'] == 1) {
        //         $this->load->model('Notification');
        //         $jumlah = number_format($data['jumlah_bayar']);
        //         $this->Notification->sendPembayaranMessage($data['id_member'], "$data[keterangan] sebesar Rp. $jumlah dengan cara pembayaran $data[cara_pembayaran] Berhasil", "Pembayaran berhasil");
        //     }
        // }

        return true;
    }
    public function cekLunasKonsultan($idPeserta)
    {
        $this->load->model('agenPaket');
        $agenPaket = $this->agenPaket->getPeserta(null, $idPeserta);
        $totalBayar = $this->getSumPembayaranKonsultan($idPeserta);
        $idAgen = $agenPaket[0]->id_agen;
        $price = $agenPaket[0]->harga_setelah_diskon;
        if ($totalBayar == 0) {
            $lunas = 0;
        } elseif ($totalBayar == $price) {
            $lunas = 1;
        } elseif ($totalBayar < $price) {
            $lunas = 2;
        } elseif ($totalBayar > $price) {
            $lunas = 3;
        }
        // update peserta jadi lunas
        $this->db->where('id_agen_peserta', $idPeserta);
        $this->db->set('lunas', $lunas);
        $this->db->update('agen_peserta_paket');
        // update agen jadi active
        if ($lunas == 1 || $lunas == 3) {
            $this->db->where('id_agen', $idAgen);
            $this->db->set('active', 1);
            $this->db->update('agen');
        }
    }

    public function cekBayarStore($orderId) {
        $this->db->where('order_id', $orderId);
        $order = $this->db->get('store_orders')->row();
        $totalBayar = $this->getSumPembayaranStore($orderId);
        $price = $order->total_amount;
        if ($totalBayar == 0) {
            $lunas = 0;
        } elseif ($totalBayar == $price) {
            $lunas = 1;
        } elseif ($totalBayar < $price) {
            $lunas = 2;
        } elseif ($totalBayar > $price) {
            $lunas = 3;
        }
        $this->db->where('order_id', $orderId);
        $this->db->set('lunas', $lunas);
        $this->db->update('store_orders');

        $this->load->model('store');
        if ($lunas != 0) {
            $check = $this->store->checkOrderTracking($orderId, 0);
        }
    }

    public function getPembayaranKonsultan($idPeserta, $verified = false)
    {
        if ($verified == true) {
            $this->db->where('verified', 1);
        }
        $this->db->where('id_member', $idPeserta);
        $this->db->where('jenis', 'bayar_konsultan');
        $data = $this->db->get('pembayaran')->result();
        foreach ($data as $key => $d) {
            $data[$key]->kuitansiDownload = base_url() . 'konsultan/kuitansi_dl/download_agen?id='. $d->id_pembayaran;
        }
        return $data;
    }

    public function getSumPembayaranKonsultan($idPeserta)
    {
        $this->db->select('SUM(jumlah_bayar) total_bayar');
        $this->db->where('verified', 1);
        $this->db->where('id_member', $idPeserta);
        $this->db->where('jenis', 'bayar_konsultan');
        $data = $this->db->get('pembayaran')->row();
        return $data->total_bayar;
    }

    public function getSumPembayaranStore($idOrder)
    {
        $this->db->select('SUM(jumlah_bayar) total_bayar');
        $this->db->where('verified', 1);
        $this->db->where('id_member', $idOrder);
        $this->db->where('jenis', 'store');
        $data = $this->db->get('pembayaran')->row();
        return $data->total_bayar;
    }

    public function getSisaPembayaranKonsultan($idPeserta)
    {
        $member = $this->db->where('id_agen_peserta', $idPeserta)->get('agen_peserta_paket')->row();
        if (empty($member)) {
            return false;
        }
        $sumBayar = $this->getSumPembayaranKonsultan($idPeserta);
        $sisaBayar = $member->harga_setelah_diskon - $sumBayar;
        return $sisaBayar;
    }

    public function getSisaPembayaranStore($idOrder)
    {
        $order = $this->db->where('order_id', $idOrder)->get('store_orders')->row();
        if (empty($order)) {
            return false;
        }
        $sumBayar = $this->getSumPembayaranStore($idOrder);
        $sisaBayar = $order->total_amount - $sumBayar;
        return $sisaBayar;
    }

    public function setPengembalian($data)
    {
        if (isset($data['files']['scan_lebih_bayar'])) {
            $this->load->library('scan');
            $hasil = $this->scan->check($data['files']['scan_lebih_bayar'], 'lebih_bayar', $data['id_jamaah']);
            if ($hasil !== false) {
                $data['scan_lebih_bayar'] = $hasil;
            } else {
                return false;
            }
            unset($data['files']);
        }
        unset($data['id_jamaah']);
        $insert = $this->db->insert('refund_pembayaran', $data);
        if (!$insert) {
            return false;
        }

        $id = $this->db->insert_id();

        // ambil data sesudahnya
        $this->db->where('id_refund', $id);
        $after = $this->db->get('refund_pembayaran')->row();
        //////////////////////////////////

        $this->load->model('logs');
        $this->logs->addLogTable($id, 'rp', null, $after);
        $this->calcTariff($data['id_member']);
        $this->alert->set('success', 'Pengembalian Berhasil diinput');

        // send notification
        if ($data['verified'] == 1) {
            $this->load->model('Notification');
            $jumlah = number_format($data['jumlah_pengembalian']);
            $this->Notification->sendPembayaranMessage($data['id_member'], "$data[keterangan] sebesar Rp. $jumlah dengan cara pembayaran $data[cara_pembayaran] Berhasil");
        }

        return true;
    }

    public function hapusPembayaran($id, $id_member)
    {
        //get files, then delete file
        $this->db->where('id_pembayaran', $id);
        $query = $this->db->get('pembayaran');
        $pembayaran = $query->row();
        if (empty($pembayaran)) {
            return false;
        }
        $file = $pembayaran->scan_bayar;
        if (!empty($file)) {
            unlink(SITE_ROOT . $file);
        }
        $this->db->where('id_pembayaran', $id);
        $this->db->delete('pembayaran');
        $this->calcTariff($id_member);
        return true;
    }

    public function hapusPembayaranAgen($id, $id_member)
    {
        //get files, then delete file
        $this->db->where('id_pembayaran', $id);
        $query = $this->db->get('pembayaran');
        $pembayaran = $query->row();
        if (empty($pembayaran)) {
            return false;
        }
        $file = $pembayaran->scan_bayar;
        if (!empty($file)) {
            unlink(SITE_ROOT . $file);
        }
        $this->db->where('id_pembayaran', $id);
        $this->db->delete('pembayaran');
        $this->calcTariffAgen($id_member);
        return true;
    }

    public function hapusRefund($id_member)
    {
        //get files, then delete file
        $this->db->where('id_member', $id_member);
        $query = $this->db->get('refund_pembayaran');
        $refund = $query->row();
        if (empty($refund)) {
            return false;
        }
        $file = $refund->scan_lebih_bayar;
        if (!empty($file)) {
            unlink(SITE_ROOT . $file);
        }
        $this->db->where('id_member', $id_member);
        $this->db->delete('refund_pembayaran');
        $this->calcTariff($id_member);
        return true;
    }

    public function getKuitansiData($id_pembayaran)
    {

        $pembayaran = $this->getPembayaranById($id_pembayaran);
        if (empty($pembayaran)) {
            return false;
        }

        $this->load->model('registrasi');
        $member = $this->registrasi->getMember($pembayaran->id_member);
        $member = $member[0];
        $user = $this->registrasi->getUser($member->id_user);
        $riwayat = $this->getRiwayatBayar($member->id_member, $pembayaran->tanggal_bayar);

        $tanggal = new DateTime($member->paket_info->tanggal_berangkat);
        $tanggal->modify('-45 days');
        $h_45 = $tanggal->format("j F Y");

        $data = array(
            'nama' => $user->name,
            'email' => $user->email,
            'no_wa' => $user->no_wa,
            'tanggal_cetak' => $this->date->convert('j F Y', date('Y-m-d')),
            'nama_paket' => $member->paket_info->nama_paket . ' ' . $this->date->convert("j F Y", $member->paket_info->tanggal_berangkat),
            'h_45' => $h_45,
            'jumlah_bayar' => "Rp. " . number_format($pembayaran->jumlah_bayar, 0, ",", "."),
            'cara_pembayaran' => $pembayaran->cara_pembayaran,
            'keterangan' => $pembayaran->keterangan,
            'jenis' => $pembayaran->jenis,
            'tanggal_pembayaran' => $this->date->convert('j F Y', $pembayaran->tanggal_bayar),
            'agen' => isset($member->agen->nama_agen) ? $member->agen->nama_agen : '',
            'agenTelp' => isset($member->agen->no_wa) ? $member->agen->no_wa : '',
            'riwayat' => $riwayat,
        );
        return $data;
    }

    public function getKuitansiDataAgen($id_pembayaran)
    {

        $this->db->where('id_pembayaran', $id_pembayaran);
        $pembayaran = $this->db->get('pembayaran')->row();
        if (empty($pembayaran)) {
            return false;
        }

        $this->load->model('agenPaket');
        $this->load->model('agen');
        $program = $this->agenPaket->getPeserta(null, $pembayaran->id_member);
        $program = $program[0];
        $agen = $this->agen->getAgen($program->id_agen);
        $agen = $agen[0];
        $riwayat = $this->getRiwayatBayarAgen($program->id_agen_peserta, $pembayaran->tanggal_bayar);

        $event = $this->agenPaket->getAgenEvent(null, $program->agenPaket->id);
        // echo '<pre>';
        // print_r($event);
        // exit();
        $tanggal = new DateTime($event[0]->tanggal);
        $tanggal->modify('-45 days');
        $h_45 = $tanggal->format("j F Y");

        $data = array(
            'nama' => $agen->nama_agen,
            'tanggal_cetak' => $this->date->convert('j F Y', date('Y-m-d')),
            'nama_paket' => $program->agenPaket->nama_paket . ' ' . $this->date->convert("j F Y", $event[0]->tanggal),
            'h_45' => $h_45,
            'jumlah_bayar' => "Rp. " . number_format($pembayaran->jumlah_bayar, 0, ",", "."),
            'cara_pembayaran' => $pembayaran->cara_pembayaran,
            'keterangan' => $pembayaran->keterangan,
            'jenis' => $pembayaran->jenis,
            'tanggal_pembayaran' => $this->date->convert('j F Y', $pembayaran->tanggal_bayar),
            'riwayat' => $riwayat,
        );
        return $data;
    }

    public function getRequestData($id)
    {
        $request = $this->getReq($id);
        if (empty($request)) {
            return false;
        }
        $this->load->model('registrasi');
        $member = $this->registrasi->getMember($request->id_member);
        $member = $member[0];
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage($member->id_paket, false, false, false, null, false);
        $data = array(
            'nama' => $request->nama_2_suku,
            'ktp_no' => $request->no_ktp,
            'tgl_request' => $request->tgl_request,
            'id_request' => $request->id_request,
            'tambah_nama' => $request->tambah_nama,
            'tanggal_berangkat' => $paket->tanggal_berangkat,
            'tanggal_pulang' => $paket->tanggal_pulang,
            'imigrasi' => $request->imigrasi_tujuan,
            'kemenag' => $request->kemenag_tujuan,
            'tgl_lahir' => $request->tempat_lahir . ', ' . (date('d-m-Y', strtotime($request->tanggal_lahir))),
        );
        return $data;
    }
}