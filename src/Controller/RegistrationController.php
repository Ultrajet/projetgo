<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use App\Service\GenerateurCoordonnees;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/inscription", name="inscription")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator, GenerateurCoordonnees $generateurCoordonnees): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            // on donne par défaut le rôle ROLE_USER à un nouveau membre
            $user->setRoles(['ROLE_USER']);

            $ville = $form->get('ville')->getData();
            $coordonnees = $generateurCoordonnees->generer($ville);
            if (!$coordonnees) {
                // je veux que : on retourne sur la page d'inscription, avec les champs déjà remplis, et un jouli petit message "votre ville n'est pas correcte"
                return $this->redirectToRoute('inscription');
            } else {
                $user->setCoordonnees($coordonnees);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                return $guardHandler->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $authenticator,
                    'main' // firewall name in security.yaml
                );
            }
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/test000", name="test coordonnées")
     */
    public function testCoordonnees(GenerateurCoordonnees $generateurCoordonnees)
    {
        $ville = "Stéphane000";
        $coordonnees = $generateurCoordonnees->generer($ville);
        if (!$coordonnees) {
            $coordonnees = "Erreur";
        }

        return new Response("<pre>" . $coordonnees . "</pre>");
        // return new Response("<pre>$request</pre>");
    }
}
