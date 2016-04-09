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
    public function getCalendrier(){
        
        return $this->render('GestionProjetBundle:Projet:testcalendrier.html.twig');
    }
    
}
