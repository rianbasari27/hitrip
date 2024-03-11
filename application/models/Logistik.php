<?php

class Logistik extends CI_Model
{

    public function addBarang($data)
    {
        $this->load->library('scan');
        if (isset($data['files']['pic'])) {
            $hasil = $this->scan->check($data['files']['pic'], 'perlengkapan_pic', null);
            if ($hasil !== false) {
                $data['pic'] = $hasil;
            }
        }
        unset($data['files']);
        $query = $this->db->insert('logistik', $data);
        if ($query == false) {
            return false;
        }

        ////add log
        $id = $this->db->insert_id();
        // ambil data sesudahnya
        $this->db->where('id_logistik', $id);
        $after = $this->db->get('logistik')->row();
        //////////////////////////////////

        $this->load->model('logs');
        $this->logs->addLogTable($id, 'lg', null, $after);
        return $id;
    }

    public function getBarang($id = null)
    {
        if ($id != null) {
            $this->db->where('id_logistik', $id);
        }
        $this->db->order_by('nama_barang', 'ASC');
        $query = $this->db->get('logistik');
        $result = $query->result();
        if (empty($result)) {
            return false;
        }
        return $result;
    }

    public function deleteBarang($id)
    {
        $this->db->where('id_logistik', $id);
        $query = $this->db->delete('logistik');
        if ($query == false) {
            return false;
        } else {
            return true;
        }
    }

    public function deleteMutasi($id)
    {
        $this->db->where('id_mutasi', $id);
        $query = $this->db->delete('mutasi_barang');
        if ($query == false) {
            return false;
        } else {
            return true;
        }
    }

    public function editbarang($id, $data)
    {
        $this->db->where('id_logistik', $id);
        $before = $this->db->get('logistik')->row();

        $this->db->where('id_logistik', $id);
        $query = $this->db->update('logistik', $data);
        if ($query == false) {
            return false;
        }

        $this->db->where('id_logistik', $id);
        $after = $this->db->get('logistik')->row();

        // add log
        $this->load->model('logs');
        $this->logs->addLogTable($id,'lg', $before, $after);
        return $id;
    }

    public function getPengirimanData($id_member) {
        $this->load->model('registrasi');
        $jamaah = $this->registrasi->getJamaah(null, null, $id_member);
        $perlAmbil = $this->getPendingBookingStatus($id_member);
        $perlengkapan = [];
        foreach ($perlAmbil['items'] as $item) {
            $perlengkapan[] = $item->nama_barang;
        }
        $data = array(
            'nama' => $jamaah->first_name . ' ' . $jamaah->second_name . ' ' . $jamaah->last_name,
            'no_wa' => $perlAmbil['items'][0]->no_pengiriman,
            'alamat' => $perlAmbil['items'][0]->alamat_pengiriman,
            'perlengkapan' => $perlengkapan
        );

        return $data;
    }

    public function getPerlengkapanMember($id_member, $id_logistik) {
        $this->dv->where('id_logistik', $id_logistik);
        // $this->db->where('id_member', $id_member);
        $this->db->join('logistik', 'logistik.id_logistik = perlengkapan_member.id_logistik');
        $this->db->stop_cache();
        $this->db->order_by('logistik.nama_barang', 'ASC');
        $this->db->where('status', 'Selesai');
        $perlengkapan = $this->db->get('perlengkapan_member')->result();

        if (!empty($perlengkapan)) {
            return true;
        } else {
            return false;
        }
    }

