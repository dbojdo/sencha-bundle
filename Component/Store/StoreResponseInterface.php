<?php
namespace Webit\Bundle\SenchaBundle\Component\Store;

interface StoreResponseInterface {
	public function getSuccess();
	
	public function setSuccess($success);
	
	public function getData();
	
	public function setData($data);
	
	public function getTotal();
	
	public function setTotal($total);
	
	public function getMessages();

	public function addMessage($message);
}
?>
