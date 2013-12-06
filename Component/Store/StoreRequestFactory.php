<?php
namespace Webit\Bundle\SenchaBundle\Component\Store;

use Webit\Bundle\SenchaBundle\Component\Store\Configuration\RequestConfiguration;

use Symfony\Component\HttpFoundation\Request;

use JMS\Serializer\SerializerInterface;

class StoreRequestFactory {
	/**
	 * @var array
	 */
	private $storeRequestMap;
	
	/**
	 * @var Request
	 */
	private $request;
	
	/**
	 * @var SerializerInterface
	 */
	private $serializer;
	
	public function __construct(array $storeRequestMap = array(), Request $request, SerializerInterface $serializer) {
		foreach($storeRequestMap as $storeName=>$config) {
			$this->storeRequestMap[$storeName] = new RequestConfiguration($config);
		}
		
		$this->request = $request;
		$this->serializer = $serializer;
	}
	
	public function getStoreRequest($storeName) {
		$config = $this->getRequestConfig($storeName);
		
		$storeRequest = new StoreRequest($storeName, $this->request);
		
		$refObject = new \ReflectionObject($storeRequest);
		foreach($config->getBaseParams() as $key) {
			$p = $refObject->getProperty($key);
			$p->setAccessible(true);
			$paramValue = $this->request->get($config->getParamKey($key),$config->getParamDefaultValue($key));
			if(in_array($config->getParamType($key),array('string','date'))) {
				$paramValue = $this->jsonfiy($paramValue);
			}
        
			$value = $this->serializer->deserialize($paramValue, $config->getParamType($key), $config->getParamFormat($key));
			$p->setValue($storeRequest, $value);
			$p->setAccessible(false);
		}
		
		$others = array();
		foreach($config->getExtraParams() as $prop) {
			$key = $config->getParamKey($prop);
			$type = $config->getParamType($prop);
			if(isset($key) == false || isset($type) == false) {
				throw new \RuntimeException('Missing configuration (key or type) for property: "'.$storeName.'->'.$prop.'"');
			}
			
			$others[$prop] = $this->serializer->deserialize($this->request->get($config->getParamKey($prop),$config->getParamDefaultValue($prop)), $config->getParamType($prop), $config->getParamFormat($prop)); 
		}
		
		$p = $refObject->getProperty('misc');
		$p->setAccessible(true);
		$p->setValue($storeRequest, $others);
		$p->setAccessible(false);
		
		if($actionType = $this->guessActionType($storeRequest)) {
			$storeRequest->setActionType($actionType);
		}
		
		return $storeRequest;
	}
	
	private function jsonfiy($value) {
		return json_encode($value);
	}
	
	private function getRequestConfig($key) {
		if(key_exists($key,$this->storeRequestMap)) {
			return $this->storeRequestMap[$key];
		}
		
		return $this->storeRequestMap['default'];
	}
	
	private function guessActionType(StoreRequest $storeRequest) {
		switch($this->request->getMethod()) {
			case 'POST':
				return StoreRequestInterface::TYPE_CREATE;
			break;
			case 'PUT':
				return StoreRequestInterface::TYPE_UPDATE;
			break;
			case 'GET':
				if($storeRequest->getId()) {
					return StoreRequestInterface::TYPE_LOAD;
				} else {
					return StoreRequestInterface::TYPE_LOAD_LIST;
				}
			break;
			case 'DELETE':
				return StoreRequestInterface::TYPE_DELETE;
			break;
		}
		
		return null;
	}
}
?>
