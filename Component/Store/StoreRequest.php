<?php
namespace Webit\Bundle\SenchaBundle\Component\Store;

use Symfony\Component\HttpFoundation\Request;
use Webit\Tools\Data\FilterCollection;
use Webit\Tools\Data\SorterCollection;

class StoreRequest implements StoreRequestInterface {
	/** 
	 * @var Request
	 */
	private $request;
	
	private $id;
	
	private $node;
	
	private $filters;
	
	private $sorters;
	
	private $limit;
	
	private $offset;
	
	private $page;
	
	private $data;
	
	private $misc = array();
	
	private $storeName;
	
	private $actionType;
	
	public function __construct($storeName, Request $request, SorterCollection $sorters = null, FilterCollection $filters = null, $data = null, $limit = null, $offset = null, $page = null) {
		$this->storeName = $storeName;
		$this->request = $request;
		$this->filters = $filters;
		$this->data = $data;
		$this->limit = $limit;
		$this->offset = $offset;
		$this->page = $page;
	}
	
	public function getStoreName() {
		return $this->storeName;
	}
	
	public function getActionType() {
		return $this->actionType;
	}
	
	public function setActionType($type) {
		$this->actionType = $type;
	}
	
	/**
	 * @return Request
	 */
	public function getRequest() {
		return $this->request;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getNode() {
		return $this->node ?: 'root';
	}
	
	public function getFilters() {
		return $this->filters ?: new FilterCollection();
	}
	
	public function getSorters() {
		return $this->sorters ?: new SorterCollection();
	}
	
	public function getLimit() {
		return $this->limit;
	}
	
	public function getPage() {
		return $this->page;
	}
	
	public function getOffset() {
		return $this->offset;
	}
	
	public function getData() {
		return $this->data;
	}
}
?>
