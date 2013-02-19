<?php

namespace BRS\DeployBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DeployBundleCommand extends ContainerAwareCommand
{
	protected function configure()
	{
		$this
			->setName('deploy')
			->setDescription('update production cache and assets')
			->addArgument('target', InputArgument::OPTIONAL, 'Specify a deploy target, default is this application.');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		//$wd = exec('pwd');

		//passthru("find . -name '*~' -type f -delete");
		
		$target = $input->getArgument('target');
		
		if($target){
			
			$targets = $this->getContainer()->getParameter('deploy_targets');
			
			if(isset($targets[$target])){
				
				$output->writeln("Deploying to $target");
				
				$target_info = $targets[$target];
				
				$ssh = $target_info['ssh'];
				
				$app = $target_info['app'];
				
				$output->writeln($ssh . ":" . $app);
				
				$command = "ssh $ssh 'cd $app; git pull; bin/bundles; app/console deploy'";
				
				passthru($command);
								
			}else{
				
				$output->writeln("No target configured: $target");
			}
				
		}else{
			
			$output->writeln("Deploying");
			
			//passthru("git pull");
			//passthru("bin/bundles");
			passthru("app/console cache:clear");
			passthru("app/console src:update");
			passthru("app/console assets:install --symlink web");
			passthru("app/console assetic:dump --env=prod");
			passthru("app/console cache:clear --env=prod");
		}
		
		
		
	}
}