<?php

class Registrasi extends CI_Model
{

    public function daftar($inputs, $fromApp = null, $update = false)
    {
        // if baru registrasi cek apakah seat tersedia
        if (!$update) {
            $this->load->model('paketUmroh');
            $paket = $this->paketUmroh->getPackage($inputs['id_paket'], false, false, false, null, true);
            if (empty($paket)) {
                $this->alert->set('danger', 'Paket tidak tersedia, seat habis.');
                return false;
            }
        }

        if (empty($inputs['no_ktp'])) {
            $this->alert->set('danger', 'Nomor KTP wajib diisi');
            return false;
        }



        //already NIK
        // $isMember = $this->getUser(null, null, null, null, $inputs['no_ktp']);
        // if (isset($isMember->member[0]) && $update == false) {
        //     $memberExistPaket = $isMember->member[0]->paket_info->tanggal_berangkat;
        //     if ($memberExistPaket > date('Y-m-d')) {
        //         $this->alert->set('danger', 'Nomor KTP sudah terdaftar');
        //         return false;
        //     }
        // }
        // already member (by ID)
        $alreadyMember = $this->getUser($inputs['id_user']);
        if (isset($alreadyMember->member[0]) && $update == false) {
            $memberExistPaket = $alreadyMember->member[0]->paket_info->tanggal_berangkat;
            if ($memberExistPaket > date('Y-m-d')) {
                $this->alert->set('danger', 'Akun sudah terdaftar');
                return false;
            }
        }

        $this->load->library('scan');
        $uploadSuccess = true;
        if (isset($inputs['files']['upload_penyakit'])) {
            $hasil = $this->scan->check($inputs['files']['upload_penyakit'], 'upload_penyakit', null);
            if ($hasil !== false) {
                $inputs['upload_penyakit'] = $hasil;
                unlink(SITE_ROOT . $isMember->upload_penyakit);
                $uploadSuccess = true;
            } else {
                $uploadSuccess = false;
            }
        }

        //split program member and jamaah data
        $member = array();
        if (isset($inputs['pernah_umroh'])) {
            $member['pernah_umroh'] = $inputs['pernah_umroh'];
            unset($inputs['pernah_umroh']);
        }
        if (isset($inputs['id_agen'])) {
            $member['id_agen'] = $inputs['id_agen'];
            unset($inputs['id_agen']);
        }

        if (isset($inputs['pilihan_kamar'])) {
            $member['pilihan_kamar'] = $inputs['pilihan_kamar'];
            unset($inputs['pilihan_kamar']);
        }
        if (isset($inputs['id_paket'])) {
            $member['id_paket'] = $inputs['id_paket'];
            unset($inputs['id_paket']);
        }
        unset($inputs['files']);
        //check if no_ktp exist in db
        //notes kalau mau ganti nomor KTP harus ngirim id_jamaah dalam $inputs
        if (isset($inputs['id_user'])) {
            $existPerson = $this->getUser($inputs['id_user']);
        } else {
            $existPerson = $this->getUser(null, null, null, null, $inputs['no_ktp']);
        }
        if ($existPerson) {
            //update
            $id_user = $existPerson->id_user;
            // ambil data sebelumnya
            $this->db->where('id_user', $id_user);
            $before = $this->db->get('user')->row();
            //////////////////////////////////

            $this->db->where('id_user', $id_user);
            $this->db->update('user', $inputs);
        } else {
            //input database
            $this->db->insert('user', $inputs);
            $id_user = $this->db->insert_id();
            $before = null;
        }


        $member['id_user'] = $id_user;
        if ($fromApp) {
            $member['register_from'] = 'app';
            $member['dp_expiry_time'] = date("Y-m-d H:i:s", strtotime('+' . $this->config->item('dp_expiry_hours') . ' hours'));
        }

        // ambil data sesudahnya
        $this->db->where('id_user', $id_user);
        $after = $this->db->get('user')->row();
        //////////////////////////////////

        ////add log
        $this->load->model('logs');
        $this->logs->addLogTable($id_user, 'u', $before, $after);
        $id_member = null;
        if (isset($member['id_paket'])) {
            $id_member = $this->updateMember($member);
            $this->load->model('tarif');
            $this->tarif->calcTariff($id_member);
            $this->registrasi->cekVerified($id_member);
        }
        $this->alert->set('success', 'Data Berhasil di Input');
        if ($id_member != null) {
            return $id_member;
        } else {
            return true;
        }
    }

    public function setAhliWaris($id_member) {
        $jamaah = $this->getJamaah(null, null, $id_member);
        if ($jamaah->member[0]->parent_id == null && $jamaah->member[0]->parent_id == 0 && $jamaah->member[0]->parent_id == '') {
            return false ;
        }
        $parentId = $jamaah->member[0]->parent_id;
        $groupMembers = $this->getGroupMembers($parentId);
        foreach ($groupMembers as $key => $group) {
            if ($key != $id_member) {
                if ($group->jamaahData->nama_ahli_waris != null ) {
                    $this->db->where('id_jamaah', $group->jamaahData->id_jamaah);
                    $this->db->set('nama_ahli_waris', $jamaah->nama_ahli_waris);
                    $this->db->update('jamaah');
                }
                if ($group->jamaahData->no_ahli_waris != null ) {
                    $this->db->where('id_jamaah', $group->jamaahData->id_jamaah);
                    $this->db->set('no_ahli_waris', $jamaah->no_ahli_waris);
                    $this->db->update('jamaah');
                }
                if ($group->jamaahData->alamat_ahli_waris != null ) {
                    $this->db->where('id_jamaah', $group->jamaahData->id_jamaah);
                    $this->db->set('alamat_ahli_waris', $jamaah->alamat_ahli_waris);
                    $this->db->update('jamaah');
                }
            }
        }
        return true;
    }

    public function getBirthdayJamaah($month)
    {
        $this->db->where('MONTH(tanggal_lahir)', $month);
        $this->db->order_by('DAY(tanggal_lahir)', 'asc');
        $query = $this->db->get('jamaah');
        $jamaah = $query->result();
        if (empty($jamaah)) {
            return array();
        }
        $data = array();
        foreach ($jamaah as $j) {
            $data[] = $this->getJamaah($j->id_jamaah);
        }
        return $data;
    }

