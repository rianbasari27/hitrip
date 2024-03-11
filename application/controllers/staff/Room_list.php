<?php

defined('BASEPATH') or exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Room_list extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }
        //this page only for admin
        if (!($_SESSION['bagian'] == 'Manifest' || $_SESSION['bagian'] == 'Master Admin')) {
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

        //get rooms
        $this->load->model('roomList');
        $rooms = $this->roomList->getRooms($id_paket);
        $this->load->view('staff/room_list', $data = array(
            'paket' => $paket,
            'id_paket' => $id_paket,
            'nama_paket' => $nama_paket,
            'rooms' => $rooms
        ));
    }

    public function setKamar()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id_member', 'id_member', 'trim|required|integer');
        $this->form_validation->set_rules('room_number', 'room_number', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            return false;
        }
        $this->load->model('roomList');
        $set = $this->roomList->updateMemberRoom($_GET['id_member'], $_GET['room_number']);
        $this->load->model('registrasi');
        $member = $this->registrasi->getMember($_GET['id_member']);
        $rooms = $this->roomList->getRooms($member[0]->id_paket);
        echo json_encode($rooms);
    }

    public function hapus()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/room_list');
        }

        $this->load->model('roomList');
        $this->load->model('registrasi');
        $member = $this->registrasi->getMember($_GET['id']);
        if (empty($member)) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/room_list');
        }
        $del = $this->roomList->deleteMemberRoom($_GET['id']);
        if ($del == true) {
            $this->alert->set('success', 'Kamar Berhasil Dihapus');
        } else {
            $this->alert->set('danger', 'Kamar Gagal Dihapus');
        }
        redirect(base_url() . 'staff/room_list?id_paket=' . $member[0]->id_paket);
    }

    public function detail_pdf()
    {

        // require composer autoload
        require_once APPPATH . 'third_party/mpdf/vendor/autoload.php';

        $url = urldecode($_REQUEST['url']);
        $serverHost = parse_url(base_url(), PHP_URL_HOST);
        $accessHost = parse_url($url, PHP_URL_HOST);
        // To prevent anyone else using your script to create their PDF files
        if ($serverHost != $accessHost) {
            die("Access denied");
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        // forward current cookies to curl
        $cookies = array();
        foreach ($_COOKIE as $key => $value) {
            if ($key != 'Array') {
                $cookies[] = $key . '=' . $value;
            }
        }


        curl_setopt($ch, CURLOPT_COOKIE, implode(';', $cookies));
        // Stop session so curl can use the same session without conflicts
        session_write_close();
        $html = curl_exec($ch);
        curl_close($ch);
        // Session restart
        session_start();

        $mpdf = new \mPDF();

        $mpdf->useSubstitutions = true; // optional - just as an example
        $mpdf->CSSselectMedia = 'mpdf'; // assuming you used this in the document header
        $mpdf->setBasePath($url);
        $mpdf->WriteHTML($html);

        $mpdf->Output();
    }

    public function load_peserta()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'program_member';
        // Primary key of table
        $primaryKey = 'id_member';

        $columns = array(
            array('db' => '`pm`.`id_member`', 'dt' => 'DT_RowId', 'field' => 'id_member'),
            array('db' => '`pm`.`id_member`', 'dt' => 'id_member', 'field' => 'id_member'),
            array('db' => '`pm`.`id_jamaah`', 'dt' => 'id_jamaah', 'field' => 'id_jamaah'),
            array('db' => '`pm`.`paspor_name`', 'dt' => 'paspor_name', 'field' => 'paspor_name'),
            array('db' => '`j`.`first_name`', 'dt' => 'first_name', 'field' => 'first_name'),
            array('db' => '`j`.`second_name`', 'dt' => 'second_name', 'field' => 'second_name'),
            array('db' => '`j`.`last_name`', 'dt' => 'last_name', 'field' => 'last_name'),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`second_name`,' ',`j`.`last_name`) AS `whole_name`", 'dt' => "whole_name", 'field' => "whole_name"),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`last_name`) AS `two_name`", 'dt' => "two_name", 'field' => "two_name"),
            array('db' => '`pm`.`paspor_no`', 'dt' => 'paspor_no', 'field' => 'paspor_no'),
            array('db' => '`pm`.`pilihan_kamar`', 'dt' => 'pilihan_kamar', 'field' => 'pilihan_kamar'),
            array('db' => '`j`.`tanggal_lahir`', 'dt' => 'tanggal_lahir', 'field' => 'tanggal_lahir'),
            array('db' => '`j`.`jenis_kelamin`', 'dt' => 'jenis_kelamin', 'field' => 'jenis_kelamin'),
            array('db' => '`pm`.`parent_id`', 'dt' => 'parent_id', 'field' => 'parent_id'),
            array('db' => '`pm`.`sharing_bed`', 'dt' => 'sharing_bed', 'field' => 'sharing_bed'),
            array('db' => '`j`.`referensi`', 'dt' => 'referensi', 'field' => 'referensi'),
            array('db' => '`a`.`nama_agen`', 'dt' => 'nama_agen', 'field' => 'nama_agen'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $id_paket = $_GET['id_paket'];
        $joinQuery = "FROM `{$table}` AS `pm` LEFT JOIN `jamaah` AS `j` ON (`j`.`id_jamaah` = `pm`.`id_jamaah`) LEFT JOIN `agen` AS `a` ON (`a`.`id_agen` = `pm`.`id_agen`)";
        $extraCondition = "`id_paket`=" . $id_paket . " AND `pm`.`room_number` IS NULL";
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition);

        //prepare extra data
        $this->load->model('registrasi');
        $this->load->model('tarif');
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

            $extra_fee = $this->tarif->getExtraFee($d['DT_RowId'], 'Quad');
            $data['data'][$key]['keterangan'] = "";
            if ($d['pilihan_kamar'] == 'Quad') {
                if (!empty($extra_fee)) {
                    $data['data'][$key]['keterangan'] = $extra_fee[0]->keterangan;
                }
            }

            if ($d['pilihan_kamar'] == 'Triple') {
                $data['data'][$key]['keterangan'] = 'UPGRADE TRIPLE';
            }

            if ($d['pilihan_kamar'] == 'Double') {
                $data['data'][$key]['keterangan'] = 'UPGRADE DOUBLE';
            }

            $data['data'][$key]['nama_lengkap'] = $d['first_name'] . " ". $d['second_name'] . " " . $d['last_name'];
            if ($d['paspor_name'] != null) {
                $data['data'][$key]['nama_lengkap'] = $d['paspor_name'];
            }
        }
        echo json_encode($data);
    }

    public function room_list_excel()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id_paket', 'id_paket', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/finance/bayar');
        }
        $this->load->model('roomList');
        $rooms = $this->roomList->getRooms($_GET['id_paket']);
        $data = array(
            'rooms' => $rooms
        );
        $fileName = str_replace(' ', '_', 'ROOM LIST ' . date("d-F-Y") . '.xls');
        
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"$fileName\"");

        echo "\n";
        $header = array('', 'NO ROOM', 'TITLE', 'NAME', 'TYPE');
        echo implode("\t", $header) . "\n";

        $no = 0;
        foreach ($rooms as $room) {
            $roomNumber = $room['room_number'];
            $type = '';
            $mergedRoom = false;

            foreach ($room['member'] as $member) {
                $no++;
                if ($member->detailJamaah->jenis_kelamin == 'L') {
                    $jenis_kelamin = "MR";
                } elseif ($member->detailJamaah->jenis_kelamin == 'P') {
                    $jenis_kelamin = "MRS";
                } else {
                    $jenis_kelamin = '';
                }
                $title = $jenis_kelamin;
                $nama = $member->paspor_name;
                $pilihan_kamar = strtoupper($member->pilihan_kamar);

                if (!$mergedRoom) {
                    $data = array('', $roomNumber, $title, $nama, $pilihan_kamar);
                    $mergedRoom = true;
                } else {
                    $data = array('', '', $title, $nama, ''); 
                }
                echo implode("\t", $data) . "\n";

                if (empty($type)) {
                    $type = $pilihan_kamar;
                }
            }

            echo "\n";
        }
        exit();
    }
}