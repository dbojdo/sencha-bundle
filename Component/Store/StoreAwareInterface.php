<?php 
namespace Webit\Bundle\SenchaBundle\Component\Store;

interface StoreAwareInterface {
	/**
	 * 
	 * @param StoreCommonInterface $store
	 */
	public function setStore(StoreCommonInterface $store);
	
	/**
	 * @return StoreCommonInterface
	 */
	public function getStore();
}
?>
