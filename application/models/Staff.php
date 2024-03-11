<?php

class Staff extends CI_Model {

    public function getStaff($id) {
        $this->db->where('id_staff', $id);
        $query = $this->db->get('staff');
        $row = $query->row();
        return $row;
    }

    public function getStaffByName($term, $limit = 5)
    {
        $data = $this->db->like('nama', $term)
            ->get('staff')->result_array();
        return $data;
    }

    public function getUser() {
        $query = $this->db->get('staff');
        $data = $query->result();
        return $data;
    }

    public function checkPassword($id, $sbm_pass) {
        $staff = $this->getStaff($id);
        $db_pass = $staff->password;
        if (password_verify($sbm_pass, $db_pass)) {
            return true;
        } else {
            return false;
        }
    }

    public function changePassword($id, $oldPass, $newPass) {
        // ambil data sebelumnya 
        $this->db->where('id_staff', $id);
        $before = $this->db->get('staff')->row();
        ////////////////////////////////////////////

        if (!$this->checkPassword($id, $oldPass)) {
            $this->alert->set('danger', 'Password Lama salah');
            return false;
        }
        $hashPass = password_hash($newPass, PASSWORD_BCRYPT);
        $this->db->where('id_staff', $id);
        $data = array('password' => $hashPass);
        if ($this->db->update('staff', $data)) {
            $this->alert->set('success', 'Password berhasil diubah');
        } else {
            $this->alert->set('danger', 'Terjadi kesalahan pada server, silakan coba lagi!');
            return false;
        }

        // ambil data sesudahnya 
        $this->db->where('id_staff', $id);
        $after = $this->db->get('staff')->row();
        ////////////////////////////////////////////

        //add log
        $this->load->model('logs');
        $this->logs->addLogTable($id, 's' ,$before, $after);
        return true;
    }

    public function changePic($id, $file) {
        // ambil data sebelumnya 
        $this->db->where('id_staff', $id);
        $before = $this->db->get('staff')->row();
        ////////////////////////////////////////////

        $target_dir = '/home/ventourc/public_html/app/asset/images/staff/';
        $imageFileType = strtolower(pathinfo(basename($file["name"]), PATHINFO_EXTENSION));
        $fileName = $id . '.' . $imageFileType;
        $target_file = $target_dir . $fileName;


        // Check if image file is a actual image or fake image
        $check = getimagesize($file["tmp_name"]);
        if ($check == false) {
            $this->alert->set('danger', 'File bukan sebuah gambar');
            return false;
        }

        // Check file size
        if ($file["size"] > 5000000) {
            $this->alert->set('danger', 'File terlalu besar, ukuran maksimal 5 MB');
            return false;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $this->alert->set('danger', 'Hanya file JPG, JPEG, PNG & GIF yang diizinkan');
            return false;
        }

        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            $this->db->where('id_staff', $id);
            $this->db->update('staff', array('image' => $fileName));
            $this->alert->set('success', 'Profile Picture berhasil diganti');
        } else {
            $this->alert->set('danger', 'Terjadi error pada server, mohon coba kembali');
            return false;
        }

        // ambil data sesudahnya 
        $this->db->where('id_staff', $id);
        $after = $this->db->get('staff')->row();
        ////////////////////////////////////////////

