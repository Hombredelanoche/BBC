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
        $register = $this->createForm(RegisterType::class);

        $register->handleRequest($request);

        if($register->isSubmitted() && $register->isValid()){
            dump($register->getData());
        }
        
        return $this->render('view/_register.html.twig', [
            'inscription' => $register->createView()
        ]);
    }
}