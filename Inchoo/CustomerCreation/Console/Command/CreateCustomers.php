<?php
 
namespace Inchoo\CustomerCreation\Console\Command;
 
use Exception;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Console\Cli;
use Magento\Framework\Filesystem;
use Magento\Framework\App\State;
use Magento\Framework\App\Area;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Inchoo\CustomerCreation\Model\Customer;
 
class CreateCustomers extends Command
{
  // everything else goes here
  private $filesystem;
private $customer;
private $state;
 
public function __construct(
    Filesystem $filesystem,
    Customer $customer,
    State $state
) {
parent::__construct();
    $this->filesystem = $filesystem;
    $this->customer = $customer;
    $this->state = $state;
}
public function configure(): void
{
    $this->setName('create:customers');
}
public function execute(InputInterface $input, OutputInterface $output): ?int
{
  try {
      $this->state->setAreaCode(Area::AREA_GLOBAL);
 
      $mediaDir = $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA);
      $fixture = $mediaDir->getAbsolutePath() . 'fixtures/sample.csv';
 
      $this->customer->install($fixture, $output);
 
      return Cli::RETURN_SUCCESS;
  } catch (Exception $e) {
      $msg = $e->getMessage();
      $output->writeln("<error>$msg</error>", OutputInterface::OUTPUT_NORMAL);
      return Cli::RETURN_FAILURE;
  }
}

}