<?php
namespace Webit\Bundle\SenchaBundle\Component\Store;

interface StoreProviderInterface {
	public function getStore($storeName);
	
	public function registerStore($storeName, StoreCommonInterface $store);

	public function isStoreRegistered($storeName);
}
?>
