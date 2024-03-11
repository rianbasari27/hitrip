<?php

class GaleriStaff extends CI_Model
{
    public function getRootDir () {
        $dirname = SITE_ROOT. "/asset/appkit/images/ventour/galeri/";
        $galeriurl = base_url()."asset/appkit/images/ventour/galeri/";
        $dir = scandir($dirname) ;
        unset($dir[0]);
        unset($dir[1]);
        $data = [];
        foreach($dir as $d) {
            $directory=$d;
            $title = str_replace("_", " ", $d);
            $dirkategori = scandir($dirname. $d);
            $data[] = ["directory"=> $directory, 
                       "title"=>$title,
                       "dirname"=> $dirname];
        }
            return $data ;
    
    }
    public function getKategoriDir($folder) {
        $dirname = SITE_ROOT. "/asset/appkit/images/ventour/galeri/". $folder . '/';
        $galeriurl = base_url(). "asset/appkit/images/ventour/galeri/". $folder . '/';
        $dir = scandir($dirname);
        $director = $folder ;
        unset($dir[0]);
        unset($dir[1]);
        $data = [] ;
        foreach($dir as $direct) {
            $directory = $direct ;
            $title = str_replace("_", " ", $direct);
            $data['isi'][] = ["director"=>$director,
                       "directory"=>$directory,
                       "title"=>$title];
        }
        // echo "<pre>";
        // print_r($data);
        // exit();
        return $data ;
    }
    public function getViewDir($folder,$file) {
        $dirname = SITE_ROOT. "/asset/appkit/images/ventour/galeri/". $folder ."/". $file."/" ;
        $galeriurl = base_url(). "asset/appkit/images/ventour/galeri/". $folder ."/". $file . "/" ;
        $title = str_replace("_", " ", $file) ;
        $dir = scandir($dirname);
        unset($dir[0]) ;
        unset($dir[1]);
        $no = 2 ;
        $data = [];
        foreach($dir as $direct) {
            $fotolist = $dir;
            if(isset($fotolist[$no])) {
                $view = $galeriurl. $fotolist[$no++];
            } else {
                $view = null;
            }
            $data['img'][] = ["view"=>$view];
        }
        return $data ;
    }
}