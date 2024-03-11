<?php

class Logistik_office extends CI_Model
{
    public function addBarangOffice($data)
    {
        
        $this->load->library('scan');
        if (isset($data['foto_status'])) {
            $hasil = $this->scan->check($data['foto_status'], 'foto_status', null);
            if ($hasil !== false) {
                $data['foto_status'] = $hasil;
            }
        }
        
        $query = $this->db->insert('barang_perlengkapan_office', $data);
        if ($query == false) {
            return false;
        }
        //add log
        $id = $this->db->insert_id();

        // ambil data sesudahnya
        $this->db->where('id_barang', $id);
        $after = $this->db->get('barang_perlengkapan_office')->row();
        //////////////////////////////////

        $this->load->model('logs');
        $this->logs->addLogTable($id, 'bpo', null, $after);
        return $id;
    }

    public function getBarangOffice($id = null)
    {
        if ($id != null ) {
            $this->db->where('id_barang', $id);
        }
        $query = $this->db->get('barang_perlengkapan_office')->result();
        
        return $query;
    }

    public function deleteBarangOffice($id) {
        $this->db->where('id_barang', $id);
        if (!$this->db->delete('barang_perlengkapan_office')) {
            return false ;
        }

        return true ;
    }

    public function addRequestOrder($data, $status = "lama", $info = "Request")
    {   
        if (isset($data['id_barang'])) {
            $id_barang = $data['id_barang'];
        }

        if (isset($data['id_staff_request'])) {
            $id_staff_request = $data['id_staff_request'];
        } else {
            $id_staff_request = $_SESSION['id_staff'] ;
        }
        
        //jika belum ada barangnya, di insert barangnya terlebih dahulu
        if ($status == "baru") {
            $insBarang = array (
                "nama" => $data['nama'],
                "jenis" => null,
                "keterangan" => null,
                "stock" => 0,
                "status" => null,
                "foto_status" => null,
                "tanggal_beli" => date('Y-m-d'),
                "harga" => 0
            );

            $id_barang = $this->addBarangOffice($insBarang);
        }

        //data request
        $insData = array(
            "id_barang" => $id_barang,
            "jumlah" => $data['stock'],
            "id_staff_request" => $id_staff_request,
            "info" => $info,
            "keterangan_tambahan" => $data['keterangan_tambahan'],
            "divisi" => $data['divisi'],
            "status_request" => $info == "Request" ? '0' : '2'
        );

        if (!$this->db->insert('request_order_perlengkapan_office', $insData)) {
            return false;
        }

        $id = $this->db->insert_id();

        //add mutasi
        // $insMutasi = array();
        // ambil data sesudahnya
        $this->db->where('id_req_order', $id);
        $after = $this->db->get('request_order_perlengkapan_office')->row();
        //////////////////////////////////

        ////add log
        $this->load->model('logs');
        $this->logs->addLogTable($id, 'ropo', null, $after);
        
        return $id;
    }

    public function getRequestPerlengkapanOrder($id_req_order = null) {
        if ($id_req_order != null) {
            $this->db->where('id_req_order', $id_req_order);
        }
        $result = $this->db->get('request_order_perlengkapan_office')->result();

        return $result;
    }

    public function setStatusRequest($id_req_order, $status_request) {
        $this->db->where('id_req_order', $id_req_order);
        $this->db->set('status_request', $status_request);

        if (!$this->db->update('request_order_perlengkapan_office')) {
            return false;
        }

        return true;
    }

    public function uploadGambarStatus($data, $id) {
        if (isset($data['foto_status'])) {
            $this->load->library('scan');
            $hasil = $this->scan->check($_FILES['foto_status'], 'foto_status', null);
            $this->db->where('id_barang', $id);
            $this->db->set('foto_status', $hasil);

            if (!$this->db->update('barang_perlengkapan_office')) {
                return false ;
            }

            return true ;
        }

        return false ;
    }

    public function deleteGambarStatus($id)
    {
        $this->db->where('id_barang', $id);
        $barang = $this->db->get('barang_perlengkapan_office')->row();
        if ($barang->foto_status == null) {
            return false;
        }


        $path = $barang->foto_status;
        unlink(SITE_ROOT . $path);

        $this->db->where('id_barang', $id);
        $this->db->set('foto_status', null);
        if (!$this->db->update('barang_perlengkapan_office')) {
            return false ;
        }
        
        return true ;
    }

