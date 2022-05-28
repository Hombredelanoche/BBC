<?php

namespace App\Controller;

use App\Entity\Calendar;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/api', name: 'app_api')]
    public function index(): Response
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }

    #[Route('/api/{id}/edit', name: 'app_api_event_edit', methods:"PUT")]
    public function majEvent(?Calendar $calendar, Request $request)
    {
        // récup les données
        $data = json_decode($request->getContent());
        //Vérifier qu'on a toutes les données
        if(
            isset($data->title) && !empty($data->title) &&
            isset($data->start) && !empty($data->start) &&
            isset($data->description) && !empty($data->description) &&
            isset($data->background_color) && !empty($data->background_color) &&
            isset($data->border_color) && !empty($data->border_color) &&
            isset($data->text_color) && !empty($data->text_color)
        ){
            //Les données sont complétes
            //On initialise un code
            $code = 200;

            //On vérifie si l'id existe
            if($calendar){
                //On instancie un rdv
                $calendar = new Calendar;
                // On change le code
                $code = 201;
            }

            //On hydrate l'objet avec les données
            $calendar->setTitle($data->title);
            $calendar->setDescription($data->description);
            $calendar->setStart(new DateTime($data->start));
            $calendar->setBackgroundColor($data->background_color);
            $calendar->setBorderColor($data->border_color);
            $calendar->setTextColor($data->text_color);
            if($data->all_day){
                $calendar->setEnd(new DateTime($data->start));
            }else {
                $calendar->setEnd(new DateTime($data->end));
            }
            $calendar->setAllDay($data->all_day);

           $em = $this->getDoctrine()->getManager();
           $em->persist($calendar);
           $em->flush;
           //On retourne un code
           return new Response('Ok', $code);

        } else {
            // les données sont incomplètes
            return new Response('Données incomplètes', 404);
        }

        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }
}
