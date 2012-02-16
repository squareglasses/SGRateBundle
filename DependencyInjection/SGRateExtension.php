<?php

namespace SG\RateBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SGRateExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        
        $container->setParameter('sg_rate.entity.rate.class',     $config['model']['rate_class']);
        $container->setParameter('sg_rate.entity.rate.min_rate_score', $config['model']['min_rate_score']);
        $container->setParameter('sg_rate.entity.rate.max_rate_score', $config['model']['max_rate_score']);
        
        $rateables = array();
        foreach($config['model']['rateables'] as $rateable) {
            $rateables[$rateable['type']] = $rateable;
        }
        $container->setParameter('sg.rateable_manager.rateables' , $rateables);
    }
}
