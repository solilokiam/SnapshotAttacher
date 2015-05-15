<?php
/**
 * Created by PhpStorm.
 * User: miquel
 * Date: 14/05/15
 * Time: 18:06
 */

namespace Snapshoter\Command;


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('create')
            ->setDescription('Create an EBS volume snapshot from an ec2 instance with a tag')
            ->addOption('device','m',InputOption::VALUE_REQUIRED,'The mount point of the volume to create the snapshot.','/dev/sdf')
            ->addOption('instance_id','i',InputOption::VALUE_REQUIRED,'The instance id in which the volume to create the snapshot is attached, if not defined it will try to do it in the current machine',null)
            ->addOption('description','d',InputOption::VALUE_REQUIRED,'The description of the snapshot','Snapshot created automatically by snapshoter')
            ->addArgument('snapshot_tag',InputArgument::REQUIRED,"the snapshot tag you're looking for");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        list($instanceId,$local) = $this->getInstanceId($input);
        $device = $input->getOption('device');
        $tag = $input->getArgument('snapshot_tag');
        $description = $input->getOption('description');

        $volumeId = $this->getVolume($instanceId, $device);

        $snapshotResult = $this->getContainer()->get('snapshoter.aws.ec2.client')->createSnapshot(array(
            'VolumeId' => $volumeId,
            'Description' => $description
        ));

        $this->getContainer()->get('snapshoter.aws.ec2.client')->createTags(array(
            'Resources' => array($snapshotResult['SnapshotId']),
            'Tags' => array(
                array(
                    'Key' => 'Name',
                    'Value' => $tag
                )
            )
        ));

        $output->writeln('Done');
    }

    /**
     * @param InputInterface $input
     * @return array
     */
    private function getInstanceId(InputInterface $input)
    {
        if (!$input->hasOption('instance_id')) {
            $instanceId = $this->getContainer()->get('snapshoter.aws.metadata.client')->getInstanceId();
            $localInstance = true;

            return array($instanceId, $localInstance);
        } else {
            $instanceId = $input->getOption('instance_id');
            $localInstance = false;

            return array($instanceId, $localInstance);
        }
    }

    /**
     * @param $instanceId
     * @param $device
     * @return mixed
     * @throws VolumeUnavailableException
     */
    protected function getVolume($instanceId, $device)
    {
        $returnObj = $this->getContainer()->get('snapshoter.aws.ec2.client')->describeVolumes(
            array(
                'OwnerIds' => array('self'),
                'Filters' => array(
                    array('Name' => 'attachment.instance-id', 'Values' => array($instanceId)),
                    array('Name' => 'attachment.device', 'Values' => array($device))

                )
            )
        );
        $volumeList = $returnObj['Volumes'];

        if (count($volumeList) > 0) {
            $volume = end($volumeList);
            return $volume['VolumeId'];
        } else {
            throw new VolumeUnavailableException();
        }
    }

}