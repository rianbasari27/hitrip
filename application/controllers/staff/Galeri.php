<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Galeri extends CI_Controller {

    public function index() {
        $this->load->model('galeriStaff');
        $data=$this->galeriStaff->getRootDir();
        $result = ['data'=>$data];
        $this->load->view('staff/input_galeri', $result);
    }

    public function tambah_view() {
        $this->load->view('staff/form_input_folder');
    }

    public function tambah_folder() {
        $this->load->model('galeriJamaah');
        $data=$this->galeriJamaah->getRootDir();
        $nama = preg_replace("([^\w\s\d\-_~,;:\[\]\(\].]|[\.]{2,})", ' ', $_POST["nama_folder"]);
        $nama_folder = str_replace(' ', '_', $nama);
        if((file_exists($nama_folder))&&(is_dir($nama_folder))) 
            { 
                $this->alert->set('danger', "Folder " . $nama . " Sudah ada");
                redirect(base_url() . 'staff/galeri');
            }else 
            { 
            $dirname = SITE_ROOT. "/asset/appkit/images/ventour/galeri/";
            mkdir ($dirname. $nama_folder );
            $this->alert->set('success', "Folder " . $nama . " Berhasil dibuat");
            redirect(base_url() . 'staff/galeri');
        };
    }

    public function kategori($folder) {
        $this->load->model('galeriStaff');
        $data=$this->galeriStaff->getKategoriDir($folder);
        $nama_folder = str_replace('_', ' ', $folder);
        $result = ['data'=>$data,
                   'folder'=>$folder,
                   'nama_folder'=>$nama_folder];
        $this->load->view('staff/kategori',$result);
    }

    public function tambahv2_view($folder) {
        $result = ['folder'=>$folder];
        $this->load->view('staff/form_input_kategori', $result);
    }

    public function tambahv2_folder() {

        $this->load->model('galeriStaff');
        $data=$this->galeriStaff->getKategoriDir();
        $nama = preg_replace("([^\w\s\d\-_~,;:\[\]\(\].]|[\.]{2,})", ' ', $_POST["folder_kategori"]);
        $nama_folder = str_replace(' ', '_', $nama);
        if((file_exists($nama_folder))&&(is_dir($nama_folder)))
            { 
                $this->alert->set('danger', "Folder " . $nama . " Sudah ada");
                redirect(base_url() . 'staff/galeri/kategori'. $_POST["directory"]);
            } else 
            { 
            $dirname = SITE_ROOT. "/asset/appkit/images/ventour/galeri/". $_POST['directory'] . "/";
            mkdir ($dirname . $nama_folder);
            $this->alert->set('success', "Folder " . $nama . " Berhasil dibuat");
            redirect(base_url() . 'staff/galeri/kategori/'. $_POST['directory']);
        };
    }

    public function foto($folder, $file) {
        $result = ['folder'=>$folder,
                   'file'=>$file];
        $this->load->view('staff/form_input_foto', $result);
    }
    
    public function vgaleri($folder, $file) {
        $this->load->model('galeriStaff');
        $data=$this->galeriStaff->getViewDir($folder, $file);
        $nama_file = str_replace('_', ' ', $file);
        $result = ['data'=>$data,
                   'file' => $file,
                   'folder' => $folder,
                   'nama_file'=> $nama_file];
        $this->load->view('staff/galeri_view',$result);
    }
    
    public function rename_dir($folder) {
        $nama = str_replace("_", " ", $folder) ;
        $result = ['nama' => $nama, 'folder' => $folder];
        $this->load->view('staff/form_rename_dir', $result);
    }

    public function form_edit_dir() {
        $pesan_error = array();
        $berhasil="";
        $_POST['path'] = SITE_ROOT. "/asset/appkit/images/ventour/galeri" ;

        $path = getcwd();
        if(isset($_POST['ubah_folder']))
        {
            if(empty($_POST['folder_lama']) &&empty($_POST['folder_baru']))
            {
                array_push($pesan_error, "Masukan nama folder lama/baru");
            }
            else
            {
                $folder = $_POST['folder_lama'];
                $folder1 = str_replace("_", " ", $folder);
                $folder_lama = SITE_ROOT. "/asset/appkit/images/ventour/galeri/". $folder ;
                $folderv2 = str_replace(" ", "_", $_POST['folder_baru']);
                $folder_baru = SITE_ROOT. "/asset/appkit/images/ventour/galeri/". $folderv2 ;
            }
            if(count($pesan_error)==0)
            {
                if(is_dir($folder_lama)) //cek apakah folder lama atau tidak
                {
                    if(rename($folder_lama, $folder_baru))
                    {
                        $this->alert->set('success', "Folder " . $folder1 . " Berhasil di Ubah menjadi ". $_POST['folder_baru']);
                        redirect(base_url() . 'staff/galeri');
                    }
                    else
                    {
                        $this->alert->set('danger', "Folder Galgal di Ubah");
                        redirect(base_url() . 'staff/galeri');
                    }
                }
                else
                {
                    $this->alert->set('danger', " Folder " . $folder1 . "Tidak Ditemukan ");
                    redirect(base_url() . 'staff/galeri');
                }
            }
        }
    }
    
    public function rename_kg($folder, $file) {
        $nama = str_replace("_", " ", $file) ;
        $this->load->model('galeriStaff');
        $data=$this->galeriStaff->getKategoriDir($folder, $file);
        $result = ['data'=>$data,
                   'folder'=>$folder, 'nama' => $nama, 'file' => $file];
        $this->load->view('staff/form_rename_kg', $result);
    }

    public function form_rename_kg() {
        $folderv2 = str_replace(" ", "_", $_POST['folder_baru']);

        $pesan_error = array();
        $berhasil="";
        $_POST['path'] = SITE_ROOT. "/asset/appkit/images/ventour/galeri" ;
        $path = getcwd();
        if(isset($_POST['ubah_folder']))
        {
            if(empty($_POST['folder_lama']) &&empty($_POST['folder_baru']))
            {
                array_push($pesan_error, "Masukan nama folder lama/baru");
            }
            else
            {
                $folder = $_POST['file'];
                $folder1 = str_replace("_", " ", $folder);
                $folder_old = SITE_ROOT. "/asset/appkit/images/ventour/galeri/". $_POST['folder_lama'] . "/" . $folder ;
                $folder_new = SITE_ROOT. "/asset/appkit/images/ventour/galeri/". $_POST['folder_lama'] . "/" . $folderv2 ;

            }
            if(count($pesan_error)==0)
            {
                if(is_dir($folder_old)) //cek apakah folder lama atau tidak
                {
                    if(rename($folder_old, $folder_new))
                    {
                        $this->alert->set('success', "Folder " . $folder1 . " Berhasil di Ubah menjadi ". $_POST['folder_baru']);
                        redirect(base_url(). 'staff/galeri/kategori/' . $_POST['folder_lama']);
                    }
                    else
                    {
                        $this->alert->set('danger', "Folder Galgal di Ubah");
                        redirect(base_url(). 'staff/galeri/kategori/' . $_POST['folder_lama']);
                    }
                }
                else
                {
                    $this->alert->set('danger', " Folder " . $folder1 . "Tidak Ditemukan ");
                    redirect(base_url(). 'staff/galeri/kategori/' . $_POST['folder_lama']);
                }
            }
        }

    }

    public function hapus_dir($folder){
    $folder1 = str_replace("_", " ", $folder);
    $nama_folder = SITE_ROOT. "/asset/appkit/images/ventour/galeri/". $folder;
    $files = glob(SITE_ROOT. "/asset/appkit/images/ventour/galeri/". $folder . "/*");
    $files1 = glob(SITE_ROOT. "/asset/appkit/images/ventour/galeri/". $folder . "/*" . "/*");

    //mengecek folder  
    if((file_exists($nama_folder))&&(is_dir($nama_folder)))   
    {
        foreach ($files as $file) {
            if (is_dir($file))
                foreach ($files1 as $f) {
                    if (is_file($f))
                    unlink($f); // hapus file
                    }
            rmdir($file); // hapus Folder dalam dir
            }
     //memasukan fungsi rmdir
     $fd = rmdir($nama_folder);   
     //mengecek proses rmdir    
     if ($fd) {    
     $this->alert->set('success', "Folder " . $folder1 . " Berhasil di Hapus "); 
     redirect(base_url() . 'staff/galeri');    
     }    
     else {    
     $this->alert->set('danger', "Folder " . $folder1 . " Gagal di Hapus ");
     redirect(base_url() . 'staff/galeri');      
     }          
    }   
    else   
    {   
     $this->alert->set('danger', "Folder " . $folder1 . " Tidak Ditemukan ");
     redirect(base_url() . 'staff/galeri');     
    }  
    }

    public function hapus_direct($folder, $file){
        $folder1 = str_replace("_", " ", $file);
        $nama_folder = SITE_ROOT. "/asset/appkit/images/ventour/galeri/". $folder . "/". $file;
        $files = glob(SITE_ROOT. "/asset/appkit/images/ventour/galeri/". $folder . "/". $file . "/*");

        // exit();
        //mengecek folder  
        if((file_exists($nama_folder))&&(is_dir($nama_folder)))   
        { 
            //menghapus semua isi dari file $nama_folder
            foreach ($files as $file) {
                if (is_file($file))
                unlink($file); // hapus file
                }
         //memasukan fungsi rmdir
         $fd = rmdir($nama_folder);   
         //mengecek proses rmdir    
         if ($fd) {    
            $this->alert->set('success', "Folder " . $folder1 . " Berhasil di Hapus ");
            redirect(base_url() . 'staff/galeri/kategori/' . $folder);    
         }    
         else {    
            $this->alert->set('danger', "Folder " . $folder1 . " Gagal di Hapus ");
            redirect(base_url() . 'staff/galeri/kategori/' . $folder);    
         }          
        }   
        else   
        {   
            $this->alert->set('danger', "Folder " . $folder1 . " Tidak Ditemukan ");
            redirect(base_url() . 'staff/galeri/kategori/' . $folder);     
        } 
        }

        public function hapus_foto($folder, $file){
            $files = glob(SITE_ROOT. "/asset/appkit/images/ventour/galeri/". $folder . "/". $file . "/*");
            //mengecek folder  
            foreach ($files as $f) {
                if (is_file($f)) {
                    unlink($f); // hapus file
                    $this->alert->set('success', "Foto Berhasil di Hapus ");
                } else {
                    $this->alert->set('danger', "Foto Gagal di Hapus ");
                }
            }
            redirect(base_url() . 'staff/galeri/vgaleri/'. $folder . "/". $file); 
        }

        public function simpan($folder, $file) {
            $result = ['folder' => $folder, 'file' => $file];
            $this->load->view('staff/form_input_foto',$result);
        }

        public function upload_foto() {
                $this->target_dir = SITE_ROOT. "/asset/appkit/images/ventour/galeri/". $_POST['directory'] . "/". $_POST['file'] . "/" ;
                
            if ($this->input->post('upload')) {
                $number_of_files = sizeof($_FILES['foto']['tmp_name']);
                $files = $_FILES['foto'];
                
                $config['upload_path'] = $this->target_dir;
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']  = 2000;
                $config['max_width']  = 2000;
                $config['max_height']  = 2000;

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
                redirect(base_url() . 'staff/galeri/vgaleri/'. $_POST['directory'] . "/". $_POST['file']);
                
                
            // echo '<pre>';
            // print_r($_POST);
            // exit();
            }
        }
}