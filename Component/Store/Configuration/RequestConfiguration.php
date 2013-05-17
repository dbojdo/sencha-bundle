<?php
namespace Webit\Bundle\SenchaBundle\Component\Store\Configuration;

class RequestConfiguration {
	/**
	 * @var array
	 */
	protected $params = array();
	
	public function __construct(array $params) {
		$this->params = $params;
	}
	
	public function getParamKey($param) {
		if($this->hasParam($param) && isset($this->params[$param]['key'])) {
			return $this->params[$param]['key'];
		}
		
		return null;
	}
	
	public function getParamType($param) {
		if($this->hasParam($param) && isset($this->params[$param]['type'])) {
			return $this->params[$param]['type'];
		}
		
		return null;
	}
	
	public function getParamFormat($param) {
		if($this->hasParam($param) && isset($this->params[$param]['format'])) {
			return $this->params[$param]['format'];
		}
		
		return 'json';
	}
	
	private function hasParam($param) {
		return isset($this->params[$param]);
	}
	
	public function getBaseParams() {
		return array('filters','sorters','data','limit','offset','page');
	}
	
	public function getExtraParams() {
		$keys = array_keys($this->params);
		
		return array_diff($keys, $this->getBaseParams());
	}
}
?>
