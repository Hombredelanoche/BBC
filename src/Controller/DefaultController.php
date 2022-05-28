<?php

namespace App\Controller;

use App\Entity\Registration;
use App\Entity\TodoArticles;
use App\Form\RegistrationType;
use App\Form\TodoArticlesType;
use App\Repository\CalendarRepository;
use App\Repository\PlanningRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
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
    public function planning(CalendarRepository $calendar)
    {
        $events = $calendar->findAll();
        
        $rdvs = [];
        foreach($events as $event){
            $rdvs[] = [
                'id' => $event->getId(),
                'start' => $event->getStart()->format('Y-m-d H:i:s'),
                'end' => $event->getEnd()->format('Y-m-d H:i:s'),
                'title' => $event->getTitle(),
                'description' => $event->getDescription(),
                'all_day' => $event->getAllDay(),
                'background_color' => $event->getBackgroundColor(),
                'border_color' => $event->getBorderColor(),
                'text_color' => $event->getTextColor(),
            ];
            
        }
        $data = json_encode($rdvs);
        return $this->render('view/_planning.html.twig', compact('data'));
    }
    
    #[Route('/actuality', name: 'actuality')]
    public function actu(Request $request, EntityManagerInterface $entityManager): Response {


        
        
        return $this->render('view/_actuality.html.twig');
    }





    #[Route('/login', name: 'login')]
    public function log(Request $request): Response
    {
       

        return $this->render('view/_login.html.twig');
    }


    
    #[Route("/register", name: "register")]
    #[Route("/register/{id}/edit", name:'user_edit')]
    public function register(Request $request, EntityManagerInterface $entityManager, RequestStack $requestStack): Response
    {
        $session = $requestStack->getSession();
        
        

        $user = new Registration;

        $userForm = $this->createForm(RegistrationType::class, $user);

        $userForm->handleRequest($request);
        if($userForm->isSubmitted() && $userForm->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('enregistrer', 'Merci ! Vous avez bien été enregistré !');
        }
          
        return $this->render('view/_registration.html.twig', [
            'inscription' => $userForm->createView()
        ]);
    }
};


?>