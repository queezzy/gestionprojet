<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CalendarController
 *
 * @author Quentin
 */
namespace GestionProjetBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use \GestionProjetBundle\Form\ActualiteType;
use \GestionProjetBundle\Entity\Actualite;


class CalendarController extends Controller {

    /**
     *
     * @Route("/calendrier", name="projet_calendrier")
     * @Method("GET")
     */
    public function getCalendrier(Request $request){
        
        
        return $this->render('GestionProjetBundle:Projet:testcalendrier.html.twig');
    }
    
    /**
     *
     * @Route("/calendrier/events", name="projet_calendrier_events")
     * @Method("GET")
     */
    public function getEvents(Request $request){
        
//        $deb=$request->get("from")/1000;
//        
//        $fin=$request->get("to")/1000;
//        
        $em = $this->getDoctrine()->getManager();

            $calendrier_repo = $em->getRepository('GestionProjetBundle:Calendrier'); 
            
            try {
                $events=$calendrier_repo->getEvent(null,null);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
            
            $out = array();
            $rsp = new \Symfony\Component\HttpFoundation\JsonResponse();
            
            foreach($events as $row) {
                $out[] = array(
                    'id' => $row->idcalendrier,
                    'title' => $row->titre,
                    'url' => Helper::url($row->type),
                    'start' => strtotime($row->datedebut) . '000',
                    'end' => strtotime($row->datefin) .'000'
                );
            }
    return $rsp->setData(array('success' => 1,'result' => $out));
        //return $this->render('GestionProjetBundle:Projet:testcalendrier.html.twig');
    }
    
}
