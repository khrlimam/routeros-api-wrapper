<?php


namespace KhairulImam\ROSWrapper;


class SequentialExecutor
{

    /**
     * @param Sequential $sequentials
     * @throws RollbackedException
     */
    public static function execute(Sequential $sequential)
    {
        $count = $sequential->countProcesses();
        for ($state = 0; $state < $count; $state++) {
            $sequential->setState($state);
            try {
                $sequential->getRollbackableCommandOfCurrentState()->run();
            } catch (\Exception $e) {
                $sequential->setReason($e->getMessage());
                static::rollback($sequential);
                break;
            }
        }
    }

    private static function rollback(Sequential $sequential)
    {
        $reversedRollbacks = $sequential->getReversedRollbackableCommandFromLastExecutedState();
        foreach ($reversedRollbacks as $reversedRollback) {
            $reversedRollback->rollback();
        }
        $rollbackException = new RollbackedException($sequential->getFailedProcess(), $reversedRollbacks);
        throw $rollbackException->withReason($sequential->getReason());
    }

}