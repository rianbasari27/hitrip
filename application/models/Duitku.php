<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Duitku extends CI_Model
{
    public function __construct()
    {
        $this->merchantCode = $this->config->item('duitku_merchant_code');
        $this->merchantKey = $this->config->item('duitku_api_key');
        $this->timestamp = round(microtime(true) * 1000);
        $this->signature = hash('sha256', $this->merchantCode . $this->timestamp . $this->merchantKey);
        $this->callbackUrl = $this->config->item('duitku_callback_url');
        $this->returnUrl = $this->config->item('duitku_return_url');
        $this->expiryPeriodHours = $this->config->item('va_expiry_hours');
        $this->expiryPeriod = $this->expiryPeriodHours * 60;
        $this->createInvoiceUrl = $this->config->item('duitku_create_invoice_url');
    }
    public function getPendingTransaction($id_member)
    {
        $this->db->where('merchantUserId', $id_member);
        $this->db->where('datePaid', null);
        $this->db->where('dateExpired >', date("Y-m-d H:i:s"));
        $data = $this->db->get('duitku')->result_array();
        return $data;
    }
    
    public function getPendingTransactionAgen($id_member)
    {
        $this->db->where('merchantUserId', $id_member);
        $this->db->where('datePaid', null);
        $data = $this->db->get('duitku')->result_array();
        return $data;
    }

    public function createInvoice($idMember, $nominal, $expired = null, $jenis = 'bayar', $paymentMethod = null) //jenis : bayar, bayar_konsultan
    {
        if ($jenis == 'bayar_konsultan') {
            $dbParams = $this->createInvoiceKonsultan($idMember, $nominal, $expired, $paymentMethod);
        }else if ($jenis == 'store') {
            $dbParams = $this->createInvoiceStore($idMember, $nominal, $expired, $paymentMethod);
        } else {
            $dbParams = $this->createInvoiceJamaah($idMember, $nominal, $expired, $paymentMethod);
        }
        return $dbParams;
    }
    public function createInvoiceKonsultan($idMember, $nominal, $expired = null, $paymentMethod)
    {
        if ($expired == "no") {
            $expiryPeriod = null;
        } elseif ($expired) {
            $expiryPeriod = $expired;
        } else {
            $expiryPeriod = $this->expiryPeriod;
        }

        $date = date("Y-m-d H:i:s");
        $currentTime = strtotime($date);
        if ($expiryPeriod) {
            $dateExpired = date("Y-m-d H:i:s", strtotime("+$expiryPeriod minutes", $currentTime));
        } else {
            $dateExpired = null;
        }
        $paymentAmount = (int)$nominal;
        $merchantOrderId = $this->generateOrderId('bayar_konsultan');

        $this->db->join('agen_peserta_paket ap', 'ap.id_agen = a.id_agen');
        $this->db->where('id_agen_peserta', $idMember);
        $agen = $this->db->get('agen a')->row();

        $productDetails = $agen->nama_agen . " - " . $agen->deskripsi_diskon;
        $customerVaName = $agen->nama_agen;
        $customerDetail = array(
            'email' => $agen->email,
            'phoneNumber' => $agen->no_wa,
        );
        //PREPARE PARAMS FOR API HIT
        $params = array(
            'paymentAmount' => $paymentAmount,
            'merchantOrderId' => $merchantOrderId,
            'productDetails' => $productDetails,
            'customerVaName' => $customerVaName,
            'merchantUserInfo' => $idMember,
            'customerDetail' => $customerDetail,
            'email' => $agen->email,
            'phoneNumber' => $agen->no_wa,
            'callbackUrl' => $this->callbackUrl,
            'returnUrl' => $this->returnUrl,
            'expiryPeriod' => $expiryPeriod,
            'paymentMethod' => $paymentMethod,
        );
        $hit = $this->hitInvoiceAPI($params);
        if (!$hit) {
            return false;
        }
        $params['reference'] = $hit['reference'];
        //SAVE DATA TO DATABASE

        $dbParams = [
            'merchantOrderId' => $merchantOrderId,
            'merchantUserId' => $idMember,
            'paymentAmount' => $paymentAmount,
            'productDetail' => $productDetails,
            'reference' => $hit['reference'],
            'paymentUrl' => $hit['paymentUrl'],
            'dateCreated' => $date,
            'dateExpired' => $dateExpired,
        ];
        $this->db->insert('duitku', $dbParams);
        $pesan = "Tagihan Berhasil Dibuat";
        $this->alert->set('success', $pesan);
        $this->alert->setJamaah('green', 'Berhasil', $pesan);
        return $dbParams;
    }

    public function createInvoiceStore($idMember, $nominal, $expired = null, $paymentMethod)
    {
        if ($expired == "no") {
            $expiryPeriod = null;
        } elseif ($expired) {
            $expiryPeriod = $expired;
        } else {
            $expiryPeriod = $this->expiryPeriod;
        }

        $date = date("Y-m-d H:i:s");
        $currentTime = strtotime($date);
        if ($expiryPeriod) {
            $dateExpired = date("Y-m-d H:i:s", strtotime("+$expiryPeriod minutes", $currentTime));
        } else {
            $dateExpired = null;
        }
        $paymentAmount = (int)$nominal;
        $merchantOrderId = $this->generateOrderId('store');

        $this->db->where('order_id', $idMember);
        $order = $this->db->get('store_orders')->row();
        $this->load->model('store');
        $customer = $this->store->getCustomer($order->customer_id);
        $customer = $customer[0];

        if ($customer->jenis == 'j') {
            $this->load->model('registrasi');
            $jamaah = $this->registrasi->getJamaah(null, null, $customer->id_user);
            $detail = implode(' ', array_filter([$jamaah->first_name, $jamaah->second_name, $jamaah->last_name])) . " - " . "Pembayaran Ventour Store";
            $VaName = implode(' ', array_filter([$jamaah->first_name, $jamaah->second_name, $jamaah->last_name]));
            $email = $jamaah->email;
            $phoneNumber = $jamaah->no_wa;
        } else {
            $this->db->join('agen_peserta_paket ap', 'ap.id_agen = a.id_agen');
            $this->db->where('id_agen_peserta', $idMember);
            $agen = $this->db->get('agen a')->row();
            $detail = $agen->nama_agen . " - " . "Pembayaran Ventour Store";
            $VaName = $agen->nama_agen;
            $email = $agen->email;
            $phoneNumber = $agen->no_wa;
        }

        $productDetails = $detail;
        $customerVaName = $VaName;
        $customerDetail = array(
            'email' => $email,
            'phoneNumber' => $phoneNumber,
        );
        //PREPARE PARAMS FOR API HIT
        $params = array(
            'paymentAmount' => $paymentAmount,
            'merchantOrderId' => $merchantOrderId,
            'productDetails' => $productDetails,
            'customerVaName' => $customerVaName,
            'merchantUserInfo' => $idMember,
            'customerDetail' => $customerDetail,
            'email' => $email,
            'phoneNumber' => $phoneNumber,
            'callbackUrl' => $this->callbackUrl,
            'returnUrl' => $this->returnUrl,
            'expiryPeriod' => $expiryPeriod,
            'paymentMethod' => $paymentMethod,
        );
        $hit = $this->hitInvoiceAPI($params);
        if (!$hit) {
            return false;
        }
        $params['reference'] = $hit['reference'];
        //SAVE DATA TO DATABASE

        $dbParams = [
            'merchantOrderId' => $merchantOrderId,
            'merchantUserId' => $idMember,
            'paymentAmount' => $paymentAmount,
            'productDetail' => $productDetails,
            'reference' => $hit['reference'],
            'paymentUrl' => $hit['paymentUrl'],
            'dateCreated' => $date,
            'dateExpired' => $dateExpired,
        ];
        $this->db->insert('duitku', $dbParams);
        $pesan = "Tagihan Berhasil Dibuat";
        $this->alert->set('success', $pesan);
        $this->alert->setJamaah('green', 'Berhasil', $pesan);
        return $dbParams;
    }

    public function createInvoiceJamaah($idMember, $nominal, $expired = null, $paymentMethod)
    {
        $this->load->model('registrasi');
        $jamaah = $this->registrasi->getJamaah(null, null, $idMember);
        if (empty($jamaah)) {
            return false;
        }
        //check if nominal valid
        $riwayatBayar = $this->checkNominalValid($idMember, $nominal);
        if (!$riwayatBayar) {
            return false;
        }
        //PREPARE INFORMASI PRODUCT DETAIL
        $countBayar = count($riwayatBayar['data']);
        $namaPaket = $jamaah->member[0]->paket_info->nama_paket;
        $tanggalBerangkat =  $jamaah->member[0]->paket_info->tanggal_berangkat;
        $tanggalBerangkatPretty = $this->date->convert_date_indo($tanggalBerangkat);
        $paketInfo = "$namaPaket ($tanggalBerangkatPretty)";
        $pembayaranKe = $countBayar + 1;
        $customerVaName = implode(" ", [$jamaah->first_name, $jamaah->second_name, $jamaah->last_name]);
        $productDetails = "$customerVaName - Pembayaran ke " . $pembayaranKe . " " . $paketInfo;
        //////////////
        //PREPARE INFORMASI CUSTOMER DETAILS
        $phoneNumber = $jamaah->no_wa;
        $customerDetail = array(
            'firstName' => $jamaah->first_name,
            'lastName' => implode(" ", [$jamaah->second_name, $jamaah->last_name]),
            'email' => $jamaah->email,
            'phoneNumber' => $phoneNumber,
        );
        //////////////////////////////////
        $merchantOrderId = $this->generateOrderId();
        $paymentAmount = (int)$nominal;
        $email = $jamaah->email;

        if ($expired == "no") {
            $expiryPeriod = null;
        } elseif ($expired) {
            $expiryPeriod = $expired;
        } else {
            $expiryPeriod = $this->expiryPeriod;
        }
        $date = date("Y-m-d H:i:s");
        $currentTime = strtotime($date);
        if ($expiryPeriod) {

            $dateExpired = date("Y-m-d H:i:s", strtotime("+$expiryPeriod minutes", $currentTime));
        } else {
            $dateExpired = null;
        }
        //PREPARE PARAMS FOR API HIT
        $params = array(
            'paymentAmount' => $paymentAmount,
            'merchantOrderId' => $merchantOrderId,
            'productDetails' => $productDetails,
            'customerVaName' => $customerVaName,
            'merchantUserInfo' => $idMember,
            'customerDetail' => $customerDetail,
            'email' => $email,
            'phoneNumber' => $phoneNumber,
            'callbackUrl' => $this->callbackUrl,
            'returnUrl' => $this->returnUrl,
            'expiryPeriod' => $expiryPeriod,
            'paymentMethod' => $paymentMethod,
        );
        $hit = $this->hitInvoiceAPI($params);
        if (!$hit) {
            return false;
        }
        $params['reference'] = $hit['reference'];
        //SAVE DATA TO DATABASE

        $dbParams = [
            'merchantOrderId' => $merchantOrderId,
            'merchantUserId' => $idMember,
            'paymentAmount' => $paymentAmount,
            'productDetail' => $productDetails,
            'reference' => $hit['reference'],
            'paymentUrl' => $hit['paymentUrl'],
            'dateCreated' => $date,
            'dateExpired' => $dateExpired,
        ];
        $this->db->insert('duitku', $dbParams);
        $pesan = "Tagihan Berhasil Dibuat";
        $this->alert->set('success', $pesan);
        $this->alert->setJamaah('green', 'Berhasil', $pesan);
        return $dbParams;
    }
    public function generateOrderId($jenis = 'bayar')
    {
        if ($jenis == 'bayar_konsultan') {
            $prefix = '0';
        }else if ($jenis == 'store') {
            $prefix = '5';
        } else {
            $prefix = '1';
        }
        $unique = false;
        $letter = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
        while (!$unique) {
            $code = '';
            for ($i = 1; $i <= 12; $i++) {
                $randNum = rand(0, 25);
                $randString = $letter[$randNum];
                $code = $code . $randString;
            }
            $orderId = $prefix . $code;
            //check if already available
            $check = $this->db->where('merchantOrderId', $orderId)->get('duitku')->row();
            if (empty($check)) {
                $unique = true;
            }
        }
        return $orderId;
    }
    public function updateTransaction($params)
    {


        //set pembayaran
        // //cek di tabel duitku
        // $cek = $this->db->where('merchantOrderId', $params['merchantOrderId'])
        //     ->where('resultCode', '00')
        //     ->get('duitku')->row_array();
        //check if already inserted
        $cekPembayaran = $this->db->where('nomor_referensi', $params['reference'])
            ->where('verified', 1)
            ->get('pembayaran')->row_array();
        if ($params['resultCode'] == "00") {
            if (empty($cekPembayaran)) {
                $this->db->trans_start();
                $this->load->model('tarif');
                $data = [
                    'jumlah_bayar' => $params['paymentAmount'],
                    'tanggal_bayar' => date('Y-m-d H:i:s'),
                    'cara_pembayaran' => "Duitku-" . $params['paymentCode'],
                    'nomor_referensi' => $params['reference'],
                    'keterangan' => $params['productDetail'],
                    'verified' => 1,
                ];
                // check pembayaran jamaah atau konsultan dari orderId
                $kodeJenis = substr($params['merchantOrderId'], 0, 1);
                if ($kodeJenis == '0') {
                    $data['id_agen_peserta'] = $params['merchantUserId'];
                    $jenis = 'bayar_konsultan';
                }else if ($kodeJenis == '5') {
                    $data['order_id'] = $params['merchantUserId'];
                    $jenis = 'store';
                } else {
                    $data['id_member'] = $params['merchantUserId'];
                    $jenis = 'bayar';
                }



                $setBayar = $this->tarif->setPembayaran($data, $jenis);
                if (!$setBayar) {
                    return false;
                }


                $this->db->trans_complete();
            }
            $this->db->where('merchantOrderId', $params['merchantOrderId']);
            $upd = $this->db->update('duitku', $params);
            return true;
        }
    }
    public function hitInvoiceAPI($params)
    {
        $params_string = json_encode($params);
        $ch = curl_init();


        curl_setopt($ch, CURLOPT_URL, $this->createInvoiceUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($params_string),
                'x-duitku-signature:' . $this->signature,
                'x-duitku-timestamp:' . $this->timestamp,
                'x-duitku-merchantcode:' . $this->merchantCode
            )
        );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        //execute post
        $request = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (
            $httpCode == 200
        ) {
            $result = json_decode($request, true);
            //header('location: '. $result['paymentUrl']);
            return $result;
            // echo "paymentUrl :". $result['paymentUrl'] . "<br />";
            // echo "reference :". $result['reference'] . "<br />";
            // echo "statusCode :". $result['statusCode'] . "<br />";
            // echo "statusMessage :". $result['statusMessage'] . "<br />";
        } else {
            $pesanError = "Data invalid, atau API duitku sedang tidak bisa diakses";
            $this->alert->set('danger', $pesanError);
            $this->alert->setJamaah('red', 'Tagihan tidak dapat dibuat', $pesanError);
            return false;
        }
    }

    public function checkNominalValid($idMember, $nominal)
    {
        $this->load->model('tarif');
        $riwayat = $this->tarif->getRiwayatBayar($idMember);
        $pesanError = "Nominal pembayaran tidak valid";
        if (empty($riwayat)) {
            $this->alert->set('danger', $pesanError);
            $this->alert->setJamaah('red', 'Tagihan tidak dapat dibuat', $pesanError);
            return false;
        }
        //cek sisa tagihan
        $sisaTagihan = $riwayat['sisaTagihan'];
        if ($nominal > $sisaTagihan) {
            $this->alert->set('danger', $pesanError);
            $this->alert->setJamaah('red', 'Tagihan tidak dapat dibuat', $pesanError);
            return false;
        }
        //jika belum dp cek minimum pembayaran
        $totalBayar = $riwayat['totalBayar'];
        $dpFee = $riwayat['tarif']['dp'];
        if ($totalBayar == 0 && $nominal < $dpFee) {
            $pesanErrorDp = 'Nominal Pembayaran kurang dari harga DP';
            $this->alert->set('danger', $pesanErrorDp);
            $this->alert->setJamaah('red', 'Tagihan tidak dapat dibuat', $pesanErrorDp);
            return false;
        }
        return $riwayat;
    }
    public function debugLog($o)
    {
        $logDir = $this->config->item('log_directory');
        $file_debug = $logDir . 'debug-duitku-' . date("Y-m-d") . '.log.txt';
        ob_start();
        var_dump(date("Y-m-d H:i:s"));
        var_dump($o);
        $c = ob_get_contents();
        ob_end_clean();

        $f = fopen($file_debug, "a");
        fputs($f, "$c\n");
        fflush($f);
        fclose($f);
    }

    public function getIDbyReferences($reference)
    {
        $this->db->where('reference', $reference);
        $query = $this->db->get('duitku');
        $data = $query->row();

        return $data;
    }
}

                        
/* End of file Duitku.php */