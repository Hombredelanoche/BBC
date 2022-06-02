<?php

namespace App\Controller;

use App\Entity\TodoArticle;
use App\Form\TodoArticleType;
use App\Repository\UserProfilRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ActualityController extends AbstractController
{
    #[Route('/actuality', name: 'actuality')]
    public function index(): Response
    {   
        return $this->render('view/_actuality.html.twig');
    }

    #[Route('actuality/create', name: 'create_art')]
    #[IsGranted('ROLE_USER')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {

        $todo = new TodoArticle;

        $form = $this->createForm(TodoArticleType::class, $todo);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $todo->setDate(new \DateTimeImmutable());
            $em->persist($todo);
            $em->flush();
            
            $this->addFlash('succed', 'Votre article à bien été crée.');
            $this->redirectToRoute('actuality');
        }
       
       return $this->render('view/todoArticle/_createArticle.html.twig', [
           'todo' => $form->createView()
       ]);
    }
}
