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


class ModuleController extends AbstractController
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/mod', name: 'app_module')]
    public function new(): Response
    {
        return $this->render('module/index.html.twig', [
            'controller_name' => 'ModuleController',
        ]);
    }
    #[Route('/module', name:'module_add')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $module = new Module();

        // Get the current user
        $currentUser = $this->security->getUser();

        // Check if the current user exists and is authenticated
        if ($currentUser) {
            // Set the current user in the module entity
            $module->setUser($currentUser);
        } else {
            // Handle the case when the current user is not available or not authenticated

           // $module->setUser(null); // in my case i have set it to null
        }

        $form = $this->createForm(ModuleType::class, $module);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($module);
            $entityManager->flush();

            return $this->redirectToRoute('main_index');
        }

        return $this->render('module/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
