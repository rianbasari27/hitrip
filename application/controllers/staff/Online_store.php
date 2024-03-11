<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Online_store extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }
        if (!($_SESSION['bagian'] == 'Store Admin' || $_SESSION['bagian'] == 'Master Admin')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
    }

    public function index()
    {
        $this->load->view('staff/list_product_view');
    }

    public function load_products()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'store_products';
        // Primary key of table
        $primaryKey = 'product_id';

        $columns = array(
            array('db' => 'product_id', 'dt' => 'DT_RowId'),
            array('db' => 'product_name', 'dt' => 0),
            array('db' => 'price', 'dt' => 1),
            array('db' => 'discount_amount', 'dt' => 2),
            array('db' => 'stock_quantity', 'dt' => 3),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        // if (isset($_GET['month'])) {
        //     if ($_GET['month'] != 0) {
        //         $extraCondition = "MONTH(tanggal_berangkat) =" . $month;
        //     } else {
        //         $extraCondition = null;
        //     }
        // } elseif (!isset($_GET['month'])) {
        //     $extraCondition = null;
        // }

        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, null, null);
        // echo '<pre>';
        // print_r($data['data']);
        // exit();
        foreach ($data['data'] as $key => $d) {
            $data['data'][$key][1] = 'Rp. ' . number_format($d[1], 0, ',', '.') . ',-';
            $data['data'][$key][2] = 'Rp. ' . number_format($d[2], 0, ',', '.') . ',-';
        }
        // echo '<pre>';
        // print_r($data['data']);
        // exit();

        echo json_encode($data);
    }

    public function tambah()
    {
        $this->load->model('store');
        $category = $this->store->getCategory();
        $this->load->view('staff/tambah_product_view', $data = ['category' => $category]);
    }

    public function proses_tambah()
    {
        $this->form_validation->set_rules('product_name', 'Nama Produk', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('description', 'Deskripsi Produk', 'trim|required');
        $this->form_validation->set_rules('short_description', 'Deskripsi Singkat', 'trim|required');
        $this->form_validation->set_rules('category_id', 'Kategori', 'trim|required');
        $this->form_validation->set_rules('price', 'Harga Produk', 'trim|required');
        $this->form_validation->set_rules('stock_quantity', 'Total Stok', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect(base_url() . 'staff/online_store/tambah');
        }

        $data = $_POST;
        $data['price'] = str_replace(",", "", $data['price']);
        $data['discount_amount'] = str_replace(",", "", $data['discount_amount']);
        $data['stock_quantity'] = str_replace(",", "", $data['stock_quantity']);
        if (!empty($_FILES['product_image']['name'])) {
            $data['files']['product_image'] = $_FILES['product_image'];
        }

        //add new product
        $this->load->model('store');
        if (!($id = $this->store->addProduct($data))) {
            redirect(base_url() . 'staff/online_store/tambah');
        } else {
            redirect(base_url() . 'staff/online_store/lihat?id=' . $id);
        }
    }

    public function lihat()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/online_store');
        }
        $this->load->model('store');
        $product = $this->store->getProduct($_GET['id']);
        $data = [
            'product' => $product[0]
        ];
        $this->load->view('staff/lihat_product_view', $data);
    }

    public function delete_image()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/online_store');
        }

        $this->load->model('store');
        $result = $this->store->deleteProductImage($_GET['id']);
        if ($result) {
            $this->alert->set('success', "Data berhasil dihapus");
        } else {
            $this->alert->set('danger', "Data gagal dihapus");
        }
        redirect(base_url() . 'staff/online_store/lihat?id=' . $_GET['product_id']);
    }

    public function ubah_product()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/online_store');
        }
        $this->load->model('store');
        $product = $this->store->getProduct($_GET['id']);
        $category = $this->store->getCategory();
        $data = [
            'product' => $product[0],
            'category' => $category
        ];
        $this->load->view('staff/ubah_product_view', $data);
    }

    public function proses_ubah() {
        $this->form_validation->set_rules('product_id', 'Id Product', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('product_name', 'Nama Produk', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('description', 'Deskripsi Produk', 'trim|required');
        $this->form_validation->set_rules('price', 'Harga Produk', 'trim|required');
        $this->form_validation->set_rules('stock_quantity', 'Total Stok', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect(base_url() . 'staff/online_store');
        }

        $data = $_POST;

        $data['price'] = str_replace(",", "", $data['price']);
        $data['discount_amount'] = str_replace(",", "", $data['discount_amount']);
        $data['stock_quantity'] = str_replace(",", "", $data['stock_quantity']);

        $this->load->model('store');
        
        if ($this->store->updateProduct($data)) {
            $this->alert->set('success', 'Data berhasil diubah');
        } else {
            $this->alert->set('danger', 'Data gagal diubah');
        }
         redirect(base_url() . 'staff/online_store/lihat?id=' . $data['product_id']);
    }

    public function proses_hapus() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/online_store');
        }

        $this->load->model('store');
        if ($this->store->deleteProduct($_GET['id'])) {
            $this->alert->set('success', 'Data Product berhasil di upload') ;
        } else {
            $this->alert->set('danger', 'Data Product gagal di upload') ;
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function upload_image()
    {
        $this->load->model('store');
        if($this->store->uploadImagesProduct($_FILES, $_POST['id'])) {
            $this->alert->set('success', 'Gambar berhasil di upload') ;
        } else {
            $this->alert->set('danger', 'Gambar gagal di upload') ;
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function kategori() {
        $this->load->view('staff/tambah_kategori_view');
    }

    public function proses_tambah_kategori() {
        $this->form_validation->set_rules('category_name', 'Nama Kategori', 'trim|required|alpha_numeric_spaces');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect(base_url() . 'staff/online_store/tambah');
        }

        $data = $_POST;

        //add new product
        $this->load->model('store');
        if (!($id = $this->store->addCategory($data))) {
            redirect(base_url() . 'staff/online_store/kategori');
        } else {
            redirect(base_url() . 'staff/online_store/list_category');
        }
    }

    public function list_category() {
        $this->load->view('staff/list_category_view');
    }

    public function load_kategori()
    {
        include APPPATH . 'third_party/ssp.class.php';
        $table = 'store_category';
        // Primary key of table
        $primaryKey = 'category_id';

        $columns = array(
            array('db' => 'category_id', 'dt' => 'DT_RowId'),
            array('db' => 'category_name', 'dt' => 0)
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );

        $data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, null, null);
        echo json_encode($data);
    }

    public function proses_hapus_kategori() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url() . 'staff/online_store/list_category');
        }

        $this->load->model('store');
        if ($this->store->deleteCategory($_GET['id'])) {
            $this->alert->set('success', 'Data Kategori berhasil di upload') ;
        } else {
            $this->alert->set('danger', 'Data Kategori gagal di upload') ;
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function upload_banner() {
        $this->load->model('galeriJamaah');
        $bannerPromo = $this->galeriJamaah->getStoreBanner();
        $data = [
            "bannerPromo" => $bannerPromo
        ];
        $this->load->view('staff/upload_banner_store_view', $data);
    }

    public function proses_upload_banner() {
        $this->load->model('store');
        if($this->store->uploadImagesBanner($_FILES)) {
            $this->alert->set('success', 'Gambar berhasil di upload') ;
        } else {
            $this->alert->set('danger', 'Gambar gagal di upload') ;
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    function delete_banner() {
        // Lakukan pengecekan jika $imageId ada dan merupakan nomor
        if(isset($_GET['id'])) {
            // Mendapatkan path gambar dari database atau dari direktori yang sesuai
            $imagePath = SITE_ROOT . '/uploads/store_banner/' . $_GET['id']; // Misalnya, mengasumsikan $imageId adalah nama file
            // Lakukan pengecekan apakah file ada sebelum dihapus
            if(file_exists($imagePath)) {
                // Hapus file gambar
                if(unlink($imagePath)) {
                $this->alert->set('success', "Banner berhasil dihapus :)");
                redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $this->alert->set('danger', "Banner gagal dihapus :)");
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $this->alert->set('danger', "Banner gagal dihapus :)");
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $this->alert->set('danger', "Banner gagal dihapus :)");
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}