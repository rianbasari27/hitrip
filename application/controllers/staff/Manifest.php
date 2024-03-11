<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Manifest extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }
        //this page only for admin
        if (!($_SESSION['bagian'] == 'Manifest' || $_SESSION['bagian'] == 'Master Admin'  || (preg_match("/bandung/i", $_SESSION['email'])))) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
    }

    public function index()
    {
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage(null, false, false, true);
        if (isset($_GET['id_paket'])) {
            $id_paket = $_GET['id_paket'];
        } else {
            $id_paket = $paket[0]->id_paket;
        }
        $selectedPaket = $this->paketUmroh->getPackage($id_paket, false, false, false);

        $nama_paket = $selectedPaket->nama_paket . ' (' . date_format(date_create($selectedPaket->tanggal_berangkat), "d F Y") . ')';

        $this->load->view('staff/choose_manifest', $data = array(
            'paket' => $paket,
            'id_paket' => $id_paket,
            'nama_paket' => $nama_paket
        ));
    }

    public function loadData()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'program_member';
        // Primary key of table
        $primaryKey = 'id_member';

        $columns = array(
            array('db' => '`pm`.`id_member`', 'dt' => 'DT_RowId', 'field' => 'id_member'),
            array('db' => '`pm`.`id_jamaah`', 'dt' => 'id_jamaah', 'field' => 'id_jamaah'),
            array('db' => '`pm`.`parent_id`', 'dt' => 'parent_id', 'field' => 'parent_id'),
            array('db' => '`j`.`first_name`', 'dt' => 'first_name', 'field' => 'first_name'),
            array('db' => '`j`.`second_name`', 'dt' => 'second_name', 'field' => 'second_name'),
            array('db' => '`j`.`last_name`', 'dt' => 'last_name', 'field' => 'last_name'),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`second_name`,' ',`j`.`last_name`) AS `whole_name`", 'dt' => "whole_name", 'field' => "whole_name"),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`last_name`) AS `two_name`", 'dt' => "two_name", 'field' => "two_name"),
            array('db' => '`ag`.`nama_agen`', 'dt' => 'nama_agen', 'field' => 'nama_agen'),
            array('db' => '`pm`.`paspor_no`', 'dt' => 'paspor_no', 'field' => 'paspor_no'),
            array('db' => '`pm`.`paspor_name`', 'dt' => 'paspor_name', 'field' => 'paspor_name'),
            array('db' => '`j`.`jenis_kelamin`', 'dt' => 'jenis_kelamin', 'field' => 'jenis_kelamin'),
            array('db' => '`j`.`tanggal_lahir`', 'dt' => 'tanggal_lahir', 'field' => 'tanggal_lahir'),
            array('db' => '`pm`.`paspor_issue_date`', 'dt' => 'paspor_issue_date', 'field' => 'paspor_issue_date'),
            array('db' => '`pm`.`paspor_expiry_date`', 'dt' => 'paspor_expiry_date', 'field' => 'paspor_expiry_date'),
            array('db' => '`pm`.`paspor_issuing_city`', 'dt' => 'paspor_issuing_city', 'field' => 'paspor_issuing_city'),
            array('db' => '`j`.`tempat_lahir`', 'dt' => 'tempat_lahir', 'field' => 'tempat_lahir'),
            array('db' => '`j`.`ktp_no`', 'dt' => 'ktp_no', 'field' => 'ktp_no'),
            array('db' => '`j`.`nama_ayah`', 'dt' => 'nama_ayah', 'field' => 'nama_ayah'),
            array('db' => '`j`.`alamat_tinggal`', 'dt' => 'alamat_tinggal', 'field' => 'alamat_tinggal'),
            array('db' => '`j`.`provinsi`', 'dt' => 'provinsi', 'field' => 'provinsi'),
            array('db' => '`j`.`kabupaten_kota`', 'dt' => 'kabupaten_kota', 'field' => 'kabupaten_kota'),
            array('db' => '`j`.`kecamatan`', 'dt' => 'kecamatan', 'field' => 'kecamatan'),
            array('db' => '`j`.`no_rumah`', 'dt' => 'no_rumah', 'field' => 'no_rumah'),
            array('db' => '`j`.`no_wa`', 'dt' => 'no_wa', 'field' => 'no_wa'),
            array('db' => '`j`.`kewarganegaraan`', 'dt' => 'kewarganegaraan', 'field' => 'kewarganegaraan'),
            array('db' => '`j`.`status_perkawinan`', 'dt' => 'status_perkawinan', 'field' => 'status_perkawinan'),
            array('db' => '`j`.`pendidikan_terakhir`', 'dt' => 'pendidikan_terakhir', 'field' => 'pendidikan_terakhir'),
            array('db' => '`j`.`pekerjaan`', 'dt' => 'pekerjaan', 'field' => 'pekerjaan'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $id_paket = $_GET['id_paket'];
        $joinQuery = "FROM `{$table}` AS `pm` LEFT JOIN `jamaah` AS `j` ON (`j`.`id_jamaah` = `pm`.`id_jamaah`) LEFT JOIN agen AS ag ON (ag.id_agen = pm.id_agen)";
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

            // if (strpos(strtolower($d['tempat_lahir']), 'kota') == TRUE) {
                // $data['data'][$key]['tempat_lahir'] = str_replace('KOTA ', 'KABUPATEN ', $d['tempat_lahir']);
            // } 
            // if (strpos(strtolower($d['tempat_lahir']), 'kabupaten') == TRUE) {
                $data['data'][$key]['tempat_lahir'] = str_replace(['KABUPATEN ', 'KOTA '], ['',''], $d['tempat_lahir']);
            // } 

            //determine WG status
            $wg = $this->registrasi->getWG($d['DT_RowId']);
            $data['data'][$key]['wg'] = $wg;

            //set usia

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

    public function siskopatuh() {
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage(null, false, false, true);
        if (isset($_GET['id_paket'])) {
            $id_paket = $_GET['id_paket'];
        } else {
            $id_paket = $paket[0]->id_paket;
        }
        $selectedPaket = $this->paketUmroh->getPackage($id_paket, false, false, false);

        $nama_paket = $selectedPaket->nama_paket . ' (' . date_format(date_create($selectedPaket->tanggal_berangkat), "d F Y") . ')';

        $this->load->view('staff/choose_siskopatuh', $data = array(
            'paket' => $paket,
            'id_paket' => $id_paket,
            'nama_paket' => $nama_paket
        ));
    }

    public function asuransi() {
        $this->load->view('staff/choose_asuransi');
    }

    public function load_asuransi()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'program_member';
        // Primary key of table
        $primaryKey = 'id_member';

        $columns = array(
            array('db' => '`pm`.`id_member`', 'dt' => 'DT_RowId', 'field' => 'id_member'),
            array('db' => '`pm`.`id_jamaah`', 'dt' => 'id_jamaah', 'field' => 'id_jamaah'),
            array('db' => '`pm`.`parent_id`', 'dt' => 'parent_id', 'field' => 'parent_id'),
            array('db' => '`j`.`first_name`', 'dt' => 'first_name', 'field' => 'first_name'),
            array('db' => '`j`.`second_name`', 'dt' => 'second_name', 'field' => 'second_name'),
            array('db' => '`j`.`last_name`', 'dt' => 'last_name', 'field' => 'last_name'),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`second_name`,' ',`j`.`last_name`) AS `whole_name`", 'dt' => "whole_name", 'field' => "whole_name"),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`last_name`) AS `two_name`", 'dt' => "two_name", 'field' => "two_name"),
            array('db' => '`ag`.`nama_agen`', 'dt' => 'nama_agen', 'field' => 'nama_agen'),
            array('db' => '`pm`.`paspor_no`', 'dt' => 'paspor_no', 'field' => 'paspor_no'),
            array('db' => '`pm`.`paspor_name`', 'dt' => 'paspor_name', 'field' => 'paspor_name'),
            array('db' => '`j`.`jenis_kelamin`', 'dt' => 'jenis_kelamin', 'field' => 'jenis_kelamin'),
            array('db' => '`j`.`tanggal_lahir`', 'dt' => 'tanggal_lahir', 'field' => 'tanggal_lahir'),
            array('db' => '`pm`.`paspor_issue_date`', 'dt' => 'paspor_issue_date', 'field' => 'paspor_issue_date'),
            array('db' => '`pm`.`paspor_expiry_date`', 'dt' => 'paspor_expiry_date', 'field' => 'paspor_expiry_date'),
            array('db' => '`pm`.`paspor_issuing_city`', 'dt' => 'paspor_issuing_city', 'field' => 'paspor_issuing_city'),
            array('db' => '`j`.`tempat_lahir`', 'dt' => 'tempat_lahir', 'field' => 'tempat_lahir'),
            array('db' => '`j`.`ktp_no`', 'dt' => 'ktp_no', 'field' => 'ktp_no'),
            array('db' => '`j`.`nama_ayah`', 'dt' => 'nama_ayah', 'field' => 'nama_ayah'),
            array('db' => '`j`.`alamat_tinggal`', 'dt' => 'alamat_tinggal', 'field' => 'alamat_tinggal'),
            array('db' => '`j`.`provinsi`', 'dt' => 'provinsi', 'field' => 'provinsi'),
            array('db' => '`j`.`kabupaten_kota`', 'dt' => 'kabupaten_kota', 'field' => 'kabupaten_kota'),
            array('db' => '`j`.`kecamatan`', 'dt' => 'kecamatan', 'field' => 'kecamatan'),
            array('db' => '`j`.`no_rumah`', 'dt' => 'no_rumah', 'field' => 'no_rumah'),
            array('db' => '`j`.`no_wa`', 'dt' => 'no_wa', 'field' => 'no_wa'),
            array('db' => '`j`.`kewarganegaraan`', 'dt' => 'kewarganegaraan', 'field' => 'kewarganegaraan'),
            array('db' => '`j`.`status_perkawinan`', 'dt' => 'status_perkawinan', 'field' => 'status_perkawinan'),
            array('db' => '`j`.`pendidikan_terakhir`', 'dt' => 'pendidikan_terakhir', 'field' => 'pendidikan_terakhir'),
            array('db' => '`j`.`pekerjaan`', 'dt' => 'pekerjaan', 'field' => 'pekerjaan'),
            array('db' => '`j`.`penyakit`', 'dt' => 'penyakit', 'field' => 'penyakit'),
            array('db' => '`pkt`.`nama_paket`', 'dt' => 'nama_paket', 'field' => 'nama_paket'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $joinQuery = "FROM `{$table}` AS `pm` LEFT JOIN `jamaah` AS `j` ON (`j`.`id_jamaah` = `pm`.`id_jamaah`) LEFT JOIN agen AS ag ON (ag.id_agen = pm.id_agen) JOIN paket_umroh as pkt ON (pkt.id_paket = pm.id_paket)";
        $extraCondition = "`j`.`penyakit` != '' AND `j`.`penyakit` NOT LIKE '%tida%' AND `j`.`penyakit` NOT LIKE '%-%' AND `j`.`penyakit` !='0'" ;
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

            //set usia

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
}