    public function setParent($id_member, $id_parent)
    {
        $this->db->where('id_member', $id_member);
        $this->db->set('parent_id', $id_parent);
        $this->db->update('program_member');

        $this->db->where('id_member', $id_parent);
        $this->db->set('parent_id', $id_parent);
        $this->db->update('program_member');
        return true;
    }

    public function setAgenParent($id_member, $agen_parent)
    {
        $this->db->where('id_member', $id_member);
        $this->db->set('agen_parent', $agen_parent);
        $this->db->update('program_member');

        $this->db->where('id_member', $agen_parent);
        $this->db->set('agen_parent', $agen_parent);
        $this->db->update('program_member');
        return true;
    }

    public function toggleVerified($id_member)
    {
        $member = $this->getMember($id_member);
        if (empty($member)) {
            return false;
        }
        $member = $member[0];
        $verified = $member->verified;
        $set = 0;
        if ($verified == 0) {
            $set = 1;
        }
        $this->db->where('id_member', $id_member);
        $this->db->set('verified', $set);
        $this->db->update('program_member');

        $this->load->model('logs');
        $this->logs->addLog('pm', $id_member);
        return true;
    }

    public function updateMember($member)
    {
        //TABEL PROGRAM MEMBER
        $uploadSuccess = false;
        $this->load->library('scan');
        if (isset($member['files']['paspor_scan'])) {
            $hasil = $this->scan->check($member['files']['paspor_scan'], 'paspor', $member['id_user']);
            if ($hasil !== false) {
                $member['paspor_scan'] = $hasil;
                $uploadSuccess = true;
            } else {
                $uploadSuccess = false;
            }
        }
        if (isset($member['files']['paspor_scan2'])) {
            $hasil = $this->scan->check($member['files']['paspor_scan2'], 'paspor2', $member['id_user']);
            if ($hasil !== false) {
                $member['paspor_scan2'] = $hasil;
                $uploadSuccess = true;
            } else {
                $uploadSuccess = false;
            }
        }
        if (isset($member['files']['ktp_scan'])) {
            $hasil = $this->scan->check($member['files']['ktp_scan'], 'ktp', $member['id_user']);
            if ($hasil !== false) {
                $member['ktp_scan'] = $hasil;
                $uploadSuccess = true;
            } else {
                $uploadSuccess = false;
            }
        }
        if (isset($member['files']['foto_scan'])) {
            $hasil = $this->scan->check($member['files']['foto_scan'], 'foto', $member['id_user']);
            if ($hasil !== false) {
                $member['foto_scan'] = $hasil;
                $uploadSuccess = true;
            } else {
                $uploadSuccess = false;
            }
        }
        if (isset($member['files']['kk_scan'])) {
            $hasil = $this->scan->check($member['files']['kk_scan'], 'kk', $member['id_user']);
            if ($hasil !== false) {
                $member['kk_scan'] = $hasil;
                $uploadSuccess = true;
            } else {
                $uploadSuccess = false;
            }
        }
        if (isset($member['files']['visa_scan'])) {
            $hasil = $this->scan->check($member['files']['visa_scan'], 'visa', $member['id_user']);
            if ($hasil !== false) {
                $member['visa_scan'] = $hasil;
                $uploadSuccess = true;
            } else {
                $uploadSuccess = false;
            }
        }
        // if (isset($member['files']['tiket_scan'])) {
        //     $hasil = $this->scan->check($member['files']['tiket_scan'], 'tiket', $member['id_user']);
        //     if ($hasil !== false) {
        //         $member['tiket_scan'] = $hasil;
        //         $uploadSuccess = true;
        //     } else {
        //         $uploadSuccess = false;
        //     }
        // }
        if (isset($member['files']['vaksin_scan'])) {
            $hasil = $this->scan->check($member['files']['vaksin_scan'], 'vaksin', $member['id_user']);
            if ($hasil !== false) {
                $member['vaksin_scan'] = $hasil;
                $uploadSuccess = true;
            } else {
                $uploadSuccess = false;
            }
        }
        if (isset($member['id_agen'])) {
            if (empty($member['id_agen'])) {
                $member['id_agen'] = null;
            }
        }

        if (isset($member['files'])) {
            unset($member['files']);
        }
        $this->load->model('registrasi');
        if (!isset($member['pilihan_kamar'])) {
            $availableKamar = $this->registrasi->getAvailableKamar($member['id_paket']);
            $member['pilihan_kamar'] = $availableKamar[0];
        }





        $existMember = $this->getMember(null,$member['id_user'] ,$member['id_paket']);
        if ($existMember) {
            if (isset($member['id_agen'])) {
                if ($member['id_agen'] != null || $member['id_agen'] != 0 || $member['id_agen'] != '') {
                    $member['id_agen'] = $member['id_agen'];
                } else {
                    $member['id_agen'] = null;
                }
            } else {
                $member['id_agen'] = null ;
            }

            if (isset($member['paspor_scan'])) {
                $member['paspor_scan'] = $member['paspor_scan'];
                unlink(SITE_ROOT . $existMember[0]->paspor_scan);
            } else {
                $member['paspor_scan'] = $existMember[0]->paspor_scan;
            }

            if (isset($member['paspor_scan2'])) {
                $member['paspor_scan2'] = $member['paspor_scan2'];
                unlink(SITE_ROOT . $existMember[0]->paspor_scan2);
            } else {
                $member['paspor_scan2'] = $existMember[0]->paspor_scan2;
            }

            if (isset($member['ktp_scan'])) {
                $member['ktp_scan'] = $member['ktp_scan'];
                unlink(SITE_ROOT . $existMember[0]->ktp_scan);
            } else {
                $member['ktp_scan'] = $existMember[0]->ktp_scan;
            }

            if (isset($member['foto_scan'])) {
                $member['foto_scan'] = $member['foto_scan'];
                unlink(SITE_ROOT . $existMember[0]->foto_scan);
            } else {
                $member['foto_scan'] = $existMember[0]->foto_scan;
            }
            if (isset($member['kk_scan'])) {
                $member['kk_scan'] = $member['kk_scan'];
                unlink(SITE_ROOT . $existMember[0]->kk_scan);
            } else {
                $member['kk_scan'] = $existMember[0]->kk_scan;
            }

            if (isset($member['visa_scan'])) {
                $member['visa_scan'] = $member['visa_scan'];
                unlink(SITE_ROOT . $existMember[0]->visa_scan);
            } else {
                $member['visa_scan'] = $existMember[0]->visa_scan;
            }

            if (isset($member['vaksin_scan'])) {
                $member['vaksin_scan'] = $member['vaksin_scan'];
                unlink(SITE_ROOT . $existMember[0]->vaksin_scan);
            } else {
                $member['vaksin_scan'] = $existMember[0]->vaksin_scan;
            }


            // Jamaah Edit Data
            //update
            $id_member = $existMember[0]->id_member;
            // ambil data sesudahnya
            $this->db->where('id_member', $id_member);
            $before = $this->db->get('program_member')->row();
            //////////////////////////////////
            $this->db->where('id_member', $id_member);
            $this->db->update('program_member', $member);
        } else {
            // Jamaah Baru Daftar
            //insert
            $this->db->insert('program_member', $member);
            $id_member = $this->db->insert_id();
            $before = null;
            $this->load->model('paketUmroh');
            //jika ada diskon event
            // $diskon_event = $this->paketUmroh->getDiskonEventPaket($member['id_paket']);
            // if ($diskon_event) {
            //     $dateNow = date('Y-m-d');
            //     if ($dateNow >= $diskon_event->tgl_mulai && $dateNow <= $diskon_event->tgl_berakhir  && $diskon_event->aktif == 1) {
            //         if ($diskon_event->nominal != 0 && $diskon_event->nominal != null) {
            //             // set extra fee
            //             $this->load->model('tarif');
            //             $this->tarif->setExtraFee($id_member, $diskon_event->nominal * -1, $diskon_event->keterangan_diskon);
            //         }
            //     }
            // }
            //jika ada diskon
            $paket = $this->paketUmroh->getPackage($member['id_paket']);
            $diskon = $paket->default_diskon;
            $deskripsiDiskon = $paket->deskripsi_default_diskon;
            if ($diskon != 0 && $diskon != null) {
                //set extra fee diskon
                if ($diskon > 0) {
                    // make it negative value
                    $diskon = $diskon * -1;
                }
                // set extra fee
                $this->load->model('tarif');
                $this->tarif->setExtraFee($id_member, $diskon, $deskripsiDiskon);

                //generate va_open
                // $this->load->model('va_model');
                // $this->va_model->createVAOpen($id_member);
            }
        }

        // ambil data sesudahnya
        $this->db->where('id_member', $id_member);
        $after = $this->db->get('program_member')->row();
        //////////////////////////////////
        ////add logupdateImigrasi
        $this->load->model('logs');
        $this->logs->addLogTable($id_member, 'pm', $before, $after);
        //check if this person already sign in package
        $this->registrasi->cekVerified($id_member);
        //hitung tarif
        $this->calcTariff($id_member);
        $this->registrasi->cekVerified($id_member);
        if ($uploadSuccess == true) {
            $this->alert->toast('success', 'Selamat', 'Data Berhasil di Input');
        } else {
            $this->alert->toast('success', 'Selamat', 'Data Berhasil di Input');
        }
        return $id_member;
    }

