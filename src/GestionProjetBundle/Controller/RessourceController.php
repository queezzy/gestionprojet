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

use GestionProjetBundle\Form\RessourceType;
use GestionProjetBundle\Entity\Ressource;
/**
 * Description of RessourceControlle
 *
 * @author Quentin
 */
class RessourceController extends Controller {
   
    
    /**
     * @Route("/ressource/ajouter", name="gestion_projet_ressource_new")
       @Method({"GET","POST"})
     */
    public function newRessourceAction(Request $request)
    {
        $ressource = new Ressource();
        $form = $this->createForm(RessourceType::class, $ressource);
        $form->handleRequest($request);

        if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();

            $ressource_repo = $em->getRepository('GestionProjetBundle:Ressource'); 
            
            try {
                $ressource_repo->saveRessource($ressource);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            } 

            $request->getSession()->getFlashBag()->add('notice', 'Actualite bien enregistrée.');
            return ;
        }
        
        return render();
    }
    
    /**
     * @Route("/ressource/modifier/{id}", name="gestion_projet_ressource_update",requirements={"id" = "\d+"})
      * @Method({"POST"})
     */
     public function updateActualiteAction(Ressource $ressource){
        
    $request = $this->get('request');

    $em = $this->getDoctrine()->getEntityManager();
    $ressource_repo = $em->getRepository('GestionProjetBundle:Ressource');
    $form = $this->createForm(new \GestionProjetBundle\Form\RessourceType, $ressource);

   // if ($request->getMethod() == 'POST') {
        $form->handleRequest($request);

        if ($form->isValid()) {
            
            try {
                $ressource_repo->updateActualite($ressource);
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
     * @Route("/ressource/tout", name="gestion_projet_ressource_all")
      *@Method({"GET"})
     */
    public function getAllRessourcesAction(){
        
            $em = $this->getDoctrine()->getManager();

            $ressources_repo = $em->getRepository('GestionProjetBundle:Ressource');
            
            $ressources=$ressources_repo->findAll();
            
            
            render();
    }
    
    /**
     * @Route("/ressource/execution", name="gestion_projet_ressource_execution")
      *@Method({"GET"})
     */
    public function getRessourcesExecutionAction(Request $request){
        
            $em = $this->getDoctrine()->getManager();

            $ressources_repo = $em->getRepository('GestionProjetBundle:Ressource');
            
            $ressources=$ressources_repo->findByStatus(0);
            
            render();
    }
    
    /**
     * @Route("/ressource/valides", name="gestion_projet_ressource_valides")
      *@Method({"GET"})
     */
    public function getRessourcesValidesAction(Request $request){
        
            $em = $this->getDoctrine()->getManager();

            $ressources_repo = $em->getRepository('GestionProjetBundle:Ressource');
            
            $ressources=$ressources_repo->findByStatus(1);
            
            render();
    }
    /**
     * @Route("/ressource/nonvalides", name="gestion_projet_ressource_nonvalides")
      *@Method({"GET"})
     */
    public function getRessourcesNonValidesAction(Request $request){
        
            $em = $this->getDoctrine()->getManager();

            $ressources_repo = $em->getRepository('GestionProjetBundle:Ressource');
            
            $ressources=$ressources_repo->findByStatus(0);
            
            render();
    }
    
    /**
     * @Route("/ressource/ref={reference}", name="gestion_projet_ressource_reference")
      *@Method({"GET"})
     */
    public function getRessourcesByReferenceAction(Request $request,$reference){
        
            $em = $this->getDoctrine()->getManager();

            $ressources_repo = $em->getRepository('GestionProjetBundle:Ressource');
            
            $ressources=$ressources_repo->findByReference($reference);
            
            render();
    }
    
    /**
     * @Route("/ressource/{id}", name="gestion_projet_ressource_unique",requirements={"id" = "\d+"})
      * @Method({"GET"})
     */
    
    public function getOneRessourceAction(Ressource $ressource){
        
        render();
    }
    
     /**
     * @Route("/ressource/supprimer/{id}", name="gestion_projet_actualite_delete",requirements={"id" = "\d+"})
      *@Method({"POST"})
     */
    
    
    public function deleteRessourceAction(Ressource $ressource){
    
        $em = $this->getDoctrine()->getManager();

        $ressource_repo = $em->getRepository('GestionProjetBundle:Ressource');
        
        try {
            $ressource_repo->deleteRessource($ressource);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
                
    }
}
