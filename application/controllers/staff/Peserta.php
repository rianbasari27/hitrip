<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Peserta extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }
        //this page only for admin
        if (!($_SESSION['bagian'] == 'Manifest' || $_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Finance'  || (preg_match("/bandung/i", $_SESSION['email'])))) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
    }

    public function index()
    {
        // echo '<pre>';
        // print_r($_GET);
        // exit();
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage(null, false, false, true);
        if (isset($_GET['id_paket'])) {
            $id_paket = $_GET['id_paket'];
        } else {
            $id_paket = $paket[0]->id_paket;
        }

        $selectedPaket = $this->paketUmroh->getPackage($id_paket, false, false, false);

        $nama_paket = $selectedPaket->nama_paket . ' (' . date_format(date_create($selectedPaket->tanggal_berangkat), "d F Y") . ')';


        $this->load->view('staff/peserta_view', $data = array(
            'paket' => $paket,
            'id_paket' => $id_paket,
            'nama_paket' => $nama_paket
        ));
    }

    public function scan_paspor_all()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/peserta');
        }
        $this->load->model('registrasi');
        $member = $this->registrasi->getMember(null, null, $_GET['id']);
        if (empty($member)) {
            $this->alert->set('danger', 'Tidak ada data!');
            redirect(base_url() . 'staff/peserta');
        }
        $data = array(
            'member' => $member
        );
        $this->load->library('Pdf');
        $this->load->view('staff/dl_paspor_all', $data);
    }

    public function scan_foto_all()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/peserta');
        }
        $this->load->model('registrasi');
        $member = $this->registrasi->getMember(null, null, $_GET['id']);
        if (empty($member)) {
            $this->alert->set('danger', 'Tidak ada data!');
            redirect(base_url() . 'staff/peserta');
        }
        $jamaah = array();
        foreach ($member as $m) {
            $jamaah[] = $this->registrasi->getJamaah($m->id_jamaah);
        }


        $data = array(
            'member' => $member,
            'jamaah' => $jamaah
        );
        $this->load->library('Pdf');
        $this->load->view('staff/dl_foto_all', $data);
    }

    public function hapus()
    {
        if (!($_SESSION['bagian'] == 'Master Admin')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/peserta');
        }

        $this->load->model('registrasi');
        $data = $this->registrasi->deleteProgramMember($_GET['id']);
        redirect(base_url() . 'staff/peserta');
    }

    public function load_peserta()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'program_member';
        // Primary key of table
        $primaryKey = 'id_member';

        $columns = array(
            array('db' => '`pm`.`id_member`', 'dt' => 'DT_RowId', 'field' => 'id_member'),
            array('db' => '`pm`.`id_jamaah`', 'dt' => 'id_jamaah', 'field' => 'id_jamaah'),
            array('db' => '`j`.`first_name`', 'dt' => 'first_name', 'field' => 'first_name'),
            array('db' => '`j`.`second_name`', 'dt' => 'second_name', 'field' => 'second_name'),
            array('db' => '`j`.`last_name`', 'dt' => 'last_name', 'field' => 'last_name'),
            array('db' => '`j`.`referensi`', 'dt' => 'referensi', 'field' => 'referensi'),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`second_name`,' ',`j`.`last_name`) AS `whole_name`", 'dt' => "whole_name", 'field' => "whole_name"),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`last_name`) AS `two_name`", 'dt' => "two_name", 'field' => "two_name"),
            array('db' => '`pm`.`paspor_no`', 'dt' => 'paspor_no', 'field' => 'paspor_no'),
            array('db' => '`pm`.`paspor_scan`', 'dt' => 'paspor_scan', 'field' => 'paspor_scan'),
            array('db' => '`pm`.`paspor_scan2`', 'dt' => 'paspor_scan2', 'field' => 'paspor_scan2'),
            array('db' => '`pm`.`ktp_scan`', 'dt' => 'ktp_scan', 'field' => 'ktp_scan'),
            array('db' => '`pm`.`foto_scan`', 'dt' => 'foto_scan', 'field' => 'foto_scan'),
            array('db' => '`pm`.`paspor_check`', 'dt' => 'paspor_check', 'field' => 'paspor_check'),
            array('db' => '`j`.`tanggal_lahir`', 'dt' => 'tanggal_lahir', 'field' => 'tanggal_lahir'),
            array('db' => '`j`.`jenis_kelamin`', 'dt' => 'jenis_kelamin', 'field' => 'jenis_kelamin'),
            array('db' => '`pm`.`parent_id`', 'dt' => 'parent_id', 'field' => 'parent_id'),
            array('db' => '`a`.`nama_agen`', 'dt' => 'nama_agen', 'field' => 'nama_agen'),
            array('db' => '`a`.`no_wa`', 'dt' => 'telp_agen', 'field' => 'no_wa'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $id_paket = $_GET['id_paket'];
        $joinQuery = "FROM `{$table}` AS `pm` LEFT JOIN `jamaah` AS `j` ON (`j`.`id_jamaah` = `pm`.`id_jamaah`) LEFT JOIN `agen` `a` ON (`pm`.`id_agen` = `a`.`id_agen`)";
        $extraCondition = "`id_paket`=" . $id_paket;
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition);

        //prepare extra data
        $this->load->model('registrasi');
        $groupCtr = 0;
        $groupArr = array();
        foreach ($data['data'] as $key => $d) {
            $data['data'][$key]['DT_RowAttr'] = array(
                'id_jamaah' => $d['id_jamaah']
            );

            //determine WG status
            $wg = $this->registrasi->getWG($d['DT_RowId']);
            $data['data'][$key]['wg'] = $wg;

            //set group class
            $parent_id = $d['parent_id'];
            if (!empty($parent_id)) {
                //check in array
                if (!isset($groupArr[$parent_id])) {
                    $groupCtr = $groupCtr + 1;
                    $groupArr[$parent_id] = $groupCtr;
                }
                $data['data'][$key]['DT_RowClass'] = 'group-color-' . $groupArr[$parent_id];
            }
        }
        echo json_encode($data);
    }
    
    // public function list_siskopatuh()
    // {

    //     $this->form_validation->set_data($this->input->get());
    //     $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
    //     if ($this->form_validation->run() == FALSE) {
    //         $this->alert->set('danger', 'Access Denied');
    //         redirect(base_url() . 'staff/finance/bayar');
    //     }
    //     $this->load->model('registrasi');
    //     $member = $this->registrasi->getMember(null, null, $_GET['id']);
    //     $this->load->model('tarif');
    //     $dt = $this->tarif->getPaymentsForPackage($_GET['id']);
    //     $fileName = str_replace(' ', '_', 'Dokumen SISKOPATUH' . $dt['paket']->nama_paket . '_' . date("Y-m-d") . '.xls');
    //     $header = array('NO', 'TITLE');
    //     $header[] = "NAMA ( SESUAI DENGAN NAMA PADA KARTU VAKSIN";
    //     $header[] = "NAMA AYAH";
    //     $header[] = "JENIS IDENTITAS";
    //     $header[] = "NO IDENTITAS";
    //     $header[] = "NAMA PASPOR";
    //     $header[] = "NO PASPOR";
    //     $header[] = "TANGGAL DIKELUARKAN PASPOR";
    //     $header[] = "KOTA PASPOR";
    //     $header[] = "TEMPAT LAHIR";
    //     $header[] = "TANGGAL LAHIR";
    //     $header[] = "ALAMAT";
    //     $header[] = "PROVINSI";
    //     $header[] = "KABUPATEN";
    //     $header[] = "KECAMATAN";
    //     $header[] = "KELURAHAN";
    //     $header[] = "NO TELP";
    //     $header[] = "NO HP";
    //     $header[] = "KEWARGANEGARAAN";
    //     $header[] = "STATUS PERNIKAHAN";
    //     $header[] = "PENDIDIKAN";
    //     $header[] = "PEKERJAAN";
    //     $header[] = "PROVIDER VISA";
    //     $header[] = "NO VISA";
    //     $header[] = "TANGGAL BERLAKU VISA";
    //     $header[] = "TANGGAL AKHIR VISA";
    //     $header[] = "ASURANSI";
    //     $header[] = "NO POLIS";
    //     $header[] = "TANGGAL INPUT POLIS";
    //     $header[] = "TANGGAL AWAL POLIS";
    //     $header[] = "TANGGAL AKHIR POLIS";

    //     header("Content-Type: application/vnd-ms-excel");
    //     header("Content-Disposition: attachment; filename=\"$fileName\"");
    //     echo "DOKUMEN SISKOPATUH " . $dt['paket']->nama_paket . " " . $dt['paket']->tanggal_berangkat . "\n";
    //     echo "Update Tanggal : " . date("Y-m-d") . "\n\n";
    //     echo implode("\t", $header) . "\n";
    //     $no = 0;
    //     foreach ($member as $m) {
    //         $j = $this->registrasi->getJamaah($m->id_jamaah);
    //         $this->load->model('calculate');
    //         $age = $this->calculate->age($j->tanggal_lahir);
    //         $umur = date('Y') - $age;
    //         if ($j->tanggal_lahir == "L" && $umur <= 17 ) {
    //             $jenis_kelamin = "MSTR";
    //         } else if ($j->tanggal_lahir == "L" && $umur > 17 ) {
    //             $jenis_kelamin = "MR";
    //         } else if ($j->tanggal_lahir == "P" && $umur <= 17 ) {
    //             $jenis_kelamin = "MISS";
    //         } else {
    //             $jenis_kelamin = "MRS";
    //         }
    //         $no++;
    //         $title = $jenis_kelamin;
    //         $data = array($no, $title);
    //         $data[] = $j->first_name . ' ' . $j->second_name . ' ' . $j->last_name;
    //         $data[] = $j->nama_ayah;
    //         $data[] = null;
    //         $data[] = $j->ktp_no;
    //         $data[] = $m->paspor_name;
    //         $data[] = $m->paspor_no;
    //         $data[] = $m->paspor_issue_date;
    //         $data[] = $m->paspor_issuing_city;
    //         $data[] = $j->tempat_lahir;
    //         $data[] = $j->tanggal_lahir;
    //         $data[] = $j->alamat_tinggal;
    //         $data[] = $j->provinsi;
    //         $data[] = $j->kabupaten_kota;
    //         $data[] = $j->kecamatan;
    //         $data[] = null;
    //         $data[] = $j->no_rumah;
    //         $data[] = $j->no_wa;
    //         $data[] = $j->kewarganegaraan;
    //         $data[] = $j->status_perkawinan;
    //         $data[] = $j->pendidikan_terakhir;
    //         $data[] = $j->pekerjaan;
    //         $data[] = null;
    //         $data[] = null;
    //         $data[] = null;
    //         $data[] = null;
    //         $data[] = null;
    //         $data[] = null;
    //         $data[] = null;
    //         $data[] = null;
    //         $data[] = null;
            
    //         // for ($i = 0; $i < $dt['maxCicil']; $i++) {
    //         //     if (isset($ls->payments['data'][$i])) {
    //         //         $data[] = $ls->payments['data'][$i]->tanggal_bayar;
    //         //         $data[] = $ls->payments['data'][$i]->cara_pembayaran;
    //         //         $data[] = $ls->payments['data'][$i]->jumlah_bayar;
    //         //     } else {
    //         //         $data[] = '';
    //         //         $data[] = '';
    //         //         $data[] = '';
    //         //     }
    //         // }
    //         // $data[] = $ls->payments['totalBayar'];
    //         // $data[] = $ls->payments['kurangBayar'];
    //         echo implode("\t", $data) . "\n";
    //     }
    //     exit();
    // }
}