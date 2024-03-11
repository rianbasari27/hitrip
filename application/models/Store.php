<?php

use Google\Service\Monitoring\Custom;

class Store extends CI_Model
{
    public function addProduct($data)
    {

        $insData = array(
            'product_name' => $data['product_name'],
            'category_id' => $data['category_id'],
            'short_description' => $data['short_description'],
            'description' => $data['description'],
            'price' => $data['price'],
            'discount_amount' => $data['discount_amount'],
            'stock_quantity' => $data['stock_quantity'],
        );


        if ($this->db->insert('store_products', $insData)) {
            $this->alert->set('success', 'Product berhasil ditambahkan');
        } else {
            $this->alert->set('danger', 'System Error, silakan coba kembali');
            return false;
        }
        // insert id
        $insert_id = $this->db->insert_id();


        // ambil data sesudahnya
        $this->db->where('product_id', $insert_id);
        $after = $this->db->get('store_products')->row();
        //////////////////////////////////
        $this->load->model('logs');
        $this->logs->addLogTable($insert_id, 'sp', null, $after);

        // upload image
        $this->uploadImagesProduct($data['files'], $insert_id);
        return $insert_id;
    }

    public function updateProduct($data)
    {
        // ambil data sesudahnya
        $this->db->where('product_id', $data['product_id']);
        $before = $this->db->get('store_products')->row();
        //////////////////////////////////

        $insData = array(
            'product_name' => $data['product_name'],
            'category_id' => $data['category_id'],
            'short_description' => $data['short_description'],
            'description' => $data['description'],
            'price' => $data['price'],
            'discount_amount' => $data['discount_amount'],
            'stock_quantity' => $data['stock_quantity'],
        );

        $this->db->where('product_id', $data['product_id']);
        if (!$this->db->update('store_products', $insData)) {
            return false;
        }

        // ambil data sesudahnya
        $this->db->where('product_id', $data['product_id']);
        $after = $this->db->get('store_products')->row();
        //////////////////////////////////

        $this->load->model('logs');
        $this->logs->addLogTable($data['product_id'], 'sp', $before, $after);

        return true;
    }

    public function deleteProduct($id = null)
    {
        if ($id != null) {
            $this->db->where('product_id', $id);
        }
        if (!$this->db->delete('store_products')) {
            return false;
        }

        return true;
    }

    public function getProduct($id = null, $limit = null, $promo = false)
    {
        if ($id != null) {
            $this->db->where('product_id', $id);
        }
        if ($limit != null) {
            $this->db->limit($limit);
        }
        if ($promo != false) {
            $this->db->where('discount_amount > 0');
        }
        $this->db->order_by('product_id', 'DESC');
        $result = $this->db->get('store_products')->result();
        foreach ($result as $key => $r) {
            $this->load->library('money');
            $productImages = $this->getProductImages(null, $r->product_id);
            $category = $this->getCategory($r->category_id);
            if ($r->discount_amount == NULL && $r->discount_amount == '') {
                $r->discount_amount = 0;
            }
            if ($category) {
                $result[$key]->category  = $category[0]->category_name;
            }
            $result[$key]->priceTotal = $r->price - $r->discount_amount;
            $result[$key]->hargaHome = $this->money->format($r->price);
            $hargaDiscount = $r->price - $r->discount_amount;
            $result[$key]->hargaDiscountHome = $this->money->format($hargaDiscount);
            $result[$key]->hargaDiscountFormat = $this->money->hargaHomeRibu($hargaDiscount);
            $result[$key]->images = $productImages;
        }
        return $result;
    }

    public function getProductImages($id = null, $product_id = null)
    {
        if ($id != null) {
            $this->db->where('image_id', $id);
        }
        if ($product_id != null) {
            $this->db->where('product_id', $product_id);
        }
        $result = $this->db->get('store_product_images')->result();
        return $result;
    }

    public function deleteProductImage($id)
    {
        $productImages = $this->getProductImages($id);
        // echo '<pre>';
        // print_r($productImages);
        // exit();
        if (empty($productImages)) {
            return false;
        }

        $path = $productImages[0]->location;
        unlink(SITE_ROOT . $path);

        $this->db->where('image_id', $id);
        $query = $this->db->delete('store_product_images');
        if ($query == true) {
            return true;
        } else {
            return false;
        }
    }

