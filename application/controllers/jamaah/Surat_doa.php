<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Surat_doa extends CI_Controller
{
    // public function __construct()
    // {
    //     parent::__construct();
    //     $this->load->model("auth");
    //     $this->load->model('konsultanAuth');
    //     if (!$this->konsultanAuth->is_user_logged_in()) {
    //         redirect(base_url() . 'konsultan/login');
    //     }
    // }

    public function index()
    {
        $this->load->model('api_model');
        $this->load->model('bookmarkQuran');
        $surat = $this->api_model->getListSurat();
        $data = [
            'surat' => $surat
        ];
        $this->load->view('jamaah/list_surat_jamaah', $data);
    }

    public function surat($nomor)
    {
        $this->load->model('api_model');
        $this->load->model('bookmarkQuran');
        $data = $this->api_model->getListSurat($nomor);
        // echo '<pre>';
        // print_r($data);
        // exit();
        $this->load->view('jamaah/jamaah_surat_view', $data);
    }

    public function tandai_ayat()
    {
        if ($_POST['userId'] == null) {
            redirect($_SERVER['HTTP_REFERER']);
            $this->alert->setJamaah('Oops...', 'red', 'Access Denied!');
        }
        $this->load->model('bookmarkQuran');
        $bookmarkBefore = $this->bookmarkQuran->getBookmarkQuran($_POST['userId']);
        $data = [
            'user_id' => $_POST['userId'],
            'ayat' => $_POST['nomorAyat'],
            'no_surat' => $_POST['nomorSurat'],
        ];
        $addBookmark = $this->bookmarkQuran->bookmarkAyat($data);
        if ($addBookmark != false) {
            $data = ['before' => $bookmarkBefore, 'after' => $addBookmark];
            echo json_encode($data);
        } else {
            return false;
        }
    }

    public function get_bookmark()
    {
        $this->load->model('bookmarkQuran');
        $bookmark = $this->bookmarkQuran->getBookmarkQuran($_POST['userId']);
        if ($bookmark != false) {
            $data = ['bookmark' => $bookmark];
            echo json_encode($data);
        } else {
            return false;
        }
    }

    public function doa()
    {
        $this->load->model('api_model');
        $doa = $this->api_model->getDoa();
        $data = [
            'doa' => $doa['result']
        ];
        $this->load->view('jamaah/doa_view', $data);
    }

    public function tasbih()
    {
        $this->load->view('jamaah/counter_tasbih_view');
    }
}
