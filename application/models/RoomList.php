<?php

class RoomList extends CI_Model {

    public function getRooms($idPaket) {
        $this->db->where('id_paket', $idPaket);
        $this->db->where('room_number <>', '');
        $this->db->group_by('room_number');
        $query = $this->db->get('program_member');
        $result = $query->result();
        if (empty($result)) {
            return $result;
        }
        $this->load->model('registrasi');
        $rooms = array();
        foreach ($result as $r) {
            $rooms[]['room_number'] = $r->room_number;
        }
        foreach ($rooms as $key => $r) {
            $this->db->where('room_number', $r['room_number']);
            $this->db->where('id_paket', $idPaket);
            $query = $this->db->get('program_member');
            $result = $query->result();
            $rooms[$key]['member'] = $result;
            foreach ($result as $key2 => $res) {
                $jamaah = $this->registrasi->getJamaah($res->id_jamaah);
                $rooms[$key]['member'][$key2]->detailJamaah = $jamaah;
            }
        }
        return $rooms;
    }
    
    public function deleteMemberRoom($idMember){
        $this->db->where('id_member', $idMember);
        $this->db->set('room_number', null);
        $query = $this->db->update('program_member');
        if($query == false){
            return false;
        }
        ////add log
        $this->load->model('logs');
        $this->logs->addLog('pm', $idMember);
        return true;
    }

    public function updateMemberRoom($id_member, $room_number) {
        $this->db->where('id_member', $id_member);
        $this->db->set('room_number', $room_number);
        $this->db->update('program_member');
        return true;
    }

}
