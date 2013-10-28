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
            ->scalarNode('request_store_key')->defaultValue('store')->end()
            ->scalarNode('assets_dir')->defaultValue('@WebitSenchaBundle/Resources/public/js')->end()
        	->arrayNode('extjs')
        		->addDefaultsIfNotSet()
        		->children()
	        		->scalarNode('version')->defaultValue('4.2.1')->end()
	        		->arrayNode('download_url')
	        			->defaultValue(array(
	        			    '4.2.1' => 'http://cdn.sencha.com/ext/gpl/ext-4.2.1-gpl.zip',
	        				'4.2.0' => 'http://cdn.sencha.com/ext/gpl/ext-4.2.0-gpl.zip',
	        				'4.1.1' => 'http://cdn.sencha.io/ext-4.1.1-gpl.zip'
	        			))
	        			->prototype('scalar')->end()
	        		->end()
        		->end()
        	->end()
        	->arrayNode('touch')
        		->addDefaultsIfNotSet()
        		->children()
        			->scalarNode('version')->defaultValue('2.2.0')->end()
		        	->arrayNode('download_url')
			        	->defaultValue(array(
			        		'2.2.0' => 'http://cdn.sencha.io/touch/sencha-touch-2.2.0-gpl.zip',
			        		'2.1.1' => 'http://cdn.sencha.io/touch/sencha-touch-2.1.1-gpl.zip'
			        	))->prototype('scalar')->end()
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
