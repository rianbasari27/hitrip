<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reminder extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('reminder_model');
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }
    }

    public function index() {
        $this->load->view('staff/reminder_view');
    }

    public function proses_tambah() 
    {
        $this->form_validation->set_rules('keterangan', "Keterangan", "trim|required");
        $this->form_validation->set_rules('nominal', 'Nominal', 'trim|required');
        $this->form_validation->set_rules('status', 'Reminder', 'trim|required');
        $this->form_validation->set_rules('jadwal', 'Jadwal Reminder', 'trim|required');
        $this->form_validation->set_rules('wa_number1', 'No WhatsApp ke-1', 'trim|required|integer');
        if($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect(base_url()."staff/reminder");
        }

        $data = $_POST;
        if ($data['status'] == 'bulan') {
            $data['tgl_reminder'] = $data['tgl_bulan'];
        }

        if ($data['status'] == 'tahun') {
            $data['tgl_reminder'] = $data['tgl_tahun'];
        }
        unset($data['tgl_bulan']);
        unset($data['tgl_tahun']);
        $data['nominal'] = str_replace(",", "", $_POST['nominal']);
        $result = $this->reminder_model->addReminder($data);
        if ($result) {
            $this->alert->set("success", "Daftar reminder berhasil ditambahkan");
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function jadwal_reminder() {
        $this->load->view('staff/jadwal_reminder_view');
    }

    public function load_reminder() {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'reminder';
        // Primary key of table
        $primaryKey = 'id_reminder';

        $columns = array(
            array('db' => 'id_reminder', 'dt' => 'DT_RowId', 'field' => 'id_reminder'),
            array('db' => 'keterangan', 'dt' => 'keterangan', 'field' => 'keterangan'),
            array('db' => 'kode_bayar', 'dt' => 'kode_bayar', 'field' => 'kode_bayar'),
            array('db' => 'nominal', 'dt' => 'nominal', 'field' => 'nominal'),
            array('db' => 'tgl_reminder', 'dt' => 'tgl_reminder', 'field' => 'tgl_reminder'),
            array('db' => 'status', 'dt' => 'status', 'field' => 'status'),
            array('db' => 'jadwal', 'dt' => 'jadwal', 'field' => 'jadwal'),
            array('db' => 'wa_number1', 'dt' => 'wa_number1', 'field' => 'wa_number1'),
            array('db' => 'wa_number2', 'dt' => 'wa_number2', 'field' => 'wa_number2'),
            array('db' => 'wa_number3', 'dt' => 'wa_number3', 'field' => 'wa_number3'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns);

        foreach ($data['data'] as $key => $d) {
            $this->load->library('money');
            $data['data'][$key]['nominal'] = $this->money->format($d['nominal']);

            if ($d['status'] == 'bulan') {
                $date = date("Y") . "-" . date("m") . "-$d[tgl_reminder]";
            }
            if ($d['status'] == 'tahun') {
                $date = date("Y") . "-$d[tgl_reminder]";
            }
            $data['data'][$key]['tgl_reminder'] = $this->date->convert_date_indo($date);

            $jadwal = explode(",", $d['jadwal']);
            $jadwal_view = str_replace(",", " Hari sebelum Tanggal Reminder <br>- ", $d['jadwal']);
            $data['data'][$key]['jadwal'] = "- $jadwal_view Hari sebelum Tanggal Reminder";

            $wa = implode(',', array_filter([$d['wa_number1'], $d['wa_number2'], $d['wa_number3']]));
            $wa_number = str_replace(",", "<br>", $wa);
            $data['data'][$key]['wa_number'] = "- $wa_number" ;
        }
        echo json_encode($data);
    }

    public function edit() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $data = $this->reminder_model->getReminder($_GET['id']);
        if (!$data) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->load->view('staff/edit_reminder_view', $data[0]);
        }
    }

    public function proses_edit() {
        $this->form_validation->set_rules('keterangan', "Keterangan", "trim|required");
        $this->form_validation->set_rules('nominal', 'Nominal', 'trim|required');
        $this->form_validation->set_rules('status', 'Reminder', 'trim|required');
        $this->form_validation->set_rules('jadwal', 'Jadwal Reminder', 'trim|required');
        $this->form_validation->set_rules('wa_number1', 'No WhatsApp ke-1', 'trim|required|integer');
        if($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect(base_url()."staff/reminder");
        }

        $data = $_POST;
        if ($data['status'] == 'bulan') {
            $data['tgl_reminder'] = $data['tgl_bulan'];
        }

        if ($data['status'] == 'tahun') {
            $data['tgl_reminder'] = $data['tgl_tahun'];
        }
        unset($data['tgl_bulan']);
        unset($data['tgl_tahun']);
        $data['nominal'] = str_replace(",", "", $_POST['nominal']);
        $result = $this->reminder_model->editReminder($data);
        if ($result) {
            $this->alert->set("success", "Proses edit berhasil");
        } else {
            $this->alert->set("danger", "Proses edit gagal");
        }
        redirect(base_url() . 'staff/reminder/jadwal_reminder');
    }

    public function hapus() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $data = $this->reminder_model->deleteReminder($_GET['id']);
        if (!$data) {
            $this->alert->set('danger', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->alert->set('success', 'Daftar berhasil dihapus');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}