<?php
namespace Snapshoter\Command;

use Herrera\Phar\Update\Manager;
use Herrera\Phar\Update\Manifest;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateCommand extends ContainerAwareCommand
{
    const MANIFEST_FILE = 'http://solilokiam.github.io/SnapshoterDist/manifest.json';

    protected function configure()
    {
        $this->setName('update')
            ->setDescription('Updates Snapshoter.phar to the latest version');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $manager = new Manager(Manifest::loadFile(self::MANIFEST_FILE));
        $manager->update($this->getApplication()->getVersion(), true);
    }

}