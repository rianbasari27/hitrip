<?php

class Logs extends CI_Model {

    public function getTableName($tbl) {
        switch ($tbl) {
            case 's':
                return 'staff';
                break;
            case 'u':
                return 'user';
                break;
            case 'pu':
                return 'paket_umroh';
                break;
            case 'ap':
                return 'agen_paket';
                break;
            case 'ae':
                return 'agen_event';
                break;
            case 'hi':
                return 'hotel_info';
                break;
            case 'ja':
                return 'jamaah';
                break;
            case 'pm':
                return 'program_member';
                break;
            case 'by':
                return 'pembayaran';
                break;
            case 'ef':
                return 'extra_fee';
                break;
            case 'lg':
                return 'logistik';
                break;
            case 'bpo':
                return 'barang_perlengkapan_office';
                break;
            case 'v':
                return 'voucher';
                break;
            case 'lpk':
                return 'log_perlengkapan_kantor';
                break;
            case 'po':
                return 'permintaan_office';
                break;
            case 'pof':
                return 'peminjaman_office';
                break;
            case 'm':
                return 'mutasi_barang';
                break;
            case 'rp':
                return 'refund_pembayaran';
                break;
            case 'agp':
                return 'agen_peserta_paket';
                break;
            case 'sp':
                return 'store_products';
                break;
            case 'ropo':
                return 'store_products';
                break;
            case 'd':
                return 'diskon';
                break;
            default:
                return false;
                break;
        }
    }

    public function getPrimaryKey($tbl) {
        $query = $this->db->query("SHOW KEYS FROM $tbl WHERE Key_name = 'PRIMARY'");
        $data = $query->row();
        return $data->Column_name;
    }

    public function getData($tbl, $id) {
        $tbl_name = $this->getTableName($tbl);
        //get primary key name
        $pk = $this->getPrimaryKey($tbl_name);

        $this->db->where($pk, $id);
        $query = $this->db->get($tbl_name);
        $data = $query->row();

        return $data->log;
    }

    public function getRowData($tbl, $id) {
        $tbl_name = $this->getTableName($tbl);
        //get primary key name
        $pk = $this->getPrimaryKey($tbl_name);

        $this->db->where($pk, $id);
        $query = $this->db->get($tbl_name);
        $data = $query->row();

        return $data;
    }

    public function addLog($tbl, $id) {
        date_default_timezone_set("Asia/Jakarta");
        $log = $this->getData($tbl, $id);
        $log = json_decode($log);
        if(!isset($_SESSION['id_staff'])){
            $id_staff = 2; //customer;
        }else{
            $id_staff = $_SESSION['id_staff'];
        }
        $log[] = array(
            'id_staff' => $id_staff,
            'date' => date("Y-m-d h:i:sa")
        );
        $log_json = json_encode($log);
        $tbl_name = $this->getTableName($tbl);
        $pk = $this->getPrimaryKey($tbl_name);
        $this->db->where($pk, $id);
        $this->db->set('log', $log_json);
        $this->db->update($tbl_name);
        return true;
    }

    public function logView($tbl, $id) {
        $data = $this->getRowData($tbl, $id);
        if (isset($data->log)) {
            $log = json_decode($data->log);
            unset($data->log);
        }
        $this->load->model('staff');
        

        $tbl_name = $this->getTableName($tbl);

        $this->db->where('table_name', $tbl_name);
        $this->db->where('pk_id', $id);
        $this->db->order_by('tanggal_update', 'desc');
        $query =  $this->db->get('log');
        $log = $query->result();


        if (!empty($log)) {
            foreach ($log as $key => $l) {
                $nama = '';
                $email = '';
                $bagian = '';
                if ($l->user == 'j') {
                    if ($l->id_staff != 0) {
                        $this->db->where('id_jamaah', $l->id_staff);
                        $user = $this->db->get('jamaah')->row();
                        if (!empty($user)) {
                            $nama = $user->first_name . " " . $user->second_name . " " . $user->last_name;
                            $email = $user->email;
                            $bagian = "Jamaah";
                        }
                    } else {
                        $nama = 'Jamaah';
                        $email = 'Jamaah';
                        $bagian = "Jamaah";
                    }
                }
                if ($l->user == 'k') {
                $this->db->where('id_agen', $l->id_staff);
                $user = $this->db->get('agen')->row();
                    if (!empty($user)) {
                        $nama = $user->nama_agen;
                        $email = $user->email;
                        $bagian = "Konsultan";
                    }
                }
                if ($l->user == 's') {
                $this->db->where('id_staff', $l->id_staff);
                $user = $this->db->get('staff')->row();
                    if (!empty($user)) {
                        $nama = $user->nama;
                        $email = $user->email;
                        $bagian = $user->bagian;
                    }
                }
                $log[$key]->data_sebelum = json_decode($l->data_before);
                $log[$key]->data_sesudah = json_decode($l->data_new);
                $log[$key]->nama = $nama;
                $log[$key]->email = $email;
                $log[$key]->bagian = $bagian;
            }
        }
        $endData = array(
            'data' => $data,
            'log' => $log
        );
        return $endData;
    }

    public function addLogTable($pk_id, $tbl, $before, $after) {
        if (isset($before->log)) {
            unset($before->log);
        }
        if (isset($after->log)) {
            unset($after->log);
        }

        if (!empty($before->log)) {
            unset($before->log);
        }
        if (!empty($after->log)) {
            unset($after->log);
        }
        $tbl_name = $this->getTableName($tbl);
        $id = '';
        $user = '';
        if (isset($_SESSION['id_user'])) {
            $id = $_SESSION['id_user'];
            $user = 'u';
        } else {
            $id = '' ;
            $user = 'u';
        }

        if (isset($_SESSION['id_agen'])) {
            $id = $_SESSION['id_agen'];
            $user = 'k';
        }

        if (isset($_SESSION['id_staff'])) {
            $id = $_SESSION['id_staff'];
            $user = 's';
        }


        $addTableLog = [
            'id_staff' => $id,
            'user' => $user,
            'table_name' => $tbl_name,
            'pk_id' => $pk_id,
            'data_before' => json_encode($before),
            'data_new' => json_encode($after),
        ];
        $this->db->insert('log', $addTableLog);
        return true;
    }

    public function tableLogView($id_log) {
        $this->db->where('id_log', $id_log);
        $query = $this->db->get('log');
        $data = $query->row();

        $data->data_before = json_decode($data->data_before);
        $data->data_new = json_decode($data->data_new);
        if (empty($data->data_new->log) || !empty($data->data_new->log)) {
            unset($data->data_new->log);
        }
        if (empty($data->data_before->log) || !empty($data->data_before->log)) {
            unset($data->data_before->log);
        }

        return $data;
        
    }

}