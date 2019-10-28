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
use Symfony\Component\Security\Core\User\UserInterface;

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
     * @Route("/postmessage/{id}", name="postmessage", methods={"POST"})
     */
    public function postMessage(Request $request, $id)
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);

        $theReturn = '';
        $userPost = $this->getUser();

        $repository = $this->getDoctrine()->getRepository(User::class);
        $userGet = $repository->find($id);

        $form->handleRequest($request);

        // return new JsonResponse($request->getContent());
        // exit;

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

    /**
     * @Route("/getmessages/{id}", name="getmessages")
     */
    public function getMessages($id)
    {
        $repository = $this->getDoctrine()->getRepository(Message::class);

        $userPost = $this->getUser()->getId();
        $messages = $repository->getMessages($userPost, $id);

        return new JsonResponse($messages);
    }
}
