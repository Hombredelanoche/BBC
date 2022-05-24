<?php

namespace App\Controller;

use App\Entity\Registration;
use App\Entity\TodoArticles;
use App\Form\RegistrationType;
use App\Form\TodoArticlesType;
use App\Repository\PlanningRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DefaultController extends AbstractController 
{

    #[Route('/', name: 'index' )]
    #[Route('/accueil', name: 'homepage')]
    public function index(Request $request): Response {
        return $this->render('base.html.twig');
    }

    #[Route('/planning', name: 'planning')]
    public function planning(PlanningRepository $planning): Response {
        
        $events = $planning->findAll();
        
        $rdvs = [];

        foreach($events as $event){
            $rdvs[] = [
                'id' => $event->getId(),
                'title' => $event->getTitle(),
                'debut' => $event->getDebut()->format('Y-m-d H:i:s'),
                'fin' => $event->getFin()->format('Y-m-d H:i:s'),
                'description' => $event->getDescription(),
                'allDay' => $event->getAllDay(),
                'background-color' => $event->getBackgroundColor(),
                'text-color' => $event->getTextColor(),
                'border-color' => $event->getBorderColor()
            ];
        }
        $data = json_encode($rdvs);
        
        return $this->render('view/_planning.html.twig', compact('data'));
    }

    #[Route('/actuality', name: 'actuality')]
    public function actu(Request $request): Response {

        $article = new TodoArticles;

        $createTodo = $this->createForm(TodoArticlesType::class);

        $createTodo->handleRequest($request);

        if($createTodo->isSubmitted() && $createTodo->isValid()){
            // $EntityManager->persist($article);
            // $EntityManager->flush();
            dump($article);die;
        }

        return $this->render('view/_actuality.html.twig', [ 
            'todo' => $createTodo->createView()]);
    }





    #[Route('/login', name: 'login')]
    public function log(Request $request): Response
    {
       

        return $this->render('view/_login.html.twig');
    }


    
    #[Route("/register", name: "register")]
    #[Route("/register/{id}/edit", name:'user_edit')]
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new Registration;

        $userForm = $this->createForm(RegistrationType::class, $user);

        $userForm->handleRequest($request);
        if($userForm->isSubmitted() && $userForm->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
        }
          
        return $this->render('view/_registration.html.twig', [
            'inscription' => $userForm->createView()
        ]);
    }
};


?>