    public function uploadImagesProduct($data, $id)
    {
        if (isset($data['product_image'])) {
            $this->load->library('scan');
            $totalItem = count($data['product_image']['name']);
            for ($i = 0; $i < $totalItem; $i++) {
                $file = array(
                    'name' => $data['product_image']['name'][$i],
                    'type' => $data['product_image']['type'][$i],
                    'tmp_name' => $data['product_image']['tmp_name'][$i],
                    'error' => $data['product_image']['error'][$i],
                    'size' => $data['product_image']['size'][$i]
                );

                $hasil = $this->scan->check($file, 'product_image', null);

                $insData = array(
                    'product_id' => $id,
                    'location' => $hasil,
                    'name' => $file['name']
                );

                $this->db->insert('store_product_images', $insData);
            }
        } else {
            return false;
        }

        return true;
    }

    public function getProductByCategory($category_id)
    {
        if ($category_id == null) {
            return false;
        }
        $this->db->where('category_id', $category_id);
        $result = $this->db->get('store_products')->result();
        foreach ($result as $key => $r) {
            $this->load->library('money');
            $productImages = $this->getProductImages(null, $r->product_id);
            if ($r->discount_amount != null || $r->discount_amount != 0) {
                $result[$key]->hargaHome = $this->money->hargaHomeFormat($r->price);
                $hargaDiscount = $r->price - $r->discount_amount;
                $result[$key]->hargaDiscountFormat = $this->money->hargaHomeRibu($hargaDiscount);
            }
            $result[$key]->images = $productImages;
        }
        return $result;
    }

    public function getCustomer($id_customer = null, $id_user = null, $jenis = null)
    {
        if ($id_customer == null && $id_user == null && $jenis == null) {
            return false;
        }
        if ($id_customer != null) {
            $this->db->where('id_customer', $id_customer);
        }
        if ($id_user != null) {
            $this->db->where('id_user', $id_user);
        }
        if ($jenis != null) {
            $this->db->where('jenis', $jenis);
        }
        $isCustomer = $this->db->get('store_customer')->result();

        return $isCustomer;
    }

    public function checkCustomer($data)
    {
        $isCustomer = $this->getCustomer(null, $data['id_user'], $data['jenis']);
        if (empty($isCustomer)) {
            $this->db->insert('store_customer', $data);
            $insert_id = $this->db->insert_id();

            //ambil data customer
            $isCustomer = $this->getCustomer($insert_id);
        }

        return $isCustomer[0];
    }



    public function getCart($id_customer = null, $id_product = null, $qty = null)
    {
        if ($id_customer == null && $id_product == null && $qty == null) {
            return false;
        }
        if ($id_customer != null) {
            $this->db->where('id_customer', $id_customer);
        }
        if ($id_product != null) {
            $this->db->where('id_product', $id_product);
        }
        if ($qty != null) {
            $this->db->where('qty', $qty);
        }
        $isCart = $this->db->get('store_cart')->result();

        foreach ($isCart as $key => $c) {
            $products = $this->getProduct($c->id_product);
            $isCart[$key]->product = $products;
            $priceAmount = $c->qty * $products[0]->priceTotal;
            $isCart[$key]->priceAmount = $priceAmount;
        }

        return $isCart;
    }

    public function updateCart($id_customer, $id_product, $qty)
    {
        if ($id_customer != null) {
            $this->db->where('id_customer', $id_customer);
        }
        if ($id_product != null) {
            $this->db->where('id_product', $id_product);
        }
        $this->db->set('qty', $qty);
        if (!$this->db->update('store_cart')) {
            return false;
        }

        return true;
    }

    public function checkCart($data)
    {
        $isCart = $this->getCart($data['id_customer'], $data['id_product']);
        $msg = "Data sudah ditambahkan";
        if (empty($isCart)) {
            $this->db->insert('store_cart', $data);
            $msg = "Data berhasil ditambahkan";
        } else {
            $qty = $isCart[0]->qty + $data['qty'];
            $this->db->where('id_customer', $data['id_customer']);
            $this->db->where('id_product', $data['id_product']);
            $this->db->set('qty', $qty, false);
            $this->db->update('store_cart');
            $msg = "Data berhasil diupdate";
        }

        return $msg;
    }

