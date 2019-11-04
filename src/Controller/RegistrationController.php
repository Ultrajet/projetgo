<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserJeu;
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
        if ($this->getUser()) {
            return $this->redirectToRoute('index');
        }

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            // on donne par défaut le rôle ROLE_USER à un nouveau membre
            $user->setRoles(['ROLE_USER']);

            $jeux = $form->get('jeux')->getData();
            foreach ($jeux as $jeu) {
                $userJeu = new UserJeu();
                $userJeu
                    ->setUser($user)
                    ->setJeu($jeu);
                $entityManager->persist($userJeu);
            }

            $ville = $form->get('ville')->getData();
            $coordonnees = $generateurCoordonnees->generer($ville);
            $user->setCoordonnees($coordonnees);

            $entityManager->persist($user);
            $entityManager->flush();

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView()
        ]);
    }
}
