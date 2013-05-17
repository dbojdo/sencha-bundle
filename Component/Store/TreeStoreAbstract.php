<?php
namespace Webit\Bundle\SenchaBundle\Component\Store;
abstract class TreeStoreAbstract extends StoreCommonAbstract implements TreeStoreInterface {
	public function getChildren(StoreRequestInterface $request) {
		return $this->response(false, array(), 'Required action "children" is not supported for this store');
	}
}
?>