    public function getPerlengkapanPaket($idPaket, $status = null, $jk = null, $umur = 999)
    {
        // disini adalah list perlengkapan sebuah paket yang bisa diambil
        // ada status siap diambil
        // got it
        // yang gw dapet disini adalah list barang yang rede diambil dalam sebuah paket
        // next kita pindah ke getStatus..
        if ($status != null) {
            $this->db->where('status', $status);
        }
        $this->db->where('id_paket', $idPaket);
        $this->db->join('logistik', 'logistik.id_logistik = perlengkapan_paket.id_logistik');
        $this->db->order_by('logistik.nama_barang', 'ASC');
        $query = $this->db->get('perlengkapan_paket');
        $result = $query->result();
        $logistikPaket['perlengkapan'] = $result;
        //count belum ready and siap diambil
        $belumReadyPria = 0;
        $belumReadyWanita = 0;
        $belumReadyAnakPria = 0;
        $belumReadyAnakWanita = 0;
        $belumReadyBayi = 0;
        $siapDiambilPria = 0;
        $siapDiambilWanita = 0;
        $siapDiambilAnakPria = 0;
        $siapDiambilAnakWanita = 0;
        $siapDiambilBayi = 0;
        $totalPria = 0;
        $totalWanita = 0;
        $totalAnakPria = 0;
        $totalAnakWanita = 0;
        $totalBayi = 0;

        $siapDiambilPriaItems = [];
        $siapDiambilWanitaItems = [];
        $siapDiambilAnakPriaItems = [];
        $siapDiambilAnakWanitaItems = [];
        $siapDiambilBayiItems = [];
        $belumReadyPriaItems = [];
        $belumReadyWanitaItems = [];
        $belumReadyAnakPriaItems = [];
        $belumReadyAnakWanitaItems = [];
        $belumReadyBayiItems = [];

        $siapDiambilPriaNamaBarang = [];
        $siapDiambilWanitaNamaBarang = [];
        $siapDiambilAnakPriaNamaBarang = [];
        $siapDiambilAnakWanitaNamaBarang = [];
        $siapDiambilBayiNamaBarang = [];
        $belumReadyPriaNamaBarang = [];
        $belumReadyWanitaNamaBarang = [];
        $belumReadyAnakPriaNamaBarang = [];
        $belumReadyAnakWanitaNamaBarang = [];
        $belumReadyBayiNamaBarang = [];

        foreach ($result as $p) {
            $totalPria = $totalPria + $p->jumlah_pria;
            $totalWanita = $totalWanita + $p->jumlah_wanita;
            $totalAnakPria = $totalAnakPria + $p->jumlah_anak_pria;
            $totalAnakWanita = $totalAnakWanita + $p->jumlah_anak_wanita;
            $totalBayi = $totalBayi + $p->jumlah_bayi;
            if ($p->status == 'Siap Diambil') {

                if ($p->jumlah_pria > 0) {
                    $siapDiambilPriaItems[] = $p;
                    $siapDiambilPriaNamaBarang[] = $p->nama_barang;
                }

                if ($p->jumlah_wanita > 0) {
                    $siapDiambilWanitaItems[] = $p;
                    $siapDiambilWanitaNamaBarang[] = $p->nama_barang;
                }

                if ($p->jumlah_anak_pria > 0) {
                    $siapDiambilAnakPriaItems[] = $p;
                    $siapDiambilAnakPriaNamaBarang[] = $p->nama_barang;
                }

                if ($p->jumlah_anak_wanita > 0) {
                    $siapDiambilAnakWanitaItems[] = $p;
                    $siapDiambilAnakWanitaNamaBarang[] = $p->nama_barang;
                }

                if ($p->jumlah_bayi > 0) {
                    $siapDiambilBayiItems[] = $p;
                    $siapDiambilBayiNamaBarang[] = $p->nama_barang;
                }

                $siapDiambilPria = $siapDiambilPria + $p->jumlah_pria;
                $siapDiambilWanita = $siapDiambilWanita + $p->jumlah_wanita;
                $siapDiambilAnakPria = $siapDiambilAnakPria + $p->jumlah_anak_pria;
                $siapDiambilAnakWanita = $siapDiambilAnakWanita + $p->jumlah_anak_wanita;
                $siapDiambilBayi = $siapDiambilBayi + $p->jumlah_bayi;
            } elseif ($p->status == 'Belum Ready') {

                if ($p->jumlah_pria > 0) {
                    $belumReadyPriaItems[] = $p;
                    $belumReadyPriaNamaBarang[] = $p->nama_barang;
                }

                if ($p->jumlah_wanita > 0) {
                    $belumReadyWanitaItems[] = $p;
                    $belumReadyWanitaNamaBarang[] = $p->nama_barang;
                }

                if ($p->jumlah_anak_pria > 0) {
                    $belumReadyAnakPriaItems[] = $p;
                    $belumReadyAnakPriaNamaBarang[] = $p->nama_barang;
                }

                if ($p->jumlah_anak_wanita > 0) {
                    $belumReadyAnakWanitaItems[] = $p;
                    $belumReadyAnakWanitaNamaBarang[] = $p->nama_barang;
                }

                if ($p->jumlah_bayi > 0) {
                    $belumReadyBayiItems[] = $p;
                    $belumReadyBayiNamaBarang[] = $p->nama_barang;
                }

                $belumReadyPria = $belumReadyPria + $p->jumlah_pria;
                $belumReadyWanita = $belumReadyWanita + $p->jumlah_wanita;
                $belumReadyAnakPria = $belumReadyAnakPria + $p->jumlah_anak_pria;
                $belumReadyAnakWanita = $belumReadyAnakWanita + $p->jumlah_anak_wanita;
                $belumReadyBayi = $belumReadyBayi + $p->jumlah_bayi;
            }
        }
        $logistikPaket['siapDiambilPria'] = $siapDiambilPria;
        $logistikPaket['siapDiambilWanita'] = $siapDiambilWanita;
        $logistikPaket['siapDiambilAnakPria'] = $siapDiambilAnakPria;
        $logistikPaket['siapDiambilAnakWanita'] = $siapDiambilAnakWanita;
        $logistikPaket['siapDiambilBayi'] = $siapDiambilBayi;
        $logistikPaket['belumReadyPria'] = $belumReadyPria;
        $logistikPaket['belumReadyWanita'] = $belumReadyWanita;
        $logistikPaket['belumReadyAnakPria'] = $belumReadyAnakPria;
        $logistikPaket['belumReadyAnakWanita'] = $belumReadyAnakWanita;
        $logistikPaket['belumReadyBayi'] = $belumReadyBayi;
        $logistikPaket['totalPria'] = $totalPria;
        $logistikPaket['totalWanita'] = $totalWanita;
        $logistikPaket['totalAnakPria'] = $totalAnakPria;
        $logistikPaket['totalAnakWanita'] = $totalAnakWanita;
        $logistikPaket['totalBayi'] = $totalBayi;
        $logistikPaket['siapDiambilPriaItems'] = $siapDiambilPriaItems;
        $logistikPaket['siapDiambilWanitaItems'] = $siapDiambilWanitaItems;
        $logistikPaket['siapDiambilAnakPriaItems'] = $siapDiambilAnakPriaItems;
        $logistikPaket['siapDiambilAnakWanitaItems'] = $siapDiambilAnakWanitaItems;
        $logistikPaket['siapDiambilBayiItems'] = $siapDiambilBayiItems;
        $logistikPaket['belumReadyPriaItems'] = $belumReadyPriaItems;
        $logistikPaket['belumReadyWanitaItems'] = $belumReadyWanitaItems;
        $logistikPaket['belumReadyAnakPriaItems'] = $belumReadyAnakPriaItems;
        $logistikPaket['belumReadyAnakWanitaItems'] = $belumReadyAnakWanitaItems;
        $logistikPaket['belumReadyBayiItems'] = $belumReadyBayiItems;

        $logistikPaket['siapDiambilPriaNamaBarang'] = $siapDiambilPriaNamaBarang;
        $logistikPaket['siapDiambilWanitaNamaBarang'] = $siapDiambilWanitaNamaBarang;
        $logistikPaket['siapDiambilAnakPriaNamaBarang'] = $siapDiambilAnakPriaNamaBarang;
        $logistikPaket['siapDiambilAnakWanitaNamaBarang'] = $siapDiambilAnakWanitaNamaBarang;
        $logistikPaket['siapDiambilBayiNamaBarang'] = $siapDiambilBayiNamaBarang;
        $logistikPaket['belumReadyPriaNamaBarang'] = $belumReadyPriaNamaBarang;
        $logistikPaket['belumReadyWanitaNamaBarang'] = $belumReadyWanitaNamaBarang;
        $logistikPaket['belumReadyAnakPriaNamaBarang'] = $belumReadyAnakPriaNamaBarang;
        $logistikPaket['belumReadyAnakWanitaNamaBarang'] = $belumReadyAnakWanitaNamaBarang;
        $logistikPaket['belumReadyBayiNamaBarang'] = $belumReadyBayiNamaBarang;
        // if ($jk == null || empty($result)) {
        //     return $logistikPaket;
        // }

        //cek apakah jamaah bayi atau bukan
        if ($umur <= 2) {
            $status = 'bayi';
        } elseif ($umur > 2 && $umur <= 6) {
            $status = 'anak';
        } else {
            $status = 'dewasa';
        }

        foreach ($logistikPaket['perlengkapan'] as $key => $lp) {
            if ($status == 'bayi') {
                if ($lp->jumlah_bayi == 0) {
                    unset($logistikPaket['perlengkapan'][$key]);
                    continue;
                }
                $logistikPaket['perlengkapan'][$key]->jumlah_harus_ambil = $lp->jumlah_bayi;
            } else {
                if ($jk == 'L' && $status == 'anak') {
                    if ($lp->jumlah_anak_pria == 0) {
                        unset($logistikPaket['perlengkapan'][$key]);
                        continue;
                    }
                    $logistikPaket['perlengkapan'][$key]->jumlah_harus_ambil = $lp->jumlah_anak_pria;
                } elseif ($jk == 'L' && $status == 'dewasa') {
                    if ($lp->jumlah_pria == 0) {
                        unset($logistikPaket['perlengkapan'][$key]);
                        continue;
                    }
                    $logistikPaket['perlengkapan'][$key]->jumlah_harus_ambil = $lp->jumlah_pria;
                } elseif ($jk == 'P' && $status == 'anak') {
                    if ($lp->jumlah_anak_wanita == 0) {
                        unset($logistikPaket['perlengkapan'][$key]);
                        continue;
                    }
                    $logistikPaket['perlengkapan'][$key]->jumlah_harus_ambil = $lp->jumlah_anak_wanita;
                } elseif ($jk == 'P' && $status == 'dewasa') {
                    if ($lp->jumlah_wanita == 0) {
                        unset($logistikPaket['perlengkapan'][$key]);
                        continue;
                    }
                    $logistikPaket['perlengkapan'][$key]->jumlah_harus_ambil = $lp->jumlah_wanita;
                }
            }
        }
        //////////////////////////////////////////////////////////

        return $logistikPaket;
    }

