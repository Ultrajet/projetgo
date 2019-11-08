<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder
            ->add('username', TextType::class)
            ->add('email', TextType::class, array(
                'constraints' => array(
                    new Assert\Email(array(
                        'message' => '{{ value }} n\'est pas un email valide'
                    ))
                )
            ))
            ->add('objet', TextType::class)
            ->add('message', TextareaType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class
        ]);
    }
}