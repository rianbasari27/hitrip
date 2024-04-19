<?php

class PaketUmroh extends CI_Model
{

    public function addPackage($data)
    {

        if (isset($data['files']['banner_image'])) {
            $this->load->library('scan');
            $hasil = $this->scan->check($data['files']['banner_image'], 'banner_image', null);
            if ($hasil !== false) {
                $data['banner_image'] = $hasil;
            } else {
                $data['banner_image'] = null;
            }
        }
        if (isset($data['files']['paket_flyer'])) {
            $this->load->library('scan');
            $hasil = $this->scan->check($data['files']['paket_flyer'], 'paket_flyer', null);
            if ($hasil !== false) {
                $data['paket_flyer'] = $hasil;
            } else {
                $data['paket_flyer'] = null;
            }
        }
        if (isset($data['files']['itinerary'])) {
            $this->load->library('scan');
            $hasil = $this->scan->check($data['files']['itinerary'], 'itinerary', null);
            if ($hasil !== false) {
                $data['itinerary'] = $hasil;
            } else {
                $data['itinerary'] = null;
            }
        }

        unset($data['files']);
        //check publish
        if (!isset($data['publish'])) {
            $publish = 0;
        } else {
            $publish = $data['publish'];
        }

        //check detail promo
        if (!isset($data['detail_promo'])) {
            $detail = '';
        } else {
            $detail = $data['detail_promo'];
        }

        $newDate = date("Y-m-d", strtotime($data['tanggal_berangkat']));

        if (!empty($data['tanggal_pulang'])) {
            $datePulang = date("Y-m-d", strtotime($data['tanggal_pulang']));
        } else {
            $datePulang = null;
        }

        if (!empty($data['jumlah_seat'])) {
            $jumlahSeat = $data['jumlah_seat'];
        } else {
            $jumlahSeat = 45;
        }


        $insData = array(
            'nama_paket' => $data['nama_paket'],
            'tanggal_berangkat' => $newDate,
            'tanggal_pulang' => $datePulang,
            'jumlah_seat' => $jumlahSeat,
            'banner_image' => $data['banner_image'],
            'detail_promo' => $detail,
            'harga' => $data['harga'],
            'harga_triple' => $data['harga_triple'],
            'harga_double' => $data['harga_double'],
            'publish' => $publish,
            'default_diskon' => $data['default_diskon'],
            'deskripsi_default_diskon' => $data['deskripsi_default_diskon'],

        );

        
        if ($this->db->insert('paket_umroh', $insData)) {
            $this->alert->set('success', 'Paket Umroh berhasil ditambahkan, silakan tambahkan informasi hotel');
        } else {
            $this->alert->set('danger', 'System Error, silakan coba kembali');
            return false;
        }
        // insert id
        $insert_id = $this->db->insert_id();
        
        // ambil data sesudahnya
        $this->db->where('id_paket', $insert_id);
        $after = $this->db->get('paket_umroh')->row();
        //////////////////////////////////
        $this->load->model('logs');
        $this->logs->addLogTable($insert_id, 'pu' ,null, $after);

        // send notif aplikasi
        // $this->load->model('paketUmroh');
        // $paket = $this->paketUmroh->getPackage($insert_id);
        // if ($publish == 1) {
        //     $this->load->model('Notification');
        //     $this->Notification->sendPackageNotif($paket->id_paket, $paket->default_diskon);
        // }
        //
        return $insert_id;
    }

    public function deletePackage($id)
    {

        //delete paket
        $this->db->where('id_paket', $id);
        if ($this->db->delete('paket_umroh')) {
            $this->alert->toast('success', 'Selamat', 'Paket berhasil dihapus');
        } else {
            $this->alert->toast('danger', 'Mohon Maaf', 'Paket gagal dihapus');
            return false;
        }

        //delete hotel
        // $this->db->where('id_paket', $id);
        // $this->db->delete('hotel_info');

        return true;
    }