    public function getAmbilList($idMember, $considerStok = false)
    {
        $this->load->model('registrasi');
        $jamaah = $this->registrasi->getJamaah(null, null, $idMember);
        if (!$jamaah) {
            return false;
        }
        if (empty($jamaah->member)) {
            return false;
        }
        $idPaket = $jamaah->member[0]->id_paket;
        if ($idPaket == null || $idPaket == false) {
            return false;
        }

        $sudahAmbil = $this->getPerlengkapanSudahAmbil($idMember);
        $sudahAmbilItemsId = [];
        foreach ($sudahAmbil['items'] as $sdhAmbil) {
            $sudahAmbilItemsId[] = $sdhAmbil->id_logistik;
        }
        //jika belum ada data jenis kelamin maka anggap laki-laki
        if (!$jamaah->jenis_kelamin) {
            $jamaah->jenis_kelamin = 'L';
        }
        $umur = $this->calculate->age($jamaah->tanggal_lahir);
        $perlengkapanPaket = $this->getPerlengkapanPaket($idPaket, 'Siap Diambil', $jamaah->jenis_kelamin, $umur);
        $listAmbil = [];
        foreach ($perlengkapanPaket['perlengkapan'] as $perlengkapan) {
            if ($considerStok == true && $perlengkapan->stok <= 0) {
                continue;
            }
            if (!in_array($perlengkapan->id_logistik, $sudahAmbilItemsId)) {
                $listAmbil[] = $perlengkapan;
            }
        }
        return $listAmbil;
    }

    public function batalkanPending($id_perlmember)
    {
        $this->db->where('id_perlmember', $id_perlmember);
        $perlAmbil = $this->db->get('perlengkapan_member')->row_array();
        if (empty($perlAmbil)) {
            return false;
        }
        $id_logistik = $perlAmbil['id_logistik'];
        $stockAmbil = $perlAmbil['jumlah_ambil'];
        $this->db->trans_start();
        $this->db->where('id_logistik', $id_logistik);
        $this->db->set('stok_kantor', "`stok_kantor` + $stockAmbil", FALSE);
        if (!$this->db->update('logistik')) {
            return false;
        }

        $this->db->where('id_perlmember', $id_perlmember);
        if (!$this->db->delete('perlengkapan_member')) {
            return false;
        }
        $this->db->trans_complete();
        return true;
    }

    public function hapusPending($id_perlmember) 
    {
        $this->db->where('id_perlmember', $id_perlmember);
        if (!$this->db->delete('perlengkapan_member')) {
            return false;
        }
        return true;
    }

    public function getStatusPerlengkapanMember($idMember)
    {
        $this->load->model('registrasi');
        $jamaah = $this->registrasi->getJamaah(null, null, $idMember);
        if (!$jamaah) {
            return false;
        }
        if (empty($jamaah->member)) {
            return false;
        }
        $idPaket = $jamaah->member[0]->id_paket;
        if ($idPaket == null || $idPaket == false) {
            return false;
        }

        $sudahAmbil = $this->getPerlengkapanSudahAmbil($idMember);

        $perlengkapanPaket = $this->getPerlengkapanPaket($idPaket, 'Siap Diambil', $jamaah->jenis_kelamin);
        $countPerlengkapan = count($perlengkapanPaket['perlengkapan']);
        $countSudahAmbil = 0;
        foreach ($perlengkapanPaket['perlengkapan'] as $perlengkapan) {
            $noMatch = true;
            foreach ($sudahAmbil['items'] as $sdhAmbil) {

                if ($sdhAmbil->id_logistik == $perlengkapan->id_logistik) {
                    $countSudahAmbil++;
                }
            }
        }

        // itu lu dapet status ambilnya darimana dah? yg di query
        //


        if ($countSudahAmbil > 0 && $countPerlengkapan > 0) {
            if ($countPerlengkapan == $countSudahAmbil) {
                $status = "Sudah Semua";
            } else {
                $status = "Sudah Sebagian";
            }
        } else {
            $status = "Belum Ambil";
        }
        return $status;
    }

    public function getStatusPerlengkapanPaket($idPaket)
    {
        $perlengkapan = $this->getPerlengkapanPaket($idPaket);
        $data['pria']['total'] = 0;
        $data['pria']['siap'] = 0;
        $data['pria']['belum'] = 0;

        $data['wanita']['total'] = 0;
        $data['wanita']['siap'] = 0;
        $data['wanita']['belum'] = 0;

        foreach ($perlengkapan['perlengkapan'] as $p) {
            $data['pria']['total'] += $p->jumlah_pria;
            $data['wanita']['total'] += $p->jumlah_wanita;

            if ($p->status == 'Siap Diambil') {
                $data['pria']['siap'] += $p->jumlah_pria;
                $data['wanita']['siap'] += $p->jumlah_wanita;
            } elseif ($p->status == 'Belum Ready') {
                $data['pria']['belum'] += $p->jumlah_pria;
                $data['wanita']['belum'] += $p->jumlah_wanita;
            }
        }
        return $data;
    }

