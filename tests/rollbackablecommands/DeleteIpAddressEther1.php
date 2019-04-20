<?php


use KhairulImam\ROSWrapper\RollbackableCommand;

class DeleteIpAddressEther1 extends RollbackableCommand
{

    /**
     * @return string
     */
    function name()
    {
        return "deleting ip address hotspot1";
    }

    function run()
    {
        echo "RUNNING: " . $this->name() . PHP_EOL;
        echo "FAILED" . PHP_EOL;
        throw new Exception("failed to delete");
    }

    public function rollback()
    {
        echo "ROLLBACK: " . $this->name() . PHP_EOL;
    }
}