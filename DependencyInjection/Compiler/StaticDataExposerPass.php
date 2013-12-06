<?php
namespace Webit\Bundle\SenchaBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class StaticDataExposerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
		$arIds = $container->findTaggedServiceIds('webit_sencha.static_data_exposer');
		$provider = $container->getDefinition('webit_sencha.static_data_exposer');
		foreach($arIds as $id=>$tag) {
			$provider->addMethodCall('registerExposer',array($container->getDefinition($id)));
		}
    }
}