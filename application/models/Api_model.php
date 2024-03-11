<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Api_model extends CI_Model {
	
	public function __construct() {
        parent::__construct();
		$this->load->database();
    }
    public function login_api($username){
    	$this->db->where(array('email' => $username));
		$data = $this->db->get('agen')->result_array();
		return $data;
	/*$query = $this->db->query("SELECT * FROM 'agen' WHERE 'email' = '$username'");
	return $query->result_array();*/
	}

	 public function login_api_jamaah($email){
		$this->db->select('jamaah.*, program_member.*,paket_umroh.*');
		$this->db->from('jamaah');
		$this->db->join('program_member', 'program_member.id_jamaah = jamaah.id_jamaah');
		$this->db->join('paket_umroh', 'paket_umroh.id_paket = program_member.id_paket');
		$this->db->where('ktp_no',$email);
		$query = $this->db->get();
		/*$this->db->select('
		jamaah.id,
		program_member.id AS jamaah_id
		');
		$this->db->from('jamaah');
		$this->db->where('recipients',$id);
		$this->db->join('users', 'conversations.user = users.id');
		$query = $this->db->get();*/
		return $query->result(); 


  //   	$this->db->where(array('ktp_no' => $email));
		// $data = $this->db->get('jamaah')->result_array();
		// return $data;
	/*$query = $this->db->query("SELECT * FROM 'agen' WHERE 'email' = '$username'");
	return $query->result_array();*/
	}
	
	public function get_data_detail_multi_select($args = NULL) {
	  
		
	   if(!empty($args)) {
		   $this->db->select('no_responden, nama_perusahaan, final, tgl_entri');
		   $this->db->where($args['lbl_condition'],$args['condition']);
		   $this->db->order_by('tgl_entri', "desc");
		   $data = $this->db->get($args['tabel'])->result_array();
        return $data;
	   }else{
		   return 0;
	   }
    }
	
	public function get_data_detail_multi($args = NULL) {
	  
		
	   if(!empty($args)) {
		   $this->db->where($args['lbl_condition'],$args['condition']);
		   $data = $this->db->get($args['tabel'])->result_array();
        return $data;
	   }else{
		   return 0;
	   }
    }

	
	public function get_data_paket() {
	  
		
	   $data = $this->db->get('paket_umroh')->result_array();
		return $data;
    }
	
	public function getAsosiasi($args){
		$this->db->where(array('email' => $args));
		$data = $this->db->get('user_data')->row_array();
		return $data;
	}

	public function getLoginAgen($args)
	{
		$this->db->select('id_agen, nama_agen, id_akun,email,agen_pic');
		$this->db->where(array('id_akun'=>$args['id_akun']));
		$data = $this->db->get('agen')->row_array();

		return $data;
	}

	public function getTipeKamar($args)
	{
		$this->db->select('id_paket, harga, harga_double,harga_triple');
		$this->db->where(array('id_paket'=>$args['id_paket']));
		$data = $this->db->get('paket_umroh')->row_array();

		return $data;
	}

	public function getDataJamaah($args)
	{
		$this->db->select('jamaah.*, program_member.*,paket_umroh.*');
		$this->db->from('program_member');
		$this->db->join('jamaah', 'jamaah.id_jamaah = program_member.id_jamaah');
		$this->db->join('paket_umroh', 'paket_umroh.id_paket = program_member.id_paket');
		$this->db->where('id_agen',$args);
		$query = $this->db->get();
		/*$this->db->select('
		jamaah.id,
		program_member.id AS jamaah_id
		');
		$this->db->from('jamaah');
		$this->db->where('recipients',$id);
		$this->db->join('users', 'conversations.user = users.id');
		$query = $this->db->get();*/
		return $query->result(); 
		/*$this->db->select('*');
		$this->db->where(array('id_jamaah'=>$args['id_jamaah']));
		$data = $this->db->get('jamaah')->row_array();

		return $data;*/
	}
	
	public function getJamaahList($args)
	{
		$this->db->select('jamaah.*');
		$this->db->from('jamaah');
		$this->db->where('id_jamaah',$args);
		$query = $this->db->get();
		/*$this->db->select('
		jamaah.id,
		program_member.id AS jamaah_id
		');
		$this->db->from('jamaah');
		$this->db->where('recipients',$id);
		$this->db->join('users', 'conversations.user = users.id');
		$query = $this->db->get();*/
		return $query->result(); 
		/*$this->db->select('*');
		$this->db->where(array('id_jamaah'=>$args['id_jamaah']));
		$data = $this->db->get('jamaah')->row_array();

		return $data;*/
	}


	public function getDataParent($args)
	{
		$this->db->select('jamaah.*, program_member.*');
		$this->db->from('program_member');
		$this->db->join('jamaah', 'jamaah.id_jamaah = program_member.id_jamaah');
		$this->db->where('id_member',$args);
		$this->db->order_by('program_member.id_jamaah','ASC');
		$query = $this->db->get();
		/*$this->db->select('
		jamaah.id,
		program_member.id AS jamaah_id
		');
		$this->db->from('jamaah');
		$this->db->where('recipients',$id);
		$this->db->join('users', 'conversations.user = users.id');
		$query = $this->db->get();*/
		return $query->result(); 
		/*$this->db->select('*');
		$this->db->where(array('id_jamaah'=>$args['id_jamaah']));
		$data = $this->db->get('jamaah')->row_array();

		return $data;*/
	}

	public function getProvinsi(){
		$data = $this->db->get('provinces')->result_array();
		return $data;
	}
	
	public function getMailAsosiasi(){
		$this->db->where(array('uacc_group_fk' => 3));
		$data = $this->db->get('user_accounts')->result_array();
		return $data;
	}
	
	public function cek_email($args){
		$this->db->where(array('uacc_email' => $args));
		$data = $this->db->get('user_accounts')->result_array();
		return $data;
	}
	
	public function cek_username($arg1, $arg2){
		$this->db->where(array('kd_user' => $arg1));
		$this->db->where(array('password' => $arg2));
		$data = $this->db->get('mt_user')->result_array();
		return $data;
	}
	
	public function getJenisUsaha(){
		$data = $this->db->get('mt_jenis_usaha')->result_array();
		return $data;
	}

	
	public function getKokab(){
		$data = $this->db->get('master_kokab')->result_array();
		return $data;
	}
	
	
	public function getKomoditi(){
		$data = $this->db->get('mt_komoditi')->result_array();
		return $data;
	}
	
	public function getSatuProfil($args){
		$this->db->where(array('email' => $args));
		$data = $this->db->get('user_data')->row_array();
		return $data;
	}
	
	public function getDataPerijinan($args = NULL) {
	   
	   if(!empty($args)) {
		   $this->db->where(array('status'=>'Sedang diproses instansi'));
		   $data = $this->db->get($args['nama_tabel'])->result_array();
        return $data;
	   }else{
		   return 0;
	   }
    }		
	
	public function getEdukasi($args = NULL) {
		if(!empty($args)) {	
			$this->db->where(array('publikasi'=>'1'));		   
			$data = $this->db->get($args['nama_tabel'])->result_array();        
			return $data;	   
		}else{		   
			return 0;	   
		}    
	}		
	
	public function getArtikel($args = NULL) {	   	   
		if(!empty($args)) {		   
			$data = $this->db->get($args['nama_tabel'])->result_array();        
			return $data;	   
		}else{		   
			return 0;	   
		}    
	}
	
	public function getSatuIjin($args = NULL) {
	   
	   if(!empty($args)) {
		   $this->db->where(array('status'=>'Sedang diproses instansi', 'id_pirt'=>$args['id_pirt']));
		   $data = $this->db->get($args['nama_tabel'])->result_array();
        return $data;
	   }else{
		   return 0;
	   }
    }
	
	
	
	 public function cek_token($args = Null) {
        if (!empty($args)) {
            $this->db->where($args);
        }
        $data = $this->db->get('tbl_apps')->row_array();
        if($data) {
			return $data;
		}else{
			return 0;
		}
    }
	
	public function update_perijinan($args, $petugas){
		
		if($args['status']){
			$data = array(
               'status' => $args['status'],
			   'petugas_institusi' => $petugas
            );
		}else{
			$data = array(
               'feedback' => $args['feedback'],
			   'petugas_institusi' => $petugas
            );
		}
		/*$data = array(
               'status' => $args['status'],
               'feedback' => $args['feedback'],
			   'petugas_institusi' => $petugas
            );*/

		$this->db->where('id_pirt', $args['id_pirt']);
		$this->db->update('pirt_pendaftaran', $data); 
	}
	
	public function update_userdata($args){
		if($args){
			$this->db->where('email', $args['email']);
			$this->db->update('user_data', $args); 
		}else{
			return 0;
		}
	}
	
	public function update_prof($member){
		 $this->load->library('scan');
        $uploadSuccess = true;
        if (isset($member['files']['agen_pic'])) {
            $hasil = $this->scan->check($member['files']['agen_pic'], 'agen_pic', $member['id_agen']);
            if ($hasil !== false) {
                $member['agen_pic'] = $hasil;
                $uploadSuccess = true;
            } else {
                $uploadSuccess = false;
            }
        }
       
        unset($member['files']);
        $id_member = $member['id_agen'];
        if ($existMember = $this->getAgen(null, $member['id_agen'])) {
            //update
            //$id_member = $existMember[0]->id_agen;
            $this->db->where('id_agen', $id_member);
            $this->db->update('agen', $member);
        } else {
            //insert
            $this->db->insert('agen', $member);
            $id_member = $this->db->insert_id();
        }
      
        if ($uploadSuccess == true) {
            $this->alert->set('success', 'Data Berhasil di Input');
        }
        return $id_member;
	}
	public function update_data($args = NULL){
		
			
		if (isset($args['condition'])) {
			
            $this->db->where(array($args['lbl_condition'] => $args['condition']));
            $data = $this->db->get($args['tabel'])->row_array();
			
            if (!empty($data)) {
                $this->db->where($args['lbl_condition'], $data[$args['lbl_condition']]);
                unset($args['condition']);
				
                $this->db->update($args['tabel'], $args['data']);
				
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
	}
	
	public function delete_data($args = NULL){
		
			
		if (isset($args['condition'])) {
			
            $this->db->where(array($args['lbl_condition'] => $args['condition']));
            $data = $this->db->get($args['tabel'])->row_array();
			
            if (!empty($data)) {
                $this->db->where($args['lbl_condition'], $args['condition']);
                
				$this->db->delete($args['tabel']);
				
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
	}
	
	/*public function update_data($args){
		if($args){
			$this->db->where($args['lbl_condition'], $args['condition']);
			$this->db->update($args['tabel'], $args['data']); 
		}else{
			return 0;
		}
	}*/

	public function insert_data($args = NULL){
		if(!empty($args['data'])) { 
		$this->db->insert($args['tabel'],$args['data']);
		return true;
		}else{
			return false;
		}
	}

	public function getPaket(){
		$data = $this->db->get('paket_umroh')->result_array();
		return $data;
	}

	public function getJamaah(){
		$data = $this->db->get('jamaah')->result_array();
		return $data;
	}

	public function getAgen($id = null) {
        if ($id != null) {
            $this->db->where('id_agen', $id);
        }

        $query = $this->db->get('agen');
        $result = $query->row();
        if (empty($result)) {
            return false;
        } else {
            //get member
            if ($id == null) {
                $id = $result->id_agen;
            }
            return($result);
        }
    }
    
    //Add for the API please dont delete
    public function getGroupMembersData($id_parent) {
        $this->db->select('jamaah.*, program_member.*');
        $this->db->from('program_member');
        $this->db->join('jamaah', 'jamaah.id_jamaah = program_member.id_jamaah');
        //$this->db->join('paket_umroh', 'paket_umroh.id_paket = program_member.id_paket');
        $this->db->where('parent_id',$id_parent);
        $query = $this->db->get();
        /*$this->db->select('
        jamaah.id,
        program_member.id AS jamaah_id
        ');
        $this->db->from('jamaah');
        $this->db->where('recipients',$id);
        $this->db->join('users', 'conversations.user = users.id');
        $query = $this->db->get();*/
        return $query->result(); 
    }

    public function editJamaah($id, $data) {
        $this->db->where('ktp_no', $id);
        $update = $this->db->update('jamaah', $data);
        if ($update == true) {
            return array(
                'status' => 'success'
            );
        } else {
            return array(
                'status' => 'error',
                'msg' => 'Terjadi error pada database'
            );
        }
    }

	public function getListSurat($surat_ke = null) {
		if ($surat_ke !== null) {
			$url = "https://equran.id/api/v2/surat/$surat_ke";
		} else {
			$url = "https://equran.id/api/v2/surat";
		}

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);

        curl_close($ch);

        $data = json_decode($response, true);

        if ($data === null) {
			return false;
        } else {
            return $data['data'];
        }
	}


	public function getDoa() 
    {   
        // // Parameter
        // $translation_key = 'sebelum_makan';

        // $result = str_replace("_","%20", $translation_key);

        // URL endpoint
        $url = "https://doa-doa-api-ahmadramadhan.fly.dev/api/";

        // Inisialisasi cURL session
        $ch = curl_init();

        // Set opsi cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Eksekusi cURL dan dapatkan respons
        $response = curl_exec($ch);

        // Tutup sesi cURL
        curl_close($ch);

        // Proses respons JSON
        $result = json_decode($response, true);
		// echo '<pre>';
		// print_r($result);
		// exit();

        // Cek apakah permintaan berhasil
        if ($result === null) {
            echo "Gagal memproses respons JSON.";
        } else {
            // Tampilkan data yang diambil
            $data = array (
                "result" => $result
            );
			return $data;
        }

    }
	
}

?>