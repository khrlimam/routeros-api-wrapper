<?php

require_once __DIR__ . '/../vendor/autoload.php';

use KhairulImam\ROSWrapper\Wrapper;

$wrapper = new Wrapper('192.168.1.1');

if ($wrapper->connected) {
    $response = $wrapper->exec('ip address getall');
    print_r($response);
    $wrapper->disconnect();
 }