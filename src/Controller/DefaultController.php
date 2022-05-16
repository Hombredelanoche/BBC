<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController 
{

    #[Route('/', name: 'index' )]
    #[Route('/accueil', name: 'homepage')]
    public function index(Request $request): Response {

        $request = random_int(1,100);
        return $this->render('base.html.twig', ['Request' => $request]);
    }

    #[Route('/planning', name: 'planning')]
    public function planning(): Response {
        return $this->render('view/_planning.html.twig');
    }

    #[Route('/actuality', name: 'actuality')]
    public function actu(): Response {
        return $this->render('view/_actuality.html.twig');
    }









}


?>