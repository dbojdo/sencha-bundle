<?php
namespace Webit\Bundle\SenchaBundle\Component\Store;

interface TreeStoreInterface extends StoreCommonInterface {
	public function getChildren(StoreRequestInterface $request);
}
?>
