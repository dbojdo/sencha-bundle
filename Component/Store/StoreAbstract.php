<?php
namespace Webit\Bundle\SenchaBundle\Component\Store;

abstract class StoreAbstract extends StoreCommonAbstract implements StoreInterface {
	/**
	 * @param StoreRequestInterface $request
	 * @return StoreResponseInterface
	 */
	public function create(StoreRequestInterface $request) {
		return $this->response(false, array(), 'Required action "create" is not supported for this store');
	}
	
	/**
	 * @param StoreRequestInterface $request
	 * @return StoreResponseInterface
	 */
	public function update(StoreRequestInterface $request) {
		return $this->response(false, array(), 'Required action "update" is not supported for this store');
	}
	
	/**
	 * @param StoreRequestInterface $request
	 * @return StoreResponseInterface
	 */
	public function delete(StoreRequestInterface $request) {
		return $this->response(false, array(), 'Required action "delete" is not supported for this store');
	}
	
	/**
	 * @param StoreRequestInterface $request
	 * @return StoreResponseInterface
	 */
	public function loadList(StoreRequestInterface $request) {
		return $this->response(false, array(), 'Required action "load_list" is not supported for this store');
	}
	
	/**
	 * @param StoreRequestInterface $request
	 * @return StoreResponseInterface
	 */
	public function load(StoreRequestInterface $request) {		
		return $this->response(false, array(), 'Required action "load" is not supported for this store');
	}
}
?>
