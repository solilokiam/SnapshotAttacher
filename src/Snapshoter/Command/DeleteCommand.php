<?php


namespace Snapshoter\Command;


use Snapshoter\Exception\InvalidParametersException;
use Snapshoter\Exception\SnapshotUnavailableException;
use Snapshoter\Sorter\SnapshotResultSorter;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('delete')
            ->setDescription('Delete one or several EBS volume snapshots with a tag')
            ->addArgument('snapshot_tag', InputArgument::OPTIONAL, "the snapshot tag you're looking for")
            ->addOption(
                'snapshotId',
                'i',
                InputOption::VALUE_REQUIRED,
                "The id of the snapshot to delete if defined we will not take a look to snapshot_tag"
            )
            ->addOption(
                'pardon',
                'p',
                InputOption::VALUE_REQUIRED,
                "The number of snapshots to pardon. The n last snapshots will not be deleted"
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $snapshotTag = $input->getArgument('snapshot_tag');
        $snapshotId = $input->getOption('snapshotId');
        $pardon = $input->getOption('pardon');

        $ec2Client = $this->getContainer()->get('snapshoter.aws.ec2.client');

        if ($snapshotId !== null) {
            $filters = array('Name' => 'snapshot-id', 'Values' => array($snapshotId));
        } elseif ($snapshotTag !== null) {
            $filters = array('Name' => 'tag:Name', 'Values' => array($snapshotTag));
        } else {
            throw new InvalidParametersException();
        }

        $returnObj = $ec2Client->describeSnapshots(
            array(
                'OwnerIds' => array('self'),
                'Filters' => array(
                    $filters
                )
            )
        );

        $snapshots = SnapshotResultSorter::sort($returnObj['Snapshots']);

        if (!empty($pardon)) {
            array_splice($snapshots, -abs($pardon));
        }

        if (count($snapshots) == 0) {
            throw new SnapshotUnavailableException();
        }

        foreach ($snapshots as $snapshot) {
            $ec2Client->deleteSnapshot(array('SnapshotId' => $snapshot['SnapshotId']));
        }
    }

}