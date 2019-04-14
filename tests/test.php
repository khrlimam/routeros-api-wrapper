<?php

require_once __DIR__ . '/../vendor/autoload.php';

use KhairulImam\ROSWrapper\Wrapper;

$wrapper = new Wrapper();

if ($wrapper->connect('192.168.1.1', 'admin', '')) {
    $response = $wrapper->exec('ip address getall');
    print_r($response);
    $wrapper->disconnect();
 }