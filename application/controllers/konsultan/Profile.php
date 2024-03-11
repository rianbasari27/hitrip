<?php

use Google\Service\AndroidPublisher\PrepaidPlan;

defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('konsultanAuth');
        if (!$this->konsultanAuth->is_user_logged_in()) {
            redirect(base_url() . 'konsultan/login');
        }
    }

    public function index($idAgen = null)
    {
        $idAgen = empty($idAgen) ? $_SESSION['id_agen'] : $idAgen;
        $this->load->model('agen');
        $this->load->library('Wa_number');
        $agen = $this->agen->getAgen($idAgen);
        if ($agen[0]->active != 1) {
            redirect(base_url() . 'konsultan/home/pemb_notice');
        }
        $format_wa = $this->wa_number->convert($agen[0]->no_wa);
        $data = array(
            "agen" => $agen[0],
            "format_wa" => $format_wa
        );
        // echo '<pre>';
        // print_r($data);
        // exit();
        $this->load->view('konsultan/profile_konsultan', $data);
    }

    public function hapus_pic()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id_agen', 'id_agen', 'trim|required|integer');
        $this->form_validation->set_rules('field', 'field', 'required');

        if ($this->form_validation->run() == FALSE) {
            return false;
        }
        $this->load->model('agen');
        $result = $this->agen->deletePic($_GET['id_agen'], $_GET['field']);
        if ($result == true) {
            echo json_encode(true);
        } else {
            return false;
        }
    }

    public function edit_profile()
    {
        $this->load->model('agen');
        $agen = $this->agen->getAgen($_SESSION['id_agen']);
        $this->load->model('region');
        $provinsi = $this->region->getProvince();
        $negara = $this->region->getCountries();
        $data = array(
            "agen" => $agen[0],
            'provinceList' => $provinsi,
            'countries' => $negara
        );
        return $this->load->view('konsultan/edit_profile_view', $data);
    }

    public function proses_edit_profile()
    {
        $this->form_validation->set_rules('id_agen', 'idAgen', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->setJamaah('red', 'Oops...', 'Data tidak ditemukan');
            redirect($_SERVER['HTTP_REFERER']);
            return false;
        }
        $data = $_POST;
        if ($data['no_wa'] == '+62') {
           unset($data['no_wa']);
        }
        unset($data['id_agen']);
        $this->load->model('agen');
        $agen = $this->agen->editAgen($_SESSION['id_agen'], $data);
        if ($agen['status'] == 'success') {
            $this->alert->setJamaah('green', 'Sukses!', 'Data berhasil diubah');
            redirect(base_url() . 'konsultan/profile?id_agen=' . $_SESSION['id_agen']);
        } else {
            $this->alert->setJamaah('red', 'Gagal!', $agen['msg']);
            redirect(base_url() . 'konsultan/profile?id_agen=' . $_SESSION['id_agen']);
        }
    }

    public function getCountries()
    {
        $term = $this->input->get('term');
        $this->load->model('region');
        $negara = $this->region->getCountriesAutoComplete($term);
        echo json_encode($negara);
    }

    public function getRegencies()
    {
        $provId = $this->input->get('provId');
        $this->load->model('region');
        $regency = $this->region->getRegency(null, $provId);
        echo json_encode($regency);
    }

    public function getDistricts()
    {
        $regId = $this->input->get('regId');
        $this->load->model('region');
        $districts = $this->region->getDistrict(null, $regId);
        echo json_encode($districts);
    }

    public function dl_mou()
    {
        if (isset($_SESSION['id_agen'])) {
            $this->load->model('agen');
            $data = $this->agen->getAgen($_SESSION['id_agen']);
            $filename = $data[0]->mou_doc;

            if (file_exists(SITE_ROOT . $filename)) {
                redirect(base_url() . $filename);
            } else {
                $this->alert->setJamaah('red', 'Ups...', 'File tidak tersedia');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function pic_ganti() {
        $this->load->model('agen');
        $agen = $this->agen->getAgen($_SESSION['id_agen']);
        if(isset($_POST["image"]))
        {
        $data = $_POST["image"];
        $image_array_1 = explode(";", $data);
        $image_array_2 = explode(",", $image_array_1[1]);
        $data = base64_decode($image_array_2[1]);
        $imageName = $agen[0]->nama_agen . "_profile_". time() . '.png';
        $file = "/uploads/agen_pic/". $imageName;
        if(!empty($agen[0]->agen_pic)) {
            unlink(SITE_ROOT . $agen[0]->agen_pic);
        }
        file_put_contents(SITE_ROOT . $file, $data);
        $image_file = addslashes(file_get_contents(SITE_ROOT . $file));
        
        $this->db->where('id_agen', $agen[0]->id_agen);
        $this->db->set('agen_pic', $file);
        $this->db->update('agen');

        // $statement = $connect->prepare($query);
        // if($statement->execute())
        // {
        echo 'Profil berhasil diganti';
        // unlink($imageName);
        // }

        }
    }
}