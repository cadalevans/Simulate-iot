<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Main;
use App\Form\MainType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;




class MainController extends AbstractController
{
    #[Route('/main', name: 'app_main')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $main = new Main();
        $form = $this->createForm(MainType::class, $main);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($main);
            $entityManager->flush();

            return $this->redirectToRoute('main_index');
        }

        return $this->render('main/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/main/new', name: 'main_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $main = new Main();
        $form = $this->createForm(MainType::class, $main);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($main);
            $entityManager->flush();

            return $this->redirectToRoute('main_index');
        }

        return $this->render('main/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/main/edit', name: 'main_edit')]
    public function edit(MainType $mainType, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(MainType::class, $mainType);
        return $this->render('main/edit.html.twig',[
            'form' => $form->createView(), // Passer la variable "form" au modèle Twig
        ]);
    }
}