    public function updateImigrasi($member)
    {
        //TABEL PROGRAM MEMBER
        //check if this person already sign in package
        $this->load->library('scan');
        $uploadSuccess = true;
        if (isset($member['files']['imigrasi'])) {
            $hasil = $this->scan->check($member['files']['imigrasi'], 'imigrasi', NULL);
            if ($hasil !== false) {
                $member['imigrasi'] = $hasil;
                $uploadSuccess = true;
            } else {
                $uploadSuccess = false;
            }
        }
        if (isset($member['files']['kemenag'])) {
            $hasil = $this->scan->check($member['files']['kemenag'], 'kemenag', NULL);
            if ($hasil !== false) {
                $member['kemenag'] = $hasil;
                $uploadSuccess = true;
            } else {
                $uploadSuccess = false;
            }
        }

        $jamaah = $this->getJamaah(null, null, $member['id_member']);
        if (!empty($jamaah)) {
            if ($member['tambah_nama'] == 0 ) {
                $member['nama_2_suku'] = $member['nama_lengkap'];
            } else {
                $member['nama_2_suku'] = implode(" ", array_filter([$member['nama_lengkap'], $jamaah->nama_ayah]));
            }
        } else {
            return false ;
        }
        unset($member['nama_lengkap']);
        unset($member['files']);
        $existMember = $this->getImigrasi($member['id_request']);
        $member['tgl_request'] = $existMember[0]->tgl_request;

        if ($existMember) {
            // Jamaah Edit Data
            //update
            $id_request = $existMember[0]->id_request;
            $this->db->where('id_request', $id_request);
            $this->db->update('request_dokumen', $member);
        } else {
            $this->db->insert('request_dokumen', $member);
        }

        if ($uploadSuccess == true) {
            $this->alert->set('success', 'Data Berhasil di Verifikasi');
        }
        return $id_request;
    }
    public function pindahPaket($idMember, $idPaketLama, $idPaketBaru)
    {
        // cek sisa seat di paket baru
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage($idPaketBaru);
        try {
            if ($paket->sisa_seat <= 0) {
                return array('status' => false, 'msg' => 'Gagal pindah paket. Jumlah seat pada paket tujuan sudah penuh!');
            }
        } catch (\Throwable $th) {
            return array('status' => false, 'msg' => 'Gagal pindah paket. Paket tidak ditemukan!');
        }

        // ambil data sesudahnya
        $this->db->where('id_member', $idMember);
        $before = $this->db->get('program_member')->row();
        //////////////////////////////////

        //update paket
        $this->db->where('id_member', $idMember);
        $this->db->where('id_paket', $idPaketLama);
        $upd = $this->db->update('program_member', ['id_paket' => $idPaketBaru]);

        // ambil data sesudahnya
        $this->db->where('id_member', $idMember);
        $after = $this->db->get('program_member')->row();
        //////////////////////////////////
        ////add logupdateImigrasi
        $this->load->model('logs');
        $this->logs->addLogTable($idMember, 'pm', $before, $after);

        if ($upd) {
            $this->load->model('tarif');
            $this->tarif->calcTariff($idMember);
            return array('status' => true, 'msg' => 'Pindah paket berhasil!');
        } else {
            return array('status' => false, 'msg' => 'Gagal memindahkan paket!');
        }
    }

    public function getAvailableKamar($idPaket)
    {
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage($idPaket);
        $kamar = array();

        if ($paket->harga != 0) $kamar[] = 'Quad';
        if ($paket->harga_triple != 0) $kamar[] = 'Triple';
        if ($paket->harga_double != 0) $kamar[] = 'Double';

        return $kamar;
    }
    public function getAvailableImigrasi($idPaket)
    {
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage($idPaket);
        return $paket;
    }