    public function updateBarangOffice($data)
    {
        // ambil data sesudahnya
        $this->db->where('id_barang', $data['id_barang']);
        $before = $this->db->get('barang_perlengkapan_office')->row();
        //////////////////////////////////
        $id = $data['id_barang'];
        unset($data['id_barang']);

        $this->db->where('id_barang', $id);
        if (!$this->db->update('barang_perlengkapan_office', $data)) {
            return false ;
        }
        // ambil data sesudahnya
        $this->db->where('id_barang', $id);
        $after = $this->db->get('barang_perlengkapan_office')->row();
        //////////////////////////////////

        //add log
        $this->load->model('logs');
        $this->logs->addLogTable($id, 'bpo', $before, $after);

        return true;
    }

    public function getListJenis() {
        $this->db->where("jenis IS NOT NULL");
        $this->db->group_by("jenis");
        $result = $this->db->get("barang_perlengkapan_office")->result();

        return $result ;
    }

    public function getStatusRequest() {
        $this->db->where("status_request IS NOT NULL");
        $this->db->group_by("status_request");
        $result = $this->db->get("request_order_perlengkapan_office")->result();

        return $result ;
    }

    public function addOrderPerlengkapanOffice($data, $operator = "tambah") {

        if (!isset($data['id_barang'])) {
            return false ;
        }

        // get stok before
        $barang = $this->getBarangOffice($data['id_barang']);
        $stok_before = $barang[0]->stock;

        if ($operator == "tambah") {
            $operator = "+";
        } else {
            $this->db->where('id_barang', $data['id_barang']);
            $barang = $this->db->get('barang_perlengkapan_office')->row();
            if ($barang->stock < $data['jumlah']) {
                $data = [
                    'type' => "danger",
                    'msg' => "Jumlah Permintaan melebihi stok yang ada, silahkan di sesuaikan"
                ];
                return $data ;
            }
            $operator = "-" ;
        }


        if (isset($data['jumlah'])) {
            $jumlah = $data['jumlah'];
        } else {
            $jumlah = 0;
        }

        if (isset($data['id_staff_order'])) {
            $id_staff = $data['id_staff_order'];
        } else {
            $id_staff = $_SESSION['id_staff'];
        }

        if (isset($data['id_request_order'])) {
            $id_request_order = $data['id_request_order'];
        } else {
            $id_request_order = null;
        }

        if (isset($data['keterangan'])) {
            $keterangan = $data['keterangan'];
        } else {
            $keterangan = null;
        }

        $insData = [
            "id_barang" => $data['id_barang'],
            "jumlah" => $jumlah,
            "id_staff_order" => $id_staff,
            "id_request_order" => $id_request_order,
            "keterangan" => $keterangan,
            "stok_before" => $stok_before,
            "stok_after" => $stok_before + $jumlah,
        ];

        if (!$this->db->insert("order_perlengkapan_office", $insData)) {
            return false ;
        }

        return true; 
    }

    public function getOrderPerlengkapanOffice($id_order = null) {
        if ($id_order != null) {
            $this->db->where('id_order', $id_order);
        }

        $query = $this->db->get('order_perlengkapan_office')->result();
        return $query;
    }

    public function setStokBarangOffice($id_barang, $jumlah, $operator = "tambah") {

        if ($id_barang == null || $id_barang == '' || $id_barang == 0) {
            $data = [
                'type' => "danger",
                'msg' => "ID barang tidak ditemukan"
            ];
            return $data ;
        }

        if ($operator == "tambah") {
            $operator = "+";
        } else {
            $this->db->where('id_barang', $id_barang);
            $barang = $this->db->get('barang_perlengkapan_office')->row();
            if ($barang->stock < $jumlah) {
                $data = [
                    'type' => "danger",
                    'msg' => "Jumlah OUT melebihi stok yang ada, silahkan di sesuaikan"
                ];
                return $data ;
            }
            $operator = "-" ;
        }
        // update stock
        $this->db->where('id_barang', $id_barang);
        $this->db->set('stock', 'stock ' . $operator . ' ' . $jumlah, FALSE);
        if (!$this->db->update('barang_perlengkapan_office')) {
            $data = [
                'type' => "danger",
                'msg' => "Terjadi kesalahan, proses gagal"
            ];
            return $data ;
        }

        return true ;
    }

