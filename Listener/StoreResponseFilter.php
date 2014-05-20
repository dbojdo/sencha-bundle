<?php
namespace Webit\Bundle\SenchaBundle\Listener;

use Webit\Bundle\SenchaBundle\Component\Store\StoreResponseInterface;

use Webit\Bundle\SenchaBundle\Component\Store\StoreRequestInterface;

use Webit\Bundle\SenchaBundle\Component\Store\Configuration\ResponseConfigurationProvider;

use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

use FOS\RestBundle\EventListener\ViewResponseListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use FOS\RestBundle\View\View;

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
			
			$view = $event->getControllerResult();			
			if($action = $storeRequest->getActionType()) {
			    $view->getSerializationContext()->setGroups($config->getSerializerGroups($action));
			}
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
