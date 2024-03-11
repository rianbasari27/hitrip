<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{

    public function get_sisa_seat($id)
    {
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage($id, false);
        if (!$paket) {
            return false;
        }

        if ($paket->publish == 1) {
            $sisaSeat = $paket->sisa_seat;
        }
        if ($paket->publish != 1) {
            $sisaSeat = 'Non-Aktif' ;
        }
        if ($paket->sisa_seat == 0) {
            $sisaSeat = 'Full';
        }

        echo json_encode($sisaSeat);
    }

    public function fetch_paket(){
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage(null,true,true,false,null,true);
        $partial= false;

        $data = ['paket' => $paket, 'partial' => $partial];
        $this->load->view('api/display_paket',$data);
    }

    public function fetch_tabel(){
        $this->load->model('paketUmroh');
        $this->load->model('api_cleaner');

        $lcu = (isset($_GET['lcu']))? (bool) $_GET['lcu']  : false;

        $paket = $this->paketUmroh->getPackage(null,true,true,false,null,true,$lcu);

        if(!empty($paket)){

            foreach($paket as $key => $p){
            
                $url = $this->api_cleaner->getMaskapaiIcon($p->maskapai);
                $paket[$key]->url = $url;
    
                $hotels = $this->api_cleaner->getHotel($p->hotel);
                $paket[$key]->hotels = $hotels;
    
                $keberangkatan = $this->date->convert("j F y", $p->tanggal_berangkat);
                $paket[$key]->keberangkatan = $keberangkatan;
    
                $bulan = explode(' ',$keberangkatan)[1];
                $paket[$key]->bulan = $bulan;
            }
        }
        $this->load->model('api_cleaner');
        $this->load->library('secret_key');
        $idAgen = $this->secret_key->generate(1105);
        $data = [
            'paket' => $paket,
            'idAgen' => $idAgen
        ];

        if($lcu){
            $this->load->view('api/display_paket_lcu',$data);

        } else {
            $this->load->view('api/tabel_paket',$data);
        }
    }


    // public function test_blast() {
    //     $this->load->model('whatsapp');
    //     $jamaah = $this->db->get('jamaah')->result();
    //     foreach ($jamaah as $j) {
    //         if ($j->no_wa != NULL) {
    //             $this->whatsapp->send($j->no_wa, "blast_urgent");
    //         }
    //     }

    //     $this->load->model('agen');
    //     $agen = $this->agen->getAgen();
    //     foreach ($agen as $a) {
    //         if ($a->no_wa != null) {
    //             $this->whatsapp->send($a->no_wa, "blast_urgent");
    //         }
    //     }
    // }

    // public function test() {
    //     $this->load->model('komisiConfig');
    //    $result = $this->komisiConfig->insertPoinPribadi();
    //    echo '<pre>';
    //    print_r($result);
    //    exit();
    // }

    function getPrayerTimes($cityId, $date) {
        // URL API
        $apiUrl = "https://api.myquran.com/v2/sholat/jadwal/{$cityId}/{$date}";
        // Inisialisasi cURL
        $ch = curl_init();
    
        // Set opsi cURL
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
        // Eksekusi cURL dan dapatkan hasil
        $result = curl_exec($ch);
    
        // Tutup koneksi cURL
        curl_close($ch);
    
        // Mengembalikan hasil dalam bentuk JSON
        return json_decode($result);
    }

    public function getKota($lang, $long) {
        // URL API
        $api_url = "https://api.aladhan.com/v1/timings/07-02-2024?latitude=$lang&longitude=$long&method=20&tune=4,4,4,4,5,5,4,5";
        // Inisialisasi cURL
        $ch = curl_init($api_url);
        // Set beberapa opsi cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Jika API memerlukan header tertentu, tambahkan di sini
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Header-Name: Header-Value'));

        // Eksekusi cURL dan dapatkan hasil
        $response = curl_exec($ch);

        // Tutup koneksi cURL
        curl_close($ch);

        // Menampilkan hasil dalam bentuk JSON
        $result = json_decode($response) ;

        return $result;
    }

    public function solat() {
        $lang = $this->input->get("lang");
        $long = $this->input->get("long");

        $kota = $this->getKota($lang, $long);
        echo json_encode($kota);
    }

    public function view_solat() {
        $this->load->view('jamaahv2/jadwal_sholat');
    }
}

/* End of file Api.php */