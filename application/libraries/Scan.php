<?php

class Scan
{

    protected $CI;

    // We'll use a constructor, as you can't directly call a function
    // from a property definition.
    public function __construct()
    {
        // Assign the CodeIgniter super-object
        $this->CI = &get_instance();
    }

    public function check($file, $doc, $id)
    {

        $target = $this->getName($doc, $id);
        $target_file = str_replace(' ', '_', $target . $file['name']);
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Allow certain file formats
        $formats = array("jpg", "png", "jpeg", "gif");
        if (in_array($doc, array(
            'tiket', 'itinerary', 'paket_info', 'imigrasi', 'kemenag', 'paspor', 'ktp',
            'visa', 'vaksin', 'bayar', 'mou_doc', 'upload_penyakit', 'paket_flyer', 'kk',
            'foto', 'scan_paspor2', 'foto_diri'
        ))) {
            $formats[] = "pdf";
        } else {
            // Check if image file is a actual image or fake image
            $check = getimagesize($file["tmp_name"]);
            if ($check == false) {
                $this->CI->alert->set('danger', 'File bukan gambar');
                return false;
            }
        }

        if (!in_array($fileType, $formats)) {
            // "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $this->CI->alert->set('danger', 'Tipe File tidak diijinkan');
            return false;
        }

        // Start Upload permanently
        if (move_uploaded_file($file["tmp_name"], SITE_ROOT . $target_file)) {
            return $target_file;
        } else {
            $this->CI->alert->set('danger', 'Upload gagal');
            return false;
        }
    }

