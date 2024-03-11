<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Handling extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }
        if (!($_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Handling')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
    }
    
    public function index()
    {
        $this->load->view('staff/jadwal_handling_view');
    }

    public function load_data() {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'paket_umroh';
        // Primary key of table
        $primaryKey = 'id_paket';

        $columns = array(
            array('db' => 'id_paket', 'dt' => 'DT_RowId', 'field' => 'id_paket'),
            array('db' => 'nama_paket', 'dt' => 'nama_paket', 'field' => 'nama_paket'),
            array('db' => 'tanggal_berangkat', 'dt' => 'tanggal_berangkat', 'field' => 'tanggal_berangkat'),
            array('db' => 'tanggal_pulang', 'dt' => 'tanggal_pulang', 'field' => 'tanggal_pulang'),
            array('db' => 'jumlah_seat', 'dt' => 'jumlah_seat', 'field' => 'jumlah_seat'),
            array('db' => 'flight_schedule', 'dt' => 'flight_schedule', 'field' => 'flight_schedule'),
            array('db' => 'jam_terbang', 'dt' => 'jam_terbang', 'field' => 'jam_terbang'),
            array(
                'db' => 'id_paket',
                'dt' => 'tanggal_kumpul',
                'field' => 'tanggal_kumpul',
                'formatter' => function($d, $row) {
                    // Menghitung tanggal kumpul dari tanggal berangkat
                    $tanggal_berangkat = new DateTime($row['tanggal_berangkat']);
                    $jam_terbang = new DateTime($row['jam_terbang']);
                    $jam_berangkat = (int)$jam_terbang->format('H'); // Get the hour of departure
                    if ($jam_berangkat < 5) {
                        $tanggal_berangkat->modify('-1 day'); // If departure time is before 5:00, subtract one day from the arrival date
                    }
                    return $tanggal_berangkat->format('Y-m-d');
                }
            ),
            array(
                'db' => 'id_paket',
                'dt' => 'jam_kumpul',
                'field' => 'jam_kumpul',
                'formatter' => function($d, $row) {
                    // Menghitung jam kumpul dari jam terbang
                    $jam_terbang = new DateTime($row['jam_terbang']);
                    $jam_kumpul = clone $jam_terbang; // Make a copy to preserve the original time
                    $jam_kumpul->modify('-5 hours'); // Subtract 5 hours from the arrival time
                    return $jam_kumpul->format('H:i') . " WIB";
                }
            ),
            
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $extraCondition = "tanggal_berangkat >=".'CURDATE()';
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, null, $extraCondition);

        $this->load->library('date');
        foreach ($data['data'] as $key => $d) {
            $tanggal_awal = new DateTime($d['tanggal_berangkat']);
            $tanggal_akhir = new DateTime($d['tanggal_pulang']);

            // Menghitung selisih antara dua tanggal
            $selisih = $tanggal_awal->diff($tanggal_akhir);

            $data['data'][$key]['program_hari'] = $selisih->days . " Hari" ;
            // if ($d['jam_terbang'] != null) {
            //     // Tanggal dan jam awal
            //     $tglStart = "$d[tanggal_berangkat] $d[jam_terbang]";
            //     $tglMulai = strtotime($tglStart);
            //     // Mengurangi 5 jam dari timestamp awal
            //     $tglResult = $tglMulai - (5 * 3600); // 5 jam * 3600 detik/jam
            //     $result = date("Y-m-d H:i", $tglResult);

            //     $tanggal = explode(" ", $result);


            //     $data['data'][$key]['tanggal_kumpul'] = $this->date->convert_date_indo($tanggal[0]);
            //     $data['data'][$key]['jam_kumpul'] = $tanggal[1] . " WIB";
            // }

            $data['data'][$key]['manifest'] = "Belum Lengkap";
            $data['data'][$key]['finance'] = "Belum Lunas";
            $data['data'][$key]['perlengkapan'] = "Belum Lengkap";

            $this->load->model('registrasi');
            $member = $this->registrasi->checkDokumen($d['DT_RowId']);
            if ($member['dokumen'] == true) {
                $data['data'][$key]['manifest'] = "Sudah Lengkap";
            }

            if ($member['finance'] == true) {
                $data['data'][$key]['finance'] = "Sudah Lunas";
            }

            if ($member['perlengkapan'] == true) {
                $data['data'][$key]['perlengkapan'] = "Sudah Lengkap";
            }

            $data['data'][$key]['tl'] = "";
            $data['data'][$key]['muthowif'] = "";
            $data['data'][$key]['tempat_kumpul'] = "";
            $data['data'][$key]['lounge'] = "";
            $data['data'][$key]['handling'] = "";
            $this->load->library('calculate');
            $countdownStart = $this->calculate->dateDiff($d['tanggal_berangkat'], date('Y-m-d'));
            $countdownEnd = $this->calculate->dateDiff($d['tanggal_pulang'], date('Y-m-d'));
            $data['data'][$key]['status'] = "";
            $dateNow = date('Y-m-d');
            if ( $dateNow <= $d['tanggal_berangkat']) {
                if ($countdownStart > 2 ) {
                    $data['data'][$key]['status'] = "BELUM BERANGKAT";
                }

                if ($countdownStart <= 2 && $countdownStart > 0) {
                    $data['data'][$key]['status'] = "PERSIAPAN KEBERANGKATAN";
                }
            }

            if ($dateNow > $d['tanggal_berangkat'] && $dateNow < $d['tanggal_pulang'] && $countdownEnd > 2) {
                $data['data'][$key]['status'] = "SEDANG BERJALAN";
            }

            if ($dateNow > $d['tanggal_berangkat'] && $dateNow < $d['tanggal_pulang'] && $countdownEnd <= 2 && $countdownEnd > 0) {
                $data['data'][$key]['status'] = "PERSIAPAN KEPULANGAN";
            }

            if ($dateNow > $d['tanggal_pulang']) {
                $data['data'][$key]['status'] = "SUDAH SELESAI/BERANGKAT";
            }

            $data['data'][$key]['tanggal_berangkat'] = $this->date->convert_date_indo($d['tanggal_berangkat']);
            $data['data'][$key]['tanggal_pulang'] = $this->date->convert_date_indo($d['tanggal_pulang']);
            $data['data'][$key]['tanggal_kumpul'] = $this->date->convert_date_indo($d['tanggal_kumpul']);

        }
        echo json_encode($data) ;
    }

    public function proses_set_tl() {
        echo '<pre>';
        print_r($_POST);
        exit();
    }

    public function tl_autocomplete()
    {
        $term = $_GET['term'];
        $this->load->model('agen');
        $data = $this->agen->getTlByName($term);
        echo json_encode($data);
    }

}