<?php
namespace Webit\Bundle\SenchaBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ExtJsInstallCommand extends ContainerAwareCommand {
	/**
	 * 
	 * @var string
	 */
	protected $version;
	
	protected $downloadUrl;
	
	protected function configure() {
		parent::configure();
		
		$this->setName('webit:sencha:install')
					->addArgument('lib',InputArgument::REQUIRED)
					->addArgument('version',InputArgument::OPTIONAL)
					->addOption('sourceFile','sf',InputOption::VALUE_OPTIONAL,'ExtJS library source file')
					->setDescription('Download and install ExtJS library');
	}
		
	protected function execute(InputInterface $input, OutputInterface $output) {
		$lib = $input->getArgument('lib');
		$version = $input->getArgument('version') ?: $this->getContainer()->getParameter('webit_sencha.' . strtolower($lib) . '_version');
		$sf = $input->getOption('sourceFile');
		
		$installer = $this->getContainer()->get('webit_sencha.installer');
		
		$output->writeln(sprintf('Installing <info>%s</info> library version <info>%s</info>...', $lib, $version));
		$installer->install($lib, $version, $sf);
		$output->writeln('Instalation has been finished successfully.');
	}
	
  private function download($url) {
  	$path = $this->getAssetDir() . '/extjs.zip';
  	
		if(file_put_contents($path, file_get_contents($url))) {
			return $path;
		}
		
		return false;
  }
  
  private function extract($path) {
  	$zip = new \ZipArchive();
  	$zip->open($path);
  	$zip->extractTo($this->getAssetDir());
  	
  	rename($this->getAssetDir() . '/'. $zip->getNameIndex(0), $this->getAssetDir() . '/extjs-'.$this->version);
  	
  	unlink($path);
  }
}
?>
