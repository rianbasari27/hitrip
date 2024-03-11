<?php

class AgenPaket extends CI_Model
{
    public function getPeserta($idPaket = null, $idPeserta = null, $idAgen = null)
    {
        if ($idPaket && $idPeserta && $idAgen == null) {
            return false;
        }
        if ($idPaket) {
            $this->db->where('id_agen_paket', $idPaket);
        }
        if ($idPeserta) {
            $this->db->where('id_agen_peserta', $idPeserta);
        }
        if ($idAgen) {
            $this->db->where('id_agen', $idAgen);
        }
        $this->db->order_by('id_agen_peserta', 'DESC');
        $result = $this->db->get('agen_peserta_paket')->result();
        if (!empty($result[0])) {
            $agenPaket = $this->getAgenPackage($result[0]->id_agen_paket, false);
            $result[0]->agenPaket = $agenPaket;
            if (empty($result[0]->va_open)) {
                $this->load->model('va_model');
                $this->va_model->createVAOpen($result[0]->id_agen_peserta, 'konsultan');
            }
        }
        return $result;
    }
    public function getAgenPesertaEvent($id = null, $idEvent = null, $idPeserta = null, $groupBy = null)
    {
        // if ($id && $idPeserta && $idEvent == null) {
        //     return false;
        // }
        if ($id) {
            $this->db->where('id', $id);
        }
        if ($idPeserta) {
            $this->db->where('id_peserta', $idPeserta);
        }
        if ($idEvent) {
            $this->db->where('id_event', $idEvent);
        }

        if ($groupBy) {
            $this->db->group_by('id_event');
        }
        $result = $this->db->get('agen_peserta_event')->result();
        if (!empty($result)) {
            foreach ($result as $key => $r) {
                $event = $this->getAgenEvent($r->id_event);
                $package = $this->getAgenPackage($event[0]->id_paket);
                $result[$key]->event = $event;
                $result[$key]->package = $package;
            }
        }
        return $result;
    }
    public function getAgenPackage($id = null, $notExpired = false, $active = false, $available = false, $isMember = null)
    {
        if ($id != null) {
            $this->db->where('id', $id);
        }
        // if ($notExpired) {
        //     $this->db->where('tanggal >=', date('Y-m-d'));
        // }
        if ($active !== false) {
            if ($active === 'no') {
                $this->db->where('active', 0);
            } elseif ($active == true) {
                $this->db->where('active', 1);
            }
        }
        if ($isMember != null) {
            // noted 
            // 0 untuk konsultan baru
            // 1 untuk konsultan lama
            // 2 untuk konsultan lama dan baru
            $this->db->where('is_member !=', $isMember);
        }
        $query = $this->db->get('agen_paket');
        $data = $query->result();

        if (!empty($data)) {
            $this->load->library('calculate');

            $lastTrips = array();
            $nextTrip = array();
            $futureTrips = array();

            $this->load->model('registrasi');
            foreach ($data as $key => $d) {


                $this->db->where('id_agen_paket', $d->id);
                $members = $this->db->get('agen_peserta_paket')->result();
                $membersCount = count($members);

                //harga di home jamaah
                $this->load->library('money');
                $data[$key]->hargaPretty = $this->money->format($d->harga);
                $data[$key]->hargaPrettyDiskon = $this->money->format($d->harga - $d->diskon_member_baru);
                $data[$key]->hargaEksJamaahPretty = $this->money->format($d->harga - $d->diskon_eks_jamaah - $d->diskon_member_lama);
                $data[$key]->hargaMemberLamaPretty = $this->money->format($d->harga - $d->diskon_member_lama);
                $data[$key]->hargaEksJamaahPrettySaja = $this->money->format($d->harga - $d->diskon_eks_jamaah);
                $data[$key]->hargaHome = $this->money->hargaHomeFormat($d->harga);
                $data[$key]->hargaHomeDiskon = $this->money->hargaHomeFormat($d->harga - $d->diskon_member_baru);

                //date format
                $this->load->library('date');
                // $data[$key]->tanggalFormat = $this->date->convert_date_indo($d->tanggal);


                //get countdown
                // get tanggal pelunasan
                // $data[$key]->tanggal_pelunasan = date('d F Y', strtotime($d->tanggal . ' -45 day'));

                //reorder
            }
        } else {
            //$this->alert->set('danger', 'Data tidak ada');
            return false;
        }

        if ($id != null) {
            $data = $data[0];
        }
        return $data;
    }

