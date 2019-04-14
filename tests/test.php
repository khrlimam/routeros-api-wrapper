<?php

require_once __DIR__ . '/../vendor/autoload.php';

use KhairulImam\ROSWrapper\Wrapper;

$wrapper = new Wrapper();

if ($wrapper->connect('192.168.1.1', 'admin', '')) {

    $wrapper->write('/interface/getall');
 
    $READ = $wrapper->read(false);
    $ARRAY = $wrapper->parseResponse($READ);
 
    print_r($ARRAY);
 
    $wrapper->disconnect();
 
 }