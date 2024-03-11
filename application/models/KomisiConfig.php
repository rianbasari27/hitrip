<?php

class KomisiConfig extends CI_Model
{
    public function getKomisiConfig($id_config=null) {
        if ($id_config != null) {
            $this->db->where('id_config', $id_config);
        }
        $this->db->order_by('id_config', 'ASC');
        $query = $this->db->get('komisi_config');
        $data = $query->result();
        return $data;
    }

    public function updateKomisiConfig($id_config, $data) {
        $this->db->where('id_config', $id_config);
        $update = $this->db->update('komisi_config', $data);
        if ($update == true) {
            return true;
        } else {
            return false;
        }
    }

    public function addKomisiPoinPribadi($data) {

        if (!isset($data['id_agen'])) {
            return false;
        }

        if (isset($data['poin'])) {
            $poin = $data['poin'];
        } else {
            $poin = 0;
        }

        if (isset($data['id_member'])) {
            $id_member = $data['id_member'];
        } else {
            $id_member = null;
        }

        if (isset($data['tanggal_insert'])) {
            $tanggal_insert = $data['tanggal_insert'];
        } else {
            $tanggal_insert = date("Y-m-d H:i:s");
        }

        if (isset($data['musim'])) {
            $musim = $data['musim'];
        } else {
            $musim = null;
        }

        if (isset($data['keterangan'])) {
            $keterangan = $data['keterangan'];
        } else {
            $keterangan = null;
        }

        $insData = [
            "id_agen" => $data['id_agen'],
            "poin" => $poin,
            "id_member" => $id_member,
            "tanggal_insert" => $tanggal_insert,
            "musim" => $musim,
            "keterangan" => $keterangan,
        ];

        if (!$this->db->insert('komisi_poin_pribadi', $insData)) {
            return false;
        }

        return true ;
    }

    public function getTotalPoin($id_agen, $hijri = null) 
    {
        if ($hijri == null ) {
            $this->load->library('date');
            $hijri = $this->date->getHijriYear();
        }

        $this->db->select('SUM(poin) total_poin');
        $this->db->where("musim", $hijri);
        $this->db->where('id_agen', $id_agen);
        $data = $this->db->get('komisi_poin_pribadi')->row();

        return (int) $data->total_poin;
        
    }

    public function groupByMusim($id_agen = null)
    {
        if ($id_agen != null) {
            $this->db->where('id_agen', $id_agen);
        }
        $this->db->group_by('musim');
        $result = $this->db->get('komisi_poin_pribadi')->result();

        return $result;
        
    }

    public function updatePecahTelorAgen() {
        $sql = "UPDATE agen a
                JOIN program_member b ON b.id_agen = a.id_agen
                JOIN paket_umroh c ON c.id_paket = b.id_paket
                SET a.pecah_telor = 1
                WHERE c.tanggal_berangkat <= CURDATE()
                AND a.pecah_telor < 1";
        $this->db->query($sql);
    }

    public function insertPoinPribadi() {
        $this->load->library('date');
        $musim = $this->date->getMusim();
        $hijri = $musim['hijri'];
        $tglAwal = $musim['tglAwal'];
        $this->db->trans_start();

        $sql = "INSERT INTO komisi_poin_pribadi SELECT null, a.id_agen, pu.komisi_poin, pm.id_member, NOW(), '$hijri', 
                CONCAT(j.first_name, ' ', j.second_name, ' ' ,j.last_name, ' - ', pu.nama_paket, ' (', pu.tanggal_berangkat,')') 
                FROM `agen` a JOIN program_member pm ON pm.id_agen = a.id_agen AND pm.poin_counted < 1 JOIN jamaah j 
                ON j.id_jamaah = pm.id_jamaah JOIN paket_umroh pu ON pu.id_paket = pm.id_paket AND pu.tanggal_berangkat <= NOW() 
                AND pu.tanggal_berangkat >= '$tglAwal' AND pu.komisi_poin > 0 ORDER BY `pu`.`tanggal_berangkat` ASC";
        $this->db->query($sql);

        $sql = "UPDATE `agen` a JOIN program_member pm ON pm.id_agen = a.id_agen AND pm.poin_counted < 1 JOIN jamaah j 
                ON j.id_jamaah = pm.id_jamaah JOIN paket_umroh pu ON pu.id_paket = pm.id_paket AND pu.tanggal_berangkat <= NOW() 
                AND pu.tanggal_berangkat >= '$tglAwal' AND pu.komisi_poin > 0 SET pm.poin_counted = 1";
        $this->db->query($sql);

        $this->db->trans_complete();
    }
}