        //add log
        $this->load->model('logs');
        $this->logs->addLogTable($id, 's' ,$before, $after);
        return true;
    }

    public function checkEmail($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('staff');
        $data = $query->row();
        return $data;
    }

    public function changeProfile($id, $nama, $email) {

        // ambil data sebelumnya 
        $this->db->where('id_staff', $id);
        $before = $this->db->get('staff')->row();
        ////////////////////////////////////////////

        //check if email already taken by others
        $email_check = $this->checkEmail($email);
        if (isset($email_check->id_staff)) {
            if ($id != $email_check->id_staff) {
                $this->alert->set('danger', 'Email sudah digunakan orang lain');
                return false;
            }
        }

        //update profile
        $data = array(
            'nama' => $nama,
            'email' => $email
        );
        $this->db->where('id_staff', $id);
        if ($this->db->update('staff', $data)) {
            $this->alert->set('success', 'Profile berhasil diubah');
        } else {
            $this->alert->set('danger', 'System Error, Silakan coba kembali');
            return false;
        }

        // ambil data sesudahnya 
        $this->db->where('id_staff', $id);
        $after = $this->db->get('staff')->row();
        ////////////////////////////////////////////

        //add log
        $this->load->model('logs');
        $this->logs->addLogTable($id, 's' ,$before, $after);
        return true;
    }

    public function addStaff($nama, $email, $bagian) {
        //check if email already exist
        $email_check = $this->checkEmail($email);
        if (isset($email_check->id_staff)) {
            $this->alert->set('danger', 'Email sudah digunakan orang lain');
            return false;
        }

        //hash default password
        $pass = password_hash('ventourpass', PASSWORD_BCRYPT);
        $data = array(
            'nama' => $nama,
            'email' => $email,
            'bagian' => $bagian,
            'password' => $pass
        );
        //add to db
        if ($this->db->insert('staff', $data)) {
            $this->alert->set('success', 'Staff berhasil ditambahkan');
//            return true;
        } else {
            $this->alert->set('danger', 'System Error, silakan coba kembali');
            return false;
        }



        //add log
        $insert_id = $this->db->insert_id();
        // ambil data sebelumnya 
        $this->db->where('id_staff', $insert_id);
        $after = $this->db->get('staff')->row();
        ////////////////////////////////////////////

        $this->load->model('logs');
        $this->logs->addLogTable($insert_id, 'staff' ,null, $after);
        return true;
    }

    public function checkId($id) {
        $this->db->where('id_staff', $id);
        $query = $this->db->get('staff');
        $data = $query->row();
        return $data;
    }

    public function resetPassword($id) {
        // ambil data sebelumnya 
        $this->db->where('id_staff', $id);
        $before = $this->db->get('staff')->row();
        ////////////////////////////////////////////

        //check if id exist
        $id_check = $this->checkId($id);
        if (!isset($id_check->id_staff)) {
            $this->alert->set('danger', 'Staff tidak ditemukan');
            return false;
        }

        $nama = $id_check->nama;
        //reset password
        //hash default password
        $pass = password_hash('ventourpass', PASSWORD_BCRYPT);
        $this->db->where('id_staff', $id);
        if ($this->db->update('staff', array('password' => $pass))) {
            $this->alert->set('success', "Password berhasil diubah menjadi 'ventourpass' untuk $nama");
        } else {
            $this->alert->set('danger', 'System Error, silakan coba kembali');
            return false;
        }

        // ambil data sebelumnya 
        $this->db->where('id_staff', $id);
        $after = $this->db->get('staff')->row();
        ////////////////////////////////////////////

        //add log
        $this->load->model('logs');
        $this->logs->addLogTable($id, 's' ,$before, $after);
        return true;
    }

    public function editStaff($id, $data) {
        //check if id exist
        $id_check = $this->checkId($id);
        if (!isset($id_check->id_staff)) {
            $this->alert->set('danger', 'Staff tidak ditemukan');
            return false;
        }

        //check if email already exist
        if (isset($data['email'])) {
            $email_check = $this->checkEmail($data['email']);
            if (isset($email_check->id_staff)) {
                if ($id != $email_check->id_staff) {
                    $this->alert->set('danger', 'Email sudah digunakan orang lain');
                    return false;
                }
            }
        }
        // ambil data sebelumnya
        $this->db->where('id_staff', $id);
        $before = $this->db->get('staff')->row();
        //////////////////////////////////
        

        $this->db->where('id_staff', $id);
        if ($this->db->update('staff', $data)) {
            $this->alert->set('success', "Data berhasil diubah");
        } else {
            $this->alert->set('danger', 'System Error, silakan coba kembali');
            return false;
        }

        // ambil data sesudahnya
        $this->db->where('id_staff', $id);
        $after = $this->db->get('staff')->row();
        //////////////////////////////////

        //add log
        $this->load->model('logs');
        $this->logs->addLogTable($id, 's' ,$before, $after);
        return true;
    }

    public function deleteStaff($id) {
        //delete Staff
        $this->db->where('id_staff', $id);
        if ($this->db->delete('staff')) {
            $this->alert->set('success', 'Staff berhasil dihapus');
        } else {
            $this->alert->set('danger', 'System Error, silakan coba kembali');
            return false;
        }
        return true;
    }

}