    public function addAgenPackage($data)
    {
        if (isset($data['agen_gambar_banner'])) {

            $this->load->library('scan');
            $hasil = $this->scan->check($data['agen_gambar_banner'], 'agen_gambar_banner', null);
            if ($hasil !== false) {
                $data['agen_gambar_banner'] = $hasil;
            } else {
                $data['agen_gambar_banner'] = null;
            }
            unset($data['files']);
        }

        //check active
        if (!isset($data['active'])) {
            $active = 0;
        } else {
            $active = $data['active'];
        }


        $insData = array(
            'nama_paket' => $data['nama_paket'],
            'harga' => $data['harga'],
            'diskon_member_baru' => $data['diskon_member_baru'],
            'deskripsi_diskon_member_baru' => $data['deskripsi_diskon_member_baru'],
            'diskon_member_lama' => $data['diskon_member_lama'],
            'deskripsi_diskon_member_lama' => $data['deskripsi_diskon_member_lama'],
            'diskon_eks_jamaah' => $data['diskon_eks_jamaah'],
            'deskripsi_diskon_eks_jamaah' => $data['deskripsi_diskon_eks_jamaah'],
            'agen_gambar_banner' => $data['agen_gambar_banner'],
            'active' => $active,
            'is_member' => $data['is_member'],
        );
        // echo '<pre>';
        // print_r($insData);
        // exit();


        if ($this->db->insert('agen_paket', $insData)) {
            $this->alert->set('success', 'Program berhasil ditambahkan.');
        } else {
            $this->alert->set('danger', 'System Error, silakan coba kembali');
            return false;
        }
        // insert id
        $insert_id = $this->db->insert_id();

        // ambil data sesudahnya
        $this->db->where('id', $insert_id);
        $after = $this->db->get('agen_paket')->row();
        //////////////////////////////////
        $this->load->model('logs');
        $this->logs->addLogTable($insert_id, 'ap', null, $after);

        // send notif aplikasi
        // if ($active == 1) {
        //     $this->load->model('Notification');
        //     $this->Notification->sendAgenPackageNotif($insert_id);
        // }

        return $insert_id;
    }

    public function editAgenPackage($id, $data)
    {
        // ambil data sebelumnya
        $this->db->where('id', $id);
        $before = $this->db->get('agen_paket')->row();
        $beforePublish = $before->active;
        //////////////////////////////////
        if (isset($data['agen_gambar_banner'])) {
            $this->load->library('scan');
            $hasil = $this->scan->check($data['agen_gambar_banner'], 'agen_gambar_banner', null);
            if ($hasil !== false) {
                $data['agen_gambar_banner'] = $hasil;
            } else {
                $data['agen_gambar_banner'] = null;
            }
            unset($data['files']);
        }
        //check publish
        if (!isset($data['active'])) {
            $active = 0;
        } else {
            $active = $data['active'];
        }

        $insData = array(
            'nama_paket' => $data['nama_paket'],
            'harga' => $data['harga'],
            'diskon_member_baru' => $data['diskon_member_baru'],
            'deskripsi_diskon_member_baru' => $data['deskripsi_diskon_member_baru'],
            'diskon_member_lama' => $data['diskon_member_lama'],
            'deskripsi_diskon_member_lama' => $data['deskripsi_diskon_member_lama'],
            'diskon_eks_jamaah' => $data['diskon_eks_jamaah'],
            'deskripsi_diskon_eks_jamaah' => $data['deskripsi_diskon_eks_jamaah'],
            'active' => $active,
            'is_member' => $data['is_member'],
        );
        if ($data['agen_gambar_banner']) {
            $insData['agen_gambar_banner'] = $data['agen_gambar_banner'];
        }
        $this->db->where('id', $id);
        if ($this->db->update('agen_paket', $insData)) {
            $this->alert->set('success', 'Program Konsultan berhasil diubah');
        } else {
            $this->alert->set('danger', 'System Error, silakan coba kembali');
            return false;
        }

        // ambil data sesudahnya
        $this->db->where('id', $id);
        $after = $this->db->get('agen_paket')->row();
        $afterPublish = $after->active;
        //////////////////////////////////

        //add log
        $this->load->model('logs');
        $this->logs->addLogTable($id, 'ap', $before, $after);
        // if ($beforePublish == 0 && $afterPublish == 1) {
        //     $this->load->model('Notification');
        //     $this->Notification->sendEditPackageNotif($id);
        // }
        return $id;
    }

