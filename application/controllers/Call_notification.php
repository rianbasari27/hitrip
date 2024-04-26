<?php

use function GuzzleHttp\json_encode;

defined('BASEPATH') or exit('No direct script access allowed');

class Call_notification extends CI_Controller
{
    public function index() {
        $this->load->view('call_notification');
    }

    public function getToken() {
        $this->load->model('Notification');
        $result = $this->Notification->setToken($_GET['token'], $_GET['id'], $_GET['user']);
        if ($result == true) {
            return true;
        } else {
            return false;
        }
    }

    public function send() {
        $this->load->model('Notification');
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage(null, false);
        $this->Notification->sendEditPackageNotif($paket[0]->id_paket);
        redirect($_SERVER['HTTP_REFERER']);
    }
}