    public function deleteCart($id_customer = null, $id_product = null)
    {
        if ($id_customer == null && $id_product == null) {
            return false;
        }
        if ($id_customer != null) {
            $this->db->where('id_customer', $id_customer);
        }
        if ($id_product != null) {
            $this->db->where('id_product', $id_product);
        }

        if (!$this->db->delete('store_cart')) {
            return false;
        }

        return true;
    }

    public function getCategory($id = null)
    {
        if ($id != null) {
            $this->db->where('category_id', $id);
        }
        $data = $this->db->get('store_category')->result();

        return $data;
    }

    public function addCategory($data)
    {
        $this->db->insert('store_category', $data);
        return true;
    }

    public function deleteCategory($id = null)
    {
        if ($id != null) {
            $this->db->where('category_id', $id);
        }
        if (!$this->db->delete('store_category')) {
            return false;
        }

        return true;
    }

    public function checkStok($customer_id, $product_id, $stokAmbil)
    {
        $this->db->where('product_id', $product_id);
        $product = $this->db->get('store_products')->row();

        if ($stokAmbil > $product->stock_quantity) {
            $data = [
                'msg' => "Stok Tidak Tersedia",
                'title' => "Maaf",
                'type' => 'red'
            ];
            return $data;
        }

        $this->db->where('product_id', $product_id);
        $this->db->set('stock_quantity', "`stock_quantity` - $stokAmbil", FALSE);
        if (!$this->db->update('store_products')) {
            $data = [
                'msg' => "Terjadi Error pada system",
                'title' => "Maaf",
                'type' => 'red'
            ];
            return $data;
        }

        if (!$this->deleteCart($customer_id, $product_id)) {
            $data = [
                'msg' => "Terjadi Error pada system",
                'title' => "Maaf",
                'type' => 'red'
            ];
            return $data;
        }

        $data = [
            'msg' => "Berhasil cek stok",
            'title' => "Berhasil",
            'type' => 'green'
        ];

        return $data;
    }

    public function addStoreOrderItems($order_id, $product_id, $quantity, $amount)
    {
        $insData = [
            "order_id" => $order_id,
            "product_id" => $product_id,
            "quantity" => $quantity,
            "amount" => $amount,
        ];

        if (!$this->db->insert('store_order_items', $insData)) {
            return false;
        }

        return true;
    }

    public function addStoreOrders($data)
    {
        $insData = [
            'customer_id' => $data['customer_id'],
            'order_date' => date('Y-m-d H:i:s'),
            'discount_amount' => $data['discount_amount'],
            'total_amount' => $data['total_amount'],
            'shipping_zip_code' => $data['shipping_zip_code'],
            'shipping_address' => $data['shipping_address'],
            'shipping_provinsi' => $data['shipping_provinsi'],
            'shipping_kecamatan' => $data['shipping_kecamatan'],
            'shipping_kabupaten_kota' => $data['shipping_kabupaten_kota'],
            'notes' => $data['notes'],
        ];

        if (!$this->db->insert('store_orders', $insData)) {
            $data = [
                'msg' => "Terjadi Error pada system",
                'title' => "Maaf",
                'type' => 'red'
            ];
            return $data;
        }

        $insert_id = $this->db->insert_id();
        foreach ($data['qty'] as $key => $q) {
            $product = $this->getProduct($data['id_product'][$key]);
            $amount = $product[0]->priceTotal * $q;
            $result = $this->addStoreOrderItems($insert_id, $data['id_product'][$key], $q, $amount);
            if (!$result) {
                return false;
            }
        }
        return $insert_id;
    }

