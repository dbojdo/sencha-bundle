<?php
namespace Webit\Bundle\SenchaBundle\Component\Store;

class StoreProvider implements StoreProviderInterface {
	/**
	 * @var array
	 */
	protected $stores = array();
	
	/**
	 * @param string $storeName
	 * @return StoreCommonInterface
	 */
	public function getStore($storeName) {
		if($this->isStoreRegistered($storeName) == false) {
			throw new \Exception('Store named "'.$storeName.'" has never been registered');
		}
		
		return $this->stores[$storeName];
	}
	
	/**
	 * @param string $storeName
	 * @param StoreCommonInterface $store
	 * @return void
	 */
	public function registerStore($storeName, StoreCommonInterface $store) {
		if($this->isStoreRegistered($storeName)) {
			throw new \Exception('Store named "'.$storeName.'" has already been registered');
		}
		
		$this->stores[$storeName] = $store;
	}
	
	/**
	 * @return bool
	 */
	public function isStoreRegistered($storeName) {
		return isset($this->stores[$storeName]);
	}
}
?>