    public function getName($doc, $id)
    {
        $this->CI->load->model('registrasi');
        $this->CI->load->model('paketUmroh');
        $this->CI->load->model('agenPaket');
        $this->CI->load->model('bcast');
        $this->CI->load->model('api_model');
        $this->CI->load->model('store');
        switch ($doc) {
            case 'paspor':
                $jamaah = $this->CI->registrasi->getUser($id);
                $targetDir = "/uploads/paspor/";
                $target_file = $targetDir . $jamaah->name. '_' . $jamaah->no_ktp . '_' . time() . '_';
                break;
            case 'paspor2':
                $jamaah = $this->CI->registrasi->getUser($id);
                $targetDir = "/uploads/paspor/";
                $target_file = $targetDir . $jamaah->name. '_' . $jamaah->no_ktp . '_paspor_2_' . time() . '_';
                break;
            case 'ktp':
                $jamaah = $this->CI->registrasi->getUser($id);
                $targetDir = "/uploads/ktp/";
                $target_file = $targetDir . $jamaah->name. '_' . $jamaah->no_ktp . '_' . time() . '_';
                break;
            case 'foto':
                $jamaah = $this->CI->registrasi->getUser($id);
                $targetDir = "/uploads/foto/";
                $target_file = $targetDir . $jamaah->name. '_' . $jamaah->no_ktp . '_' . time() . '_';
                break;
            case 'bayar':
                $jamaah = $this->CI->registrasi->getUser($id);
                $targetDir = "/uploads/bayar/";
                $target_file = $targetDir . $jamaah->name. '_' . $jamaah->no_ktp . '_' . time() . '_';
                $target_file = $target_file . time() . '_';
                break;
            case 'visa':
                $jamaah = $this->CI->registrasi->getUser($id);
                $targetDir = "/uploads/visa/";
                $target_file = $targetDir . $jamaah->name. '_' . $jamaah->no_ktp . '_' . time() . '_';
                break;
            case 'kk':
                $jamaah = $this->CI->registrasi->getUser($id);
                $targetDir = "/uploads/kk/";
                $target_file = $targetDir . $jamaah->name. '_' . $jamaah->no_ktp . '_' . time() . '_';
                break;
            case 'tiket':
                $jamaah = $this->CI->registrasi->getUser($id);
                $targetDir = "/uploads/tiket/";
                $target_file = $targetDir . $jamaah->name. '_' . $jamaah->no_ktp . '_' . time() . '_';
                break;
            case 'vaksin':
                $jamaah = $this->CI->registrasi->getUser($id);
                $targetDir = "/uploads/vaksin/";
                $target_file = $targetDir . $jamaah->name. '_' . $jamaah->no_ktp . '_' . time() . '_';
                break;
            case 'paket_info':
                $paket = $this->CI->paketUmroh->getPackage($id);
                $targetDir = "/uploads/paket_info/";
                $target_file = $targetDir . $paket->nama_paket . '_' . $paket->tanggal_berangkat . '_' . time() . '_';
                break;
            case 'itinerary':
                $paket = $this->CI->paketUmroh->getPackage($id);
                $targetDir = "/uploads/itinerary/";
                $target_file = $targetDir . $paket->nama_paket . '_' . $paket->tanggal_berangkat . '_' . time() . '_';
                break;
            case 'agen_pic':
                $agen = $this->CI->api_model->getAgen($id);
                $targetDir = "/uploads/agen_pic/";
                $target_file = $targetDir . $agen->nama_agen . '_' . $agen->id_agen . '_' . time() . '_';
                break;
            case 'banner_image':
                $targetDir = "/uploads/banner_image/";
                $target_file = $targetDir . 'paket_' . time() . '_';
                break;
            case 'gallery_image':
                $targetDir = "/uploads/gallery_image/";
                $target_file = $targetDir . 'paket_' . time() . '_';
                break;
            case 'foto_hotel':
                $targetDir = "/uploads/hotel_image/";
                $target_file = $targetDir . 'hotel_' . time() . '_';
                break;
            case 'imigrasi':
                $imigrasi = Date('d F Y');
                $targetDir = "/uploads/imigrasi/";
                $target_file = $targetDir . $imigrasi . '_' . time() . '_';
                break;
            case 'kemenag':
                $kemenag = Date('d F Y');
                $targetDir = "/uploads/kemenag/";
                $target_file = $targetDir . $kemenag . '_' . time() . '_';
                break;
            case 'agen_pic':
                $targetDir = "/uploads/agen_pic/";
                $target_file = $targetDir . '_' . time() . '_';
                break;
            case 'perlengkapan_pic':
                $targetDir = "/uploads/perlengkapan_pic/";
                $target_file = $targetDir . '_' . time() . '_';
                break;
            case 'mou_doc':
                $agen = $this->CI->api_model->getAgen($id);
                $targetDir = "/uploads/mou_doc/";
                $target_file = $targetDir . $agen->nama_agen . '_' . $agen->id_agen . '_' . time() . '_';
                break;
            case 'upload_penyakit':
                $targetDir = "/uploads/upload_penyakit/";
                $target_file = $targetDir . '_' . time() . '_';
                break;
            case 'lebih_bayar':
                $targetDir = "/uploads/lebih_bayar/";
                $target_file = $targetDir . '_' . time() . '_';
                break;
            case 'paket_flyer':
                $paket = $this->CI->paketUmroh->getPackage($id);
                $targetDir = "/uploads/paket_flyer/";
                $target_file = $targetDir . $paket->nama_paket . '_' . $paket->tanggal_berangkat . '_' . time() . '_';
                break;
            case 'agen_paket_flyer':
                $agenPaket = $this->CI->agenPaket->getAgenPackage($id);
                $targetDir = "/uploads/paket_flyer/";
                $target_file = $targetDir . $agenPaket->nama_paket . '_' . $agenPaket->tanggal . '_' . time() . '_';
                break;
            case 'agen_gambar_banner':
                $agenPaket = $this->CI->agenPaket->getAgenPackage($id);
                $targetDir = "/uploads/banner_image/";
                $target_file = $targetDir . $agenPaket->nama_paket . '_' . $agenPaket->tanggal . '_' . time() . '_';
                break;
            case 'flyer_image':
                // $broadcast = $this->CI->bcast->getPesanAgen($id);
                $targetDir = "/uploads/flyer_broadcast/";
                $target_file = $targetDir . '_' . '_' . time() . '_';
                break;
            case 'foto_diri':
                // $broadcast = $this->CI->bcast->getPesanAgen($id);
                $targetDir = "/uploads/foto_diri_konsultan/";
                $target_file = $targetDir . '_' . '_' . time() . '_';
                break;
            case 'bayar_konsultan':
                $agen = $this->CI->db->join('agen a', 'a.id_agen = app.id_agen')
                    ->where('id_agen_peserta', $id)
                    ->get('agen_peserta_paket app')
                    ->row();
                $targetDir = "/uploads/bayar_konsultan/";
                $target_file = $targetDir . $agen->nama_agen . "_" . time() . "_";
                break;
            case 'product_image':
                $targetDir = "/uploads/product_image/";
                $target_file = $targetDir . "_" . time() . "_";
                break;
            case 'store_banner':
                $targetDir = "/uploads/store_banner/";
                $target_file = $targetDir . "_" . time() . "_";
                break;
            case 'bayar_store':
                $order = $this->CI->store->getStoreOrders($id);
                $customer = $this->CI->store->getCustomer($order[0]->customer_id);
                $customer = $customer[0];
                if ($customer->jenis == "j") {
                    $jamaah = $this->CI->registrasi->getUser(null, null, $customer->id_user);
                    $nama = implode(' ', array_filter([$jamaah->first_name, $jamaah->second_name, $jamaah->last_name]));
                } else {
                    $agen = $this->CI->agen->getAgen($customer->id_user);
                    $nama = $agen[0]->nama_agen;
                }
                $targetDir = "/uploads/bayar_store/";
                $target_file = $targetDir . "_". $nama . "_" . time() . "_";
                break;
            case 'foto_status':
                $targetDir = "/uploads/foto_status/";
                $target_file = $targetDir . "_" . time() . "_";
                break;
        }
        return $target_file;
    }
}