    public function getStoreOrders($order_id = null, $customer_id = null)
    {
        if ($order_id != null) {
            $this->db->where('order_id', $order_id);
        }
        if ($customer_id != null) {
            $this->db->where('customer_id', $customer_id);
        }

        $this->db->order_by('order_date', 'DESC');
        $data = $this->db->get('store_orders')->result();
        foreach ($data as $key => $d) {
            $this->load->library('money');
            $data[$key]->totalAmountFormat = $this->money->format($d->total_amount);
            $data[$key]->discountAmountFormat = $this->money->format($d->discount_amount);
            $data[$key]->product = $this->getStoreOrdersItems(null, $d->order_id);
            foreach ($d->product as $keyItem => $p) {
                $d->product[$keyItem]->amountFormat = $this->money->format($p->amount);
            }
        }

        return $data;
    }

    public function getStoreOrdersItems($order_item_id = null, $order_id = null)
    {
        if ($order_item_id != null) {
            $this->db->where('order_item_id', $order_item_id);
        }
        if ($order_id != null) {
            $this->db->where('order_id', $order_id);
        }
        $data = $this->db->get('store_order_items')->result();

        if (!empty($data)) {
            foreach ($data as $key => $d) {
                $product = $this->getProduct($d->product_id);
                $data[$key]->items = $product;
            }
        }

        return $data;
    }

    public function checkPesanan($number) {

        if ($number == 0) {
            $status = "Pesanan Segera Di Siapkan";
        } else if ($number == 1) {
            $status = "Pesanan Sedang Di Siapkan";
        } else if($number == 2) {
            $status = "Pesanan Sedang Di Kirim";
        } else if($number == 3) {
            $status = "Pesanan Di Terima";
        }

        return $status;
    }

    public function updateStatusPesanan($order_id, $status) {
        if ($order_id == null) {
            return false;
        }
        if ($status == null) {
            return false;
        }

        $this->db->where('order_id', $order_id);
        $this->db->set('status_pesanan', $status);

        if ($this->db->update('store_orders')) {
            $this->alert->set('success', 'Status berhasil diubah');
            return true;
        } else {
            $this->alert->set('danger', 'System Error, silakan coba kembali');
            return false;
        }
    }

    public function checkOrderTracking($order_id = null, $status = null, $updated_time = null) {
        if ($order_id == null && $status == null && $updated_time == null) {
            return false;
        }
        $orderTracking = $this->getOrderTracking($order_id, $status);
        if (empty($orderTracking)) {
            $data = [
                'order_id' => $order_id,
                'status' => $status,
            ];
            $this->addOrderTracking($data);
        } else {
            $this->updateOrderTracking($order_id, $status);
        }
        return true;
    }

    public function addOrderTracking($data) {
        $insData = [
            'order_id' => $data['order_id'],
            'status' => $data['status'],
        ];

        if ($this->db->insert('store_order_time_tracking', $insData)) {
            return true;
        } else {
            return false;
        }
    }

    public function updateOrderTracking($order_id, $status) {
        $this->db->where('order_id', $order_id);
        $this->db->where('status', $status);
        $this->db->set('updated_time', date('Y-m-d H:i:s')); 
        if ($this->db->update('store_order_time_tracking')) {
            return true;
        } else {
            return false;
        }
    }

    public function getOrderTracking($order_id, $status = null) {
        if (empty($order_id)) {
            return false;
        }
        if ($status != null) {
            $this->db->where('status', $status);
        }
        $this->db->where('order_id', $order_id);
        $this->db->order_by('status', 'asc');
        $data = $this->db->get('store_order_time_tracking')->result(); 
        foreach ($data as $key => $d) {
            $data[$key]->keterangan = $this->checkPesanan($d->status);
        }
        return $data;
    }

    public function uploadImagesBanner($data, $id)
    {
        if (isset($data['store_banner'])) {
            $this->load->library('scan');
            $totalItem = count($data['store_banner']['name']);
            for ($i = 0; $i < $totalItem; $i++) {
                $file = array(
                    'name' => $data['store_banner']['name'][$i],
                    'type' => $data['store_banner']['type'][$i],
                    'tmp_name' => $data['store_banner']['tmp_name'][$i],
                    'error' => $data['store_banner']['error'][$i],
                    'size' => $data['store_banner']['size'][$i]
                );
                $hasil = $this->scan->check($file, 'store_banner', null);
            }
        } else {
            return false;
        }

        return true;
    }
}