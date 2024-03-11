<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        if (empty($this->input->get('id'))) {
            return false;
        }
        $idPaket = $this->input->get('id');
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage($idPaket, false);
        


        if (empty($paket)) {
            return false;
        }

        $jumlahSeat = $paket->jumlah_seat;

        $this->load->model('registrasi');
        $jamaah = $this->registrasi->getMember(null, null, $idPaket);
        if (empty($jamaah)) {
            $seatTerisi = 0;
        } else {
            $seatTerisi = count($jamaah);
        }

        $returnData = array(
            'quota' => $jumlahSeat,
            'terisi' => $seatTerisi
        );
        
        echo json_encode($returnData);
    }

}
