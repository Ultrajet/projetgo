<?php

namespace App\Form;

use App\Entity\Jeu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class GeolocType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('jeu', EntityType::class, [
                'mapped' => false,
                'class' => Jeu::class,
                'choice_label' => 'nom',
                'expanded' => true,
                'label' => 'Sélection d\'un jeu :',
                'choice_attr' => function ($choice, $key, $value) {
                    // adds a class like attending_yes, attending_no, etc
                    return [
                        'onclick' => 'handleClick(this);'
                    ];
                }
            ]);
    }

    // public function configureOptions(OptionsResolver $resolver)
    // {
    //     $resolver->setDefaults([
    //         'data_class' => UserJeu::class,
    //     ]);
    // }
}
