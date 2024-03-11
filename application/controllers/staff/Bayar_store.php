<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Bayar_store extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }
        if (!($_SESSION['bagian'] == 'Store Admin' || $_SESSION['bagian'] == 'Master Admin')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
    }

    public function index() {
        $this->load->view('staff/list_bayar_store');
    }

    public function load_order()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'store_orders';
        // Primary key of table
        $primaryKey = 'order_id';

        $columns = array(
            array('db' => '`s`.`order_id`', 'dt' => 'DT_RowId', 'field' => 'order_id'),
            array('db' => '`s`.`customer_id`', 'dt' => 'customer_id', 'field' => 'customer_id'),
            array('db' => '`s`.`order_date`', 'dt' => 'order_date', 'field' => 'order_date'),
            array('db' => '`s`.`discount_amount`', 'dt' => 'discount_amount', 'field' => 'discount_amount'),
            array('db' => '`s`.`total_amount`', 'dt' => 'total_amount', 'field' => 'total_amount'),
            array('db' => '`s`.`notes`', 'dt' => 'notes', 'field' => 'notes'),
            array('db' => '`s`.`lunas`', 'dt' => 'lunas', 'field' => 'lunas'),
            array('db' => '`s`.`status_pesanan`', 'dt' => 'status_pesanan', 'field' => 'status_pesanan'),
            array('db' => '`s`.`shipping_zip_code`', 'dt' => 'shipping_zip_code', 'field' => 'shipping_zip_code'),
            array('db' => '`s`.`shipping_kecamatan`', 'dt' => 'shipping_kecamatan', 'field' => 'shipping_kecamatan'),
            array('db' => '`s`.`shipping_kabupaten_kota`', 'dt' => 'shipping_kabupaten_kota', 'field' => 'shipping_kabupaten_kota'),
            array('db' => '`s`.`shipping_provinsi`', 'dt' => 'shipping_provinsi', 'field' => 'shipping_provinsi'),
            array('db' => '`s`.`shipping_address`', 'dt' => 'shipping_address', 'field' => 'shipping_address'),
            array('db' => '`sc`.`id_user`', 'dt' => 'id_user', 'field' => 'id_user'),
            array('db' => '`sc`.`jenis`', 'dt' => 'jenis', 'field' => 'jenis'),

        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $joinQuery = "FROM `{$table}` AS `s`"
            . " JOIN `store_customer` AS `sc` ON (`sc`.`id_customer` = `s`.`customer_id`)";
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery);
        $this->load->model('registrasi');
        $this->load->model('agen');
        $this->load->model('tarif');
        $this->load->model('store');
        foreach($data['data'] as $key => $d) {
            $data['data'][$key]['DT_RowAttr'] = array(
                'id_user' => $d['id_user'],
                'customer_id' => $d['customer_id']
            );

            if ($d['jenis'] == "j") {
                $jamaah = $this->registrasi->getJamaah(null, null, $d['id_user']);
                $nama = implode(' ', array_filter([$jamaah->first_name, $jamaah->second_name, $jamaah->last_name]));
            } else {
                $agen = $this->agen->getAgen($d['id_user']);
                $nama = $agen[0]->nama_agen;
            }

            $data['data'][$key]['nama'] = $nama;

            $status = $this->store->checkPesanan($d['status_pesanan']);
            $data['data'][$key]['status'] = $status;

            $alamat = $d['shipping_address'] . ", Kec." . $d['shipping_kecamatan'] . ", " . $d['shipping_kabupaten_kota'] . ", " . $d['shipping_provinsi']. " " . $d['shipping_zip_code'] ;
            $data['data'][$key]['alamat'] = $alamat ;

            $this->tarif->cekBayarStore($d['DT_RowId']);
        }
        // //prepare extra data
        // $this->load->model('registrasi');
        // $groupCtr = 0;
        // $groupArr = array();
        // foreach ($data['data'] as $key => $d) {
        //     $data['data'][$key]['DT_RowAttr'] = array(
        //         'id_jamaah' => $d['id_jamaah']
        //     );

        //     //determine WG status
        //     $wg = $this->registrasi->getWG($d['DT_RowId']);
        //     $data['data'][$key]['wg'] = $wg;

        //     //set group class
        //     $parent_id = $d['parent_id'];
        //     if (!empty($parent_id)) {
        //         //check in array
        //         if (!isset($groupArr[$parent_id])) {
        //             $groupCtr = $groupCtr + 1;
        //             $groupArr[$parent_id] = $groupCtr;
        //         }
        //         $data['data'][$key]['DT_RowClass'] = 'group-color-' . $groupArr[$parent_id];
        //     }

        //     //format money
        //     if (!empty($d['total_harga'])) {
        //         $data['data'][$key]['total_harga'] = 'Rp. ' . number_format($d['total_harga'], 0, ',', '.') . ',-';
        //     }

        //     //format lunas
        //     if ($d['lunas'] == 1) {
        //         $lns = 'Lunas';
        //     } else if ($d['lunas'] == 2) {
        //         $lns = 'Sudah Cicil';
        //     } else if ($d['lunas'] == 3) {
        //         $lns = 'Kelebihan Bayar';
        //     } else {
        //         $lns = 'Belum Bayar';
        //     }
        //     $data['data'][$key]['lunas'] = $lns;
        // }
        echo json_encode($data);
    }

    public function verifikasi()
    {
        $this->load->view('staff/list_verifikasi_store');
    }

    public function load_verifikasi()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'pembayaran';
        // Primary key of table
        $primaryKey = 'id_member';

        $columns = array(
            array('db' => '`byr`.`id_member`', 'dt' => 'DT_RowId', 'field' => 'id_member'),
            array('db' => '`byr`.`id_pembayaran`', 'dt' => 'id_pembayaran', 'field' => 'id_pembayaran'),
            array('db' => '`byr`.`tanggal_bayar`', 'dt' => 'tanggal_bayar', 'field' => 'tanggal_bayar'),
            array('db' => '`byr`.`verified`', 'dt' => 'verified', 'field' => 'verified'),
            array('db' => '`byr`.`cara_pembayaran`', 'dt' => 'cara_pembayaran', 'field' => 'cara_pembayaran'),
            array('db' => '`byr`.`keterangan`', 'dt' => 'keterangan', 'field' => 'keterangan'),
            array('db' => '`so`.`customer_id`', 'dt' => 'customer_id', 'field' => 'customer_id'),
            array('db' => '`sc`.`id_user`', 'dt' => 'id_user', 'field' => 'id_user'),
            array('db' => '`sc`.`jenis`', 'dt' => 'jenis', 'field' => 'jenis'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $joinQuery = "FROM `{$table}` AS `byr`"
            . "JOIN `store_orders` AS `so` ON (`byr`.`id_member` = `so`.`order_id`)"
            . "JOIN `store_customer` AS `sc` ON (`sc`.`id_customer` = `so`.`customer_id`)";
        $extraCondition = "`byr`.`jenis` = 'store'";
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition);
        //prepare extra data
        $this->load->model('registrasi');
        $this->load->model('tarif');
        $groupCtr = 0;
        $groupArr = array();
        foreach ($data['data'] as $key => $d) {
            if ($d['jenis'] == "j") {
                $jamaah = $this->registrasi->getJamaah(null, null, $d['id_user']);
                $id_member = $jamaah->member[0]->id_member;
                $nama = implode(' ', array_filter([$jamaah->first_name, $jamaah->second_name, $jamaah->last_name]));
                $lihat = base_url() . "staff/info/detail_jamaah?id=$jamaah->id_jamaah&id_member=$id_member";
            } else {
                $agen = $this->agen->getAgen($d['id_user']);
                $nama = $agen[0]->nama_agen;
                $id_member = $agen[0]->id_agen;
                $lihat = base_url(). "staff/keola_agen/profile?id=". $id_member;
            }
            
            $data['data'][$key]['DT_RowAttr'] = array(
                'lihat' => $lihat,
                'customer_id' => $d['customer_id'],
                'id_pembayaran' => $d['id_pembayaran'],
                'verified' => $d['verified'],
                'jenis' => $d['jenis'],
                'id_user' => $d['id_user'],
            );
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

            $data['data'][$key]['nama'] = $nama;
        }
        echo json_encode($data);
    }

    public function bayar_manual() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('ido', 'ido', 'trim|required|integer');
        $this->form_validation->set_rules('idc', 'idc', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->model('store');
        $this->load->model('registrasi');
        $this->load->model('agen');
        $cust = $this->store->getCustomer($_GET['idc']);
        $cust = $cust[0];
        if ($cust->jenis == "j") {
            $jamaah = $this->registrasi->getJamaah(null, null, $cust->id_user);
            $nama = implode(' ', array_filter([$jamaah->first_name, $jamaah->second_name, $jamaah->last_name]));
        } else {
            $agen = $this->agen->getAgen($cust->id_user);
            $nama = $agen[0]->nama_agen;
        }

        $orders = $this->store->getStoreOrders($_GET['ido']);
        $data = [
            "nama" => $nama,
            "order" => $orders[0]
        ];

        $this->load->view('staff/input_bayar_store', $data);
    }

    public function proses_bayar()
    {
        // echo '<pre>';
        // print_r($_FILES);
        // exit();
        $this->form_validation->set_rules('order_id', 'id order', 'trim|required|integer');
        // $this->form_validation->set_rules('customer_id', 'id customer', 'trim|required|integer');
        $this->form_validation->set_rules('tanggal_bayar', 'tanggal_bayar', 'required');
        $this->form_validation->set_rules('jumlah_bayar', 'jumlah_bayar', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $data = $_POST;
        $data['tanggal_bayar'] = date('Y-m-d H:i:s', strtotime($_POST['tanggal_bayar']));
        $data['jumlah_bayar'] = str_replace(",", "", $data['jumlah_bayar']);
        if (!empty($_FILES['scan_bayar']['name'])) {
            $data['files']['scan_bayar'] = $_FILES['scan_bayar'];
        }

        $this->load->model('tarif');
        $this->tarif->setPembayaran($data, 'store');

        redirect(base_url() . 'staff/bayar_store');
    }

    public function verifikasi_data()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('idu', 'idu', 'trim|required|integer');
        $this->form_validation->set_rules('idb', 'idb', 'trim|required|integer');
        $this->form_validation->set_rules('jenis', 'jenis', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/bayar_store/verifikasi');
        }

        $refund = null;
        if (isset($_GET['refund'])) {
            $refund = $_GET['refund'];
        }

        if ($_GET['jenis'] == "j") {
            $this->load->model('registrasi');
            $jamaah = $this->registrasi->getJamaah(null, null, $_GET['idu']);
            $nama = implode(' ', array_filter([$jamaah->first_name, $jamaah->second_name, $jamaah->last_name]));
        } else {
            $this->load->model('agen');
            $agen = $this->agen->getAgen($_GET['idu']);
            $nama = $agen[0]->nama_agen;
        }

        $this->load->model('tarif');
        $dataBayar = $this->tarif->getPembayaranStore($_GET['io'], false, $_GET['idb']);
        if (empty($dataBayar['data'])) {
            $this->alert->set('danger', 'Data Tidak Ditemukan');
            redirect(base_url() . 'staff/bayar_store/verifikasi');
        }
        $data = array(
            'refund' => $refund,
            'nama' => $nama,
            'dataBayar' => $dataBayar
        );
        $this->load->view('staff/verifikasi_store_view', $data);
    }

    public function proses_verifikasi()
    {
        $this->form_validation->set_rules('id_pembayaran', 'id_pembayaran', 'trim|required|integer');
        $this->form_validation->set_rules('verified', 'verified', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/bayar_store/verifikasi');
        }
        $this->load->model('tarif');

        $ver = $this->tarif->verifikasi($_POST['id_pembayaran'], $_POST['verified']);
        if (!$ver) {
            $this->alert->set('danger', 'Data Pembayaran Tidak Ada');
        } else {
            $this->alert->set('success', 'Data Pembayaran Berhasil diverifikasi');
        }
        
        $this->load->model('tarif');
        $this->tarif->cekBayarStore($_GET['order_id']);
        redirect(base_url() . 'staff/bayar_store/verifikasi');
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
        redirect(base_url() . 'staff/bayar_store/verifikasi');
    }

    public function set_status() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('io', 'io', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/bayar_store');
        }

        $this->load->model('store');
        $order = $this->store->getStoreOrders($_GET['io']);
        if ($order == null) {
            $this->alert->set('danger', 'Pesanan Tidak Ditemukan');
            redirect(base_url() . 'staff/bayar_store');
        }
        $order = $order[0];

        $customer = $this->store->getCustomer($order->customer_id);
        if ($customer == null) {
            $this->alert->set('danger', 'Pesanan Tidak Ditemukan');
            redirect(base_url() . 'staff/bayar_store');
        }
        $customer = $customer[0];

        if ($customer->jenis == "j") {
            $this->load->model('registrasi');
            $jamaah = $this->registrasi->getJamaah(null, null, $customer->id_user);
            $nama = implode(' ', array_filter([$jamaah->first_name, $jamaah->second_name, $jamaah->last_name]));
        } else {
            $this->load->model('agen');
            $agen = $this->agen->getAgen($customer->id_user);
            $nama = $agen[0]->nama_agen;
        }

        $list_items = $this->store->getStoreOrdersItems(null, $order->order_id);
        $alamat = $order->shipping_address . ", Kec." . $order->shipping_kecamatan . ", " . $order->shipping_kabupaten_kota . ", " . $order->shipping_provinsi. " " . $order->shipping_zip_code ;

        $data = array(
            "nama" => $nama,
            "order" => $order,
            "list_items" => $list_items,
            "alamat" => $alamat
        );
        $this->load->view('staff/set_status_store', $data);
        
    }

    public function proses_set_status() {
        $this->form_validation->set_rules('order_id', 'ID', 'trim|required|integer');
        $this->form_validation->set_rules('status_pesanan', 'Status Pesanan', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->load->model('store');
        $updateStatus = $this->store->updateStatusPesanan($_POST['order_id'], $_POST['status_pesanan']);
        if (!$updateStatus) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        } 
        $checkStatus = $this->store->checkOrderTracking($_POST['order_id'], $_POST['status_pesanan']);
        if (!$checkStatus) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        } 

        $this->alert->set('success', 'Status berhasil diubah');
        redirect(base_url() . 'staff/bayar_store');
    }
}