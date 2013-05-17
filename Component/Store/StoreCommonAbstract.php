<?php
namespace Webit\Bundle\SenchaBundle\Component\Store;

abstract class StoreCommonAbstract implements StoreCommonInterface {
	/**
	 *
	 * @param bool $success
	 * @param mixed $data
	 * @param string|array $messages
	 * @return \Webit\Bundle\SenchaBundle\Component\Store\StoreResponse
	 */
	protected function response($success = true, $data = array(), $messages = array()) {
		$response = new StoreResponse();
		$response->setSuccess($success);
		$response->setData($data);
		$messages = (array)$messages;
	
		foreach($messages as $msg) {
			$response->addMessage($msg);
		}
	
		return $response;
	}
}
?>
