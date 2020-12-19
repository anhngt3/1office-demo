<?php

namespace App\Controllers;

use Database;

class ProductController extends BaseController
{
    public function index($request)
    {
        $db = new Database();
        var_dump($_GET['id']);
        if ($_GET['id']) {
            $db->select('products', '"id"='.$_GET['id']);
            $product = $db->getResult();
            include('./app/views/products/index.php');
        } else {
            $db->select('products');
            $product = $db->getResult();
            include('./app/views/products/index.php');      
        }

    }

    public function create()
    {
        include('./app/views/products/form.php');
    }

    public function store()
    {
        $data = [];
        $db = new Database();
        $file_name = $this->upload($_FILES['image'], 'products');
        if ($file_name) {
            $data['image'] = $file_name;
        }
        $data['name'] = $_POST['name'];
        $data['price'] = $_POST['price'];
        $result = $db->insert('products', array_values($data), array_keys($data));

        if ($result) {
            header('Location: http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
        } else {
            header('Location: http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '/create');
        }
        die;
    }
}
