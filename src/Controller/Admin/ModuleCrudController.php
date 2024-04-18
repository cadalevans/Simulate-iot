<?php

namespace App\Controller\Admin;

use App\Entity\Module;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Security\Core\Security;




class ModuleCrudController extends AbstractCrudController
{
    private Security $security;
      public static function getEntityFqcn(): string
    {
        return Module::class;
    }

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        // Get the authenticated user
        $user = $this->security->getUser();

        // Create a new Module instance
        $module = new Module();

        // Associate the user with the module
        $module->setUser($user);

        // Now you can persist the module entity as usual
        $entityManager->persist($module);
        $entityManager->flush();
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
