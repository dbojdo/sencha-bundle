<?php 
namespace Webit\Bundle\SenchaBundle\Component\Store;

class StoreRequestFilterProvider implements StoreRequestFilterProviderInterface {
    
    /**
     * 
     * @var array
     */
    private $filters = array();
    	
	/**
	 * 
	 * @param string $storeName
	 * @return array<StoreRequestFilterInterface>
	 */
	public function getFilters() {
	    return $this->filters;
	}
}
?>
