<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Poin_bulan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }
        //this page only for admin
        if (!($_SESSION['bagian'] == 'Admin' || $_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Manifest')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
    }

    public function index(){        
        $this->load->model('paketUmroh');
        if (isset($_GET['month'])) {
            $month = $_GET['month'];
        } else {
            $month = null;
        }
        $paket = $this->paketUmroh->getPackage(null, true, true, true, $month, true);
        $availableMonths = $this->paketUmroh->getAvailableMonths(true, true, true);
        foreach ($paket as $key => $p) {
            $paket[$key]->detailLink = base_url() . "staff/detail_paket?id=" . $p->id_paket;
        }
        $data = [
            'paket' => $paket,
            'availableMonths' => $availableMonths,
            'monthSelected' => $month,
        ];   
        $this->load->view('staff/poin_perbulan', $data); 
    }
    

}
?>