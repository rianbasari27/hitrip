<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Upload_promo extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }
        //this page for master admin, manifest and finance
        if (!($_SESSION['bagian'] == 'Master Admin')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
    }
    
    public function index() {
        $this->load->model('galeriJamaah');
        $promo = $this->galeriJamaah->getPromoBanner();
        $data = array (
            'promo' => $promo
        );
        $this->load->view('staff/banner_promo_view', $data);
    }

    public function tambah() {
        $this->load->view('staff/form_input_banner');
    }

    public function proses_tambah() {
    $this->target_dir = SITE_ROOT. "/uploads/promo_banner/" ;
        if ($this->input->post('upload')) {
            $number_of_files = sizeof($_FILES['foto']['tmp_name']);
            $files = $_FILES['foto'];
            
            $config['upload_path'] = $this->target_dir;
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']  = 200000;
            $config['max_width']  = 200000;
            $config['max_height']  = 200000;

            $this->load->library('upload', $config);
            
            for ($i = 0; $i < $number_of_files; $i++) {
                $_FILES['foto']['name'] = $files['name'][$i];
                $_FILES['foto']['type'] = $files['type'][$i];
                $_FILES['foto']['tmp_name'] = $files['tmp_name'][$i];
                $_FILES['foto']['error'] = $files['error'][$i];
                $_FILES['foto']['size'] = $files['size'][$i];

                $this->upload->initialize($config);

                $this->upload->do_upload('foto');
            }
            $this->alert->set('success', 'Foto berhasil ditambahkan');
            redirect(base_url() . 'staff/upload_promo');
        }
    }

    public function hapus() {
        if (isset($_GET['id'])) {
            unlink(SITE_ROOT . '/uploads/promo_banner/' . $_GET['id']); // hapus file
            $this->alert->set('success' , 'Foto berhasil dihapus');
        } else {
            $this->alert->set('danger' , 'Foto gagal dihapus');
        }
        redirect(base_url() . 'staff/upload_promo');
    }
    
    public function hapus_all(){
        $files = glob(SITE_ROOT. "/uploads/promo_banner/*");
        //mengecek folder  
        foreach ($files as $f) {
            if (is_file($f)) {
                unlink($f); // hapus file
            } else {
                $this->alert->set('danger', "Foto gagal dihapus ");
            }
        }
        $this->alert->set('success', "Foto berhasil dihapus ");
        redirect($_SERVER['HTTP_REFERER']);
    }
}