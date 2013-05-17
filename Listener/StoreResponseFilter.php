<?php
namespace Webit\Bundle\SenchaBundle\Listener;

use Webit\Bundle\SenchaBundle\Component\Store\StoreResponseInterface;

use Webit\Bundle\SenchaBundle\Component\Store\StoreRequestInterface;

use Webit\Bundle\SenchaBundle\Component\Store\Configuration\ResponseConfigurationProvider;

use FOS\RestBundle\Controller\Annotations\View;

use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

use FOS\RestBundle\EventListener\ViewResponseListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StoreResponseFilter implements EventSubscriberInterface {
	/**
	 * @var ResponseConfigurationProvider
	 */
	private $provider;
	
	public function __construct(ResponseConfigurationProvider $provider) {
		$this->provider = $provider;
	}
	
	static public function getSubscribedEvents() {
		return array(
			'kernel.view' =>array(
				array('setSerializerGroups',200),
				array('setResponseHeaders',150)
			)	
		);
	}
	
	public function setSerializerGroups(GetResponseForControllerResultEvent $event) {
		$storeRequest = $event->getRequest()->attributes->get('storeRequest');
		if($storeRequest instanceof StoreRequestInterface) {
			$config = $this->provider->getConfiguration($storeRequest->getStoreName());
			
			$_view = new View(array());
			if($action = $storeRequest->getActionType()) {
				$_view->setSerializerGroups($config->getSerializerGroups($action));
			}
			
			$event->getRequest()->attributes->set('_view', $_view);
		}
	}
	
	public function setResponseHeaders(GetResponseForControllerResultEvent $event) {
		$storeRequest = $event->getRequest()->attributes->get('storeRequest');
		$view = $event->getControllerResult();
		
		if($storeRequest instanceof StoreRequestInterface && $view instanceof \FOS\RestBundle\View\View) {
			$data = $view->getData();
			if($data instanceof StoreResponseInterface) {
				if($data->getSuccess() == false) {
					$view->setStatusCode(500);
				}
			}
		}
	}
}
?>
