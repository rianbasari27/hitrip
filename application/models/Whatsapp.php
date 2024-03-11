<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Whatsapp extends CI_Model
{

    public function debugLog($o, $type = 'webhook_response')
    {
        $logDir = $this->config->item('wa_log_dir');
        $file_debug = $logDir . 'debug-wa-' . date("Y-m-d") . '.log.txt';
        ob_start();
        print_r(date("Y-m-d H:i:s"));
        echo "\n";
        print_r($type);
        echo "\n";
        print_r($o);
        $c = ob_get_contents();
        ob_end_clean();

        $f = fopen($file_debug, "a");
        fputs($f, "$c\n");
        fflush($f);
        fclose($f);
    }
    public function verifyWebhook($payload)
    {
        if (!(isset($payload['hub_mode']) && isset($payload['hub_challenge']) && isset($payload['hub_verify_token']))) {
            return false;
        }
        if ($payload['hub_mode'] != 'subscribe') {
            return false;
        }
        $config_token = $this->config->item('wa_verify_token');

        if ($payload['hub_verify_token'] == $config_token) {
            return $payload['hub_challenge'];
        } else {
            return false;
        }
    }

    public function addWALog($id_member, $keterangan) {
        if (isset($_SESSION['id_staff'])) {
            $id_staff = $_SESSION['id_staff'];
        } else {
            $id_staff = null ;
        }
        $data = array (
            'id_member' => $id_member,
            'id_staff' => $id_staff,
            'keterangan' => $keterangan
        );
        if (!$this->db->insert('wa_log', $data)) {
            return false;
        }
        return true;

    }

    public function getLog($id) {
        $this->db->where('id_member', $id);
        $data = $this->db->get('wa_log')->result();

        return $data;
    }

    public function sendMessageDp() {
        $this->db->from('program_member a');
        $this->db->join('paket_umroh b', 'b.id_paket = a.id_paket');
        $this->db->where('a.register_from', 'app');
        $this->db->where('a.lunas', 0);
        $this->db->where('b.publish', 1);
        $this->db->where('b.tanggal_berangkat >', date('Y-m-d'));
        $this->db->where("(TIMESTAMPDIFF(HOUR,tgl_regist, NOW()) = 2)");
        $this->db->select("CASE WHEN a.parent_id IS NOT NULL THEN a.parent_id ELSE a.id_member END as group_column", FALSE);
        $this->db->group_by('group_column');

        
        $member = $this->db->get()->result();

        // unset data id_member = 0
        foreach ($member as $key => $mbr) {
            if ($mbr->group_column == 0 || $mbr->group_column == null) {
                unset($member[$key]);
            }
        }
        //

        foreach ($member as $item) {
            $this->load->model('registrasi');
            $jamaah = $this->registrasi->getJamaah(null, null, $item->group_column);
            if ($jamaah->member[0]->id_agen == null || $jamaah->member[0]->id_agen == '' || $jamaah->member[0]->id_agen == 0) {
                $this->otomatisSendDP($jamaah->member[0]->id_member, 'tagihan_dp_new');
            } else {
                $this->otomatisSendDP($jamaah->member[0]->id_member, 'tagihan_dp_new', $jamaah->member[0]->agen->no_wa);
            }
        }
        if (!$member) {
            return false;
        }

        return true;
    }

    public function sendMessageTagihan() {
        $this->db->from('program_member a');
        $this->db->join('paket_umroh b', 'b.id_paket = a.id_paket');
        $this->db->where('a.lunas', 2);
        $this->db->where('b.tanggal_berangkat >=', date('Y-m-d'));
        $this->db->where('b.publish', 1);
        $this->db->where('DATEDIFF(b.tanggal_berangkat, NOW()) <= 48');
        $this->db->where('DATEDIFF(b.tanggal_berangkat, NOW()) >= 35');
        $this->db->select("CASE WHEN a.parent_id IS NOT NULL THEN a.parent_id ELSE a.id_member END as group_column", FALSE);
        $this->db->group_by('group_column');

     
        $member = $this->db->get()->result();
        // unset data id_member = 0
        foreach ($member as $key => $mbr) {
            if ($mbr->group_column == 0 || $mbr->group_column == null) {
                unset($member[$key]);
            }
        }
        //
        if (!$member) {
            return false;
        }

        foreach ($member as $m) {
            $this->load->model('registrasi');
            $this->load->library('calculate');
            $jamaah = $this->registrasi->getJamaah(null, null, $m->group_column);
            $this->load->model('paketUmroh');
            $paket = $this->paketUmroh->getPackage($jamaah->member[0]->id_paket);
            if (!empty($paket)) {
                $countdown = $this->calculate->dateDiff($paket->tanggal_berangkat, date('Y-m-d'));
            } else {
                $countdown = 0;
            }
            if (!empty($jamaah)) {
                if ($countdown == 48) {
                    if($jamaah->member[0]->id_agen != null || $jamaah->member[0]->id_agen != '' || $jamaah->member[0]->id_agen != 0) {
                        $noHp = $jamaah->member[0]->agen->no_wa ;
                        if ($noHp != null || $noHp != ''){
                            $this->otomatisSendTagihanPelunasan($jamaah->member[0]->id_member, 'blast_pelunasan1', $noHp, "45");
                        } else {
                            $this->otomatisSendTagihanPelunasan($jamaah->member[0]->id_member, 'blast_pelunasan1', null, "45");
                        }
                    } else {
                        $this->otomatisSendTagihanPelunasan($jamaah->member[0]->id_member, 'blast_pelunasan1', null , "45");
                    }
                } else if ($countdown == 45) {
                    if($jamaah->member[0]->id_agen != null || $jamaah->member[0]->id_agen != '' || $jamaah->member[0]->id_agen != 0) {
                        $noHp = $jamaah->member[0]->agen->no_wa ;
                        if ($noHp != null || $noHp != ''){
                            $this->otomatisSendTagihanPelunasan($jamaah->member[0]->id_member, 'blast_pelunasan3', $noHp, null);
                        } else {
                            $this->otomatisSendTagihanPelunasan($jamaah->member[0]->id_member, 'blast_pelunasan3', null, null);
                        }
                    } else {
                        $this->otomatisSendTagihanPelunasan($jamaah->member[0]->id_member, 'blast_pelunasan3', null, null);
                    }
                } else if ($countdown == 43) {
                    if($jamaah->member[0]->id_agen != null || $jamaah->member[0]->id_agen != '' || $jamaah->member[0]->id_agen != 0) {
                        $noHp = $jamaah->member[0]->agen->no_wa ;
                        if ($noHp != null || $noHp != ''){
                            $this->otomatisSendTagihanPelunasan($jamaah->member[0]->id_member, 'blast_pelunasan3', $noHp, null);
                        } else {
                            $this->otomatisSendTagihanPelunasan($jamaah->member[0]->id_member, 'blast_pelunasan3', null, null);
                        }
                    } else {
                        $this->otomatisSendTagihanPelunasan($jamaah->member[0]->id_member, 'blast_pelunasan3', null, null);
                    }
                } else if ($countdown == 40) {
                    if($jamaah->member[0]->id_agen != null || $jamaah->member[0]->id_agen != '' || $jamaah->member[0]->id_agen != 0) {
                        $noHp = $jamaah->member[0]->agen->no_wa ;
                        if ($noHp != null || $noHp != ''){
                            $this->otomatisSendTagihanPelunasan($jamaah->member[0]->id_member, 'blast_pelunasan4', $noHp, null);
                        } else {
                            $this->otomatisSendTagihanPelunasan($jamaah->member[0]->id_member, 'blast_pelunasan4', null, null);
                        }
                    } else {
                        $this->otomatisSendTagihanPelunasan($jamaah->member[0]->id_member, 'blast_pelunasan4', null, null);
                    }
                } else if ($countdown == 38) {
                    if($jamaah->member[0]->id_agen != null || $jamaah->member[0]->id_agen != '' || $jamaah->member[0]->id_agen != 0) {
                        $noHp = $jamaah->member[0]->agen->no_wa ;
                        if ($noHp != null || $noHp != ''){
                            $this->otomatisSendTagihanPelunasan($jamaah->member[0]->id_member, 'blast_pelunasan5', $noHp, "35");
                        } else {
                            $this->otomatisSendTagihanPelunasan($jamaah->member[0]->id_member, 'blast_pelunasan5', null, "35");
                        }
                    } else {
                        $this->otomatisSendTagihanPelunasan($jamaah->member[0]->id_member, 'blast_pelunasan5', null, "35");
                    }
                } else if ($countdown == 35) {
                    if($jamaah->member[0]->id_agen != null || $jamaah->member[0]->id_agen != '' || $jamaah->member[0]->id_agen != 0) {
                        $noHp = $jamaah->member[0]->agen->no_wa ;
                        if ($noHp != null || $noHp != ''){
                            $this->otomatisSendTagihanPelunasan($jamaah->member[0]->id_member, 'blast_pelunasan6', $noHp, null);
                        } else {
                            $this->otomatisSendTagihanPelunasan($jamaah->member[0]->id_member, 'blast_pelunasan6', null, null);
                        }
                    } else {
                        $this->otomatisSendTagihanPelunasan($jamaah->member[0]->id_member, 'blast_pelunasan6', null, null);
                    }
                }
            }
        }
        return true ;
    }

    // public function sendMessageTagihanPelunasan() {
    //     $this->db->from('program_member a');
    //     $this->db->join('paket_umroh b', 'b.id_paket = a.id_paket');
    //     $this->db->where('a.lunas', 2);
    //     $this->db->where('b.tanggal_berangkat >', date('Y-m-d'));
    //     $this->db->where('DATEDIFF(b.tanggal_berangkat, NOW()) <= 40');
    //     $this->db->where('DATEDIFF(b.tanggal_berangkat, NOW()) >= 35');
    //     $this->db->select("CASE WHEN a.parent_id IS NOT NULL THEN a.parent_id ELSE a.id_member END as group_column", FALSE);
    //     $this->db->group_by('group_column');

     
    //     $member = $this->db->get()->result();

    //     // unset data id_member = 0
    //     foreach ($member as $key => $mbr) {
    //         if ($mbr->group_column == 0 || $mbr->group_column == null) {
    //             unset($member[$key]);
    //         }
    //     }
    //     //

    //     foreach ($member as $m) {
    //         $this->load->model('registrasi');
    //         $this->load->library('calculate');
    //         $jamaah = $this->registrasi->getJamaah(null, null, $m->group_column);
    //         $this->load->model('paketUmroh');
    //         $paket = $this->paketUmroh->getPackage($jamaah->member[0]->id_paket);
    //         if (!empty($paket)) {
    //             $countdown = $this->calculate->dateDiff($paket->tanggal_berangkat, date('Y-m-d'));
    //         } else {
    //             $countdown = 0;
    //         }
    //         if (!empty($jamaah)) {
    //             $this->load->library('secret_key');
    //             $link = $this->secret_key->generate($jamaah->member[0]->id_member) ;
    //             if ($countdown == 40) {
    //                 if($jamaah->member[0]->id_agen != null || $jamaah->member[0]->id_agen != '' || $jamaah->member[0]->id_agen != 0) {
    //                     $noHp = $jamaah->member[0]->agen->no_wa ;
    //                     if ($noHp != null || $noHp != ''){
    //                         $this->otomatisSendTagihan($jamaah->member[0]->id_member, 'tagihan_pelunasan4', $link, $noHp);
    //                     } else {
    //                         $this->otomatisSendTagihan($jamaah->member[0]->id_member, 'tagihan_pelunasan4', $link);
    //                     }
    //                 } else {
    //                     $this->otomatisSendTagihan($jamaah->member[0]->id_member, 'tagihan_pelunasan4', $link);
    //                 }
    //             } else if ($countdown == 38) {
    //                 if($jamaah->member[0]->id_agen != null || $jamaah->member[0]->id_agen != '' || $jamaah->member[0]->id_agen != 0) {
    //                     $noHp = $jamaah->member[0]->agen->no_wa ;
    //                     if ($noHp != null || $noHp != ''){
    //                         $this->otomatisSendTagihan($jamaah->member[0]->id_member, 'tagihan_pelunasan5', $link, $noHp);
    //                     } else {
    //                         $this->otomatisSendTagihan($jamaah->member[0]->id_member, 'tagihan_pelunasan5', $link);
    //                     }
    //                 } else {
    //                     $this->otomatisSendTagihan($jamaah->member[0]->id_member, 'tagihan_pelunasan5', $link);
    //                 }
    //             }
    //         }
    //     }
    //     return true ;
    // }

    // public function sendMessageSuratPernyataan() {
    //     $this->db->from('program_member a');
    //     $this->db->join('paket_umroh b', 'b.id_paket = a.id_paket');
    //     $this->db->where('a.lunas', 2);
    //     $this->db->where('b.tanggal_berangkat >', date('Y-m-d'));
    //     $this->db->where('DATEDIFF(b.tanggal_berangkat, NOW()) = 33');
    //     $this->db->select("CASE WHEN a.parent_id IS NOT NULL THEN a.parent_id ELSE a.id_member END as group_column", FALSE);
    //     $this->db->group_by('group_column');

     
    //     $member = $this->db->get()->result();
    //     // unset data id_member = 0
    //     foreach ($member as $key => $mbr) {
    //         if ($mbr->group_column == 0 || $mbr->group_column == null) {
    //             unset($member[$key]);
    //         }
    //     }
    //     //

    //     foreach ($member as $m) {
    //         $this->load->model('registrasi');
    //         $this->load->library('calculate');
    //         $jamaah = $this->registrasi->getJamaah(null, null, $m->group_column);
    //         $this->load->model('paketUmroh');
    //         $paket = $this->paketUmroh->getPackage($jamaah->member[0]->id_paket);
    //         if (!empty($paket)) {
    //             $countdown = $this->calculate->dateDiff($paket->tanggal_berangkat, date('Y-m-d'));
    //         } else {
    //             $countdown = 0;
    //         }
    //         if (!empty($jamaah)) {
    //             if ($countdown == 33) {
    //                 if($jamaah->member[0]->id_agen != null || $jamaah->member[0]->id_agen != '') {
    //                     $noHp = $jamaah->member[0]->agen->no_wa;
    //                     if ($noHp != '' || $noHp != null) {
    //                         $this->otomatisSendSuratPernyataan($jamaah->member[0]->id_member, 'tagihan_pelunasan7', $noHp);
    //                     } else {
    //                         $this->otomatisSendSuratPernyataan($jamaah->member[0]->id_member, 'tagihan_pelunasan7');
    //                     }
    //                 } else {
    //                     $this->otomatisSendSuratPernyataan($jamaah->member[0]->id_member, 'tagihan_pelunasan7');
    //                 }
    //             }
    //         }
    //     }
    //     return true ;
    // }

    public function otomatisSendDP($id_member, $template_name, $nomor = null)
    {
        $this->load->model('registrasi');
        $jamaah = $this->registrasi->getJamaah(null, null, $id_member);
        if (empty($jamaah)) {
            return false;
        }
        $noHp = $jamaah->no_wa;
        // get no hp
        if ($nomor != null ) {
            $noHp = $nomor;
        }
        if (empty($noHp)) {
            // data nomor hp belum diinput
            return false;
        }

        $arrayNames = [$jamaah->first_name, $jamaah->second_name, $jamaah->last_name];
        $nama = implode(' ', array_filter($arrayNames));

        $namaPaket = $jamaah->member[0]->paket_info->nama_paket;
        $this->load->model('tarif');
        $tarif = $this->tarif->calcTariff($jamaah->member[0]->id_member);
        $minimalDP = $tarif['dp_display'];
        $this->load->library('date');
        $tanggalBerangkat = $this->date->convert_date_indo($jamaah->member[0]->paket_info->tanggal_berangkat);
        $paketFull = "$namaPaket ($tanggalBerangkat)";
        $realTime = $this->date->convert("H:i", $jamaah->member[0]->dp_expiry_time);
        $timeEnd = "$realTime WIB";

        $this->load->library('money');

        $components = [
            [
                'type' => 'body',
                'parameters' => [
                    [
                        'type' => 'text',
                        'text' => $nama
                    ],
                    [
                        'type' => 'text',
                        'text' => $paketFull
                    ],
                    [
                        'type' => 'text',
                        'text' => $timeEnd
                    ],
                    [
                        'type' => 'currency',
                        'currency' => [
                            'fallback_value' => $this->money->format($minimalDP),
                            'code' => 'IDR',
                            'amount_1000' => $minimalDP * 1000
                        ]
                    ]
                ]
            ],
            // [
            //     'type' => 'button',
            //     'sub_type' => 'url',
            //     'index' => '1',
            //     'parameters' => [
            //         [
            //             'type' => 'text',
            //             'text' => $invoiceLinkSecret
            //         ]
            //     ]
            // ]
        ];
        $this->addWALog($id_member, $template_name);
        return $this->send($noHp, $template_name, $components);
    }

    public function otomatisSendTagihanPelunasan($id_member, $template_name, $nomor = null, $dateDay) {
        $this->load->model('registrasi');
        $jamaah = $this->registrasi->getJamaah(null, null, $id_member);
        if (empty($jamaah)) {
            return false;
        }

        $this->load->model('tarif');
        $riwayat = $this->tarif->getRiwayatBayar($id_member);
        if (empty($riwayat)) {
            return false;
        }

        $sisaTagihan = $riwayat['sisaTagihan'];
        if ($sisaTagihan <= 0) {
            return false;
        }

        $noHp = $jamaah->no_wa;
        // get no hp
        if ($nomor != null ) {
            $noHp = $nomor;
        }
        if (empty($noHp)) {
            // data nomor hp belum diinput
            return false;
        }

        $arrayNames = [$jamaah->first_name, $jamaah->second_name, $jamaah->last_name];
        $nama = implode(' ', array_filter($arrayNames));

        $namaPaket = $jamaah->member[0]->paket_info->nama_paket;
        // $minimalDP = $jamaah->member[0]->paket_info->minimal_dp;
        $this->load->library('date');
        $tanggalBerangkat = $this->date->convert_date_indo($jamaah->member[0]->paket_info->tanggal_berangkat);
        $paketFull = "$namaPaket ($tanggalBerangkat)";
        $jatuh_tempo = date('d F Y', strtotime($jamaah->member[0]->paket_info->tanggal_berangkat . " -$dateDay day"));
        $jatuhTempo = "$jatuh_tempo";
        if ( $dateDay == null ) {
            $jatuhTempo = 'JATUH TEMPO';
        }

        $this->load->library('money');

        $components = [
            [
                'type' => 'body',
                'parameters' => [
                    [
                        'type' => 'text',
                        'text' => $nama
                    ],
                    [
                        'type' => 'text',
                        'text' => $jatuhTempo
                    ],
                    [
                        'type' => 'currency',
                        'currency' => [
                            'fallback_value' => $this->money->format($sisaTagihan),
                            'code' => 'IDR',
                            'amount_1000' => $sisaTagihan * 1000
                        ]
                    ],
                    [
                        'type' => 'text',
                        'text' => $paketFull
                    ],
                ]
            ],
            // [
            //     'type' => 'button',
            //     'sub_type' => 'url',
            //     'index' => '1',
            //     'parameters' => [
            //         [
            //             'type' => 'text',
            //             'text' => $invoiceLinkSecret
            //         ]
            //     ]
            // ]
        ];

        $this->addWALog($id_member, $template_name);
        return $this->send($noHp, $template_name, $components);
    }
    
    public function sendDpNotice($id_member, $nomor = null)
    {
        
        $this->load->model('registrasi');
        $jamaah = $this->registrasi->getJamaah(null, null, $id_member);
        if (empty($jamaah)) {
            return false;
        }

        $noHp = $jamaah->no_wa;
        // get no hp
        if ($nomor != null ) {
            $noHp = $nomor;
        }

        if (empty($noHp)) {
            return false;
        }
        $this->addWALog($id_member, 'tagihan_dp');
        return $this->send($noHp, 'tagihan_dp');
    }
    
    public function sendTagihanPelunasan($id_member, $invoiceLinkSecret, $nomor = null)
    {
        $this->load->model('tarif');
        $riwayat = $this->tarif->getRiwayatBayar($id_member);
        if (empty($riwayat)) {
            return false;
        }

        $sisaTagihan = $riwayat['sisaTagihan'];
        if ($sisaTagihan <= 0) {
            return false;
        }

        $this->load->model('registrasi');
        $jamaah = $this->registrasi->getJamaah(null, null, $id_member);
        if (empty($jamaah)) {
            return false;
        }
        $noHp = $jamaah->no_wa;
        // get no hp
        if ($nomor != null ) {
            $noHp = $nomor;
        }
        if (empty($noHp)) {
            // data nomor hp belum diinput
            return false;
        }

        $arrayNames = [$jamaah->first_name, $jamaah->second_name, $jamaah->last_name];
        $nama = implode(' ', array_filter($arrayNames));

        $namaPaket = $jamaah->member[0]->paket_info->nama_paket;
        $this->load->library('date');
        $tanggalBerangkat = $this->date->convert_date_indo($jamaah->member[0]->paket_info->tanggal_berangkat);
        $paketFull = "$namaPaket ($tanggalBerangkat)";

        $noVa = $riwayat['tarif']['nomorVAOpen'];
        $this->load->library('money');

        //prepare whatsapp parameters
        $components = [
            [
                'type' => 'body',
                'parameters' => [
                    [
                        'type' => 'text',
                        'text' => $nama
                    ],
                    [
                        'type' => 'text',
                        'text' => $paketFull
                    ],
                    [
                        'type' => 'currency',
                        'currency' => [
                            'fallback_value' => $this->money->format($sisaTagihan),
                            'code' => 'IDR',
                            'amount_1000' => $sisaTagihan * 1000
                        ]

                    ],
                    [
                        'type' => 'text',
                        'text' => $noVa
                    ]
                ]
            ],
            [
                'type' => 'button',
                'sub_type' => 'url',
                'index' => '1',
                'parameters' => [
                    [
                        'type' => 'text',
                        'text' => $invoiceLinkSecret
                    ]
                ]
            ]
        ];
        $this->addWALog($id_member, 'tagihan_pelunasan');
        return $this->send($noHp, 'tagihan_pelunasan', $components);
    }

    public function sendBroadcast($no_wa, $nama) {
        $components = [
            [
                'type' => 'body',
                'parameters' => [
                    [
                        'type' => 'text',
                        'text' => $nama
                    ]
                ]
            ],
        ];
        return $this->send($no_wa, 'broadcast', $components);
    }

    public function sendPengirimanPerlengkapan($id_member, $noWa) {
        $this->load->model('registrasi');
        $jamaah = $this->registrasi->getJamaah(null, null, $id_member);
        if (empty($jamaah)) {
            return false;
        }

        $fullName = implode(' ', array_filter([$jamaah->first_name, $jamaah->second_name, $jamaah->last_name]));
        $components = [
            [
                'type' => 'body',
                'parameters' => [
                    [
                        'type' => 'text',
                        'text' => $fullName
                    ]
                ]
            ],
        ];
        // $this->addWALog($id_member, 'tagihan_pelunasan');
        return $this->send($noWa, 'notif_kirim', $components);
    }

    public function sendReminder($ket, $tgl_reminder, $nominal, $no_wa) {
        $this->load->library('money');
        $components = [
            [
                'type' => 'body',
                'parameters' => [
                    [
                        'type' => 'text',
                        'text' => $ket
                    ],
                    [
                        'type' => 'text',
                        'text' => $tgl_reminder
                    ],
                    [
                        'type' => 'currency',
                        'currency' => [
                            'fallback_value' => $this->money->format($nominal),
                            'code' => 'IDR',
                            'amount_1000' => $nominal * 1000
                        ]

                    ],
                ]
            ],
        ];
        // $this->addWALog($id_member, 'tagihan_pelunasan');
        return $this->send($no_wa, 'reminder', $components);
    }

    public function sendFiturBaru($no_wa, $template_name) {
        // $this->addWALog($id_member, 'tagihan_pelunasan');

        $components = [
            [
                'type' => 'header',
                'parameters' => [
                    [
                        'type' => 'video',
                        'video' => [
                            'link' => 'https://www.ventour.co.id/app/uploads/video/hubungi_help_support.mp4'
                        ]
                    ]
                ]
            ],
        ];
        return $this->send($no_wa, $template_name, $components);
    }


    public function sendBlastUrgent($no_wa, $template_name) {
        // $this->addWALog($id_member, 'tagihan_pelunasan');

        $components = [
            [
                'type' => 'header',
                'parameters' => [
                    [
                        'type' => 'video',
                        'video' => [
                            'link' => 'https://www.ventour.co.id/app/uploads/video/hubungi_help_support.mp4'
                        ]
                    ]
                ]
            ],
        ];
        return $this->send($no_wa, $template_name);
    }

    /**
     * components arrays see
     * https://developers.facebook.com/docs/whatsapp/cloud-api/reference/messages#components-object
     * 
     * Available template name:
     * 
     * - tagihan_dp (no params)
     * 
     * - tagihan_pelunasan (4 body params, 1 button url param)
     * body: (param1: nama, param2: paket/tanggal berangkat, param3: sisa tagihan, param4: no VA BSI)
     * button (text): secretInvoiceLink 
     * 
     */
    public function send($noHp, $templateName, array $components = [])
    {

        //LIST OF TEMPLATE NAME
        //prepare number
        $this->load->library('wa_number');
        $noWa = $this->wa_number->convert($noHp);

        $templateParams = [
            'name' => $templateName,
            'language' => [
                'code' => 'id'
            ],
            'components' => $components
        ];

        $apiParams = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $noWa,
            'type' => 'template',
            'template' => $templateParams
        ];

        $curl = curl_init();
        $this->debugLog(json_encode($apiParams), 'request');
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://graph.facebook.com/v18.0/137270836139700/messages',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($apiParams),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer EAAJx448oNnQBO9IErZAm7ePW4DZA2hbpefsyym9udk6oUtya3OrdXjLzFDmeZAAsyxkoMhnWFvpdmzxDfQZCh2SchViD6kjGGLGSMzoEvQwyEoiKUAv3Yyz6uY1Ol9iJAIX0gPbxSdBguFdLtNKrDh2qtjtiSYXITOZAcLMY4E7jhH4cJWgk2LzWKIncSU7xf'
            ),
        ));
        $result = curl_exec($curl);
        $this->debugLog($result, 'response');
        curl_close($curl);
        return true;
    }
}
                        
/* End of file whatsapp.php */