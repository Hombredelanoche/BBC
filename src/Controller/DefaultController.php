<?php

namespace App\Controller;


use App\Repository\CalendarRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DefaultController extends AbstractController 
{

    #[Route('/', name: 'index' )]
    #[Route('/accueil', name: 'homepage')]
    public function index(): Response {
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
};


?>