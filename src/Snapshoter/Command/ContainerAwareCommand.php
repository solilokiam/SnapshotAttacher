<?php
/**
 * Created by PhpStorm.
 * User: miquel
 * Date: 8/05/15
 * Time: 13:25
 */

namespace Snapshoter\Command;


use Snapshoter\DependencyInjection\SnapshoterExtension;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Yaml\Yaml;

class ContainerAwareCommand extends Command
{
    private $container;

    function __construct($name = null)
    {
        parent::__construct($name);

        $this->container = new ContainerBuilder();
        $this->container->registerExtension(new SnapshoterExtension());


        $pharFile = \Phar::running(false);

        if('' === $pharFile)
        {
            $loader = new YamlFileLoader($this->container, new FileLocator(__DIR__.'/../../../'));
        } else {
            $loader = new YamlFileLoader($this->container, new FileLocator(dirname($pharFile)));
        }

        $loader->load('config.yml');

        $this->container->compile();

    }

    protected function getContainer()
    {
        return $this->container;
    }


}