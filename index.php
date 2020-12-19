<?php

// Định nghĩa hằng Path của file index.php
define('PATH_ROOT', __DIR__);
include_once (PATH_ROOT . '/connect.php');
// Autoload class trong PHP
spl_autoload_register(function ($class_name) {
    include_once PATH_ROOT . '/' . $class_name . '.php';
});

// load class Route
$router = new Core\Http\Route();
include_once PATH_ROOT . '/app/routes.php';


// Lấy url hiện tại của trang web. Mặc định la /
$request_url = !empty($_GET['url']) ? '/' . $_GET['url'] : '/';
// Lấy phương thức hiện tại của url đang được gọi. (GET | POST). Mặc định là GET.
$method_url = !empty($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';

// map URL
$router->map($request_url, $method_url);