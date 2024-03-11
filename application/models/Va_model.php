<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Va_model extends CI_Model
{

    public function getVAOpen($id_member)
    {
        if (!$id_member) {
            return false;
        }
        $this->db->where('id_member', $id_member);
        $data = $this->db->get('program_member')->row_array();
        if (!$data) {
            return false;
        }
        $va = $data['va_open'];
        return $va;
    }

    public function getVAOpenAgen($id_agen_peserta)
    {
        if (!$id_agen_peserta) {
            return false;
        }
        $this->db->where('id_agen_peserta', $id_agen_peserta);
        $data = $this->db->get('agen_peserta_paket')->row_array();
        if (!$data) {
            return false;
        }
        $va = $data['va_open'];
        return $va;
    }

    public function createVA($data)
    {
        //check if nominal valid
        $this->load->model('tarif');
        $tarif = $this->tarif->getRiwayatBayar($data['id_member']);
        if ($data['nominal_tagihan'] > $tarif['sisaTagihan']) {
            $this->alert->set('danger', 'Error, Nominal VA lebih besar daripada sisa tagihan!');
            return false;
        }
        if (isset($data['expiryDays'])) {
            $expiryDays = $data['expiryDays'];
        } else {
            $expiryDays = $this->config->item('va_expiry_days');
        }
        if (isset($data['expiryHours'])) {
            $expiryHours = $data['expiryHours'];
        } else {
            $expiryHours = $this->config->item('va_expiry_hours');
        }
        $data['nomor_va'] = $this->generateNomorVA();
        $data['tanggal_expired'] = $this->calcExpiryDate($expiryDays, $expiryHours);

        unset($data['expiryDays']);
        unset($data['expiryHours']);
        if ($this->db->insert('virtual_account', $data)) {
            $nominalPretty = 'Rp. ' . number_format($data['nominal_tagihan'], 0, ',', '.') . ',-';
            $this->alert->set('success', 'Virtual Account senilai ' . $nominalPretty . ' berhasil dibuat dengan nomor akun ' . $data['nomor_va']);
            return $data['nomor_va'];
        } else {
            $this->alert->set('danger', 'Error, Virtual Account gagal dibuat!');
            return false;
        }
    }

    public function calcExpiryDate($expiryDays, $expiryHours)
    {
        $now = new DateTime(); //now

        $now->add(new DateInterval("PT{$expiryHours}H"));
        $now->add(new DateInterval("P{$expiryDays}D"));
        return $now->format('Y-m-d H:i:s');
    }
    public function generateNomorVA()
    {
        $this->load->library('strings');
        $used = 1;
        while ($used == 1) {
            $randString = '1' . $this->strings->generateRandom();
            $exist = $this->db->where('nomor_va', $randString)
                ->get('virtual_account')->row();
            if (!$exist) {
                $used = 0;
            }
        }
        return $randString;

        //check if strings already used
    }
    public function generateNomorVAOpen($jenis = 'jamaah')
    {
        $this->load->library('strings');
        if ($jenis == 'konsultan') {
            $prefix = '0';
        }else if ($jenis == 'store') {
            $prefix = '5';
        } else {
            $prefix = '1';
        }
        $used = 1;
        while ($used == 1) {
            $randString = $prefix . $this->strings->generateRandom();
            if ($jenis == 'konsultan') {
                $exist = $this->db->where('va_open', $randString)
                    ->get('agen_peserta_paket')->row();
            }else if ($jenis == 'store') {
                $exist = $this->db->where('va_open', $randString)
                    ->get('store_orders')->row();
            } else {
                $exist = $this->db->where('va_open', $randString)
                    ->get('program_member')->row();
            }
            if (!$exist) {
                $used = 0;
            }
        }
        return $randString;
    }
    public function createVAOpen($idMember, $jenis = 'jamaah') //jenis : jamaah, konsultan, store
    {
        $va = $this->generateNomorVAOpen($jenis);
        if ($jenis == 'konsultan') {
            $update = $this->db->update('agen_peserta_paket', ['va_open' => $va], ['id_agen_peserta' => $idMember]);
        }else if ($jenis == 'store') {
            $update = $this->db->update('store_orders', ['va_open' => $va], ['order_id' => $idMember]);
        } else {
            $update = $this->db->update('program_member', ['va_open' => $va], ['id_member' => $idMember]);
        }
        if ($update) {
            return $va;
        } else {
            return false;
        }
    }
}
                        
/* End of file Va_model.php */