<?php

namespace App\Form;

use App\Entity\Jeu;
use App\Entity\User;
use App\Service\GenerateurCoordonnees;
use Exception;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('email')
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
            ->add('txt_profil', TextareaType::class, [
                'required' => false,
            ])
            ->add('jeux', EntityType::class, [
                'mapped' => false,
                'class' => Jeu::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => true,
                'choice_attr' => function ($val, $keys, $index) use ($options) {
                    return in_array($index, $options['userJeu']) ? ['checked' => 'checked'] : [null];
                }
            ]);
    }

    public function validate($data, ExecutionContextInterface $context): void
    {
        if (!is_null($data)) {
            $generateurCoordonnees = new GenerateurCoordonnees;

            try {
                $generateurCoordonnees->generer($data);
            } catch (TransportExceptionInterface $e) {
                $context->buildViolation($e->getMessage())
                    ->atPath('ville')
                    ->addViolation();
            } catch (Exception $e) {
                $context->buildViolation($e->getMessage())
                    ->atPath('ville')
                    ->addViolation();
            }
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'userJeu' => null
        ]);
    }
}
