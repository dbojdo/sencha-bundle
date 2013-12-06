<?php 
namespace Webit\Bundle\SenchaBundle\Component\Store;

interface StoreRequestFilterInterface {	
	/**
	 * 
	 * @param StoreRequestInterface $storeRequest
	 */
	public function filterRequest(StoreRequestInterface $storeRequest);
}
?>
