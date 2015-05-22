<?php
namespace Snapshoter\Waiter;


class FstabWaiter extends AbstractWaiter
{
    protected function checkWaitContition($waiterParams)
    {
        return file_exists($waiterParams['device']);
    }

}