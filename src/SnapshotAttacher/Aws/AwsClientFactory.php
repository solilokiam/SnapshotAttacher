<?php
namespace SnapshotAttacher\Aws;

use Aws\Common\Aws;
use SnapshotAttacher\Exception\InvalidAwsContainerException;

class AwsClientFactory
{
    private $awsClient;

    function __construct($key,$secret,$region)
    {
        $this->awsClient = Aws::factory(array(
            'key' => $key,
            'secret' => $secret,
            'region' => $region
        ));
    }

    private function get($service)
    {
        if(!$this->awsClient)
        {
            throw new InvalidAwsContainerException("Cannot load '{$service}' service. The AWS container is invalid.");
        }

        return $this->awsClient->get($service);
    }

    public function getEc2()
    {
        return $this->get('Ec2');
    }


}