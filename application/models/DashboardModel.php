<?php

class DashboardModel extends CI_Model
{
    public function getDetailPerlengkapan($id_paket = NULL) {
        $this->db->select('id_paket, nama_paket, tanggal_berangkat, jumlah_seat');
        if ($id_paket != NULL) {
            $this->db->where('id_paket', $id_paket);
        }
        $this->db->where('tanggal_berangkat >=', date('Y-m-d'));
        $this->db->order_by('tanggal_berangkat', 'asc');
        $query = $this->db->get('paket_umroh');
        $data = $query->result();
        
        foreach ($data as $key => $d) {
            //sisa_seat status
            $this->db->where('id_paket', $d->id_paket);
            $member = $this->db->get('program_member')->result();
            $count_member = count($member);
            $data[$key]->sisa_seat = $d->jumlah_seat - $count_member;

            $this->db->where('id_paket', $d->id_paket);
            $jamaah = $this->db->get('program_member')->result();
            if (empty($jamaah)) {
                $data[$key]->total_jamaah = 0;
            } 
            else {
                $data[$key]->total_jamaah = count($jamaah);
            }

            $data[$key]->sudah_semua = $this->getSudahDiambil($d->id_paket)['SudahDiambil'];
            $data[$key]->sudah_sebagian = $this->getSebagianSudah($d->id_paket)['SebagianSudah'];
            $data[$key]->belum_ambil = $this->getBelumDiambil($d->id_paket)['BelumDiambil'];
        }

        return $data;
    }

