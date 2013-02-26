<?php

namespace Webit\Bundle\SenchaBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ExtJsController extends Controller {
	public function includeJsAction() {
		return $this
				->render('WebitSenchaBundle:ExtJs:includeJs.html.twig',array('version'=>'4.1.1'));
	}
	
	public function includeCssAction() {
		return $this
			->render('WebitSenchaBundle:ExtJs:includeCss.html.twig',array('version'=>'4.1.1'));
	}
}
?>