    public function editPackage($id, $data)
    {
        // ambil data sebelumnya
        $this->db->where('id_paket', $id);
        $before = $this->db->get('paket_umroh')->row();
        //////////////////////////////////
        
        //check publish
        if (!isset($data['publish'])) {
            $publish = 0;
        } else {
            $publish = $data['publish'];
        }

        //check detail promo
        if (!isset($data['detail_promo'])) {
            $detail = '';
        } else {
            $detail = $data['detail_promo'];
        }

        $newDate = date("Y-m-d", strtotime($data['tanggal_berangkat']));

        if (!empty($data['tanggal_pulang'])) {
            $datePulang = date("Y-m-d", strtotime($data['tanggal_pulang']));
        } else {
            $datePulang = null;
        }

        if (!empty($data['jumlah_seat'])) {
            $jumlahSeat = $data['jumlah_seat'];
        } else {
            $jumlahSeat = 45;
        }

        $insData = array(
            'nama_paket' => $data['nama_paket'],
            'tanggal_berangkat' => $newDate,
            'tanggal_pulang' => $datePulang,
            'jumlah_seat' => $jumlahSeat,
            'detail_promo' => $detail,
            'harga' => $data['harga'],
            'harga_triple' => $data['harga_triple'],
            'harga_double' => $data['harga_double'],
            'publish' => $publish,
            'default_diskon' => $data['default_diskon'],
            'deskripsi_default_diskon' => $data['deskripsi_default_diskon'],
            
        );

        
        $this->db->where('id_paket', $id);
        if (!$this->db->update('paket_umroh', $insData)) {
            return false;
        }

        
        
        // ambil data sesudahnya
        $this->db->where('id_paket', $id);
        $after = $this->db->get('paket_umroh')->row();

        //add log
        $this->load->model('logs');
        $this->logs->addLogTable($id, 'pu', $before, $after);

        return $id;
    }

