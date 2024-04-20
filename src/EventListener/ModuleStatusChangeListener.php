<?php

// src/EventListener/ModuleStatusChangeListener.php

namespace App\EventListener;

use App\Entity\Module;
use App\Event\ModuleStatusChangeEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class ModuleStatusChangeListener implements EventSubscriberInterface
{
    private $flashBag;

   /* public function __construct(FlashBagInterface $flashBag)
    {
       // $this->flashBag = $flashBag;
    }
    */

    public static function getSubscribedEvents(): array
    {
        return [
            ModuleStatusChangeEvent::NAME => 'onModuleStatusChange',
        ];
    }

    public function onModuleStatusChange(ModuleStatusChangeEvent $event)
    {
        $module = $event->getModule();
        if (!$module->isIsOperating()) {
            $this->flashBag->add('warning', "Module '{$module->getName()}' has stopped.");
        }
    }
}
