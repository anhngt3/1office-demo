<?php

// action là callback
$router->get('/product', 'ProductController@index');
$router->get('/product/create', 'ProductController@create');
$router->post('/product', 'ProductController@store');