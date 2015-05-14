<?php
namespace Snapshoter\Waiter;

use Aws\Ec2\Ec2Client;
use Snapshoter\Exception\InvalidVolumeException;

class VolumeAvailableWaiter extends AbstractWaiter
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
            return $volumes[0]['State'] == 'available';
        } else {
            throw new InvalidVolumeException();
        }
    }
}