<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cron_model extends CI_Model
{
    public function delete_no_dp_member()
    {
        $this->load->model('registrasi');
        $del = $this->registrasi->deleteNoDpMember();
        $this->write_log("delete_no_dp_member", $del);
    }

    public function write_log($name, $status) {
        $myfile = fopen("../../cron_log.txt", "w") or die("Unable to open file!");
        if ($status) {
            $txt = "success run $name on " . date("Y-m-d H:i:s");
        } else {
            $txt = "fail run $name on " . date('Y-m-d H:i:s');
        }
        fwrite($myfile, $txt);
        fclose($myfile);
    }

    public function selfReminder()
    {
        $this->load->model('reminder_model');
        $result = $this->reminder_model->otomatis_reminder();
        $this->write_log("selfReminder", $result);
    }

    public function delete_diskon()
    {
        $query = $this->db->query("UPDATE paket_umroh SET default_diskon = 0, deskripsi_default_diskon = NULL where id_paket IN 
        (SELECT dl.id_paket FROM discount_log dl JOIN
        (SELECT id_paket, max(id_log) logId FROM `discount_log` d_log GROUP BY id_paket  
        ORDER BY `d_log`.`id_paket` ASC) AS c_log ON c_log.logId = dl.id_log where tanggal_berakhir < DATE(NOW()) AND discount != 0)");

        $this->write_log('delete_diskon', $query);
        
    }

    public function cek_komisi()
    {

        $this->load->library('date');
        $hijr = $this->date->gregorianToHijri('1990-01-01');
        echo '<pre>';
        print_r($hijr);
        echo exit();
    }

    public function delete_perlengkapan() {
        $this->load->model('logistik');
        $del = $this->logistik->delPerlengkapanMember();
        $this->write_log("delete_perlengkapan", $del);
    }

    public function send_dp() {
        $this->load->model('Whatsapp');
        $del = $this->Whatsapp->sendMessageDp();
        $this->write_log("send_dp", $del);
    }

    public function message_tagihan() {
        $this->load->model('Whatsapp');
        $del = $this->Whatsapp->sendMessageTagihan();
        $this->write_log("message_tagihan", $del);
        
    }

    public function notif_pelunasan() {
        $this->load->model('notification');
        $notif = $this->notification->sendNotifPelunasan();
        $this->write_log("notif_pelunasan2", $notif);
    }

    public function notif_pelunasan2() {
        $this->load->model('notification');
        $notif = $this->notification->sendNotifPelunasan2();
        $this->write_log("notif_pelunasan2", $notif);
    }

    public function notif_pelunasan3() {
        $this->load->model('notification');
        $notif = $this->notification->sendNotifPelunasan3();
        $this->write_log("notif_pelunasan2", $notif);
    }

    public function updateAgenPecahTelor() {
        $this->load->model('komisiConfig');
        $data = $this->komisiConfig->updatePecahTelorAgen();
        $this->write_log("update_pecah_telor", $data);
    }

    public function insertPoinPribadi() {
        $this->load->model('komisiConfig');
        $data = $this->komisiConfig->insertPoinPribadi();
        $this->write_log("insert_poin_pribadi", $data);
    }
}