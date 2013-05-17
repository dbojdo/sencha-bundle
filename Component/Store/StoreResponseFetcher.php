<?php
namespace Webit\Bundle\SenchaBundle\Component\Store;

class ResponseConfigurationProvider {
	protected $map = array();
	public function __construct(array $map = array()) {
		$this->map = $map;
	}
	
	public function getConfiguration($storeName) {
		if(isset($this->map[$storeName])) {
			return $this->map[$storeName];
		}
		
		return null;
	}
}