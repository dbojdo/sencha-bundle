<?php 
namespace Webit\Bundle\SenchaBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Definition;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class StoreCompiler implements CompilerPassInterface {
	public function process(ContainerBuilder $container) {
		$this->registerStores($container);
	}
	
	private function registerStores(ContainerBuilder $container) {
		$provider = $container->getDefinition('webit_sencha.store_provider');
		foreach($container->getDefinitions() as $defName => $def) {
			if($def->hasTag('webit_sencha.store') || $def->hasTag('webit_sencha.tree_store')) {
				$provider->addMethodCall('registerStore',array($defName, $def));
			}
		}
	}
}
?>