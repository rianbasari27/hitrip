<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Blast_wa extends CI_Controller {

    public function index() {
        $this->load->model('Whatsapp');
        $this->db->from('program_member');
        $this->db->where('id_paket', $_GET['id']);
        $this->db->select("CASE WHEN parent_id IS NOT NULL THEN parent_id ELSE id_member END as group_column", FALSE);
        $this->db->group_by('group_column');

        // $this->db->group_end();
        // $this->db->group_by('CASE WHEN a.parent_id IS NOT NULL THEN a.parent_id ELSE a.id_member END');
        
        $jamaah = $this->db->get()->result();
        foreach ($jamaah as $j) {
            $id_secret = md5($j->group_column.'ventourapp');
            $link = $j->group_column . "_" . $id_secret;
            $result = $this->Whatsapp->sendTagihanPelunasan($j->group_column, $link);
        }
        if ($result != true) {
            $this->alert->set('danger', 'Gagal mengirim pesan !!');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->alert->set('success', 'Pesan berhasil terkirim');
        redirect($_SERVER['HTTP_REFERER']);
    }
}