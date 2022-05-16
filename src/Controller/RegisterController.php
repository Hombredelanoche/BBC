<?php

namespace App\Controller;

use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function register(Request $request): Response
    {
        $Register = $this->createForm(RegisterType::class);

        $Register->handleRequest($request);

        if($Register->isSubmitted() && $Register->isValid()){
            dump($Register->getData());
        }
        
        return $this->render('view/_register.html.twig', [
            'inscription' => $Register->createView()
        ]);
    }
}