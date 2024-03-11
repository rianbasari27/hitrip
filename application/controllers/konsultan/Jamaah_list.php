<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Jamaah_list extends CI_Controller
{    
    public function __construct()
    {
        parent::__construct();
        $this->load->model("auth");
        $this->load->library("secret_key");
        $this->load->model('konsultanAuth');
        if (!$this->konsultanAuth->is_user_logged_in()) {
            redirect(base_url() . 'konsultan/login');
        }
    }
    
    public function index() { 
        $this->load->model('agen');
        $agen = $this->agen->getAgen($_SESSION['id_agen']);
        if ($agen[0]->active != 1) {
            redirect(base_url() . 'konsultan/home/pemb_notice');
        }
        $this->load->model('paketUmroh');
        $this->load->model('registrasi');
        $this->load->library('wa_number');
        $month = array(
            1 =>'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );

        $jamaah = $this->agen->getJamaahAgen($_SESSION['id_agen']);
        $paket = $this->paketUmroh->getPackage();

        $this->load->model('komisiConfig');
        $groupBySeason = $this->komisiConfig->groupByMusim($_SESSION['id_agen']);
        $data = array(
            'jamaah' => $jamaah,
            'paket' => $paket,
            'month' => $month,
            'groupBySeason' => $groupBySeason,
        );
        return $this->load->view('konsultan/jamaah_list_view', $data);
    }

    public function getPackageByMonth()
    {
        $month = $this->input->get('bulan');
        $this->load->model('paketUmroh');
        $package = $this->paketUmroh->getPackage(null, false, true, true, $month, true);
        echo json_encode($package);
        // echo '<pre>';
        // print_r($package);
        // exit();
    }

    public function getLunas() {
        $status_bayar = $this->input->get('status_bayar');
        $this->load->model('registrasi');
        $lunas = $this->registrasi->getMember();
        // echo '<pre>';
        // print_r($lunas);
        // exit();
    }

    public function load_jamaah() {
        include APPPATH . 'third_party/ssp.class.php';
        include APPPATH . 'libraries/Wa_number.php'; 

        // echo '<pre>';
        // print_r($_GET);
        // exit();
        $table = 'program_member';
        // Primary key of table
        $primaryKey = 'id_member';

        $columns = array(
            array('db' => '`pm`.`id_member`', 'dt' => 'DT_RowId', 'field' => 'id_member'),
            array('db' => '`pm`.`id_jamaah`', 'dt' => 'id_jamaah', 'field' => 'id_jamaah'),
            array('db' => '`a`.`id_agen`', 'dt' => 'id_agen', 'field' => 'id_agen'),
            array('db' => '`j`.`first_name`', 'dt' => 'first_name', 'field' => 'first_name'),
            array('db' => '`j`.`second_name`', 'dt' => 'second_name', 'field' => 'second_name'),
            array('db' => '`j`.`last_name`', 'dt' => 'last_name', 'field' => 'last_name'),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`second_name`,' ',`j`.`last_name`) AS `whole_name`", 'dt' => "whole_name", 'field' => "whole_name"),
            array('db' => '`j`.`kabupaten_kota`', 'dt' => 'kabupaten_kota', 'field' => 'kabupaten_kota'),
            array('db' => '`pm`.`paspor_no`', 'dt' => 'paspor_no', 'field' => 'paspor_no'),
            array('db' => '`pm`.`lunas`', 'dt' => 'lunas', 'field' => 'lunas'),
            // array('db' => '`j`.`no_wa`', 'dt' => 'no_wa', 
            // 'formatter' => function($no_wa, $index) {
                //         $formatter_number = new Wa_number();
                //         return $formatter_number->convert($no_wa); // bisa akwowk
                
                //     },
                // 'field' => 'no_wa'),
            array('db' => '`pu`.`nama_paket`', 'dt' => 'nama_paket', 'field' => 'nama_paket'),
            array('db' => '`pu`.`tanggal_berangkat`', 'dt' => 'tanggal_berangkat', 'formatter' => function($d, $row) {
                return date_format(date_create($d), "d M Y");
            }
            , 'field' => 'tanggal_berangkat'),
            array('db' => '`pm`.`verified` AS `verified_member`', 'dt' => 'verified_member', 'field' => 'verified_member'),
            array('db' => '`j`.`verified` AS `verified_jamaah`', 'dt' => 'verified_jamaah', 'field' => 'verified_jamaah'),
            // array('db' => "CONCAT(`pu`.`nama_paket`,' (',`pu`.`tanggal_berangkat`,')') AS `paket_berangkat`", 'dt' => "paket_berangkat", 'field' => "paket_berangkat"),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $id_agen = $_SESSION['id_agen'];
        $joinQuery = "FROM `{$table}` AS `pm` LEFT JOIN `jamaah` AS `j` ON (`j`.`id_jamaah` = `pm`.`id_jamaah`) LEFT JOIN `paket_umroh` AS `pu` ON (`pu`.`id_paket` = `pm`.`id_paket`) LEFT JOIN `agen` AS `a` ON (`a`.`id_agen` = `pm`.`id_agen`)";
        $extraCondition = "`pm`.`id_agen`='" . $id_agen /*. "' AND `pu`.`tanggal_berangkat` >= '" . date('Y-m-d')*/ . "'";
        if ($_GET['month'] == null && $_GET['id_paket'] == null && $_GET['data'] == null && $_GET['berangkat'] == null && $_GET['perlengkapan'] == null) {
            $condition = " AND `pu`.`tanggal_berangkat` >= CURDATE()";
            $extraCondition = $extraCondition . $condition;
        }
        if ($_GET['musim'] != '') {
            $musim = $this->date->getMusim($_GET['musim']);
        } else {
            $musim = $this->date->getMusim();
        }
        // echo '<pre>';
        // print_r($musim);
        // exit();
        $tglAwal = $musim['tglAwal'];
        $tglAkhir = $musim['tglAkhir']; 
        if ($_GET['musim'] != '') {
            $condition = " AND pu.tanggal_berangkat >= '$tglAwal' AND pu.tanggal_berangkat <= '$tglAkhir'";
            $extraCondition = $extraCondition . $condition;
        }
        if ($_GET['month'] != '') {
            $month = $_GET['month'];
            $condition = " AND pu.tanggal_berangkat >= '$tglAwal' AND pu.tanggal_berangkat <= '$tglAkhir' AND MONTH(pu.tanggal_berangkat) = $month";
            $extraCondition = $extraCondition . $condition;
        }
        if ($_GET['id_paket'] != '') {
            $id_paket = $_GET['id_paket'];
            $condition = " AND pu.tanggal_berangkat >= '$tglAwal' AND pu.tanggal_berangkat <= '$tglAkhir' AND pm.id_paket = $id_paket";
            $extraCondition = $extraCondition . $condition;
        }
        if ($_GET['status_bayar'] != '') {
            $lunas = $_GET['status_bayar'];
            $condition = " AND pu.tanggal_berangkat >= '$tglAwal' AND pu.tanggal_berangkat <= '$tglAkhir' AND pm.lunas = $lunas";
            $extraCondition = $extraCondition . $condition;
        }
        if ($_GET['data'] != '') {
            $data = $_GET['data'];
            $condition = " AND pu.tanggal_berangkat >= '$tglAwal' AND pu.tanggal_berangkat <= '$tglAkhir' AND pm.verified = $data AND j.verified = $data";
            $extraCondition = $extraCondition . $condition;
        }
        if ($_GET['berangkat'] != '') {
            if ($_GET['berangkat'] == "Sudah berangkat") {
                $condition = " AND pu.tanggal_berangkat >= '$tglAwal' AND pu.tanggal_berangkat <= '$tglAkhir' AND DATE(`pu`.`tanggal_berangkat`) < CURDATE()";
            } else {
                $condition = " AND pu.tanggal_berangkat >= '$tglAwal' AND pu.tanggal_berangkat <= '$tglAkhir' AND DATE(`pu`.`tanggal_berangkat`) > CURDATE()";
            }
            $extraCondition = $extraCondition . $condition;
        }

        if ($_GET['perlengkapan'] != '') {
            $this->load->model('logistik');
            if(isset($_GET['id_paket'])) {
                $paket = $this->logistik->getStatusPengambilan($_GET['id_paket']);
            } else {
                $paket = $this->logistik->getStatusPengambilan();
            }

                $belum = [];
                $sebagian = [];
                $semua = [];
            $this->load->model('agen');
            $agen = $this->agen->getJamaahAgen($id_agen);

            foreach ($agen as $a) {
                unset($a->jamaah);
                $member = $this->logistik->getStatusPerlengkapanMember($a->id_member);
                switch ($member) {
                    case 'Sudah Semua':
                        $semua[] = (array)$a;
                        break;
                    case 'Sudah Sebagian':
                        $sebagian[] = (array)$a;
                        break;
                    case 'Belum Ambil':
                        $belum[] = (array)$a;
                        break;
                    default:
                        break;
                }
            }

            // belum ambil perlengkapan
            $id_belum = "";
            foreach ($belum as $b) {
                $id_belum = $id_belum . $b['id_member'] ." ";
            }
            $hasil = explode(" ", $id_belum);
            $count = count($hasil);
            unset($hasil[$count-1]);
            $a = implode(",", $hasil);

            // sudah sebagian perlengkapan
            $id_sebagian = "";
            foreach ($sebagian as $s) {
                $id_sebagian = $id_sebagian . $s['id_member'] ." ";
            }
            $hasil = explode(" ", $id_sebagian);
            $count = count($hasil);
            unset($hasil[$count-1]);
            $s = implode(",", $hasil);

            // sudah semua perlengkapan
            $id_semua = "";
            foreach ($semua as $all) {
                $id_semua = $id_semua . $all['id_member'] ." ";
            }
            $hasil = explode(" ", $id_semua);
            $count = count($hasil);
            unset($hasil[$count-1]);
            $x = implode(",", $hasil);

            if ($_GET['perlengkapan'] == 'Belum diambil') {
                if (!empty($a)) {
                    $condition = " AND pu.tanggal_berangkat >= '$tglAwal' AND pu.tanggal_berangkat <= '$tglAkhir' AND pm.id_member IN " . "(" . $a . ")";
                } else {
                    $condition = " AND pu.tanggal_berangkat >= '$tglAwal' AND pu.tanggal_berangkat <= '$tglAkhir' AND pm.id_member IN (0)";
                }
            }
            if ($_GET['perlengkapan'] == 'Sudah sebagian') {
                if (!empty($s)) {
                    $condition = " AND pu.tanggal_berangkat >= '$tglAwal' AND pu.tanggal_berangkat <= '$tglAkhir' AND pm.id_member IN " . "(" . $s . ")";
                } else {
                    $condition = " AND pu.tanggal_berangkat >= '$tglAwal' AND pu.tanggal_berangkat <= '$tglAkhir' AND pm.id_member IN (0)";
                }
            }
            if ($_GET['perlengkapan'] == 'Sudah diambil') {
                if (!empty($x)) {
                    $condition = " AND pu.tanggal_berangkat >= '$tglAwal' AND pu.tanggal_berangkat <= '$tglAkhir' AND pm.id_member IN " . "(" . $x . ")";
                } else {
                    $condition = " AND pu.tanggal_berangkat >= '$tglAwal' AND pu.tanggal_berangkat <= '$tglAkhir' AND pm.id_member IN (0)";
                }
            }
            $extraCondition = $extraCondition . $condition;
        }
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition);

        //prepare extra data
        $this->load->model('registrasi');
        $groupCtr = 0;
        $groupArr = array();
        foreach ($data['data'] as $key => $d) {
            $data['data'][$key]['DT_RowAttr'] = array(
                'id_jamaah' => $d['id_jamaah'],
                'id_secret' => $this->secret_key->generate($d['DT_RowId'])
            );

            //determine WG status
            $wg = $this->registrasi->getWG($d['DT_RowId']);
            $data['data'][$key]['wg'] = $wg;

            // echo '<pre>';
            // print_r($d);
            // exit();
            if ($d['verified_member'] == 1 && $d['verified_jamaah'] == 1) {
                $document = 1;
            } else {
                $document = 0;
            }

            $data['data'][$key]['dokumen'] = $document;

            $this->load->model('logistik');
            $perlengkapan = $this->logistik->getStatusPerlengkapanMember($d['DT_RowId']);
            if ($perlengkapan == "Sudah Semua") {
                $perlengkapan = 1;
            } else {
                $perlengkapan = 0;
            }
            $data['data'][$key]['perlengkapan'] = $perlengkapan;
        }
        // echo '<pre>';
        // print_r($data);
        // exit();
        echo json_encode($data);
    }

    
}

?>