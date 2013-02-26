<?php

namespace Webit\Bundle\SenchaBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class WebitSenchaExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        
        $container->setParameter($this->getAlias().'.assets_dir', $this->resolvePath($config['assets_dir'],$container));
        
        $this->loadExtJs($config['extjs'], $container);
        $this->loadTouch($config['touch'], $container);
    }
    
    private function resolvePath($path, ContainerBuilder $container) {
    	if(!in_array($path[0],array('/','@'))) {
    		$path = '@WebitSenchaBundle/'.$path;	
    	}
    	
   		if ('@' === $path[0]) {
   			$bundles = $container->getParameter('kernel.bundles');
			$bundleName = substr($path, 1, strpos($path, '/') - 1);
			if (!isset($bundles[$bundleName])) {
				throw new \RuntimeException(sprintf('The bundle "%s" has not been registered with AppKernel. Available bundles: %s', $bundleName, implode(', ', array_keys($bundles))));
			}
    		
			$ref = new \ReflectionClass($bundles[$bundleName]);
			$path = dirname($ref->getFileName()).substr($path, strlen('@'.$bundleName));
    	}
    	
    	return $path;
    }
    
    private function loadExtJs($config, ContainerBuilder $container) {
    	$alias = $this->getAlias();
    	$container->setParameter($alias.'.extjs_version',$config['version']);
    	$container->setParameter($alias.'.extjs_url_list',$config['download_url']);
    }
    
    private function loadTouch($config, ContainerBuilder $container) {
    	$alias = $this->getAlias();
    	$container->setParameter($alias.'.touch_version',$config['version']);
    	$container->setParameter($alias.'.touch_url_list',$config['download_url']);
    }
}
