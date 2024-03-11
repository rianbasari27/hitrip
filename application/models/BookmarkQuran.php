<?php

class BookmarkQuran extends CI_Model {

    public function bookmarkAyat($data) {
		if ($data['user_id'] == null || $data['ayat'] == null || $data['no_surat'] == null) {
			return false;
		}
        $this->db->where('user_id', $data['user_id']);
        $bookmark = $this->db->get('bookmark_quran')->row();
        if (!empty($bookmark)) {
            $this->db->set('ayat', $data['ayat']);
            $this->db->set('no_surat', $data['no_surat']);
            $this->db->where('user_id', $data['user_id']);
            $this->db->update('bookmark_quran');
            return $result = ['ayat' => $data['ayat'], 'no_surat' => $data['no_surat']];
        } else {
            $insData = $data;
            if ($this->db->insert('bookmark_quran', $insData)) {
                return $result = ['ayat' => $data['ayat'], 'no_surat' => $data['no_surat']];
                $this->alert->set('success', 'Hotel berhasil ditambahkan');
            } else {
                $this->alert->set('danger', 'System Error, silakan coba kembali');
                return false;
            }
        }
	}

    public function getBookmarkQuran($user_id) {
        if ($user_id == null) {
            return false;   
        }
        $this->db->where('user_id', $user_id);
        $data = $this->db->get('bookmark_quran')->row();
        return $data;
    }
}