<?php

class Region extends CI_Model {

    public function getProvince($id = null) {
        if ($id != null) {
            $this->db->where('id', $id);
        }
        $query = $this->db->get('provinces');
        $result = $query->result();
        if (!empty($result)) {
            if ($id != null) {
                $result = $result[0];
            }
        }else{
            $result = array();
        }
        return $result;
    }
    
    public function getRegency($id=null, $idProv=null){
        if($id != null){
            $this->db->where('id', $id);
        }
        if($idProv != null){
            $this->db->where('province_id', $idProv);
        }
        $query = $this->db->get('regencies');
        $result = $query->result();
        if(!empty($result)){
            if($id != null){
                $result = $result[0];
            }
        }else{
            $result = array();
        }
        return $result;
    }
    
    public function getDistrict($id=null, $idReg=null){
        if($id != null){
            $this->db->where('id', $id);
        }
        if($idReg != null){
            $this->db->where('regency_id', $idReg);
        }
        $query = $this->db->get('districts');
        $result = $query->result();
        if(!empty($result)){
            if($id != null){
                $result = $result[0];
            }
        }else{
            $result = array();
        }
        return $result;
    }
    
    public function getRegionAutoComplete($term){
        $this->db->like('name',$term);
        $this->db->limit(15);
        $query = $this->db->get('regencies');
        $result = $query->result();
        $data = array();
        foreach($result as $r){
            $data[] = $r->name;
        }
        return $data;
    }

    public function getKantorImigrasi($term){
        $this->db->like('nama_kantor',$term);
        $this->db->limit(5);
        $query = $this->db->get('kantor_imigrasi');
        $result = $query->result();
        $data = array();
        foreach($result as $r){
            $data[] = $r->nama_kantor;
        }
        return $data;
    }

    public function getTtdBasah($kantor) {
        $this->db->like('nama_kantor', $kantor);
        $kantorImigrasi = $this->db->get('kantor_imigrasi')->row();
        if (empty($kantorImigrasi)) {
            // echo '<pre>';
            // print_r('here');
            // exit();
            $num = 0;
            return $num;
        }
        if ($kantorImigrasi->ttd_basah == 0) {
            $num = 0;
        } else {
            $num = 1;
        }
        return $num;
    }

    public function getKabupaten() {
        $query = $this->db->get('regencies');
        $data = $query->result();
        return $data;
    }
    
    public function getCountries($id = null){
        if($id != null){
            $this->db->where('id', $id);
        }
        $query = $this->db->get('countries');
        $result = $query->result();
        if(!empty($result)){
            if($id != null){
                $result = $result[0];
            }
        }else{
            $result = array();
        }
        return $result;
    }

    public function getCountriesAutoComplete($term){
        $this->db->like('country_name',$term);
        $this->db->limit(5);
        $query = $this->db->get('countries');
        $result = $query->result();
        $data = array();
        foreach($result as $r){
            $data[] = $r->country_name;
        }
        return $data;
    }

}