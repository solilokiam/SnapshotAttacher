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
            ->addArgument('snapshot_tag',InputArgument::REQUIRED,"the snapshot tag you're looking for");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Done');
    }

}