<?php

namespace PhpDevCommunity\PaperORMBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Reference;

final class PaperORMExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);


        $container->setParameter('paper_orm.dsn', $config['dsn']);
        $container->setParameter('paper_orm.debug', $config['debug']);
        $container->setParameter('paper_orm.logger', $config['logger']);
        $container->setParameter('paper_orm.entity_dir', $config['entity_dir']);
        $container->setParameter('paper_orm.migrations_dir', $config['migrations_dir']);
        $container->setParameter('paper_orm.migrations_table', $config['migrations_table']);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../../config'));
        $loader->load('services.yaml');

        if ($container->hasDefinition(\PhpDevCommunity\PaperORM\EntityManager::class)) {
            $definition = $container->getDefinition(\PhpDevCommunity\PaperORM\EntityManager::class);
            $definition->replaceArgument(2, new Reference($config['logger']));
        }
    }
}
