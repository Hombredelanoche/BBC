<?php

namespace App\Controller;

use App\Repository\PlanningRepository;
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
    public function actu(): Response {
        return $this->render('view/_actuality.html.twig');
    }

    #[Route('/login', name: 'login')]
    public function log(): Response
    {
        return $this->render('view/_login.html.twig');
    }








}


?>