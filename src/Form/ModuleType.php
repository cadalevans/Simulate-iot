<?php

namespace App\Form;

use App\Entity\Module;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModuleType extends AbstractType
{
    // I have generated this form automatically with symfony console make:form
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('category')
            ->add('description')
            //->add('isOperating') because i am going to set it to true so all the new module should be working fine 
            //->add('installationDate') it's going to take the current date so the user don't have to add it 
            //->add('user')
            // i hide the user so that it couldn't appear in the form 
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Module::class,
        ]);
    }
}
