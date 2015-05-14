<?php
/**
 * Created by PhpStorm.
 * User: miquel
 * Date: 14/05/15
 * Time: 17:50
 */

namespace Snapshoter\Waiter;


class FstabWaiter extends AbstractWaiter
{
    protected function checkWaitContition($waiterParams)
    {
        return file_exists($waiterParams['device']);
    }

}