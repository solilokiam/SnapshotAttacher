<?php
namespace Snapshoter\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetInstanceIdCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('instanceid')
            ->setDescription('Gets the ec2 instance id of the current machine');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $metadataClient = $this->getContainer()->get('snapshoter.aws.metadata.client');

        $instanceId = $metadataClient->getInstanceId();

        if ($instanceId) {
            $output->writeln($instanceId);
        } else {
            $output->writeln('No instance found');
        }
    }

}