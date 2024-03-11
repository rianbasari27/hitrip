<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Req_dokumen extends CI_Controller
{    
    public function getMember($id_member = null, $id_jamaah = null, $id_paket = null)
    {
        if ($id_member != null) {
            $this->db->where('id_member', $id_member);
        }
        if ($id_jamaah != null) {
            $this->db->where('id_jamaah', $id_jamaah);
        }
        if ($id_paket != null) {
            $this->db->where('id_paket', $id_paket);
        }

        $this->db->order_by('id_member', 'desc');
        $query = $this->db->get('program_member');
        $result = $query->result();
        if (empty($result)) {
            return false;
        }

        $this->load->model('paketUmroh');
        $this->load->model('agen');

        foreach ($result as $key => $mbr) {
            $result[$key]->paket_info = $this->paketUmroh->getPackage($mbr->id_paket, false);
            $agenData = null;
            if (!empty($mbr->id_agen)) {
                $agenData = $this->agen->getAgen($mbr->id_agen);
                if (!empty($agenData)) {
                    $agenData = $agenData[0];
                }
            }
            $result[$key]->agen = $agenData;
        }
        return $result;
    }

    public function getJamaah($id = null, $no_ktp = null, $idMember = null)
    {
        $result = false;
        if ($id || $no_ktp) {
            //get data from jamaah table first
            $result = $this->getJamaahTableData($id, $no_ktp);
            if (empty($result)) {
                return false;
            }
            //then get member data
            $id = $result->id_jamaah;
            $result->member = $this->getMember($idMember, $id, null);
        } elseif ($idMember) {
            //get member data first
            $member = $this->getMember($idMember);
            if (empty($member)) {
                return false;
            }
            //then get jamaah table data
            $id = $member[0]->id_jamaah;
            $result = $this->getJamaahTableData($id, $no_ktp);
            if (empty($result)) {
                return false;
            }
            $result->member = $member;
        } else {
            return false;
        }
        return $result;
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
        $jamaah = $this->registrasi->getJamaah($member->id_jamaah);
        $riwayat = $this->getRiwayatBayar($member->id_member, $pembayaran->tanggal_bayar);
        // echo '<pre>';
        // print_r($riwayat);
        // echo exit();
        $data = array(
            'nama' => $jamaah->first_name . ' ' . $jamaah->second_name . ' ' . $jamaah->last_name,
            'nama_paket' => $member->paket_info->nama_paket . ' ' . date_format(date_create($member->paket_info->tanggal_berangkat), "j F Y"),
            'jumlah_bayar' => "Rp. " . number_format($pembayaran->jumlah_bayar, 0, ",", "."),
            'cara_pembayaran' => $pembayaran->cara_pembayaran,
            'keterangan' => $pembayaran->keterangan,
            'tanggal_pembayaran' => date_format(date_create($pembayaran->tanggal_bayar), "j F Y"),
            'agen' => isset($member->agen->nama_agen) ? $member->agen->nama_agen : '',
            'agenTelp' => isset($member->agen->no_wa) ? $member->agen->no_wa : '',
            'riwayat' => $riwayat,
        );
        return $data;
    }
}