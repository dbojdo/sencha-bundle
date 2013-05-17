<?php
namespace Webit\Bundle\SenchaBundle\Component\Store;
class StoreResponse implements StoreResponseInterface {
	protected $success = true;
	
	protected $data = array();
	
	protected $total;
	
	protected $messages = array();
	
	public function getSuccess() {
		return $this->success;
	}
	
	public function setSuccess($success) {
		$this->success = $success;
	}
	
	public function getData() {
		return $this->data;
	}
	
	public function setData($data) {
		$this->data = $data;
	}
	
	public function getTotal() {
		return $this->total;
	}
	
	public function setTotal($total) {
		$this->total = $total;
	}
	
	public function getMessages() {
		return $this->messages;
	}
	
	public function addMessage($message) {
		$this->messages[] = $message;
	}
}
?>
