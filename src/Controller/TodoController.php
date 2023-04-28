<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('todo')]
class TodoController extends AbstractController
{
    #[Route('/', name: 'app_todo')]
    public function index(SessionInterface $session): Response
    {
//        Si je n'ai pas de session
        if (!$session->has('todos')) {
            $todos = array(
                'achat' => 'acheter clé usb',
                'cours' => 'Finaliser mon cours',
                'correction' => 'corriger mes examens'
            );
            $session->set('todos', $todos);
            $this->addFlash('info','Bienvenu dans notre gestionnaire de Todo');
        }
        return $this->render('todo/index.html.twig');
    }

    #[Route('/delete/{name}', name: 'app_todo_delete')]
    public function delete(SessionInterface $session, $name): Response
    {
//        Si je n'ai pas de session
        if ($session->has('todos')) {
            $todos = $session->get('todos');
            if (isset($todos[$name])) {
                unset($todos[$name]);
                $session->set('todos', $todos);
                $this->addFlash('success',"Le Todo $name a été supprimé avec succès");
            } else {
                $this->addFlash('error',"Le Todo $name n'existe pas");
            }
        } else {
            $this->addFlash('warning',"Rabi iehdik Ti haka tawa");
        }
        return $this->redirectToRoute('app_todo');
    }
}