    public function getJamaahTableData($id = null, $username = null, $email = null, $no_ktp = null)
    {
        if ($id != null) {
            $this->db->where('id_user', $id);
        }
        if ($username != null) {
            $this->db->where('username', $username);
        }
        if ($email != null) {
            $this->db->where('email', $email);
        }
        if ($no_ktp != null) {
            $this->db->where('no_ktp', $no_ktp);
        }

        $query = $this->db->get('user');
        $result = $query->row();
        return $result;
    }

    public function getUser($id = null, $username = null, $email = null, $idMember = null, $no_ktp = null)
    {
        $result = false;
        if ($id || $username || $no_ktp) {
            //get data from jamaah table first
            $result = $this->getJamaahTableData($id, $username, $email, $no_ktp);
            if (empty($result)) {
                return false;
            }
            //then get member data
            $id = $result->id_user;
            $result->member = $this->getMember($idMember, $id, null);
        } 
        elseif ($idMember) {
            //get member data first
            $member = $this->getMember($idMember);
            if (empty($member)) {
                return false;
            }
            //then get jamaah table data
            $id = $member[0]->id_user;
            $result = $this->getJamaahTableData($id, $username);
            if (empty($result)) {
                return false;
            }
            $result->member = $member;
        } else {
            return false;
        }
        return $result;
    }

    public function getNewRegistrar($limit)
    {
        $this->db->order_by('id_jamaah', 'desc');
        $query = $this->db->get('jamaah', $limit);
        $jamaah = $query->result();
        if (empty($jamaah)) {
            return false;
        }
        $data = array();
        foreach ($jamaah as $j) {
            $data[] = $this->getJamaah($j->id_jamaah);
        }
        return $data;
    }

    public function getBerkasBelumLengkap($id_paket)
    {
        $scanFields = array('paspor_no', 'paspor_scan', 'ktp_scan', 'foto_scan');
        $data = array();
        foreach ($scanFields as $sc) {
            $this->db->where($sc, null);
            $this->db->where('id_paket', $id_paket);
            $query = $this->db->get('program_member');
            $data[$sc] = $query->result();
        }

        $checkFields = array('paspor_check', 'buku_kuning_check', 'foto_check');
        foreach ($checkFields as $cf) {
            $this->db->where($cf, 'N');
            $this->db->where('id_paket', $id_paket);
            $query = $this->db->get('program_member');
            $data[$cf] = $query->result();
        }
        return $data;
    }

    public function getMemberCustom($conditions)
    {
        $this->db->where($conditions);
        $query = $this->db->get('program_member');
        return $query->result();
    }

    public function getMember($id_member = null, $id_user = null, $id_paket = null)
    {
        if ($id_member != null) {
            $this->db->where('id_member', $id_member);
        }
        if ($id_user != null) {
            $this->db->where('id_user', $id_user);
        }
        if ($id_paket != null) {
            $this->db->where('id_paket', $id_paket);
        }

        $this->db->order_by('id_member', 'desc');
        $query = $this->db->get('program_member');
        $result = $query->result();
        if (empty($result)) {
            return false;
        }

        $this->load->model('paketUmroh');
        $this->load->model('agen');

        foreach ($result as $key => $mbr) {
            // generate id secret
            $this->load->library('secret_key');
            $result[$key]->idSecretMember = $this->secret_key->generate($mbr->id_member);

            $result[$key]->paket_info = $this->paketUmroh->getPackage($mbr->id_paket, false);
            $agenData = null;
            if (!empty($mbr->id_agen)) {
                $agenData = $this->agen->getAgen($mbr->id_agen);
                if (!empty($agenData)) {
                    $agenData = $agenData[0];
                }
            }
            $result[$key]->agen = $agenData;
        }
        return $result;
    }

    public function getImigrasi($id_request, $id_member = null)
    {
        $this->db->where('id_request', $id_request);
        if ($id_member != null) {
            $this->db->where('id_member', $id_member);
        }

        $query = $this->db->get('request_dokumen');
        $result = $query->result();

        return $result;
    }

    public function getGroupMembers($id_parent)
    {
        if (!$id_parent) {
            return false;
        }
        $this->db->where('parent_id', $id_parent);
        $query = $this->db->get('program_member');
        $result = $query->result();

        if (empty($result))
            return false;
        $data = array();
        foreach ($result as $key => $r) {
            $user = $this->getUser($r->id_user);
            $data[$r->id_member] = new stdClass();
            $data[$r->id_member]->userData = $user;
            $data[$r->id_member]->memberData = $r;

            // generate id secret
            $this->load->library('secret_key');
            $data[$r->id_member]->memberData->idSecretMember = $this->secret_key->generate($r->id_member);
        }
        return $data;
    }

    public function getAgenGroupMembers($agen_parent) {
        if (!$agen_parent) {
            return false;
        }
        $this->db->where('agen_parent', $agen_parent);
        $query = $this->db->get('program_member');
        $result = $query->result();

        if (empty($result))
            return false;
        $data = array();
        foreach ($result as $key => $r) {
            $jamaah = $this->getJamaah($r->id_jamaah);
            $data[$r->id_member] = new stdClass();
            $data[$r->id_member]->jamaahData = $jamaah;
            $data[$r->id_member]->memberData = $r;

            // generate id secret
            $this->load->library('secret_key');
            $data[$r->id_member]->memberData->idSecretMember = $this->secret_key->generate($r->id_member);
        }
        return $data;
    }

    public function calcTariff($id_member)
    {
        //get data member
        $this->db->where('id_member', $id_member);
        $query = $this->db->get('program_member');
        $data_member = $query->row();
        if (empty($data_member)) {
            return false;
        }
        $pilihan_kamar = $data_member->pilihan_kamar;

        //get data paket
        $this->db->where('id_paket', $data_member->id_paket);
        $query = $this->db->get('paket_umroh');
        $data_paket = $query->row();
        if (empty($data_paket)) {
            return false;
        }

        //get extra fee
        $this->db->where('id_member', $id_member);
        $query = $this->db->get('extra_fee');
        $data_extra_fee = $query->result();

        //sum extra fee
        $extra_fee = 0;
        if (!empty($data_extra_fee)) {
            foreach ($data_extra_fee as $def) {
                $extra_fee = $extra_fee + $def->nominal;
            }
        }

        //get calculation variables

        if ($pilihan_kamar == 'Triple') {
            $harga = $data_paket->harga_triple;
        } elseif ($pilihan_kamar == 'Double') {
            $harga = $data_paket->harga_double;
        } else {
            $harga = $data_paket->harga;
        }

        $dendaProgresif = $data_paket->denda_kurang_3;
        $pernahUmroh = $data_member->pernah_umroh;

        $total_harga = $harga + $extra_fee;
        if ($pernahUmroh == 1) {
            $total_harga = $total_harga + $dendaProgresif;
        }

        //update database
        $this->db->where('id_member', $id_member);
        $this->db->set('total_harga', $total_harga);
        $this->db->update('program_member');
        return true;
    }