    public function addKeluarPerlengkapanOffice($data) {

        if (!isset($data['id_barang'])) {
            return false ;
        }

        if (isset($data['stok_before'])) {
            $stok_before = $data['stok_before'];
        } else {
            // get stok before
            $barang = $this->getBarangOffice($data['id_barang']);
            $stok_before = $barang[0]->stock;
        }

        if (isset($data['jumlah'])) {
            $jumlah = $data['jumlah'];
        } else {
            $jumlah = 0;
        }

        if (isset($data['id_staff'])) {
            $id_staff = $data['id_staff'];
        } else {
            $id_staff = $_SESSION['id_staff'];
        }

        if (isset($data['keterangan'])) {
            $keterangan = $data['keterangan'];
        } else {
            $keterangan = null;
        }

        $insData = [
            "id_barang" => $data['id_barang'],
            "jumlah" => $jumlah,
            "id_staff" => $id_staff,
            "keterangan" => $keterangan,
            "stok_before" => $stok_before,
            "stok_after" => $stok_before + $jumlah,
        ];

        if (!$this->db->insert("keluar_perlengkapan_office", $insData)) {
            return false ;
        }

        return true; 
    }

    public function addRequestPinjamPerlengkapanOffice($data) {
        if (!isset($data['id_barang'])) {
            $data = [
                'type' => "danger",
                'msg' => "ID barang tidak ditemukan"
            ];
            return $data ;
        }

        if (isset($data['jumlah'])) {
            $jumlah = $data['jumlah'];
        } else {
            $jumlah = 1;
        }

        if (isset($data['tanggal_request'])) {
            $tanggal_request = $data['tanggal_request'];
        } else {
            $tanggal_request = date("Y-m-d H:i:s");
        }

        if (isset($data['tempat'])) {
            $tempat = $data['tempat'];
        } else {
            $tempat = "Kantor";
        }

        if (isset($data['id_staff_request'])) {
            $id_staff_request = $data['id_staff_request'];
        } else {
            $id_staff_request = $_SESSION['id_staff'];
        }

        if (isset($data['nama_peminjam'])) {
            $nama_peminjam = $data['nama_peminjam'];
        } else {
            $nama_peminjam = $_SESSION['nama'];
        }

        if (isset($data['keperluan'])) {
            $keperluan = $data['keperluan'];
        } else {
            $keperluan = NULL;
        }

        if (isset($data['lama_pinjam'])) {
            $lama_pinjam = $data['lama_pinjam'];
        } else {
            $lama_pinjam = NULL;
        }

        //cek stok dulu
        $barang = $this->getBarangOffice($data['id_barang']);
        $barang = $barang[0];
        if ($barang->stock < $jumlah) {
            $data = [
                'type' => "danger",
                'msg' => "Jumlah Request melebihi stok saat ini"
            ];
            return $data ;
        }


        $insData = array(
            "id_barang" => $data['id_barang'],
            "jumlah_request" => $jumlah,
            "tanggal_request" => $tanggal_request,
            "tempat" => $tempat,
            "id_staff_request" => $id_staff_request,
            "nama_peminjam" => $nama_peminjam,
            "jumlah_approve" => null,
            "tanggal_approve" => null,
            "id_staff_approval" => null,
            "keperluan" => $keperluan,
            "lama_pinjam" => $lama_pinjam
        );

        if (!$this->db->insert('request_pinjam_perlengkapan_office', $insData)) {
            $data = [
                'type' => "danger",
                'msg' => "Terjadi kesalahan, proses Pinjam Gagal"
            ];
            return $data ;
        }
    }

    public function updateRequestPinjamPerlengkapanOffice($data) {

        if (!isset($data['id_req_pinjam'])) {
            $pesan = [
                "type" => "danger",
                "msg" => "Access Denied"
            ];
            return $pesan ;
        }

        $dataPinjam = $this->getRequestPinjamPerlengkapanOffice($data['id_req_pinjam']);
        if (empty($dataPinjam)) {
            $pesan = [
                "type" => "danger",
                "msg" => "Data peminjaman tidak ada"
            ];
            return $pesan ;
        }

        if ($data['jumlah_approve'] > $dataPinjam[0]->jumlah_request) {
            $pesan = [
                "type" => "danger",
                "msg" => "Jumlah Approve melebihi dari jumlah yang di request"
            ];
            return $pesan ;
        }

        // get stok before
        $barang = $this->getBarangOffice($data['id_barang']);
        $stok_before = $barang[0]->stock;

        $updateData = [
            "jumlah_approve" => $data['jumlah_approve'],
            "tanggal_approve" => date('Y-m-d H:i:s'),
            "id_staff_approval" => $_SESSION['id_staff'],
            "status" => 2,
            "stok_before" => $stok_before,
            "stok_after" => $stok_before - $data['jumlah_approve']
        ];

        $this->db->where('id_req_pinjam', $data['id_req_pinjam']);
        if (!$this->db->update('request_pinjam_perlengkapan_office', $updateData)) {
            $pesan = [
                "type" => "danger",
                "msg" => "Terjadi Error pada system :("
            ];
            return $pesan ;
        }

        //set stok
        $this->setStokBarangOffice($dataPinjam[0]->id_barang, $data['jumlah_approve'], "kurang");

        return true ;
    }
    public function getRequestPinjamPerlengkapanOffice($id_req_pinjam = null) {
        if ($id_req_pinjam != null) {
            $this->db->where('id_req_pinjam', $id_req_pinjam);
        }
        $result = $this->db->get('request_pinjam_perlengkapan_office')->result();

        return $result;
    }

