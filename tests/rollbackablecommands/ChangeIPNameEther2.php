<?php

use KhairulImam\ROSWrapper\RollbackableCommand;
use KhairulImam\ROSWrapper\Wrapper;

class ChangeIPNameEther2 extends RollbackableCommand
{

    private $id, $originalAddress, $mikrotik;

    public function __construct(Wrapper $mikrotik)
    {
        $this->mikrotik = $mikrotik;
        $this->originalAddress = "192.168.90.1/24";
        $this->id = $this->mikrotik->run("ip address print", ["?interface" => "hotspot2"])[0]['.id'];
    }

    /**
     * @return string
     */
    function name()
    {
        return 'change hotspot2 address from ' . $this->originalAddress . ' to 192.168.92.1/24';
    }

    function run()
    {
        echo "RUNNING: " . $this->name() . PHP_EOL;
        $this->mikrotik->run("ip address set", ["address" => "192.168.92.1/24", ".id" => $this->id]);
        echo "SUCCESS:" . PHP_EOL;
        print_r($this->mikrotik->run("ip address print", ["?interface" => "hotspot2"])[0]);
        $this->id = $this->mikrotik->run("ip address print", ["?interface" => "hotspot2"])[0]['.id'];
    }

    public function rollback()
    {
        echo "ROLLBACK: " . $this->name() . PHP_EOL;
        $this->mikrotik->run("ip address set", ["address" => $this->originalAddress, ".id" => $this->id]);
        print_r($this->mikrotik->run("ip address print", ["?interface" => "hotspot2"])[0]);
    }
}