    public function getStatusPengambilan($idPaket = null)
    {
        $this->load->model('registrasi');
        $members = $this->registrasi->getMember(null, null, $idPaket);

        $belum = [];
        $sebagian = [];
        $semua = [];

        $this->load->model('logistik');
        if ($members) {

            foreach ($members as $key => $member) {
                unset($member->paket_info);
                $status = $this->logistik->getStatusPerlengkapanMember($member->id_member);
                switch ($status) {
                    case 'Sudah Semua':
                        $semua[] = $member;
                        break;
                    case 'Sudah Sebagian':
                        $sebagian[] = $member;
                        break;
                    case 'Belum Ambil':
                        $belum[] = $member;
                        break;
                    default:
                        break;
                }
            }
        }
        $data = [
            'data' => [
                'semua' => $semua,
                'sebagian' => $sebagian,
                'belum' => $belum
            ],
            'total' => count($belum) + count($sebagian) + count($semua),
            'belumAmbil' => count($belum),
            'sudahSebagian' => count($sebagian),
            'sudahSemua' => count($semua)
        ];
        return $data;
    }
    public function getPendingBooking($idMember)
    {
        return $this->getPerlengkapanSudahAmbil($idMember, 'Pending');
    }

    public function getPendingBookingStatus($idMember)
    {
        return $this->getPerlengkapanSudahAmbil($idMember, 'Siap');
    }

    public function getPerlengkapanSudahAmbil($idMember, $status = 'Selesai')
    {
        // disini di join dengan perlengkapan member
        // yang gw fikir adalah perlengkapan member itu barang yang sudah diambil
        // soalnya kita kembali ke getStatus tadi

        $this->db->start_cache();
        $this->db->where('id_member', $idMember);
        if ($status != 'all') {
            $this->db->where('status', $status);
        }
        $this->db->join('logistik', 'logistik.id_logistik = perlengkapan_member.id_logistik');
        $this->db->stop_cache();
        $this->db->order_by('logistik.nama_barang', 'ASC');
        $sudahAmbil = $this->db->get('perlengkapan_member')->result();

        $data['items'] = $sudahAmbil;

        //group by date
        $this->db->group_by('tanggal_ambil');
        $this->db->order_by('tanggal_ambil', 'ASC');
        $group = $this->db->get('perlengkapan_member')->result();
        $this->db->flush_cache();

        $dateGroup = [];
        foreach ($group as $gr) {
            foreach ($sudahAmbil as $sdh) {
                if ($sdh->tanggal_ambil == $gr->tanggal_ambil) {
                    $prettyDate =  $this->date->convert("l, j F Y", $gr->tanggal_ambil);
                    $dateGroup[$prettyDate][] = $sdh;
                }
            }
        }

        $data['dateGroup'] = $dateGroup;

        return $data;
    }

    public function getPerlengkapanSudahAmbilPerBarang($idMember)
    {
        // disini di join dengan perlengkapan member
        // yang gw fikir adalah perlengkapan member itu barang yang sudah diambil
        // soalnya kita kembali ke getStatus tadi

        $this->db->start_cache();
        $this->db->where('id_member', $idMember);
        $this->db->join('logistik', 'logistik.id_logistik = perlengkapan_member.id_logistik');
        $this->db->stop_cache();
        $this->db->order_by('logistik.nama_barang', 'ASC');
        $sudahAmbil = $this->db->get('perlengkapan_member')->result();
        $this->db->flush_cache();

        
        //group by date
        $barang = $this->getBarang();

        $itemsGroup = [];
        $totalItems = [];
        foreach ($barang as $br) {
            if (!empty($sudahAmbil)) {
                foreach ($sudahAmbil as $key => $sdh) {
                    if ($sdh->id_logistik == $br->id_logistik) {
                        $itemsGroup["items"][$br->nama_barang] = 1 ;
                    }
                }
                if (!empty($itemsGroup['items'])) {
                    foreach ($itemsGroup['items'] as $key => $item) {
                        if ($br->nama_barang == $key) {
                            $totalItems["$br->nama_barang"] = 1 ;
                        } else {
                            $totalItems["$br->nama_barang"] = 0 ;
                        }
                    }
                } else {
                    $totalItems[$br->nama_barang] = 0;
                }
            } else {
                $totalItems[$br->nama_barang] = 0;
            }
        }
        return $totalItems;
    }

    public function setPendingAmbil($perlmemberIds, $idPaket, $fullName, $tempat_ambil = "ho")
    {
        foreach ($perlmemberIds as $id_perlmember) {
            $this->db->where('id_perlmember', $id_perlmember);
            $data = $this->db->get('perlengkapan_member')->row();
            if (empty($data)) {
                $this->alert->set('danger', 'Perlengkapan gagal diambil');
                return false;
            }
            $barang = $this->getBarang($data->id_logistik);
            $nama_barang = $barang[0]->nama_barang;
            $stok_kantor = $barang[0]->stok_kantor;
            $stok_bandung = $barang[0]->stok_bandung;

            //update stok
           if ($stok_kantor != 0 || $stok_bandung != 0) {
            $this->db->where('id_logistik', $data->id_logistik);
            if ($tempat_ambil == "ho") {
                $this->db->set("stok_kantor", $stok_kantor - $data->jumlah_ambil);
                $stok_result = $stok_kantor;
            } else {
                $this->db->set("stok_bandung", $stok_bandung - $data->jumlah_ambil);
                $stok_result = $stok_bandung;
            }
            $this->db->update('logistik');
           } else {
            $this->alert->set("danger", "Stok kantor $nama_barang habis !!");
            return false ;
           }

            $paket = $this->paketUmroh->getPackage($idPaket);
            if (isset($_SESSION['id_staff'])) {
                $id_staff = $_SESSION['id_staff'];
            } else {
                $id_staff = null;
            }

            if (isset($_SESSION['id_agen'])) {
                $id_agen = $_SESSION['id_agen'];
            } else {
                $id_agen = null;
            }

            if (isset($_SESSION['id_member'])) {
                $id_member = $_SESSION['id_member'];
            } else {
                $id_member = null;
            }

            $mutasiOut = [
                'id_logistik' => $data->id_logistik,
                'id_perlmember' => $id_perlmember,
                'stok_before' => $stok_result,
                'jumlah' => $data->jumlah_ambil,
                'status' => 'keluar',
                'tempat' => $tempat_ambil == "ho" ? "Kantor (Head Office)" : "Bandung",
                'note' => "$fullName mengambil perlengkapan",
                'id_paket' => $idPaket,
                'id_staff' => $id_staff,
                'id_agen' => $id_agen,
                'id_member' => $id_member,
            ];
            $this->addMutasi($mutasiOut, $mutasiOut['id_logistik']);

            $this->db->where('id_perlmember', $id_perlmember);
            $this->db->set('status', 'Selesai');
            $this->db->set("tanggal_ambil", date('Y-m-d H:i:s'));
            $this->db->set('staff', $_SESSION['nama']);
            $this->db->set('penerima', $fullName);
            $query = $this->db->update('perlengkapan_member');
            if (!$query) {
                $this->alert->set('danger', 'Perlengkapan gagal diambil');
                return false;
            }
        }
        return true;
    }

