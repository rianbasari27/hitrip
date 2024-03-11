<?php

class Agen extends CI_Model
{

    
    //    public function getAgen($term, $lim = 10) {
    //        $this->db->like('nama_agen', $term);
    //        $this->db->where('nama_agen !=', '');
    //        $this->db->where('nama_agen !=', null);
    //        $this->db->group_by('nama_agen');
    //        $this->db->limit($lim);
    //        $query = $this->db->get('program_member');
    //        $data = $query->result();
    //        if(empty($data)){
    //            return $data;
    //        }
    //        $result = array();
    //        foreach($data as $d){
    //            $result[] = $d->nama_agen;
    //        } 
    //        return $result;
    //    }
    public function hapusUpline($idAgen)
    {
        $hapus = $this->db->where('id_agen', $idAgen)
            ->update('agen', ['upline_id' => null]);
        if (!$hapus) {
            $this->alert->set('danger', 'Error, Upline gagal dihapus');
            return false;
        }
        return true;
    }
    public function getAgen($id = null, $byNia = false, $suspendTrue = false, $isEmail = false, $active = false, $no_ktp = false)
    {

        if ($id != null) {
            if ($byNia == true) {
                $this->db->where('no_agen', $id);
            } elseif ($isEmail == true) {
                $this->db->where('email', $id);
            } elseif ($no_ktp == true) {
                $this->db->where('no_ktp', $id);
            } else {
                $this->db->where('id_agen', $id);
            }
        }
        if ($suspendTrue == true) {
            $this->db->where('suspend', 1);
        }

        if ($active !== false) {
            if ($active === 'no') {
                $this->db->where('active', 0);
            } elseif ($active == true) {
                $this->db->where('active', 1);
            }
        }
        $query = $this->db->get('agen');
        $data = $query->result();
        foreach ($data as $key => $d) {
            $this->db->where('id_agen', $d->id_agen);
            $this->db->order_by('id_agen_peserta', "DESC");
            $program = $this->db->get('agen_peserta_paket')->result();
            if (!empty($program)) {
                foreach ($program as $item => $p) {
                    $this->load->model('agenPaket');
                    $this->load->library('money');
                    $program[$item]->hargaPretty = $this->money->format($p->harga);
                    $program[$item]->hargaAfterDiskonPretty = $this->money->format($p->harga_setelah_diskon);
                    $agen_paket = $this->agenPaket->getAgenPackage($p->id_agen_paket);
                    $program[$item]->detail_program = $agen_paket;
                }
            }
            $data[$key]->program = $program;
        }
        return $data;
    }
    public function getAgenByName($term, $limit = 5)
    {
        $data = $this->db->like('nama_agen', $term)
            ->get('agen')->result_array();
        return $data;
    }
    public function setUpline($idAgen, $idUpline)
    {
        $this->db->where('id_agen', $idAgen);
        if ($this->db->update('agen', ['upline_id' => $idUpline])) {
            return true;
        } else {
            return false;
        }
    }
    public function setDownline($idAgen, $idDownline)
    {
        $this->db->where('id_agen', $idDownline);
        if ($this->db->update('agen', ['upline_id' => $idAgen])) {
            return true;
        } else {
            return false;
        }
    }
    public function getUpline($idAgen)
    {
        $dataAgen = $this->db->where('id_agen', $idAgen)
            ->get('agen')->row();
        if (empty($dataAgen)) {
            return false;
        }
        //get upline
        $uplineId = $dataAgen->upline_id;
        $uplineData =
            $this->db->where('id_agen', $uplineId)
            ->get('agen')->row();

        return $uplineData;
    }
    public function getDownline($idAgen)
    {
        //get downline
        $dataDownline = $this->db->where('upline_id', $idAgen)
            ->order_by('nama_agen', 'asc')
            ->get('agen')->result();
        return $dataDownline;
    }