    public function getAvailMonths($notExpired = TRUE, $active = false)
    {
        if ($notExpired) {
            $this->db->where('tanggal >=', date('Y-m-d'));
        }
        if ($active !== false) {
            if ($active === 'no') {
                $this->db->where('active', 0);
            } elseif ($active == true) {
                $this->db->where('active', 1);
            }
        }
        // $this->db->order_by('tanggal', 'ASC');
        // $this->db->group_by('MONTH(tanggal)');
        // $this->db->select('tanggal');
        $query = $this->db->get('agen_paket');
        $data = $query->result();
        return $data;
    }

    public function uploadDokumen($file, $id)
    {
        $program = $this->getAgenPackage($id);
        $this->load->library('scan');
        if (isset($file['agen_paket_flyer'])) {
            $fileins = $file['agen_paket_flyer'];
            $jenis = 'agen_paket_flyer';
            if ($program->agen_paket_flyer != null) {
                unlink(SITE_ROOT . $program->agen_paket_flyer);
            }
        } else {
            return false;
        }
        $hasil = $this->scan->check($fileins, $jenis, $id);
        if ($hasil == false) {
            return false;
        }
        $this->db->where('id', $id);
        $update = $this->db->update('agen_paket', array(
            $jenis => $hasil
        ));

        if ($update == false) {
            $this->alert->set('danger', 'File Gagal diupload');
            return false;
        } else {
            $this->alert->set('success', 'File Berhasil diupload');
            return true;
        }
    }

    public function deleteDokumen($id, $field)
    {
        $program = $this->getAgenPackage($id);
        if (empty($program)) {
            return false;
        }

        $path = $program->$field;
        unlink(SITE_ROOT . $path);

        $this->db->where('id', $id);
        $this->db->set($field, null);
        $query = $this->db->update('agen_paket');
        if ($query == true) {
            return true;
        } else {
            return false;
        }
    }


    public function addProgramMember($data, $update = false)
    {

        $this->load->model('agen');
        $id_agen_paket = $data['id_agen_paket'];
        if (isset($data['id_agen'])) {
            $id_agen = $data['id_agen'];
            unset($data['id_agen']);
        } else {
            $id_agen = null;
        }
        unset($data['id_agen_paket']);
        unset($data['status']);
        $program = $this->agenPaket->getAgenPackage($id_agen_paket, false, true, true);
        if (empty($program)) {
            return array(
                'status' => 'danger',
                'msg' => 'Paket sudah tidak tersedia'
            );
        }
        $diskon_member = 0;
        $deskripsi_diskon_member = '';
        $deskripsi_diskon_eks_jamaah = '';
        if ($update == false && $id_agen == null) {
            $data['no_agen'] = rand();
            $result = $this->agen->tambahAgen($data);
            if ($result['status'] == 'success') {
                $id_agen = $result['id_agen'];
            } else {
                return array(
                    'status' => 'danger',
                    'msg' => $result['msg']
                );
            }
            if ($program->diskon_member_baru != null || $program->diskon_member_baru != '' || $program->diskon_member_baru != 0) {
                $diskon_member = $program->diskon_member_baru;
                $deskripsi_diskon_member = $program->deskripsi_diskon_member_baru;
            }
        } else {
            $result = $this->agen->editAgen($id_agen, $data);
            if ($result['status'] != 'success') {
                return array(
                    'status' => 'danger',
                    'msg' => $result['msg']
                );
            }
            if ($program->diskon_member_lama != null || $program->diskon_member_lama != '' || $program->diskon_member_lama != 0) {
                $diskon_member = $program->diskon_member_lama;
                $deskripsi_diskon_member = $program->deskripsi_diskon_member_lama;
            }
        }


        $this->load->model('registrasi');
        $diskon_eksJamaah = 0;
        $jamaah = $this->registrasi->getJamaah(null, $data['no_ktp'], null);
        if (!empty($jamaah->member)) {
            $diskon_eksJamaah = $program->diskon_eks_jamaah;
            $deskripsi_diskon_eks_jamaah = ' | ' . $program->deskripsi_diskon_eks_jamaah;
        }

        $harga_setelah_diskon = $program->harga - $diskon_eksJamaah - $diskon_member;
        $deskripsi_diskon = $deskripsi_diskon_member . $deskripsi_diskon_eks_jamaah;
        $insData = [
            "id_agen_paket" => $id_agen_paket,
            "id_agen" => $id_agen,
            "harga" => $program->harga,
            "harga_setelah_diskon" => $harga_setelah_diskon,
            "deskripsi_diskon" => $deskripsi_diskon,
            "lunas" => 0
        ];
        $hasil = $this->db->insert('agen_peserta_paket', $insData);
        if ($hasil) {

            // ambil data sesudahnya
            $insert_id = $this->db->insert_id();
            $this->load->model('va_model');
            $this->va_model->createVAOpen($insert_id, 'konsultan');
            $this->db->where('id_agen_peserta', $insert_id);
            $after = $this->db->get('agen_peserta_paket')->row();
            //////////////////////////////////
            $this->load->model('logs');
            $this->logs->addLogTable($insert_id, 'agp', null, $after);
            return array(
                'status' => 'success',
                'msg' => 'Berhasil mendaftarkan program',
                'id_agen' => $id_agen
            );
        } else {
            return array(
                'status' => 'danger',
                'msg' => 'Terjadi masalah pada database'
            );
        }
    }

