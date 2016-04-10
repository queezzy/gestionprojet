<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GestionProjetBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use \GestionProjetBundle\Form\ActualiteType;
use \GestionProjetBundle\Entity\Actualite;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Description of ActualiteController
 *
 * @author Quentin
 */
class ActualiteController extends Controller {

     /**
     * @Route("/actualite/ajouter", name="gestion_projet_actualite_new")
       @Method({"GET","POST"})
     */
    public function newActualiteAction(Request $request)
    {
        $actualite = new Actualite();
        $form = $this->createForm(ActualiteType::class, $actualite);
        $form->handleRequest($request);

        if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();

            $actu_repo = $em->getRepository('GestionProjetBundle:Actualite'); 

            try {
                $actu_repo->saveActualite($actualite);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            } 

            $request->getSession()->getFlashBag()->add('notice', 'Actualite bien enregistrée.');
            return $this->redirect($this->generateUrl('gp_accueil'));
        }
        
        return $this->render('GestionProjetBundle:actualite:actualite.template.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
     /**
     * @Route("/actualite/modifier/{id}", name="gestion_projet_actualite_update",requirements={"id" = "\d+"})
      * @Method({"POST"})
     */
     public function updateActualiteAction(Actualite $actu){
        
    $request = $this->get('request');

    $em = $this->getDoctrine()->getEntityManager();
    $actu_repo = $em->getRepository('GestionProjetBundle:Actualite');
    $form = $this->createForm(new \GestionProjetBundle\Form\ActualiteType(), $actu);

   // if ($request->getMethod() == 'POST') {
        $form->handleRequest($request);

        if ($form->isValid()) {
            
            try {
                $actu_repo->updateActualite($actu);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }

            return $this->redirect($this->generateUrl('MyBundle_list_testimonials'));
        }
   // }

//    return $this->render('MyBundle:Testimonial:update.html.twig', array(
//        'form' => $form->createView()
//    ));
//    
    
            }
    
    /**
     * @Route("/actualites", name="gestion_projet_actualite_all")
      *@Method({"GET"})
     */
    public function getAllActualitesAction(){
        
            return $this->render('GestionProjetBundle:actualite:actualite.template.html.twig');
        }        
    
    public function getActualitesAction($nbre_actualite=0){
        
        if($nbre_actualite == 0){
            
            $em = $this->getDoctrine()->getManager();

            $actu_repo = $em->getRepository('GestionProjetBundle:Actualite');
            
            try {
                $actualites = $actu_repo->findByStatut(1);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }



            return $this->render('GestionProjetBundle:formulaire:liste.actualite.template.html.twig',array("actualites"=>$actualites));
    
            
        }else{
             $em = $this->getDoctrine()->getManager();

            $actu_repo = $em->getRepository('GestionProjetBundle:Actualite');
            
            try {
                $actualites = $actu_repo->findBy(array("statut"=>1),null, $nbre_actualite);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }



            return $this->render('GestionProjetBundle:formulaire:liste.actualite.mini.html.twig',array("actualites"=>$actualites));
    
        } 
    }
    
    
     /**
     * @Route("/actualite/{id}", name="gestion_projet_actualite_unique",requirements={"id" = "\d+"})
      * @Method({"GET"})
     */
    
    public function getOneActualiteAction(Actualite $actualite){
        
        return $this->render('GestionProjetBundle:formulaire:form.affichage.actualite.html.twig',array("actualite"=>$actualite));
    }
    
     /**
     * @Route("/actualite/supprimer", name="gestion_projet_actualite_delete")
      *@Method({"POST"})
     */
    
    public function deleteActualiteAction(Actualite $actualite){
    
        $em = $this->getDoctrine()->getManager();

        $actu_repo = $em->getRepository('GestionProjetBundle:Actualite');
        
        try {
            $actu_repo->deleteActualite($actualite);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
                
    }
}
