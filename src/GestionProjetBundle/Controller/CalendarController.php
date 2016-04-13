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
use \GestionProjetBundle\Form\CalendrierType;
use \GestionProjetBundle\Entity\Calendrier;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class CalendarController extends Controller {

    /**
     *
     * @Route("/calendrier", name="projet_calendrier")
     * @Method("GET")
     */
    public function getCalendrier(Request $request){
        
        
        return $this->render('GestionProjetBundle:calendrier:calendrier.template.html.twig');
    }
    
    /**
     *
     * @Route("/calendrier/events", name="projet_calendrier_events")
     * @Method("GET")
     */
    public function getEvents(){
        
//        $deb=$request->get("from")/1000;
//        
//        $fin=$request->get("to")/1000;
//        
        $em = $this->getDoctrine()->getManager();
            $calendrier_repo = $em->getRepository('GestionProjetBundle:Calendrier'); 
            
            try {
                $events=$calendrier_repo->findAll();
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
            $out = array();
            $rsp = new \Symfony\Component\HttpFoundation\JsonResponse();
            
            foreach($events as $row) {
                $out[] = array(
                    'title' => $row->getTitre(),
                    //'url' => Helper::url($row->type),
                    'start' => $row->getDatedebut()->format('c'),
                    'end' => $row->getDatefin()->format('c'),
                    'color' => $row -> getCodecouleur()
                );
            }
            return $rsp->setData($out);
        //return $this->render('GestionProjetBundle:Projet:testcalendrier.html.twig');
    }
    
    /**
     * @Route("/evenement/ajouter", name="gestion_projet_calendrier_new")
      @Method({"GET","POST"})
     */
    public function newEvenementAction(Request $request) {
        $calendrier = new Calendrier();
        $form = $this->createForm(CalendrierType::class, $calendrier);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $actu_repo = $em->getRepository('GestionProjetBundle:Calendrier');

            try {
                
                $actu_repo->saveCalendrier($calendrier);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }

            $request->getSession()->getFlashBag()->add('notice', 'Evenement bien enregistrée.');
            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('GestionProjetBundle:formulaire:form.creation.evenement.html.twig', array(
                    'form' => $form->createView(),
        ));
    }
    
    /**
     * @Route("/evenement/modifier/{id}", name="gestion_projet_evenement_update",requirements={"id" = "\d+"})
     * @Method({"GET","POST"})
     */
    public function updateEvenementAction(Calendier $calendrier) {

        $request = $this->get('request');

        $em = $this->getDoctrine()->getEntityManager();
        $actu_repo = $em->getRepository('GestionProjetBundle:Calendrier');
        $form = $this->createForm(CalendrierType::class, $calendrier);

        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            if ($form->isValid()) {

                try {



                    $actu_repo->updateCalendrier($calendrier);
                } catch (Exception $exc) {
                    echo $exc->getTraceAsString();
                }

                return $this->redirect($this->generateUrl('homepage'));
            }
        }

        return $this->render('GestionProjetBundle:formulaire:form.modification.calendrier.html.twig', array(
                    'form' => $form->createView(), 'idcalendrier' => $actu->getIdcalendrier()
        ));
    }

}
