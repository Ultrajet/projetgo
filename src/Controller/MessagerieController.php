<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Message;
use App\Form\MessageType;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;

class MessagerieController extends AbstractController
{
    /**
     * @Route("/message/{id}", name="messagerie")
     */
    public function message($id)
    {
        $form = $this->createForm(MessageType::class);

        return $this->render('messagerie/index.html.twig', [
            'id' => $id,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/postmessage", name="postmessage", methods={"GET", "POST"})
     */
    public function postMessage(Request $request, Security $security)
    {
        // // $repository = $this->getDoctrine()->getRepository(User::class);
        // // $userGet = $repository->find($request->get('userGet'));
        // return new JsonResponse($request->getContent());
        // exit;

        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);

        $theReturn = '';
        // $content = $form->get('content')->getData();
        $content = 'Hello World!';
        $userPost = $security->getUser();

        $repository = $this->getDoctrine()->getRepository(User::class);
        $userGet = $repository->find(100);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $message->setContent($form->get('content')->getData());
            $message->setUserPost($userPost);
            $message->setUserGet($userGet);

            $message->setTime(new DateTime('now'));

            $entityManager->persist($message);
            $entityManager->flush();

            $theReturn = new JsonResponse('OKAY!!!');
        } else {
            $theReturn = new JsonResponse('CA MARCHE PAS MAIS DU COUP CA MARCHE');
        }

        return $theReturn;
    }
}