    public function uploadDokumen($file, $idPaket)
    {
        $paket = $this->getPackage($idPaket);
        $this->load->library('scan');
        if (isset($file['itinerary'])) {
            $fileins = $file['itinerary'];
            $jenis = 'itinerary';
            if ($paket->itinerary != null) {
                unlink(SITE_ROOT . $paket->itinerary);
            }
        } elseif (isset($file['paket_info'])) {
            $fileins = $file['paket_info'];
            $jenis = 'paket_info';
            if ($paket->paket_info != null) {
                unlink(SITE_ROOT . $paket->paket_info);
            }
        } elseif (isset($file['paket_flyer'])) {
            $fileins = $file['paket_flyer'];
            $jenis = 'paket_flyer';
            if ($paket->paket_flyer != null) {
                unlink(SITE_ROOT . $paket->paket_flyer);
            }
        } elseif (isset($file['banner_image'])) {
            $fileins = $file['banner_image'];
            $jenis = 'banner_image';
            if ($paket->banner_image != null) {
                unlink(SITE_ROOT . $paket->banner_image);
            }
        } else {
            return false;
        }
        $hasil = $this->scan->check($fileins, $jenis, $idPaket);
        if ($hasil == false) {
            return false;
        }
        $this->db->where('id_paket', $idPaket);
        $update = $this->db->update('paket_umroh', array(
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

    public function deleteDokumen($idPaket, $field)
    {
        $paket = $this->getPackage($idPaket);
        if (empty($paket)) {
            return false;
        }

        $path = $paket->$field;
        unlink(SITE_ROOT . $path);

        $this->db->where('id_paket', $idPaket);
        $this->db->set($field, null);
        $query = $this->db->update('paket_umroh');
        if ($query == true) {
            return true;
        } else {
            return false;
        }
    }

    public function getAvailableMonths($notExpired = TRUE, $active = false, $curSeasonOnly = false, $season = null)
    {
        if ($notExpired) {
            $this->db->where('tanggal_berangkat >=', date('Y-m-d'));
        }
        if ($active !== false) {
            if ($active === 'no') {
                $this->db->where('publish', 0);
            } elseif ($active == true) {
                $this->db->where('publish', 1);
            }
        }
        if ($curSeasonOnly == true) {
            //less than current year are not included
            $this->db->where('YEAR(tanggal_berangkat)>=', date("Y"));
        }
        if ($season) {
            $this->load->library('date');
            $musim = $this->date->getMusim($season);
            $this->db->where('tanggal_berangkat >=', $musim['tglAwal']);
            $this->db->where('tanggal_berangkat <=', $musim['tglAkhir']);
        }
        $this->db->order_by('tanggal_berangkat', 'ASC');
        $this->db->group_by('MONTH(tanggal_berangkat)');
        $this->db->select('tanggal_berangkat');
        $query = $this->db->get('paket_umroh');
        $data = $query->result();
        return $data;
    }

    public function getAvailableYear($notExpired = TRUE, $active = false, $curSeasonOnly = null)
    {
        if ($notExpired) {
            $this->db->where('tanggal_berangkat >=', date('Y-m-d'));
        }
        if ($active !== false) {
            if ($active === 'no') {
                $this->db->where('publish', 0);
            } elseif ($active == true) {
                $this->db->where('publish', 1);
            }
        }
        if ($curSeasonOnly != null) {
            //less than current year are not included
            $this->db->where('YEAR(tanggal_berangkat)>=', date("Y"));
        }
        $this->db->order_by('tanggal_berangkat', 'DESC');
        $this->db->group_by('YEAR(tanggal_berangkat)');
        $this->db->select('YEAR(tanggal_berangkat) AS "Y"');
        $query = $this->db->get('paket_umroh');
        $data = $query->result();
        return $data;
    }

    public function getAllMonth($notExpired = TRUE, $active = false, $curSeasonOnly = null)
    {
        if ($notExpired) {
            $this->db->where('tanggal_berangkat >=', date('Y-m-d'));
        }
        if ($active !== false) {
            if ($active === 'no') {
                $this->db->where('publish', 0);
            } elseif ($active == true) {
                $this->db->where('publish', 1);
            }
        }
        if ($curSeasonOnly != null) {
            //less than current year are not included
            $this->db->where('YEAR(tanggal_berangkat) =', $curSeasonOnly);
        }
        $this->db->order_by('tanggal_berangkat', 'DESC');
        $this->db->group_by('MONTH(tanggal_berangkat)');
        $this->db->select('tanggal_berangkat');
        $query = $this->db->get('paket_umroh');
        $data = $query->result();
        return $data;
    }

    public function getPackage($id = null, $notExpired = TRUE, $active = false, $curSeasonOnly = false, $month = null, $available = false, $season = null)
    {
        if ($id != null) {
            $this->db->where('id_paket', $id);
        }
        if ($notExpired) {
            $this->db->where('tanggal_berangkat >=', date('Y-m-d'));
        }
        if ($active !== false) {
            if ($active === 'no') {
                $this->db->where('publish', 0);
            } elseif ($active == true) {
                $this->db->where('publish', 1);
            }
        }
        if ($curSeasonOnly == true) {
            //less than current year are not included
            $this->db->where('YEAR(tanggal_berangkat)>=', date("Y"));
        }
        if ($season) {
            $this->load->library('date');
            $musim = $this->date->getMusim($season);
            $this->db->where('tanggal_berangkat >=', $musim['tglAwal']);
            $this->db->where('tanggal_berangkat <=', $musim['tglAkhir']);
        }
        if ($month) {
            $this->db->where('MONTH(tanggal_berangkat)', $month);
        }

        $this->db->order_by('tanggal_berangkat', 'ASC');
        $query = $this->db->get('paket_umroh');
        $data = $query->result();


        if (!empty($data)) {
            $this->load->library('calculate');

            $lastTrips = array();
            $nextTrip = array();
            $futureTrips = array();

            $this->load->model('registrasi');
            foreach ($data as $key => $d) {


                $this->db->where('id_paket', $d->id_paket);
                $members = $this->db->get('program_member')->result();
                $membersCount = count($members);
                $sisaSeat = $d->jumlah_seat - $membersCount;

                //is available only
                if ($available) {
                    if ($sisaSeat <= 0) {
                        unset($data[$key]);
                        continue;
                    }
                }
                $data[$key]->sisa_seat = $sisaSeat;

                //harga display di promo jamaah
                if ($d->harga) {
                    $hargaDisplay = $d->harga;
                } elseif ($d->harga_triple) {
                    $hargaDisplay = $d->harga_triple;
                } else {
                    $hargaDisplay = $d->harga_double;
                }
                $data[$key]->harga_display = $hargaDisplay;

                //harga di home jamaah
                $this->load->library('money');
                $data[$key]->hargaPretty = $this->money->format($hargaDisplay);
                $data[$key]->hargaPrettyDiskon = $this->money->format($hargaDisplay - $d->default_diskon);
                $data[$key]->hargaHome = $this->money->hargaHomeFormat($hargaDisplay);
                $data[$key]->hargaHomeDiskon = $this->money->hargaHomeFormat($hargaDisplay - $d->default_diskon);
                //get berapa hari paket umrohnya
                if (isset($d->tanggal_pulang)) {
                    $data[$key]->lamaHari = ($this->calculate->dateDiff($d->tanggal_pulang, $d->tanggal_berangkat)) + 1;
                } else {
                    $data[$key]->lamaHari = null;
                }

                //get countdown

                $countdown = $this->calculate->dateDiff($data[$key]->tanggal_berangkat, date('Y-m-d'));
                if ($countdown > 0) {
                    $data[$key]->countdown = $countdown . ' hari lagi';
                } else {
                    $data[$key]->countdown = 'Sudah berangkat';
                }
                // get tanggal pelunasan
                $data[$key]->tanggal_pelunasan = date('d F Y', strtotime($d->tanggal_berangkat . ' -45 day'));
                //get hotel
                // $this->db->where('id_paket', $d->id_paket);
                // $query = $this->db->get('hotel_info');
                // $dataHotel = $query->result();
                // $data[$key]->hotel = $dataHotel;
                //reorder
                $tripDate = strtotime($d->tanggal_berangkat);
                $currentDate = strtotime('now');
                if ($tripDate < $currentDate) {
                    $lastTrips[] = $data[$key];
                } elseif (empty($nextTrip)) {
                    $nextTrip[] = $data[$key];
                } else {
                    $futureTrips[] = $data[$key];
                }
            }
            $data = array_merge($nextTrip, $futureTrips, $lastTrips);
        } else {
            //$this->alert->set('danger', 'Data tidak ada');
            return false;
        }

        if ($id != null) {
            $data = $data[0];
        }
        return $data;
    }

    public function addHotel($data)
    {
        if (empty($data['id_paket'] || empty($data['nama_hotel']))) {
            return false;
        }

        // ambil data sebelumnya
        $this->db->where('id_paket', $data['id_paket']);
        $before = $this->db->get('paket_umroh')->row();
        //////////////////////////////////

        if (isset($data['files']['foto'])) {

            $this->load->library('scan');
            $hasil = $this->scan->check($data['files']['foto'], 'foto_hotel', null);
            if ($hasil !== false) {
                $data['foto'] = $hasil;
            } else {
                $data['foto'] = null;
            }
            unset($data['files']);
        }
        $insData = $data;
        if ($this->db->insert('hotel_info', $insData)) {
            $this->alert->set('success', 'Hotel berhasil ditambahkan');
        } else {
            $this->alert->set('danger', 'System Error, silakan coba kembali');
            return false;
        }

        // ambil data sesudahnya
        $this->db->where('id_paket', $data['id_paket']);
        $after = $this->db->get('paket_umroh')->row();
        //////////////////////////////////

        //add log
        $this->load->model('logs');
        $this->logs->addLogTable($data['id_paket'], 'pu', $before, $after);
        return $data['id_paket'];
    }

    public function deleteHotel($id)
    {
        //get data first
        $this->db->where('id_hotel', $id);
        $query = $this->db->get('hotel_info');
        $data = $query->row();

        if (empty($data)) {
            return false;
        }

        // ambil data sebelumnya
        $this->db->where('id_paket', $data->id_paket);
        $before = $this->db->get('paket_umroh')->row();
        //////////////////////////////////

        $this->db->where('id_hotel', $id);
        if ($this->db->delete('hotel_info')) {
            $this->alert->set('success', 'Hotel berhasil dihapus');
        } else {
            $this->alert->set('danger', 'System Error, silakan coba kembali');
            return false;
        }

        // ambil data sesudahnya
        $this->db->where('id_paket', $data->id_paket);
        $after = $this->db->get('paket_umroh')->row();
        //////////////////////////////////

        //add log
        $this->load->model('logs');
        $this->logs->addLogTable($data->id_paket, 'pu', $before, $after);
        return $data->id_paket;
    }

    public function addDiskonEvent($data)
    {

        //check aktif
        if (!isset($data['aktif'])) {
            $aktif = 0;
        } else {
            $aktif = $data['aktif'];
        }

        //check detail promo

        $tgl_mulai = date("Y-m-d", strtotime($data['tgl_mulai']));
        $tgl_akhir = date("Y-m-d", strtotime($data['tgl_berakhir']));

        if (!empty($data['keterangan_diskon'])) {
            $keterangan_diskon = $data['keterangan_diskon'];
        } else {
            $keterangan_diskon = NULL;
        }


        $insData = array(
            'nominal' => $data['nominal'],
            'keterangan_diskon' => $keterangan_diskon,
            'tgl_mulai' => $tgl_mulai,
            'tgl_berakhir' => $tgl_akhir,
            'aktif' => $aktif

        );

        if ($this->db->insert('diskon', $insData)) {
            $this->alert->set('success', 'Discount Event berhasil ditambahkan');
        } else {
            $this->alert->set('danger', 'System Error, silakan coba kembali');
            return false;
        }

        //add log and voucher_paket
        $insert_id = $this->db->insert_id();
        $this->addDiskonEventPaket($insert_id, $data);

        // ambil data sesudahnya
        $this->db->where('id_diskon', $insert_id);
        $after = $this->db->get('diskon')->row();
        //////////////////////////////////

        $this->load->model('logs');
        $this->logs->addLogTable($insert_id, 'd', null, $after);
        return $insert_id;
    }

    public function addDiskonEventPaket($id, $data)
    {
        foreach ($data['id_paket'] as $id_paket) {
            $diskon = array(
                'id_diskon' => $id,
                'id_paket' => $id_paket
            );
            $this->db->insert('diskon_paket', $diskon);
        }
    }

    public function getDiskonEvent($id)
    {
        $this->db->where('id_diskon', $id);
        $query = $this->db->get('diskon');
        $data = $query->row();

        $this->db->where('id_diskon', $id);
        $query = $this->db->get('diskon_paket');
        $diskon_paket = $query->result();
        $paket = array();
        foreach ($diskon_paket as $v) {
            $paket[] = $v->id_paket;
        }
        $data->paket = $paket;
        return $data;
    }

    public function getDiskonEventPaket($id_paket = null)
    {
        $this->db->select('*');
        $this->db->from('diskon');
        $this->db->join('diskon_paket', 'diskon.id_diskon = diskon_paket.id_diskon');
        $this->db->where('diskon_paket.id_paket', $id_paket);
        $data = $this->db->get()->row();
        return $data;
    }

    public function editDiskonEvent($data)
    {
        // ambil data sebelumnya
        $this->db->where('id_diskon', $data['id_diskon']);
        $before = $this->db->get('diskon')->row();
        //////////////////////////////////

        $dataDiskon = array(
            'id_diskon' => $data['id_diskon'],
            'nominal' => $data['nominal'],
            'tgl_mulai' => $data['tgl_mulai'],
            'tgl_berakhir' => $data['tgl_berakhir'],
            'keterangan_diskon' => $data['keterangan_diskon'],
            'aktif' => $data['aktif']
        );

        $this->db->where('id_diskon', $data['id_diskon']);
        $this->db->update('diskon', $dataDiskon);

        if (isset($data['paket'])) {
            $this->db->where('id_diskon', $data['id_diskon']);
            $this->db->delete('diskon_paket');

            foreach ($data['paket'] as $p) {
                $diskonPaket = array(
                    'id_diskon' => $data['id_diskon'],
                    'id_paket' => $p
                );

                $this->db->insert('diskon_paket', $diskonPaket);
            }
        }

        // ambil data sesudahnya
        $this->db->where('id_diskon', $data['id_paket']);
        $after = $this->db->get('diskon')->row();
        //////////////////////////////////

        $this->load->model('logs');
        $this->logs->addLogTable($data['id_diskon'], 'd', $before, $after);

        return true;
    }

    public function hapusDiskonEvent($id)
    {
        $this->db->where('id_diskon', $id);
        if (!$this->db->delete('diskon')) {
            return false ;
        }

        $this->db->where('id_diskon', $id);
        if (!$this->db->delete('diskon_paket')) {
            return false ;
        }

        return true;
    }
}