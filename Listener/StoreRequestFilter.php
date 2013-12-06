<?php
namespace Webit\Bundle\SenchaBundle\Listener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Webit\Bundle\SenchaBundle\Component\Store\StoreRequestInterface;
use Webit\Bundle\SenchaBundle\Component\Store\StoreRequestFilterProviderInterface;

class StoreRequestFilter implements EventSubscriberInterface {
	/**
	 * @var StoreProviderInterface
	 */
	private $filterProvider;
	
	public function __construct(StoreRequestFilterProviderInterface $filterProvider) {
		$this->filterProvider = $filterProvider;
	}
	
	/**
	 * @return array
	 */
	static public function getSubscribedEvents() {
		return array('kernel.controller'=>'onKernelController');
	}

	public function onKernelController(FilterControllerEvent $event) {
		$controller = $event->getController();
		if(!is_array($controller)) {
			return;
		}
		
		$request = $event->getRequest();
		$storeRequest = $request->get('storeRequest'); 
		if($storeRequest instanceof StoreRequestInterface) {
		    $filters = $this->filterProvider->getFilters();
		    foreach($filters as $filter) {
		        $filter->filterStoreRequest($storeRequest);
		    }
		}
	}
}
?>
