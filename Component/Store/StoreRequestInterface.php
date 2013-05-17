<?php
namespace Webit\Bundle\SenchaBundle\Component\Store;

use Symfony\Component\HttpFoundation\Request;

interface StoreRequestInterface {
	const TYPE_LOAD_LIST = 'load_list';
	const TYPE_LOAD = 'load';
	const TYPE_CREATE = 'create';
	const TYPE_UPDATE = 'update';
	const TYPE_DELETE = 'delete';
	const TYPE_LOAD_CHILDREN = 'load_children';
	
	/**
	 * @return string
	 */
	public function getStoreName();
	
	/**
	 * @return Request
	 */
	public function getRequest();
	
	/**
	 * @return mixed
	 */
	public function getId();
	
	public function getNode();
	
	public function getFilters();
	
	public function getSorters();
	
	public function getLimit();
	
	public function getPage();
	
	public function getOffset();
	
	public function getData();
}
?>
