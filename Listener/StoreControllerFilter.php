<?php
namespace Webit\Bundle\SenchaBundle\Listener;

use Webit\Bundle\SenchaBundle\Component\Store\StoreRequestFactory;

use Webit\Bundle\SenchaBundle\Component\Store\StoreProviderInterface;
use Webit\Bundle\SenchaBundle\Component\Store\StoreAwareInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StoreControllerFilter implements EventSubscriberInterface {
	/**
	 * @var StoreProviderInterface
	 */
	private $storeProvider;
	
	/**
	 * @var StoreRequestFactory
	 */
	private $storeRequestFactory;
	
	/**
	 * @var string
	 */
	private $requestStoreKey;
	
	public function __construct(StoreProviderInterface $storeProvider, StoreRequestFactory $storeRequestFactory, $requestStoreKey) {
		$this->storeProvider = $storeProvider;
		$this->storeRequestFactory = $storeRequestFactory;
		$this->requestStoreKey = $requestStoreKey;
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
		
		$storeName = $this->getStoreName($event->getRequest());
		
		if($controller[0] instanceof StoreAwareInterface) {
			$store = $this->findStore($storeName);
			if(!$store) {
				throw new \Exception('Store not found');
				// response filter - store not found
			}
			
			$controller[0]->setStore($store);
			
			$storeRequest = $this->getStoreRequest($storeName);
			$event->getRequest()->attributes->set('storeRequest', $storeRequest);
		}
	}
	
	private function getStoreName(Request $request) {
		$storeName = $request->get($this->requestStoreKey);
		
		return $storeName;
	}
	
	private function findStore($storeName) {
		if(empty($storeName) || $this->storeProvider->isStoreRegistered($storeName) == false) {
			return null;
		}
		
		return $this->storeProvider->getStore($storeName);
	}
	
	private function getStoreRequest($storeName) {
		return $this->storeRequestFactory->getStoreRequest($storeName);
	}
}
?>
