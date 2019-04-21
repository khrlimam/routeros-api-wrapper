<?php

require_once __DIR__ . '/../vendor/autoload.php';

use KhairulImam\ROSWrapper\RollbackedException;
use KhairulImam\ROSWrapper\Sequential;
use KhairulImam\ROSWrapper\Wrapper;

$wrapper = new Wrapper('192.168.88.1');

if ($wrapper->connected) {
    try {
        $wrapper->runSequentialProcess(Sequential::process(
            new ChangeIPNameEther1($wrapper),
            new ChangeIPNameEther2($wrapper),
            new ChangeUpdatePool1($wrapper),
            new DeleteIpAddressEther1()
        ));
    } catch (RollbackedException $e) {
        echo("\nError: " . $e->getMessage() . PHP_EOL . PHP_EOL);
    }
    $wrapper->disconnect();
}