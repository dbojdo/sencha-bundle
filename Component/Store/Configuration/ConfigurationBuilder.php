<?php
namespace Webit\Bundle\SenchaBundle\Component\Store\Configuration;

class ConfigurationBuilder {
	/**
	 * @var array
	 */
	private $requestMap = array();
	
	/**
	 * @var array
	 */
	private $responseMap = array();
	
	/**
	 * @var array
	 */
	private $mainDefault = array();
	
	/**
	 * @var array
	 */
	private $currentDefault = array();
	
	public function setConfig($storeName, array $arConfig) {
		if($storeName == 'default') {
			$this->setDefaultConfig($arConfig);
		} else {
			$arConfig = $this->merge($arConfig);
			$this->requestMap[$storeName] = $arConfig['request'];
			$this->responseMap[$storeName] = $arConfig['response']['format'];
		}
	}
	
	public function clearDefault() {
		$this->currentDefault = $this->mainDefault;
	}
	
	private function merge(array $arConfig) {
		$arConfig = array_replace_recursive($this->currentDefault, $arConfig);
		
		return $arConfig;
	}
	
	public function setDefaultConfig(array $arConfig, $main = false) {
		if($this->mainDefault == null) {
			$this->mainDefault = $arConfig;
			$this->currentDefault = $arConfig;
		} else {
			$this->currentDefault = array_replace_recursive($this->mainDefault, $arConfig);
		}
	}
	
	public function getRequestConfigMap() {
		$map = $this->requestMap;
		$map['default'] = $this->mainDefault['request'];
		
		return $map;
	}
	
	public function getResponseConfigMap() {
		$map = $this->responseMap;
		$map['default'] = $this->mainDefault['response'];
		
		return $map;
	}
}
?>
