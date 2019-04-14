<?php

require_once __DIR__ . '/../vendor/autoload.php';

use KhairulImam\ROSWrapper\Wrapper;

$wrapper = new Wrapper();

if ($wrapper->connect('192.168.1.1', 'admin', '')) {
    $response = $wrapper->exec('/ip/address/set', [
        "address" => "192.168.3.1/24",
        ".id" => "*3"
    ]);
    print_r($response);
    $wrapper->disconnect();
 }