<?php
namespace PhpDevCommunity\PaperORMBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

final class PaperORMBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

    }

    public function getPath() : string
    {
        return \dirname(__DIR__);
    }
}
