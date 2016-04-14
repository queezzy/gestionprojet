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
use UserBundle\Entity\Utilisateur;
use GestionProjetBundle\Entity\Intervenant;
use GestionProjetBundle\Entity\Projet;
use GestionProjetBundle\Entity\Lot;
use GestionProjetBundle\Entity\Adresse;
use GestionProjetBundle\Form\IntervenantType;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Description of IntervenantController
 *
 * @author TONYE
 */
class IntervenantController extends Controller {

    //put your code here
    /**
     * @Route("/intervenants")
     * @Template()
     * @param Request $request
     */
    public function intervenantsAction(Request $request) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /*if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }*/
        $em = $this->getDoctrine()->getManager();

        $repositoryIntervenant = $em->getRepository("GestionProjetBundle:Intervenant");
        $intervenant = new Intervenant();
        $form = $this->createForm(new IntervenantType(), $intervenant);
        $display_tab = 1;
        //selectionne le seul intervenant actif
        $intervenants = $repositoryIntervenant->findBy(array("statut" => 1));
        
        return $this->render('GestionProjetBundle:Intervenant:intervenants.template.html.twig', array('liste_intervenants' => $intervenants, 'form' => $form->createView(), "display_tab" => $display_tab));
    }
    
    /**
     * @Route("/add-intervenant")
     * @Template()
     * @param Request $request
     */
    public function addIntervenantAction(Request $request){
        /*if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }*/
        $intervenant = new Intervenant();
        $form = $this->createForm(new IntervenantType(), $intervenant);
        $form->handleRequest($request);
        $repositoryIntervenant = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Intervenant");
        //$user = $this->getUser();
       // if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
            //if($request->isMethod('POST')){
                if($form->isValid()){           
                   try {
                       $repositoryIntervenant->saveIntervenant($intervenant);
                       $message = $this->get('translator')->trans('Intervenant.created_success', array(), "GestionProjetBundle");
                       $request->getSession()->getFlashBag()->add('message', $message);
                       return $this->redirect($this->generateUrl('gp_intervenant'));
                   } catch (Exception $ex){
                       $message = $this->get('translator')->trans('Intervenant.created_failure', array(), "GestionProjetBundle");
                       $request->getSession()->getFlashBag()->add('message_success', $message);
                       $intervenants = array();
                       $display_tab =0;
                       return $this->render('GestionProjetBundle:Intervenant:intervenants.template.html.twig', array('liste_intervenants' => $intervenants, 'form' => $form->createView(), "display_tab" => $display_tab));
                   }
               }else{
                   $message = $this->get('translator')->trans('Intervenant.created_failure', array(), "GestionProjetBundle");
                       $request->getSession()->getFlashBag()->add('message_failure', $message);
                       $intervenants = array();
                       $display_tab =0;
                       return $this->render('GestionProjetBundle:Intervenant:intervenants.template.html.twig', array('liste_intervenants' => $intervenants, 'form' => $form->createView(), "display_tab" => $display_tab));
               }
           // }
        /*}else{
            $message = $message = $this->get('translator')->trans('Intervenant.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }*/
    }
    
    /**
     * @Route("/update-intervenant/{id}")
     * @Template()
     */
    public function updateintervenantAction(Intervenant $intervenant){
        /*if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }*/          
        $repositoryIntervenant = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Intervenant");
        $form = $this->createForm(new IntervenantType(), $intervenant); 
        $request = $this->get("request");
        $form->handleRequest($request);
        $user = $this->getUser();
        //if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
            if($request->isMethod('POST')){
                if($form->isValid()){           
                   try {
                       $repositoryIntervenant->updateIntervenant($intervenant);
                       $message = $this->get('translator')->trans('Intervenant.updated_success', array(), "GestionProjetBundle");
                       $request->getSession()->getFlashBag()->add('message_success', $message);
                       return $this->redirect($this->generateUrl('gp_intervenant'));
                   } catch (Exception $ex){
                       $message = $this->get('translator')->trans('Intervenant.updated_failure', array(), "GestionProjetBundle");
                       $request->getSession()->getFlashBag()->add('message_failure', $message);
                       $intervenants = array();
                       $display_tab =0;
                       return $this->render('GestionProjetBundle:Intervenant:intervenants.template.html.twig', array('liste_intervenants' => $intervenants, 'form' => $form->createView(), "display_tab" => $display_tab));
                   }
               }else{
                    $request->getSession()->getFlashBag()->add('message_failure', $message);
                    $intervenants = array();
                    $display_tab =0;
                    return $this->render('GestionProjetBundle:Intervenant:intervenants.template.html.twig', array('liste_intervenants' => $intervenants, 'form' => $form->createView(), "display_tab" => $display_tab));
               }
            }
       /* }else{
            $message = $message = $this->get('translator')->trans('Intervenant.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }*/
    }
    
    /**
     * @Route("/delete-intervenant/{id}")
     * @Template()
     */
    public function deleteintervenantAction(Intervenant $intervenant) {
        /*if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }*/
        $request = $this->get("request");
       // $user = new Utilisateur();
        $response = new JsonResponse();
        $repositoryIntervenant = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Intervenant");
        //if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
            if ($request->isMethod('POST')) {
                $user = $this->getUser();
                try{
                    $repositoryIntervenant->deleteIntervenant($intervenant);
                    $message = $message = $this->get('translator')->trans('Intervenant.deleted_success', array(), "GestionProjetBundle");
                    $messages = array("letype" => "sucess", "message" => $message);
                    return $response->setData(array("data" => $messages));
                } catch (Exception $ex) {
                    $message = $message = $this->get('translator')->trans('Intervenant.deleted_failure', array(), "GestionProjetBundle");
                    $messages = array("letype" => "sucess", "message" => $message);
                    return $response->setData(array("data" => $messages));
                }                
            }
       /* }else {
            $message = $message = $this->get('translator')->trans('Intervenant.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }*/
    }
    
    /**
     * @Route("/get-intervenant/{id}")
     * @Template()
     */
    public function getintervenantAction(Intervenant $intervenant) {
        /*if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }*/
        $request = $this->get("request");
         $form = $this->createForm(new IntervenantType(), $intervenant);
        $form->handleRequest($request);
 
        return $this->render('GestionProjetBundle:Intervenant:form.intervenant.html.twig', array('form' => $form->createView(), "idintervenant" => $intervenant->getId()));
    }
    
    
    /**
     * @Route("/get-details-intervenant/{id}")
     * @Template()
     */
    public function getdetailsintervenantAction(Intervenant $intervenant) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /*if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }*/
        //selectionne le personnel clé
        $user = new Utilisateur();
        $personnelcle = array();
        $utilisateurs = $intervenant->getUtilisateurs();
        foreach ($utilisateurs as $user) {
            if($user->getPersonnelcle()== 1){
                $personnelcle[]= $user;
            }
        }
        return $this->render('GestionProjetBundle:Intervenant:intervenant.presentation.template.html.twig', array('intervenant' => $intervenant, "personnelcle" => $personnelcle));
    }
    
}