    public function getRowAgen($id = null, $byNia = false, $suspendTrue = false)
    {

        if ($id != null) {
            if ($byNia == true) {
                $this->db->where('no_agen', $id);
            } else {
                $this->db->where('id_agen', $id);
            }
        }
        if ($suspendTrue == true) {
            $this->db->where('suspend', 1);
        }
        $query = $this->db->get('agen');
        $data = $query->row();
        return $data;
    }

    public function getJamaahAgen($id, $active = false, $season = false)
    {
        $this->db->where('id_agen', $id);
        $query = $this->db->get('program_member');
        $data = $query->result();
        foreach ($data as $key => $d) {
            $this->load->model('paketUmroh');
            $jamaahData = $this->paketUmroh->getPackage($d->id_paket, false, false);
            if (empty($jamaahData)) {
                unset($data[$key]);
            } else {
                $data[$key]->jamaah = $jamaahData;
                if ($active == true) {
                    if (!$this->paketUmroh->getPackage($d->id_paket, true)) {
                        unset($data[$key]);
                    }
                }
                if ($season == true) {
                    if ($jamaahData->tanggal_berangkat < '2023-06-19') {
                        unset($data[$key]);
                    }
                }
            }
        }

        return $data;
    }

    public function editAgen($id, $data)
    {
        //check if agen exist
        $agen = $this->getAgen($id);
        if (empty($agen)) {
            return array(
                'status' => 'error',
                'msg' => 'Record tidak ditemukan'
            );
        }
        $agen = $agen[0];

        //check if NIA changed
        if (isset($data['no_agen'])) {
            if ($agen->no_agen != $data['no_agen']) {
                $existNia = $this->getAgen($data['no_agen'], true);
                if (!empty($existNia)) {
                    return array(
                        'status' => 'error',
                        'msg' => 'NIA sudah digunakan Konsultan lain !'
                    );
                }
            }
        }
        if (isset($data['no_ktp'])) {
            if ($agen->no_ktp != $data['no_ktp']) {
                $existKtp = $this->getAgen($data['no_ktp'], false, false, false, false, true);
                if (!empty($existKtp)) {
                    return array(
                        'status' => 'error',
                        'msg' => 'No KTP sudah digunakan Konsultan lain !'
                    );
                }
            }
        }
        $this->db->where('id_agen', $id);
        $update = $this->db->update('agen', $data);
        if ($update == true) {
            return array(
                'status' => 'success'
            );
        } else {
            return array(
                'status' => 'error',
                'msg' => 'Terjadi error pada database'
            );
        }
    }

    public function tambahAgen($data)
    {
        //check if exist nama and NIA
        if (!isset($data['nama_agen'])) {
            return array(
                'status' => 'error',
                'msg' => "NIA dan Nama Konsultan Harus Diisi"
            );
        }

        $this->load->library('scan');
        $uploadSuccess = true;
        if (isset($data['files']['mou_doc'])) {
            $hasil = $this->scan->check($data['files']['mou_doc'], 'mou_doc', null);
            if ($hasil !== false) {
                $data['mou_doc'] = $hasil;
                $uploadSuccess = true;
            } else {
                $uploadSuccess = false;
            }
        }
        if (isset($data['files']['foto_diri'])) {
            $hasil = $this->scan->check($data['files']['foto_diri'], 'foto_diri', null);
            if ($hasil !== false) {
                $data['foto_diri'] = $hasil;
                $uploadSuccess = true;
            } else {
                $uploadSuccess = false;
            }
        }
        if (isset($data['files']['foto_diri2'])) {
            $hasil = $this->scan->check($data['files']['foto_diri2'], 'foto_diri', null);
            if ($hasil !== false) {
                $data['foto_diri2'] = $hasil;
                $uploadSuccess = true;
            } else {
                $uploadSuccess = false;
            }
        }

        if (isset($data['files'])) {
            unset($data['files']);
        }

        //check if NIA already exist
        if (isset($data['no_agen'])) {
            $oldAgen = $this->getAgen($data['no_agen'], true);
            if (!empty($oldAgen)) {
                return array(
                    'status' => 'error',
                    'msg' => "NIA sudah digunakan konsultan lain!"
                );
            }
        }
        if (isset($data['no_ktp'])) {
            $existKtp = $this->getAgen($data['no_ktp'], false, false, false, false, true);
            if (!empty($existKtp)) {
                return array(
                    'status' => 'error',
                    'msg' => "No KTP sudah digunakan konsultan lain!"
                );
            }
        }

        if (!empty($data['password'])) {
            $pass = password_hash($data['password'], PASSWORD_BCRYPT);
        } else {
            $pass = password_hash('ventouragen', PASSWORD_BCRYPT);
        }
        $data['password'] = $pass;
        $insert = $this->db->insert('agen', $data);
        $id_agen = $this->db->insert_id();
        if ($insert == true) {
            return array(
                'status' => 'success',
                'id_agen'=> $id_agen
            );
        } else {
            return array(
                'status' => 'error',
                'msg' => 'Terjadi masalah pada database'
            );
        }
    }

