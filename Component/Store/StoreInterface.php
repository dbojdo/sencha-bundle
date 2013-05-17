<?php 
namespace Webit\Bundle\SenchaBundle\Component\Store;

interface StoreInterface extends StoreCommonInterface {	
	/**
	 * @param StoreRequestInterface $request
	 * @return StoreResponseInterface
	 */
	public function create(StoreRequestInterface $request);
	
	/**
	 * @param StoreRequestInterface $request
	 * @return StoreResponseInterface
	 */
	public function update(StoreRequestInterface $request);
	
	/**
	 * @param StoreRequestInterface $request
	 * @return StoreResponseInterface
	 */
	public function delete(StoreRequestInterface $request);
	
	/**
	 * @param StoreRequestInterface $request
	 * @return StoreResponseInterface
	 */
	public function loadList(StoreRequestInterface $request);
	
	/**
	 * @param StoreRequestInterface $request
	 * @return StoreResponseInterface
	 */
	public function load(StoreRequestInterface $request);
}
?>
