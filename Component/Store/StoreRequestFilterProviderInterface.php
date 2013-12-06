<?php 
namespace Webit\Bundle\SenchaBundle\Component\Store;

interface StoreRequestFilterProviderInterface {	
	/**
	 * 
	 * @return array<StoreRequestFilterInterface>
	 */
	public function getFilters();
}
?>
