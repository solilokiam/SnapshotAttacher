<?php
namespace SnapshotAttacher\Waiter;

abstract class AbstractWaiter
{
    public function wait($waiterParams,$interval,$times)
    {
        for($i = 0;$i<$times;$i++) {
            if ($this->checkWaitContition($waiterParams)) {
                return;
            }

            sleep($interval);
        }
    }

    abstract protected function checkWaitContition($waiterParams);
}