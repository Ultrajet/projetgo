<?php

namespace App\Form;

use App\Entity\Jeu;
use App\Entity\User;
use App\Service\GenerateurCoordonnees;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez remplir le champ.',
                    ]),
                    new Length([
                        'min' => 3,
                        'max' => 30,
                        'minMessage' => 'Veuillez mettre un pseudo avec 3 caractère minimum.',
                        'maxMessage' => 'Veuillez mettre un pseudo avec 30 caractère maximum.'
                    ])
                ]
            ])
            ->add('email', EmailType::class, array(
                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Veuillez remplir le champ'
                    )),
                    new Email(array(
                        'message' => '{{ value }} n est pas un email valide'
                    )),
                    new Length(array(
                        'min' => 3,
                        'max' => 40,
                        'minMessage' => 'Veuillez mettre un email avec 3 caractère minimum ',
                        'maxMessage' => 'Veuillez mettre un email avec 40 caractère maximum '
                    ))
                )
            ))
            ->add('password', RepeatedType::class, [
                'mapped' => false,
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mots de passe doivent correspondre.',
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer le mot de passe'],
                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Veuillez remplir le champ'
                    ))
                )
            ])
            ->add('ville', TextType::class, array(
                'required' => false,
                'constraints' => array(
                    new Length(array(
                        'max' => 40,
                        'maxMessage' => 'Veuillez mettre une ville avec 40 caractères maximum.'
                    )),
                    new Callback([$this, 'validate'])
                )
            ))
            ->add('jeux', EntityType::class, [
                'mapped' => false,
                'class' => Jeu::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les conditions d\'utilisation.',
                    ]),
                ],
                'label' => "Accepter les termes d'utilisation",
            ]);
    }

    public function validate($data, ExecutionContextInterface $context): void
    {
        if (!is_null($data)) {
            $generateurCoordonnees = new GenerateurCoordonnees;

            if (!$generateurCoordonnees->generer($data)) {
                $context->buildViolation("Le nom de cette ville n'a pas été reconnu.")
                    ->atPath('ville')
                    ->addViolation();
            }
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr' => [
                'novalidate' => 'novalidate'
            ]
        ]);
    }
}
