<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar extends CI_Controller {

    public function index() {
        $parent_id = null;
        $id = null;
        if (isset($_GET['parent'])) {
            $this->load->model('registrasi');
            $parent = $this->registrasi->getMember($_GET['parent']);
            if (empty($parent)) {
                $this->load->view('jamaah/false_reg');
                return false;
            }
            $parent = $parent[0];
            $parent_id = $parent->id_member;
            $id = $parent->id_paket;
        } else if (!isset($_GET['id'])) {
            $this->load->view('jamaah/false_reg');
            return false;
        }
        if ($id == null) {
            $id = $_GET['id'];
        }

        $this->load->model('PaketUmroh');
        $paket = $this->PaketUmroh->getPackage($id, true, true);
        if (empty($paket)) {
            $this->load->view('jamaah/false_reg');
            return false;
        }
        $data = array(
            'paket' => $paket,
            'parent_id' => $parent_id
        );
        $this->load->view('jamaah/registrasi', $data);
    }

    public function proses() {
        //cek paket
        if (empty($_POST['id_paket'])) {
            $this->load->view('jamaah/false_reg');
            return false;
        }

        $id = $_POST['id_paket'];
        $this->load->model('PaketUmroh');
        $paket = $this->PaketUmroh->getPackage($id, true, true);
        if (empty($paket)) {
            $this->load->view('jamaah/false_reg');
            return false;
        }
        $this->form_validation->set_rules('first_name', 'Nama Depan', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('ktp_no', 'Nomor KTP', 'required|numeric');
        $this->form_validation->set_rules('no_wa', 'Nomor Telepon', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect(base_url() . 'daftar?id=' . $id);
        }
        $this->load->model('registrasi');
        $parent_id = null;
        if (isset($_POST['parent_id'])) {
            $parent_id = $_POST['parent_id'];
            unset($_POST['parent_id']);
        }

        $id_member = $this->registrasi->daftar($_POST);
        if ($id_member == true && $parent_id != null) {
            $this->registrasi->setParent($id_member, $parent_id);
        }

        $this->load->model('customer');
        if ($parent_id == null) {
            $this->customer->setSession($_POST['ktp_no']);
        }
        redirect(base_url() . 'home');
    }

}
