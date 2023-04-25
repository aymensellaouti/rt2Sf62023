<?php

namespace App\Controller;

use App\Service\FirstService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    // Controller
    #[Route('/first/{section}', name: 'app_first')]
    public function index($section, Request $request, SessionInterface $session): Response
    {
//        $session = $request->getSession();
        if ($session->has('nbVisite')) {
            $nbVisite = $session->get('nbVisite');
            $nbVisite++;
            $message = "Merci pour votre fidilitè c'est votre $nbVisite éme fois :)";
            $session->set('nbVisite', $nbVisite);
        } else {
            $this->addFlash('success', 'Vous avez reçu à accéder à notre page ');
            $this->addFlash('success', 'Bravo :D');
            $message = "Bienvenu :)";
            $session->set('nbVisite', 1);
        }
        // Vue
        return $this->render('first/index.html.twig', [
            'controller_name' => $section,
            'message' => $message
        ]);
    }
}
