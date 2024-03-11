<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Perlengkapan_peserta extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }
        //this page only for admin
        if (!($_SESSION['bagian'] == 'Admin' || $_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Logistik' || $_SESSION['bagian'] == 'Manifest')) {
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

        //get list perlengkapan
        $this->load->model('logistik');
        $perlengkapan = $this->logistik->getPerlengkapanPaket($id_paket);

        $this->load->view('staff/list_perlengkapan_peserta', $data = array(
            'paket' => $paket,
            'id_paket' => $id_paket,
            'nama_paket' => $nama_paket,
            'siapDiambilPria' => $perlengkapan['siapDiambilPria'],
            'siapDiambilWanita' => $perlengkapan['siapDiambilWanita'],
            'siapDiambilAnakPria' => $perlengkapan['siapDiambilAnakPria'],
            'siapDiambilAnakWanita' => $perlengkapan['siapDiambilAnakWanita'],
            'siapDiambilBayi' => $perlengkapan['siapDiambilBayi'],
            'belumReadyPria' => $perlengkapan['belumReadyPria'],
            'belumReadyWanita' => $perlengkapan['belumReadyWanita'],
            'belumReadyAnakPria' => $perlengkapan['belumReadyAnakPria'],
            'belumReadyAnakWanita' => $perlengkapan['belumReadyAnakWanita'],
            'belumReadyBayi' => $perlengkapan['belumReadyBayi'],
            'totalPria' => $perlengkapan['totalPria'],
            'totalWanita' => $perlengkapan['totalWanita'],
            'totalAnakPria' => $perlengkapan['totalAnakPria'],
            'totalAnakWanita' => $perlengkapan['totalAnakWanita'],
            'totalBayi' => $perlengkapan['totalBayi'],
            'perlengkapan' => $perlengkapan['perlengkapan'],
            'brgBelumReadyPria' => $perlengkapan['belumReadyPriaNamaBarang'],
            'brgBelumReadyWanita' => $perlengkapan['belumReadyWanitaNamaBarang'],
            'brgBelumReadyAnakPria' => $perlengkapan['belumReadyAnakPriaNamaBarang'],
            'brgBelumReadyAnakWanita' => $perlengkapan['belumReadyAnakWanitaNamaBarang'],
            'brgBelumReadyBayi' => $perlengkapan['belumReadyBayiNamaBarang'],
            'brgSiapPria' => $perlengkapan['siapDiambilPriaNamaBarang'],
            'brgSiapWanita' => $perlengkapan['siapDiambilWanitaNamaBarang'],
            'brgSiapAnakPria' => $perlengkapan['siapDiambilAnakPriaNamaBarang'],
            'brgSiapAnakWanita' => $perlengkapan['siapDiambilAnakWanitaNamaBarang'],
            'brgSiapBayi' => $perlengkapan['siapDiambilBayiNamaBarang']
        ));
    }
    public function pending_ambil()
    {
        $this->form_validation->set_rules('tanggal_ambil', 'tanggal_ambil', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/perlengkapan_peserta');
        }

        $items = $_POST['items'];
        $tanggalAmbil = $_POST['tanggal_ambil'];
        $this->load->model('logistik');
        $pendingAmbil = $this->logistik->setPendingAmbil($items, $tanggalAmbil);
        if (!$pendingAmbil) {
            $this->alert->set('danger', 'Perlengkapan gagal diambil');
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public function status_ambil()
    {
        $this->form_validation->set_rules('idm', 'id', 'trim|required');
        $this->form_validation->set_rules('penerima', 'Nama Penerima', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->model('registrasi');
        $jamaah = $this->registrasi->getJamaah(null, null, $_POST['idm']);
        $nama = $_POST['penerima'];
        $this->load->model('logistik');
        $pendingAmbil = $this->logistik->setPendingAmbil($_POST['items'], $jamaah->member[0]->id_paket, $nama, $_POST['tempat_ambil']);
        if ($pendingAmbil) {
            $this->alert->set('success', 'Perlengkapan berhasil diambil');
        }
        redirect(base_url() . 'staff/perlengkapan_pending/status_siap');
    }

    public function ambil()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id_member', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/perlengkapan_peserta');
        }
        $this->load->model('registrasi');
        $member = $this->registrasi->getMember($_GET['id_member']);
        if (empty($member)) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/perlengkapan_peserta');
        }
        $idPaket = $member[0]->id_paket;

        $this->load->model('logistik');
        $logistikPaket = $this->logistik->getPerlengkapanPaket($idPaket, 'Siap Diambil');

        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage($idPaket, false);

        $jamaah = $this->registrasi->getJamaah($member[0]->id_jamaah);

        $sudahAmbil = $this->logistik->getPerlengkapanSudahAmbil($member[0]->id_member);
        $pendingBooking = $this->logistik->getPendingBooking($member[0]->id_member);
        $ambilList = $this->logistik->getAmbilList($member[0]->id_member);
        foreach($ambilList as $key => $ambil) {
            $this->db->where('id_logistik', $ambil->id_logistik);
            $this->db->where('id_member', $_GET['id_member']);
            $perlMember = $this->db->get('perlengkapan_member')->row();
            if (!empty($perlMember)) {
                if ($perlMember->status =='Siap' || $perlMember->status == "Pending") {
                    unset($ambilList[$key]);
                }
            }
        }
        $data = array(
            'member' => $member[0],
            'logistikPaket' => $logistikPaket,
            'sudahAmbil' => $sudahAmbil,
            'pendingBooking' => $pendingBooking,
            'ambilList' => $ambilList,
            'jamaah' => $jamaah,
            'paket' => $paket
        );
        $this->load->view('staff/ambil_perlengkapan_peserta', $data);
    }

    public function proses_ambil()
    {
        //this page only for admin
        $this->form_validation->set_rules('id_member', 'id_member', 'trim|required|integer');
        $this->form_validation->set_rules('penerima', 'Nama Penerima', 'trim|required');
        $this->form_validation->set_rules('tanggal_ambil', 'tanggal_ambil', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'access denied');
            redirect(base_url() . 'staff/perlengkapan_peserta');
        }
        if (empty($_POST['items'])) {
            $this->alert->set('danger', 'Error. Tidak ada barang yang dipilih');
            redirect(base_url() . 'staff/perlengkapan_peserta');
        }
        $this->load->model('logistik');
        $add = $this->logistik->addPerlengkapanPeserta($_POST['id_member'], $_POST['items'], $_POST['tanggal_ambil'], $_POST['status'], "langsung", null, null, $_POST['penerima'], $_POST['tempat_ambil']);
        if ($add) {
            $this->alert->set('success', 'Perlengkapan berhasil diambil.');
        } else {
            $this->alert->set('danger', 'Error. Perlengkapan gagal diambil.');
        }
        redirect(base_url() . 'staff/perlengkapan_peserta/ambil?id_member=' . $_POST['id_member']);
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
            array('db' => '`ag`.`nama_agen`', 'dt' => 'nama_agen', 'field' => 'nama_agen'),
            array('db' => '`pm`.`lunas`', 'dt' => 'lunas', 'field' => 'lunas'),
            // array('db' => '`pm`.`status_perlengkapan`', 'dt' => 'status_perlengkapan', 'field' => 'status_perlengkapan'),
            array('db' => '`j`.`first_name`', 'dt' => 'first_name', 'field' => 'first_name'),
            array('db' => '`j`.`second_name`', 'dt' => 'second_name', 'field' => 'second_name'),
            array('db' => '`j`.`last_name`', 'dt' => 'last_name', 'field' => 'last_name'),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`second_name`,' ',`j`.`last_name`) AS `whole_name`", 'dt' => "whole_name", 'field' => "whole_name"),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`last_name`) AS `two_name`", 'dt' => "two_name", 'field' => "two_name"),
            array('db' => '`pm`.`paspor_no`', 'dt' => 'paspor_no', 'field' => 'paspor_no'),
            array('db' => '`j`.`tanggal_lahir`', 'dt' => 'tanggal_lahir', 'field' => 'tanggal_lahir'),
            array('db' => '`j`.`jenis_kelamin`', 'dt' => 'jenis_kelamin', 'field' => 'jenis_kelamin'),
            array('db' => '`pm`.`parent_id`', 'dt' => 'parent_id', 'field' => 'parent_id'),
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
        $this->load->model('logistik');
        $groupCtr = 0;
        $groupArr = array();
        foreach ($data['data'] as $key => $d) {

            //handle status perlengkapan per member
            $data['data'][$key]['status_perlengkapan'] = $this->logistik->getStatusPerlengkapanMember($d['DT_RowId']);

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

    public function load_perlengkapan()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'perlengkapan_member';
        // Primary key of table
        $primaryKey = 'id_perlmember';

        $columns = array(
            array('db' => '`perl`.`id_perlmember`', 'dt' => 'id_perlmember', 'field' => 'id_perlmember'),
            array('db' => '`perl`.`id_logistik`', 'dt' => 'id_logistik', 'field' => 'id_logistik'),
            array('db' => '`perl`.`id_member`', 'dt' => 'DT_RowId', 'field' => 'id_member'),
            array('db' => '`pm`.`id_jamaah`', 'dt' => 'id_jamaah', 'field' => 'id_jamaah'),
            array('db' => '`perl`.`tanggal_ambil`', 'dt' => 'tanggal_ambil', 'field' => 'tanggal_ambil'),
            array('db' => '`perl`.`jumlah_ambil`', 'dt' => 'jumlah_ambil', 'field' => 'jumlah_ambil'),
            array('db' => '`pm`.`parent_id`', 'dt' => 'parent_id', 'field' => 'parent_id'),
            array('db' => '`l`.`nama_barang`', 'dt' => 'nama_barang', 'field' => 'nama_barang'),
            array('db' => '`j`.`first_name`', 'dt' => 'first_name', 'field' => 'first_name'),
            array('db' => '`j`.`second_name`', 'dt' => 'second_name', 'field' => 'second_name'),
            array('db' => '`j`.`last_name`', 'dt' => 'last_name', 'field' => 'last_name'),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`second_name`,' ',`j`.`last_name`) AS `whole_name`", 'dt' => "whole_name", 'field' => "whole_name"),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`last_name`) AS `two_name`", 'dt' => "two_name", 'field' => "two_name"),
            array('db' => '`j`.`tanggal_lahir`', 'dt' => 'tanggal_lahir', 'field' => 'tanggal_lahir'),
            array('db' => '`j`.`jenis_kelamin`', 'dt' => 'jenis_kelamin', 'field' => 'jenis_kelamin'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $id_paket = $_GET['id_paket'];
        $joinQuery = "FROM `{$table}` AS `perl` LEFT JOIN `logistik` AS `l` ON (`l`.`id_logistik` = `perl`.`id_logistik`) LEFT JOIN program_member AS pm ON (pm.id_member = perl.id_member) LEFT JOIN jamaah AS j ON (j.id_jamaah = pm.id_jamaah)";
        $extraCondition = "`id_paket`=" . $id_paket;
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition);
        //prepare extra data
        $this->load->model('registrasi');
        $this->load->model('logistik');
        $this->load->library('calculate');
        $groupCtr = 0;
        $groupArr = array();
        foreach ($data['data'] as $key => $d) {

            //handle status perlengkapan per member
            $data['data'][$key]['status_perlengkapan'] = $this->logistik->getStatusPerlengkapanMember($d['DT_RowId']);
            $data['data'][$key]['DT_RowAttr'] = array(
                'id_jamaah' => $d['id_jamaah']
            );
        }
        echo json_encode($data);
    }

    public function download()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('idj', 'idj', 'trim|required|integer');
        $this->form_validation->set_rules('idm', 'idm', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/perlengkapan_peserta');
        }
        $this->load->model('registrasi');
        $jamaah = $this->registrasi->getJamaah($_GET['idj']);
        if (empty($jamaah)) {
            $this->alert->set('danger', 'Data Tidak Ditemukan');
            redirect(base_url() . 'staff/request_dokumen');
        }
        $member = $this->registrasi->getMember($_GET['idm']);
        $this->load->model('logistik');
        $sudahAmbil = $this->logistik->getPerlengkapanSudahAmbil($member[0]->id_member);
        // $hasil = [];
        // foreach ($sudahAmbil['dateGroup'][$_GET['id']] as $ambil) {
        //     $hasil['nama_barang'] = $ambil;
        // }
        $data = array(
            // 'member' => $member[0],
            // 'jamaah' => $jamaah,
            'sudahAmbil' => $sudahAmbil['dateGroup'][$_GET['id']],
            'nama' => $jamaah->first_name . " " . $jamaah->second_name . " " . $jamaah->last_name,
            'no_ktp' => $jamaah->ktp_no,
            'nama_paket' => $member[0]->paket_info->nama_paket,
            'tgl_berangkat' => $member[0]->paket_info->tanggal_berangkat,
            'tgl_ambil' => $_GET['id'],
            'nama_penerima' => $sudahAmbil['dateGroup'][$_GET['id']][0]->penerima,
            'nama_staff' => $sudahAmbil['dateGroup'][$_GET['id']][0]->staff
        );
        $data['html'] = $this->load->view('staff/invoice_barang_html_view', $data, true);
        $this->load->view('staff/invoice_brg_view', $data);
    }

    public function log()
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
        $this->load->model('logistik');
        $perlengkapanPaket = $this->logistik->getPerlengkapanPaket($id_paket, 'Siap Diambil');

        $countPerl = count($perlengkapanPaket['perlengkapan']);

        $this->load->view('staff/log_perlengkapan_peserta', $data = array(
            'paket' => $paket,
            'id_paket' => $id_paket,
            'nama_paket' => $nama_paket,
            'perlengkapanPaket' => $perlengkapanPaket['perlengkapan'],
            'countPerl' =>$countPerl
        ));
    }

    public function load_log()
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
            array('db' => '`j`.`tanggal_lahir`', 'dt' => 'tanggal_lahir', 'field' => 'tanggal_lahir'),
            array('db' => '`j`.`jenis_kelamin`', 'dt' => 'jenis_kelamin', 'field' => 'jenis_kelamin'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $id_paket = $_GET['id_paket'];
        $joinQuery = "FROM `{$table}` AS `pm` LEFT JOIN perlengkapan_member AS perl ON (perl.id_member = pm.id_member) JOIN jamaah AS j ON (j.id_jamaah = pm.id_jamaah)";
        $extraCondition = "`id_paket`=" . $id_paket;
        if ($_GET['jenisKelamin'] != '') {
            $jk = $_GET['jenisKelamin'];
            if ($extraCondition != "") {
                $condition = " AND `j`.`jenis_kelamin` = '$jk'";
            } else {
                $condition = "`j`.`jenis_kelamin` ='$jk'";
            }
            $extraCondition = $extraCondition . $condition;
        }
        $groupBy = "`pm`.`id_member`";
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition, $groupBy);
        $this->load->model('registrasi');
        $this->load->model('logistik');
        $this->load->library('calculate');
        $groupCtr = 0;
        $groupArr = array();
        foreach ($data['data'] as $key => $d) {

            $data['data'][$key]['DT_RowAttr'] = array(
                'id_jamaah' => $d['id_jamaah']
            );
            // list perlengkapan yang sudah diambil
            $data['data'][$key]['status_perlengkapan'] = $this->logistik->getStatusPerlengkapanMember($d['DT_RowId']);
            $sudahAmbil = $this->logistik->getPerlengkapanSudahAmbil($d['DT_RowId']);
            $perlengkapanPaket = $this->logistik->getPerlengkapanPaket($_GET['id_paket'], 'Siap Diambil');
            foreach ($perlengkapanPaket['perlengkapan'] as $perl => $perlengkapan){
                $data['data'][$key][$perl+3] = 0;
                foreach ($sudahAmbil['items'] as $sdhAmbil)  {
                    if ($perlengkapan->nama_barang == $sdhAmbil->nama_barang) {
                            $data['data'][$key][$perl+3] = 1;
                    }
                }
            }
            $umur = $this->calculate->age($d['tanggal_lahir']);
            if ($umur <= 2) {
                $status = 'bayi';
            } elseif ($umur > 2 && $umur <= 6) {
                $status = 'Anak';
            } else {
                $status = 'Dewasa';
            }

            if ($umur > 2 && $d['jenis_kelamin'] == 'P') {
                $status = 'Perempuan ' . $status;
            } else if ($umur > 2 && $d['jenis_kelamin'] == 'L') {
                $status = 'Laki-laki ' . $status;
            }
            $data['data'][$key]['jk'] = $status;
        }
        // echo '<pre>';
        // print_r($data['data']);
        // exit();
        echo json_encode($data);
    }

    public function perlengkapan_excel()
    {
        $this->load->model('paketUmroh');
        $perlengkapan = $this->paketUmroh->getPackage(null, true);
        $fileName = "Detail Pengambilan Perlengkapan " . date("d M Y"). ".xls";
        $header = array('NO', 'NAMA PAKET', 'TANGGAL BERANGKAT');
        $header[] = "JUMLAH SEAT";
        $header[] = "SISA SEAT";
        $header[] = "TOTAL JAMAAH";
        $header[] = "SUDAH AMBIL SEMUA";
        $header[] = "SUDAH AMBIL SEBAGIAN";
        $header[] = "BELUM AMBIL SEMUA";

        header("Content-Type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        echo "\n\n";
        echo implode("\t", $header) . "\n";
        $no = 0;
        foreach ($perlengkapan as $key => $perl) {
            $no++;
            $nama = $perl->nama_paket;
            $data = array($no, $nama, date("d M Y", strtotime($perl->tanggal_berangkat)));
            // ambil jamaah per paket
            $jamaah = $this->registrasi->getMember(null, null, $perl->id_paket);
            if (empty($jamaah)) {
                $totalJamaah = 0;
            } else {
                $totalJamaah = count($jamaah);
            }
            // ambil status perlengkapan paket
            $this->load->model('logistik');
            $status = $this->logistik->getStatusPengambilan($perl->id_paket);
            $data[] = $perl->jumlah_seat . " Pax";
            $data[] = $perl->sisa_seat . " Pax";
            $data[] = $totalJamaah . " Orang";
            $data[] = $status['sudahSemua'] . " Orang";
            $data[] = $status['sudahSebagian'] . " Orang";
            $data[] = $status['belumAmbil'] . " Orang";
            echo implode("\t", $data) . "\n";
        }
        exit();
    }

    public function summary_perlengkapan()
    {
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage(null, false, false, true);
        if (isset($_GET['id_paket'])) {
            $id_paket = $_GET['id_paket'];
        } else {
            $id_paket = $paket[0]->id_paket;
        }


        if (isset($_GET['month'])) {
            $month = $_GET['month'];
        } else {
            $month = 0;
        }
        $selectedPaket = $this->paketUmroh->getPackage($id_paket, false, false, false);
        $hasil = $this->paketUmroh->getAvailableYear(false);
        $monthPackage = [] ;
        foreach($hasil as $m ) {
            $array[] = $this->paketUmroh->getAllMonth(false, false, $m->Y);
        }

        foreach ($array as $last) {
            foreach($last as $m) {
                $monthPackage[]['tanggal_berangkat'] = $m->tanggal_berangkat;
            }
        }

        $nama_paket = $selectedPaket->nama_paket . ' (' . date_format(date_create($selectedPaket->tanggal_berangkat), "d F Y") . ')';
        $this->load->model('logistik');
        $perlJamaah = $this->logistik->getBarang();
        $barang = $this->logistik->getBarang();
        $countPerl = count($barang);
        $this->load->view('staff/summary_perlengkapan_view', $data = array(
            'paket' => $paket,
            'id_paket' => $id_paket,
            'nama_paket' => $nama_paket,
            'perlJamaah' => $perlJamaah,
            'countPerl' => $countPerl,
            'monthPackage' => $monthPackage,
            'month' => $month
        ));
    }

    public function load_summary() 
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'paket_umroh';
        // Primary key of table
        $primaryKey = 'id_paket';

        $columns = array(
            array('db' => '`pu`.`id_paket`', 'dt' => 'DT_RowId', 'field' => 'id_paket'),
            array('db' => '`pu`.`nama_paket`', 'dt' => 'nama_paket', 'field' => 'nama_paket'),
            array('db' => '`pu`.`tanggal_berangkat`', 'dt' => 'tanggal_berangkat', 'field' => 'tanggal_berangkat'),
            array('db' => '`pu`.`jumlah_seat`', 'dt' => 'jumlah_seat', 'field' => 'jumlah_seat'),
            
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $joinQuery = "FROM `{$table}` AS `pu`";
        $extraCondition = "";

        if ($_GET['date_start'] != '') {
            $date_start = $_GET['date_start'];
            if ($extraCondition != "") {
                $condition = " AND `pu`.`tanggal_berangkat` >= '$date_start'";
            } else {
                $condition = " `pu`.`tanggal_berangkat` >= '$date_start'";
            }
            $extraCondition = $extraCondition . $condition;
        }
        if ($_GET['date_end'] != '') {
            $date_end = $_GET['date_end'];
            if ($extraCondition != "") {
                $condition = " AND `pu`.`tanggal_berangkat` <= '$date_end'";
            } else {
                $condition = " `pu`.`tanggal_berangkat` <= '$date_end'";
            }
            $extraCondition = $extraCondition . $condition;
        }
        

        if ($_GET['month'] != 0) {
            $month = $_GET['month'];
            $month = explode(" ", $month);
            if ($extraCondition != "") {
                $condition = " AND MONTH(`pu`.`tanggal_berangkat`) = " . $month[0] . " AND YEAR(`pu`.`tanggal_berangkat`) = " . $month[1];
            } else {
                $condition = "MONTH(`pu`.`tanggal_berangkat`) = " . $month[0] . " AND YEAR(`pu`.`tanggal_berangkat`) = " . $month[1];
            }
            $extraCondition = $extraCondition . $condition;
        }

        if ($_GET['status_berangkat'] != '') {
            if ($_GET['status_berangkat'] == 1) {
                if ($extraCondition != "") {
                    $condition = " AND `pu`.`tanggal_berangkat` <= CURDATE()";
                } else {
                    $condition = " `pu`.`tanggal_berangkat` <= CURDATE()";
                }
            } else {
                if ($extraCondition != "") {
                    $condition = " AND `pu`.`tanggal_berangkat` >= CURDATE()";
                } else {
                    $condition = " `pu`.`tanggal_berangkat` >= CURDATE()";
                }
            }
            $extraCondition = $extraCondition . $condition;
        }

        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition);
        
        foreach ($data['data'] as $key => $d) {
            $this->load->model('paketUmroh');
            $paket = $this->paketUmroh->getPackage($d['DT_RowId'], false);
            if (isset($paket->sisa_seat)) {
                $data['data'][$key]['sisa_seat'] = $paket->sisa_seat;
            } else {
                $data['data'][$key]['sisa_seat'] = 0;
            }
            $data['data'][$key]['jumlah_jamaah'] = $d['jumlah_seat'] - $data['data'][$key]['sisa_seat'];

            $this->db->select('*');
            $this->db->from('program_member a');
            $this->db->join('jamaah b', 'b.id_jamaah = a.id_jamaah');
            $this->db->where('b.jenis_kelamin', 'P');
            $this->db->where('a.id_paket', $d['DT_RowId']);
            $wanita = $this->db->get('')->result();
            $countWanita = count($wanita);

            $this->db->select('*');
            $this->db->from('program_member a');
            $this->db->join('jamaah b', 'b.id_jamaah = a.id_jamaah');
            $this->db->where('b.jenis_kelamin', 'L');
            $this->db->where('a.id_paket', $d['DT_RowId']);
            $pria = $this->db->get('')->result();
            $countPria = count($pria);

            // $total = $countPria+$countWanita;
            // echo '<pre>';
            // print_r($d['DT_RowId']);
            // exit();

            $data['data'][$key]['jumlah_laki'] = $countPria;
            $data['data'][$key]['jumlah_wanita'] = $countWanita;
            $data['data'][$key]['siap_ambil'] = '';
            
            $this->load->model('logistik');
            $getPerlengkapan = $this->logistik->getPerlengkapanPaket($d['DT_RowId'], 'Siap Diambil');
            if (!empty($getPerlengkapan['perlengkapan'])) {
                $data['data'][$key]['siap_ambil'] = 1;
            }
            $barang = $this->logistik->getBarang();
            $totalItems = array();
            foreach ($barang as $b) {
                $totalItems[$b->nama_barang] = [
                    "jumlah" => 0,
                    "id_logistik" => $b->id_logistik 
                ] ;
                $data['data'][$key]['id_logistik'] = $b->id_logistik;
            }
            $this->db->where('id_paket', $d['DT_RowId']);
            $jamaah = $this->db->get('program_member')->result();
            if (!empty($jamaah)) {
                foreach ($jamaah as $j) {
                    $sudahAmbil = $this->logistik->getPerlengkapanSudahAmbilPerBarang($j->id_member);
                    foreach ($totalItems as $item => $items) {
                        foreach ($sudahAmbil as $ambil => $sdhAmbil) {
                            if ($ambil == $item) {
                                $totalItems[$item]["jumlah"] = $items["jumlah"] + $sdhAmbil ;
                            }
                        }
                    }
                }
            }
            $items = array() ;
            foreach ($totalItems as $total => $ti) {
                $items[] = [
                    "jumlah" => $ti["jumlah"],
                    "id_logistik" => $ti["id_logistik"]
                ] ;
            }  
            foreach ($items as $item => $i) {
                $data['data'][$key][$item+3] = [
                    "jumlah" => $i["jumlah"],
                    "id_logistik" => $i["id_logistik"] 
                ];
            }
        }
        echo json_encode($data);
    }

    public function detail_sudah_ambil() {
        $id_paket = $_GET['id'];
        $id_log = $_GET['idl'];
        $status = $_GET['status'];
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage($id_paket, false, false, true);
        if (empty($id_paket)) {
            return false;
        } 
        $selectedPaket = $this->paketUmroh->getPackage($id_paket, false, false, false);

        $nama_paket = $selectedPaket->nama_paket . ' (' . date_format(date_create($selectedPaket->tanggal_berangkat), "d F Y") . ')';
        $this->load->model('logistik');
        $barang = $this->logistik->getBarang($id_log);

        $this->load->view('staff/detail_sudah_ambil_view', $data = array(
            'paket' => $paket,
            'id_paket' => $id_paket,
            'id_log' => $id_log,
            'status' => $status,
            'nama_paket' => $nama_paket,
            'barang' => $barang,
        ));
    }

    public function load_detail() {
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
            array('db' => '`j`.`tanggal_lahir`', 'dt' => 'tanggal_lahir', 'field' => 'tanggal_lahir'),
            array('db' => '`j`.`jenis_kelamin`', 'dt' => 'jenis_kelamin', 'field' => 'jenis_kelamin'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $id_paket = $_GET['id_paket'];
        $id_logistik = $_GET['id_logistik'];
        $statusAmbil = $_GET['status'];
        $joinQuery = "FROM `{$table}` AS `pm` JOIN jamaah AS j ON (j.id_jamaah = pm.id_jamaah)";
        $extraCondition = "`pm`.`id_paket`=" . $id_paket;
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition);
        
        foreach ($data['data'] as $key => $d) {
            $this->load->model('logistik');
            $barang = $this->logistik->getBarang($id_logistik);
            $sudah = $this->logistik->getPerlengkapanSudahAmbil($d['DT_RowId']);
            $status = 0 ;
            foreach ($sudah['items'] as $ambil) {
                if ($ambil->id_logistik == $id_logistik) {
                    $status = 1;
                    if(!empty($ambil)) {
                        $data['data'][$key]['tanggal_ambil'] = $ambil->tanggal_ambil ;
                        $data['data'][$key]['nama_penginput'] = $ambil->staff ;
                    } else {
                        $data['data'][$key]['tanggal_ambil'] = null ;
                        $data['data'][$key]['nama_penginput'] = null;
                    }
                }
            }
            $data['data'][$key]['status_ambil'] = $status;
            if ($data['data'][$key]['status_ambil'] != $statusAmbil) {
                unset($data['data'][$key]);
            }
            if ($d['jenis_kelamin'] == 'P') {
                if (strpos(strtolower($barang[0]->nama_barang), 'laki') == true || strpos(strtolower($barang[0]->nama_barang), 'ihrom') == true) {
                    unset($data['data'][$key]);
                }
                if (strtolower($barang[0]->nama_barang) == 'ihram') {
                    unset($data['data'][$key]);
                }
            }

            if ($d['jenis_kelamin'] == 'L') {
                if (strpos(strtolower($barang[0]->nama_barang), 'perempuan') == true) {
                    unset($data['data'][$key]);
                }

                if (strtolower($barang[0]->nama_barang) == 'mukena' || strtolower($barang[0]->nama_barang) == 'bergo') {
                    unset($data['data'][$key]);
                }
            }
        }
        $data['data'] = array_values($data['data']);
        echo json_encode($data);
    }

    public function hapus() {
        if (!($_SESSION['email'] == 'qonita@ventour.co.id' || $_SESSION['bagian'] == 'Master Admin')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id_member', 'id', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/perlengkapan_peserta');
        }

        $id_member = $_GET['id_member'];
        $this->load->model('registrasi');
        $member = $this->registrasi->getJamaah(null, null, $id_member);
        if (empty($member)) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/perlengkapan_peserta');
        }

        $this->load->model('logistik');
        $result = $this->logistik->getPerlengkapanSudahAmbil($id_member);

        $data = array(
            'member' => $member,
            'sudahAmbil' => $result,
            'paket' => $member->member[0]->paket_info
        );

        $this->load->view('staff/hapus_perlengkapan_view', $data);
    }

    public function proses_hapus() {
        if (!($_SESSION['email'] == 'qonita@ventour.co.id' || $_SESSION['bagian'] == 'Master Admin')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        
        if (!isset($_POST['id_perl'])) {
            $this->alert->set('danger', 'Silahkan ceklis terlebih dahulu');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->form_validation->set_rules('id_member', 'id', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect('staff/perlengkapan_peserta');
        }

        $this->load->model('logistik');
        foreach ($_POST['id_perl'] as $id_perl) {
            $this->logistik->batalkanPending($id_perl);
        }
        $this->alert->set('success', 'Perlengkapan berhasul dihapus');
        redirect ($_SERVER['HTTP_REFERER']);
    }

    public function download_full() {

        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('idm', 'idm', 'trim|required|numeric');
        if ($this->form_validation->run() == false) {
            $this->alert->set('danger', 'Access Denied.');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->model('logistik');
        $data = $this->logistik->getRiwayatAmbil($_GET['idm']);
        $paket = $this->paketUmroh->getPackage($data['members'][0]->id_paket, false, false);
        $data['nama_penerima'] = null;
        $data['staff'] = null;
        foreach ($data['members'] as $key => $d) {
            if (!empty($d->riwayatAmbil['items'])) {
                $data['nama_penerima'] = $d->riwayatAmbil['items'][0]->penerima;
                $data['staff'] = $d->riwayatAmbil['items'][0]->staff;
                break;
            }
        }
        $this->load->library('date');
        $data['dateNow'] = $this->date->convert_date_indo(date('Y-m-d'));
        $strpos = strpos(strtolower($paket->nama_paket), ' ');
        $firstWord= substr($paket->nama_paket, 0, $strpos);
        $data['jenisPaket'] = false;
        $data['logo'] = 'asset/login/images/LOGO-VENTOUR.png';
        if (strtolower($firstWord) == "low" || strtolower($firstWord) == "lcu") {
            $data['jenisPaket'] = true;
            $data['logo'] = 'asset/login/images/LOGO-LCU.png';
        }
        // $data['id'] = $_GET['id'];
        $data['html'] = $this->load->view('staff/kuitansi_perl_view', $data, true);
        $this->load->view('staff/perlengkapan_view', $data);
    }
}