<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Jamaah extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }
        //this page only for admin
        if (!($_SESSION['bagian'] == 'Manifest' || $_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Finance' || $_SESSION['bagian'] == 'Logistik' || (preg_match("/bandung/i", $_SESSION['email'])))) {
            $this->alert->toast('danger', 'Mohon Maaf', 'Anda tidak memiliki akses');
            redirect(base_url() . 'staff/dashboard');
        }
    }

    public function index()
    {
        $this->load->view('staff/jamaah_view');
    }

    public function toggle_data_validasi()
    {
        if (!isset($_GET['id_member'])) {
            return false;
        }
        $id_member = $_GET['id_member'];
        $this->load->model('registrasi');
        $toggle = $this->registrasi->toggleVerified($id_member);
        if ($toggle == true) {
            echo json_encode(true);
            return true;
        } else {
            return false;
        }
    }

    public function registrasi()
    {
        //get all available paket
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage(null, false, false, true);


        $this->load->model('region');
        $province = $this->region->getProvince();
        $regency = $this->region->getRegency(null, $province[0]->id);
        $districts = $this->region->getDistrict(null, $regency[0]->id);
        $this->load->model('agen');
        $agenList = $this->agen->getAgen();
        $this->load->view('staff/registrasi_view', $data = array(
            'paket' => $paket,
            'provinsi' => $province,
            'kabupaten' => $regency,
            'kecamatan' => $districts,
            'agenList' => $agenList
        ));
    }

    public function add_member()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->toast('danger', 'Mohon Maaf', 'Anda tidak memiliki akses');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->model('paketUmroh');
        $this->load->model('registrasi');
        $paket = $this->paketUmroh->getPackage(null, false, false);
        $user = $this->registrasi->getuser($_GET['id']);
        $data = array(
            'paket' => $paket,
            'user' => $user
        );
        if (!empty($user->member)) {
            foreach ($paket as $key => $p) {
                $id_paket = $p->id_paket;
                foreach ($user->member as $p) {
                    if ($id_paket == $p->id_paket) {
                        unset($data['paket'][$key]);
                        break;
                    }
                }
            }
        }
        $this->load->view('staff/add_member_view', $data);
    }

    public function set_parent()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('idm', 'idm', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/jamaah');
        }
        $this->load->model('registrasi');
        //get parent id of this member
        $jamaah = $this->registrasi->getJamaah(null, null, $_GET['idm']);
        $member = $jamaah->member;
        if (empty($member)) {
            $this->alert->set('danger', 'Data Tidak Ditemukan');
            redirect(base_url() . 'staff/info/detail_jamaah');
            return false;
        }
        $member = $member[0];

        $parentId = $member->parent_id;

        //get list of member of the same package
        $listMember = $this->registrasi->getMember(null, null, $member->id_paket);

        foreach ($listMember as $key => $lm) {
            $j = $this->registrasi->getJamaah($lm->id_jamaah);
            if (empty($j)) {
                unset($listMember[$key]);
            } else {
                $listMember[$key]->jamaahData = $j;
            }
        }

        $data = array(
            'jamaah' => $jamaah,
            'member' => $member,
            'parentId' => $parentId,
            'listMember' => $listMember
        );
        $this->load->view('staff/set_parent', $data);
    }

    public function proses_set_parent()
    {
        $this->form_validation->set_rules('id_jamaah', 'idj', 'trim|required|integer');
        $this->form_validation->set_rules('id_member', 'idm', 'trim|required|integer');
        if ($_POST['parent_id'] != '') {
            $this->form_validation->set_rules('parent_id', 'pid', 'trim|required|integer');
        }
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/jamaah');
        }
        $parent_id = $_POST['parent_id'];
        if ($parent_id == '') {
            $parent_id = null;
        }
        $this->load->model('registrasi');
        $result = $this->registrasi->setParent($_POST['id_member'], $parent_id);
        $this->alert->set('success', 'Akun Berhasil dihubungkan');
        redirect(base_url() . 'staff/info/detail_jamaah?id=' . $_POST['id_jamaah'] . '&id_member=' . $_POST['id_member']);
    }

    public function update_data()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->toast('danger', 'Mohon Maaf', 'Anda tidak memiliki akses');
            redirect(base_url() . 'staff/jamaah');
        }

        $this->load->model('registrasi');
        $data = $this->registrasi->getUser($_GET['id']);
        if (empty($data)) {
            $this->alert->toast('danger', 'Mohon Maaf', 'Data tidak ditemukan');
            redirect(base_url() . 'staff/jamaah');
        }
        // $this->load->model('region');
        // $province = $this->region->getProvince();
        // $data->provinceList = $province;

        // $this->load->model('agen');
        // $agenList = $this->agen->getAgen();
        // $data->agenList = $agenList;

        $this->load->view('staff/update_user', $data);
    }

    public function update_member()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('idm', 'idm', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->toast('danger', 'Mohon Maaf', 'Anda tidak memiliki akses');
            redirect($_SERVER['HTTP_REFERER']);
            return false;
        }
        $this->load->model('registrasi');
        $data_jamaah = $this->registrasi->getUser(null, null, null, $_GET['idm']);
        if (empty($data_jamaah)) {
            $$this->alert->toast('danger', 'Mohon Maaf', 'Data tidak ditemukan');
            redirect($_SERVER['HTTP_REFERER']);
            return false;
        }
        $data_member = $data_jamaah->member;
        if (empty($data_member)) {
            $$this->alert->toast('danger', 'Mohon Maaf', 'Data tidak ditemukan');
            redirect($_SERVER['HTTP_REFERER']);
            return false;
        }
        $idPaket = $data_member[0]->id_paket;
        $this->load->model('paketUmroh');
        $paketInfo = $this->paketUmroh->getPackage($idPaket, false, false, false);
        if (empty($paketInfo)) {
            $$this->alert->toast('danger', 'Mohon Maaf', 'Data tidak ditemukan');
            redirect($_SERVER['HTTP_REFERER']);
            return false;
        }
        //option for pilihan kamar
        $kamarOption = array();
        if (!empty($paketInfo->harga) || $paketInfo->harga != '0') {
            $kamarOption[] = 'Quad';
        }
        if (!empty($paketInfo->harga_triple) || $paketInfo->harga_triple != '0') {
            $kamarOption[] = 'Triple';
        }
        if (!empty($paketInfo->harga_double) || $paketInfo->harga_double != '0') {
            $kamarOption[] = 'Double';
        }

        $this->load->view('staff/update_peserta', $data = array(
            'jamaah' => $data_jamaah,
            'member' => $data_member[0],
            'kamarOption' => $kamarOption
        ));
    }

    public function hapus()
    {
        if (!($_SESSION['bagian'] == 'Master Admin')) {
            $this->alert->toast('danger', 'Mohon Maaf', 'Anda tidak memiliki akses');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->toast('danger', 'Mohon Maaf', 'Anda tidak memiliki akses');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->model('registrasi');
        $data = $this->registrasi->deleteUser($_GET['id']);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function proses_tambah()
    {
        if (!empty($_FILES['upload_penyakit']['name'])) {
            $_POST['files']['upload_penyakit'] = $_FILES['upload_penyakit'];
        }
        $this->load->model('registrasi');
        $result = $this->registrasi->daftar($_POST);
        redirect(base_url() . 'staff/jamaah/registrasi');
    }

    public function proses_update()
    {

        $id_user = $_POST['id_user'];
        $this->load->model('registrasi');
        $member = $this->registrasi->getMember(null, $id_user);
        $this->load->model('registrasi');
        if (empty($member)) {
            $registerFrom = null;
        } else {
            $registerFrom = $member[0]->register_from;
        }
        $result = $this->registrasi->daftar($_POST, $registerFrom, true);
        redirect(base_url() . 'staff/info/detail_user?id=' . $id_user);
    }

    public function proses_update_peserta()
    {
        $data = (array) $_POST;
        if (!empty($_FILES['paspor_scan']['name'])) {
            $data['files']['paspor_scan'] = $_FILES['paspor_scan'];
        }
        if (!empty($_FILES['paspor_scan2']['name'])) {
            $data['files']['paspor_scan2'] = $_FILES['paspor_scan2'];
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
        if (!empty($_FILES['kk_scan']['name'])) {
            $data['files']['kk_scan'] = $_FILES['kk_scan'];
        }
        if (!empty($_FILES['vaksin_scan']['name'])) {
            $data['files']['vaksin_scan'] = $_FILES['vaksin_scan'];
        }

        $this->load->model('registrasi');
        $result = $this->registrasi->updateMember($data);
        $redir_string = base_url() . 'staff/info/detail_user?id=' . $_POST['id_user'];
        if (isset($_POST['id_member'])) {
            $redir_string = $redir_string . '&id_member=' . $_POST['id_member'];
        }
        redirect($redir_string);
    }
    public function proses_update_imigrasi()
    {
        $this->load->model('tarif');
        $ver = $this->tarif->verifDokumen($_POST['id_member'], $_POST['status']);

        $data = $_POST;
        if (!empty($_FILES['imigrasi']['name'])) {
            $data['files']['imigrasi'] = $_FILES['imigrasi'];
        }
        if (!empty($_FILES['kemenag']['name'])) {
            $data['files']['kemenag'] = $_FILES['kemenag'];
        }

        $this->load->model('registrasi');
        $result = $this->registrasi->updateImigrasi($data);
        $redir_string = base_url() . 'staff/request_dokumen';
        if (isset($_POST['id_member'])) {
            $redir_string = $redir_string;
        }
        redirect($redir_string);
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

    public function getTempatLahir()
    {
        $term = $this->input->get('term');
        $this->load->model('region');
        $kota = $this->region->getRegionAutoComplete($term);
        echo json_encode($kota);
    }

    public function getCountries()
    {
        $term = $this->input->get('term');
        $this->load->model('region');
        $negara = $this->region->getCountriesAutoComplete($term);
        echo json_encode($negara);
    }

    public function getJamaah()
    {
        $ktp = $this->input->get('ktp');
    }

    public function load_jamaah()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'user';
        // Primary key of table
        $primaryKey = 'id_user';

        $columns = array(
            array('db' => '`u`.`id_user`', 'dt' => 'DT_RowId', 'field' => 'id_user'),
            array('db' => '`u`.`name`', 'dt' => 'name', 'field' => 'name'),
            array('db' => '`u`.`email`', 'dt' => 'email', 'field' => 'email'),
            array('db' => '`u`.`no_wa`', 'dt' => 'no_wa', 'field' => 'no_wa'),
            array('db' => 'GROUP_CONCAT(CONCAT("- ",`pu`.`nama_paket`,"<br>(",DATE_FORMAT(`pu`.`tanggal_berangkat`,"%e %b %Y"),")") SEPARATOR ",<br>") AS all_paket', 'dt' => 'all_paket', 'field' => 'all_paket'),
            array('db' => '`pu`.`nama_paket`', 'dt' => 'nama_paket', 'field' => 'nama_paket'),
            array('db' => '`pu`.`id_paket`', 'dt' => 'id_paket', 'field' => 'id_paket'),
            array('db' => '`pm`.`register_from`', 'dt' => 'register_from', 'field' => 'register_from'),
            array('db' => '`pm`.`tgl_regist`', 'dt' => 'tgl_regist', 'field' => 'tgl_regist')
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $joinQuery = "FROM `{$table}` AS `u` LEFT JOIN `program_member` AS `pm` ON (`u`.`id_user` = `pm`.`id_user`)"
            . "LEFT JOIN `paket_umroh` AS `pu` ON (`pu`.`id_paket` = `pm`.`id_paket`)";
        $groupBy = "`u`.`id_user`";
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, null, $groupBy);
        foreach ($data['data'] as $key => $d) {
            $data['data'][$key]['DT_RowAttr'] = array(
                'id_paket' => $d['id_paket'] 
            );
        }
        echo json_encode($data);
    }

    public function hapus_upload()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id_member', 'id_member', 'trim|required|integer');
        $this->form_validation->set_rules('field', 'field', 'required');

        if ($this->form_validation->run() == FALSE) {
            return false;
        }
        $this->load->model('registrasi');
        $result = $this->registrasi->deleteUpload($_GET['id_member'], $_GET['field']);
        if ($result == true) {
            echo json_encode(true);
        } else {
            return false;
        }
    }

    public function hapus_surat_dokter()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id_jamaah', 'id_jamaah', 'trim|required|integer');
        $this->form_validation->set_rules('field', 'field', 'required');

        if ($this->form_validation->run() == FALSE) {
            return false;
        }
        $this->load->model('registrasi');
        $result = $this->registrasi->deleteSuratDokter($_GET['id_jamaah'], $_GET['field']);
        if ($result == true) {
            echo json_encode(true);
        } else {
            return false;
        }
    }
    public function hapus_imigrasi()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id_request', 'id_request', 'trim|required|integer');
        $this->form_validation->set_rules('field', 'field', 'required');

        if ($this->form_validation->run() == FALSE) {
            return false;
        }
        $this->load->model('registrasi');
        $result = $this->registrasi->deleteImigrasi($_GET['id_request'], $_GET['field']);
        if ($result == true) {
            echo json_encode(true);
        } else {
            return false;
        }
    }

    public function agen_autocomplete()
    {
        $term = $_GET['r']['term'];
        $this->load->model('agen');
        $data = $this->agen->getAgen($term, 10);
        echo json_encode($data);
    }

    public function data_peserta() {
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage(null, false, false);
        if (isset($_GET['id_paket'])) {
            $id_paket = $_GET['id_paket'];
        } else {
            $id_paket = $paket[0]->id_paket;
        }

        $selectedPaket = $this->paketUmroh->getPackage($id_paket, false, false, false);

        $nama_paket = $selectedPaket->nama_paket . ' (' . date_format(date_create($selectedPaket->tanggal_berangkat), "d F Y") . ')';

        $data = array(
            'paket' => $paket,
            'id_paket' => $id_paket,
            'nama_paket' => $nama_paket
        );
        $this->load->view('staff/peserta_paket', $data);
    }

    public function load_peserta()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'program_member';
        // Primary key of table
        $primaryKey = 'id_member';

        $columns = array(
            array('db' => 'pm.id_member', 'dt' => 'DT_RowId', 'field' => 'id_member'),
            array('db' => 'pm.id_user', 'dt' => 'id_user', 'field' => 'id_user'),
            array('db' => 'pm.id_paket', 'dt' => 'id_paket', 'field' => 'id_paket'),
            array('db' => 'u.name', 'dt' => 'name', 'field' => 'name'),
            array('db' => 'u.email', 'dt' => 'email', 'field' => 'email'),
            array('db' => 'u.no_wa', 'dt' => 'no_wa', 'field' => 'no_wa'),
            array('db' => 'pu.nama_paket', 'dt' => 'nama_paket', 'field' => 'nama_paket'),
            array('db' => 'register_from', 'dt' => 'register_from', 'field' => 'register_from'),
            array('db' => 'tgl_regist', 'dt' => 'tgl_regist', 'field' => 'tgl_regist')
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $joinQuery = "FROM {$table} AS pm LEFT JOIN user as u ON (pm.id_user = u.id_user)"
        . " LEFT JOIN paket_umroh as pu ON (pm.id_paket = pu.id_paket)";
        $id_paket = $_GET['id_paket'];
        $extraCondition = "pm.id_paket = $id_paket";
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition);
        foreach ($data['data'] as $key => $d) {
            $data['data'][$key]['DT_RowAttr'] = array(
                'id_paket' => $d['id_paket'] 
            );
        }
        echo json_encode($data);
    }
}