    public function getProgramMember($idPaket = null, $idPeserta = null, $idAgen = null) {
        if ($idPaket && $idPeserta && $idAgen == null) {
            return false;
        }
        if ($idPaket) {
            $this->db->where('id_agen_paket', $idPaket);
        }
        if ($idPeserta) {
            $this->db->where('id_agen_peserta', $idPeserta);
        }
        if ($idAgen) {
            $this->db->where('id_agen', $idAgen);
        }
        $this->db->order_by('tanggal_terdaftar', 'DESC');
        $data = $this->db->get('agen_peserta_paket')->result();
        if (!empty($data)) {
            foreach ($data as $key => $d) {
                $agenPaket = $this->getAgenPackage($d->id_agen_paket, false);
                $data[$key]->agenPaket = $agenPaket;
            }
        } else {
            return false ;
        }
        return $data;
    }

    public function deleteProgramMember($id_agen_peserta = null)
    {
        //delete program member
        if ($id_agen_peserta != null) {
            $this->db->where('id_agen_peserta', $id_agen_peserta);
        }
        if ($this->db->delete('agen_peserta_paket')) {
            $this->alert->set('success', 'Program konsultan berhasil dihapus');
        } else {
            $this->alert->set('danger', 'System Error, silakan coba kembali');
            return false;
        }
        return true;
    }

    public function addAgenEvent($data)
    {

        //check publish
        if (!isset($data['publish'])) {
            $publish = 0;
        } else {
            $publish = $data['publish'];
        }

        //check pax
        if (!isset($data['pax'])) {
            $pax = 45;
        } else {
            $pax = $data['pax'];
        }


        $insData = array(
            'id_paket' => $data['id_paket'],
            'pax' => $pax,
            'tanggal' => $data['tanggal'],
            'tanggal_selesai' => $data['tanggal_selesai'],
            'lokasi' => $data['lokasi'],
            'link_lokasi' => $data['link_lokasi'],
            'publish' => $publish
        );


        if ($this->db->insert('agen_event', $insData)) {
            $this->alert->set('success', 'Event berhasil ditambahkan.');
        } else {
            $this->alert->set('danger', 'System Error, silakan coba kembali');
            return false;
        }
        // insert id
        $insert_id = $this->db->insert_id();

        // ambil data sesudahnya
        $this->db->where('id', $insert_id);
        $after = $this->db->get('agen_event')->row();
        //////////////////////////////////
        $this->load->model('logs');
        $this->logs->addLogTable($insert_id, 'ae', null, $after);

        // send notif aplikasi
        // if ($active == 1) {
        //     $this->load->model('Notification');
        //     $this->Notification->sendAgenPackageNotif($insert_id);
        // }

        return $insert_id;
    }

