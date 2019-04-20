<?php


namespace KhairulImam\ROSWrapper;


class Sequential
{

    private $state;
    private $processes = [];
    private $countProcesses;

    public function __construct(RollbackableCommand ...$sequens)
    {
        $this->processes = $sequens;
        $this->countProcesses = count($sequens);
    }

    /**
     * @return int
     */
    public function countProcesses()
    {
        return $this->countProcesses;
    }

    public static function process(array $sequentialProcesses)
    {
        return new Sequential($sequentialProcesses);
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    public function getFailedProcess()
    {
        return $this->processes[$this->getState()];
    }

    /**
     * @return RollbackableCommand
     */
    public function getRollbackableCommandOfCurrentState()
    {
        return $this->processes[$this->getState()];
    }

    /**
     * @return array[RollbackableCommand]
     */
    public function getReversedRollbackableCommandFromLastExecutedState()
    {
        return array_reverse(array_slice($this->processes, 0, $this->getState() + 1));
    }

}