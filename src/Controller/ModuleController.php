<?php

namespace App\Controller;

use App\Entity\Module;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ModuleType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use App\Repository\ModuleRepository;


class ModuleController extends AbstractController
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/modules', name: 'app_module')]
    public function index(): Response
    {
        return $this->render('module/new.html.twig', [
            'controller_name' => 'ModuleController',
        ]);
    }

   #[Route('view', name:'note')]
    public function inviewdex(Request $request, EntityManagerInterface $entityManager): Response
    {
        $module = new Module();

        // Get the current user
        $currentUser = $this->security->getUser();

        // Check if the current user exists and is authenticated
        if ($currentUser) {
            // Set the current user in the module entity
            $module->setUser($currentUser);
        } else {
           

           // $module->setUser(null); // in my case i have set it to null
           //but note that normaly it was never going to be null because in case off unsuccessful login we can enter in 
           // in that page but some time let us say that we can have a problem with the credentials or a web attack so you can put it on null as you want 

        }

        $form = $this->createForm(ModuleType::class, $module);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $module->setIsOperating(true);
            $module->setInstallationDate(new \DateTime());
            $entityManager->persist($module);
            $entityManager->flush();

            return $this->redirectToRoute('module_add');
        }

        return $this->render('module/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/mod', name:'module_add')] 
    public function new(ModuleRepository $moduleRepository): Response
    {
        // Get the current user ID, you might have your own logic to retrieve it
        $userId = $this->getUser()->getId();

        // Fetch modules based on the user ID
        $modules = $moduleRepository->findModulesByUserId($userId);

        // Do something with the modules
        // ...

        return $this->render('module/new.html.twig', [
            'modules' => $modules,
        ]);
    }

    
}
