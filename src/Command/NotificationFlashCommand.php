<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use App\Entity\Module;

#[AsCommand(
    name: 'NotificationFlashCommand',
    description: 'Add a short description for your command',
)]
class NotificationFlashCommand extends Command
{
    private $security;
    //private $session;
    //private SessionInterface $session;
    // Inject the security component and session interface
    public function __construct(Security $security)
    {
        $this->security = $security;
        
        parent::__construct();
    }
    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }
    // retrieve the flash messages bag
  

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Get the current user
        $currentUser = $this->security->getUser();

        // Check if the current user is authenticated
        if ($currentUser) {
            // Retrieve the modules created by the current user
            $modules = $currentUser->getModules();

            // Iterate through the modules
            foreach ($modules as $module) {
                // Check if the module meets the condition to send the flash message
                if ($module->isIsOperating() === false) {
                    // Send the flash message to the current user
                    $this->sendNotification($module);
                   // $this->session->getFlashBag()->add('warning', 'One of your modules is not operating correctly.');
                    break; // Stop after sending the flash message once
                }
            }
        }
        
        // Your command logic continues here
    }
    private function sendNotification(Module $module)
    {
        //$this->addFlash();
        //$module->getUser()->getFlashBag()->add();
        // Implement logic to send notifications
        // You can use Symfony's Messenger component, email, or any other method to send notifications
    }
    
}