    public function setStatusPending($perlmemberIds, $status)
    {
        foreach ($perlmemberIds as $id_perlmember) {
            $this->db->where('id_perlmember', $id_perlmember);
            $this->db->set('status', $status);
            $this->db->set('staff', $_SESSION['nama']);
            if (!$this->db->update('perlengkapan_member')) {
                return false;
            }
        }
        return true;
    }

    // public function getPerlengkapanPeserta($idMember)
    // {
    //     $this->load->model('registrasi');
    //     $member = $this->registrasi->getMember($idMember);
    //     if (empty($member)) {
    //         return false;
    //     }
    //     $member = $member[0];
    //     $jamaah = $this->registrasi->getJamaah($member->id_jamaah);
    //     $perlengkapanPaket = $this->getPerlengkapanPaket($member->id_paket, null, $jamaah->jenis_kelamin);

    //     $this->db->where('id_member', $idMember);
    //     $this->db->join('logistik', 'logistik.id_logistik = perlengkapan_member.id_logistik');
    //     $this->db->order_by('logistik.nama_barang', 'ASC');
    //     $query = $this->db->get('perlengkapan_member');
    //     $sudahAmbil = $query->result();
    //     foreach ($perlengkapanPaket['perlengkapan'] as $key => $lp) {
    //         foreach ($sudahAmbil as $lm) {
    //             if ($lm->id_logistik == $lp->id_logistik) {
    //                 $perlengkapanPaket[$key]->jumlah_ambil = $lm->jumlah_ambil;
    //                 $perlengkapanPaket[$key]->tanggal_ambil = $lm->tanggal_ambil;
    //                 $perlengkapanPaket[$key]->id_perlmember = $lm->id_perlmember;
    //                 break;
    //             }
    //         }
    //     }

    //     return $perlengkapanPaket;
    // }

