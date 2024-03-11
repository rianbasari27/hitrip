<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Bsi_model_close extends CI_Model
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
        // PARAMATER DI BAWAH INI ADALAH VARIABEL YANG DITERIMA DARI BSI
        $kodeBank         = $_JSON['kodeBank'];
        $kodeChannel      = $_JSON['kodeChannel'];
        $kodeBiller       = $_JSON['kodeBiller'];
        $kodeTerminal     = $_JSON['kodeTerminal'];
        $nomorPembayaran  = $_JSON['nomorPembayaran'];
        $tanggalTransaksi = $_JSON['tanggalTransaksi'];
        $idTransaksi      = $_JSON['idTransaksi'];
        // $totalNominalInquiry = $_JSON['totalNominalInquiry'];

        $tagihan = $this->db->where('metode', 'BSI-VA')
            ->where('nomor_va', $nomorPembayaran)
            ->get('virtual_account')->row_array();
        // $this->debugLog($tagihan);

        //NOMOR NOT FOUND
        if (empty($tagihan)) {
            $response = array(
                'rc'  => 'ERR-NOT-FOUND',
                'msg' => 'Nomor Tidak Ditemukan'
            );
            return $response;
        }

        //NOMOR ALREADY PAID
        if ($tagihan['status_pembayaran'] == "SUKSES") {
            $response = array(
                'rc'  => 'ERR-ALREADY-PAID',
                'msg' => 'Nomor Sudah Pernah Dibayarkan'
            );
            return $response;
        }

        //CHECK IF EXPIRED
        $tanggalExpired = $tagihan['tanggal_expired'];
        $tanggalNow = date("Y-m-d H:i:s");
        if ($tanggalExpired < $tanggalNow) {
            $response = array(
                'rc'  => 'ERR-BILL-EXPIRED',
                'msg' => 'Nomor Tagihan Sudah Expired atau Kadaluarsa.'
            );
            return $response;
        }

        //CHECK IF NOMINAL IS > 0
        if ($tagihan['nominal_tagihan'] <= 0) {
            $response = array(
                'rc'  => 'ERR-DB',
                'msg' => 'Nominal Tagihan Salah Pada Sistem, Hubungi Admin Ventour.'
            );
            return $response;
        }

        //PREPARE INFORMASI
        $all_info = $tagihan['informasi'];
        $info1 = substr($all_info, 0, 30);
        $info2 = substr($all_info, 30, 30);
        $arr_informasi = [
            ['label_key' => 'Info1', 'label_value' => $info1],
            ['label_key' => 'Info2', 'label_value' => $info2],
        ];

        // PREPARE RINCIAN
        $this->load->model('registrasi');
        $member = $this->registrasi->getJamaah(null, null, $tagihan['id_member']);

        $nama = implode(" ", [$member->first_name, $member->second_name, $member->last_name]);

        $tanggalPaket = $member->member[0]->paket_info->tanggal_berangkat;

        $date = DateTime::createFromFormat('Y-m-d', $tanggalPaket);
        $tanggalPaketPretty = $date->format('d-m-Y');

        $namaPaket = $member->member[0]->paket_info->nama_paket . " " . $tanggalPaketPretty;

        $arr_rincian = [
            [
                "kode_rincian" => 'TAGIHAN',
                "deskripsi" => "Pembayaran " . $namaPaket,
                "nominal" => $tagihan['nominal_tagihan']
            ],
        ];

        $data_inquiry = [
            'rc' => 'OK',
            'msg' => 'Inquiry Succeeded',
            'nomorPembayaran' => $nomorPembayaran,
            'idPelanggan' => $member->member[0]->id_member,
            'nama' => $nama,
            'nomorHP' => $member->no_wa,
            'email' => $member->email,
            'totalNominal' => $tagihan['nominal_tagihan'],
            'informasi' => $arr_informasi,
            'rincian' => $arr_rincian,
            'idTagihan' => $nomorPembayaran,
        ];

        return $data_inquiry;
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

        $dataInquiry = $this->startInquiry($_JSON);
        if ($dataInquiry['rc'] != 'OK') {
            return $dataInquiry;
        }
        //CEK NOMINAL TAGIHAN
        if ($totalNominal != $dataInquiry['totalNominal']) {
            // APABILA [CLOSE PAYMENT]
            // MAKA NILAI TAGIHAN DI DALAM DATABASE HARUS SAMA DENGAN YANG DIBAYARKAN
            $response = array(
                'rc' => 'ERR-PAYMENT-WRONG-AMOUNT',
                'msg' => 'Terdapat kesalahan nilai pembayaran ' . $totalNominal . ' tidak sama
                            dengan tagihan ' . $dataInquiry['totalNominal']
            );
            return $response;
        }

        //CEK SISA PEMBAYARAN
        $this->load->model('tarif');
        $tarif = $this->tarif->getRiwayatBayar($dataInquiry['idPelanggan']);
        if ($totalNominal > $tarif['sisaTagihan']) {
            $response = array(
                'rc' => 'ERR-PAYMENT-WRONG-AMOUNT',
                'msg' => 'Terdapat kesalahan nilai pembayaran, nominal pembayaran ' . $totalNominal . ' lebih besar daripada sisa tagihan ' . $tarif['sisaTagihan'],
            );
            return $response;
        }

        //START PAYMENT TRANSACTION
        $this->db->trans_start();
        //update virtual_account table
        $data = [
            'nomor_jurnal_pembukuan' => $nomorJurnalPembukuan,
            'waktu_transaksi' => date("Y-m-d H:i:s"),
            'channel_pembayaran' => $kodeChannel,
            'status_pembayaran' => 'SUKSES',
        ];
        $this->db->where('nomor_va', $nomorPembayaran);
        $upd = $this->db->update('virtual_account', $data);
        if (!$upd) {
            $response = array(
                'rc' => 'ERR-UNDEFINED',
                'msg' => 'Gagal saat update pembayaran',
            );
            return $response;
        }

        $data = [
            'id_member' => $dataInquiry['idPelanggan'],
            'jumlah_bayar' => $totalNominal,
            'tanggal_bayar' => date('Y-m-d'),
            'cara_pembayaran' => 'BSI-VA',
            'nomor_referensi' => $nomorPembayaran,
            'keterangan' => implode(" ", [$dataInquiry['informasi'][0]['label_value'], $dataInquiry['informasi'][1]['label_value']]),
            'verified' => 1,
        ];
        $setBayar = $this->tarif->setPembayaran($data);
        if (!$setBayar) {
            $response = array(
                'rc' => 'ERR-UNDEFINED',
                'msg' => 'Gagal saat update pembayaran',
            );
            return $response;
        }
        $this->db->trans_complete();

        $dataPayment = $dataInquiry;
        $dataPayment['msg'] = 'Payment Succeeded';
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
