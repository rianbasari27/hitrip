<?php

class StoreModel extends CI_Model {

    public function addProduct($data) {
        if ($data == null) {
            return false;
        }
        if ($this->db->insert('store', $data)) {
            $this->alert->set('success', 'Produk berhasil ditambahkan');
        } else {
            $this->alert->set('danger', 'System Error, silakan coba kembali');
            return false;
        }
    }

}