    public function changePic($id, $agen_pic)
    {
        // Check file size
        if ($agen_pic["size"] > 5000000) {
            $this->alert->set('danger', 'File terlalu besar, ukuran maksimal 5 MB');
            return false;
        }
        $this->load->library('scan');
        if (isset($agen_pic)) {
            $hasil = $this->scan->check($agen_pic, 'agen_pic', $id);
            if ($hasil !== false) {
                $file = $hasil;
            }
        }


        $agen = $this->getAgen($id);
        if ($agen) {
            $id_agen = $agen[0]->id_agen;
            if ($agen[0]->agen_pic != null) {
                unlink(SITE_ROOT . $agen[0]->agen_pic) ;
            }
            $this->db->where('id_agen', $id_agen);
            $this->db->update('agen', array('agen_pic' => $file));
            $this->alert->set('success', 'Profile Picture berhasil diganti');
        } else {
            $this->alert->set('danger', 'Terjadi error pada server, mohon coba kembali');
            return false;
        }

        //add log
        $this->load->model('logs');
        $this->logs->addLog('s', $id);
        return true;
    }

    public function deletePic($id, $field)
    {
        $agen = $this->getAgen($id);
        if (empty($agen)) {
            return false;
        }

        $agen = $agen[0];
        $path = $agen->$field;
        unlink(SITE_ROOT . $path);

        $this->db->where('id_agen', $id);
        $this->db->set($field, null);
        $query = $this->db->update('agen');
        if ($query == true) {
            return true;
        } else {
            return false;
        }
    }
    public function changeMou($id, $mou_doc)
    {
        // Check file size
        if ($mou_doc["size"] > 5000000) {
            $this->alert->set('danger', 'File terlalu besar, ukuran maksimal 5 MB');
            return false;
        }

        $this->load->library('scan');
        if (isset($mou_doc)) {
            $hasil = $this->scan->check($mou_doc, 'mou_doc', $id);
            if ($hasil !== false) {
                $file = $hasil;
            }
        }


        $agen = $this->getAgen($id);
        if ($agen) {
            $id_agen = $agen[0]->id_agen;
            if ($agen[0]->mou_doc != null) {
                unlink(SITE_ROOT . $agen[0]->mou_doc) ;
            }
            $this->db->where('id_agen', $id_agen);
            $this->db->update('agen', array('mou_doc' => $file));
            $this->alert->set('success', 'MOU berhasil diupload');
        } else {
            $this->alert->set('danger', 'Terjadi error pada server, mohon coba kembali');
            return false;
        }

        //add log
        $this->load->model('logs');
        $this->logs->addLog('s', $id);
        return true;
    }

    public function deleteMou($id_agen, $field)
    {
        $agen = $this->getAgen($id_agen);
        if (empty($agen)) {
            return false;
        }
        $agen = $agen[0];
        $path = $agen->$field;
        unlink(SITE_ROOT . $path);

        $this->db->where('id_agen', $id_agen);
        $this->db->set($field, null);
        $query = $this->db->update('agen');
        if ($query == true) {
            return true;
        } else {
            return false;
        }
    }


