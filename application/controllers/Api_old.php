<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('api_model');
    }

    // ukmnasional

    public function index() {

        echo"<pre>";
        print_r('You are not allowed!');
        exit;
    }

    public function login_api_ci() {
        $token_in = $this->uri->segment(3);
        $data_token = array('api_token' => $token_in);
        if ($this->api_model->cek_token($data_token)) {

            $email = $this->input->get('email');
            //$pass =    $this->input->get('password');
            $query = $this->api_model->login_api($email);
            //echo json_encode($query);

            if (!empty($query)) {
                print json_encode(array('status' => true, 'data' => $query));
            } else {
                print json_encode(array('status' => false));
            }
        }
    }

    public function login_api_jamaah() {
        $token_in = $this->uri->segment(3);
        $data_token = array('api_token' => $token_in);
        if ($this->api_model->cek_token($data_token)) {

            $noktp = $this->input->get('ktp_no');
            //$pass =    $this->input->get('password');
            $query = $this->api_model->login_api_jamaah($noktp);
            //echo json_encode($query);

            if (!empty($query)) {
                print json_encode(array('status' => true, 'data' => $query));
            } else {
                print json_encode(array('status' => false));
            }
        }
    }

    public function get_login() {

        $token_in = $this->uri->segment(3);
        $data_token = array('api_token' => $token_in);

        /* echo "<pre>";
          print_r($token_in);
          exit(); */

        if ($this->api_model->cek_token($data_token)) {
            $id_akun = $this->uri->segment(4);
            $email = $this->uri->segment(5);

            $data = $this->api_model->getLoginAgen(array('id_akun' => $id_akun));

            /* $test = $this->db->last_query();
              echo "<pre>";
              print_r($test);
              exit(); */

            if (!empty($data)) {
                print json_encode(array('response' => true,
                    "id_agen" => $data['id_agen'], "id_akun" => $data['id_akun'], "nama_agen" => $data['nama_agen'], "email" => $data['email'], "agen_pic" => $data['agen_pic']));
            } else {
                print json_encode(array('response' => false));
            }
        }
    }

    public function profile() {
        $token_in = $this->uri->segment(3);
        $data_token = array('api_token' => $token_in);

        /* echo "<pre>";
          print_r($token_in);
          exit(); */

        if ($this->api_model->cek_token($data_token)) {
            $id_akun = $this->uri->segment(4);
            //$email = $this->uri->segment(5);

            $email = $this->input->get('email');

            //$data = $this->api_model->getLoginAgen(array('id_akun'=>$id_akun));

            /* $test = $this->db->last_query();
              echo "<pre>";
              print_r($test);
              exit(); */
            $data = $this->api_model->get_data_detail_multi(array('tabel' => 'agen', 'lbl_condition' => 'id_agen', 'condition' => $id_akun));

            if (!empty($data)) {
                print json_encode(array('status' => true, 'data' => $data));
            } else {
                print json_encode(array('status' => false, 'data' => 'no'));
            }
        }
    }

    public function get_paket() {
        $token_in = $this->uri->segment(3);

        $data_token = array('api_token' => $token_in);
        $this->load->model('paketUmroh');
        if ($this->api_model->cek_token($data_token)) {
            $paket = $this->paketUmroh->getPackage(null, false, true, true);
            if (!empty($paket)) {
                /* echo"<pre>";
                  print_r($jenis_usaha);
                  exit; */
                print json_encode(array('status' => true,
                    'data' => $paket));
            }
        }
    }

    public function get_tipeKamar() {

        $token_in = $this->uri->segment(3);
        $data_token = array('api_token' => $token_in);

        /* echo "<pre>";
          print_r($token_in);
          exit(); */

        if ($this->api_model->cek_token($data_token)) {
            $id_paket = $this->uri->segment(4);
            $email = $this->uri->segment(5);

            $data = $this->api_model->getTipeKamar(array('id_paket' => $id_paket));

            /* $test = $this->db->last_query();
              echo "<pre>";
              print_r($test);
              exit(); */

            if (!empty($data)) {
                print json_encode(array('response' => true, 'harga' => array($survey['harga'])));
            } else {
                print json_encode(array('response' => false));
            }
        }
    }

    public function cek_akun() {
        $token_in = $this->uri->segment(3);
        $data_token = array('api_token' => $token_in);

        if ($this->uri->segment(4)) {
            if ($this->api_model->cek_token($data_token)) {
                $this->load->library('data_lib');
                $pass = $this->data_lib->create_pass($this->uri->segment(5));
                $cek = $this->api_model->cek_username($this->uri->segment(4), $pass['new_pass']);
                if (!empty($cek)) {
                    print json_encode(array('status' => true,
                        'kd_surveyor' => $cek[0]['kd_user'], 'nama_surveyor' => $cek[0]['nama']));
                } else {
                    print json_encode(array('status' => false));
                }
            } else {
                print json_encode(array('status' => false));
            }
        } else {
            print json_encode(array('status' => false));
        }

        exit;
    }

    public function get_list_paket() {

        $token_in = $this->uri->segment(3);

        $data_token = array('api_token' => $token_in);

        if ($this->api_model->cek_token($data_token)) {
            //$no_surveyor = $this->uri->segment(4);
            $this->load->model('paketUmroh');
            $paket = $this->paketUmroh->getPackage(null, false, true, true);
            $this->load->model('registrasi');

            foreach ($paket as $k => $sr) {
                $jamaah = $this->registrasi->getMember(null, null, $sr->id_paket);
                if (empty($jamaah)) {
                    $seatTerisi = 0;
                } else {
                    $seatTerisi = count($jamaah);
                }
                $pkt[$k]['seat_terisi'] = $seatTerisi;
                $pkt[$k]['id_paket'] = $sr->id_paket;
                $pkt[$k]['nama_paket'] = $sr->nama_paket;
                $pkt[$k]['tanggal_berangkat'] = $sr->tanggal_berangkat;
                $pkt[$k]['jumlah_seat'] = $sr->jumlah_seat;
                if ($sr->harga != 0) {
                    $pkt[$k]['harga'] = $sr->harga;
                } elseif ($sr->harga_triple != 0) {
                    $pkt[$k]['harga'] = $sr->harga_triple;
                } elseif ($sr->harga_double != 0) {
                    $pkt[$k]['harga'] = $sr->harga_double;
                } else {
                    $pkt[$k]['harga'] = '-';
                }
            }
            if (!empty($pkt)) {
                print json_encode($pkt);
                //print json_encode(array('status'=>false, 'data'=>'no'));
            } else {
                print json_encode(array('status' => false, 'data' => 'no'));
            }
        }
    }

    public function get_maps() {
        $token_in = $this->uri->segment(3);
        $data_token = array('api_token' => $token_in);

        /* echo "<pre>";
          print_r($token_in);
          exit(); */

        if ($this->api_model->cek_token($data_token)) {
            $id_paket = $this->uri->segment(4);
            $email = $this->uri->segment(5);

            //$data = $this->api_model->getLoginAgen(array('id_akun'=>$id_akun));

            /* $test = $this->db->last_query();
              echo "<pre>";
              print_r($test);
              exit(); */

            $data2 = $this->api_model->get_data_detail_multi(array('tabel' => 'hotel_info', 'lbl_condition' => 'id_paket', 'condition' => $id_paket));

            if (!empty($data2)) {
                print json_encode($data2);
            } else {
                print json_encode(array('status' => false, 'data' => 'no'));
            }
        }
    }

    public function get_detail_paket() {
        $token_in = $this->uri->segment(3);
        $data_token = array('api_token' => $token_in);

        /* echo "<pre>";
          print_r($token_in);
          exit(); */

        if ($this->api_model->cek_token($data_token)) {
            $id_paket = $this->uri->segment(4);
            $email = $this->uri->segment(5);

            //$data = $this->api_model->getLoginAgen(array('id_akun'=>$id_akun));

            /* $test = $this->db->last_query();
              echo "<pre>";
              print_r($test);
              exit(); */
            $data = $this->api_model->get_data_detail_multi(array('tabel' => 'paket_umroh', 'lbl_condition' => 'id_paket', 'condition' => $id_paket));
            $data2 = $this->api_model->get_data_detail_multi(array('tabel' => 'hotel_info', 'lbl_condition' => 'id_paket', 'condition' => $id_paket));
            


            if (!empty($data)) {
                print json_encode(array('status' => true, 'data' => $data, 'data_hotel' => $data2));
            } else {
                print json_encode(array('status' => false, 'data' => 'no'));
            }
        }
    }

    public function get_detail_jamaah() {
        $token_in = $this->uri->segment(3);
        $data_token = array('api_token' => $token_in);

        /* echo "<pre>";
          print_r($token_in);
          exit(); */

        if ($this->api_model->cek_token($data_token)) {
            $id_jamaah = $this->uri->segment(4);
            $email = $this->uri->segment(5);

            //$data = $this->api_model->getLoginAgen(array('id_akun'=>$id_akun));

            /* $test = $this->db->last_query();
              echo "<pre>";
              print_r($test);
              exit(); */
            $data = $this->api_model->get_data_detail_multi(array('tabel' => 'jamaah', 'lbl_condition' => 'id_jamaah', 'condition' => $id_jamaah));
            $data2 = $this->api_model->get_data_detail_multi(array('tabel' => 'program_member', 'lbl_condition' => 'id_jamaah', 'condition' => $id_jamaah));

            if (!empty($data)) {
                print json_encode(array('status' => true, 'data' => $data, 'data_member' => $data2));
            } else {
                print json_encode(array('status' => false, 'data' => 'no'));
            }
        }
    }

    public function get_provinsi() {
        $token_in = $this->uri->segment(3);

        $data_token = array('api_token' => $token_in);

        if ($this->api_model->cek_token($data_token)) {
            $provinsi = $this->api_model->getProvinsi();
            if (!empty($provinsi)) {
                /* echo"<pre>";
                  print_r($jenis_usaha);
                  exit; */
                print json_encode(array('status' => true,
                    'data' => $provinsi));
            }
        }
    }

    public function get_kabupaten() {
        $token_in = $this->uri->segment(3);
        $data_token = array('api_token' => $token_in);

        /* echo "<pre>";
          print_r($token_in);
          exit(); */

        if ($this->api_model->cek_token($data_token)) {
            $id_kabupaten = $this->uri->segment(4);
            $email = $this->uri->segment(5);

            //$data = $this->api_model->getLoginAgen(array('id_akun'=>$id_akun));

            /* $test = $this->db->last_query();
              echo "<pre>";
              print_r($test);
              exit(); */
            $data = $this->api_model->get_data_detail_multi(array('tabel' => 'regencies', 'lbl_condition' => 'province_id', 'condition' => $id_kabupaten));

            if (!empty($data)) {
                print json_encode(array('status' => true, 'data' => $data));
            } else {
                print json_encode(array('status' => false, 'data' => 'no'));
            }
        }
    }

    public function get_kecamatan() {
        $token_in = $this->uri->segment(3);
        $data_token = array('api_token' => $token_in);

        /* echo "<pre>";
          print_r($token_in);
          exit(); */

        if ($this->api_model->cek_token($data_token)) {
            $id_kecamatan = $this->uri->segment(4);
            $email = $this->uri->segment(5);

            //$data = $this->api_model->getLoginAgen(array('id_akun'=>$id_akun));

            /* $test = $this->db->last_query();
              echo "<pre>";
              print_r($test);
              exit(); */
            $data = $this->api_model->get_data_detail_multi(array('tabel' => 'districts', 'lbl_condition' => 'regency_id', 'condition' => $id_kecamatan));

            if (!empty($data)) {
                print json_encode(array('status' => true, 'data' => $data));
            } else {
                print json_encode(array('status' => false, 'data' => 'no'));
            }
        }
    }

    public function get_list_datajamaah_by_agen() {

        $token_in = $this->uri->segment(3);

        $data_token = array('api_token' => $token_in);

        if ($this->api_model->cek_token($data_token)) {
            $id_agen = $this->uri->segment(4);

            //$surveyp = $this->api_model->get_data_detail_multi_select(array('tabel'=>'tt_survey_prosedur', 'lbl_condition'=>'no_surveyor','condition'=>$no_surveyor));
            $data = $this->api_model->getDataJamaah($id_agen);

            if (!empty($data)) {
                print json_encode($data);
                //print json_encode(array('status'=>false, 'data'=>'no'));
            } else {
                print json_encode(array('status' => false, 'data' => 'no'));
            }
        }
    }

    public function get_list_datajamaah_by_parent() {

        $token_in = $this->uri->segment(3);

        $data_token = array('api_token' => $token_in);

        if ($this->api_model->cek_token($data_token)) {
            $id_parent = $this->uri->segment(4);

            //$surveyp = $this->api_model->get_data_detail_multi_select(array('tabel'=>'tt_survey_prosedur', 'lbl_condition'=>'no_surveyor','condition'=>$no_surveyor));
            $data = $this->api_model->getDataParent($id_parent);

            if (!empty($data)) {
                print json_encode($data);
                //print json_encode(array('status'=>false, 'data'=>'no'));
            } else {
                print json_encode(array('status' => false, 'data' => 'no'));
            }
        }
    }

    public function detail_jamaah() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/jamaah');
        }

        $this->load->model('registrasi');
        $data = $this->registrasi->getJamaah($_GET['id']);
        if (empty($data)) {
            $this->alert->set('danger', 'Data Tidak Ditemukan');
            redirect(base_url() . 'staff/jamaah');
        }

        $data->member_select = 0;
        if (!empty($_GET['id_member'])) {
            foreach ($data->member as $key => $mbr) {
                if ($mbr->id_member == $_GET['id_member']) {
                    $data->member_select = $key;
                    break;
                }
            }
        }
        if (!empty($data->member[$data->member_select]->parent_id)) {
            $data->child = $this->api_model->getGroupMembersData($data->member[$data->member_select]->parent_id);
        }

        print json_encode($data);
    }

    public function get_kokab() {
        $token_in = $this->uri->segment(3);

        $data_token = array('api_token' => $token_in);

        if ($this->api_model->cek_token($data_token)) {
            $kokab = $this->api_model->getKokab();
            if (!empty($kokab)) {
                /* echo"<pre>";
                  print_r($jenis_usaha);
                  exit; */
                print json_encode(array('status' => true,
                    'kokab' => $kokab));
            }
        }
    }

    public function get_profil() {
        $token_in = $this->uri->segment(3);

        $data_token = array('api_token' => $token_in);

        if ($this->uri->segment(4)) {
            if ($this->api_model->cek_token($data_token)) {

                $data = $this->api_model->getSatuProfil($this->uri->segment(4));
                if (!empty($data)) {
                    print json_encode(array('status' => true, 'data' => $data));
                } else {
                    print json_encode(array('status' => false));
                }
            } else {
                print json_encode(array('status' => false));
            }
        } else {
            print json_encode(array('status' => false));
        }
    }

    private function getprovinsi($kab) {

        //$kab = $this->input->get('kab');

        $kabupaten = $this->data_model->get_data_detail(array('tabel' => 'master_kokab',
            'lbl_condition' => 'kokab_nama',
            'condition' => $kab));
        /* echo"<pre>";
          print_r($kabupaten);
          exit; */

        $provinsi = $this->data_model->get_data_detail(array('tabel' => 'master_provinsi',
            'lbl_condition' => 'provinsi_id',
            'condition' => $kabupaten['provinsi_id']));
        $nprovinsi = $provinsi['provinsi_nama'];

        return $nprovinsi;
    }

    public function tambah_agen() {
        $token_in = $this->uri->segment(3);
        $data_token = array('api_token' => $token_in);

        if ($this->api_model->cek_token($data_token)) {
            if ($_POST) {
                $pos = $_POST;
                //print json_encode(array('status'=>true, 'data'=>$pos));
                //exit;
                //$wilayah = $pos['data'];
                foreach ($pos as $data1) {
                    foreach ($data1 as $data2) {
                        foreach ($data2 as $var => $data3) {
                            $data[$var] = $data3;
                        }
                    }
                }

                /* if ($data['tabel']=='risk') {
                  $tabel = 'tt_survey_risk';
                  }else{
                  $tabel = 'tt_survey_prosedur';
                  } */

                $datum = array('id_akun' => $data['id_akun'], 'nama_agen' => $data['nama_agen'], 'email' => $data['email'], 'agen_pic' => $data['agen_pic']);

                $this->api_model->insert_data(array('tabel' => 'agen', 'data' => $datum));

                if ($datum) {
                    print json_encode(array('status' => true, 'data' => $datum, 'pesan' => 'Berhasil Menambah Data.'));
                    // print json_encode(array('status'=>true, 'data'=>$no_responden, 'tabel'=>$tabel, 'pesan'=>'Berhasil Menambah Responden.'));
                } else {
                    print json_encode(array('status' => false, 'pesan' => 'Tidak Berhasil Menambah Responden.'));
                }
            } else {
                print json_encode(array('status' => true, 'data' => 'no'));
            }
        }
    }

    public function tambah_jamaah() {
        $token_in = $this->uri->segment(3);
        $data_token = array('api_token' => $token_in);

        if ($this->api_model->cek_token($data_token)) {
            if ($_POST) {
                $pos = $_POST;
                //print json_encode(array('status'=>true, 'data'=>$pos));
                //exit;
                //$wilayah = $pos['data'];
                foreach ($pos as $data1) {
                    foreach ($data1 as $data2) {
                        foreach ($data2 as $var => $data3) {
                            $data[$var] = $data3;
                        }
                    }
                }

                /* if ($data['tabel']=='risk') {
                  $tabel = 'tt_survey_risk';
                  }else{
                  $tabel = 'tt_survey_prosedur';
                  } */

                $datum = array('first_name' => $data['first_name'], 'second_name' => $data['second_name'], 'last_name' => $data['last_name'], 'ktp_no' => $data['ktp_no'], 'nama_ayah' => $data['nama_ayah'], 'tempat_lahir' => $data['tempat_lahir'], 'tanggal_lahir' => $data['tanggal_lahir'], 'jenis_kelamin' => $data['jenis_kelamin'], 'status_perkawinan' => $data['status_perkawinan'], 'no_wa' => $data['no_wa'], 'no_rumah' => $data['no_rumah'], 'email' => $data['email'], 'alamat_tinggal' => $data['alamat_tinggal'], 'provinsi' => $data['provinsi'], 'kecamatan' => $data['kecamatan'], 'kabupaten_kota' => $data['kabupaten_kota'], 'kewarganegaraan' => $data['kewarganegaraan'], 'pekerjaan' => $data['pekerjaan'], 'pendidikan_terakhir' => $data['pendidikan_terakhir'], 'penyakit' => $data['penyakit'], 'referensi' => $data['referensi']);

                $this->api_model->insert_data(array('tabel' => 'jamaah', 'data' => $datum));

                $id_jamaah = $this->db->insert_id();

                $data_member = array('id_jamaah' => $id_jamaah, 'id_paket' => $data['id_paket'], 'id_agen' => $data['id_agen'], 'parent_id' => $id_jamaah, 'pilihan_kamar' => $data['pilihan_kamar'], 'total_harga' => $data['total_harga']);
                $this->api_model->insert_data(array('tabel' => 'program_member', 'data' => $data_member));

                if ($datum) {
                    print json_encode(array('status' => true, 'data' => $datum, 'pesan' => 'Berhasil Menambah Data.'));
                    // print json_encode(array('status'=>true, 'data'=>$no_responden, 'tabel'=>$tabel, 'pesan'=>'Berhasil Menambah Responden.'));,
                    /*
                      $jamaah = $this->api_model->get_jamaah();

                      foreach($jamaah as $k=>$sr){
                      $pkt[$k]['id_paket'] = $sr['id_paket'];
                      $pkt[$k]['nama_paket'] = $sr['nama_paket'];
                      //$surv[$k]['no_surveyor'] = $sr['no_surveyor'];
                      $pkt[$k]['tanggal_berangkat'] = $sr['tanggal_berangkat'];
                      $pkt[$k]['harga'] = $sr['harga'];
                      }

                      $data['id_jamaah'] */
                } else {
                    print json_encode(array('status' => false, 'pesan' => 'Tidak Berhasil Menambah Responden.'));
                }
            } else {
                print json_encode(array('status' => true, 'data' => 'no'));
            }
        }
    }

    public function add_jamaah() {
        $token_in = $this->uri->segment(3);
        $data_token = array('api_token' => $token_in);

        if ($this->api_model->cek_token($data_token)) {
            if ($_POST) {
                $data = $_POST;
                $this->load->model('registrasi');
                $hasil = $this->registrasi->daftar($data);
                if ($hasil == true) {
                    print json_encode(array('status' => true, 'pesan' => 'Berhasil Menambah Jamaah.'));
                } else {
                    print json_encode(array('status' => false, 'pesan' => 'Gagal Menambah Jamaah.'));
                }
            } else {
                print json_encode(array('status' => true, 'data' => 'no'));
            }
        }
    }

    public function hapus_jamaah() {

        $token_in = $this->uri->segment(3);

        $data_token = array('api_token' => $token_in);

        if ($this->api_model->cek_token($data_token)) {
            $id_jamaah = $this->uri->segment(4);

            $data_jamaah = $this->api_model->delete_data(array('tabel' => 'jamaah', 'lbl_condition' => 'id_jamaah', 'condition' => $id_jamaah));
            $data_pm = $this->api_model->delete_data(array('tabel' => 'program_member', 'lbl_condition' => 'id_jamaah', 'condition' => $id_jamaah));

            if (!empty($data_jamaah)) {
                print json_encode(array('status' => true, 'pesan' => 'Data berhasil dihapus'));
                //print json_encode(array('status'=>false, 'data'=>'no'));
            } else {
                print json_encode(array('status' => false, 'pesan' => 'Data gagal dihapus'));
            }
        }
    }

    /* 	public function rincian_harga() {
      $token_in = $this->uri->segment(3);
      $data_token = array('api_token'=>$token_in);


      if($this->api_model->cek_token($data_token)) {
      $this->form_validation->set_data($this->input->get());
      $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

      if ($this->form_validation->run() == FALSE) {
      echo 'Access Denied';
      return false;
      }
      $this->load->model('tarif');
      $data = $this->tarif->calcTariff($_GET['id']);
      print json_encode($data);
      }
      } */

    public function riwayat_bayar() {
        $token_in = $this->uri->segment(3);
        $data_token = array('api_token' => $token_in);


        if ($this->api_model->cek_token($data_token)) {
            $this->form_validation->set_data($this->input->get());
            $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

            if ($this->form_validation->run() == FALSE) {
                echo 'Access Denied';
                return false;
            }
            $this->load->model('tarif');
            $data = $this->tarif->getPembayaran($_GET['id']);

            $this->load->view('staff/riwayat_bayar', $data);
        }
    }

    public function rincian_harga() {
        $token_in = $this->uri->segment(3);
        $data_token = array('api_token' => $token_in);


        if ($this->api_model->cek_token($data_token)) {

            $this->form_validation->set_data($this->input->get());
            $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

            if ($this->form_validation->run() == FALSE) {
                echo 'Access Denied';
                return false;
            }
            $this->load->model('tarif');
            $data = $this->tarif->calcTariff($_GET['id']);
            $this->load->view('staff/rincian_harga', $data);
        }
    }

    public function set_parent() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('idj', 'idj', 'trim|required|integer');
        $this->form_validation->set_rules('idm', 'idm', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/jamaah');
        }
        $this->load->model('registrasi');
        //get parent id of this member

        $member = $this->registrasi->getMember($_GET['idm']);
        if (empty($member)) {
            $this->alert->set('danger', 'Data Tidak Ditemukan');
            redirect(base_url() . 'staff/info/detail_jamaah');
            return false;
        }
        $member = $member[0];
        $jamaah = $this->registrasi->getJamaah($_GET['idj']);
        $parentId = $member->parent_id;

        //get list of member of the same package
        $listMember = $this->registrasi->getMember(null, null, $member->id_paket);
        foreach ($listMember as $key => $lm) {
            //$j = $this->registrasi->getJamaah($lm->id_jamaah);
            $j = $this->registrasi->getJamaah($lm->id_jamaah);
            $listMember[$key]->jamaahData = $j;
        }

        $data = array(
            'jamaah' => $jamaah,
            'member' => $member,
            'parentId' => $parentId,
            'listMember' => $listMember
        );
        print json_encode($data);
    }

    public function leader() {
        $this->form_validation->set_data($this->input->get());
        //$this->form_validation->set_rules('idj', 'idj', 'trim|required|integer');
        $this->form_validation->set_rules('idm', 'idm', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/jamaah');
        }
        $this->load->model('registrasi');
        //get parent id of this member

        $member = $this->registrasi->getMember($_GET['idm']);
        if (empty($member)) {
            $this->alert->set('danger', 'Data Tidak Ditemukan');
            redirect(base_url() . 'staff/info/detail_jamaah');
            return false;
        }
        $member = $member[0];
        $jamaah = $this->registrasi->getJamaah($_GET['idj']);
        $parentId = $member->parent_id;

        //get list of member of the same package
        $listMember = $this->registrasi->getMember(null, null, $member->id_paket);
        foreach ($listMember as $key => $lm) {
            //$j = $this->registrasi->getJamaah($lm->id_jamaah);
            $j = $this->registrasi->getJamaah($lm->id_jamaah);
            $listMember[$key]->jamaahData = $j;
        }

        $data = array(
            'jamaah' => $jamaah,
            'member' => $member,
            'parentId' => $parentId
        );
        print json_encode($data);
    }

    /* public function proses_set_parent() {

      if ($_POST['parent_id'] != '') {
      $this->form_validation->set_rules('parent_id', 'pid', 'trim|required|integer');
      }

      if ($this->form_validation->run() == FALSE) {
      $this->alert->set('danger', 'Access Denied');
      redirect(base_url() . 'staff/jamaah');
      }
      $this->load->model('registrasi');
      $result = $this->registrasi->setParent($_POST['id_member'], $_POST['parent_id']);
      $this->alert->set('success', 'Akun Berhasil dihubungkan');
      redirect(base_url() . 'staff/info/detail_jamaah?id=' . $_POST['id_jamaah'] . '&id_member=' . $_POST['id_member']);
      } */

    public function proses_set_parent() {
        $token_in = $this->uri->segment(3);
        $data_token = array('api_token' => $token_in);

        if ($this->api_model->cek_token($data_token)) {
            if ($_POST) {
                //$id_member = $this->uri->segment(4);
                $data = $_POST;
                $this->load->model('registrasi');
                $hasil = $this->registrasi->setParent($data['id_member'], $data['parent_id']);
                if ($hasil == true) {
                    print json_encode(array('status' => true, 'pesan' => 'Berhasil Mengubah Leader.'));
                } else {
                    print json_encode(array('status' => false, 'pesan' => 'Gagal Mengubah.'));
                }
            } else {
                print json_encode(array('status' => true, 'data' => 'no'));
            }
        }
    }

    public function proses_update() {
        $token_in = $this->uri->segment(3);
        $data_token = array('api_token' => $token_in);

        if ($this->api_model->cek_token($data_token)) {
            if ($_POST) {
                $this->load->model('registrasi');
                $result = $this->registrasi->daftar($_POST);
                if ($result == true) {
                    print json_encode(array('status' => true, 'pesan' => 'Berhasil Mengubah Data!'));
                } else {
                    print json_encode(array('status' => false, 'pesan' => 'Gagal Mengubah Data!'));
                }
            } else {
                print json_encode(array('status' => true, 'data' => 'no'));
            }
        }
    }

    public function update_member() {
        $token_in = $this->uri->segment(3);
        $data_token = array('api_token' => $token_in);


        if ($this->api_model->cek_token($data_token)) {
            $this->form_validation->set_data($this->input->get());
            $this->form_validation->set_rules('idj', 'idj', 'trim|required|integer');
            $this->form_validation->set_rules('idm', 'idm', 'trim|required|integer');

            if ($this->form_validation->run() == FALSE) {
                $this->alert->set('danger', 'Access Denied');
                redirect(base_url() . 'staff/jamaah');
                return false;
            }
            $this->load->model('registrasi');
            $data_jamaah = $this->registrasi->getJamaah($_GET['idj']);
            if (empty($data_jamaah)) {
                $this->alert->set('danger', 'Data Tidak Ditemukan');
                redirect(base_url() . 'staff/jamaah');
                return false;
            }
            $data_member = $this->registrasi->getMember($_GET['idm']);
            if (empty($data_member)) {
                $this->alert->set('danger', 'Data Tidak Ditemukan');
                redirect(base_url() . 'staff/jamaah');
                return false;
            }
            
            $idPaket = $data_member[0]->id_paket;
        $this->load->model('paketUmroh');
        $paketInfo = $this->paketUmroh->getPackage($idPaket, false, false, false);
        if (empty($paketInfo)) {
            $this->alert->set('danger', 'Data Tidak Ditemukan');
            redirect(base_url() . 'staff/jamaah');
            return false;
        }
        //option for pilihan kamar
        $kamarOption = array();
        if(!empty($paketInfo->harga) || $paketInfo->harga != '0'){
            $kamarOption[] = 'Quad';
        }
        if(!empty($paketInfo->harga_triple) || $paketInfo->harga_triple != '0'){
            $kamarOption[] = 'Triple';
        }
        if(!empty($paketInfo->harga_double) || $paketInfo->harga_double != '0'){
            $kamarOption[] = 'Double';
        }


            print json_encode($data = array(
                        'jamaah' => $data_jamaah,
                        'member' => $data_member[0],
                        'kamarOption' => $kamarOption
            ));
        }
    }

    public function proses_update_peserta() {

        /* if($_SERVER['REQUEST_METHOD']=='POST'){
          $data = $_POST['foto_scan']; */
        $token_in = $this->uri->segment(3);
        $data_token = array('api_token' => $token_in);


        if ($this->api_model->cek_token($data_token)) {
            $data = $_POST;
            if (!empty($_FILES['paspor_scan']['name'])) {
                $data['files']['paspor_scan'] = $_FILES['paspor_scan'];
            }
            if (!empty($_FILES['ktp_scan']['name'])) {
                $data['files']['ktp_scan'] = $_FILES['ktp_scan'];
            }
            if (!empty($_FILES['foto_scan']['name'])) {
                $data['files']['foto_scan'] = $_FILES['foto_scan'];
            }
            if (!empty($_FILES['visa_scan']['name'])) {
                $data['files']['visa_scan'] = $_FILES['visa_scan'];
            }
            if (!empty($_FILES['tiket_scan']['name'])) {
                $data['files']['tiket_scan'] = $_FILES['tiket_scan'];
            }

            $this->load->model('registrasi');
            $result = $this->registrasi->updateMember($data);
            if ($result == true) {
                print json_encode(array('status' => true, 'pesan' => 'Berhasil Mengubah Data!'));
            } else {
                print json_encode(array('status' => false, 'pesan' => 'Gagal Mengubah Data!'));
            }
        }
    }

    public function proses_bayar() {
        $token_in = $this->uri->segment(3);
        $data_token = array('api_token' => $token_in);

        if ($this->api_model->cek_token($data_token)) {
            $data = $_POST;
            if (!empty($_FILES['scan_bayar']['name'])) {
                $data['files']['scan_bayar'] = $_FILES['scan_bayar'];
            }
            $this->load->model('tarif');
            $result = $this->tarif->setPembayaran($data);
            if ($result == true) {
                print json_encode(array('status' => true, 'pesan' => 'Berhasil melakukan Pembayaran!'));
            } else {
                print json_encode(array('status' => false, 'pesan' => 'Gagal melakukan Pembayaran!'));
            }
        }
    }

    public function update_profile() {
        $token_in = $this->uri->segment(3);
        $data_token = array('api_token' => $token_in);


        if ($this->api_model->cek_token($data_token)) {
            $data = $_POST;

            $id_agen = $_POST['id_agen'];
            unset($_POST['id_agen']);
            $this->load->model('agen');
            $update = $this->agen->editAgen($id_agen, $_POST);
            if (!empty($_FILES['file']['name'])) {
                $result = $this->agen->changePic($id_agen, $_FILES['file']);
            }

            if ($update == true) {
                print json_encode(array('status' => true, 'pesan' => 'Berhasil Mengubah Data!'));
            } else {
                print json_encode(array('status' => false, 'pesan' => 'Gagal Mengubah Data!'));
            }
        }
    }

    public function histori_poin() {
        if (empty($_GET['id'])) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/kelola_agen');
        }
        $this->load->model('poinAgen');
        $history = $this->poinAgen->getHistory($_GET['id']);
        if ($history['status'] == 'error') {
            $this->alert->set('danger', $history['msg']);
            redirect(base_url() . 'staff/kelola_agen');
        }
        $this->load->model('agen');
        $profile = $this->agen->getAgen($_GET['id']);
        $data = array(
            'history' => $history['data'],
            'profile' => $profile[0]
        );
        print json_encode($data);
    }

    public function data_jamaah() {
        $id_member = $_GET['id_member'];
        if (isset($_GET['id_member'])) {
            $id_member = $_GET['id_member'];
        }

        $this->load->model('registrasi');
        $this->load->model('customer');

        $member = $this->registrasi->getMember($id_member);
        $member = $member[0];
        $jamaah = $this->registrasi->getJamaah($member->id_jamaah);

        $status = $this->customer->getStatus($member);
        $this->load->library('calculate');
        $member->paket_info->countdown = $this->calculate->dateDiff($member->paket_info->tanggal_berangkat, date('Y-m-d'));
        $member->paket_info->tanggal_pelunasan = date('d F Y', strtotime($member->paket_info->tanggal_berangkat . ' -45 day'));

        //logistik
        $this->load->model('logistik');
        $logistik = $this->logistik->getPerlengkapanPeserta($id_member);
        $logBelumAmbil = array();
        $logSudahAmbil = array();
        foreach ($logistik as $log) {
            if ($log->status != 'Siap Diambil')
                continue;
            if (isset($log->jumlah_ambil)) {
                $logSudahAmbil[] = $log->nama_barang;
            } else {
                $logBelumAmbil[] = $log->nama_barang;
            }
        }

        //get broadcast
        $this->load->model('bcast');
        $broadcast = $this->bcast->getPesan(null, $member->id_paket, 1);

        $data = array(
            'jamaahData' => $jamaah,
            'memberData' => $member,
            'DPStatus' => $status['DPStatus'],
            'dataStatus' => $status['dataStatus'],
            'lunasStatus' => $status['lunasStatus'],
            'displayBroadcast' => $status['displayBroadcast'],
            'logBelumAmbil' => $logBelumAmbil,
            'logSudahAmbil' => $logSudahAmbil,
            'broadcast' => $broadcast
        );
        print json_encode($data);
    }

    public function data_pengumuman() {
        $id_member = $_GET['id_member'];
        if (isset($_GET['id_member'])) {
            $id_member = $_GET['id_member'];
        }

        $this->load->model('registrasi');
        $this->load->model('customer');

        $member = $this->registrasi->getMember($id_member);
        $member = $member[0];
        $jamaah = $this->registrasi->getJamaah($member->id_jamaah);

        $status = $this->customer->getStatus($member);
        $this->load->library('calculate');
        $member->paket_info->countdown = $this->calculate->dateDiff($member->paket_info->tanggal_berangkat, date('Y-m-d'));
        $member->paket_info->tanggal_pelunasan = date('d F Y', strtotime($member->paket_info->tanggal_berangkat . ' -45 day'));

        //logistik
        $this->load->model('logistik');
        $logistik = $this->logistik->getPerlengkapanPeserta($id_member);
        $logBelumAmbil = array();
        $logSudahAmbil = array();
        foreach ($logistik as $log) {
            if ($log->status != 'Siap Diambil')
                continue;
            if (isset($log->jumlah_ambil)) {
                $logSudahAmbil[] = $log->nama_barang;
            } else {
                $logBelumAmbil[] = $log->nama_barang;
            }
        }

        //get broadcast
        $this->load->model('bcast');
        $broadcast = $this->bcast->getPesan(null, $member->id_paket, 1);

        $data = array(
            'jamaahData' => $jamaah,
            'memberData' => $member,
            'DPStatus' => $status['DPStatus'],
            'dataStatus' => $status['dataStatus'],
            'lunasStatus' => $status['lunasStatus'],
            'displayBroadcast' => $status['displayBroadcast'],
            'logBelumAmbil' => $logBelumAmbil,
            'logSudahAmbil' => $logSudahAmbil,
            'broadcast' => $broadcast
        );
        print json_encode($broadcast);
    }

    public function update_device() {
        $token_in = $this->uri->segment(3);
        $data_token = array('api_token' => $token_in);


        if ($this->api_model->cek_token($data_token)) {
            $data = $_POST;

            $id_jamaah = $_POST['ktp_no'];
            //unset($_POST['id_jamaah']);
            $update = $this->api_model->editJamaah($id_jamaah, $_POST);

            if ($update == true) {
                print json_encode(array('status' => true));
            } else {
                print json_encode(array('status' => false));
            }
        }
    }

}

?>