<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Tentang_kami extends CI_Controller
{
    // public function __construct()
    // {
    //     parent::__construct();
    //     $this->load->model('konsultanAuth');
    //     if (!$this->konsultanAuth->is_user_logged_in()) {
    //         redirect(base_url() . 'konsultan/login');
    //     }
    // }

    public function index()
    {
        $this->load->model('galeriJamaah');
        $data=$this->galeriJamaah->getRootDir();
        $result = ['data'=>$data];
        $this->load->view('konsultan/galeri',$result);
    }

    public function profile()
    {        
        $this->load->view('konsultan/profile_view');
    }

    public function layanan()
    {        
        $this->load->view('konsultan/paket_layanan_view');
    }

    public function kontak()
    {
        $arr = [];
        for ($i = 0 ; $i < 7 ; $i++) {
            $arr[$i] = [
                'days' => date('l', strtotime("+$i days"))
            ];
        }
        $this->load->view('konsultan/kontak_kami', $data = ['arr' => $arr]);
    }

    public function kategori($folder) {
        $this->load->model('galeriJamaah');
        $data=$this->galeriJamaah->getKategoriDir($folder);
        $dirname = SITE_ROOT. "/asset/appkit/images/ventour/galeri/". $folder . '/';
        $galeriurl = base_url(). "asset/appkit/images/ventour/galeri/". $folder . '/';
        $dir = scandir($dirname);
        unset($dir[0]);
        unset($dir[1]);
        $folder1 = str_replace("_", " ", $folder);
        if ($dir == NULL) {
            $list = ' ';
        } else {
            $list = scandir($dirname . $dir[2]);
        }
        if(isset($list[2])) {
            $thumbnail_ = $galeriurl. $dir[2] . '/'. $list[2];
        }else {
            $thumbnail_ = ' ' ;
        }
        // unset($data['thumbnail_']);
        $result = ['data'=>$data, 
                   'folder'=>$folder1,
                    'thumbnail_'=>$thumbnail_];
        $this->load->view('konsultan/kategori',$result);
    }

    public function vgaleri($folder, $file) {
        $this->load->model('galeriJamaah');
        $data=$this->galeriJamaah->getViewDir($folder, $file);
        $file1 = str_replace("_", " ", $file);
        $result = ['data'=>$data,
                   'file'=>$file1];
        $this->load->view('konsultan/galeri_view',$result);
    }
}
        
    /* End of file  Tentang_kami.php */