    public function setSuspend($id)
    {
        //check if id exist
        $agen = $this->getAgen($id);
        if (empty($agen)) {
            return array(
                'status' => 'danger',
                'msg' => 'Agen tidak terdaftar'
            );
        }
        $agen = $agen[0];
        $suspend = $agen->suspend;
        if ($suspend == 0) {
            $newSuspend = 1;
        } else {
            $newSuspend = 0;
        }
        $this->db->where('id_agen', $id);
        $update = $this->db->update('agen', array('suspend' => $newSuspend));
        if ($update == true) {
            return array(
                'status' => 'success',
                'msg' => 'Suspend Berhasil Diubah'
            );
        } else {
            return array(
                'status' => 'danger',
                'msg' => 'Terjadi error pada database'
            );
        }
    }

    public function hapusAgen($id)
    {
        $agen = $this->getAgen($id);
        if (empty($agen)) {
            return array(
                'status' => 'danger',
                'msg' => 'Agen tidak terdaftar'
            );
        }
        $agen = $agen[0];
        if (!empty($agen->agen_pic)) {
            //delete picture file
            $target = '/home/ventourc/public_html/app/asset/images/agen/' . $agen->agen_pic;
            unlink($target);
        }
        $this->db->where('id_agen', $id);
        $delete = $this->db->delete('agen');
        if ($delete == true) {
            return array(
                'status' => 'success',
                'msg' => 'Agen Berhasil Dihapus'
            );
        } else {
            return array(
                'status' => 'danger',
                'msg' => 'Terjadi Error Pada Database'
            );
        }
    }
    public function getBirthdayAgen($month)
    {
        $this->db->where('MONTH(tanggal_lahir)', $month);
        $this->db->order_by('DAY(tanggal_lahir)', 'asc');
        $query = $this->db->get('agen');
        $agen = $query->result();
        if (empty($agen)) {
            return array();
        }
        return $agen;
    }

    function getUsers($postData)
    {

        $response = array();
        if (isset($postData['search'])) {
            // Select record
            $this->db->select('*');
            $this->db->where("nama_agen like '%" . $postData['search'] . "%' ");
            $records = $this->db->get('agen')->result();
            //   echo '<pre>';
            //   print_r($records);
            //   exit();
            foreach ($records as $row) {
                $response[] = array("value" => $row->id_agen, "label" => $row->nama_agen);
            }
        }
        return $response;
    }

    public function getJamaahBy($id_agen, $month, $id_paket, $status_bayar, $data, $perlengkapan)
    {
        $this->load->model('paketUmroh');
        // by month
        $paket = $this->paketUmroh->getPackage($id_paket, true, false, false, $month);
        if ($id_paket != NULL) {
            $this->db->where('id_paket', $id_paket);
        }
        // by lunas
        $this->db->where('lunas', $status_bayar);
        $this->db->where('id_agen', $id_agen);
        $member = $this->db->get('program_member');
        $result = $member->result();

        //by data
        foreach ($result as $key => $r) {
            $this->load->model('registrasi');
            $jamaah = $this->registrasi->getJamaah($r->id_jamaah);
            unset($jamaah->member);
            $result[$key]->jamaahData = $jamaah;

            // echo '<pre>';
            // print_r($result);
            // exit();
        }

        foreach ($result as $key => $rst) {
            if ($rst->verified == 1 && $rst->jamaahData == 1) {
                $result[$key]->document = 1;
            } else {
                $result[$key]->document = 0;
            }
        }
        if ($data != NULL) {
            foreach ($result as $hasil) {
                if ($hasil->document != $data) {
                }
                if ($hasil->jamaahData != $data) {
                    # code...
                }
            }
            $this->db->where('verified', $data);
        }

        // by perlengkapan




        echo '<pre>';
        print_r($result);
        exit();
    }
    public function hapusDownline($idDownline)
    {
        $hapus = $this->db->where('id_agen', $idDownline)
            ->update('agen', ['upline_id' => null]);
        if (!$hapus) {
            $this->alert->set('danger', 'Error. Downline gagal di hapus');
            return false;
        }
        return true;
    }
}