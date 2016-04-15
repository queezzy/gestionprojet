<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GestionProjetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use GestionProjetBundle\Entity\Utilisateur;
use GestionProjetBundle\Entity\Intervenant;
use GestionProjetBundle\Entity\Projet;
use GestionProjetBundle\Form\EvolutionIntervenantType;
use GestionProjetBundle\Form\EvolutionProjetType;
/**
 * Description of EvolutionController
 *
 * @author TONYE
 */
class EvolutionController extends Controller{
    //put your code here
    /**
     * @Route("/evolutions")
     * @Template()
     * @param Request $request
     */
    public function evolutionsAction(Request $request) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /*if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }*/
        $em = $this->getDoctrine()->getManager();

        $repositoryIntervenant = $em->getRepository("GestionProjetBundle:Intervenant");
        $repositoryProjet = $em->getRepository("GestionProjetBundle:Projet");
        $display_tab = 1;
        $now= new \DateTime('now');
        //selectionne le seul intervenant actif
        $projet = $repositoryProjet->findBy(array("statut" => 1))[0];
        //$intervenants = $repositoryIntervenant->findBy(array("statut" => 1, "idprojet" => $projet));
        $intervenants = $repositoryIntervenant->findBy(array("statut" => 1));
        
        return $this->render('GestionProjetBundle:Evolution:evolution.template.html.twig', array('liste_intervenants' => $intervenants, 'projet' => $projet, "display_tab" => $display_tab, "now" => $now));
    }
    
    /**
     * @Route("/update-evolution-projet/{id}")
     * @Template()
     */
    public function updateevolution_projetAction(Projet $projet){
        /*if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }*/
        $repositoryProjet = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Projet");
        $form = $this->createForm(new EvolutionProjetType(), $projet); 
        $request = $this->get("request");
        $form->handleRequest($request);
        $user = $this->getUser();
        //if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
            if($request->isMethod('POST')){
                if($form->isValid()){           
                   try {
                       if($projet->getEvolutionattendu()>= $projet->getEvolutionencours()){
                            $repositoryProjet->updateProjet($projet);
                            $message = $this->get('translator')->trans('Projet.updated_success', array(), "GestionProjetBundle");
                            $request->getSession()->getFlashBag()->add('message_success', $message);
                            return $this->redirect($this->generateUrl('gp_evolution'));
                       }else{
                            return $this->redirect($this->generateUrl('gp_evolution'));
                       }
                   } catch (Exception $ex){
                       return $this->redirect($this->generateUrl('gp_evolution'));
                   }
               }else{
                    return $this->redirect($this->generateUrl('gp_evolution'));
               }
            }
       /* }else{
            $message = $message = $this->get('translator')->trans('Projet.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }*/
    }
    
    /**
     * @Route("/update-evolution-intervenant/{id}")
     * @Template()
     */
    public function updateevolution_intervenantAction(Intervenant $intervenant){
        /*if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }*/          
        $repositoryIntervenant = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Intervenant");
        $form = $this->createForm(new EvolutionIntervenantType(), $intervenant); 
        $request = $this->get("request");
        $form->handleRequest($request);
        $user = $this->getUser();
        //if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
            if($request->isMethod('POST')){
                if($form->isValid()){           
                   try {
                       if($intervenant->getEvolutionattendu()>= $intervenant->getEvolutionencours()){
                            $repositoryIntervenant->updateIntervenant($intervenant);
                            $message = $this->get('translator')->trans('Intervenant.updated_success', array(), "GestionProjetBundle");
                            $request->getSession()->getFlashBag()->add('message_success', $message);
                            return $this->redirect($this->generateUrl('gp_evolution'));
                       }else{
                            return $this->redirect($this->generateUrl('gp_evolution'));
                       }
                       
                   } catch (Exception $ex){
                       return $this->redirect($this->generateUrl('gp_evolution'));
                   }
               }else{
                    return $this->redirect($this->generateUrl('gp_evolution'));
               }
            }
       /* }else{
            $message = $message = $this->get('translator')->trans('Intervenant.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }*/
    }
    
    
    /**
     * @Route("/get-evolution-intervenant/{id}")
     * @Template()
     */
    public function getEvolutionintervenantAction(Intervenant $intervenant) {
        /*if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }*/
        $request = $this->get("request");
         $form = $this->createForm(new EvolutionIntervenantType(), $intervenant);
        $form->handleRequest($request);
 
        return $this->render('GestionProjetBundle:Evolution:form.evolution.intervenant.html.twig', array('form' => $form->createView(), "intervenant" => $intervenant));
    }
    
    /**
     * @Route("/get-evolution-projet/{id}")
     * @Template()
     */
    public function getevolutionprojetAction(Projet $projet) {
        /*if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }*/
        $request = $this->get("request");
         $form = $this->createForm(new EvolutionProjetType(), $projet);
        $form->handleRequest($request);
        return $this->render('GestionProjetBundle:Evolution:form.evolution.projet.html.twig', array('form' => $form->createView(), "idprojet" => $projet->getId()));
    }
}
