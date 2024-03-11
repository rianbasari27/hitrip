<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Online_store extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //check if logged in redirect to user page
        $this->load->model('customer');
        $this->load->model('store');
        if (!$this->customer->is_user_logged_in()) {
            redirect(base_url() . 'jamaah/home');
        }
    }

    public function index()
    {
        $this->load->model('store');
        $this->load->model('galeriJamaah');
        $products = $this->store->getProduct();

        $data = [
            'id_user' => $_SESSION['id_member'],
            'jenis' => "j"
        ];
        $c = $this->store->checkCustomer($data);
        $newArrival = $this->store->getProduct(null, 3);
        $productPromo = $this->store->getProduct(null, null, true);
        // echo '<pre>';
        // print_r($c);
        // exit();
        $bannerPromo = $this->galeriJamaah->getStoreBanner();
        $cartItems = $this->store->getCart($c->id_customer);
        $countCart = 0;
        foreach ($cartItems as $ci) {
            $countCart = $countCart + $ci->qty;
        }
        $category = $this->store->getCategory();
        // echo '<pre>';
        // print_r($countCart);
        // exit();

        $data = [
            'products' => $products,
            'countCart' => $countCart,
            'id_customer' => $_SESSION['id_member'],
            'jenis' => "j",
            'cart' => $cartItems,
            'newArrival' => $newArrival,
            'productPromo' => $productPromo,
            'bannerPromo' => $bannerPromo,
            'listCategory' => $category
        ];
        $this->load->view('jamaahv2/homepage_store', $data);
    }

    public function products() {
        $this->load->model('store');
        $products = $this->store->getProduct();
        $category = $this->store->getCategory();
        $data = [
            'id_user' => $_SESSION['id_member'],
            'jenis' => "j"
        ];
        $c = $this->store->checkCustomer($data);
        $cartItems = $this->store->getCart($c->id_customer);
        $countCart = 0;
        foreach ($cartItems as $ci) {
            $countCart = $countCart + $ci->qty;
        }

        $data = [
            'products' => $products,
            'countCart' => $countCart,
            'listCategory' => $category
        ];
        $this->load->view('jamaahv2/list_product_view', $data);
    }

    public function single_product()
    {
        $this->load->model('store');
        $product = $this->store->getProduct($_GET['id']);
        $otherProduct = $this->store->getProduct();
        foreach ($otherProduct as $key => $op) {
            if ($op->product_id == $_GET['id']) {
                unset($otherProduct[$key]);
            }
        }
        $cusArr = [
            'id_user' => $_SESSION['id_member'],
            'jenis' => 'j',
        ];
        $customer = $this->store->checkCustomer($cusArr);
        $cartItems = $this->store->getCart($customer->id_customer);
        $countCart = 0;
        foreach ($cartItems as $c) {
            $countCart = $countCart + $c->qty;
        }
        $data = [
            'product' => $product[0],
            'customer' => $customer,
            'countCart' => $countCart,
            'other' => $otherProduct
        ];
        $this->load->view('jamaahv2/single_product_view', $data);
    }

    public function add_cart()
    {

        $data = json_decode(file_get_contents("php://input"), true);
        if ($data === null) {
            http_response_code(400); // Bad request
            echo json_encode(array("message" => "Invalid JSON data"));
            exit;
        }

        $this->load->model('store');

        // store_cart
        $dataCart = [
            "id_customer" => $data['id_customer'],
            'id_product' => $data['id_product'],
            'qty' => $data['qty']
        ];
        $cart = $this->store->checkCart($dataCart);
        if ($cart) {
            echo $cart;
        } else {
            echo "gagal";
        }
    }

    public function getCustomerCart()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if ($data === null) {
            http_response_code(400); // Bad request
            echo json_encode(array("message" => "Invalid JSON data"));
            exit;
        }

        $this->load->model('store');
        $isCustomer = $this->store->checkCustomer($data);
        $result = $this->store->getCart($isCustomer->id_customer);
        echo json_encode($result);
    }

    public function hapus_cart()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if ($data === null) {
            http_response_code(400); // Bad request
            echo json_encode(array("message" => "Invalid JSON data"));
            exit;
        }

        $this->load->model('store');
        $delete = $this->store->deleteCart($data['id_customer'], $data['id_product']);
        echo $delete;
    }

    public function cart_to_checkout()
    {
        $data = $_POST;
        $totalItem = count($data['id_product']);
        for ($i = 0; $i < $totalItem; $i++) {

            $this->load->model('store');
            $this->store->updateCart($data['id_customer'][$i], $data['id_product'][$i], $data['qty'][$i]);
        }
        redirect(base_url() . 'jamaah/online_store/checkout');
    }

    public function checkout()
    {
        $this->load->model('store');
        $customer = $this->store->getCustomer(null, $_SESSION['id_member']);
        $cartItems = $this->store->getCart($customer[0]->id_customer);
        $countCart = 0;
        foreach ($cartItems as $c) {
            $countCart = $countCart + $c->qty;
        }
        $totalItems = count($cartItems);

        $totalHarga = 0;
        $totalDiscount = 0;
        foreach ($cartItems as $key => $c) {
            $totalHarga += $c->priceAmount;
            $totalDiscount += $cartItems[$key]->product[0]->discount_amount;
        }
        // echo '<pre>';
        // print_r($totalDiscount);
        // exit();
        $data = [
            'cart' => $cartItems,
            'totalItems' => $totalItems,
            'countCart' => $countCart,
            'totalHarga' => $totalHarga,
            'totalDiscount' => $totalDiscount
        ];
        $this->load->view('jamaahv2/checkout_view', $data);
    }

    public function getKota()
    {
        $term = $this->input->get('term');
        $this->load->model('region');
        $kota = $this->region->getRegionAutoComplete($term);
        echo json_encode($kota);
    }

    public function getRegencies()
    {
        $provId = $this->input->get('provId');
        $this->load->model('region');
        $regency = $this->region->getRegency(null, $provId);
        echo json_encode($regency);
    }

    public function getDistricts()
    {
        $regId = $this->input->get('regId');
        $this->load->model('region');
        $districts = $this->region->getDistrict(null, $regId);
        echo json_encode($districts);
    }

    public function proses_checkout()
    {
        $this->form_validation->set_rules('customer_id', 'customer id', 'trim|required');
        $this->form_validation->set_rules('shipping_provinsi', 'Provinsi', 'trim|required');
        $this->form_validation->set_rules('shipping_kabupaten_kota', 'Kabupaten/Kota', 'trim|required');
        $this->form_validation->set_rules('shipping_kecamatan', 'Kecamatan', 'trim|required');
        $this->form_validation->set_rules('shipping_address', 'Alamat lengkap', 'trim|required');
        $this->form_validation->set_rules('total_amount', 'Total Harga', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->alert->setJamaah('red', 'Checkout Gagal!', validation_errors('<li>', '</li>'));
            redirect($_SERVER['HTTP_REFERER']);
        }

        // check stok
        $this->load->model('store');
        foreach ($_POST['qty'] as $key => $q) {
            $checkStock = $this->store->checkStok($_POST['customer_id'], $_POST['id_product'][$key], $q);
            if ($checkStock['type'] == 'red') {
                $this->alert->setJamaah("$checkStock[type]", "$checkStock[title]", "$checkStock[msg]");
                redirect($_SERVER['HTTP_REFERER']);
            }
        }

        $idOrder = $this->store->addStoreOrders($_POST);
        if (!$idOrder) {
            $this->alert->setJamaah('red', 'Checkout Gagal!', 'Silahkan coba lagi beberapa saat');
            redirect($_SERVER['HTTP_REFERER']);
        }

        //create VA BSI
        $this->load->model('va_model');
        $this->va_model->createVAOpen($idOrder, "store");
        if (!$idOrder) {
            $this->alert->setJamaah('red', 'Ups...', $_SESSION['alert_message']);
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->alert->setJamaah('green', 'Berhasil', "Checkout Berhasil, silahkan cek di menu blabla");
        redirect(base_url() . 'jamaah/online_store/payment_method?id=' . $idOrder);
    }

    public function payment_method()
    {
        $cust = [
            'id_user' => $_SESSION['id_member'],
            'jenis' => "j"
        ];
        $c = $this->store->checkCustomer($cust);
        $cart = $this->store->getCart($c->id_customer);
        $countCart = count($cart);
        $data = [
            "id_order" => $_GET['id'],
            "countCart" => $countCart,
        ];
        $this->load->view('jamaahv2/store_payment_view', $data);
    }

    public function bayar_bsi() {
        $this->load->model('tarif');
        $this->load->model('store');
        $tagihan = $this->tarif->getSisaPembayaranStore($_GET['id']);
        $order = $this->store->getStoreOrders($_GET['id']);
        $tarif['tagihan'] = $tagihan;
        $tarif['tagihanPlusAdmin'] = $tagihan + $this->config->item('bsi_admin_fee');
        $tarif['vaOpenAdminFee'] = $this->config->item('bsi_admin_fee');
        $tarif['nomorVAOpen'] = $order[0]->va_open;
        $tarif['nomorVAOpenLuarBSI'] = $this->config->item('va_general_code') . $this->config->item('ventour_institution_code') . $order[0]->va_open;

        $cart = $this->store->getCart($order[0]->customer_id);
        $countCart = count($cart);
        $data = [
            'tarif' => $tarif,
            'order' => $order[0],
            "countCart" => $countCart,
        ];
        $this->load->view('jamaahv2/bayar_bsi_store', $data);
    }

    public function proses_duitku()
    {
        $this->load->model('store');
        $order = $this->store->getStoreOrders($_GET['ido']);
        $order = $order[0];
        $this->load->model('duitku');
        //get pending transaction
        $invoice = $this->duitku->getPendingTransactionAgen($_GET['ido']);
        if (empty($invoice)) {
            // if no pending transaction, create new payment invoice
            $invoice = $this->duitku->createInvoice($_GET['ido'], $order->total_amount, "no", 'store', $_GET['metode']);
        } else {
            $invoice = $invoice[0];
        }

        $this->session->set_userdata(array(
            'id_order' => $_GET['ido']
        ));
        redirect($invoice['paymentUrl']);
    }

    public function orders() {
        $this->load->model('store');
        $customer = $this->store->getCustomer(null, $_SESSION['id_member'], 'j');
        $ordersProcess = $this->store->getStoreOrders(null, $customer[0]->id_customer);    
        // echo '<pre>';
        // print_r($ordersProcess);
        // exit();
        $ordersComplete = $this->store->getStoreOrders(null, $customer[0]->id_customer);    

        foreach ($ordersProcess as $key => $o) {
            $status = $this->store->checkPesanan($o->status_pesanan);
            $ordersProcess[$key]->status = $status;
            if ($o->status_pesanan == 3) {
                unset($ordersProcess[$key]);
            }
        }

        foreach ($ordersComplete as $key => $o) {
            $status = $this->store->checkPesanan($o->status_pesanan);
            $ordersComplete[$key]->status = $status;
            if ($o->status_pesanan != 3) {
                unset($ordersComplete[$key]);
            }
        }

        $cartItems = $this->store->getCart($customer[0]->id_customer);
        $countCart = 0;
        foreach ($cartItems as $c) {
            $countCart = $countCart + $c->qty;
        }
        $data = [
            'ordersProcess' => $ordersProcess,
            'countCart' => $countCart,
            'ordersComplete' => $ordersComplete,
        ];
        $this->load->view('jamaahv2/order_view', $data);
    }

    public function orders_tracking() {
        $this->load->model('store');
        $orders = $this->store->getStoreOrders($_GET['ido']);
        $tracking = $this->store->getOrderTracking($_GET['ido']);
        foreach ($tracking as $key => $t) {
            if ($t->status == 0) {
                $tracking[$key]->icon = 'fa-hourglass';
            } elseif ($t->status == 1) {
                $tracking[$key]->icon = 'fa-boxes-packing';
            } elseif ($t->status == 2) {
                $tracking[$key]->icon = 'fa-truck-fast';
            } else {
                $tracking[$key]->icon = 'fa-circle-check';
            }
            
        }
        $id_pesanan = 'VSW' . $orders[0]->order_id . $orders[0]->customer_id . $orders[0]->va_open;
        // echo '<pre>';
        // print_r($orders);
        // exit();

        $cartItems = $this->store->getCart($orders[0]->customer_id);
        $countCart = 0;
        foreach ($cartItems as $ci) {
            $countCart = $countCart + $ci->qty;
        }
        $data = [
            'orders' => $orders,
            'countCart' => $countCart,
            'tracking' => $tracking,
            'id_pesanan' => $id_pesanan,
        ];
        $this->load->view('jamaahv2/order_tracking_view', $data);
    }
} 