    public function addPerlengkapanPeserta($idMember, $items, $tanggalAmbil, $status, $jenis_ambil, $alamat_pengiriman = null , $no_pengiriman = null, $penerima = null, $ambil_tempat = "ho")
    {
        $this->load->model('registrasi');
        $jamaah = $this->registrasi->getJamaah(null, null, $idMember);
        $jk = $jamaah->jenis_kelamin;

        if (!$jamaah->member) {
            return false;
        }

        $member = $jamaah->member[0];
        $idPaket = $member->id_paket;

        $perlengkapan = $this->getPerlengkapanPaket($idPaket);
        $perlengkapanItems = $perlengkapan['perlengkapan'];
        
        if (empty($perlengkapanItems)) {
            return false;
        }
        foreach ($perlengkapanItems as $perlItems) {
            if (in_array($perlItems->id_logistik, $items)) {
                $idLogistik = $perlItems->id_logistik;

                //cek sudah diambil apa belum
                $this->db->where('id_member', $idMember);
                $this->db->where('id_logistik', $idLogistik);
                $sudahAmbil = $this->db->get('perlengkapan_member')->row_array();
                if (!empty($sudahAmbil)) {
                    //cek berapa jumlah ambilnya
                    $jumlahAmbil = $sudahAmbil['jumlah_ambil'];
                    $jumlahHarusAmbil = $perlItems->jumlah_harus_ambil;
                    $sisaHarusAmbil = $jumlahHarusAmbil - $jumlahAmbil;
                    if ($sisaHarusAmbil <= 0) {
                        continue;
                    }
                }
                //cek stok
                $barang = $this->getBarang($idLogistik);
                $stok_kantor = $barang[0]->stok_kantor;
                $stok_bandung = $barang[0]->stok_bandung;
                $stok = $barang[0]->stok;
                
                if ($jk == 'P') {
                    $decreaseSum = $perlItems->jumlah_wanita;
                } else {
                    $decreaseSum = $perlItems->jumlah_pria;
                }

                //start cek stok
                if ($status == "Pending") {
                    if ($stok >= $decreaseSum) {
                        //allow ambil perlengkapan
                        $this->db->trans_start();

                        // ambil nama staff
                        if (isset($_SESSION['id_staff'])) {
                            $staff = $_SESSION['nama'];
                        } else {
                            $staff = null ;
                        }

                        //add to perlengkapan_member table
                        if ($jenis_ambil == 'langsung') {
                            $dataAdd = [
                                'id_logistik' => $idLogistik,
                                'id_member' => $idMember,
                                'jumlah_ambil' => $decreaseSum,
                                'tanggal_ambil' => $tanggalAmbil,
                                'status' => $status,
                                'staff' => $staff,
                                'jenis_ambil' => $jenis_ambil,
                                'penerima' => $penerima
                            ];
                        }

                        if ($jenis_ambil == 'pengiriman') {
                            $dataAdd = [
                                'id_logistik' => $idLogistik,
                                'id_member' => $idMember,
                                'jumlah_ambil' => $decreaseSum,
                                'tanggal_ambil' => $tanggalAmbil,
                                'status' => $status,
                                'staff' => $staff,
                                'jenis_ambil' => $jenis_ambil,
                                'alamat_pengiriman' => $alamat_pengiriman,
                                'no_pengiriman' => $no_pengiriman,
                                'penerima' => $penerima
                            ];
                        }

                        $this->db->insert('perlengkapan_member', $dataAdd);
                        $id_perlmember = $this->db->insert_id();
                        
                        //update stok
                        $this->db->where('id_logistik', $idLogistik);
                        $this->db->set('stok', $stok - $decreaseSum);
                        if ($ambil_tempat == 'ho') {
                            $this->db->set('stok_kantor', $stok_kantor + $decreaseSum);
                            $stok_result = $stok_kantor;
                        } else {
                            $this->db->set('stok_bandung', $stok_bandung + $decreaseSum);
                            $stok_result = $stok_bandung;
                        }
                        $this->db->update('logistik');
    //tesaaaa
                        $this->load->model('paketUmroh');
                        $paket = $this->paketUmroh->getPackage($idPaket);
                        if (isset($_SESSION['id_staff'])) {
                            $id_staff = $_SESSION['id_staff'];
                        } else {
                            $id_staff = null;
                        }
    
                        if (isset($_SESSION['id_agen'])) {
                            $id_agen = $_SESSION['id_agen'];
                        } else {
                            $id_agen = null;
                        }
    
                        if (isset($_SESSION['id_member'])) {
                            $id_member = $_SESSION['id_member'];
                        } else {
                            $id_member = null;
                        }
    
                        $mutasiOut = [
                            'id_logistik' => $idLogistik,
                            'id_perlmember' => $id_perlmember,
                            'stok_before' => $stok,
                            'jumlah' => $decreaseSum,
                            'status' => 'keluar',
                            'tempat' => 'Gudang',
                            'note' => "Pending perlengkapan jamaah : $jamaah->first_name $jamaah->second_name $jamaah->last_name",
                            'id_paket' => $jamaah->member[0]->id_paket,
                            'id_staff' => $id_staff,
                            'id_agen' => $id_agen,
                            'id_member' => $id_member,
                        ];
                        $this->addMutasi($mutasiOut, $mutasiOut['id_logistik']);
    
                        $mutasiIn = [
                            'id_logistik' => $idLogistik,
                            'id_perlmember' => $id_perlmember,
                            'stok_before' => $stok_result,
                            'jumlah' => $decreaseSum,
                            'status' => 'masuk',
                            'tempat' => $ambil_tempat == "ho" ? "Kantor (Head Office)" : "Bandung",
                            'note' => "Pending perlengkapan jamaah : $jamaah->first_name $jamaah->second_name $jamaah->last_name",
                            'id_paket' => $jamaah->member[0]->id_paket,
                            'id_staff' => $id_staff,
                            'id_agen' => $id_agen,
                            'id_member' => $id_member,
                        ];
                        $this->addMutasi($mutasiIn, $mutasiIn['id_logistik']);
    
                        $this->db->trans_complete();
                    }
                }

                if ($status == "Selesai") {
                    if ($stok_kantor >= $decreaseSum) {
                        //allow ambil perlengkapan
                        $this->db->trans_start();

                        // ambil nama staff
                        if (isset($_SESSION['id_staff'])) {
                            $staff = $_SESSION['nama'];
                        } else {
                            $staff = null ;
                                                }

                        //add to perlengkapan_member table
                        if ($jenis_ambil == 'langsung') {
                            $dataAdd = [
                                'id_logistik' => $idLogistik,
                                'id_member' => $idMember,
                                'jumlah_ambil' => $decreaseSum,
                                'tanggal_ambil' => $tanggalAmbil,
                                'status' => $status,
                                'staff' => $staff,
                                'jenis_ambil' => $jenis_ambil,
                                'penerima' => $penerima
                            ];
                        }

                        if ($jenis_ambil == 'pengiriman') {
                            $dataAdd = [
                                'id_logistik' => $idLogistik,
                                'id_member' => $idMember,
                                'jumlah_ambil' => $decreaseSum,
                                'tanggal_ambil' => $tanggalAmbil,
                                'status' => $status,
                                'staff' => $staff,
                                'jenis_ambil' => $jenis_ambil,
                                'alamat_pengiriman' => $alamat_pengiriman,
                                'no_pengiriman' => $no_pengiriman,
                                'penerima' => $penerima
                            ];
                        }
    
                        $this->db->insert('perlengkapan_member', $dataAdd);
                        $id_perlmember = $this->db->insert_id();
                        
                        //update stok
                        $this->db->where('id_logistik', $idLogistik);
                        if ($ambil_tempat == 'ho') {
                            $this->db->set('stok_kantor', $stok_kantor - $decreaseSum);
                            $stok_result = $stok_kantor;
                        } else {
                            $this->db->set('stok_bandung', $stok_bandung - $decreaseSum);
                            $stok_result = $stok_bandung;
                        }
                        $this->db->update('logistik');
    //tesaaaa
                        $this->load->model('paketUmroh');
                        $paket = $this->paketUmroh->getPackage($idPaket);
                        if (isset($_SESSION['id_staff'])) {
                            $id_staff = $_SESSION['id_staff'];
                        } else {
                            $id_staff = null;
                        }
    
                        if (isset($_SESSION['id_agen'])) {
                            $id_agen = $_SESSION['id_agen'];
                        } else {
                            $id_agen = null;
                        }
    
                        if (isset($_SESSION['id_member'])) {
                            $id_member = $_SESSION['id_member'];
                        } else {
                            $id_member = null;
                        }
    
                        $mutasiOut = [
                            'id_logistik' => $idLogistik,
                            'id_perlmember' => $id_perlmember,
                            'stok_before' => $stok_result,
                            'jumlah' => $decreaseSum,
                            'status' => 'keluar',
                            'tempat' => $ambil_tempat == "ho" ? "Kantor (Head Office)" : "Bandung",
                            'note' => "$jamaah->first_name $jamaah->second_name $jamaah->last_name mengambil perlengkapan",
                            'id_paket' => $jamaah->member[0]->id_paket,
                            'id_staff' => $id_staff,
                            'id_agen' => $id_agen,
                            'id_member' => $id_member,
                        ];
                        $this->addMutasi($mutasiOut, $mutasiOut['id_logistik']);
    
                        $this->db->trans_complete();
                    }
                }
            }
        }
        return true;
    }

