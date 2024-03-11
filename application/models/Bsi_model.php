<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Bsi_model extends CI_Model
{

    public function debugLog($o)
    {
        $logDir = $this->config->item('log_directory');
        $file_debug = $logDir . 'debug-h2h-' . date("Y-m-d") . '.log.txt';
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
    public function startInquiry($_JSON)
    {
        $nomorPembayaran = $_JSON['nomorPembayaran'];
        // Pembayaran jamaah umroh atau konsultan?
        $kodeJenis = substr($nomorPembayaran, 0, 1);
        if ($kodeJenis == '0') {
            $dataInquiry = $this->inquiryKonsultan($_JSON);
        }else if ($kodeJenis == '5') {
            $dataInquiry = $this->inquiryStore($_JSON);
        } else {
            $dataInquiry = $this->inquiryJamaah($_JSON);
        }

        return $dataInquiry;
    }
    public function inquiryStore($_JSON)
    {
        // PARAMATER DI BAWAH INI ADALAH VARIABEL YANG DITERIMA DARI BSI
        $kodeBank         = $_JSON['kodeBank'];
        $kodeChannel      = $_JSON['kodeChannel'];
        $kodeBiller       = $_JSON['kodeBiller'];
        $kodeTerminal     = $_JSON['kodeTerminal'];
        $nomorPembayaran  = $_JSON['nomorPembayaran'];
        $tanggalTransaksi = $_JSON['tanggalTransaksi'];
        $idTransaksi      = $_JSON['idTransaksi'];
        $totalNominalInquiry = $_JSON['totalNominalInquiry'];
        // $totalNominalInquiry = $_JSON['totalNominalInquiry'];

        // Get is va exist
        $order = $this->db->where('va_open', $nomorPembayaran)
            ->get('store_orders')->row_array();
        // $this->debugLog($order);

        //NOMOR NOT FOUND
        if (empty($order)) {
            $response = array(
                'rc'  => 'ERR-NOT-FOUND',
                'msg' => 'Nomor Tidak Ditemukan'
            );
            return $response;
        }


        // ADA BANK YANG MENGELUARKAN TOTAL INQUIRY = 0, MAKA SKIP SAJA CEK PAYMENT NYA DI INQUIRY
        if ($totalNominalInquiry != 0) {
            $checkPaymentRules = $this->checkPaymentStoreRules($order['order_id'], $totalNominalInquiry, false);
            if ($checkPaymentRules['rc'] != 'OK') {
                return $checkPaymentRules;
            }
        }
        // check nama
        $this->load->model('store');
        $customer = $this->store->getCustomer($order['customer_id']);
        if ($customer[0]->jenis == "j") {
            $this->load->model('registrasi');
            $jamaah = $this->registrasi->getJamaah(null, null, $customer[0]->id_user);
            $nama = implode(' ', array_filter([$jamaah->first_name, $jamaah->second_name, $jamaah->last_name]));
            $email = $jamaah->email;
            $no_wa = $jamaah->no_wa;
        } else {
            $this->load->model('agen');
            $agen = $this->agen->getAgen($customer[0]->id_user);
            $nama = $agen[0]->nama_agen;
            $email = $agen[0]->email;
            $no_wa = $agen[0]->no_wa;
        }

        //PREPARE INFORMASI
        $strInfo = $nama . " - Pembayaran ke Ventour Store";
        $text = $strInfo;
        $result = [];
        $partial = [];
        $len = 0;

        foreach (explode(' ', $text) as $chunk) {
            $chunkLen = strlen($chunk);
            if ($len + $chunkLen > 30) {
                $result[] = $partial;
                $partial = [];
                $len = 0;
            }
            $len += $chunkLen;
            $partial[] = $chunk;
        }

        if ($partial) {
            $result[] = $partial;
        }
        $arr_informasi = [];
        $ctr = 0;
        foreach ($result as $key => $rs) {
            $ctr++;
            $arr_informasi[$key]['label_key'] = 'Info' . $ctr;
            $arr_informasi[$key]['label_value'] = implode(" ", $rs);
        }



        // PREPARE RINCIAN
        $arr_rincian = [
            [
                "kode_rincian" => 'TAGIHAN',
                "deskripsi" => $strInfo,
                "nominal" => $totalNominalInquiry
            ],
        ];


        $data_inquiry = [
            'rc' => 'OK',
            'msg' => 'Inquiry Succeeded',
            'nomorPembayaran' => $nomorPembayaran,
            'idPelanggan' => $order['order_id'],
            'nama' => $nama,
            'nomorHP' => $no_wa,
            'email' => $email,
            'totalNominal' => $totalNominalInquiry,
            'totalNominalInquiry' => $totalNominalInquiry,
            'informasi' => $arr_informasi,
            'rincian' => $arr_rincian,
            'idTagihan' => $tanggalTransaksi
        ];
        return $data_inquiry;
    }

    public function inquiryKonsultan($_JSON)
    {
        // PARAMATER DI BAWAH INI ADALAH VARIABEL YANG DITERIMA DARI BSI
        $kodeBank         = $_JSON['kodeBank'];
        $kodeChannel      = $_JSON['kodeChannel'];
        $kodeBiller       = $_JSON['kodeBiller'];
        $kodeTerminal     = $_JSON['kodeTerminal'];
        $nomorPembayaran  = $_JSON['nomorPembayaran'];
        $tanggalTransaksi = $_JSON['tanggalTransaksi'];
        $idTransaksi      = $_JSON['idTransaksi'];
        $totalNominalInquiry = $_JSON['totalNominalInquiry'];
        // $totalNominalInquiry = $_JSON['totalNominalInquiry'];

        // Get is va exist
        $member = $this->db->where('va_open', $nomorPembayaran)
            ->get('agen_peserta_paket')->row_array();
        // $this->debugLog($member);

        //NOMOR NOT FOUND
        if (empty($member)) {
            $response = array(
                'rc'  => 'ERR-NOT-FOUND',
                'msg' => 'Nomor Tidak Ditemukan'
            );
            return $response;
        }


        // ADA BANK YANG MENGELUARKAN TOTAL INQUIRY = 0, MAKA SKIP SAJA CEK PAYMENT NYA DI INQUIRY
        if ($totalNominalInquiry != 0) {
            $checkPaymentRules = $this->checkPaymentKonsultanRules($member['id_agen_peserta'], $totalNominalInquiry);
            if ($checkPaymentRules['rc'] != 'OK') {
                return $checkPaymentRules;
            }
        }

        $agen = $this->db->where('id_agen', $member['id_agen'])->get('agen')->row_array();

        $nama = $agen['nama_agen'];

        //PREPARE INFORMASI
        $strInfo = $nama . " - " . $member['deskripsi_diskon'];
        $text = $strInfo;
        $result = [];
        $partial = [];
        $len = 0;

        foreach (explode(' ', $text) as $chunk) {
            $chunkLen = strlen($chunk);
            if ($len + $chunkLen > 30) {
                $result[] = $partial;
                $partial = [];
                $len = 0;
            }
            $len += $chunkLen;
            $partial[] = $chunk;
        }

        if ($partial) {
            $result[] = $partial;
        }
        $arr_informasi = [];
        $ctr = 0;
        foreach ($result as $key => $rs) {
            $ctr++;
            $arr_informasi[$key]['label_key'] = 'Info' . $ctr;
            $arr_informasi[$key]['label_value'] = implode(" ", $rs);
        }



        // PREPARE RINCIAN
        $arr_rincian = [
            [
                "kode_rincian" => 'TAGIHAN',
                "deskripsi" => $strInfo,
                "nominal" => $totalNominalInquiry
            ],
        ];


        $data_inquiry = [
            'rc' => 'OK',
            'msg' => 'Inquiry Succeeded',
            'nomorPembayaran' => $nomorPembayaran,
            'idPelanggan' => $member['id_agen_peserta'],
            'nama' => $nama,
            'nomorHP' => $agen['no_wa'],
            'email' => $agen['email'],
            'totalNominal' => $totalNominalInquiry,
            'totalNominalInquiry' => $totalNominalInquiry,
            'informasi' => $arr_informasi,
            'rincian' => $arr_rincian,
            'idTagihan' => $tanggalTransaksi
        ];
        return $data_inquiry;
    }
    
    public function checkPaymentKonsultanRules($idPeserta, $totalNominalInquiry, $debug = false)
    {
        $this->load->model('tarif');
        $sisaBayar = $this->tarif->getSisaPembayaranKonsultan($idPeserta);
        if ($sisaBayar <= 0) {
            $response = array(
                'rc'  => 'ERR-ALREADY-PAID',
                'msg' => 'Tagihan Pembayaran Anda Sudah Lunas.'
            );
            return $response;
        }
        $adminFee = $this->config->item('bsi_admin_fee');
        $minPayment = $sisaBayar + $adminFee;

        if ($totalNominalInquiry < $minPayment) {
            $response = array(
                'rc'  => 'ERR-PAYMENT-WRONG-AMOUNT',
                'msg' => 'Nominal Pembayaran kurang dari ' . $totalNominalInquiry . '.'
            );
            return $response;
        }
        return $response = array(
            'rc' => 'OK'
        );
    }

    public function checkPaymentStoreRules($idOrder, $totalNominalInquiry, $debug = false)
    {
        $this->load->model('tarif');
        $sisaBayar = $this->tarif->getSisaPembayaranStore($idOrder);
        if ($sisaBayar <= 0) {
            $response = array(
                'rc'  => 'ERR-ALREADY-PAID',
                'msg' => 'Tagihan Pembayaran Anda Sudah Lunas.'
            );
            return $response;
        }
        $adminFee = $this->config->item('bsi_admin_fee');
        $minPayment = $sisaBayar + $adminFee;

        if ($totalNominalInquiry < $minPayment) {
            $response = array(
                'rc'  => 'ERR-PAYMENT-WRONG-AMOUNT',
                'msg' => 'Nominal Pembayaran kurang dari ' . $minPayment . '.'
            );
            return $response;
        }
        return $response = array(
            'rc' => 'OK'
        );
    }

    public function inquiryJamaah($_JSON)
    {
        // PARAMATER DI BAWAH INI ADALAH VARIABEL YANG DITERIMA DARI BSI
        $kodeBank         = $_JSON['kodeBank'];
        $kodeChannel      = $_JSON['kodeChannel'];
        $kodeBiller       = $_JSON['kodeBiller'];
        $kodeTerminal     = $_JSON['kodeTerminal'];
        $nomorPembayaran  = $_JSON['nomorPembayaran'];
        $tanggalTransaksi = $_JSON['tanggalTransaksi'];
        $idTransaksi      = $_JSON['idTransaksi'];
        $totalNominalInquiry = $_JSON['totalNominalInquiry'];
        // $totalNominalInquiry = $_JSON['totalNominalInquiry'];

        $member = $this->db->where('va_open', $nomorPembayaran)
            ->get('program_member')->row_array();
        // $this->debugLog($member);

        //NOMOR NOT FOUND
        if (empty($member)) {
            $response = array(
                'rc'  => 'ERR-NOT-FOUND',
                'msg' => 'Nomor Tidak Ditemukan'
            );
            return $response;
        }

        //get riwayat pembayaran
        $this->load->model('tarif');
        $riwayatBayar = $this->tarif->getRiwayatBayar($member['id_member']);
        $countBayar = count($riwayatBayar['data']);

        // ADA BANK YANG MENGELUARKAN TOTAL INQUIRY = 0, MAKA SKIP SAJA CEK PAYMENT NYA DI INQUIRY
        if ($totalNominalInquiry != 0) {
            $checkPaymentRules = $this->checkPaymentRules($riwayatBayar, $totalNominalInquiry);
            if ($checkPaymentRules['rc'] != 'OK') {
                return $checkPaymentRules;
            }
        }

        //cek if expired, jika sudah lewat tanggal keberangkatan tagihan expired
        $this->load->model('paketUmroh');
        $paket =  $this->paketUmroh->getPackage($member['id_paket']);
        $namaPaket = $paket->nama_paket;
        $tanggalBerangkat = $paket->tanggal_berangkat;
        $curDate = date('Y-m-d');
        if ($curDate > $tanggalBerangkat) {
            $response = array(
                'rc'  => 'ERR-BILL-EXPIRED',
                'msg' => 'Nomor Tagihan Sudah Expired atau Kadaluarsa.'
            );
            return $response;
        }
        $this->load->model('registrasi');
        $jamaah = $this->registrasi->getJamaah(null, null, $member['id_member']);

        $nama = implode(" ", [$jamaah->first_name, $jamaah->second_name, $jamaah->last_name]);

        //PREPARE INFORMASI
        $pembayaranKe = $countBayar + 1;
        $strInfo = $nama . " - Pembayaran ke " . $pembayaranKe . " " . $namaPaket;
        $text = $strInfo;
        $result = [];
        $partial = [];
        $len = 0;

        foreach (explode(' ', $text) as $chunk) {
            $chunkLen = strlen($chunk);
            if ($len + $chunkLen > 30) {
                $result[] = $partial;
                $partial = [];
                $len = 0;
            }
            $len += $chunkLen;
            $partial[] = $chunk;
        }

        if ($partial) {
            $result[] = $partial;
        }
        $arr_informasi = [];
        $ctr = 0;
        foreach ($result as $key => $rs) {
            $ctr++;
            $arr_informasi[$key]['label_key'] = 'Info' . $ctr;
            $arr_informasi[$key]['label_value'] = implode(" ", $rs);
        }



        // PREPARE RINCIAN
        $arr_rincian = [
            [
                "kode_rincian" => 'TAGIHAN',
                "deskripsi" => $nama . " - Pembayaran Ke " . $pembayaranKe . " " . $namaPaket,
                "nominal" => $totalNominalInquiry
            ],
        ];


        $data_inquiry = [
            'rc' => 'OK',
            'msg' => 'Inquiry Succeeded',
            'nomorPembayaran' => $nomorPembayaran,
            'idPelanggan' => $member['id_member'],
            'nama' => $nama,
            'nomorHP' => $jamaah->no_wa,
            'email' => $jamaah->email,
            'totalNominal' => $totalNominalInquiry,
            'totalNominalInquiry' => $totalNominalInquiry,
            'informasi' => $arr_informasi,
            'rincian' => $arr_rincian,
            'idTagihan' => $tanggalTransaksi,
            'tanggal_expired' => $tanggalBerangkat,
        ];
        return $data_inquiry;
    }
    public function checkPaymentRules($riwayatBayar, $totalNominalInquiry)
    {
        //cek apakah ini pembayaran pertama (minimal harus 5 juta)
        $minDP = $riwayatBayar['tarif']['dp'];
        $totalBayar = $riwayatBayar['totalBayar'];
        if ($totalBayar == 0) {
            $minPayment = $minDP;
        } else {
            $minPayment = 1;
        }
        $sisaTagihan = $riwayatBayar['sisaTagihan'];
        $adminFee = $this->config->item('bsi_admin_fee');
        $maxPayment = $sisaTagihan + $adminFee;
        $minPayment = $minPayment + $adminFee;

        if ($sisaTagihan == 0) {
            $response = array(
                'rc'  => 'ERR-ALREADY-PAID',
                'msg' => 'Tagihan Pembayaran Anda Sudah Lunas.'
            );
            return $response;
        }
        if ($totalNominalInquiry < $minPayment && $totalBayar == 0) {
            $response = array(
                'rc'  => 'ERR-PAYMENT-WRONG-AMOUNT',
                'msg' => 'Minimal DP adalah Rp. ' . $minPayment,
            );
            return $response;
        }
        if ($totalNominalInquiry < $minPayment) {
            $response = array(
                'rc'  => 'ERR-PAYMENT-WRONG-AMOUNT',
                'msg' => 'Nominal Pembayaran Tidak Sesuai Ketentuan.',
            );
            return $response;
        }

        if ($totalNominalInquiry > $maxPayment) {
            $response = array(
                'rc'  => 'ERR-PAYMENT-WRONG-AMOUNT',
                'msg' => 'Nominal Pembayaran Maksimal Rp.' . $maxPayment,
            );
            return $response;
        }

        // CEK SISA PEMBAYARAN
        if ($totalNominalInquiry > ($riwayatBayar['sisaTagihan'] + $adminFee)) {
            $response = array(
                'rc' => 'ERR-PAYMENT-WRONG-AMOUNT',
                'msg' => 'Terdapat kesalahan nilai pembayaran, nominal pembayaran ' . $totalNominalInquiry . ' lebih besar daripada sisa tagihan ' . $riwayatBayar['sisaTagihan'],
            );
            return $response;
        }

        //CEK JIKA SISA TAGIHAN APABILA DIBAYARKAN KURANG DARI 8000
        // if ((($riwayatBayar['sisaTagihan'] + $adminFee - $totalNominalInquiry) < 8000)
        //     && (($riwayatBayar['sisaTagihan'] + $adminFee - $totalNominalInquiry) != 0)
        // ) {
        //     $response = array(
        //         'rc' => 'ERR-PAYMENT-WRONG-AMOUNT',
        //         'msg' => 'Sisa tagihan setelah dibayarkan tidak boleh kurang dari Rp.8.000',
        //     );
        //     return $response;
        // }
        return $response = array(
            'rc' => 'OK'
        );
    }
    public function validateInquiryData($_JSON)
    {
        // $this->debugLog($_JSON);

        // PARAMATER DI BAWAH INI ADALAH VARIABEL YANG DITERIMA DARI BSI
        $kodeBank         = $_JSON['kodeBank'];
        $kodeChannel      = $_JSON['kodeChannel'];
        $kodeBiller       = $_JSON['kodeBiller'];
        $kodeTerminal     = $_JSON['kodeTerminal'];
        $nomorPembayaran  = $_JSON['nomorPembayaran'];
        $tanggalTransaksi = $_JSON['tanggalTransaksi'];
        $idTransaksi      = $_JSON['idTransaksi'];
        $totalNominalInquiry = $_JSON['totalNominalInquiry'];

        // PERIKSA APAKAH SELURUH PARAMETER SUDAH LENGKAP
        if (empty($kodeBank) || empty($kodeChannel) || empty($kodeTerminal) || empty($nomorPembayaran) || empty($tanggalTransaksi) || empty($idTransaksi)) {
            $response = json_encode(array(
                'rc'  => 'ERR-PARSING-MESSAGE',
                'msg' => 'Invalid Message Format'
            ));
            $this->debugLog('RESPONSE: ' . $response);
            echo $response;
            exit();
        }

        // PERIKSA APAKAH KODE BANK DIIZINKAN MENGAKSES WEBSERVICE INI
        if (!in_array($kodeBank, $this->config->item('allowed_collecting_agents'))) {
            $response = json_encode(array(
                'rc'  => 'ERR-BANK-UNKNOWN',
                'msg' => 'Collecting agent is not allowed by ' . $this->config->item('biller_name')
            ));
            $this->debugLog('RESPONSE: ' . $response);
            echo $response;
            exit();
        }

        // PERIKSA APAKAH KODE CHANNEL DIIZINKAN MENGAKSES WEBSERVICE INI
        if (!in_array($kodeChannel, $this->config->item('allowed_channels'))) {
            $response = json_encode(array(
                'rc'  => 'ERR-CHANNEL-UNKNOWN',
                'msg' => 'Channel is not allowed by ' . $this->config->item('biller_name')
            ));
            $this->debugLog('RESPONSE: ' . $response);
            echo $response;
            exit();
        }

        // PERIKSA APAKAH CHECKSUM VALID
        if (sha1($_JSON['nomorPembayaran'] . $this->config->item('secret_key') . $_JSON['tanggalTransaksi']) != $_JSON['checksum']) {
            $response = json_encode(array(
                'rc'  => 'ERR-SECURE-HASH',
                'msg' => 'H2H Checksum is invalid'
            ));
            $this->debugLog('RESPONSE: ' . $response);
            echo $response;
            exit();
        }
    }

    public function startPayment($_JSON)
    {
        $nomorPembayaran = $_JSON['nomorPembayaran'];
        // Pembayaran jamaah umroh atau konsultan?
        $kodeJenis = substr($nomorPembayaran, 0, 1);
        if ($kodeJenis == '0') {
            $dataPayment = $this->paymentKonsultan($_JSON);
        }else if ($kodeJenis == '5') {
            $dataPayment = $this->paymentStore($_JSON);
        } else {
            $dataPayment = $this->paymentJamaah($_JSON);
        }


        return $dataPayment;
    }
    public function paymentKonsultan($_JSON)
    {
        $_JSON['totalNominalInquiry'] = $_JSON['totalNominalPembayaranDanFee'];
        $kodeBank               = $_JSON['kodeBank'];
        $kodeChannel            = $_JSON['kodeChannel'];
        $kodeBiller             = $_JSON['kodeBiller'];
        $kodeTerminal           = $_JSON['kodeTerminal'];
        $nomorPembayaran        = $_JSON['nomorPembayaran'];
        $idTagihan              = $_JSON['idTagihan'];
        $tanggalTransaksi       = $_JSON['tanggalTransaksi'];
        $idTransaksi            = $_JSON['idTransaksi'];
        $totalNominal           = $_JSON['totalNominal'];
        $nomorJurnalPembukuan   = $_JSON['nomorJurnalPembukuan'];
        $totalNominalPembayaranDanFee = $_JSON['totalNominalPembayaranDanFee'];
        $dataInquiry = $this->startInquiry($_JSON);
        if ($dataInquiry['rc'] != 'OK') {
            return $dataInquiry;
        }

        //CEK PEMBAYARAN
        $checkPaymentRules = $this->checkPaymentKonsultanRules($dataInquiry['idPelanggan'], $totalNominalPembayaranDanFee);
        if ($checkPaymentRules['rc'] != 'OK') {
            return $checkPaymentRules;
        }

        //START PAYMENT TRANSACTION
        $this->db->trans_start();
        //keterangan
        $keterangan = [];
        foreach ($dataInquiry['informasi'] as $info) {
            $keterangan[] = $info['label_value'];
        }
        $keterangan = implode(" ", $keterangan);


        $data = [
            'id_agen_peserta' => $dataInquiry['idPelanggan'],
            'jumlah_bayar' => $totalNominal,
            'tanggal_bayar' => date('Y-m-d H:i:s'),
            'cara_pembayaran' => 'BSI-VA',
            'nomor_referensi' => $nomorPembayaran . '_' . $nomorJurnalPembukuan,
            'keterangan' => $keterangan,
            'verified' => 1,
        ];
        $setBayar = $this->tarif->setPembayaran($data, 'bayar_konsultan');

        //insert ke tabel VA
        $dataVa = [
            'nomor_va' => $nomorPembayaran,
            'tanggal_create' => date('Y-m-d H:i:s'),
            'id_member' => $data['id_agen_peserta'],
            'nominal_tagihan' => $data['jumlah_bayar'],
            'informasi' => $keterangan,
            'metode' => 'BSI-VA',
            'nomor_jurnal_pembukuan' => $nomorJurnalPembukuan,
            'waktu_transaksi' => date('Y-m-d H:i:s'),
            'channel_pembayaran' => $kodeChannel,
            'status_pembayaran' => 'SUKSES',
        ];
        $insertTableVa = $this->db->insert('virtual_account', $dataVa);
        if (!$setBayar || !$insertTableVa) {
            $response = array(
                'rc' => 'ERR-UNDEFINED',
                'msg' => 'Gagal saat update pembayaran',
            );
            return $response;
        }
        $this->db->trans_complete();

        $dataPayment = $dataInquiry;
        $dataPayment['msg'] = 'Payment Succeeded';
        $dataPayment['totalNominal'] = $totalNominal;
        return $dataPayment;
    }
    public function paymentJamaah($_JSON)
    {
        $_JSON['totalNominalInquiry'] = $_JSON['totalNominalPembayaranDanFee'];
        $kodeBank               = $_JSON['kodeBank'];
        $kodeChannel            = $_JSON['kodeChannel'];
        $kodeBiller             = $_JSON['kodeBiller'];
        $kodeTerminal           = $_JSON['kodeTerminal'];
        $nomorPembayaran        = $_JSON['nomorPembayaran'];
        $idTagihan              = $_JSON['idTagihan'];
        $tanggalTransaksi       = $_JSON['tanggalTransaksi'];
        $idTransaksi            = $_JSON['idTransaksi'];
        $totalNominal           = $_JSON['totalNominal'];
        $nomorJurnalPembukuan   = $_JSON['nomorJurnalPembukuan'];
        $totalNominalPembayaranDanFee = $_JSON['totalNominalPembayaranDanFee'];
        $dataInquiry = $this->startInquiry($_JSON);
        if ($dataInquiry['rc'] != 'OK') {
            return $dataInquiry;
        }


        //CEK PEMBAYARAN
        $this->load->model('tarif');
        $tarif = $this->tarif->getRiwayatBayar($dataInquiry['idPelanggan']);
        $checkPaymentRules = $this->checkPaymentRules($tarif, $totalNominalPembayaranDanFee);
        if ($checkPaymentRules['rc'] != 'OK') {
            return $checkPaymentRules;
        }
        //START PAYMENT TRANSACTION
        $this->db->trans_start();
        //keterangan
        $keterangan = [];
        foreach ($dataInquiry['informasi'] as $info) {
            $keterangan[] = $info['label_value'];
        }
        $keterangan = implode(" ", $keterangan);
        $data = [
            'id_member' => $dataInquiry['idPelanggan'],
            'jumlah_bayar' => $totalNominal,
            'tanggal_bayar' => date('Y-m-d H:i:s'),
            'cara_pembayaran' => 'BSI-VA',
            'nomor_referensi' => $nomorPembayaran . '_' . $nomorJurnalPembukuan,
            'keterangan' => $keterangan,
            'verified' => 1,
        ];
        $setBayar = $this->tarif->setPembayaran($data);
        //insert ke tabel VA
        $dataVa = [
            'nomor_va' => $nomorPembayaran,
            'tanggal_create' => date('Y-m-d H:i:s'),
            'tanggal_expired' => $dataInquiry['tanggal_expired'],
            'id_member' => $data['id_member'],
            'nominal_tagihan' => $data['jumlah_bayar'],
            'informasi' => $keterangan,
            'metode' => 'BSI-VA',
            'nomor_jurnal_pembukuan' => $nomorJurnalPembukuan,
            'waktu_transaksi' => date('Y-m-d H:i:s'),
            'channel_pembayaran' => $kodeChannel,
            'status_pembayaran' => 'SUKSES',
        ];
        $insertTableVa = $this->db->insert('virtual_account', $dataVa);

        if (!$setBayar || !$insertTableVa) {
            $response = array(
                'rc' => 'ERR-UNDEFINED',
                'msg' => 'Gagal saat update pembayaran',
            );
            return $response;
        }
        $this->db->trans_complete();

        $dataPayment = $dataInquiry;
        $dataPayment['msg'] = 'Payment Succeeded';
        $dataPayment['totalNominal'] = $totalNominal;
        return $dataPayment;
    }

    public function paymentStore($_JSON)
    {
        $_JSON['totalNominalInquiry'] = $_JSON['totalNominalPembayaranDanFee'];
        $kodeBank               = $_JSON['kodeBank'];
        $kodeChannel            = $_JSON['kodeChannel'];
        $kodeBiller             = $_JSON['kodeBiller'];
        $kodeTerminal           = $_JSON['kodeTerminal'];
        $nomorPembayaran        = $_JSON['nomorPembayaran'];
        $idTagihan              = $_JSON['idTagihan'];
        $tanggalTransaksi       = $_JSON['tanggalTransaksi'];
        $idTransaksi            = $_JSON['idTransaksi'];
        $totalNominal           = $_JSON['totalNominal'];
        $nomorJurnalPembukuan   = $_JSON['nomorJurnalPembukuan'];
        $totalNominalPembayaranDanFee = $_JSON['totalNominalPembayaranDanFee'];
        $dataInquiry = $this->startInquiry($_JSON);
        if ($dataInquiry['rc'] != 'OK') {
            return $dataInquiry;
        }

        //CEK PEMBAYARAN
        $checkPaymentRules = $this->checkPaymentStoreRules($dataInquiry['idPelanggan'], $totalNominalPembayaranDanFee);
        if ($checkPaymentRules['rc'] != 'OK') {
            return $checkPaymentRules;
        }

        //START PAYMENT TRANSACTION
        $this->db->trans_start();
        //keterangan
        $keterangan = [];
        foreach ($dataInquiry['informasi'] as $info) {
            $keterangan[] = $info['label_value'];
        }
        $keterangan = implode(" ", $keterangan);


        $data = [
            'order_id' => $dataInquiry['idPelanggan'],
            'jumlah_bayar' => $totalNominal,
            'tanggal_bayar' => date('Y-m-d H:i:s'),
            'cara_pembayaran' => 'BSI-VA',
            'nomor_referensi' => $nomorPembayaran . '_' . $nomorJurnalPembukuan,
            'keterangan' => $keterangan,
            'verified' => 1,
        ];
        $setBayar = $this->tarif->setPembayaran($data, 'store');

        //insert ke tabel VA
        $dataVa = [
            'nomor_va' => $nomorPembayaran,
            'tanggal_create' => date('Y-m-d H:i:s'),
            'id_member' => $data['order_id'],
            'nominal_tagihan' => $data['jumlah_bayar'],
            'informasi' => $keterangan,
            'metode' => 'BSI-VA',
            'nomor_jurnal_pembukuan' => $nomorJurnalPembukuan,
            'waktu_transaksi' => date('Y-m-d H:i:s'),
            'channel_pembayaran' => $kodeChannel,
            'status_pembayaran' => 'SUKSES',
        ];
        $insertTableVa = $this->db->insert('virtual_account', $dataVa);
        if (!$setBayar || !$insertTableVa) {
            $response = array(
                'rc' => 'ERR-UNDEFINED',
                'msg' => 'Gagal saat update pembayaran',
            );
            return $response;
        }
        $this->db->trans_complete();

        $dataPayment = $dataInquiry;
        $dataPayment['msg'] = 'Payment Succeeded';
        $dataPayment['totalNominal'] = $totalNominal;
        return $dataPayment;
    }

    public function validatePaymentData($_JSON)
    {
        // $this->debugLog($_JSON);

        // PARAMATER DI BAWAH INI ADALAH VARIABEL YANG DITERIMA DARI BSI
        $kodeBank               = $_JSON['kodeBank'];
        $kodeChannel            = $_JSON['kodeChannel'];
        $kodeBiller             = $_JSON['kodeBiller'];
        $kodeTerminal           = $_JSON['kodeTerminal'];
        $nomorPembayaran        = $_JSON['nomorPembayaran'];
        $idTagihan              = $_JSON['idTagihan'];
        $tanggalTransaksi       = $_JSON['tanggalTransaksi'];
        $idTransaksi            = $_JSON['idTransaksi'];
        $totalNominal           = $_JSON['totalNominal'];
        $nomorJurnalPembukuan   = $_JSON['nomorJurnalPembukuan'];


        // PERIKSA APAKAH SELURUH PARAMETER SUDAH LENGKAP
        if (empty($kodeBank) || empty($kodeChannel) || empty($kodeTerminal) || empty($nomorPembayaran) || empty($tanggalTransaksi) || empty($idTransaksi) || empty($totalNominal) || empty($nomorJurnalPembukuan)) {

            $response = json_encode(array(
                'rc'  => 'ERR-PARSING-MESSAGE',
                'msg' => 'Invalid Message Format'
            ));
            $this->debugLog('RESPONSE: ' . $response);
            echo $response;
            exit();
        }
        // PERIKSA APAKAH KODE BANK DIIZINKAN MENGAKSES WEBSERVICE INI
        if (!in_array($kodeBank, $this->config->item('allowed_collecting_agents'))) {
            $response = json_encode(array(
                'rc'  => 'ERR-BANK-UNKNOWN',
                'msg' => 'Collecting agent is not allowed by ' . $this->config->item('biller_name')
            ));
            $this->debugLog('RESPONSE: ' . $response);
            echo $response;
            exit();
        }

        // PERIKSA APAKAH KODE CHANNEL DIIZINKAN MENGAKSES WEBSERVICE INI
        if (!in_array($kodeChannel, $this->config->item('allowed_channels'))) {
            $response = json_encode(array(
                'rc'  => 'ERR-CHANNEL-UNKNOWN',
                'msg' => 'Channel is not allowed by ' . $this->config->item('biller_name')
            ));
            $this->debugLog('RESPONSE: ' . $response);
            echo $response;
            exit();
        }
        // PERIKSA APAKAH CHECKSUM VALID
        if (sha1($_JSON['nomorPembayaran'] . $this->config->item('secret_key') . $_JSON['tanggalTransaksi'] . $totalNominal . $nomorJurnalPembukuan) != $_JSON['checksum']) {
            $response = json_encode(array(
                'rc'  => 'ERR-SECURE-HASH',
                'msg' => 'H2H Checksum is invalid'
            ));
            $this->debugLog('RESPONSE: ' . $response);
            echo $response;
            exit();
        }
    }
}
                        
/* End of file bsi_model.php */