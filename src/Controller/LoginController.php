<?php

namespace App\Controller;

use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function log(Request $request): Response
    {


        $formLogin = $this->createForm(LoginType::class);

        $formLogin->handleRequest($request);

        if($formLogin->isSubmitted() && $formLogin->isValid()){
            dump($formLogin->getData());
        }

        return $this->render('view/_login.html.twig', [
            'log' => $formLogin->createView()
        ]);
    }
}
