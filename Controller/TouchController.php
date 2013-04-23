<?php
namespace Webit\Bundle\SenchaBundle\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TouchController extends Controller {
	protected $container;
	
	public function __construct(ContainerInterface $container) {
		$this->container = $container;
	}
	
	public function includeJsAction() {
		return $this
				->render('WebitSenchaBundle:Touch:includeJs.html.twig',array('version'=>'2.2.0'));
	}
	
	public function includeCssAction() {
		return $this
			->render('WebitSenchaBundle:Touch:includeCss.html.twig',array('version'=>'2.2.0'));
	}
}
?>
