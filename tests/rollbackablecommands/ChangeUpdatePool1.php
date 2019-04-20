<?php


use KhairulImam\ROSWrapper\RollbackableCommand;
use KhairulImam\ROSWrapper\Wrapper;

class ChangeUpdatePool1 extends RollbackableCommand
{

    private $id, $mikrotik;

    public function __construct(Wrapper $mikrotik)
    {
        $this->mikrotik = $mikrotik;
        $this->id = "*1";
    }

    /**
     * @return string
     */
    function name()
    {
        return "rename local_pool to global_pool";
    }

    function run()
    {
        echo "RUNNING: " . $this->name() . PHP_EOL;
        $this->mikrotik->run("ip pool set", ['name' => 'global_pool', '.id' => $this->id]);
        echo "SUCCESS:" . PHP_EOL;
        print_r($this->mikrotik->run("ip pool print", ['?name' => 'global_pool'])[0]);
    }

    public function rollback()
    {
        echo "ROLLBACK: " . $this->name() . PHP_EOL;
        $this->mikrotik->run("ip pool set", ['name' => 'local_pool', '.id' => $this->id]);
        print_r($this->mikrotik->run("ip pool print", ['?name' => 'local_pool'])[0]);
    }
}