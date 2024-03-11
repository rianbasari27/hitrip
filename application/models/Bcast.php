<?php

class Bcast extends CI_Model {

    public function getPesan($id, $idPaket = null, $status = null) {
        if ($id != null) {
            $this->db->where('id_broadcast', $id);
        }
        if ($idPaket != null) {
            $this->db->where('id_paket', $idPaket);
        }
        if ($status != null) {
            $this->db->where('tampilkan', $status);
        }
        $this->db->order_by('tanggal_post', 'desc');
        $query = $this->db->get('broadcast');
        if ($id != null) {
            $result = $query->row();
        } else {
            $result = $query->result();
        }
        return $result;
    }

    public function getPesanAgen($id_broadcast = null, $id_agen = null, $status = null, $group_by = null) {
        $this->db->select('*');
        $this->db->from('broadcast_agen');
        $this->db->join('bcast_agen', 'bcast_agen.id_broadcast = broadcast_agen.id_broadcast');

        if ($id_broadcast != null) {
            $this->db->where('broadcast_agen.id_broadcast', $id_broadcast);
        }

        if ($id_agen != null) {
            $this->db->where('bcast_agen.id_agen', $id_agen);
        }

        if ($status == 1) {
            $this->db->where('broadcast_agen.tampilkan', $status);
        }

        if ($group_by == 1) {
            $this->db->group_by('bcast_agen.id_broadcast');
        }
        $this->db->order_by('broadcast_agen.tanggal_post', 'desc');
        $query = $this->db->get();

        return $query->result();
    }

    public function addPost($post) {
        $this->db->insert('broadcast', $post);
        if ($post['tampilkan'] == 1 ) {
            $this->load->model('Notification');
            $this->Notification->sendBroadcastMessage($post['id_paket'], $post['judul'], base_url() . 'jamaah/home');
        }
        return true;
    }

    public function getPesanForWhatsapp($id_paket) {
        $this->db->select('*');
        $this->db->from('program_member pm');
        $this->db->join('jamaah j', 'j.id_jamaah = pm.id_jamaah');
        $this->db->join('paket_umroh pu', 'pm.id_paket = pu.id_paket');
        $this->db->where('pu.tanggal_berangkat >=', date('Y-m-d'));
        $this->db->where('pu.id_paket', $id_paket);
        // $this->db->select("CASE WHEN a.parent_id IS NOT NULL THEN a.parent_id ELSE a.id_member END as group_column", FALSE);
        // $this->db->group_by('group_column');
        $result = $this->db->get()->result();

        if (!empty($result)) {
            foreach ($result as $r) {
                $nama = implode(' ', array_filter([$r->first_name, $r->second_name, $r->last_name]));
                $this->load->model('whatsapp');
                $send = $this->whatsapp->sendBroadcast($r->no_wa, $nama);
            }
        }
    }

    public function addPostAgen($post) {
        $data = $post ;
        unset($data['id_agen']);
        if (isset($data['flyer_image'])) {

            $this->load->library('scan');
            $hasil = $this->scan->check($data['flyer_image'], 'flyer_image', null);
            if ($hasil !== false) {
                $data['flyer_image'] = $hasil;
            } else {
                $data['flyer_image'] = null;
            }
            unset($data['files']);
        }
        $this->db->insert('broadcast_agen', $data);

        $insert_id = $this->db->insert_id();
    
        foreach ($post['id_agen'] as $key => $id_agen) {
            $bcast = array(
                'id_broadcast' => $insert_id,
                'id_agen' => $id_agen
            );
            $this->db->insert('bcast_agen', $bcast);
        }
        return true;
    }

    public function updateTampilkan($idBroadcast, $data) {
        $this->db->where('id_broadcast', $idBroadcast);
        $update = $this->db->update('broadcast', $data);
        if ($data['tampilkan'] == 1 ) {
            $this->load->model('Notification');
            $this->Notification->sendBroadcastMessage($data['id_paket'], $data['judul'], base_url() . 'jamaah/home');
        }
        if ($update == true) {
            return true;
        } else {
            return false;
        }
    }

    public function updateTampilkanAgen($id, $data) {
        $this->db->where('id_broadcast', $id);
        if (isset($data['flyer_image'])) {

            $this->load->library('scan');
            $hasil = $this->scan->check($data['flyer_image'], 'flyer_image', null);
            if ($hasil !== false) {
                $data['flyer_image'] = $hasil;
            } else {
                $data['flyer_image'] = null;
            }
            unset($data['files']);
        }
        $update = $this->db->update('broadcast_agen', $data);
        if ($update == true) {
            return true;
        } else {
            return false;
        }
    }

    public function deletePost($id) {
        $this->db->where('id_broadcast', $id);
        $query = $this->db->delete('broadcast');
        if ($query == false) {
            return false;
        } else {
            return true;
        }
    }

    public function deletePostAgen($id) {
        $this->db->where('id_broadcast', $id);
        $del_broadcast_agen = $this->db->delete('broadcast_agen');
        $this->db->where('id_broadcast', $id);
        $del_bcast_agen = $this->db->delete('bcast_agen');
        if ($del_broadcast_agen == false || $del_bcast_agen == false) {
            return false;
        } else {
            return true;
        }
    }

    public function deleteFlyer($id)
    {
        $bc = $this->getPesanAgen($id);
        if (empty($bc)) {
            return false;
        }

        // ambil data sesudahnya
        $this->db->where('id_broadcast', $id);
        $before = $this->db->get('broadcast_agen')->row();
        //////////////////////////////////

        $bc = $bc[0];
        $path = $bc->flyer_image;
        unlink(SITE_ROOT . $path);

        $this->db->where('id_broadcast', $id);
        $this->db->set('flyer_image', null);
        $query = $this->db->update('broadcast_agen');
        if ($query == true) {
            // ambil data sesudahnya
            // $this->db->where('id_broadcast', $id);
            // $after = $this->db->get('broadcast_agen')->row();
            //////////////////////////////////
            // $this->load->model('logs');
            // $this->logs->addLogTable($id, 'pm', $before, $after);
            return true;
        } else {
            return false;
        }
    }

}