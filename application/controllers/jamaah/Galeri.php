<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Galeri extends CI_Controller
{
    public function index()
    {        
        $this->load->model('galeriJamaah');
        $data=$this->galeriJamaah->getRootDir();
        $result = ['data'=>$data];
        $this->load->view('jamaahv2/galeri',$result);
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
        $this->load->view('jamaahv2/kategori',$result);
    }
    public function vgaleri($folder, $file) {
        $this->load->model('galeriJamaah');
        $data=$this->galeriJamaah->getViewDir($folder, $file);
        $file1 = str_replace("_", " ", $file);
        $result = ['data'=>$data,
                   'file'=>$file1];
        $this->load->view('jamaahv2/galeri_view',$result);
    }

}