    public function addPerlengkapanPaket($idp, $data)
    {
        //get data from db
        $this->db->where('id_paket', $idp);
        $query = $this->db->get('perlengkapan_paket');
        $result = $query->result();
        //check for deletion
        if (!empty($result)) {
            foreach ($result as $r) {
                $delete = true;
                if (!empty($data)) {
                    foreach ($data['id_paket'] as $key => $idPaket) {
                        if ($idPaket == $r->id_paket && $data['id_logistik'][$key] == $r->id_logistik) {
                            $delete = false;
                            break;
                        }
                    }
                }
                if ($delete == true) {
                    $this->db->where('id_paket', $r->id_paket);
                    $this->db->where('id_logistik', $r->id_logistik);
                    $this->db->delete('perlengkapan_paket');
                }
            }
        }

        //insert or update
        if (!empty($data)) {
            foreach ($data['id_paket'] as $key => $idPaket) {
                $ins = array(
                    'id_paket' => $idPaket,
                    'id_logistik' => $data['id_logistik'][$key],
                    'jumlah_pria' => $data['jumlah_pria'][$key],
                    'jumlah_wanita' => $data['jumlah_wanita'][$key],
                    'jumlah_anak_pria' => $data['jumlah_anak_pria'][$key],
                    'jumlah_anak_wanita' => $data['jumlah_anak_wanita'][$key],
                    'jumlah_bayi' => $data['jumlah_bayi'][$key]
                );
                //check if already exist then update else insert
                $this->db->where('id_paket', $idPaket);
                $this->db->where('id_logistik', $data['id_logistik'][$key]);
                $query = $this->db->get('perlengkapan_paket');
                $exist = $query->result();
                if (!empty($exist)) {
                    $this->db->where('id_paket', $idPaket);
                    $this->db->where('id_logistik', $data['id_logistik'][$key]);
                    $this->db->update('perlengkapan_paket', $ins);
                } else {
                    $this->db->insert('perlengkapan_paket', $ins);
                }
            }
        }
        return true;
    }

    public function setStatusPerlengkapanPaket($ids, $status)
    {
        if (empty($ids)) {
            return false;
        }
        foreach ($ids as $id) {
            $this->db->where('id_perlpaket', $id);
            $this->db->set('status', $status);
            $this->db->update('perlengkapan_paket');
        }
        return true;
    }

    // public function balikRequest($id, $id_perl)
    // {   
    //     // ambil data sesudahnya
    //     $this->db->where('id_barang', $id);
    //     $before = $this->db->get('permintaan_office')->row();
    //     //////////////////////////////////
    //     if (isset($id)) {
    //         $this->db->where('id_barang', $id);
    //         $query = $this->db->get('permintaan_office');
    //         $pinjam = $query->row();
    //     }
        
    //     $row = $this->getPerlengkapanOffice($id_perl);

    //     if ($pinjam->id_perlkantor == $row->id_perlkantor) {
    //         $row->nama_barang = $pinjam->nama_barang;
    //         $row->jumlah = $row->jumlah + $pinjam->jumlah;
    //         if($row) {
    //             $id = $row->id_perlkantor;
    //             unset($row->id_perlkantor);
    //             $this->db->where('id_perlkantor',$id);
    //             $data = $this->db->update('perlengkapan_kantor', $row);
    //         }
    //     }
        
    //     // ambil data sesudahnya
    //     $this->db->where('id_barang', $id);
    //     $before = $this->db->get('permintaan_office')->row();
    //     //////////////////////////////////


    //     ////add log
    //     $id = $this->db->insert_id();
    //     $this->load->model('logs');
    //     $this->logs->addLog('pk', $id);
    //     return $id;
    // }

    // public function balikPinjam($id, $id_perl)
    // {   
    //     if (isset($id)) {
    //         $this->db->where('id_barang', $id);
    //         $query = $this->db->get('peminjaman_office');
    //         $pinjam = $query->row();
    //     }
        
    //     $row = $this->getPerlengkapanOffice($id_perl);

    //     if ($pinjam->id_perlkantor == $row->id_perlkantor) {
    //         $row->nama_barang = $pinjam->nama_barang;
    //         $row->jumlah = $row->jumlah + $pinjam->jumlah;
    //         if($row) {
    //             $id = $row->id_perlkantor;
    //             unset($row->id_perlkantor);
    //             $this->db->where('id_perlkantor',$id);
    //             $data = $this->db->update('perlengkapan_kantor', $row);
    //         }
    //     }



    //     ////add log
    //     $id = $this->db->insert_id();
    //     $this->load->model('logs');
    //     $this->logs->addLog('pk', $id);
    //     return $id;
    // }


    public function tambahLogOffice($data)
    {
        $data['status'] = 'Pinjam';
        $query = $this->db->insert('log_perlengkapan_kantor', $data);
        if ($query == false) {
            return false;
        }
        
        //add log
        $id = $this->db->insert_id();
        $this->load->model('logs');
        $this->logs->addLog('lpk', $id);

        $permintaan = $data;
        $minta = $this->db->insert('peminjaman_office', $permintaan);
        if ($minta == false) {
            return false;
        }

        $id = $this->db->insert_id();
        $this->load->model('logs');
        $this->logs->addLog('pof', $id);
        
        return true;
    }
    
    public function requestBarang($data) {
        $data['status'] = 'Minta';
        $log = $data;
        $query = $this->db->insert('log_perlengkapan_kantor', $log);
        if ($query == false) {
            return false;
        }
        
        //add log
        $id = $this->db->insert_id();
        $this->load->model('logs');
        $this->logs->addLog('lpk', $id);

        $permintaan = $data;
        $minta = $this->db->insert('permintaan_office', $permintaan);
        if ($minta == false) {
            return false;
        }

        $id = $this->db->insert_id();
        $this->load->model('logs');
        $this->logs->addLog('po', $id);
        
        return true;
    }

    public function deleteRequest($id)
    {
        $this->db->where('id_barang', $id);
        $query = $this->db->delete('permintaan_office');
        if ($query == false) {
            return false;
        } else {
            return true;
        }
    }

    public function deleteBarangOffice($id)
    {
        $this->db->where('id_perlkantor', $id);
        $query = $this->db->delete('perlengkapan_kantor');
        if ($query == false) {
            return false;
        } else {
            return true;
        }
    }

    public function deleteLog($id)
    {
        $this->db->where('id_pinjam', $id);
        $query = $this->db->delete('log_perlengkapan_kantor');
        if ($query == false) {
            return false;
        } else {
            return true;
        }
    }

    public function deletePinjam($id)
    {
        $this->db->where('id_barang', $id);
        $query = $this->db->delete('peminjaman_office');
        if ($query == false) {
            return false;
        } else {
            return true;
        }
    }

