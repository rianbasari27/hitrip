<?php

class Chat extends CI_Model {

    public function send($id_staff, $message) {
        $data = array(
            'id_staff' => $id_staff,
            'pesan' => $message
        );
        $this->db->insert('chat', $data);
        return true;
    }

    public function getMessages($limit) {
        $this->db->select('*');
        $this->db->from('chat');
        $this->db->join('staff', 'chat.id_staff = staff.id_staff');
        $this->db->order_by('chat.tanggal_post', 'desc');
        $this->db->limit($limit);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    public function deleteLastSent($idStaff){
        $this->db->where('id_staff', $idStaff);
        $this->db->order_by('tanggal_post','desc');
        $query = $this->db->get('chat',1);
        $msg = $query->row();
        if(empty($msg)){
            return true;
        }
        $id = $msg->id_chat;
        $this->db->where('id_chat', $id);
        $this->db->delete('chat');
        return true;
    
    }

}
