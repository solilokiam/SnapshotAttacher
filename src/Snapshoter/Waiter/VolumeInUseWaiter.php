<?php
/**
 * Created by PhpStorm.
 * User: miquel
 * Date: 8/05/15
 * Time: 14:02
 */

namespace Snapshoter\Waiter;


use Aws\Ec2\Ec2Client;

class VolumeInUseWaiter extends AbstractWaiter
{
    protected $ec2Client;

    function __construct(Ec2Client $ec2Client)
    {
        $this->ec2Client = $ec2Client;
    }


    protected function checkWaitContition($waiterParams)
    {
        $volumesReturn = $this->ec2Client->describeVolumes(array(
            'VolumeIds' => array($waiterParams['VolumeId'])
        ));

        $volumes = $volumesReturn['Volumes'];
        if(count($volumes) > 0)
        {
            return $volumes[0]['State'] == 'in_use';
        } else {
            throw new InvalidVolumeException();
        }
    }

}