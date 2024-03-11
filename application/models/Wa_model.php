<?php

class Wa_model extends CI_Model
{

    public function getNumberPackages($id_paket)
    {
        $this->load->model('tarif');
        $this->load->library('wa_number');
        $this->load->library('money');
        $this->load->model('paketUmroh');
        $this->load->library('date');
        $payments = $this->tarif->getPaymentsForPackage($id_paket);
        $data = [];
        if (!empty($payments['list'])) {
            foreach ($payments['list'] as $p) {
                $message = $this->config->item('template_wa_penagihan');
                $number = $this->wa_number->convert($p->jamaah->no_wa);
                $paket = $this->paketUmroh->getPackage($p->id_paket, false, false);
                $nama = $p->jamaah->first_name . " " . $p->jamaah->second_name . " " . $p->jamaah->last_name;
                $tgl = $this->date->convert_date_indo($paket->tanggal_berangkat);
                $group = $paket->nama_paket . " ( $tgl )";
                $outstanding = $this->money->format($p->payments['kurangBayar']);

                $message = str_replace("(NAMA)", "$nama", $message);
                $message = str_replace("(GROUP)", "$group", $message);
                $message = str_replace("(OUTSTANDING)", "$outstanding", $message);
                if ($p->lunas != '1') {
                    $data[] = array(
                        'no_wa' => $number,
                        'message' => $message
                    );
                }
            }

            // hapus data yang tidak ada nomornya
            foreach ($data as $key => $d) {
                if ($d['no_wa'] == '-') {
                    unset($data[$key]);
                }
            }
            //////

        } else {
            return false;
        }
        return true;
    }
    public function test()
    {
        $this->load->model('whatsapp');
        $this->whatsapp->send();
    }
}
