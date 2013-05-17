<?php
namespace Webit\Bundle\SenchaBundle\Component\Store;

use JMS\Serializer\Annotation\Type;
use Doctrine\Common\Collections\ArrayCollection;

class TreeNode {	
	/**
	 * @var mixed
	 */
	public $id;
	
	/**
	 * @var string
	 */
	public $text;
	
	/**
	 * @var mixed
	 */
	public $parentId;
	
	/**
	 * @var int
	 */
	public $index;
	
	/**
	 * @var int
	 */
	public $depth = 0;
	
	/**
     * @var boolean
	 */
	public $expanded = false;
	
	/**
	 * @var boolean
	 */
	public $expandable = true;	

	/**
	 * @var string
	 */
	public $checked;
	
	/**
	 * @var boolean
	 */
	public $leaf = false;
	
	/**
	 * @var string
	 */
	public $cls;

	/**
	 * @var string
	 */
	public $iconCls;
	
	/**
	 * @var string
	 */
	public $icon;
	
	/**
	 * @var Boolean
	 */
	public $root = false;
	
	/**
	 * @var Boolean
	 */
	public $isLast = false;
	
	/**
	 * @var Boolean
	 */
	public $isFirst = false;
	
	/**
	 * @var Boolean
	 */
	public $allowDrop = true;
	
	/**
	 * @var Boolean
	 */
	public $allowDrag = true;

	/**
	 * @var Boolean
	 */
	public $loaded = false;
	
	/**
	 * @var Boolean
	 */
	public $loading = false;
	
	/**
	 * @var string
	 */
	public $href;
	
	/**
	 * @var string
	 */
	public $hrefTarget;
	
	/**
	 * @var string
	 */
	public $qtip;
	
	/**
	 * @var string
	 */
	public $qtitle;
	
	/**
	 * @var ArrayCollection
	 */
	public $children;
	
	public function __construct() {
		$this->children = new ArrayCollection();
	}

	public function fromArray($arNode) {
		foreach($arNode as $key=>$value) {
			if($key == 'children') {
				foreach($arNode['children'] as $arChild) {
					$child = new self();
					$child->fromArray($arChild);
					$this->children->add($child);
				}
			} else {
				$this->{$key} = $value;
			}
		}
	}
}
?>
