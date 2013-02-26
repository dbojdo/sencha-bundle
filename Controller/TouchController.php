<?php
namespace Webit\Bundle\SenchaBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TouchController extends Controller {
	public function includeJsAction() {
		return $this
				->render('WebitSenchaBundle:Touch:includeJs.html.twig',array('version'=>'2.1.1'));
	}
	
	public function includeCssAction() {
		return $this
			->render('WebitSenchaBundle:Touch:includeCss.html.twig',array('version'=>'2.1.1'));
	}
}
?>