    public function getSebagianSudah($idPaket) {
        $this->db->select("SUM(
            CASE WHEN
                DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), IFNULL(b.tanggal_lahir,'0000-00-00'))), '%Y') <= 2 
            THEN 
                CASE WHEN (SELECT COUNT(*) FROM perlengkapan_member perl_memb WHERE perl_memb.id_member = a.id_member) > 0 AND (SELECT COUNT(*) FROM perlengkapan_member perl_memb WHERE perl_memb.id_member = a.id_member) < (SELECT COUNT(*) FROM perlengkapan_paket perl_paket WHERE perl_paket.id_paket = a.id_paket AND jumlah_bayi = 1) THEN 1 ELSE 0 END
            WHEN 
                DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), IFNULL(b.tanggal_lahir,'0000-00-00'))), '%Y') > 2 AND DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), IFNULL(b.tanggal_lahir,'0000-00-00'))), '%Y') <= 6
            THEN
                CASE WHEN 
                    b.jenis_kelamin = 'L'
                THEN
                    CASE WHEN (SELECT COUNT(*) FROM perlengkapan_member perl_memb WHERE perl_memb.id_member = a.id_member) > 0 AND (SELECT COUNT(*) FROM perlengkapan_member perl_memb WHERE perl_memb.id_member = a.id_member) < (SELECT COUNT(*) FROM perlengkapan_paket perl_paket WHERE perl_paket.id_paket = a.id_paket AND jumlah_anak_pria = 1) THEN 1 ELSE 0 END
                WHEN 
                    b.jenis_kelamin = 'P'
                THEN
                    CASE WHEN (SELECT COUNT(*) FROM perlengkapan_member perl_memb WHERE perl_memb.id_member = a.id_member) > 0 AND (SELECT COUNT(*) FROM perlengkapan_member perl_memb WHERE perl_memb.id_member = a.id_member) < (SELECT COUNT(*) FROM perlengkapan_paket perl_paket WHERE perl_paket.id_paket = a.id_paket AND jumlah_anak_wanita = 1) THEN 1 ELSE 0 END
                ELSE
                    CASE WHEN (SELECT COUNT(*) FROM perlengkapan_member perl_memb WHERE perl_memb.id_member = a.id_member) > 0 AND (SELECT COUNT(*) FROM perlengkapan_member perl_memb WHERE perl_memb.id_member = a.id_member) < (SELECT COUNT(*) FROM perlengkapan_paket perl_paket WHERE perl_paket.id_paket = a.id_paket AND jumlah_anak_wanita = 1) THEN 1 ELSE 0 END
                END
            ELSE
                CASE WHEN 
                    b.jenis_kelamin = 'L'
                THEN
                    CASE WHEN (SELECT COUNT(*) FROM perlengkapan_member perl_memb WHERE perl_memb.id_member = a.id_member) > 0 AND (SELECT COUNT(*) FROM perlengkapan_member perl_memb WHERE perl_memb.id_member = a.id_member) < (SELECT COUNT(*) FROM perlengkapan_paket perl_paket WHERE perl_paket.id_paket = a.id_paket AND jumlah_pria = 1) THEN 1 ELSE 0 END
                WHEN 
                    b.jenis_kelamin = 'P'
                THEN
                    CASE WHEN (SELECT COUNT(*) FROM perlengkapan_member perl_memb WHERE perl_memb.id_member = a.id_member) > 0 AND (SELECT COUNT(*) FROM perlengkapan_member perl_memb WHERE perl_memb.id_member = a.id_member) < (SELECT COUNT(*) FROM perlengkapan_paket perl_paket WHERE perl_paket.id_paket = a.id_paket AND jumlah_wanita = 1) THEN 1 ELSE 0 END
                ELSE
                    CASE WHEN (SELECT COUNT(*) FROM perlengkapan_member perl_memb WHERE perl_memb.id_member = a.id_member) > 0 AND (SELECT COUNT(*) FROM perlengkapan_member perl_memb WHERE perl_memb.id_member = a.id_member) < (SELECT COUNT(*) FROM perlengkapan_paket perl_paket WHERE perl_paket.id_paket = a.id_paket AND jumlah_wanita = 1) THEN 1 ELSE 0 END
                END
            END
                    
            ) AS SebagianSudah", false);

        $this->db->from('program_member a');
        $this->db->join('jamaah b', 'ON a.id_jamaah = b.id_jamaah');
        $this->db->where('a.id_paket', $idPaket);
        return $this->db->get()->row_array();
    }

    public function getSudahDiambil($idPaket) {
        $this->db->select("SUM(
            CASE WHEN
                DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), IFNULL(b.tanggal_lahir,'0000-00-00'))), '%Y') <= 2 
            THEN 
                CASE WHEN (SELECT COUNT(*) FROM perlengkapan_member perl_memb WHERE perl_memb.id_member = a.id_member) >= (SELECT COUNT(*) FROM perlengkapan_paket perl_paket WHERE perl_paket.id_paket = a.id_paket AND jumlah_bayi = 1) THEN 1 ELSE 0 END
            WHEN 
                DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), IFNULL(b.tanggal_lahir,'0000-00-00'))), '%Y') > 2 AND DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), IFNULL(b.tanggal_lahir,'0000-00-00'))), '%Y') <= 6
            THEN
                CASE WHEN 
                    b.jenis_kelamin = 'L'
                THEN
                    CASE WHEN (SELECT COUNT(*) FROM perlengkapan_member perl_memb WHERE perl_memb.id_member = a.id_member) >= (SELECT COUNT(*) FROM perlengkapan_paket perl_paket WHERE perl_paket.id_paket = a.id_paket AND jumlah_anak_pria = 1) THEN 1 ELSE 0 END
                WHEN 
                    b.jenis_kelamin = 'P'
                THEN
                    CASE WHEN (SELECT COUNT(*) FROM perlengkapan_member perl_memb WHERE perl_memb.id_member = a.id_member) >= (SELECT COUNT(*) FROM perlengkapan_paket perl_paket WHERE perl_paket.id_paket = a.id_paket AND jumlah_anak_wanita = 1) THEN 1 ELSE 0 END
                ELSE
                    CASE WHEN (SELECT COUNT(*) FROM perlengkapan_member perl_memb WHERE perl_memb.id_member = a.id_member) >= (SELECT COUNT(*) FROM perlengkapan_paket perl_paket WHERE perl_paket.id_paket = a.id_paket AND jumlah_anak_wanita = 1) THEN 1 ELSE 0 END
                END
            ELSE
                CASE WHEN 
                    b.jenis_kelamin = 'L'
                THEN
                    CASE WHEN (SELECT COUNT(*) FROM perlengkapan_member perl_memb WHERE perl_memb.id_member = a.id_member) >= (SELECT COUNT(*) FROM perlengkapan_paket perl_paket WHERE perl_paket.id_paket = a.id_paket AND jumlah_pria = 1) THEN 1 ELSE 0 END
                WHEN 
                    b.jenis_kelamin = 'P'
                THEN
                    CASE WHEN (SELECT COUNT(*) FROM perlengkapan_member perl_memb WHERE perl_memb.id_member = a.id_member) >= (SELECT COUNT(*) FROM perlengkapan_paket perl_paket WHERE perl_paket.id_paket = a.id_paket AND jumlah_wanita = 1) THEN 1 ELSE 0 END
                ELSE
                    CASE WHEN (SELECT COUNT(*) FROM perlengkapan_member perl_memb WHERE perl_memb.id_member = a.id_member) >= (SELECT COUNT(*) FROM perlengkapan_paket perl_paket WHERE perl_paket.id_paket = a.id_paket AND jumlah_wanita = 1) THEN 1 ELSE 0 END
                END
            END
            ) AS SudahDiambil", false);

        $this->db->from('program_member a');
        $this->db->join('jamaah b', 'ON a.id_jamaah = b.id_jamaah');
        $this->db->where('a.id_paket', $idPaket);
        return $this->db->get()->row_array();
    }

    public function getBelumDiambil($idPaket) {
        $this->db->select("SUM(
            CASE WHEN
                DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), IFNULL(b.tanggal_lahir,'0000-00-00'))), '%Y') <= 2 
            THEN 
                CASE WHEN (SELECT COUNT(*) FROM perlengkapan_member perl_memb WHERE perl_memb.id_member = a.id_member) = 0 THEN 1 ELSE 0 END
            WHEN 
                DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), IFNULL(b.tanggal_lahir,'0000-00-00'))), '%Y') > 2 AND DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), IFNULL(b.tanggal_lahir,'0000-00-00'))), '%Y') <= 6
            THEN
                CASE WHEN 
                    b.jenis_kelamin = 'L'
                THEN
                    CASE WHEN (SELECT COUNT(*) FROM perlengkapan_member perl_memb WHERE perl_memb.id_member = a.id_member) = 0 THEN 1 ELSE 0 END
                WHEN 
                    b.jenis_kelamin = 'P'
                THEN
                    CASE WHEN (SELECT COUNT(*) FROM perlengkapan_member perl_memb WHERE perl_memb.id_member = a.id_member) = 0 THEN 1 ELSE 0 END
                ELSE
                    CASE WHEN (SELECT COUNT(*) FROM perlengkapan_member perl_memb WHERE perl_memb.id_member = a.id_member) = 0 THEN 1 ELSE 0 END
                END
            ELSE
                CASE WHEN 
                    b.jenis_kelamin = 'L'
                THEN
                    CASE WHEN (SELECT COUNT(*) FROM perlengkapan_member perl_memb WHERE perl_memb.id_member = a.id_member) = 0 THEN 1 ELSE 0 END
                WHEN 
                    b.jenis_kelamin = 'P'
                THEN
                    CASE WHEN (SELECT COUNT(*) FROM perlengkapan_member perl_memb WHERE perl_memb.id_member = a.id_member) = 0 THEN 1 ELSE 0 END
                ELSE
                    CASE WHEN (SELECT COUNT(*) FROM perlengkapan_member perl_memb WHERE perl_memb.id_member = a.id_member) = 0 THEN 1 ELSE 0 END                        
                END
            END
            ) AS BelumDiambil", false);

        $this->db->from('program_member a');
        $this->db->join('jamaah b', 'ON a.id_jamaah = b.id_jamaah');
        $this->db->where('a.id_paket', $idPaket);
        return $this->db->get()->row_array();
    }


    public function getInfoSeat($id_paket = NULL) {
        $this->db->select('id_paket, nama_paket, tanggal_berangkat, jumlah_seat');
        if ($id_paket != NULL) {
            $this->db->where('id_paket', $id_paket);
        }
        $this->db->where('tanggal_berangkat >=', date('Y-m-d'));
        $this->db->where('publish', 1);
        $this->db->order_by('tanggal_berangkat', 'asc');
        $query = $this->db->get('paket_umroh');
        $data = $query->result();
        foreach ($data as $key => $d) {
            $this->db->where('id_paket', $d->id_paket);
            $member = $this->db->get('program_member')->result();
            $count_member = count($member);
            $data[$key]->sisa_seat = $d->jumlah_seat - $count_member;

            $this->db->where([
                'id_paket' => $d->id_paket,
                'lunas' => "0"
            ]);
            $jamaahBelumBayar = $this->db->get('program_member')->result();
            
            $this->db->where([
                'id_paket' => $d->id_paket,
                'lunas' => "1"
            ]);
            $jamaahLunas = $this->db->get('program_member')->result();
            
            $this->db->where([
                'id_paket' => $d->id_paket,
                'lunas' => "2"
            ]);
            $jamaahCicil = $this->db->get('program_member')->result();
            
            $jamaahLebihBayar = $this->db->where([
                'id_paket' => $d->id_paket,
                'lunas' => "3"
            ]);
            $jamaahLebihBayar = $this->db->get('program_member')->result();

            $data[$key]->total_belum_lunas = count($jamaahBelumBayar);
            $data[$key]->total_lunas = count($jamaahLunas);
            $data[$key]->total_cicil = count($jamaahCicil);
            $data[$key]->total_lebih = count($jamaahLebihBayar);
        }

        return $data;
    }
}