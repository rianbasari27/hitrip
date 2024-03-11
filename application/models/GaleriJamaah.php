<?php

class GaleriJamaah extends CI_Model
{
    public function getRootDir()
    {
        $dirname = SITE_ROOT . "/asset/appkit/images/ventour/galeri/";
        $galeriurl = base_url() . "asset/appkit/images/ventour/galeri/";
        $dir = scandir($dirname);
        unset($dir[0]);
        unset($dir[1]);
        $data = [];
        foreach ($dir as $d) {
            $directory = $d;
            $title = str_replace("_", " ", $d);
            $dirkategori = scandir($dirname . $d);
            if (isset($dirkategori[2])) {
                $fotolist = scandir($dirname . $d . "/" . $dirkategori[2]);
                if (isset($fotolist[2])) {
                    $thumbnail = $galeriurl . $d . "/" . $dirkategori[2] . "/" . $fotolist[2];
                } else {
                    $thumbnail = ' ';
                }
            }
            $data[] = [
                "directory" => $directory,
                "title" => $title,
                "thumbnail" => $thumbnail
            ];
        }
        return $data;
    }
    public function getKategoriDir($folder)
    {
        $dirname = SITE_ROOT . "/asset/appkit/images/ventour/galeri/" . $folder . '/';
        $galeriurl = base_url() . "asset/appkit/images/ventour/galeri/" . $folder . '/';
        $dir = scandir($dirname);
        $director = $folder;
        $head = str_replace("_", " ", $director);
        unset($dir[0]);
        unset($dir[1]);
        if ($dir == NULL) {
            $list = ' ';
        } else {
            $list = scandir($dirname . $dir[2]);
        }
        $data = [];
        if (isset($list[2])) {
            $thumbnail_ = $galeriurl . $dir[2] . '/' . $list[2];
        } else {
            $thumbnail_ = ' ';
        }
        foreach ($dir as $direct) {
            $directory = $direct;
            $title = str_replace("_", " ", $direct);
            $fotolist = scandir($dirname . $direct);
            if (isset($fotolist[2])) {
                $thumbnail = $galeriurl . $direct . "/" . $fotolist[2];
            } else {
                $thumbnail = ' ';
            }
            $data[] = [
                "head" => $head,
                "director" => $director,
                "directory" => $directory,
                "title" => $title,
                "thumbnail" => $thumbnail
            ];
        }
        // echo "<pre>";
        // print_r($data);
        // exit();
        return $data;
    }
    public function getViewDir($folder, $file)
    {
        $dirname = SITE_ROOT . "/asset/appkit/images/ventour/galeri/" . $folder . "/" . $file . "/";
        $galeriurl = base_url() . "asset/appkit/images/ventour/galeri/" . $folder . "/" . $file . "/";
        $title = str_replace("_", " ", $file);
        $dir = scandir($dirname);
        unset($dir[0]);
        unset($dir[1]);
        $no = 2;
        $data = [];
        foreach ($dir as $direct) {
            $fotolist = $dir;
            if (isset($fotolist[$no])) {
                $view = $galeriurl . $fotolist[$no++];
            } else {
                $view = null;
            }
            $data[] = ["view" => $view];
        }
        // echo "<pre>";
        // print_r($data);
        // exit();
        return $data;
    }

    public function getPromoBanner()
    {
        $dirname = SITE_ROOT . "/uploads/promo_banner/";
        $galeriurl = base_url() . "uploads/promo_banner/";
        $dir = scandir($dirname);
        unset($dir[0]);
        unset($dir[1]);
        $no = 2;
        $data = [];
        foreach ($dir as $direct) {
            $fotolist = $dir;
            if (isset($fotolist[$no])) {
                $view = $fotolist[$no++];
            } else {
                $view = null;
            }
            $data[] = ["view" => $view];
        }
        return $data;
    }

    public function getStoreBanner()
    {
        $dirname = SITE_ROOT . "/uploads/store_banner/";
        $galeriurl = base_url() . "uploads/store_banner/";
        $dir = scandir($dirname);
        unset($dir[0]);
        unset($dir[1]);
        $no = 2;
        $data = [];
        foreach ($dir as $direct) {
            $fotolist = $dir;
            if (isset($fotolist[$no])) {
                $view = $fotolist[$no++];
            } else {
                $view = null;
            }
            $data[] = ["view" => $view];
        }
        return $data;
    }
}
