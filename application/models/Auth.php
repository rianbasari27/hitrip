<?php

class Auth extends CI_Model
{
    public function checkPembayaran($id_member, $id_pembayaran) {
        $this->load->model('tarif');
        $tarif = $this->tarif->getPembayaranById($id_pembayaran);
        if (empty($tarif)) {
            return false ;
        }

        $checkId = $this->checkMember($id_member, $tarif->id_member);
        return $checkId ;

    } 

    public function checkMember($id_member, $id_check) {
        if ($id_member == $id_check) {
            return true ;
        }

        $this->db->where('id_member', $id_member);
        $member = $this->db->get('program_member')->row();
        if (empty($member)) {
            return false ;
        }

        $parentId = $member->parent_id;
        if ($parentId == null ) {
            return false ;
        }

        $this->db->where('id_member', $id_check);
        $check = $this->db->get('program_member')->row();
        if (empty($check)) {
            return false ;
        }
        $parentCheck = $check->parent_id;
        if ($parentCheck == null) {
            return false ;
        }

        if ($parentId == $parentCheck) {
            return true ;
        } else {
            return false ;
        }
    }

    public function checkMemberAgen($id_agen, $id_member) {
        $this->db->where('id_member', $id_member);
        $member = $this->db->get('program_member')->row();
        if (empty($member)) {
            return false;
        }

        $id_check = $member->id_agen;
        if ($id_check == NULL || $id_check == '') {
            return false;
        }

        if ($id_agen == $id_check) {
            return true;
        } else {
            return false;
        }
    }

    public function checkRequest($id_member, $id_request) {
        $this->db->where('id_request', $id_request);
        $request = $this->db->get('request_dokumen')->row();
        if (empty($request)) {
            return false;
        }

        
        $checkIdRequest = $this->checkMember($id_member, $request->id_member);
        if (!$checkIdRequest) {
            return false ;
        } else {
            return true ;
        }

    }

    public function checkCuti($id_member, $id_req_cuti) {
        $this->db->where('id_req_cuti', $id_req_cuti);
        $request = $this->db->get('request_cuti')->row();
        if (empty($request)) {
            return false;
        }

        
        $checkIdRequest = $this->checkMember($id_member, $request->id_member);
        if (!$checkIdRequest) {
            return false ;
        } else {
            return true ;
        }

    }
}