<?php


namespace KhairulImam\ROSWrapper;


class SequentialExecutor
{

    /**
     * @param Sequential $sequentials
     * @throws RollbackedException
     */
    public static function execute(Sequential $sequentials)
    {
        $count = $sequentials->countProcesses();
        for ($state = 0; $state < $count; $state++) {
            $sequentials->setState($state);
            try {
                $sequentials->getRollbackableCommandOfCurrentState()->run();
            } catch (\Exception $e) {
                static::rollback($sequentials);
                break;
            }
        }
    }

    private static function rollback(Sequential $sequentials)
    {
        $reversedRollbacks = $sequentials->getReversedRollbackableCommandFromLastExecutedState();
        foreach ($reversedRollbacks as $reversedRollback) {
            $reversedRollback->rollback();
        }
        throw new RollbackedException($sequentials->getFailedProcess(), $reversedRollbacks);
    }

}