<?php
/**
 * Created by PhpStorm.
 * User: miquel
 * Date: 14/05/15
 * Time: 17:43
 */

namespace Snapshoter\Aws;


class AwsMetadataClient
{
    private $baseUrl = 'http://169.254.169.254/latest/meta-data';

    public function getInstanceId()
    {
        $instanceId = @file_get_contents($this->baseUrl.'/instance-id');

        return $instanceId;
    }
}