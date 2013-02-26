<?php

namespace Webit\Bundle\SenchaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('webit_sencha');
        $rootNode
        ->children()
            ->scalarNode('assets_dir')->defaultValue('@WebitSenchaBundle:Resources/public/js')->end()
        	->arrayNode('extjs')
        		->scalarNode('version')->defaultValue('4.1.1')->end()
        		->addDefaultsIfNotSet()
        		->arrayNode('download_url')
        			->addDefaultsIfNotSet()
        			->children()
        				->scalarNode('4.1.1')->defaultValue('http://cdn.sencha.io/ext-4.1.1-gpl.zip')->end()
        			->end()
        		->end()
        	->end()
        	->arrayNode('touch')
        		->scalarNode('version')->defaultValue('2.1.1')->end()
	        	->addDefaultsIfNotSet()
	        	->arrayNode('download_url')
		        	->addDefaultsIfNotSet()
		        	->children()
		        		->scalarNode('2.1.1')->defaultValue('http://cdn.sencha.io/touch/sencha-touch-2.1.1-gpl.zip')->end()
		        	->end()
	        	->end()
        	->end()
        	->arrayNode('security')
        		->addDefaultsIfNotSet()
        		->children()
        			->scalarNode('user_model')->defaultValue('Webit.security.User')->end()
        		->end()
        	->end()
        ->end();

        return $treeBuilder;
    }
}