    public function checkStatusPinjam($id_req_pinjam) {
        if ($id_req_pinjam == null || $id_req_pinjam == '' || $id_req_pinjam == 0) {
            $pesan = [
                "type" => "danger",
                "msg" => "Access Denied"
            ];
            return $pesan ;
        }

        $dataPinjam = $this->getRequestPinjamPerlengkapanOffice($id_req_pinjam);
        if (empty($dataPinjam)) {
            $pesan = [
                "type" => "danger",
                "msg" => "Data peminjaman tidak ada"
            ];
            return $pesan ;
        }

        // mulai untuk set stok

        $totalDikembalikan = $this->getSumKembaliPerlengkapan($id_req_pinjam);

        if ($totalDikembalikan == $dataPinjam[0]->jumlah_approve) {
            $result = $this->setStatusPinjam($id_req_pinjam, 4);
        } else {
            $result = $this->setStatusPinjam($id_req_pinjam, 3);
        }

        if (!$result) {
            $pesan = [
                "type" => "danger",
                "msg" => "Error, Terjadi kesalahan pada sistem"
            ];
            return $pesan ;
        }

        return true ;
    }

    public function setStatusPinjam($id_req_pinjam, $status) {
        $this->db->where('id_req_pinjam', $id_req_pinjam);
        $this->db->set('status', $status);
        if (!$this->db->update('request_pinjam_perlengkapan_office')) {
            return false ;
        }

        return true;
    }

    public function getBarangDiPinjam($id_barang) {
        $this->db->where('id_barang', $id_barang);
        $this->db->where('status = 2 OR status = 3');
        $result = $this->db->get('request_pinjam_perlengkapan_office')->result();

        return $result ;
    }

    public function addKembaliPerlengkapanOffice($data) {

        //cek apakah jumlah pengembalian lebih dari jumlah approve
        $dataPinjam = $this->getRequestPinjamPerlengkapanOffice($data['id_req_pinjam']);
        $sudahKembali = $this->getSumKembaliPerlengkapan($data['id_req_pinjam']);
        if ($data['jumlah'] > ($dataPinjam[0]->jumlah_approve - $sudahKembali)) {
            $pesan = [
                "type" => "danger",
                "msg" => "Jumlah pengembalian berlebihan"
            ];
            return $pesan ;
        }

        // get stok before
        $pinjam = $this->getRequestPinjamPerlengkapanOffice($data['id_req_pinjam']);
        $barang = $this->getBarangOffice($pinjam[0]->id_barang);
        $stok_before = $barang[0]->stock;



        $insData = [
            "id_req_pinjam" => $data['id_req_pinjam'],
            "jumlah" => $data['jumlah'],
            "id_staff_penerima" => $_SESSION['id_staff'],
            "tanggal_kembali" => date('Y-m-d H:i:s'),
            "stok_before" => $stok_before,
            "stok_after" => $stok_before + $data['jumlah'],
        ];

        if (!$this->db->insert('kembali_perlengkapan_office', $insData)) {
            $pesan = [
                "type" => "danger",
                "msg" => "Error, Terjadi Kesalahan pada sistem"
            ];
            return $pesan ;
        }

        //cek stok
        $cekStok = $this->checkStatusPinjam($data['id_req_pinjam']);
        if ($cekStok['type'] == "danger") {
            $pesan = [
                "type" => $cekStok['type'],
                "msg" => $cekStok['msg']
            ];
            return $pesan ;
        }

        //tambah stok
        $this->setStokBarangOffice($dataPinjam[0]->id_barang, $data['jumlah']);
        return true;
    }

    public function getSumKembaliPerlengkapan($id_req_pinjam) {
        $this->db->select('SUM(jumlah) as total_kembali');
        $this->db->where('id_req_pinjam', $id_req_pinjam);
        $data = $this->db->get('kembali_perlengkapan_office')->row();

        return (int)$data->total_kembali; 
    }
}