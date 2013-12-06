<?php 
namespace Webit\Bundle\SenchaBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Definition;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class RegisterStoreRequestFilterPass implements CompilerPassInterface {
	public function process(ContainerBuilder $container) {
		$this->registerStoreRequestFilters($container);
	}
	
	private function registerStoreRequestFilters(ContainerBuilder $container) {
		$provider = $container->getDefinition('webit_sencha.store_request_filter_provider');
		
	    $tagged = $container->findTaggedServiceIds('webit_sencha.store_request_filter');
        foreach($tagged as $id=>$tag) {            
            $loaderProvider->addMethodCall('registerFilter',array(new Reference($id)));
        }
	}
}
?>