<?php

namespace Webit\Bundle\SenchaBundle;

use Webit\Bundle\SenchaBundle\DependencyInjection\Compiler\StoreCompiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Webit\Bundle\SenchaBundle\DependencyInjection\Compiler\RegisterStoreRequestFilterPass;
use Webit\Bundle\SenchaBundle\DependencyInjection\Compiler\StaticDataExposerPass;

class WebitSenchaBundle extends Bundle
{
	public function build(ContainerBuilder $container) {
		parent::build($container);
		$container->addCompilerPass(new StoreCompiler());
		$container->addCompilerPass(new RegisterStoreRequestFilterPass());
		$container->addCompilerPass(new StaticDataExposerPass());
	}
}
