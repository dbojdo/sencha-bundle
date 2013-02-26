<?php
namespace Webit\Bundle\SenchaBundle\Component\Common;

class Installer {
	const SENCHA_EXTJS = 'extjs';
	const SENCHA_TOUCH = 'touch';
	
	/**
	 * @var array
	 */
	protected $sourceList;
	
	/**
	 * @var string
	 */
	protected $targetDir;
	
	public function __construct($targetDir, $sourceList = array()) {
		$this->sourceList = $sourceList;
		
		$this->setTargetDir($targetDir);
	}
	
	private function setTargetDir($dir) {
		if(!is_dir($dir)) {
			@mkdir($dir,0755,true);
		}
		
		if(!is_writable($dir)) {
			throw new \Exception('Target directory ('.$dir.') is not writable.');
		}
		
		$this->targetDir = $dir;
	}
	
	private function getUrl($lib, $version) {
		if(!isset($this->sourceList[$lib][$version])) {
			throw new \Exception('Source url not found.'); 
		}
		
		return $this->sourceList[$lib][$version];
	}
	
	/**
	 * 
	 * @param string $lib one of SENCHA_* constants
	 * @param string $version
	 * @param string $sourceFile
	 * @throws \Exception
	 */
	public function install($lib, $version, $sourceFile = null) {
		$lib = strtolower($lib);
		$version = strtolower($version);
		
		if($sourceFile == null) {
			$url = $this->getUrl($lib, $version);
			$sourceFile = $this->download($url, $lib);
			if(!$sourceFile) {
				throw new \Exception('Cannot download library from given url: '.$url);
			}	
		}
		
		$this->extract($sourceFile, $lib, $version);
	}
	
	private function download($url, $lib) {
		$path = $this->targetDir . '/'.$lib.'.zip';
		 
		if(file_put_contents($path, file_get_contents($url))) {
			return $path;
		}
	
		return false;
	}
	
	private function extract($path, $lib, $version) {
		if(!is_file($path)) {
			throw new \Exception('Source path not found');
		}
		
		$zip = new \ZipArchive();
		$zip->open($path);
		$zip->extractTo($this->targetDir);
		 
		rename($this->targetDir . '/'. $zip->getNameIndex(0), $this->targetDir . '/'.$lib.'-'.$version);
		 
		unlink($path);
	}
}
?>
