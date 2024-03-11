<?php

class PoinAgen extends CI_Model {
    
    public function aturUlang($idAgen, $uncl, $cl, $ket){
        //check if agen exist
        $this->load->model('agen');
        $agen = $this->agen->getAgen($idAgen);
        if(empty($agen)){
            return false;
        }
        
        //change the point in agent table
        $this->db->where('id_agen', $idAgen);
        $data = array(
            'unclaimed_point' => $uncl,
            'claimed_point' => $cl
        );
        $up = $this->db->update('agen', $data);
        if($up == false){
            return false;
        }
        
        //add the history list
        
        //unclaimed point add
        $data = array(
            'id_agen' => $idAgen,
            'poin' => $uncl,
            'jenis' => 3,
            'tanggal' => date("Y-m-d"),
            'keterangan' => $ket
        );
        $ins = $this->db->insert('agen_poin', $data);
        if($ins == false){
            return false;
        }
        
        //claimed point add
        $data['poin'] = $cl;
        $data['jenis'] = 4;
        $ins = $this->db->insert('agen_poin', $data);
        if($ins == false){
            return false;
        }
        return true;
    }
    
    public function getHistory($idAgen){
        //check if agen exist
        $this->load->model('agen');
        $agen = $this->agen->getAgen($idAgen);
        if(empty($agen)){
            return array(
                'status' => 'error',
                'msg' => 'Data Tidak Ditemukan.'
            );
        }

        //get history
        $this->db->where('id_agen', $idAgen);
        $this->db->order_by('tanggal', 'DESC');
        $this->db->order_by('id_poin', 'DESC');
        $query = $this->db->get('agen_poin');
        $data = $query->result();     
        $dataMod = array();
        foreach($data as $key => $d){
            $dataMod[$key] = $d;
            $jenisText = '';
            switch ($d->jenis) {
                case 1:
                    $jenisText = 'Penambahan Poin';
                    break;
                case 2:
                    $jenisText = 'Penukaran poin dengan Reward';
                    break;
                case 3:
                    $jenisText = 'Penyesuaian Unclaimed Point';
                    break;
                case 4:
                    $jenisText = 'Penyesuaian Claimed Point';
            }
            $dataMod[$key]->jenisText = $jenisText;
        }
        return array(
            'status' => 'success',
            'data' => $dataMod
        );
    }
    
    public function klaimReward($idAgen, $point, $ket){
        //check if agen exist
        $this->load->model('agen');
        $agen = $this->agen->getAgen($idAgen);
        if(empty($agen)){
            return array(
                'status' => 'error',
                'msg' => 'Data Tidak Ditemukan.'
            );
        }
        $profile = $agen[0];
        $uncl = $profile->unclaimed_point;
        $cl = $profile->claimed_point;
        if($point > $uncl){
            return array(
                'status'=> 'error',
                'msg' => 'Klaim reward gagal dilakukan. Poin tidak cukup.'
            );
        }
        
        //update agent table
        $newUncl = $uncl - $point;
        $newCl = $cl + $point;
        $this->db->where('id_agen', $idAgen);
        $upData = array(
            'unclaimed_point' => $newUncl,
            'claimed_point' => $newCl
        );
        $up = $this->db->update('agen', $upData);
        if($up == false){
            return array(
                'status' => 'error',
                'msg' => 'Klaim reward gagal. Tidak dapat menyimpan data.'
            );
        }
        
        //insert to history
        $insData = array(
            'id_agen' => $idAgen,
            'poin' => $point,
            'jenis' => 2,
            'tanggal' => date("Y-m-d"),
            'keterangan' => $ket
        );
        $ins = $this->db->insert('agen_poin', $insData);
        if($ins == false){
            return array(
                'status' => 'error',
                'msg' => 'Data history gagal disimpan.'
            );
        }
        
        return array(
            'status' => 'success',
            'msg' => 'Klaim reward berhasil dilakukan. Sisa Poin '. $newUncl
        );
        
        
    }
}

