<?php 
namespace Webit\Bundle\SenchaBundle\StaticData;

interface StaticDataExposerInterface {
	/**
	 * @return array<key, data>
	 */
	public function getExposedData();
}
