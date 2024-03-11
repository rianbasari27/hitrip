<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cron extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cron_model');
    }

    public function exec_setiap_jam() {
        $this->cron_model->delete_no_dp_member();
        $this->cron_model->send_dp();
    }

    public function exec_setiap_hari() {
        $this->cron_model->delete_diskon();
    }

    public function exec_setiap_hari_pagi() {
        $this->cron_model->selfReminder();
        $this->cron_model->message_tagihan();
        $this->cron_model->notif_pelunasan();
        $this->cron_model->notif_pelunasan2();
        $this->cron_model->notif_pelunasan3();
        $this->cron_model->updateAgenPecahTelor();
        $this->cron_model->insertPoinPribadi();
    }

    public function exec_setiap_hari_malem() {
        $this->cron_model->delete_perlengkapan();
    }
    public function exec_setiap_hari_siang() {
        $this->cron_model->notif_pelunasan3();
    }
    public function exec_setiap_hari_sore() {
        $this->cron_model->notif_pelunasan2();
        $this->cron_model->notif_pelunasan3();
    }

}
        
    /* End of file  Cron.php */