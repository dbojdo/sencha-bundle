<?php
namespace Webit\Bundle\SenchaBundle\Controller;

use Webit\Bundle\SenchaBundle\Component\Store\StoreCommonInterface;

use FOS\RestBundle\Controller\FOSRestController;

use Webit\Bundle\SenchaBundle\Component\Store\StoreRequestInterface;

use Webit\Bundle\SenchaBundle\Component\Store\StoreInterface;

use Webit\Bundle\SenchaBundle\Component\Store\StoreAwareInterface;

use FOS\RestBundle\Controller\Annotations as FOS;

/**
 * 
 * @author dbojdo
 * @FOS\NamePrefix("webit_sencha_")
 */
class StoreController extends FOSRestController implements StoreAwareInterface {
	/**
	 * @var StoreInterface
	 */
	protected $store;
	
	public function setStore(StoreCommonInterface $store) {
		$this->store = $store;
	}
	
	/**
	 * @return StoreInterface
	 */
	public function getStore() {
		return $this->store;
	}
	
	/**
	 * @param StoreRequestInterface $request
	 * @FOS\Route("/store")
	 * @FOS\Get
	 */
	public function getAction(StoreRequestInterface $storeRequest) {
		if($storeRequest->getId()) {
 			$response = $this->store->load($storeRequest);
		} else {
			$response = $this->store->loadList($storeRequest);
		}
		
		$view = $this->view($response, 200);
		$view->setFormat('json');
		
		return $view;
	}
	
	/**
	 * @param StoreRequestInterface $request
	 * @FOS\Route("/store")
	 * @FOS\Post
	 */
	public function postAction(StoreRequestInterface $storeRequest) {
		$response = $this->store->create($storeRequest);
		
		$view = $this->view($response, 200);
		$view->setFormat('json');
		
		return $view;
	}
	
	/**
	 * @param StoreRequestInterface $request
	 * @FOS\Route("/store")
	 * @FOS\Put
	 */
	public function putAction(StoreRequestInterface $storeRequest) {
		$response = $this->store->update($storeRequest);
		
		$view = $this->view($response, 200);
		$view->setFormat('json');
		
		return $view;
	}
	
	/**
	 * @param StoreRequestInterface $request
	 * @FOS\Route("/store")
	 * @FOS\Delete
	 */
	public function deleteAction(StoreRequestInterface $storeRequest) {
		$response = $this->store->remove($storeRequest);
		
		$view = $this->view($response, 200);
		return $view;
	}
}
?>
