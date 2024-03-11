<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

defined('BASEPATH') or exit('No direct script access allowed');

class Finance extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }
        //this page for master admin, manifest and finance
        if (!($_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Finance' || $_SESSION['email'] == 'mala@ventour.co.id')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
    }

    public function bayar()
    {
        // echo '<pre>';
        // print_r($_SESSION);
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

        $this->load->view('staff/list_bayar', $data = array(
            'paket' => $paket,
            'id_paket' => $id_paket,
            'nama_paket' => $nama_paket
        ));
    }

    public function list_bayar_excel()
    {

        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/finance/bayar');
        }
        $this->load->model('tarif');
        $dt = $this->tarif->getPaymentsForPackage($_GET['id']);
        $list = $dt['list'];
        $sumCicil = $dt['sumCicil'];
        $sumTotal = $dt['sumTotal'];
        $sumKurang = $dt['sumKurang'];
        if ($sumKurang < 0 ) {
            $sumKurang = 0;
        }
        $fileName = str_replace(' ', '_', 'Payment_Report_' . $dt['paket']->nama_paket . '_' . date("Y-m-d") . '.xls');
        $header = array('NO', 'NAMA JAMAAH', 'GRUP ID');
        for ($i = 1; $i <= $dt['maxCicil']; $i++) {
            $header[] = "TANGGAL";
            $header[] = "KET";
            $header[] = "DP$i";
        }
        $header[] = "TOTAL BAYAR";
        $header[] = "KURANG";

        header("Content-Type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        echo "Laporan Pembayaran " . $dt['paket']->nama_paket . " " . $dt['paket']->tanggal_berangkat . "\n";
        echo "Update Tanggal : " . date("Y-m-d") . "\n\n";
        echo implode("\t", $header) . "\n";
        $no = 0;
        foreach ($list as $ls) {
            $no++;
            $nama = $ls->jamaah->first_name . ' ' . $ls->jamaah->second_name . ' ' . $ls->jamaah->last_name;
            $data = array($no, $nama, $ls->parent_id);
            for ($i = 0; $i < $dt['maxCicil']; $i++) {
                if (isset($ls->payments['data'][$i])) {
                    $data[] = $ls->payments['data'][$i]->tanggal_bayar;
                    $data[] = $ls->payments['data'][$i]->cara_pembayaran;
                    $data[] = $ls->payments['data'][$i]->jumlah_bayar;
                } else {
                    $data[] = '';
                    $data[] = '';
                    $data[] = '';
                }
            }
            $data[] = $ls->payments['totalBayar'];
            $data[] = $ls->payments['kurangBayar'];
            echo implode("\t", $data) . "\n";
        }
        $data = array('TOTAL', '', '');
        for ($i = 0; $i < $dt['maxCicil']; $i++) {
            $data[] = '';
            $data[] = '';
            $data[] = $sumCicil[$i];
        }
        $data[] = $sumTotal;
        $data[] = $sumKurang;
        echo implode("\t", $data) . "\n";
        exit();
    }

    public function verifikasi()
    {
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage(null, false, false, true);

        if (isset($_GET['id_paket']) && $_GET['id_paket'] !== 'all') {
            $id_paket = $_GET['id_paket'];
            $selectedPaket = $this->paketUmroh->getPackage($id_paket, false, false, false);
            $nama_paket = $selectedPaket->nama_paket . ' (' . date_format(date_create($selectedPaket->tanggal_berangkat), "d F Y") . ')';
        } else {
            $id_paket = 0;
            $nama_paket = 'Semua Paket';
        }
        $this->load->view('staff/list_verifikasi', $data = array(
            'paket' => $paket,
            'id_paket' => $id_paket,
            'nama_paket' => $nama_paket,
        ));
    }

    public function verifikasi_data()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('idj', 'idj', 'trim|required|integer');
        $this->form_validation->set_rules('idm', 'idm', 'trim|required|integer');
        $this->form_validation->set_rules('idb', 'idb', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/finance/verifikasi');
        }
        $refund = null;
        if (isset($_GET['refund'])) {
            $refund = $_GET['refund'];
        }
        $this->load->model('registrasi');
        $jamaah = $this->registrasi->getJamaah($_GET['idj']);
        if (empty($jamaah)) {
            $this->alert->set('danger', 'Data Tidak Ditemukan');
            redirect(base_url() . 'staff/finance/verifikasi');
        }
        $member = $this->registrasi->getMember($_GET['idm']);
        $this->load->model('tarif');
        $dataBayar = $this->tarif->getPembayaran($_GET['idm'], false, $_GET['idb']);
        if (empty($dataBayar['data'])) {
            $this->alert->set('danger', 'Data Tidak Ditemukan');
            redirect(base_url() . 'staff/finance/verifikasi');
        }
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage($member[0]->id_paket, false);
        $data = array(
            'member' => $member[0],
            'refund' => $refund,
            'jamaah' => $jamaah,
            'paket' => $paket,
            'dataBayar' => $dataBayar
        );
        $this->load->view('staff/verifikasi_view', $data);
    }

    public function proses_verifikasi()
    {
        $this->form_validation->set_rules('id_pembayaran', 'id_pembayaran', 'trim|required|integer');
        $this->form_validation->set_rules('verified', 'verified', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/finance/verifikasi');
        }
        $this->load->model('tarif');

        $ver = $this->tarif->verifikasi($_POST['id_pembayaran'], $_POST['verified']);
        if (!$ver) {
            $this->alert->set('danger', 'Data Pembayaran Tidak Ada');
        } else {
            $this->alert->set('success', 'Data Pembayaran Berhasil diverifikasi');
        }
        
        // $this->load->library('user_agent');
        // redirect($this->agent->referrer());
        // redirect($_SERVER['HTTP_REFERER']);
        if ($_GET['refund'] != null) {
            redirect(base_url() . 'staff/finance/verifikasi_refund');
        } else {
            redirect(base_url() . 'staff/finance/verifikasi');
        }

    }

    public function refund() {
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage(null, false, false, true);
        if (isset($_GET['id_paket']) && $_GET['id_paket'] != 0) {
            $id_paket = $_GET['id_paket'];
            $selectedPaket = $this->paketUmroh->getPackage($id_paket, false, false, false);
            $nama_paket = $selectedPaket->nama_paket . ' (' . date_format(date_create($selectedPaket->tanggal_berangkat), "d F Y") . ')';
        } else {
            $id_paket = 0;
            $nama_paket = 'Semuanya';
        }
        $this->load->view('staff/refund_pembayaran', $data = array(
            'paket' => $paket,
            'id_paket' => $id_paket,
            'nama_paket' => $nama_paket
        ));
    }

    public function verifikasi_refund()
    {
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage(null, false, false, true);

        if (isset($_GET['id_paket']) && $_GET['id_paket'] !== 'all') {
            $id_paket = $_GET['id_paket'];
            $selectedPaket = $this->paketUmroh->getPackage($id_paket, false, false, false);
            $nama_paket = $selectedPaket->nama_paket . ' (' . date_format(date_create($selectedPaket->tanggal_berangkat), "d F Y") . ')';
        } else {
            $id_paket = 0;
            $nama_paket = 'Semua Paket';
        }
        $this->load->view('staff/list_verifikasi_refund', $data = array(
            'paket' => $paket,
            'id_paket' => $id_paket,
            'nama_paket' => $nama_paket
        ));
    }

    public function extrafee()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('idj', 'idj', 'trim|required|integer');
        $this->form_validation->set_rules('idm', 'idm', 'trim|required|integer');
        $this->form_validation->set_rules('idpkt', 'idpkt', 'trim|required|integer');
        
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect(base_url() . 'staff/finance/bayar');
        }
        $this->load->model('tarif');
        if (isset($_POST['nominal'])) {
            //post set extra fee
            $_POST['nominal'] = str_replace(",","",$_POST['nominal']);
            $setEf = $this->tarif->setExtraFee($_GET['idm'], $_POST['nominal'], $_POST['keterangan']);
            if ($setEf) {
                $this->alert->set('success', 'Extra Fee berhasil ditambahkan');
            } else {
                $this->alert->set('danger', 'Update data gagal');
            }
            redirect(base_url() . 'staff/finance/bayar?id_paket=' . $_GET['idpkt']);
        }

        $this->load->model('registrasi');
        $jamaah = $this->registrasi->getJamaah($_GET['idj']);
        $member = $this->registrasi->getMember($_GET['idm']);
        if (empty($jamaah) || empty($member)) {
            $this->alert->set('danger', 'Data Tidak Ditemukan');
            redirect(base_url() . 'staff/finance/bayar?id_paket=' . $_GET['idpkt']);
        }

        $extrafee = $this->tarif->getExtraFee($_GET['idm']);



        $data = array(
            'jamaah' => $jamaah,
            'member' => $member[0],
            'extraFee' => $extrafee
        );


        $this->load->view('staff/extrafee_view', $data);
    }

    public function hapus_extrafee()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('idj', 'idj', 'trim|required|integer');
        $this->form_validation->set_rules('idm', 'idm', 'trim|required|integer');
        $this->form_validation->set_rules('idpkt', 'idpkt', 'trim|required|integer');
        $this->form_validation->set_rules('idef', 'idef', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/finance/bayar');
        }

        $this->load->model('tarif');
        $hapus = $this->tarif->deleteExtraFee($_GET['idef'], $_GET['idm']);
        if (!$hapus) {
            $this->alert->set('danger', 'Access Denied');
        } else {
            $this->alert->set('success', 'Extra Fee Berhasil dihapus');
        }
        redirect(base_url() . 'staff/finance/extrafee?idm=' . $_GET['idm'] . '&idj=' . $_GET['idj'] . '&idpkt=' . $_GET['idpkt']);
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
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`second_name`,' ',`j`.`last_name`) AS `whole_name`", 'dt' => "whole_name", 'field' => "whole_name"),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`last_name`) AS `two_name`", 'dt' => "two_name", 'field' => "two_name"),
            array('db' => '`pm`.`paspor_no`', 'dt' => 'paspor_no', 'field' => 'paspor_no'),
            array('db' => '`pm`.`total_harga`', 'dt' => 'total_harga', 'field' => 'total_harga'),
            array('db' => '`pm`.`lunas`', 'dt' => 'lunas', 'field' => 'lunas'),
            array('db' => '`pm`.`pilihan_kamar`', 'dt' => 'pilihan_kamar', 'field' => 'pilihan_kamar'),
            array('db' => '`pm`.`parent_id`', 'dt' => 'parent_id', 'field' => 'parent_id')
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $id_paket = $_GET['id_paket'];
        $joinQuery = "FROM `{$table}` AS `pm` LEFT JOIN `jamaah` AS `j` ON (`j`.`id_jamaah` = `pm`.`id_jamaah`)";
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

            //format money
            if (!empty($d['total_harga'])) {
                $data['data'][$key]['total_harga'] = 'Rp. ' . number_format($d['total_harga'], 0, ',', '.') . ',-';
            }

            //format lunas
            if ($d['lunas'] == 1) {
                $lns = 'Lunas';
            } else if ($d['lunas'] == 2) {
                $lns = 'Sudah Cicil';
            } else if ($d['lunas'] == 3) {
                $lns = 'Kelebihan Bayar';
            } else {
                $lns = 'Belum Bayar';
            }
            $data['data'][$key]['lunas'] = $lns;
        }
        echo json_encode($data);
    }

    public function load_verifikasi()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'pembayaran';
        // Primary key of table
        $primaryKey = 'id_member';

        $columns = array(
            array('db' => '`pm`.`id_member`', 'dt' => 'DT_RowId', 'field' => 'id_member'),
            array('db' => '`byr`.`id_pembayaran`', 'dt' => 'id_pembayaran', 'field' => 'id_pembayaran'),
            array('db' => '`pm`.`id_jamaah`', 'dt' => 'id_jamaah', 'field' => 'id_jamaah'),
            array('db' => '`j`.`first_name`', 'dt' => 'first_name', 'field' => 'first_name'),
            array('db' => '`j`.`second_name`', 'dt' => 'second_name', 'field' => 'second_name'),
            array('db' => '`j`.`last_name`', 'dt' => 'last_name', 'field' => 'last_name'),
            array('db' => '`j`.`referensi`', 'dt' => 'referensi', 'field' => 'referensi'),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`second_name`,' ',`j`.`last_name`) AS `whole_name`", 'dt' => "whole_name", 'field' => "whole_name"),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`last_name`) AS `two_name`", 'dt' => "two_name", 'field' => "two_name"),
            array('db' => '`pm`.`paspor_no`', 'dt' => 'paspor_no', 'field' => 'paspor_no'),
            array('db' => '`byr`.`jumlah_bayar`', 'dt' => 'jumlah_bayar', 'field' => 'jumlah_bayar'),
            array('db' => '`byr`.`tanggal_bayar`', 'dt' => 'tanggal_bayar', 'field' => 'tanggal_bayar'),
            array('db' => '`byr`.`verified`', 'dt' => 'verified', 'field' => 'verified'),
            array('db' => '`byr`.`scan_bayar`', 'dt' => 'scan_bayar', 'field' => 'scan_bayar'),
            array('db' => '`byr`.`jenis`', 'dt' => 'jenis', 'field' => 'jenis'),
            array('db' => '`byr`.`cara_pembayaran`', 'dt' => 'cara_pembayaran', 'field' => 'cara_pembayaran'),
            array('db' => '`byr`.`keterangan`', 'dt' => 'keterangan', 'field' => 'keterangan'),
            array('db' => '`pkt`.`nama_paket`', 'dt' => 'nama_paket', 'field' => 'nama_paket'),
            array('db' => '`pkt`.`tanggal_berangkat`', 'dt' => 'tanggal_berangkat', 'field' => 'tanggal_berangkat'),
            array('db' => '`pm`.`parent_id`', 'dt' => 'parent_id', 'field' => 'parent_id'),
            array('db' => '`pkt`.`harga`', 'dt' => 'harga', 'field' => 'harga'),
            array('db' => '`pkt`.`id_paket`', 'dt' => 'id_paket', 'field' => 'id_paket'),
            array('db' => '`a`.`id_agen`', 'dt' => 'id_agen', 'field' => 'id_agen'),
            array('db' => '`a`.`nama_agen`', 'dt' => 'nama_agen', 'field' => 'nama_agen'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $id_paket = $_GET['id_paket'];
        $joinQuery = "FROM `{$table}` AS `byr`"
            . "JOIN `program_member` AS `pm` ON (`byr`.`id_member` = `pm`.`id_member`)"
            . " JOIN `jamaah` AS `j` ON (`j`.`id_jamaah` = `pm`.`id_jamaah`)"
            . " JOIN `paket_umroh` AS `pkt` ON(`pkt`.`id_paket` = `pm`.`id_paket`)"
            . " LEFT JOIN `agen` AS `a` ON(`a`.`id_agen` = `pm`.`id_agen`)";
        $extraCondition = "`byr`.`jenis` = 'bayar'";
        // $extraCondition = $_GET['id_paket'] != 0 ? " AND `pkt`. `id_paket`=" . $id_paket : "";
        if ($_GET['id_paket'] != 0) {
            $condition = " AND pkt.id_paket = '$id_paket'";
            $extraCondition = $extraCondition . $condition;
        }
        // $extraCondition = "`pkt`. `id_paket`=" . $id_paket;
        
        // echo '<pre>';
        // print_r($_GET);
        // exit();
        if ($_GET['date_start'] != '') {
            $date_start = $_GET['date_start'];
            if ($extraCondition != "") {
                $condition = " AND byr.tanggal_bayar >= '$date_start 00:00:00'";
            } else {
                $condition = " byr.tanggal_bayar >= '$date_start 00:00:00'";
            }
            $extraCondition = $extraCondition . $condition;
        }
        if ($_GET['date_end'] != '') {
            $date_end = $_GET['date_end'];
            if ($extraCondition != "") {
                $condition = " AND byr.tanggal_bayar <= '$date_end 00:00:00'";
            } else {
                $condition = " byr.tanggal_bayar <= '$date_end 00:00:00'";
            }
            $extraCondition = $extraCondition . $condition;
        }
        // if ($_GET['date_start'] != '' && $_GET['date_end'] != '') {
        //     $date_start = $_GET['date_start'];
        //     $date_end = $_GET['date_end'];
        //     $condition = " AND byr.tanggal_bayar >= $date_start AND byr.tanggal_bayar <= $date_end";
        //     $extraCondition = $extraCondition . $condition;
        // }
        if ($_GET['payments_method'] != '') {
            $payments_method = $_GET['payments_method'];
            if ($extraCondition != "") {
                $condition = " AND byr.cara_pembayaran LIKE '$payments_method%'";
            } else {
                $condition = " byr.cara_pembayaran LIKE '$payments_method%'";
            }
            $extraCondition = $extraCondition . $condition;
        }
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition);
        //prepare extra data
        $this->load->model('registrasi');
        $this->load->model('tarif');
        $groupCtr = 0;
        $groupArr = array();
        foreach ($data['data'] as $key => $d) {
            $data['data'][$key]['harga'] = 'Rp. ' . number_format($data['data'][$key]['harga'], 0, ',', '.') . ',-';
            $data['data'][$key]['DT_RowAttr'] = array(
                'id_jamaah' => $d['id_jamaah'],
                'id_pembayaran' => $d['id_pembayaran'],
                'verified' => $d['verified']
            );
            $bayar = $this->tarif->getRiwayatBayar($d['DT_RowId']);
            $data['data'][$key]['notes'] = "";
            if (!empty($bayar['data'])) {
                $no = 0;
                foreach ($bayar['data'] as $byr) {
                    $no++;
                    if ($d['id_pembayaran'] == $byr->id_pembayaran) {
                        if ($d['keterangan'] == "Bayar DP") {
                            $data['data'][$key]['notes'] = "Bayar DP";
                        } elseif ($d['keterangan'] == "Pelunasan") {
                            $data['data'][$key]['notes'] = "Pelunasan";
                        } elseif ($d['keterangan'] == "Cicilan") {
                            $data['data'][$key]['notes'] = "Payments " . $no ;
                        } else {
                            $data['data'][$key]['notes'] = $d['keterangan'];
                        }

                        break;
                    }
                }
            }
            //determine WG status
            $wg = $this->registrasi->getWG($d['DT_RowId']);
            $data['data'][$key]['wg'] = $wg;
            //set verification class
            if ($d['verified'] == 1) {
                $data['data'][$key]['DT_RowClass'] = 'group-color-10';
            } elseif ($d['verified'] == 2) {
                $data['data'][$key]['DT_RowClass'] = 'group-color-11';
            }
            //format money
            if (!empty($d['jumlah_bayar'])) {
                $data['data'][$key]['jumlah_bayar'] = 'Rp. ' . number_format($d['jumlah_bayar'], 0, ',', '.') . ',-';
            }
            if ($d['parent_id'] !== NULL && $d['parent_id'] != '' && $d['parent_id'] != 0) {
                $groupMembers = $this->registrasi->getGroupMembers($d['parent_id']);
                $jumlahPax = count($groupMembers) . " Orang";
            } else {
                $jumlahPax = "1 Orang" ;
            }

            $data['data'][$key]['tanggal_invoice'] = '';
            $data['data'][$key]['jumlah_pax'] = $jumlahPax;
            if ($bayar['data']) {
                $data['data'][$key]['tanggal_invoice'] = $bayar['data'][0]->tanggal_bayar;
            }
        }
        echo json_encode($data);
    }

    public function load_verifikasi_refund()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'pembayaran';
        // Primary key of table
        $primaryKey = 'id_member';

        $columns = array(
            array('db' => '`pm`.`id_member`', 'dt' => 'DT_RowId', 'field' => 'id_member'),
            array('db' => '`byr`.`id_pembayaran`', 'dt' => 'id_pembayaran', 'field' => 'id_pembayaran'),
            array('db' => '`pm`.`id_jamaah`', 'dt' => 'id_jamaah', 'field' => 'id_jamaah'),
            array('db' => '`j`.`first_name`', 'dt' => 'first_name', 'field' => 'first_name'),
            array('db' => '`j`.`second_name`', 'dt' => 'second_name', 'field' => 'second_name'),
            array('db' => '`j`.`last_name`', 'dt' => 'last_name', 'field' => 'last_name'),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`second_name`,' ',`j`.`last_name`) AS `whole_name`", 'dt' => "whole_name", 'field' => "whole_name"),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`last_name`) AS `two_name`", 'dt' => "two_name", 'field' => "two_name"),
            array('db' => '`pm`.`paspor_no`', 'dt' => 'paspor_no', 'field' => 'paspor_no'),
            array('db' => '`pm`.`total_harga`', 'dt' => 'total_harga', 'field' => 'total_harga'),
            array('db' => '`byr`.`jumlah_bayar`', 'dt' => 'jumlah_bayar', 'field' => 'jumlah_bayar'),
            array('db' => '`byr`.`tanggal_bayar`', 'dt' => 'tanggal_bayar', 'field' => 'tanggal_bayar'),
            array('db' => '`byr`.`verified`', 'dt' => 'verified', 'field' => 'verified'),
            array('db' => '`byr`.`scan_bayar`', 'dt' => 'scan_bayar', 'field' => 'scan_bayar'),
            array('db' => '`byr`.`jenis`', 'dt' => 'jenis', 'field' => 'jenis'),
            array('db' => '`byr`.`cara_pembayaran`', 'dt' => 'cara_pembayaran', 'field' => 'cara_pembayaran'),
            array('db' => '`byr`.`keterangan`', 'dt' => 'keterangan', 'field' => 'keterangan'),
            array('db' => '`pkt`.`nama_paket`', 'dt' => 'nama_paket', 'field' => 'nama_paket'),
            array('db' => '`pkt`.`tanggal_berangkat`', 'dt' => 'tanggal_berangkat', 'field' => 'tanggal_berangkat'),
            array('db' => '`pm`.`parent_id`', 'dt' => 'parent_id', 'field' => 'parent_id'),
            array('db' => '`pkt`.`harga`', 'dt' => 'harga', 'field' => 'harga'),
            array('db' => '`pkt`.`id_paket`', 'dt' => 'id_paket', 'field' => 'id_paket'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $idPaket = $_GET['id_paket'];
        $joinQuery = "FROM `{$table}` AS `byr`"
            . "JOIN `program_member` AS `pm` ON (`byr`.`id_member` = `pm`.`id_member`)"
            . " JOIN `jamaah` AS `j` ON (`j`.`id_jamaah` = `pm`.`id_jamaah`)"
            . " JOIN `paket_umroh` AS `pkt` ON(`pkt`.`id_paket` = `pm`.`id_paket`)";
        $extraCondition = "`byr`.`jenis` = 'refund'";
        // $extraCondition = $_GET['id_paket'] != 0 ? " AND `pkt`. `id_paket`=" . $id_paket : "";
        if ($idPaket != 0) {
            $condition = " AND pkt.id_paket = '$idPaket'";
            $extraCondition = $extraCondition . $condition;
        }
        if ($_GET['date_start'] != '') {
            $date_start = $_GET['date_start'];
            if ($extraCondition != "") {
                $condition = " AND byr.tanggal_bayar >= '$date_start'";
            } else {
                $condition = " byr.tanggal_bayar >= '$date_start'";
            }
            $extraCondition = $extraCondition . $condition;
        }
        if ($_GET['date_end'] != '') {
            $date_end = $_GET['date_end'];
            if ($extraCondition != "") {
                $condition = " AND byr.tanggal_bayar <= '$date_end'";
            } else {
                $condition = " byr.tanggal_bayar <= '$date_end'";
            }
            $extraCondition = $extraCondition . $condition;
        }
        if ($_GET['payments_method'] != '') {
            $payments_method = $_GET['payments_method'];
            if ($extraCondition != "") {
                $condition = " AND byr.cara_pembayaran = '$payments_method'";
            } else {
                $condition = " byr.cara_pembayaran = '$payments_method'";
            }
            $extraCondition = $extraCondition . $condition;
        }
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition);
        //prepare extra data
        $this->load->model('registrasi');
        $this->load->model('tarif');
        $groupCtr = 0;
        $groupArr = array();
        foreach ($data['data'] as $key => $d) {
            $data['data'][$key]['harga'] = 'Rp. ' . number_format($data['data'][$key]['harga'], 0, ',', '.') . ',-';
            $data['data'][$key]['DT_RowAttr'] = array(
                'id_jamaah' => $d['id_jamaah'],
                'id_pembayaran' => $d['id_pembayaran'],
                'verified' => $d['verified']
            );
            $bayar = $this->tarif->getRiwayatBayar($d['DT_RowId']);
            $data['data'][$key]['notes'] = "";
            if (!empty($bayar['data'])) {
                $no = 0;
                foreach ($bayar['data'] as $byr) {
                    $no++;
                    if ($d['id_pembayaran'] == $byr->id_pembayaran) {
                        if ($d['keterangan'] == "Bayar DP") {
                            $data['data'][$key]['notes'] = "Bayar DP";
                        } elseif ($d['keterangan'] == "Pelunasan") {
                            $data['data'][$key]['notes'] = "Pelunasan";
                        } elseif ($d['keterangan'] == "Cicilan") {
                            $data['data'][$key]['notes'] = "Payments " . $no ;
                        } else {
                            $data['data'][$key]['notes'] = $d['keterangan'];
                        }

                        break;
                    }
                }
            }
            //determine WG status
            $wg = $this->registrasi->getWG($d['DT_RowId']);
            $data['data'][$key]['wg'] = $wg;
            //set verification class
            if ($d['verified'] == 1) {
                $data['data'][$key]['DT_RowClass'] = 'group-color-10';
            } elseif ($d['verified'] == 2) {
                $data['data'][$key]['DT_RowClass'] = 'group-color-11';
            }
            $this->load->model('tarif');
            $bayar = $this->tarif->getPembayaran($d['DT_RowId']);
            $total = count($bayar['data']);
            $totalBayar = 0;
            if ($bayar['totalBayar'] != 0) {
                $totalBayar = $bayar['totalBayar'];
            }


            $data['data'][$key]['jumlah_pembayaran'] = number_format($totalBayar);
            
            $this->load->model('registrasi');
            $groupMembers = $this->registrasi->getGroupMembers($d['parent_id']);
            $count = count($groupMembers);

            $data['data'][$key]['jumlah_keluarga'] = $count;

            $total_tagihan = $d['total_harga'];
            if ($d['parent_id'] != null) {
                $total_tagihan = $total_tagihan * $count;
            }

            $this->load->model('paketUmroh');
            $paket = $this->paketUmroh->getPackage($d['id_paket'], false, false);

            $data['data'][$key]['nama_paket'] = $paket->nama_paket;
            $data['data'][$key]['total_tagihan'] = 'Rp. ' . number_format($total_tagihan, 0, ',', '.') . ',-';
            $data['data'][$key]['jumlah_pembayaran'] = 'Rp. ' . number_format($totalBayar, 0, ',', '.') . ',-';


            //format money
            if (!empty($d['jumlah_bayar'])) {
                $data['data'][$key]['jumlah_bayar'] = 'Rp. ' . number_format(abs($d['jumlah_bayar']), 0, ',', '.') . ',-';
            }
        }      
        echo json_encode($data);
    }

    public function load_refund() {
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
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`second_name`,' ',`j`.`last_name`) AS `whole_name`", 'dt' => "whole_name", 'field' => "whole_name"),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`last_name`) AS `two_name`", 'dt' => "two_name", 'field' => "two_name"),
            array('db' => '`pm`.`paspor_no`', 'dt' => 'paspor_no', 'field' => 'paspor_no'),
            array('db' => '`pm`.`total_harga`', 'dt' => 'total_harga', 'field' => 'total_harga'),
            array('db' => '`pm`.`lunas`', 'dt' => 'lunas', 'field' => 'lunas'),
            array('db' => '`pm`.`pilihan_kamar`', 'dt' => 'pilihan_kamar', 'field' => 'pilihan_kamar'),
            array('db' => '`pm`.`parent_id`', 'dt' => 'parent_id', 'field' => 'parent_id'),
            array('db' => '`pm`.`id_paket`', 'dt' => 'id_paket', 'field' => 'id_paket'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $idPaket = $_GET['id_paket'];
        $joinQuery = "FROM `{$table}` AS `pm` LEFT JOIN `jamaah` AS `j` ON (`j`.`id_jamaah` = `pm`.`id_jamaah`)";
        if ($idPaket != 0 ) {
            $extraCondition = "`id_paket`= " . $idPaket;
        } else {
            $extraCondition = null;
        }
        $groupBy = "CASE WHEN `pm`.`parent_id` IS NOT NULL THEN `pm`.`parent_id` ELSE `pm`.`id_member` END";
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition, $groupBy);

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

            //format money
            if (!empty($d['total_harga'])) {
                $data['data'][$key]['total_harga'] = 'Rp. ' . number_format($d['total_harga'], 0, ',', '.') . ',-';
            }

            //format lunas
            if ($d['lunas'] == 1) {
                $lns = 'Lunas';
            } else if ($d['lunas'] == 2) {
                $lns = 'Sudah Cicil';
            } else if ($d['lunas'] == 3) {
                $lns = 'Kelebihan Bayar';
            } else {
                $lns = 'Belum Bayar';
            }
            $data['data'][$key]['lunas'] = $lns;

            // $payments = $this->tarif->getPaymentsForPackage($d['DT_RowId']);
            $this->load->model('tarif');
            $bayar = $this->tarif->getRiwayatBayar($d['DT_RowId']);

            
            $this->load->model('registrasi');
            $groupMembers = $this->registrasi->getGroupMembers($d['parent_id']);
            $count = count($groupMembers);

            $data['data'][$key]['jumlah_keluarga'] = $count;
            $data['data'][$key]['nilai_outstanding'] = $bayar['sisaTagihan'];
            if ($data['data'][$key]['nilai_outstanding'] < 0) {
                $data['data'][$key]['nilai_outstanding'] = 0;
                $data['data'][$key]['lebih_bayar'] = number_format($bayar['sisaTagihan']);
            } else {
                $data['data'][$key]['nilai_outstanding'] = number_format($bayar['sisaTagihan']);
                $data['data'][$key]['lebih_bayar'] = 0;
            }

            $this->load->model('paketUmroh');
            $paket = $this->paketUmroh->getPackage($d['id_paket'], false, false);

            $total_tagihan = $bayar['tarif']['totalHargaFamily'];

            $data['data'][$key]['nama_paket'] = $paket->nama_paket;
            $data['data'][$key]['total_tagihan'] = number_format($total_tagihan);
            $data['data'][$key]['jumlah_pembayaran'] = number_format($bayar['totalBayar']);
            
            //get lebih bayar
            $this->db->where('id_member', $d['DT_RowId']);
            $query = $this->db->get('refund_pembayaran');
            $data_refund = $query->result();
            $refund = end($data_refund);

            if (!empty($refund)) {
                $data['data'][$key]['status'] = $refund->verified;
                $data['data'][$key]['tanggal_pengembalian'] = $refund->tanggal_pengembalian;
                $data['data'][$key]['jenis_refund'] = $refund->jenis_pengembalian ;
            } else {
                $data['data'][$key]['status'] = null;
                $data['data'][$key]['tanggal_pengembalian'] = "";
                $data['data'][$key]['jenis_refund'] = "" ;
            }

        }
        echo json_encode($data);
    }

    public function load_paket()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'paket_umroh';
        // Primary key of table
        $primaryKey = 'id_paket';
        $columns = array(
            array('db' => 'id_paket', 'dt' => 'DT_RowId', 'field' => 'id_paket'),
            array('db' => 'nama_paket', 'dt' => 'nama_paket', 'field' => 'nama_paket'),
            array(
                'db' => 'harga',
                'dt' => 'harga',
                'field' => 'harga',
                'formatter' => function ($d, $row) {
                    return number_format($d);
                }
            ),
            array('db' => 'harga', 'dt' => 'hargaNoFormat', 'field' => 'harga'),
            array('db' => 'default_diskon', 'dt' => 'default_diskon', 'field' => 'default_diskon'),
            array('db' => 'tanggal_berangkat', 'dt' => 'tanggal_berangkat', 'field' => 'tanggal_berangkat'),
            array('db' => 'jumlah_seat', 'dt' => 'jumlah_seat', 'field' => 'jumlah_seat'),
            array('db' => 'publish', 'dt' => 'publish', 'field' => 'publish')
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $month = explode("_", $_GET['month']);

        if ($month[0] != 0 && $month[1] != 0000) {
            $extraCondition = "MONTH(tanggal_berangkat) = " . $month[0] . " AND YEAR(tanggal_berangkat) = " . $month[1];
        } else {
            $extraCondition = "";
        }

        // if($id == 2) { 
        //     if ($extraCondition == "") {
        //         $condition = "tanggal_berangkat >='" . date('Y-m-d'). "'";
        //     } else {
        //         $condition = " AND tanggal_berangkat >='" . date('Y-m-d'). "'";
        //     }
        //     $extraCondition = $extraCondition . $condition;
        // }
        // if($id == 1) {
        //     if ($extraCondition == "") {
        //         $condition = "tanggal_berangkat <='" . date('Y-m-d'). "'";
        //     } else {
        //         $condition = " AND tanggal_berangkat <='" . date('Y-m-d'). "'";
        //     }
        //     $extraCondition = $extraCondition . $condition;
        // }
        // if($id == 0) { 
        //     $extraCondition = $extraCondition;
        // }

        if ($_GET['ket'] != '') {
            $ket = $_GET['ket'];
            if ($ket == 1) {
                if ($extraCondition != "") {
                    $condition = " AND tanggal_berangkat <='" . date('Y-m-d') . "'";
                } else {
                    $condition = "tanggal_berangkat <= '" . date('Y-m-d'). "'";;
                }
                $extraCondition = $extraCondition . $condition;
            }

            if ($ket == 0) {
                if ($extraCondition != "") {
                    $condition = " AND tanggal_berangkat >='" . date('Y-m-d') . "'";
                } else {
                    $condition = "tanggal_berangkat >= '" . date('Y-m-d'). "'";;
                }
                $extraCondition = $extraCondition . $condition;
            }
        }

        // if($id == 2 && $month[0] == 0) {
        //     if ($extraCondition == "") {
        //         $condition = "tanggal_berangkat >='" . date('Y-m-d'). "'";
        //     } else {
        //         $condition = " AND tanggal_berangkat >='" . date('Y-m-d'). "'";
        //     }
        //     $extraCondition = $extraCondition . $condition;
        // }
        // if($id == 1 && $month[0] == 0 ) {
        //     if ($extraCondition == "") {
        //         $condition = "tanggal_berangkat <='" . date('Y-m-d'). "'";
        //     } else {
        //         $condition = " AND tanggal_berangkat <='" . date('Y-m-d'). "'";
        //     }
        //     $extraCondition = $extraCondition . $condition;
        // }
        // if($id == 0 && $month[0] == 0) {
        //     $extraCondition = $extraCondition;
        // }

        //new filter
        if ($_GET['date_start'] != '') {
            $date_start = $_GET['date_start'];
            if ($extraCondition != "") {
                $condition = " AND tanggal_berangkat >= '$date_start'";
            } else {
                $condition = " tanggal_berangkat >= '$date_start'";
            }
            $extraCondition = $extraCondition . $condition;
        }
        if ($_GET['date_end'] != '') {
            $date_end = $_GET['date_end'];
            if ($extraCondition != "") {
                $condition = " AND tanggal_berangkat <= '$date_end'";
            } else {
                $condition = " tanggal_berangkat <= '$date_end'";
            }
            $extraCondition = $extraCondition . $condition;
        }

        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, null, $extraCondition);
        $this->load->model('paketUmroh');
        // $paket = $this->paketUmroh->getPackage(157, false);
        // $this->load->model('registrasi');
        $this->load->model('tarif');
        $this->load->library('login_lib');
        $status_pembayaran = [];
        foreach ($data['data'] as $key => $d) {
            //sisa_seat status
            $paket = $this->paketUmroh->getPackage($d['DT_RowId'], false);
            if (isset($paket->sisa_seat)) {
                $data['data'][$key]['sisa_seat'] = $paket->sisa_seat;
            } else {
                $data['data'][$key]['sisa_seat'] = 0;
            }
            $data['data'][$key]['terisi'] = $d['jumlah_seat'] - $data['data'][$key]['sisa_seat'];
            //ambil jatuh tempo
            if (date('Y-m-d', strtotime($paket->tanggal_pelunasan)) < date('Y-m-d')) {
                $data['data'][$key]['jatuh_tempo'] = 'Sudah terlewat';
            } else {
                $data['data'][$key]['jatuh_tempo'] = $paket->tanggal_pelunasan;
            }
            
            $data['data'][$key]['countdown'] = floor((strtotime($paket->tanggal_pelunasan) - strtotime(date('Y-m-d'))) / (60 * 60 * 24));

            $payments = $this->tarif->getPaymentsForPackage($d['DT_RowId']);

            if (!$payments) {
                $persentase = 'kosong';
                // $persentaseAllSeat = 'kosong';
                $outstanding = 0;
                $statusBayar = 'kosong';
            } else {
                if ($payments['sumTotal'] != 0) {
                    $persentase = round($payments['sumTotal'] / ($payments['sumKurang'] + $payments['sumTotal']) * 100);
                } else {
                    $persentase = 'kosong';
                }
                if ($payments['sumTotal'] == 0) {
                    $statusBayar = 'Belum DP';
                } elseif ($payments['sumKurang'] > 0) {
                    $statusBayar = 'Sudah Cicil';
                } elseif ($payments['sumKurang'] == 0) {
                    $statusBayar = 'Sudah Lunas';
                } elseif ($payments['sumKurang'] < 0) {
                    $statusBayar = 'Kelebihan Bayar';
                }
            }
            $status_pembayaran[] = $statusBayar;
            $data['data'][$key]['persentase'] = $persentase . " %";
            $data['data'][$key]['status_pembayaran'] = $statusBayar;
            
            if (isset($paket->publish)) {
                if($paket->publish == 0 && $data['data'][$key]['sisa_seat'] > 0) {
                    $data['data'][$key]['status_group'] = "Unpublish";
                } else if ($paket->publish == 1 && $data['data'][$key]['sisa_seat'] > 0) {
                    $data['data'][$key]['status_group'] = "Belum Penuh";
                } else if ($paket->publish == 1 && $data['data'][$key]['sisa_seat'] <= 0){
                    $data['data'][$key]['status_group'] = "Sudah Penuh";
                } else if ($paket->publish == 0 && $data['data'][$key]['sisa_seat'] <= 0){
                    $data['data'][$key]['status_group'] = "Sudah Penuh";
                }
            } else {
                $data['data'][$key]['status_group'] = "Sudah Berangkat";
            }
            // $data['data'][$key]['lebih_bayar'] = ;
            
            // $jumlah_pembayaran = 0;
            // if ($payments['sumCicil']) {
            //     foreach ($payments['sumCicil'] as $keyArr => $item) {
            //         $jumlah_pembayaran += $payments['sumCicil'][$keyArr];
            //     }
            // }
            $data['data'][$key]['jumlah_pembayaran'] = number_format($payments['sumTotal']);
            
            $data['data'][$key]['total_exclude'] = number_format($payments['sumExclude']);
            $data['data'][$key]['excludeNoFormat'] = $payments['sumExclude'];

            
            // $total_tagihan = $data['data'][$key]['terisi'] * $data['data'][$key]['hargaNoFormat'] + $data['data'][$key]['excludeNoFormat'] - $data['data'][$key]['default_diskon'];
            // $this->load->model('registrasi');
            // $member = $this->registrasi->getMember(null,null,$id_paket);
            // $this->db->where('id_paket', $data['data'][$key]['DT_RowId']);
            // $member = $this->db->get('program_member')->result();
            // $total_tagihan = 0;
            // foreach ($member as $value) {
            //     $total_tagihan += $value->total_harga;
            // }
            $total_tagihan = $payments['totalTagihan'];
            if ($total_tagihan < 0) {
                $total_tagihan = 0;
            }
            // $this->load->model('registrasi');
            // $member = $this->registrasi->getMember();
            $this->db->where('id_paket', $data['data'][$key]['DT_RowId']);
            $this->db->where('lunas', 0);
            $member = $this->db->get('program_member')->result();
            $belum_dp = 0;
            foreach ($member as $m) {
                $belum_dp++;
            }
            // $belum_dp = 0;
            // if ($payments['sumTotal'] == 0) {
            //     if ($data['data'][$key]['terisi'] != 0) {
            //         $belum_dp += 1;
            //     }
            // }

            // start ambil data infant //
            $this->db->select('*');
            $this->db->from('program_member pm');
            $this->db->join('jamaah j', 'pm.id_jamaah = j.id_jamaah');
            $this->db->where('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) < 2');
            $this->db->where('pm.id_paket', $d['DT_RowId']);
            $infant = $this->db->count_all_results();
            $data['data'][$key]['infant'] = $infant;
            // end ambil data infant //
            
            // start ambil data anak //
            $this->db->select('*');
            $this->db->from('program_member pm');
            $this->db->join('jamaah j', 'pm.id_jamaah = j.id_jamaah');
            $this->db->where('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) >= 2');
            $this->db->where('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) < 7');
            $this->db->where('pm.id_paket', $d['DT_RowId']);
            $anak = $this->db->count_all_results();
            $data['data'][$key]['anak'] = $anak;
            // end ambil data anak //
            
            // start ambil data dewasa //
            $this->db->select('*');
            $this->db->from('program_member pm');
            $this->db->join('jamaah j', 'pm.id_jamaah = j.id_jamaah');
            $this->db->where('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) >= 7');
            $this->db->where('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) < 60');
            $this->db->where('pm.id_paket', $d['DT_RowId']);
            $dewasa = $this->db->count_all_results();

            $this->db->select('*');
            $this->db->from('program_member pm');
            $this->db->join('jamaah j', 'pm.id_jamaah = j.id_jamaah');
            $this->db->where('j.tanggal_lahir', '0000-00-00');
            $this->db->where('pm.id_paket', $d['DT_RowId']);
            $formatDate = $this->db->count_all_results();

            $this->db->select('*');
            $this->db->from('program_member pm');
            $this->db->join('jamaah j', 'pm.id_jamaah = j.id_jamaah');
            $this->db->where('j.tanggal_lahir', null);
            $this->db->where('pm.id_paket', $d['DT_RowId']);
            $nullDate = $this->db->count_all_results();
            $data['data'][$key]['dewasa'] = $dewasa + $nullDate + $formatDate;
            // end ambil data dewasa //
            
            // start ambil data lansia //
            $this->db->select('*');
            $this->db->from('program_member pm');
            $this->db->join('jamaah j', 'pm.id_jamaah = j.id_jamaah');
            $this->db->where('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) >= 60');
            $this->db->where('pm.id_paket', $d['DT_RowId']);
            $lansia = $this->db->count_all_results();
            $data['data'][$key]['lansia'] = $lansia;
            // end ambil data lansia //


            $data['data'][$key]['belum_dp'] = $belum_dp;
            $data['data'][$key]['total_tagihan'] = number_format($total_tagihan);
            // $data['data'][$key]['lansia'] = $lansia;
            // $data['data'][$key]['dewasa'] = $dewasa;
            $data['data'][$key]['anak'] = $anak;
            // echo '<pre>';
            // print_r($data['data']);
            // exit();
            
            $this->db->where('id_paket', $data['data'][$key]['DT_RowId']);
            $dataMember = $this->db->get('program_member')->result();
            $nilai_outstanding = 0;
            foreach ($dataMember as $dm) {
                $this->load->model('tarif');
                $tarif = $this->tarif->getRiwayatBayar($dm->id_member);
                if ($dm->parent_id == $dm->id_member || $dm->parent_id == null || $dm->parent_id == 0) {
                    if ($tarif['sisaTagihan'] > 0) {
                        $nilai_outstanding += $tarif['sisaTagihan'];
                    }
                }
            }
            // echo '<pre>';
            // print_r($dataMember);
            // exit();

            // nilai outstanding
            $data['data'][$key]['nilai_outstanding'] = number_format($nilai_outstanding);
            $data['data'][$key]['lebih_bayar'] = 0;
            if ($data['data'][$key]['nilai_outstanding'] < 0) {
                $data['data'][$key]['nilai_outstanding'] = 0;
                $data['data'][$key]['lebih_bayar'] = number_format(abs($nilai_outstanding));
            } 

            // warning untuk finance
            if ($data['data'][$key]['countdown'] < 45 && $data['data'][$key]['countdown'] > 0  && $_SESSION['bagian'] == 'Finance' && $data['data'][$key]['status_pembayaran'] != 'Sudah Lunas') {
                $this->alert->set('danger', 'Ada Paket yang hampir jatuh tempo dan Belum Lunas');
            }
        }

        if ($_GET['status'] != '') {
            $sort_bayar = $data['data'];
            $data['data'] = [];
            $status = $_GET['status'];
            asort($status_pembayaran);
            foreach ($status_pembayaran as $ks => $s) {
                foreach ($sort_bayar as $k => $d) {
                    if ($status == 0) {
                        if ($s == "Belum DP") {
                            $data['data'][$ks] = $sort_bayar[$ks];
                        }
                        if ($s == "Sudah Cicil") {
                            $data['data'][$ks] = $sort_bayar[$ks];
                        }
                        if ($s == "kosong") {
                            $data['data'][$ks] = $sort_bayar[$ks];
                        }
                    }
                    if ($status == 2) {
                        if ($s == "Kelebihan Bayar") {
                            $data['data'][$ks] = $sort_bayar[$ks];
                        }
                    }
                    if ($status == 1) {
                        if ($s == "Sudah Lunas") {
                            $data['data'][$ks] = $sort_bayar[$ks];
                        }
                    }
                }
            }
            $data['data'] = array_values($data['data']);
        }
        echo json_encode($data);
    }

    public function summary()
    {
        $this->load->model('paketUmroh');
        if (isset($_GET['month'])) {
            // if ($_GET['month'] != '0 0000') {
                $month = $_GET['month'];
            // } else {
            //     $month = 0;
            // }
        } else {
            $month = '0_0000';
        }

        $this->load->library('Date');
        $hasil = $this->paketUmroh->getAvailableYear(false, false, null);
        $monthPackage = [] ;
        foreach($hasil as $m ) {
            $array[] = $this->paketUmroh->getAllMonth(false, false, $m->Y);
        }

        foreach ($array as $last) {
            foreach($last as $m) {
                $monthPackage[]['tanggal_berangkat'] = $m->tanggal_berangkat;
            }
        }

        $data = array (
            "monthPackage" => $monthPackage,
            "month" => $month
        );
        $this->load->view('staff/summary_view', $data);
    }

    public function list_summary()
    {
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage(null, true, true);
        $fileName = 'Verifikasi Summary Pembayaran ' . date('d F Y') . '.xls';
        $header = array('NO', 'NAMA PAKET', 'HARGA PAKET');
        $header[] = "DISCOUNT PAKET";
        $header[] = "TOTAL EXCLUDE";
        $header[] = "TANGGAL KEBERANGKATAN";
        $header[] = "JUMLAH PAX";
        $header[] = "TERISI";
        $header[] = "SISA SEAT";
        $header[] = "TOTAL BELUM DP";
        $header[] = "TOTAL TAGIHAN";
        $header[] = "JUMLAH PEMBAYARAN JAMAAH";
        $header[] = "JUMLAH LEBIH BAYAR";
        $header[] = "NILAI OUTSTANDING";
        $header[] = "JATUH TEMPO";
        $header[] = "SISA HARI PELUNASAN";
        $header[] = "STATUS GROUP";

        header("Content-Type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        echo "\n\n";
        echo implode("\t", $header) . "\n";
        $no = 0;
        foreach ($paket as $p) {
            $this->load->model('tarif');
            $payments = $this->tarif->getPaymentsForPackage($p->id_paket);

            $this->db->where('id_paket', $p->id_paket);
            $this->db->where('lunas', 0);
            $member = $this->db->get('program_member')->result();
            $belum_dp = 0;
            foreach ($member as $m) {
                $belum_dp++;
            }

            $this->db->where('id_paket', $p->id_paket);
            $member = $this->db->get('program_member')->result();
            $total_tagihan = 0;
            foreach ($member as $value) {
                $total_tagihan += $value->total_harga;
            }

            $lebih_bayar = 0;
            $nilai_outstanding = 0;
            if ($payments['sumKurang'] < 0) {
                $lebih_bayar = abs($payments['sumKurang']);
                $nilai_outstanding = 0;
            } else {
                $lebih_bayar = 0;
                $nilai_outstanding = $payments['sumKurang'];
            }

            $status_group = "";
            if (isset($p->publish)) {
                if($p->publish == 0 ) {
                    $status_group = "Unpublish";
                } else {
                    if (isset($p->sisa_seat)) {
                        $status_group = "Belum Penuh";
                    } else {
                        $status_group = "Sudah Penuh";
                    }
                }
            } else {
                $status_group = "Sudah Berangkat";
            }

            if (date('Y-m-d', strtotime($p->tanggal_pelunasan)) < date('Y-m-d')) {
                $jatuh_tempo = 'Sudah terlewat';
            } else {
                $jatuh_tempo = $p->tanggal_pelunasan;
            }

            $hari = floor((strtotime($p->tanggal_pelunasan) - strtotime(date('Y-m-d'))) / (60 * 60 * 24));
            if ($hari > 0) {
                $sisa_hari_lunas = $hari . ' hari lagi';
            } else {
                $sisa_hari_lunas = 'Over due date';
            }
            // if (!$payments) {
            //     $persentase = 'kosong';
            // } else {
            //     $persentase = round($payments['sumTotal'] / ($payments['sumKurang'] + $payments['sumTotal']) * 100) . ' %';
            // }
            $no++;
            $nama_paket = $p->nama_paket;
            $data = array($no, $nama_paket, (int)$p->harga);
            $data[] = (int)$p->default_diskon ;
            $data[] = (int)$payments['sumExclude'] ;
            $data[] = $p->tanggal_berangkat;
            $data[] = $p->jumlah_seat;
            $data[] = $p->jumlah_seat - $p->sisa_seat;
            $data[] = $p->sisa_seat;
            $data[] = $belum_dp;
            $data[] = $total_tagihan;
            $data[] = $payments['sumTotal'];
            $data[] = $lebih_bayar;
            $data[] = $nilai_outstanding;
            $data[] = $jatuh_tempo;
            $data[] = $sisa_hari_lunas;
            $data[] = $status_group;
            echo implode("\t", $data) . "\n";
        }
        echo implode("\t", $data) . "\n";
        exit();
    }


    public function detail_paket()
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


        $this->load->view('staff/detail_paket_finance', $data = array(
            'paket' => $paket,
            'id_paket' => $id_paket,
            'nama_paket' => $nama_paket
        ));
    }

    public function hapusPembayaran()
    {
        if (!($_SESSION['bagian'] == 'Master Admin')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }

        $this->load->model('tarif');
        $data = $this->tarif->hapusPembayaran($_GET['id'], $_GET['idm']);
        if ($data == true) {
            $this->alert->set('success', 'Data Pembayaran Berhasil Dihapus');
        } else {
            $this->alert->set('danger', 'Data Pembayaran Gagal Dihapus');
        }
        redirect(base_url() . 'staff/finance/verifikasi');
    }

    public function hapusRefund()
    {
        if (!($_SESSION['bagian'] == 'Master Admin')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }

        $this->load->model('tarif');
        $data = $this->tarif->hapusPembayaran($_GET['id'], $_GET['idm']);
        if ($data == true) {
            $this->alert->set('success', 'Data Pembayaran Berhasil Dihapus');
        } else {
            $this->alert->set('danger', 'Data Pembayaran Gagal Dihapus');
        }
        redirect(base_url() . 'staff/finance/verifikasi_refund');
    }

    public function diskon_log()
    {
        $id_paket = $_GET['id'];
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage($id_paket, false, false);
        $this->load->view('staff/diskon_log_view', $data = array(
            'id_paket' => $id_paket,
            'nama_paket' => $paket->nama_paket
        )); 
    }

    public function load_diskon() {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'discount_log';
        // Primary key of table
        $primaryKey = 'id_log';
        $columns = array(
            array('db' => '`dl`.`id_log`', 'dt' => 'DT_RowId', 'field' => 'id_log'),
            array('db' => '`dl`.`id_paket`', 'dt' => 'id_paket', 'field' => 'id_paket'),
            array('db' => '`dl`.`discount`', 'dt' => 'discount', 'field' => 'discount'),
            array('db' => '`dl`.`deskripsi_diskon`', 'dt' => 'deskripsi_diskon', 'field' => 'deskripsi_diskon'),
            array('db' => '`dl`.`tanggal_mulai`', 'dt' => 'tanggal_mulai', 'field' => 'tanggal_mulai'),
            array('db' => '`dl`.`tanggal_berakhir`', 'dt' => 'tanggal_berakhir', 'field' => 'tanggal_berakhir'),
            array('db' => '`pkt`.`nama_paket`', 'dt' => 'nama_paket', 'field' => 'nama_paket'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $id_paket = $_GET['id_paket'];
        $joinQuery = "FROM `{$table}` AS `dl`"
        . " JOIN `paket_umroh` AS `pkt` ON(`pkt`.`id_paket` = `dl`.`id_paket`)";
        $extraCondition = "`dl`.`id_paket`=$id_paket";
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition);
        foreach ($data['data'] as $key => $d) {
            $data['data'][$key]['discount'] = number_format($data['data'][$key]['discount']);
            $data['data'][$key]['DT_RowAttr'] = array(
                'id_paket' => $id_paket,
                'tgl_mulai' => $d['tanggal_mulai'],
                'tgl_berakhir' => $d['tanggal_berakhir']
            );
        }
        echo json_encode($data);
    }

    public function diskon_log_jamaah()
    {
        $id_paket = $_GET['id'];
        $tgm = $_GET['tgm'];
        $tgb = $_GET['tgb'];
        $id_log = $_GET['id_log'];
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage($id_paket, false, false);
        $this->load->view('staff/diskon_jamaah_view', $data = array(
            'id_paket' => $id_paket,
            'nama_paket' => $paket->nama_paket,
            'tgm' => $tgm,
            'tgb' => $tgb,
            'id_log' => $id_log
        )); 
    }

    public function load_diskon_jamaah() {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'program_member';
        // Primary key of table
        $primaryKey = 'id_member';
        $columns = array(
            array('db' => '`pm`.`id_member`', 'dt' => 'DT_RowId', 'field' => 'id_member'),
            array('db' => '`pm`.`tgl_regist`', 'dt' => 'tgl_regist', 'field' => 'tgl_regist'),
            array('db' => '`pm`.`id_paket`', 'dt' => 'id_paket', 'field' => 'id_paket'),
            array('db' => '`pkt`.`nama_paket`', 'dt' => 'nama_paket', 'field' => 'nama_paket'),
            array('db' => '`dl`.`discount`', 'dt' => 'discount', 'field' => 'discount'),
            array('db' => '`dl`.`deskripsi_diskon`', 'dt' => 'deskripsi_diskon', 'field' => 'deskripsi_diskon'),
            array('db' => '`j`.`first_name`', 'dt' => 'first_name', 'field' => 'first_name'),
            array('db' => '`j`.`second_name`', 'dt' => 'second_name', 'field' => 'second_name'),
            array('db' => '`j`.`last_name`', 'dt' => 'last_name', 'field' => 'last_name'),
            array('db' => '`dl`.`tanggal_berakhir`', 'dt' => 'tanggal_berakhir', 'field' => 'tanggal_berakhir'),
            array('db' => '`dl`.`tanggal_mulai`', 'dt' => 'tanggal_mulai', 'field' => 'tanggal_mulai'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $id_paket = $_GET['id_paket'];
        $tgb = $_GET['tgb'];
        $tgm = $_GET['tgm'];
        $id_log = $_GET['id_log'];
        $joinQuery = "FROM `{$table}` AS `pm`"
        . " JOIN `discount_log` AS `dl` ON(`dl`.`id_paket` = `pm`.`id_paket`)"
        . " JOIN `jamaah` AS `j` ON(`j`.`id_jamaah` = `pm`.`id_jamaah`)"
        . " JOIN `paket_umroh` AS `pkt` ON (`pkt`.`id_paket` = `pm`.`id_paket`)";
        
        $extraCondition = "`pm`.`id_paket`=$id_paket AND `pm`.`tgl_regist` >= '$tgm' AND `pm`.`tgl_regist` <= '$tgb' AND `dl`.`id_log` = $id_log";
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition);

        foreach ($data['data'] as $key => $dt) {

            $this->load->model('tarif');
            $extra_fee = $this->tarif->getExtraFee($dt['DT_RowId']);
            $keterangan = "- " . $dt['deskripsi_diskon'] . ' - ';
            if (!empty($extra_fee)) {
                foreach ($extra_fee as $ef) {
                    if ($ef->nominal < 0) {
                        $diskon = $dt['discount'] - $ef->nominal;
                        $data['data'][$key]['discount'] = number_format($diskon);
                        $keterangan = $keterangan . $ef->keterangan . ' - ';
                    }
                }
                $data['data'][$key]['deskripsi_diskon'] = substr($keterangan, 0, -3);
            }
        }

        echo json_encode($data);
    }

    
    public function detail_exclude() {
        $id_paket = $_GET['id'];
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage($id_paket, false, false);
        $data = array(
            'id_paket' => $id_paket,
            'nama_paket' => $paket->nama_paket,
        );
        $this->load->view('staff/detail_exclude_view', $data);
    }

    public function load_exclude() {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'program_member';
        // Primary key of table
        $primaryKey = 'id_member';
        $columns = array(
            array('db' => '`pm`.`id_member`', 'dt' => 'DT_RowId', 'field' => 'id_member'),
            array('db' => '`pm`.`tgl_regist`', 'dt' => 'tgl_regist', 'field' => 'tgl_regist'),
            array('db' => '`pm`.`id_paket`', 'dt' => 'id_paket', 'field' => 'id_paket'),
            array('db' => '`pm`.`pilihan_kamar`', 'dt' => 'pilihan_kamar', 'field' => 'pilihan_kamar'),
            array('db' => '`pm`.`total_harga`', 'dt' => 'total_harga', 'field' => 'total_harga'),
            array('db' => '`pkt`.`nama_paket`', 'dt' => 'nama_paket', 'field' => 'nama_paket'),
            array('db' => '`pkt`.`harga`', 'dt' => 'harga', 'field' => 'harga'),
            array('db' => '`pkt`.`harga_double`', 'dt' => 'harga_double', 'field' => 'harga_double'),
            array('db' => '`pkt`.`harga_triple`', 'dt' => 'harga_triple', 'field' => 'harga_triple'),
            array('db' => '`j`.`first_name`', 'dt' => 'first_name', 'field' => 'first_name'),
            array('db' => '`j`.`second_name`', 'dt' => 'second_name', 'field' => 'second_name'),
            array('db' => '`j`.`last_name`', 'dt' => 'last_name', 'field' => 'last_name'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $id_paket = $_GET['id_paket'];
        $joinQuery = "FROM `{$table}` AS `pm`"
        . " JOIN `jamaah` AS `j` ON(`j`.`id_jamaah` = `pm`.`id_jamaah`)"
        . " JOIN `paket_umroh` AS `pkt` ON (`pkt`.`id_paket` = `pm`.`id_paket`)";
        
        $extraCondition = "`pm`.`id_paket`=$id_paket";
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition);
        // echo '<pre>';
        // print_r($exclude);
        // exit();


        foreach ($data['data'] as $key => $item) {
            $this->load->model('tarif');
            $exclude = $this->tarif->getExtraFee($item['DT_RowId']);
            $total_exclude = 0;
            $keterangan = "- ";
            if (!empty($exclude)) {
                foreach ($exclude as $x) {
                    if ($x->nominal > 0) {
                        $total_exclude += $x->nominal;
                        $keterangan = $keterangan . $x->keterangan . ' - ';
                    } 
                }
            }

            
            if ($item['pilihan_kamar'] != 'Quad') {
                if ($item['pilihan_kamar'] == 'Triple') {
                    $total_exclude = $total_exclude + $item['harga_triple'] - $item['harga'];
                }
                if ($item['pilihan_kamar'] == 'Double') {
                    $total_exclude = $total_exclude + $item['harga_double'] - $item['harga'];
                }
            }
            $data['data'][$key]['total_exclude'] = number_format($total_exclude);
            $data['data'][$key]['keterangan'] = substr($keterangan, 0, -3);
            if ($total_exclude == 0) {
                unset($data['data'][$key]);
            }
        }
        $data['data'] = array_values($data['data']);
        echo json_encode($data);
    }

    public function exclude_jamaah_detail() {
        $id_member = $_GET['id'];
        $this->load->model('registrasi');
        $jamaah = $this->registrasi->getJamaah(null, null, $id_member);
        $data = [
            'id_member' => $id_member,
            'nama_jamaah' => $jamaah->first_name
        ];
        $this->load->view('staff/exclude_jamaah_detail', $data);
    }

    public function load_jamaah_exclude() {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'extra_fee';
        // Primary key of table
        $primaryKey = 'id_fee';
        $columns = array(
            array('db' => '`ef`.`id_fee`', 'dt' => 'DT_RowId', 'field' => 'id_fee'),
            array('db' => '`pm`.`id_member`', 'dt' => 'id_member', 'field' => 'id_member'),
            // array('db' => '`pm`.`pilihan_kamar`', 'dt' => 'pilihan_kamar', 'field' => 'pilihan_kamar'),
            array('db' => '`ef`.`nominal`', 'dt' => 'nominal', 'field' => 'nominal'),
            array('db' => '`ef`.`keterangan`', 'dt' => 'keterangan', 'field' => 'keterangan'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $id_member = $_GET['id'];
        $joinQuery = "FROM `{$table}` AS `ef`"
        . " JOIN `program_member` AS `pm` ON(`ef`.`id_member` = `pm`.`id_member`)";
        
        $extraCondition = "`ef`.`id_member`=$id_member AND `ef`.`nominal` > 0";
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition);
        $this->load->model('registrasi');
        $this->load->model('paketUmroh');
        $member = $this->registrasi->getMember($id_member);
        $paket = $this->paketUmroh->getPackage($member[0]->id_paket, false, false);
        
        end($data['data']);
        $lastArr = key($data['data']);
        $key1 = $lastArr + 1;
        $nominal = 0;
        $keterangan = '';

        foreach ($data['data'] as $key => $value) {
            $data['data'][$key]['nominal'] = number_format($data['data'][$key]['nominal']);
        }

        if ($member[0]->pilihan_kamar != 'Quad') {
            $lastArr = end($data['data']);
            if ($member[0]->pilihan_kamar == 'Triple') {
                $nominal = $nominal + $paket->harga_triple - $paket->harga;
            }
            if ($member[0]->pilihan_kamar == 'Double') {
                $nominal = $nominal + $paket->harga_double - $paket->harga;
            }
            $keterangan = "Upgrade Kamar " . $member[0]->pilihan_kamar;
            if ($data['data'] == null) {
                $data['data'][0]['id_member'] = $id_member;
                $data['data'][0]['nominal'] = number_format($nominal);
                $data['data'][0]['keterangan'] = $keterangan;
            } else {
                foreach ($data['data'] as $item) {
                    
                    $data['data'][$key1]['id_member'] = $id_member;
                    $data['data'][$key1]['nominal'] = number_format($nominal);
                    $data['data'][$key1]['keterangan'] = $keterangan;
                }
            }
        }
        echo json_encode($data);
    }

    public function total_lebih_bayar() {
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage(null, false, false, true);
        $id_paket = $_GET['id_paket'];
        // if (isset($_GET['id_paket'])) {
        // } else {
        //     $id_paket = $paket[0]->id_paket;
        // }
        
        $selectedPaket = $this->paketUmroh->getPackage($id_paket, false, false, false);

        $nama_paket = $selectedPaket->nama_paket . ' (' . date_format(date_create($selectedPaket->tanggal_berangkat), "d F Y") . ')';

        $this->load->view('staff/lebih_bayar_jamaah', $data = array(
            'paket' => $paket,
            'id_paket' => $id_paket,
            'nama_paket' => $nama_paket
        ));
    }

    public function load_lebih_bayar() {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'program_member';
        // Primary key of table
        $primaryKey = 'id_member';
        $columns = array(
            array('db' => '`pm`.`id_member`', 'dt' => 'id_member', 'field' => 'id_member'),
            array('db' => '`pm`.`id_jamaah`', 'dt' => 'id_jamaah', 'field' => 'id_jamaah'),
            array('db' => '`pm`.`id_paket`', 'dt' => 'id_paket', 'field' => 'id_paket'),
            array('db' => '`pm`.`parent_id`', 'dt' => 'parent_id', 'field' => 'parent_id'),
            array('db' => '`j`.`first_name`', 'dt' => 'first_name', 'field' => 'first_name'),
            array('db' => '`j`.`second_name`', 'dt' => 'second_name', 'field' => 'second_name'),
            array('db' => '`j`.`last_name`', 'dt' => 'last_name', 'field' => 'last_name'),
            array('db' => '`pm`.`lunas`', 'dt' => 'lunas', 'field' => 'lunas'),
            array('db' => '`pm`.`total_harga`', 'dt' => 'total_harga', 'field' => 'total_harga'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $id_paket = $_GET['id_paket'];
        $joinQuery = "FROM `{$table}` AS `pm`"
        . " JOIN `jamaah` AS `j` ON(`j`.`id_jamaah` = `pm`.`id_jamaah`)";
        
        $extraCondition = "`pm`.`id_paket` = $id_paket AND `pm`.`lunas` = 3";
        $groupBy = "CASE WHEN `pm`.`parent_id` IS NOT NULL THEN `pm`.`parent_id` ELSE `pm`.`id_member` END";
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition, $groupBy);
        
        
        foreach ($data['data'] as $key => $item) {
            
            $this->load->model('tarif');
            $pembayaran = $this->tarif->getPembayaran($data['data'][$key]['id_member'], true);
            $total_harga = 0;
            if ($data['data'][$key]['parent_id'] != NULL) {
                $this->load->model('tarif');
                $this->load->model('registrasi');
                $harga_paket = $this->tarif->getHargaPaketParent($data['data'][$key]['parent_id']);
                $total_harga = $harga_paket->total_harga;
            } 
            else {
                $total_harga = $data['data'][$key]['total_harga'];
            }

            $lebih_bayar = $pembayaran['totalBayar'] - $total_harga;
            $data['data'][$key]['lebih_bayar'] = number_format($lebih_bayar);
        }


        echo json_encode($data);
    }

    public function belum_dp() {
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage(null, false, false, true);
        $id_paket = $_GET['id_paket'];
        // if (isset($_GET['id_paket'])) {
        // } else {
        //     $id_paket = $paket[0]->id_paket;
        // }
        
        $selectedPaket = $this->paketUmroh->getPackage($id_paket, false, false, false);

        $nama_paket = $selectedPaket->nama_paket . ' (' . date_format(date_create($selectedPaket->tanggal_berangkat), "d F Y") . ')';

        $this->load->view('staff/list_belum_dp', $data = array(
            'paket' => $paket,
            'id_paket' => $id_paket,
            'nama_paket' => $nama_paket
        ));
    }

    public function load_belum_dp() {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'program_member';
        // Primary key of table
        $primaryKey = 'id_member';
        $columns = array(
            array('db' => '`pm`.`id_member`', 'dt' => 'id_member', 'field' => 'id_member'),
            array('db' => '`pm`.`id_jamaah`', 'dt' => 'id_jamaah', 'field' => 'id_jamaah'),
            array('db' => '`pm`.`id_paket`', 'dt' => 'id_paket', 'field' => 'id_paket'),
            array('db' => '`pm`.`id_agen`', 'dt' => 'id_agen', 'field' => 'id_agen'),
            array('db' => '`pm`.`parent_id`', 'dt' => 'parent_id', 'field' => 'parent_id'),
            array('db' => '`j`.`first_name`', 'dt' => 'first_name', 'field' => 'first_name'),
            array('db' => '`j`.`second_name`', 'dt' => 'second_name', 'field' => 'second_name'),
            array('db' => '`j`.`last_name`', 'dt' => 'last_name', 'field' => 'last_name'),
            array('db' => '`j`.`no_wa`', 'dt' => 'no_wa', 'field' => 'no_wa'),
            array('db' => '`j`.`referensi`', 'dt' => 'referensi', 'field' => 'referensi'),
            array('db' => '`pm`.`lunas`', 'dt' => 'lunas', 'field' => 'lunas'),
            // array('db' => '`a`.`id_agen`', 'dt' => 'id_agen', 'field' => 'id_agen'),
            // array('db' => '`a`.`nama_agen`', 'dt' => 'nama_agen', 'field' => 'nama_agen'),
            // array('db' => '`a`.`no_wa`', 'dt' => 'no_wa_konsultan', 'field' => 'no_wa'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $id_paket = $_GET['id_paket'];
        $joinQuery = "FROM `{$table}` AS `pm`"
        . "JOIN `jamaah` AS `j` ON(`j`.`id_jamaah` = `pm`.`id_jamaah`)";
        // . "LEFT JOIN `agen` AS `a` ON(`a`.`id_agen` = `pm`.`id_agen`)";
        
        $extraCondition = "`pm`.`id_paket` = $id_paket AND `pm`.`lunas` = 0";
        // $groupBy = "CASE WHEN `pm`.`parent_id` IS NOT NULL THEN `pm`.`parent_id` ELSE `pm`.`id_member` END";
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition);
        
        foreach ($data['data'] as $key => $item) {
            $this->load->model('agen');
            $agen = $this->agen->getAgen($item['id_agen']);

            $data['data'][$key]['referensi'] = $item['referensi'];
            if ($item['referensi'] == 'Agen') {
                $data['data'][$key]['referensi'] = $agen[0]->nama_agen;
                $data['data'][$key]['no_wa_agen'] = $agen[0]->no_wa;
            }
            // $data['data'][$key]['no_wa_agen'] = '-';
            // if ($data['data'][$key]['id_agen'] != null) {
            //     $data['data'][$key]['nama_agen'] = $agen[0]->nama_agen;
            // }

            // if ($data['data'][$key]['nama_agen'] == null || $data['data'][$key]['nama_agen'] == '') {
            //     $data['data'][$key]['nama_agen'] = '-';
            // }
            // if ($data['data'][$key]['no_wa'] == null || $data['data'][$key]['no_wa'] == '') {
            //     $data['data'][$key]['no_wa'] = '-';
            // }
            // if ($data['data'][$key]['no_wa_agen'] == null || $data['data'][$key]['no_wa_agen'] == '') {
            //     $data['data'][$key]['no_wa_agen'] = '-';
            // }
        }
        
        echo json_encode($data);
    }

    public function detail_outstanding() {
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage(null, false, false, true);
        $id_paket = $_GET['id_paket'];
        // if (isset($_GET['id_paket'])) {
        // } else {
        //     $id_paket = $paket[0]->id_paket;
        // }
        
        $selectedPaket = $this->paketUmroh->getPackage($id_paket, false, false, false);

        $nama_paket = $selectedPaket->nama_paket . ' (' . date_format(date_create($selectedPaket->tanggal_berangkat), "d F Y") . ')';

        $this->load->view('staff/list_outstanding', $data = array(
            'paket' => $paket,
            'id_paket' => $id_paket,
            'nama_paket' => $nama_paket
        ));
    }

    public function load_outstanding() {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'program_member';
        // Primary key of table
        $primaryKey = 'id_member';
        $columns = array(
            array('db' => '`pm`.`id_member`', 'dt' => 'DT_RowId', 'field' => 'id_member'),
            array('db' => '`pm`.`id_jamaah`', 'dt' => 'id_jamaah', 'field' => 'id_jamaah'),
            array('db' => '`pm`.`id_paket`', 'dt' => 'id_paket', 'field' => 'id_paket'),
            array('db' => '`pm`.`parent_id`', 'dt' => 'parent_id', 'field' => 'parent_id'),
            array('db' => '`pm`.`id_agen`', 'dt' => 'id_agen', 'field' => 'id_agen'),
            array('db' => '`j`.`first_name`', 'dt' => 'first_name', 'field' => 'first_name'),
            array('db' => '`j`.`second_name`', 'dt' => 'second_name', 'field' => 'second_name'),
            array('db' => '`j`.`last_name`', 'dt' => 'last_name', 'field' => 'last_name'),
            array('db' => '`j`.`referensi`', 'dt' => 'referensi', 'field' => 'referensi'),
            array('db' => '`j`.`no_wa`', 'dt' => 'no_wa', 'field' => 'no_wa'),
            array('db' => '`pm`.`lunas`', 'dt' => 'lunas', 'field' => 'lunas'),
            array('db' => '`pm`.`tgl_regist`', 'dt' => 'tgl_regist', 'field' => 'tgl_regist'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $id_paket = $_GET['id_paket'];
        $joinQuery = "FROM `{$table}` AS `pm`"
        . " JOIN `jamaah` AS `j` ON(`j`.`id_jamaah` = `pm`.`id_jamaah`)";
        
        $extraCondition = "(`pm`.`lunas` = 2 OR `pm`.`lunas` = 0)  AND `pm`.`id_paket` = $id_paket";
        $groupBy = "CASE WHEN `pm`.`parent_id` IS NOT NULL THEN `pm`.`parent_id` ELSE `pm`.`id_member` END";
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition, $groupBy);
        
        foreach ($data['data'] as $key => $item) {
            $this->load->model('tarif');
            $tarif = $this->tarif->getRiwayatBayar($data['data'][$key]['DT_RowId']);

            $referensi = $item['referensi'];
            $no_wa = $item['no_wa'];

            if($item['id_agen'] != null || $item['id_agen'] != '') {
                $this->load->model('agen');
                $agen = $this->agen->getAgen($item['id_agen']);
                $referensi = $agen[0]->nama_agen;
                $no_wa = $agen[0]->no_wa;
            }

            $data['data'][$key]['total_pembayaran'] = number_format($tarif['totalBayar']);
            $data['data'][$key]['nilai_outstanding'] = number_format($tarif['sisaTagihan']);
            $data['data'][$key]['referensi'] = $referensi;
            $data['data'][$key]['no_wa'] = $no_wa;

            $tanggal = new DateTime($tarif['tarif']['dataMember'][$item['DT_RowId']]['detailJamaah']->member[0]->paket_info->tanggal_berangkat);
            $tanggal->modify('-45 days');
            $h_45 = $tanggal->format("Y-m-d");
            $this->load->library('calculate');
            $countdown = $this->calculate->dateDiff($h_45, date('Y-m-d'));


            $data['data'][$key]['jatuh_tempo'] = $countdown . " Hari Lagi";
            if (date('Y-m-d') > $h_45) {
                // Menghitung berapa hari sudah lewat
                $tanggal_sekarang = new DateTime(date('Y-m-d'));
                $selisih = $tanggal_sekarang->diff($tanggal)->format("%a");
                
                $data['data'][$key]['jatuh_tempo'] = "Lewat " . $selisih . " Hari";
            }
        }
        echo json_encode($data);
    }

    public function summary_jamaah() {
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage(null, false, false, true);
        if (isset($_GET['id_paket']) && $_GET['id_paket'] != 'all') {
            $id_paket = $_GET['id_paket'];
            $selectedPaket = $this->paketUmroh->getPackage($id_paket, false, false, false);
            $nama_paket = $selectedPaket->nama_paket . ' (' . date_format(date_create($selectedPaket->tanggal_berangkat), "d F Y") . ')';
        } else {
            $id_paket = null;
            $nama_paket = "Semua Paket" ;
        }

        $this->load->view('staff/summary_jamaah_view', $data = array(
            'paket' => $paket,
            'id_paket' => $id_paket,
            'nama_paket' => $nama_paket
        ));
    }

    public function load_jamaah() {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'program_member';
        // Primary key of table
        $primaryKey = 'id_member';
        $columns = array(
            array('db' => '`pm`.`id_member`', 'dt' => 'DT_RowId', 'field' => 'id_member'),
            array('db' => '`pm`.`tgl_regist`', 'dt' => 'tgl_regist', 'field' => 'tgl_regist'),
            array('db' => '`pm`.`id_paket`', 'dt' => 'id_paket', 'field' => 'id_paket'),
            array('db' => '`pm`.`id_agen`', 'dt' => 'id_agen', 'field' => 'id_agen'),
            array('db' => '`pm`.`parent_id`', 'dt' => 'parent_id', 'field' => 'parent_id'),
            array('db' => '`pm`.`pilihan_kamar`', 'dt' => 'pilihan_kamar', 'field' => 'pilihan_kamar'),
            array('db' => '`pm`.`total_harga`', 'dt' => 'total_harga', 'field' => 'total_harga'),
            array('db' => '`pm`.`lunas`', 'dt' => 'lunas', 'field' => 'lunas'),
            array('db' => '`pkt`.`nama_paket`', 'dt' => 'nama_paket', 'field' => 'nama_paket'),
            array('db' => '`pkt`.`harga`', 'dt' => 'harga', 'field' => 'harga'),
            array('db' => '`pkt`.`harga_double`', 'dt' => 'harga_double', 'field' => 'harga_double'),
            array('db' => '`pkt`.`harga_triple`', 'dt' => 'harga_triple', 'field' => 'harga_triple'),
            array('db' => '`pkt`.`jumlah_seat`', 'dt' => 'jumlah_seat', 'field' => 'jumlah_seat'),
            array('db' => '`pkt`.`tanggal_berangkat`', 'dt' => 'tanggal_berangkat', 'field' => 'tanggal_berangkat'),
            array('db' => '`j`.`first_name`', 'dt' => 'first_name', 'field' => 'first_name'),
            array('db' => '`j`.`second_name`', 'dt' => 'second_name', 'field' => 'second_name'),
            array('db' => '`j`.`last_name`', 'dt' => 'last_name', 'field' => 'last_name'),
            array('db' => '`j`.`referensi`', 'dt' => 'referensi', 'field' => 'referensi'),
            array('db' => '`j`.`no_wa`', 'dt' => 'no_wa', 'field' => 'no_wa'),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`second_name`,' ',`j`.`last_name`) AS `whole_name`", 'dt' => "whole_name", 'field' => "whole_name"),
            array('db' => "CONCAT(`j`.`first_name`,' ',`j`.`last_name`) AS `two_name`", 'dt' => "two_name", 'field' => "two_name"),
            // array(
            //     'db' => "date_format(`pkt`.`tanggal_berangkat`, ('%d %M %Y')) as tanggal_berangkat",
            //     'dt' => 'tanggal_berangkat',
            //     'field' => 'tanggal_berangkat',
            // ),
            array('db' => '`a`.`nama_agen`', 'dt' => 'nama_agen', 'field' => 'nama_agen'),

        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $id_paket = $_GET['id_paket'];
        $joinQuery = "FROM `{$table}` AS `pm`"
        . " JOIN `jamaah` AS `j` ON(`j`.`id_jamaah` = `pm`.`id_jamaah`)"
        . " JOIN `paket_umroh` AS `pkt` ON (`pkt`.`id_paket` = `pm`.`id_paket`)"
        . " LEFT JOIN `agen` AS `a` ON (`a`.`id_agen` = `pm`.`id_agen`)";
        
        $extraCondition = $_GET['id_paket'] != 0 ? "`pkt`. `id_paket`=" . $id_paket : "";
        $groupBy = "CASE WHEN `pm`.`parent_id` IS NOT NULL THEN `pm`.`parent_id` ELSE `pm`.`id_member` END";

        if ($_GET['date_start'] != '') {
            $date_start = $_GET['date_start'];
            if ($extraCondition != "") {
                $condition = " AND pkt.tanggal_berangkat >= '$date_start'";
            } else {
                $condition = " pkt.tanggal_berangkat >= '$date_start'";
            }
            $extraCondition = $extraCondition . $condition;
        }
        if ($_GET['date_end'] != '') {
            $date_end = $_GET['date_end'];
            if ($extraCondition != "") {
                $condition = " AND pkt.tanggal_berangkat <= '$date_end'";
            } else {
                $condition = " pkt.tanggal_berangkat <= '$date_end'";
            }
            $extraCondition = $extraCondition . $condition;
        }

        if ($_GET['status_bayar'] != '') {
            $status_bayar = $_GET['status_bayar'];
            if ($extraCondition != "") {
                $condition = " AND pm.lunas = $status_bayar";
            } else {
                $condition = " pm.lunas = $status_bayar";
            }
            $extraCondition = $extraCondition . $condition;
        }

        if ($_GET['status_berangkat'] != '') {
            if ($_GET['status_berangkat'] == 1) {
                if ($extraCondition != "") {
                    $condition = " AND pkt.tanggal_berangkat <= CURDATE()";
                } else {
                    $condition = " pkt.tanggal_berangkat <= CURDATE()";
                }
            } else {
                if ($extraCondition != "") {
                    $condition = " AND pkt.tanggal_berangkat >= CURDATE()";
                } else {
                    $condition = " pkt.tanggal_berangkat >= CURDATE()";
                }
            }
            $extraCondition = $extraCondition . $condition;
        }

        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition, $groupBy);
        $this->load->model('paketUmroh');
        $this->load->model('tarif');
        $this->load->library('login_lib');
        foreach ($data['data'] as $key => $d) {
            $this->load->model('tarif');
            $bayar = $this->tarif->getPembayaran($d['DT_RowId']);
            $total = count($bayar['data']);
            $totalBayar = 0;
            if ($bayar['totalBayar'] != 0) {
                $totalBayar = $bayar['totalBayar'];
            }

            $data['data'][$key]['harga'] = number_format($data['data'][$key]['harga']);
            $data['data'][$key]['jumlah_pembayaran'] = number_format($totalBayar);
            
            $this->load->model('registrasi');
            $groupMembers = $this->registrasi->getGroupMembers($d['parent_id']);
            $count = count($groupMembers);

            $data['data'][$key]['jumlah_keluarga'] = $count;

            $total_tagihan = $d['total_harga'];
            if ($d['parent_id'] != null) {
                $total_tagihan = $total_tagihan * $count;
            }
            // $data['data'][$key]['nilai_outstanding'] = $total_tagihan - $totalBayar;
            // if ($data['data'][$key]['nilai_outstanding'] < 0) {
            //     $data['data'][$key]['nilai_outstanding'] = 0;
            //     $data['data'][$key]['lebih_bayar'] = number_format(abs($total_tagihan - $totalBayar));
            // } else {
            //     $data['data'][$key]['nilai_outstanding'] = number_format($total_tagihan - $totalBayar);
            //     $data['data'][$key]['lebih_bayar'] = 0;
            // }

            $this->load->model('tarif');
            $bayar = $this->tarif->getRiwayatBayar($d['DT_RowId']);

            $data['data'][$key]['nilai_outstanding'] = $bayar['sisaTagihan'];
            if ($data['data'][$key]['nilai_outstanding'] < 0) {
                $data['data'][$key]['nilai_outstanding'] = 0;
                $data['data'][$key]['lebih_bayar'] = number_format(abs($bayar['sisaTagihan']));
            } else {
                $data['data'][$key]['nilai_outstanding'] = number_format($bayar['sisaTagihan']);
                $data['data'][$key]['lebih_bayar'] = 0;
            }
                
            if ($d['lunas'] == 0) {
                $statusBayar = 'Belum DP';
            } elseif ($d['lunas'] == 2) {
                $statusBayar = 'Sudah Cicil';
            } elseif ($d['lunas'] == 1) {
                $statusBayar = 'Sudah Lunas';
            } elseif ($d['lunas'] == 3) {
                $statusBayar = 'Kelebihan Bayar';
            }
            
            $data['data'][$key]['status_pembayaran'] = $statusBayar;

            $this->load->model('paketUmroh');
            $paket = $this->paketUmroh->getPackage($d['id_paket'], false);
            if (date('Y-m-d', strtotime($paket->tanggal_pelunasan)) < date('Y-m-d')) {
                $data['data'][$key]['jatuh_tempo'] = 'Sudah terlewat';
            } else {
                $data['data'][$key]['jatuh_tempo'] = $paket->tanggal_pelunasan;
            }

            end($bayar['data']);
            $lastBayar = key($bayar['data']);

            //sisa_seat status
            if (isset($paket->sisa_seat)) {
                $data['data'][$key]['sisa_seat'] = $paket->sisa_seat;
            } else {
                $data['data'][$key]['sisa_seat'] = 0;
            }
            $data['data'][$key]['terisi'] = $d['jumlah_seat'] - $data['data'][$key]['sisa_seat'];
            //ambil jatuh tempo
            if (date('Y-m-d', strtotime($paket->tanggal_pelunasan)) < date('Y-m-d')) {
                $data['data'][$key]['jatuh_tempo'] = 'Sudah terlewat';
            } else {
                $data['data'][$key]['jatuh_tempo'] = $paket->tanggal_pelunasan;
            }
            if ($d['lunas'] == 1 || $d['lunas'] == 3) {
                // $data['data'][$key]['tanggal_pelunasan'] = $bayar['data'][$total-1]->tanggal_bayar;
                $data['data'][$key]['tanggal_pelunasan'] = $bayar['data'][$lastBayar]->tanggal_bayar;
            } else {
                $data['data'][$key]['tanggal_pelunasan'] = '-';
            }
            
            $data['data'][$key]['countdown'] = floor((strtotime($paket->tanggal_pelunasan) - strtotime(date('Y-m-d'))) / (60 * 60 * 24));

            $payments = $this->tarif->getPaymentsForPackage($d['DT_RowId']);

            if (!$payments) {
                $outstanding = 0;
                $statusBayar = 'kosong';
            } else {
                // menghitung status pembayaran
                if ($payments['sumTotal'] == 0) {
                    $statusBayar = 'Belum DP';
                } elseif ($payments['sumKurang'] > 0) {
                    $statusBayar = 'Sudah Cicil';
                } elseif ($payments['sumKurang'] == 0) {
                    $statusBayar = 'Sudah Lunas';
                } elseif ($payments['sumKurang'] < 0) {
                    $statusBayar = 'Kelebihan Bayar';
                }
            }
            if (isset($paket->publish)) {
                if($paket->publish == 0 ) {
                    $data['data'][$key]['status_group'] = "Unpublish";
                } else {
                    if (isset($paket->sisa_seat)) {
                        $data['data'][$key]['status_group'] = "Belum Penuh";
                    } else {
                        $data['data'][$key]['status_group'] = "Sudah Penuh";
                    }
                }
            } else {
                $data['data'][$key]['status_group'] = "Sudah Berangkat";
            }
            // $data['data'][$key]['jumlah_pembayaran'] = number_format($payments['sumTotal']);
            
            $data['data'][$key]['total_exclude'] = number_format($payments['sumExclude']);
            $data['data'][$key]['excludeNoFormat'] = $payments['sumExclude'];

            $this->db->where('id_paket', $data['data'][$key]['DT_RowId']);
            $member = $this->db->get('program_member')->result();
            $total_tagihan = 0;
            foreach ($member as $value) {
                $total_tagihan += $value->total_harga;
            }

            $this->db->where('id_paket', $data['data'][$key]['DT_RowId']);
            $this->db->where('lunas', 0);
            $member = $this->db->get('program_member')->result();
            $belum_dp = 0;
            foreach ($member as $m) {
                $belum_dp++;
            }

            $data['data'][$key]['belum_dp'] = $belum_dp;
            $data['data'][$key]['total_tagihan'] = number_format($total_tagihan);

            // ambil no wa konsultan
            $this->load->model('agen');
            $agen = $this->agen->getAgen($d['id_agen']);

            if ($d['referensi'] == 'Agen') {
                if (!empty($agen)) {
                    $data['data'][$key]['no_wa'] = $agen[0]->no_wa;
                }
            }


            // warning untuk finance
            if ($data['data'][$key]['countdown'] < 45 && $data['data'][$key]['countdown'] > 0  && $_SESSION['bagian'] == 'Finance' && $data['data'][$key]['status_pembayaran'] != 'Sudah Lunas') {
                $this->alert->set('danger', 'Ada Paket yang hampir jatuh tempo dan Belum Lunas');
            }

            $this->load->model('Whatsapp');
            $log_wa = $this->Whatsapp->getLog($d['DT_RowId']);
            $keterangan = end($log_wa);
            $data['data'][$key]['last_blast'] = '';
            if($log_wa) {
                $data['data'][$key]['last_blast'] = $keterangan->tanggal;
            }
        }
        echo json_encode($data);
    }

    // public function send_message() {
    //     $this->load->model('Whatsapp');
    //     $this->db->where('id_member', $_GET['id']);
    //     $member = $this->db->get('program_member')->row();

    //     if ($member->lunas == 0) {
    //         if ($member->id_agen == null || $member->id_agen == '') {
    //             $result = $this->Whatsapp->sendDpNotice($member->id_member);
    //         } else {
    //             $this->load->model('agen');
    //             $agen = $this->agen->getAgen($member->id_agen);
    //             $result = $this->Whatsapp->sendDpNotice($member->id_member, $agen[0]->no_wa);
    //         }
    //     } else if ($member->lunas == 2) {
    //         if ($member->id_agen == null || $member->id_agen == '') {
    //             $id_secret = md5($member->id_member.'ventourapp');
    //             $link = $member->id_member . "_" . $id_secret;
    //             $result = $this->Whatsapp->sendTagihanPelunasan($member->id_member, $link);
    //         } else {
    //             $this->load->model('agen');
    //             $agen = $this->agen->getAgen($member->id_agen);
    //             $id_secret = md5($member->id_member.'ventourapp');
    //             $link = $member->id_member . "_" . $id_secret;
    //             $result = $this->Whatsapp->sendTagihanPelunasan($member->id_member,$link, $agen[0]->no_wa);
    //         }
    //     } else  {
    //         $result = false;
    //     } 

        
    //     if ($result != true) {
    //         $this->alert->set('danger', 'Gagal mengirim pesan !!');
    //         redirect($_SERVER['HTTP_REFERER']);
    //     }
    //     $this->alert->set('success', 'Pesan berhasil terkirim');
    //     redirect($_SERVER['HTTP_REFERER']);
    // }

    // public function send_jamaah() {
    //     $this->load->model('Whatsapp'); 
    //     $this->db->from('program_member a');
    //     $this->db->join('paket_umroh b', 'b.id_paket = a.id_paket');
    //     if ($_GET['id_paket']) {
    //         $this->db->where('a.id_paket', $_GET['id_paket']);
    //     }
    //     if (isset($_GET['statusBayar'])) {
    //         if ($_GET['statusBayar']) {
    //             $this->db->where('a.lunas', $_GET['statusBayar']);
    //         }
    //     }
    //     if (isset($_GET['dateStart'])) {
    //         if ($_GET['dateStart']) {
    //             $this->db->where('b.tanggal_berangkat >=', $_GET['dateStart']);
    //         }
    //     }
    //     if (isset($_GET['dateEnd'])) {
    //         if ($_GET['dateEnd']) {
    //             $this->db->where('b.tanggal_berangkat <=', $_GET['dateEnd']);
    //         }   
    //     }

    //     $this->db->select("CASE WHEN a.parent_id IS NOT NULL THEN a.parent_id ELSE a.id_member END as group_column", FALSE);
    //     $this->db->group_by('group_column');

     
    //     $member = $this->db->get()->result();

    //     foreach ($member as $item) {
    //         $this->load->model('registrasi');
    //         $this->load->model('paketUmroh');
    //         $m = $this->registrasi->getMember($item->group_column);
    //         $j = $this->registrasi->getJamaah($m[0]->id_jamaah);
    //         $p = $this->paketUmroh->getPackage($m[0]->id_paket);
    //         if ($p) {
    //             if ($j->no_wa != null) {
    //                 if (isset($_GET['lunas'])) {
    //                     $id_secret = md5($m[0]->id_member.'ventourapp');
    //                     $link = $m[0]->id_member . "_" . $id_secret;
    //                     $this->Whatsapp->sendTagihanPelunasan($m[0]->id_member, $link);
    //                     $isSend = true;
    //                 } else {
    //                     if ($m[0]->lunas == 0) {
    //                         $this->Whatsapp->sendDpNotice($m[0]->id_member);
    //                         $isSend = true;
    //                     } elseif ($m[0]->lunas == 2) {
    //                         $id_secret = md5($m[0]->id_member.'ventourapp');
    //                         $link = $m[0]->id_member . "_" . $id_secret;
    //                         $this->Whatsapp->sendTagihanPelunasan($m[0]->id_member, $link);
    //                         $isSend = true;
    //                     } 
    //                 }
    //             }
    //         } else {
    //             return false;
    //         }
    //     }

    //     if ($_GET['input'] == 1){
    //         redirect($_SERVER['HTTP_REFERER']);
    //     }
    //     if ($isSend == TRUE) {
    //         return true;    
    //     } else {
    //         return false;
    //     }
    // }

    public function log_wa() {
        $id_member = $_GET['id'];
        $this->load->model('registrasi');
        $jamaah = $this->registrasi->getJamaah(null, null, $id_member);
        unset($jamaah->member);
        $jamaah_name = $jamaah->first_name . $jamaah->second_name . $jamaah->last_name;
        $data = array(
            'id_member' => $id_member,
            'jamaah_name' => $jamaah_name
            // 'nama_paket' => $paket->nama_paket,
        );
        $this->load->view('staff/wa_log_finance', $data);
    }

    public function load_wa_log() {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'wa_log';
        // Primary key of table
        $primaryKey = 'id_wa_log';
        $columns = array(
            array('db' => '`wl`.`id_wa_log`', 'dt' => 'DT_RowId', 'field' => 'id_wa_log'),
            array('db' => '`wl`.`id_member`', 'dt' => 'id_member', 'field' => 'id_member'),
            array('db' => '`wl`.`id_staff`', 'dt' => 'id_staff', 'field' => 'id_staff'),
            array('db' => '`wl`.`keterangan`', 'dt' => 'keterangan', 'field' => 'keterangan'),
            array('db' => '`wl`.`tanggal`', 'dt' => 'tanggal', 'field' => 'tanggal'),
            array('db' => '`j`.`first_name`', 'dt' => 'first_name', 'field' => 'first_name'),
            array('db' => '`j`.`second_name`', 'dt' => 'second_name', 'field' => 'second_name'),
            array('db' => '`j`.`last_name`', 'dt' => 'last_name', 'field' => 'last_name'),
            array('db' => '`s`.`nama`', 'dt' => 'nama', 'field' => 'nama'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $id_member = $_GET['id_member'];
        $joinQuery = "FROM `{$table}` AS `wl`"
        . " JOIN `program_member` AS `pm` ON(`pm`.`id_member` = `wl`.`id_member`)"
        . " JOIN `jamaah` AS `j` ON(`j`.`id_jamaah` = `pm`.`id_jamaah`)"
        . " LEFT JOIN `staff` AS `s` ON (`s`.`id_staff` = `wl`.`id_staff`)";
        
        $extraCondition = "`wl`.`id_member`=$id_member";
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition);
        // echo '<pre>';
        // print_r($data['data']);
        // exit();

        echo json_encode($data);
        
    }

    public function detail_terisi()
    {
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage(null, false, false, true);
        if (isset($_GET['id_paket'])) {
            $id_paket = $_GET['id_paket'];
        } else {
            $id_paket = $paket[0]->id_paket;
        }

        if (isset($_GET['klasifikasi'])) {
            $klasifikasi = $_GET['klasifikasi'];
        } else {
            $klasifikasi = null;
        }
        $selectedPaket = $this->paketUmroh->getPackage($id_paket, false, false, false);

        $nama_paket = $selectedPaket->nama_paket . ' (' . date_format(date_create($selectedPaket->tanggal_berangkat), "d F Y") . ')';


        $this->load->view('staff/detail_terisi_finance', $data = array(
            'paket' => $paket,
            'id_paket' => $id_paket,
            'nama_paket' => $nama_paket,
            'klasifikasi' => $klasifikasi
        ));
    }
}