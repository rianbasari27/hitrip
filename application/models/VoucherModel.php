<?php

class VoucherModel extends CI_Model
{

    public function applyVoucher($kodeVoucher, $idMember)
    {
        //find if code exist
        $dataVoucher = $this->db->where('kode_voucher', $kodeVoucher)
            ->where('aktif', 1)
            ->get('voucher')->row();

        if (empty($dataVoucher)) {
            return [
                'status' => false,
                'msg' => 'Kode voucher tidak ditemukan'
            ];
        }
        //cek expiry date
        $currDate = date('Y-m-d');
        if ($currDate < $dataVoucher->tgl_mulai || $currDate > $dataVoucher->tgl_berakhir) {
            return [
                'status' => false,
                'msg' => 'Kode voucher sudah kadaluarsa'
            ];
        }
        $this->load->model('registrasi');
        $member = $this->registrasi->getMember($idMember);
        //cek paket
        $dataPaket = $this->db->where('id_voucher', $dataVoucher->id_voucher)
            ->where('id_paket', $member[0]->id_paket)
            ->get('voucher_paket')->row();
        if (empty($dataPaket)) {
            return [
                'status' => false,
                'msg' => 'Kode voucher tidak tersedia untuk paket Anda'
            ];
        }

        //cari ada family atau tidak
        $family = [];
        if ($member[0]->parent_id) {
            $family = $this->registrasi->getGroupMembers($member[0]->parent_id);
        }
        $memberIdList = [];
        if (empty($family)) {
            $memberIdList[] = $idMember;
        } else {
            foreach ($family as $key => $family) {
                $memberIdList[] = $key;
            }
        }
        $countDiskon = 0;
        $status = 0;
        $this->load->model('tarif');

        foreach ($memberIdList as $idFromList) {
            //cek quota
            $voucher = $this->db->where('id_voucher', $dataVoucher->id_voucher)
                ->where('kuota >', 0)
                ->get('voucher')->row();
            if (empty($voucher)) {
                break;
            }
            //cek apakah member ini sudah pernah pakai voucher yg sama
            $inExtraFee = $this->db->where('id_member', $idFromList)
                ->where('id_voucher', $voucher->id_voucher)
                ->get('extra_fee')->row();
            if ($inExtraFee) {
                continue;
            }
            //apply voucher
            $this->db->trans_begin();
            $apply = $this->tarif->setExtraFee($idFromList, $voucher->nominal * -1, 'Diskon kode voucher ' . $voucher->kode_voucher, $voucher->id_voucher);
            //kuota kurangi satu
            $this->db->where('id_voucher', $voucher->id_voucher)
                ->set('kuota', $voucher->kuota - 1)
                ->update('voucher');
            $countDiskon = $countDiskon + $voucher->nominal;
            $this->db->trans_complete();
        }
        return [
            'status' => $countDiskon,
            'msg' => 'Diskon yang didapatkan ' . 'Rp. ' . number_format($countDiskon, 0, ',', '.') . ',-'
        ];
    }
    public function addVoucher($data)
    {

        //check aktif
        if (!isset($data['aktif'])) {
            $aktif = 0;
        } else {
            $aktif = $data['aktif'];
        }

        //check detail promo

        $tgl_mulai = date("Y-m-d", strtotime($data['tgl_mulai']));
        $tgl_akhir = date("Y-m-d", strtotime($data['tgl_berakhir']));

        if (!empty($data['kuota'])) {
            $kuota = $data['kuota'];
        } else {
            $kuota = 45;
        }


        $insData = array(
            'kode_voucher' => $data['kode_voucher'],
            'nominal' => $data['nominal'],
            'kuota' => $kuota,
            'tgl_mulai' => $tgl_mulai,
            'tgl_berakhir' => $tgl_akhir,
            'aktif' => $aktif

        );

        if ($this->db->insert('voucher', $insData)) {
            $this->alert->toast('success', 'Selamat', "Voucher berhasil ditambahkan");
        } else {
            $this->alert->toast('danger', 'Mohon Maaf', 'System Error, silakan coba kembali');
            return false;
        }

        //add log and voucher_paket
        $insert_id = $this->db->insert_id();
        $this->addVoucherPaket($insert_id, $data);

        // ambil data sesudahnya
        $this->db->where('id_voucher', $insert_id);
        $after = $this->db->get('voucher')->row();
        //////////////////////////////////

        $this->load->model('logs');
        $this->logs->addLogTable($insert_id, 'v', null, $after);
        return $insert_id;
    }

    public function addVoucherPaket($id, $data)
    {
        foreach ($data['id_paket'] as $id_paket) {
            $voucher = array(
                'id_voucher' => $id,
                'id_paket' => $id_paket
            );
            $this->db->insert('voucher_paket', $voucher);
        }
    }

    public function getVoucher($id)
    {
        $this->db->where('id_voucher', $id);
        $query = $this->db->get('voucher');
        $data = $query->row();

        $this->db->where('id_voucher', $id);
        $query = $this->db->get('voucher_paket');
        $voucher_paket = $query->result();
        $paket = array();
        foreach ($voucher_paket as $v) {
            $paket[] = $v->id_paket;
        }
        $data->paket = $paket;
        return $data;
    }

    public function editVoucher($data)
    {
        // ambil data sebelumnya
        $this->db->where('id_voucher', $data['id_voucher']);
        $before = $this->db->get('voucher')->row();
        //////////////////////////////////

        $dataVoucher = array(
            'id_voucher' => $data['id_voucher'],
            'kode_voucher' => $data['kode_voucher'],
            'nominal' => $data['nominal'],
            'kuota' => $data['kuota'],
            'tgl_mulai' => $data['tgl_mulai'],
            'tgl_berakhir' => $data['tgl_berakhir'],
            'aktif' => $data['aktif']
        );

        $this->db->where('id_voucher', $data['id_voucher']);
        $this->db->update('voucher', $dataVoucher);

        $this->db->where('id_voucher', $data['id_voucher']);
        $this->db->delete('voucher_paket');
        if (isset($data['id_paket'])) {
            foreach ($data['id_paket'] as $p) {
                $voucherPaket = array(
                    'id_voucher' => $data['id_voucher'],
                    'id_paket' => $p
                );
                $this->db->insert('voucher_paket', $voucherPaket);
            }
        }

        // ambil data sesudahnya
        $this->db->where('id_voucher', $data['id_voucher']);
        $after = $this->db->get('voucher')->row();
        //////////////////////////////////

        $this->load->model('logs');
        $this->logs->addLogTable($data['id_voucher'], 'v', $before, $after);
    }

    public function getVoucherPaketArray($id)
    {
        $this->db->where('id_voucher', $id);
        $query = $this->db->get('voucher');
        $data = $query->row();

        $this->db->where('id_voucher', $id);
        $query = $this->db->get('voucher_paket');
        $voucher_paket = $query->result();
        $paket = array();
        foreach ($voucher_paket as $v) {
            $paket[] = $v->id_paket;
        }
        $data->paket = $paket;
        return $data;
    }

    public function hapusVoucher($id)
    {
        $this->db->where('id_voucher', $id);
        $this->db->delete('voucher');

        $this->db->where('id_voucher', $id);
        $this->db->delete('voucher_paket');
    }

    public function getVoucherPaket($id_voucher = null, $id_paket = null) {
        if ($id_voucher) {
            $this->db->where('id_voucher', $id_voucher);
        }

        if ($id_paket) {
            $this->db->where('id_paket', $id_paket);
        }

        return $this->db->get('voucher_paket')->result();
    }
}