    public function changePic($id, $pic)
    {
        $this->load->library('scan');
        if (isset($pic)) {
            $hasil = $this->scan->check($pic, 'perlengkapan_pic', null);
            if ($hasil !== false) {
                $file = $hasil;
            }
        }

        // Check file size
        if ($pic["size"] > 5000000) {
            $this->alert->set('danger', 'File terlalu besar, ukuran maksimal 5 MB');
            return false;
        }

        $barang = $this->getBarang($id);
        if ($barang[0]) {
            $id_logistik = $barang[0]->id_logistik;
            $this->db->where('id_logistik', $id_logistik);
            $this->db->update('logistik', array('pic' => $file));
            $this->alert->set('success', 'Profile Picture berhasil diganti');
        } else {
            $this->alert->set('danger', 'Terjadi error pada server, mohon coba kembali');
            return false;
        }

        //add log
        $this->load->model('logs');
        $this->logs->addLog('lg', $id);
        return true;
    }

    public function hapusPic($id)
    {
        $this->db->where('id_logistik', $id);
        $barang = $this->db->get('logistik')->row();
        if ($barang->pic == null) {
            return false;
        }


        $path = $barang->pic;
        unlink(SITE_ROOT . $path);

        $this->db->where('id_logistik', $id);
        $this->db->set('pic', null);
        if (!$this->db->update('logistik')) {
            return false ;
        }
        
        return true ;
    }

    public function addMutasi($data, $id) {
        $mutasi = $this->db->insert('mutasi_barang', $data);
        if ($mutasi == false) {
            return false;
        }

        $id_mutasi = $this->db->insert_id();
        // $this->load->model('logs');
        // $this->logs->addLog('m', $id_mutasi);
        // ambil data sesudahnya
        $this->db->where('id_mutasi', $id_mutasi);
        $after = $this->db->get('mutasi_barang')->row();
        //////////////////////////////////
        //add log
        $this->load->model('logs');
        $this->logs->addLogTable($id_mutasi, 'm', null, $after);
        
        return true; 
    }

    public function getMutasiMonth() {
        $this->db->order_by('tanggal', 'asc');
        $this->db->group_by('MONTH(tanggal)');
        $this->db->select('tanggal');
        $query = $this->db->get('mutasi_barang');
        $data = $query->result();

        return $data;
    }

    public function getMutasi($id_mutasi = null, $id_logistik = null, $id_staff = null) {
        if ($id_mutasi != null) {
            $this->db->where('id_mutasi', $id_mutasi);
        }

        if ($id_logistik != null) {
            $this->db->where('id_$id_logistik', $id_logistik);
        }

        if ($id_staff != null) {
            $this->db->where('id_staff', $id_staff);
        }
        $query = $this->db->get('mutasi_barang');
        $data = $query->result();

        return $data;
    }

    public function delPerlengkapanMember() {
        $this->db->where("(tanggal_ambil <= NOW() OR tanggal_ambil IS null)");
        $this->db->where('status =', 'Siap');
        $this->db->where('jenis_ambil', null);
        $this->db->where('jenis_ambil', 'langsung');
        $query = $this->db->get('perlengkapan_member')->result();
        if ($query) {
            foreach ($query as $q) {
                $this->hapusPending($q->id_perlmember);
            }
        }
        $this->db->where("(tanggal_ambil <= NOW() OR tanggal_ambil IS null)");
        $this->db->where('status =', 'Pending');
        $this->db->where('jenis_ambil', null);
        $this->db->where('jenis_ambil', 'langsung');
        $data = $this->db->get('perlengkapan_member')->result();
        if ($data) {
            foreach ($data as $d) {
                $this->hapusPending($d->id_perlmember);
            }
        } else {
            return false ;
        }
        
        // pengiriman
        $this->db->where("(tanggal_ambil < (DATE(NOW()) -3)");
        $this->db->where("(tanggal_ambil > (DATE(NOW()) -4)");
        $this->db->where('status =', 'Siap');
        $this->db->where('jenis_ambil', 'pengiriman');
        $query = $this->db->get('perlengkapan_member')->result();
        if ($query) {
            foreach ($query as $q) {
                $this->hapusPending($q->id_perlmember);
            }
        }
        $this->db->where("(tanggal_ambil < (DATE(NOW()) -3)");
        $this->db->where("(tanggal_ambil > (DATE(NOW()) -4)");
        $this->db->where('status =', 'Pending');
        $this->db->where('jenis_ambil', 'pengiriman');
        $data = $this->db->get('perlengkapan_member')->result();
        if ($data) {
            foreach ($data as $d) {
                $this->hapusPending($d->id_perlmember);
            }
        } else {
            return false ;
        }
        
        return true;
    }

    public function getRiwayatAmbil($id_member) 
    {
        //get data member
        $this->db->where('id_member', $id_member);
        $query = $this->db->get('program_member');
        $data_member = $query->row();
        if (empty($data_member)) {
            return false;
        }
        
        $this->load->model('registrasi');
        $jamaah = $this->registrasi->getJamaah($data_member->id_jamaah);
        $nama = implode(' ', array_filter([$jamaah->first_name, $jamaah->second_name, $jamaah->last_name]));
        // get parent 
        $members = [];
        if ($data_member->parent_id) {
            $this->db->where('parent_id', $data_member->parent_id);
            $query = $this->db->get('program_member');
            $members = $query->result();
        } else {
            $members[] = $data_member;
        }

        foreach ($members as $key => $member) {
            $members[$key]->status = $this->getStatusPerlengkapanMember($member->id_member);

            // ambil perlengkapan member
            $this->load->model('registrasi');
            $jamaah = $this->registrasi->getJamaah($member->id_jamaah);
            $perlengkapanPaket = $this->getPerlengkapanPaket($member->id_paket, 'Siap Diambil', $jamaah->jenis_kelamin);
            $members[$key]->result = $perlengkapanPaket['perlengkapan'];

            // ambil perlengkapan member sudah ambil
            $ambil = $this->getPerlengkapanSudahAmbil($member->id_member);
            $members[$key]->riwayatAmbil = $ambil;

            //ambil data Jamaah
            $jamaah = $this->registrasi->getJamaah($member->id_jamaah);
            $members[$key]->jamaahData = $jamaah; 

        }

        // validasi checklist
        // foreach ($members as $key => $member) {
        //     foreach ($member->riwayatAmbil as $ambil) {
        //         foreach ($member->result as $key => $r) {
        //             if ($ambil->id_logistik == $r->id_logistik) {
        //                 $member->result[$key]->checkList = 1;
        //             } else {
        //                 $member->result[$key]->checkList = 0;
        //             }
        //         }
        //     }
        // }
        $data = [
            'members' => $members,
            'nama' => $nama
        ];

        return $data;
    }
}