<?php


namespace KhairulImam\ROSWrapper;


class Sequential
{

    private $state;
    private $processes = [];
    private $countProcesses;
    private $reason = "";

    private function __construct(array $sequens)
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

    public static function process(RollbackableCommand ...$sequentialProcesses)
    {
        return new Sequential($sequentialProcesses);
    }

    /**
     * @param int $state
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

    /**
     * @param sring $reason
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    }

    /**
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
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