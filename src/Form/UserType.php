<?php

namespace App\Form;

use App\Entity\Jeu;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password')
            ->add('email')
            ->add('ville')
            ->add('txt_profil')
            // ->add('jeux', EntityType::class, [
            //     'mapped' => false,
            //     'class' => Jeu::class,
            //     'choice_label' => 'nom',
            //     'multiple' => true,
            //     'expanded' => true,
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
