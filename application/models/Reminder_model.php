<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Reminder_model extends CI_Model
{
    public function addReminder($data) {
        $data['staff'] = $_SESSION['nama'];
        $insert = $this->db->insert('reminder', $data);
        if (!$insert) {
            $this->alert->set('danger', 'Daftar gagal ditambahkan!!');
            return false;
        }

        return true;
    }

    public function getReminder($id = null) {
        if ($id != null) {
            $this->db->where('id_reminder', $id);
        }
        $data = $this->db->get('reminder')->result();
        if (empty($data)) {
            return false;
        }

        return $data ;
    }

    public function otomatis_reminder() {
        $data = $this->getReminder();
        if (!$data) {
            return false;
        }

        foreach ($data as $d) {
            $jadwal = explode(',', $d->jadwal);
            foreach ($jadwal as $j) {
                if ($d->status == 'tahun') {
                    $tgl_reminder = date("Y") . "-$d->tgl_reminder";
                }
                if ($d->status == 'bulan') {
                    $tgl_reminder = date("Y") . "-" . date("m") . "-$d->tgl_reminder";
                }

                $tanggal = new DateTime($tgl_reminder);
                $tanggal->modify("-$j days");
                $interval = $tanggal->format("Y-m-d");
                
                if ($interval == date("Y-m-d")) {
                    $this->load->library('money');
                    // $nominal = $this->money->format($d->nominal);
                    // echo '<pre>';
                    // print_r($nominal);
                    // exit();
                    $date = $this->date->convert_date_indo($tgl_reminder);
                    $this->load->model('Whatsapp');
                    // $this->load->library('Date');
                    if ($d->wa_number1 != null) {
                        $this->Whatsapp->sendReminder($d->keterangan, $date, $d->nominal, $d->wa_number1);
                    }
                    if ($d->wa_number2 != null) {
                        $this->Whatsapp->sendReminder($d->keterangan, $date, $d->nominal, $d->wa_number2);
                    }
                    if ($d->wa_number3 != null) {
                        $this->Whatsapp->sendReminder($d->keterangan, $date, $d->nominal, $d->wa_number3);
                    }
                }
            }
        }
    }

    public function editReminder($data) {
        $id_reminder = $data['id_reminder'];
        unset($data['id_reminder']);
        $this->db->where('id_reminder', $id_reminder);
        $result = $this->db->update('reminder', $data);
        if (!$result) {
            return false;
        }

        return true;
    }

    public function deleteReminder($id) {
        $this->db->where('id_reminder', $id);
        if (!$this->db->delete('reminder')) {
            return false;
        } else {
            return true;
        }
    }
}