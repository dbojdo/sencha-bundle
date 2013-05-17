<?php
namespace Webit\Bundle\SenchaBundle\Controller;

use Webit\Bundle\SenchaBundle\Component\Store\StoreCommonInterface;

use FOS\RestBundle\Controller\FOSRestController;

use Webit\Bundle\SenchaBundle\Component\Store\StoreRequestInterface;

use Webit\Bundle\SenchaBundle\Component\Store\TreeStoreInterface;

use Webit\Bundle\SenchaBundle\Component\Store\StoreAwareInterface;

use FOS\RestBundle\Controller\Annotations as FOS;

/**
 *
 * @author dbojdo
 * @FOS\NamePrefix("webit_sencha_")
 */
class TreeStoreController extends FOSRestController implements StoreAwareInterface {
	/**
	 * @var TreeStoreInterface
	 */
	protected $store;
	
	public function setStore(StoreCommonInterface $store) {
		$this->store = $store;
	}
	
	/**
	 * @return TreeStoreInterface
	 */
	public function getStore() {
		return $this->store;
	}

	/**
	 * @FOS\Route("/tree-store")
	 * @FOS\Get
	 */
	public function getChildrenAction(StoreRequestInterface $storeRequest) {
		$storeRequest->setActionType(StoreRequestInterface::TYPE_LOAD_CHILDREN);
		
		$response = $this->store->getChildren($storeRequest);
		
		$view = $this->view($response, 200);
		return $view;
	}
}
?>
