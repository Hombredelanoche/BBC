<?php

namespace App\Controller;

use App\Entity\TodoArticle;
use App\Repository\UserProfilRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ActualityController extends AbstractController
{
    #[Route('/actuality', name: 'actuality')]
    public function index(): Response
    {
        return $this->render('view/_actuality.html.twig', [
            'controller_name' => 'ActualityController',
        ]);
    }

    #[Route('actuality/create', name: 'create')]
    #[IsGranted('ROLE_USER')]
    public function create(EntityManagerInterface $em, UserProfilRepository $userRepo): Response
    {
       $user = $this->getUser();

       

       return $this->redirectToRoute('homepage');
    }
}
