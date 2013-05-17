<?php 
namespace Webit\Bundle\SenchaBundle\Component\Store\Configuration;

class ResponseConfigurationProvider {
	private $configs;
	
	public function __construct(array $configs) {
		foreach($configs as $key=>$config) {
			$this->configs[$key] = new ResponseConfiguration($config['format'],$config['serializer_groups']);
		}
	}
	
	/**
	 * 
	 * @param string $storeName
	 * @return ResponseConfiguration
	 */
	public function getConfiguration($storeName) {
		return isset($this->configs[$storeName]) ? $this->configs[$storeName] : $this->configs['default']; 
	}
	
	public function registerConfiguration($storeName, ResponseConfiguration $config) {
		$this->configs[$storeName] = $config;
	} 
}
?>
