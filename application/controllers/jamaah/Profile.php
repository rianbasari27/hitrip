<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{    
    public function __construct()
    {
        parent::__construct();
        //check if logged in redirect to user page
        $this->load->model('customer');
        if (!$this->customer->is_user_logged_in()) {
            $this->alert->toastAlert('red', 'Anda perlu login');
            redirect(base_url() . 'jamaah/login');
        }
    }
    
    public function index()
    {
        //cek apakah sudah pernah menampilkan splash
        if (!$this->customer->isSplashSeen()) {
            redirect(base_url() . "jamaah/splash");
        }
        $this->load->model('registrasi');
        $data = $this->registrasi->getUser($_SESSION['id_user']);
        $this->load->view('jamaah/profile_view', $data);
    }

    public function edit_profile() {
        $this->load->model('registrasi');
        $data = $this->registrasi->getUser($_SESSION['id_user']);

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('name', 'fullname', 'required|trim');
        $this->form_validation->set_rules('no_wa', 'nomor telepon', 'required|trim');
        $this->form_validation->set_rules('email', 'email', 'required|trim');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('jamaah/edit_profile_view', $data);
        } else {
            $this->proses_edit_profile();
        }
    }

    public function proses_edit_profile() {
        
        $this->load->model('registrasi');
        if (!$this->registrasi->daftar($_POST, null, true)) {
            $this->alert->toastAlert('red', 'Gagal menyimpan');
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->alert->toastAlert('green', 'Berhasil menyimpan');
            redirect(base_url('jamaah/profile'));
        }
        
    }

    public function pic_ganti() {
        $this->load->model('registrasi');
        $user = $this->registrasi->getUser($_SESSION['id_user']);
        if(isset($_POST["image"]))
        {
            $data = $_POST["image"];
            $image_array_1 = explode(";", $data);
            $image_array_2 = explode(",", $image_array_1[1]);
            $data = base64_decode($image_array_2[1]);
            $imageName = $user->name . "profile". time() . '.png';
            $file = "/uploads/user_picture/". $imageName;
            if(!empty($user->profile_picture)) {
                unlink(SITE_ROOT . $user->profile_picture);
            }
            file_put_contents(SITE_ROOT . $file, $data);
            $image_file = addslashes(file_get_contents(SITE_ROOT . $file));
            
            $this->db->where('id_user', $user->id_user);
            $this->db->set('profile_picture', $file);
            $this->db->update('user');

            // $statement = $connect->prepare($query);
            // if($statement->execute())
            // {
            echo 'Profil berhasil diganti';
            // unlink($imageName);
            // }

        }
    }

    public function hapus_pic()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id_user', 'id_user', 'trim|required|integer');
        $this->form_validation->set_rules('field', 'field', 'required');

        if ($this->form_validation->run() == FALSE) {
            return false;
        }
        $this->load->model('registrasi');
        $result = $this->registrasi->deletePic($_GET['id_user'], $_GET['field']);
        if ($result == true) {
            echo json_encode(true);
        } else {
            return false;
        }
    }
    // public function main_menu()
    // {        
    //     $this->load->view('jamaahv2/include/menu-main');
    // }
    // public function colors()
    // {        
    //     $this->load->view('jamaahv2/include/menu-colors');
    // }
    // public function share()
    // {        
    //     $this->load->view('jamaahv2/include/menu-share');
    // }
}