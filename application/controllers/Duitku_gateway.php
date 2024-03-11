<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Duitku_gateway extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // $this->json = json_decode($request, true);
    }

    public function callback()
    {
        $this->load->model('duitku');
        $request = file_get_contents('php://input');
        $this->duitku->debugLog($request);

        $apiKey = $this->config->item('duitku_api_key'); // API key anda
        $merchantCode = isset($_POST['merchantCode']) ? $_POST['merchantCode'] : null;
        $amount = isset($_POST['amount']) ? $_POST['amount'] : null;
        $merchantOrderId = isset($_POST['merchantOrderId']) ? $_POST['merchantOrderId'] : null;
        $productDetail = isset($_POST['productDetail']) ? $_POST['productDetail'] : null;
        $additionalParam = isset($_POST['additionalParam']) ? $_POST['additionalParam'] : null;
        $paymentCode = isset($_POST['paymentCode']) ? $_POST['paymentCode'] : null;
        $resultCode = isset($_POST['resultCode']) ? $_POST['resultCode'] : null;
        $merchantUserId = isset($_POST['merchantUserId']) ? $_POST['merchantUserId'] : null;
        $reference = isset($_POST['reference']) ? $_POST['reference'] : null;
        $signature = isset($_POST['signature']) ? $_POST['signature'] : null;
        $publisherOrderId = isset($_POST['publisherOrderId']) ? $_POST['publisherOrderId'] : null;
        $spUserHash = isset($_POST['spUserHash']) ? $_POST['spUserHash'] : null;
        $settlementDate = isset($_POST['settlementDate']) ? $_POST['settlementDate'] : null;
        $issuerCode = isset($_POST['issuerCode']) ? $_POST['issuerCode'] : null;

        //log callback untuk debug 
        // file_put_contents('callback.txt', "* Callback *\r\n", FILE_APPEND | LOCK_EX);
        // echo '<pre>';
        // print_r($_POST);
        // echo exit();
        if (!empty($merchantCode) && !empty($amount) && !empty($merchantOrderId) && !empty($signature)) {

            $params = $merchantCode . "$amount" . "$merchantOrderId" . $apiKey;
            // echo $apiKey;

            $calcSignature = md5($params);
            // echo "<br>";
            // echo $amount . "<br>";
            // echo $params . "<br>";
            // echo $calcSignature . "<br>";
            // echo $signature;

            if ($signature == $calcSignature) {
                //Callback tervalidasi
                //Silahkan rubah status transaksi anda disini
                $this->load->model('duitku');
                unset($_POST['merchantCode']);
                unset($_POST['signature']);
                unset($_POST['amount']);
                unset($_POST['sourceAccount']);

                $_POST['datePaid'] = date("Y-m-d H:i:s");

                $_POST['paymentAmount'] = $amount;

                $updTrans = $this->duitku->updateTransaction($_POST);
                if (!$updTrans) {
                    throw new Exception('Failed Update');
                }

                // file_put_contents('callback.txt', "* Berhasil *\r\n\r\n", FILE_APPEND | LOCK_EX);

            } else {
                // file_put_contents('callback.txt', "* Bad Signature *\r\n\r\n", FILE_APPEND | LOCK_EX);
                throw new Exception('Bad Signature');
            }
        } else {
            // file_put_contents('callback.txt', "* Bad Parameter *\r\n\r\n", FILE_APPEND | LOCK_EX);
            throw new Exception('Bad Parameter');
        }
    }
    public function return_page()
    {
        if (isset($_SESSION['id_member'])) {
            $code = $_REQUEST['resultCode'];
            if (isset($_SESSION['id_order'])) {
                if ($code == '00') {
                    $this->alert->setJamaah('green', 'Berhasil', 'Pembayaran Berhasil');
                    redirect(base_url() . 'jamaah/online_store');
                } else {
                    $this->alert->setJamaah('yellow', 'Transaksi Pending', 'Selesaikan Pembayaran pada transaksi pending');
                    redirect(base_url() . 'jamaah/online_store');
                }
            }
            if ($code == '00') {
                $this->alert->setJamaah('green', 'Berhasil', 'Pembayaran Berhasil');
                redirect(base_url() . 'jamaah/pembayaran/riwayat');
            } else {
                $this->alert->setJamaah('yellow', 'Transaksi Pending', 'Selesaikan Pembayaran pada transaksi pending');
                redirect(base_url() . 'jamaah/pembayaran/bayar_duitku');
            }
        }

        if (isset($_SESSION['id_agen'])) {
            $code = $_REQUEST['resultCode'];
            $this->load->model('duitku');
            $duitku = $this->duitku->getIDbyReferences($_REQUEST['reference']);
            if ($code == '00') {
                $this->alert->setJamaah('green', 'Berhasil', 'Pembayaran Berhasil');
                redirect(base_url() . 'konsultan/riwayat_bayar/riwayat?id=' . $duitku->merchantUserId);
            } else {
                $this->alert->setJamaah('yellow', 'Transaksi Pending', 'Selesaikan Pembayaran pada transaksi pending');
                redirect(base_url() . 'konsultan/riwayat_bayar/bayar_duitku?id=' . $duitku->merchantUserId);
            }
        }
        $this->load->view('duitku_return_view');
    }
}
        
    /* End of file  Duitku_gateway.php */