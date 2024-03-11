<?php

defined('BASEPATH') or exit('No direct script access allowed');

class JamaahDashboard extends CI_Model
{

    public function getStatus($member)
    {
        if ($member->lunas == 0) {
            $DPStatus = true;
        } else {
            $DPStatus = false;
        }

        if ($member->lunas == 1 || $DPStatus == true) {
            $lunasStatus = false;
        } else {
            $lunasStatus = true;
        }

        $this->load->model('tarif');
        $bayar = $this->tarif->getPembayaran($member->id_member);
        $unconfirmedPay = false;
        foreach ($bayar['data'] as $byr) {
            if ($byr->verified != 2) {
                $unconfirmedPay = true;
                break;
            }
        }
        if ($member->verified != 1 && $unconfirmedPay == true) {
            $dataStatus = true;
        } else {
            $dataStatus = false;
        }

        if ($unconfirmedPay == true) {
            $displayBroadcast = true;
        } else {
            $displayBroadcast = false;
        }

        $result = array(
            'DPStatus' => $DPStatus,
            'dataStatus' => $dataStatus,
            'lunasStatus' => $lunasStatus,
            'displayBroadcast' => $displayBroadcast
        );
        return $result;
    }

    public function getChecklistData($member)
    {
        //CHECK LUNAS
        if ($member->lunas == 1) {
            $data['lunas'] = true;
        } else {
            $data['lunas'] = false;
        }

        //CHECK DATA DAN DOKUMEN
        $this->load->model('registrasi');
        $jamaah = $this->registrasi->getJamaah($member->id_jamaah);

        if ($member->verified == 1 && $jamaah->verified == 1 ) {
            $data['dokumen'] = true;
        } else {
            $data['dokumen'] = false;
        }
        //get family member
        // $familyMembers = [];
        // if ($member->parent_id) {
        //     $familyMembers = $this->registrasi->getGroupMembers($member->parent_id);
        // } else {
        //     $familyMembers[0] = new \stdClass();
        //     $familyMembers[0]->jamaahData = new \stdClass();
        //     $familyMembers[0]->memberData = new \stdClass();
        //     $familyMembers[0]->jamaahData = $this->registrasi->getJamaah(null, null, $member->id_member);
        //     $familyMembers[0]->memberData = $familyMembers[0]->jamaahData->member[0];
        // }
        // $uncheckJamaah = ['referensi', 'log' ,'member', 'id_jamaah', 'token', 'second_name', 'last_name','status_perkawinan',
        // 'no_rumah' , 'email', 'alamat_tinggal', 'provinsi', 'kecamatan', 'kabupaten_kota', 'kewarganegaraan', 'pekerjaan', 'pendidikan_terakhir', 'office'];
        // $uncheckMember = [
        //     'id_member', 'id_jamaah', 'id_paket', 'parent_id', 'register_from', 'pernah_umroh',
        //     'id_agen', 'manifest_order', 'room_number', 'total_harga', 'lunas', 'dp_expiry_time',
        //     'va_open', 'log', 'tiket_scan', 'visa_scan', 'paket_info', 'agen', 'tgl_regist', 'buku_kuning_check', 
        //     'paspor_scan2', 'valid', 'paspor_no', 'paspor_name','paspor_issue_date','paspor_expiry_date', 'paspor_issuing_city', 'vaksin_scan' , 'pilihan_kamar', 'foto_scan', 'foto_check'
        // ];
        // foreach ($familyMembers as $fam) {
        //     $dataJamaah = (array) $fam->jamaahData;
        //     $dataMember = (array) $fam->memberData;

        //     //hapus index yang tidak ingin di cek
        //     foreach ($uncheckJamaah as $unj) {
        //         unset($dataJamaah[$unj]);
        //     }
        //     foreach ($uncheckMember as $unm) {
        //         unset($dataMember[$unm]);
        //     }

        //     foreach ($dataJamaah as $dj) {
        //         if ($dj != null || $dj != 0 || $dj != '') {
        //             $data['dokumen'] = true;
        //         } else {
        //             $data['dokumen'] = false;
        //             break ;
        //         }
        //     }
        //     if ($dataJamaah['verified'] == 1 && $data['dokumen'] == true) {
        //         $data['dokumen'] = true;
        //     } else {
        //         $data['dokumen'] = false;
        //         break;
        //     }

        //     foreach ($dataMember as $dm) {
        //         if ($dm != null || $dm != 0 || $dm != '') {
        //             $data['dokumen'] = true;
        //         } else {
        //             $data['dokumen'] = false;
        //             break;
        //         }
        //     }
        //     if ($dataMember['verified'] == 1 && $data['dokumen'] == true) {
        //         $data['dokumen'] = true;
        //     } else {
        //         $data['dokumen'] = false;
        //         break;
        //     }
        //     if ($data['dokumen'] == false) {
        //         break;
        //     }
        //     // echo '<pre>';
        //     // print_r($data['dokumen']);
        //     // exit();
        // }


        // CHECK STATUS PERLENGKAPAN
        $this->load->model('logistik');
        $data['perlengkapan'] = true;
        // foreach ($familyMembers as $fam) {
            $perlengkapan = $this->logistik->getStatusPerlengkapanMember($member->id_member);
            if ($perlengkapan != 'Sudah Semua') {
                $data['perlengkapan'] = false;
            }
        // }
        return $data;
    }
}
                        
/* End of file Jamaah_dashboard.php */