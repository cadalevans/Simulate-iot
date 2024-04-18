<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Repository\ModuleRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Module;

#[AsCommand(
    name: 'app:persist-module',
    description: 'Add a short description for your command',
    hidden: false,
    aliases: ['app:add-module']
)]
class PersistModuleCommand extends Command
{

    private $entityManager;
    private $moduleRepository;

    public function __construct(EntityManagerInterface $entityManager, ModuleRepository $moduleRepository)
    {
        $this->entityManager = $entityManager;
        $this->moduleRepository = $moduleRepository;

        parent::__construct();
    }
    protected function configure(): void
    {
        $this->setDescription('Generate and persist random is_Operating for modules');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            // Generate and persist random data
            $this->generateAndPersistRandomModule();

            $output->writeln('Random is_Operating module persisted successfully.');

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln('An error occurred: ' . $e->getMessage());

            return Command::FAILURE;
        }
    }
    private function generateAndPersistRandomModule(): void
    {
        $modules = $this->moduleRepository->findAll();

        
        foreach ($modules as $module) {
            $module->setIsOperating((bool) rand(0, 1));
        }
    
        
        $this->entityManager->flush();
    }
}
// command : php bin/console app:persist-module
//linux link : https://www.brainvire.com/configure-cron-jobs-symfony/
// on window we can see it on stack overflow : https://stackoverflow.com/questions/71352951/how-to-run-a-symfony-command-in-windows-task-scheduler