    public function deleteUser($id)
    {
        //delete jamaah
        $this->db->where('id_user', $id);
        if ($this->db->delete('user')) {
            $this->alert->toast('success', 'Selamat', 'User Berhasil Dihapus');
        } else {
            $this->alert->toast('danger', 'Mohon Maaf', 'System Error, silakan coba kembali');
            return false;
        }

        //delete from Program Member
        $this->db->where('id_user', $id);
        $this->db->delete('program_member');

        return true;
    }

    public function deleteProgramMember($id_member = null, $parent_id = null)
    {
        //delete program member
        if ($id_member != null) {
            $this->db->where('id_member', $id_member);
        }
        if ($parent_id != null) {
            $this->db->where('parent_id', $parent_id);
        }
        if ($this->db->delete('program_member')) {
            $this->alert->set('success', 'Program member berhasil dihapus');
        } else {
            $this->alert->set('danger', 'System Error, silakan coba kembali');
            return false;
        }

        return true;
    }

    public function getWG($idm)
    {
        $this->load->library('calculate');
        $member = $this->getMember($idm);

        if (empty($member)) {
            return false;
        }

        $member = $member[0];
        $idj = $member->id_user;
        $user = $this->getUser($idj);
        if (empty($user)) {
            return false;
        }
        $age = $this->calculate->age($user->tanggal_lahir);
        $sex = $user->jenis_kelamin;
        $parent = $member->parent_id;

        if ($age < 45 && $sex == 'P' && empty($parent)) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteUpload($idMember, $field)
    {
        $member = $this->getMember($idMember);
        if (empty($member)) {
            return false;
        }

        // ambil data sesudahnya
        $this->db->where('id_member', $idMember);
        $before = $this->db->get('program_member')->row();
        //////////////////////////////////

        $member = $member[0];
        $path = $member->$field;
        unlink(SITE_ROOT . $path);

        $this->db->where('id_member', $idMember);
        $this->db->set($field, null);
        $query = $this->db->update('program_member');
        if ($query == true) {
            // ambil data sesudahnya
            $this->db->where('id_member', $idMember);
            $after = $this->db->get('program_member')->row();
            //////////////////////////////////
            $this->load->model('logs');
            $this->logs->addLogTable($idMember, 'pm', $before, $after);
            return true;
        } else {
            return false;
        }
    }

    public function deleteSuratDokter($id_jamaah, $field)
    {
        $jamaah = $this->getJamaah($id_jamaah);
        if (empty($jamaah)) {
            return false;
        }

        // ambil data sesudahnya
        $this->db->where('id_jamaah', $id_jamaah);
        $before = $this->db->get('jamaah')->row();
        //////////////////////////////////

        $path = $jamaah->$field;
        unlink(SITE_ROOT . $path);

        $this->db->where('id_jamaah', $id_jamaah);
        $this->db->set($field, null);
        $query = $this->db->update('jamaah');
        if ($query == true) {
            // ambil data sesudahnya
            $this->db->where('id_jamaah', $id_jamaah);
            $after = $this->db->get('jamaah')->row();
            //////////////////////////////////
            $this->load->model('logs');
            $this->logs->addLogTable($id_jamaah, 'ja', $before, $after);
            return true;
        } else {
            return false;
        }
    }

    public function deleteImigrasi($id_request, $field)
    {
        $member = $this->getImigrasi($id_request);
        if (empty($member)) {
            return false;
        }
        $member = $member[0];
        $path = $member->$field;
        unlink(SITE_ROOT . $path);

        $this->db->where('id_request', $id_request);
        $this->db->set($field, null);
        $query = $this->db->update('request_dokumen');
        if ($query == true) {
            return true;
        } else {
            return false;
        }
    }
    public function updateRequest($data)
    {
        $this->load->library('scan');
        $uploadSuccess = true;
        if (isset($member['files']['imigrasi'])) {
            $hasil = $this->scan->check($member['files']['imigrasi'], 'imigrasi', $member['id_jamaah']);
            if ($hasil !== false) {
                $member['imigrasi'] = $hasil;
                $uploadSuccess = true;
            } else {
                $uploadSuccess = false;
            }
        }
        if (isset($member['files']['kemenag'])) {
            $hasil = $this->scan->check($member['files']['kemenag'], 'kemenag', $member['id_jamaah']);
            if ($hasil !== false) {
                $member['kemenag'] = $hasil;
                $uploadSuccess = true;
            } else {
                $uploadSuccess = false;
            }
        }

        $existMember = $this->getImigrasi($data['id_request'], $data['id_member']);
        $data['tgl_request'] =  $existMember[0]->tgl_request;
        $data['nama_2_suku'] = $data['nama_lengkap'];
        $data['tambah_nama'] = $data['tambah'];
        unset($data['nama_lengkap']);
        unset($data['tambah']);
        if ($existMember != null) {
            $id_request = $existMember[0]->id_request;
            $this->db->where('id_request', $id_request);
            $this->db->update('request_dokumen', $data);
        } else {
            $this->db->insert('request_dokumen', $data);
        };

        if ($uploadSuccess == true) {
            $this->alert->set('success', 'Data Berhasil di Edit');
        }

        return $id_request;
    }
    public function inputRequest($data)
    {
        $existRequest = $this->getImigrasi($data['id_request']);
        $member = $this->getJamaah(null, null, $data['id_member']);
        if (!empty($member)) {
            if ($data['tambah_nama'] == 0 ) {
                $data['nama_2_suku'] = $data['nama_lengkap'];
            } else {
                $data['nama_2_suku'] = implode(" ", array_filter([$data['nama_lengkap'], $member->nama_ayah]));
            }
        } else {
            return false ;
        }
        
        unset($data['nama_lengkap']);
        unset($data['nama_paket']);

        if ($existRequest) {
            $id_request = $existRequest[0]->id_request;
            $this->db->where('id_request', $id_request);
            $this->db->update('request_dokumen', $data);
        } else {
            $this->db->insert('request_dokumen', $data);
        };

        return true;
    }
    
    public function deleteRequest($id)
    {
        $this->db->where('id_request', $id);
        $query = $this->db->delete('request_dokumen');
        if ($query == false) {
            return false;
        } else {
            return true;
        }
    }
    public function updateDoc($data, $inputs, $fromApp = null, $update = false)
    {
        // if baru registrasi cek apakah seat tersedia
        if (!$update) {
            $this->load->model('paketUmroh');
            $paket = $this->paketUmroh->getPackage($inputs['id_paket'], false, false, false, null, true);
            if (empty($paket)) {
                $this->alert->setJamaah('red', 'Paket tidak tersedia, seat habis.');
                return false;
            }
        }
        if (empty($inputs['ktp_no'])) {
            $this->alert->setJamaah('red', 'Nomor KTP wajib diisi');
            return false;
        }
        //split program member and jamaah data
        $member = array();
        if (isset($inputs['pernah_umroh'])) {
            $member['pernah_umroh'] = $inputs['pernah_umroh'];
            unset($inputs['pernah_umroh']);
        }
        if (isset($inputs['id_agen'])) {
            $member['id_agen'] = $inputs['id_agen'];
            unset($inputs['id_agen']);
        }

        if (isset($inputs['pilihan_kamar'])) {
            $member['pilihan_kamar'] = $inputs['pilihan_kamar'];
            unset($inputs['pilihan_kamar']);
        }
        if (isset($inputs['id_paket'])) {
            $member['id_paket'] = $inputs['id_paket'];
            unset($inputs['id_paket']);
        }

        $unsetInputs = [
            'id_member', 'paspor_no', 'paspor_name', 'paspor_issue_date', 'paspor_expiry_date', 'paspor_issuing_city', 'paspor_scan', 'paspor_scan2',
            'ktp_scan', 'foto_scan', 'visa_scan', 'tiket_scan', 'paspor_check', 'buku_kuning_check', 'foto_check', 'files'
        ];

        foreach ($unsetInputs as $ui) {
            unset($inputs[$ui]);
        }

        foreach ($inputs as $ip) {
            if ($ip != 0 || $ip != null || $ip != '') {
                $inputs['verified'] = true;
            } else {
                $inputs['verified'] = false;
                break;
            }
        }

        $this->load->library('scan');
        $uploadSuccess = true;
        if (isset($data['files']['paspor_scan'])) {
            $hasil = $this->scan->check($data['files']['paspor_scan'], 'paspor', $data['id_jamaah']);
            if ($hasil !== false) {
                $data['paspor_scan'] = $hasil;
                $uploadSuccess = true;
            } else {
                $uploadSuccess = false;
            }
        }
        if (isset($data['files']['paspor_scan2'])) {
            $hasil = $this->scan->check($data['files']['paspor_scan2'], 'paspor2', $data['id_jamaah']);
            if ($hasil !== false) {
                $data['paspor_scan2'] = $hasil;
                $uploadSuccess = true;
            } else {
                $uploadSuccess = false;
            }
        }
        if (isset($data['files']['ktp_scan'])) {
            $hasil = $this->scan->check($data['files']['ktp_scan'], 'ktp', $data['id_jamaah']);
            if ($hasil !== false) {
                $data['ktp_scan'] = $hasil;
                $uploadSuccess = true;
            } else {
                $uploadSuccess = false;
            }
        }
        if (isset($data['files']['foto_scan'])) {
            $hasil = $this->scan->check($data['files']['foto_scan'], 'foto', $data['id_jamaah']);
            if ($hasil !== false) {
                $data['foto_scan'] = $hasil;
                $uploadSuccess = true;
            } else {
                $uploadSuccess = false;
            }
        }
        if (isset($data['files']['visa_scan'])) {
            $hasil = $this->scan->check($data['files']['visa_scan'], 'visa', $data['id_jamaah']);
            if ($hasil !== false) {
                $data['visa_scan'] = $hasil;
                $uploadSuccess = true;
            } else {
                $uploadSuccess = false;
            }
        }
        if (isset($data['files']['vaksin_scan'])) {
            $hasil = $this->scan->check($data['files']['vaksin_scan'], 'vaksin', $data['id_jamaah']);
            if ($hasil !== false) {
                $data['vaksin_scan'] = $hasil;
                $uploadSuccess = true;
            } else {
                $uploadSuccess = false;
            }
        }
        if (isset($data['id_agen'])) {
            if (empty($data['id_agen'])) {
                $data['id_agen'] = null;
            }
        }

        if (isset($data['files'])) {
            unset($data['files']);
        }


        if (!isset($data['pilihan_kamar'])) {
            $availableKamar = $this->getAvailableKamar($data['id_paket']);
            $data['pilihan_kamar'] = $availableKamar[0];
        }


        $existMember = $this->getMember(null, $data['id_jamaah'], $data['id_paket']);
        $unsetData = [
            'ktp_no', 'first_name', 'second_name', 'last_name', 'nama_ayah', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'status_perkawinan', 'verified',
            'no_wa', 'no_rumah', 'email', 'alamat_tinggal', 'provinsi', 'kabupaten_kota', 'kecamatan', 'kewarganegaraan', 'pekerjaan', 'pendidikan_terakhir', 'penyakit', 'referensi'
        ];

        foreach ($unsetData as $ud) {
            unset($data[$ud]);
        }
        if (isset($data['paspor_scan'])) {
            $data['paspor_scan'] = $data['paspor_scan'];
        } else {
            $data['paspor_scan'] = $existMember[0]->paspor_scan;
        }

        if (isset($data['ktp_scan'])) {
            $data['ktp_scan'] = $data['ktp_scan'];
        } else {
            $data['ktp_scan'] = $existMember[0]->ktp_scan;
        }

        if (isset($data['foto_scan'])) {
            $data['foto_scan'] = $data['foto_scan'];
        } else {
            $data['foto_scan'] = $existMember[0]->foto_scan;
        }

        if (isset($data['visa_scan'])) {
            $data['visa_scan'] = $data['visa_scan'];
        } else {
            $data['visa_scan'] = $existMember[0]->visa_scan;
        }

        if (isset($data['vaksin_scan'])) {
            $data['vaksin_scan'] = $data['vaksin_scan'];
        } else {
            $data['vaksin_scan'] = $existMember[0]->vaksin_scan;
        }
        unset($data['id_agen']);
        unset($data['pernah_umroh']);
        foreach ($data as $m) {
            if ($m != 0 || $m != null || $m != '') {
                $data['verified'] = true;
            } else {
                $data['verified'] = false;
                break;
            }

            if ($data['verified'] == true) {
                if ($data['paspor_check'] != true || $data['buku_kuning_check'] != true || $data['foto_check'] != true) {
                    $data['verified'] = false;
                    break;
                } else {
                    $data['verified'] = true;
                }
            }
        }

        if ($existMember) {
            // Jamaah Edit Data
            //update
            $id_member = $existMember[0]->id_member;
            $this->db->where('id_member', $id_member);
            $this->db->update('program_member', $data);
        } else {
            // Jamaah Baru Daftar
            //insert
            $this->db->insert('program_member', $data);
            $id_member = $this->db->insert_id();

            //jika ada diskon
            $this->load->model('paketUmroh');
            $paket = $this->paketUmroh->getPackage($data['id_paket']);
            $diskon = $paket->default_diskon;
            $deskripsiDiskon = $paket->deskripsi_default_diskon;
            if ($diskon != 0 && $diskon != null) {
                //set extra fee diskon
                if ($diskon > 0) {
                    // make it negative value
                    $diskon = $diskon * -1;
                }
                // set extra fee
                $this->load->model('tarif');
                $this->tarif->setExtraFee($id_member, $diskon, $deskripsiDiskon);

                //generate va_open
                $this->load->model('va_model');
                $this->va_model->createVAOpen($id_member);
            }
        }
        ////add log
        $this->load->model('logs');
        $this->logs->addLog('pm', $id_member);

        //check if no_ktp exist in db
        if ($existPerson = $this->getJamaah($inputs['id_jamaah'])) {
            //update
            $id_jamaah = $existPerson->id_jamaah;
            $this->db->where('id_jamaah', $id_jamaah);
            $this->db->update('jamaah', $inputs);
        } else {
            //input database
            $this->db->insert('jamaah', $inputs);
        }
        $member['id_jamaah'] = $id_jamaah;
        if ($fromApp) {
            $member['register_from'] = 'app';
            $member['dp_expiry_time'] = date("Y-m-d H:i:s", strtotime('+' . $this->config->item('dp_expiry_hours') . ' hours'));
        }
        ////add log
        $this->load->model('logs');
        $this->logs->addLog('ja', $id_jamaah);
        $id_member = null;
        if (isset($member['id_paket'])) {
            $id_member = $this->updateMember($member);
        }
        $this->alert->setJamaah('green', 'Data ' . $_POST['first_name'] . ' ' . $_POST['second_name'] . ' ' . $_POST['last_name'] . ' berhasil Di Simpan');
        if ($id_member != null) {
            return $id_member;
        } else {
            return true;
        }
    }

    public function getUsia($id)
    {
        $this->load->library('calculate');
        $member = $this->getMember(null, null, $id);
        if (empty($member)) {
            return false;
        }

        $member = $member[0];
        $idj = $member->id_jamaah;
        $jamaah = $this->getJamaah($idj);
        $age = $this->calculate->age($jamaah->tanggal_lahir);
        return $age;
    }

    public function getRequestDokumen($id_member)
    {
        $this->db->where('id_member', $id_member);
        $sudahAmbil = $this->db->get('request_dokumen')->result();

        $data['items'] = $sudahAmbil;
        //group by date
        $this->db->order_by('tgl_request', 'DESC');
        $group = $this->db->get('request_dokumen')->result();
        $this->db->flush_cache();
        $dateGroup = [];
        foreach ($group as $gr) {
            foreach ($sudahAmbil as $sdh) {
                if ($sdh->tgl_request == $gr->tgl_request) {
                    $prettyDate =  $this->date->convert("l, j F Y H:i:s", $gr->tgl_request);
                    $dateGroup[$prettyDate][] = $sdh;
                }
            }
        }
        $data['dateGroup'] = $dateGroup;

        return $data;
    }
    public function deleteNoDpMember()
    {
        $dpExpiryHours = $this->config->item('dp_expiry_hours');
        $this->db->where('register_from', 'app');
        $this->db->where('lunas', 0);
        $this->db->where("(TIMESTAMPDIFF(HOUR,tgl_regist, NOW()) >= $dpExpiryHours OR tgl_regist IS null)");
        $delete = $this->db->delete('program_member');
        if (!$delete) {
            return false;
        }
        return true;
    }

    public function getSuratCuti($id_member) {
        {
        $this->db->where('id_member', $id_member);
        $sudahAmbil = $this->db->get('request_cuti')->result();
        $this->load->library('secret_key');
        $data['items'] = $sudahAmbil;
        $this->db->order_by('tanggal_dibuat', 'DESC');
        $group = $this->db->get('request_cuti')->result();
        $this->db->flush_cache();
        $dateGroup = [];
        foreach ($group as $gr) {
            foreach ($sudahAmbil as $sdh) {
                if ($sdh->tanggal_dibuat == $gr->tanggal_dibuat) {
                    $prettyDate =  $this->date->convert("l, j F Y H:i", $gr->tanggal_dibuat);
                    $dateGroup[$prettyDate][] = $sdh;
                    foreach ($dateGroup[$prettyDate] as $key => $item) {
                        $dateGroup[$prettyDate][$key]->idSecretCuti = $this->secret_key->generate($dateGroup[$prettyDate][$key]->id_req_cuti);
                    }
                }
            }
        }
        $data['dateGroup'] = $dateGroup;
        // echo '<pre>';
        // print_r($data);
        // exit();

        return $data;
    }
    }

    public function getDataCuti($id)
    {
        $this->db->where('id_req_cuti', $id);
        $request = $this->db->get('request_cuti')->row();
        // echo '<pre>';
        // print_r($request);
        // exit();
        // if (empty($request)) {
        //     return false;
        // }
        // $this->load->model('registrasi');
        // $member = $this->registrasi->getMember($request->id_member);
        // $member = $member[0];
        // $this->load->model('paketUmroh');
        // $paket = $this->paketUmroh->getPackage($member->id_paket);
        // $data = array(
        //     'nama' => $request->nama_2_suku,
        //     'ktp_no' => $request->no_ktp,
        //     'tgl_request' => $request->tgl_request,
        //     'id_request' => $request->id_request,
        //     'tambah_nama' => $request->tambah_nama,
        //     'tanggal_berangkat' => $paket->tanggal_berangkat,
        //     'tanggal_pulang' => $paket->tanggal_pulang,
        //     'imigrasi' => $request->imigrasi_tujuan,
        //     'kemenag' => $request->kemenag_tujuan,
        //     'tgl_lahir' => $request->tempat_lahir . ', ' . (date('d-m-Y', strtotime($request->tanggal_lahir))),
        // );
        return $request;
    }

    public function inputSuratCuti($data) {
        $uploadSuccess = true;
        // $existMember = $this->getImigrasi($data['id_request'], $data['id_member']);
        // $data['nama_2_suku'] = $data['nama_lengkap'];
        // $data['tambah_nama'] = $data['tambah'];
        // unset($data['nama_lengkap']);
        // unset($data['nama_paket']);
        unset($data['nama_lengkap']);
        if ($data['jenis_nomor'] != 'Other') {
            unset($data['lainnya']);
        } else {
            unset($data['jenis_nomor']);
        }
        $this->db->insert('request_cuti', $data);

        if ($uploadSuccess == true) {
            $this->alert->setJamaah('green', 'Berhasil request surat cuti');
        }

        return true;
    }

    public function deleteSuratCuti($id) {
        $this->db->where('id_req_cuti', $id);
        $query = $this->db->delete('request_cuti');
        if ($query == false) {
            return false;
        } else {
            return true;
        }
    }

    public function cekVerified($id_member) {
        // ambil data member
        $this->db->where('id_member', $id_member);
        $data_member = $this->db->get('program_member')->row();
        if (empty($data_member)) {
            return false;
        }

        // proses verified
        $data['paspor_scan'] = $data_member->paspor_scan;
        $data['ktp_scan'] = $data_member->ktp_scan;
        $data['kk_scan'] = $data_member->kk_scan;

        foreach ($data as $m) {
            if ($m != 0 || $m != null || $m != '') {
                $data['verified'] = 1;
            } else {
                $data['verified'] = 0;
                break;
            }
        }
        $this->db->where('id_member', $id_member);
        $this->db->set('verified', $data['verified']);
        if (!$this->db->update('program_member')){
            return false;
        }
        // end proses

        // ambil data jamaah
        $this->db->where('id_user', $data_member->id_user);
        $data_jamaah = $this->db->get('user')->row();
        if (empty($data_jamaah)){
            return false;
        }

        // proses verified
        $jamaah['name'] = $data_jamaah->name;
        $jamaah['no_ktp'] = $data_jamaah->no_ktp;
        $jamaah['jenis_kelamin'] = $data_jamaah->jenis_kelamin;
        $jamaah['tanggal_lahir'] = $data_jamaah->tanggal_lahir;

        foreach ($jamaah as $j) {
            if ($j != 0 || $j != null || $j != '') {
                $jamaah['verified'] = 1;
            } else {
                $jamaah['verified'] = 0;
                break;
            }
        }

        $this->db->where('id_user', $data_jamaah->id_user);
        $this->db->set('verified', $jamaah['verified']);
        if (!$this->db->update('user')){
            return false;
        }
        // end proses

        return $id_member;
    }

    public function checkDokumen($id_paket) {
        $this->db->where('id_paket', $id_paket);
        $member = $this->db->get('program_member')->result();
        if (empty($member)) {
            return false ;
        }

        foreach ($member as $m) {
            $familyMembers = [];
            $familyMembers[0] = new \stdClass();
            $familyMembers[0]->jamaahData = new \stdClass();
            $familyMembers[0]->memberData = new \stdClass();
            $familyMembers[0]->jamaahData =$this->getJamaah(null, null, $m->id_member);
            $familyMembers[0]->memberData = $familyMembers[0]->jamaahData->member[0];
            $uncheckJamaah = ['referensi', 'log' ,'member', 'id_jamaah', 'token', 'second_name', 'last_name','status_perkawinan',
                'no_rumah' , 'email', 'alamat_tinggal', 'provinsi', 'kecamatan', 'kabupaten_kota', 'kewarganegaraan', 'pekerjaan', 'pendidikan_terakhir', 'office', 'upload_penyakit', 'penyakit',
                'nama_ahli_waris', 'no_ahli_waris', 'alamat_ahli_waris'];
            $uncheckMember = [
                'id_member', 'id_jamaah', 'id_paket', 'parent_id', 'register_from', 'pernah_umroh',
                'id_agen', 'manifest_order', 'room_number', 'total_harga', 'lunas', 'dp_expiry_time',
                'va_open', 'log', 'tiket_scan', 'visa_scan', 'paket_info', 'agen', 'tgl_regist', 'buku_kuning_check', 
                'paspor_scan2', 'valid', 'paspor_no', 'paspor_name','paspor_issue_date','paspor_expiry_date', 'paspor_issuing_city', 'vaksin_scan' , 'pilihan_kamar', 'foto_scan', 'foto_check'
            ];
            foreach ($familyMembers as $fam) {
                $dataJamaah = (array) $fam->jamaahData;
                $dataMember = (array) $fam->memberData;

                //hapus index yang tidak ingin di cek
                foreach ($uncheckJamaah as $unj) {
                    unset($dataJamaah[$unj]);
                }
                foreach ($uncheckMember as $unm) {
                    unset($dataMember[$unm]);
                }

                if ($dataMember['verified'] == 1 && $dataJamaah['verified'] == 1) {
                    $data['dokumen'] = true;
                } else {
                    $data['dokumen'] = false;
                    break;
                }
            }

            foreach ($familyMembers as $fam) {
                $dataMember = (array) $fam->memberData ;
                if ($dataMember['lunas'] == 1) {
                    $data['finance'] = true ;
                } else {
                    $data['finance'] = false;
                    break ;
                }
            }

            foreach ($familyMembers as $fam) {
                $dataMember = (array) $fam->memberData ;
                $this->load->model('logistik');
                $perlengkapan = $this->logistik->getStatusPerlengkapanMember($dataMember['id_member']);
                if ($perlengkapan != 'Sudah Semua') {
                    $data['perlengkapan'] = false;
                    break;
                } else {
                    $data['perlengkapan'] = true ;
                }
            }
        }

        return $data ;

    }
}