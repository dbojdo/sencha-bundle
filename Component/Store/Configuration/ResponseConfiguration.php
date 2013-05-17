<?php
namespace Webit\Bundle\SenchaBundle\Component\Store\Configuration;

class ResponseConfiguration {
	/**
	 * @var string
	 */
	protected $format;
	
	/**
	 * @var array
	 */
	protected $serializerGroups = array();
	
	/**
	 * @param string $format
	 * @param array $serializerGroups
	 */
	public function __construct($format, array $serializerGroups = array()) {
		$this->format = $format;
		$this->serializerGroups = $serializerGroups;
	}
	
	/**
	 * @return string
	 */
	public function getFormat() {
		return $this->format;
	}
	
	/**
	 * @param string $action
	 * @return array:|NULL
	 */
	public function getSerializerGroups($action) {
		if(isset($this->serializerGroups[$action])) {
			return $this->serializerGroups[$action];
		}
		
		return null;
	}
}
?>
