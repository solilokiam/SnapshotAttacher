<?php
/**
 * Created by PhpStorm.
 * User: miquel
 * Date: 8/05/15
 * Time: 13:25
 */

namespace Snapshoter\Command;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class ContainerAwareCommand extends Command
{
    private $container;

    function __construct($name = null)
    {
        parent::__construct($name);

        $this->container = new ContainerBuilder();
        $loader = new YamlFileLoader($this->container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }

    protected function getContainer()
    {
        return $this->container;
    }


}