    public function updateAgenEvent($data)
    {
        // ambil data sesudahnya
        $this->db->where('id', $data['id']);
        $before = $this->db->get('agen_event')->row();
        //////////////////////////////////

        
        //check publish
        if (!isset($data['publish'])) {
            $publish = 0;
        } else {
            $publish = $data['publish'];
        }

        //check pax
        if (!isset($data['pax'])) {
            $pax = 45;
        } else {
            $pax = $data['pax'];
        }


        $insData = array(
            'id_paket' => $data['id_paket'],
            'pax' => $pax,
            'tanggal' => $data['tanggal'],
            'tanggal_selesai' => $data['tanggal_selesai'],
            'lokasi' => $data['lokasi'],
            'link_lokasi' => $data['link_lokasi'],
            'publish' => $publish
        );

        $this->db->where('id', $data['id']);
        if ($this->db->update('agen_event', $insData)) {
            $this->alert->set('success', 'Event berhasil ditambahkan.');
        } else {
            $this->alert->set('danger', 'System Error, silakan coba kembali');
            return false;
        }

        // ambil data sesudahnya
        $this->db->where('id', $data['id']);
        $after = $this->db->get('agen_event')->row();
        //////////////////////////////////
        $this->load->model('logs');
        $this->logs->addLogTable($data['id'], 'ae', $before, $after);

        // send notif aplikasi
        // if ($active == 1) {
        //     $this->load->model('Notification');
        //     $this->Notification->sendAgenPackageNotif($insert_id);
        // }

        return $data['id'];
    }

    public function getAgenEvent($id = null, $idPaket = null) {
        if ($id != null) {
            $this->db->where('id', $id);
        }

        if ($idPaket != null) {
            $this->db->where('id_paket', $idPaket);
        }
        $this->db->order_by('tanggal', 'DESC');
        $result = $this->db->get('agen_event')->result();

        return $result;
    }

    public function deleteAgenEvent($id) {
        // hapus data di agen_event
        $this->db->where('id', $id);
        if(!$this->db->delete('agen_event')) {
            return false ;
        }

        $pesertaEvent = $this->getAgenPesertaEvent(null, $id);
        if (!empty($pesertaEvent)) {
            foreach ($pesertaEvent as $p) {
                // hapus data di agen_peserta_event
                $this->deleteAgenPesertaEvent($p->id, $p->id_peserta);
            }
        }

        return true ;
    }

    public function addPesertaAgenEvent($idPaket = null, $idEvent, $limit) {
        if ($idPaket == null) {
            return false;
        }

        $this->db->group_start(); // Membuka kelompok kondisi
        $this->db->where('id_agen_paket', $idPaket);
        $this->db->where('sudah_ikut', 0);
        $this->db->or_where('sudah_ikut', null);
        $this->db->group_end(); // Menutup kelompok kondisi


        $this->db->group_start(); // Membuka kelompok kondisi
        $this->db->where('lunas', 1);
        $this->db->or_where('lunas', 3);
        $this->db->group_end(); // Menutup kelompok kondisi

        $this->db->order_by('tanggal_terdaftar', 'ASC');
        $this->db->limit($limit);
        $data = $this->db->get('agen_peserta_paket')->result();
        if (!empty($data)) {
            foreach ($data as $key => $d) {
                $insData = [
                    'id_event' => $idEvent,
                    'id_peserta' => $d->id_agen_peserta
                ];

                //set sudah_ikut
                if ($this->db->insert('agen_peserta_event', $insData)) {
                    $this->db->where('id_agen_peserta', $d->id_agen_peserta);
                    $this->db->set('sudah_ikut', 1);
                    $this->db->update('agen_peserta_paket');
                }
            }
        } else {
            $data = [
                'msg' => 'danger',
                'desc' => 'Tidak ada antrian'
            ];
            return $data ;
        }

        $data = [
            'msg' => 'success',
            'desc' => 'Data berhasil di isi sesuai antrian'
        ];
        return $data;
    }

    public function deleteAgenPesertaEvent($id, $idPeserta) {
        //hapus data di agen_peserta_event
        $this->db->where('id', $id);
        if (!$this->db->delete('agen_peserta_event')) {
            return false;
        }

        // set sudah ikut di agen_peserta_paket menjadi 0
        $this->db->where('id_agen_peserta', $idPeserta);
        $this->db->set('sudah_ikut', 0);
        if (!$this->db->update('agen_peserta_paket')) {
            return false ;
        }

        return true ;

    }
}