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
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();
        $repositoryIntervenant = $em->getRepository("GestionProjetBundle:Intervenant");
        $intervenants = $repositoryIntervenant->findBy(array("status" => 1));
        return $this->render('GestionProjetBundle:intervenant:intervenant.html.twig', array('intervenants' => $intervenants));
    }

    /**
     * @Route("/add-intervenant")
     * @Template()
     * @param Request $request
     */
    public function addIntervenantAction(Request $request){
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $intervenant = new Intervenant();
        $form = $this->createForm(new IntervenantType(), $intervenant);
        $form->handleRequest($request);
        $response = new JsonResponse();
        $repositoryIntervenant = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Intervenant");
        $user = $this->getUser();
        if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
            if($request->isMethod('POST')){
                if($form->isValid()){           
                   try {
                       $repositoryIntervenant->saveIntervenant($intervenant);
                       $intervenant = $repositoryIntervenant->findOneBy(array("nom" => $intervenant->getNom(), "idadresse" => $intervenant->getIdadresse()));
                       $message = $this->get('translator')->trans('Intervenant.created_success', array(), "GestionProjetBundle");
                       $messages[] = array("letype" => "success", "message" => $message);
                       $messages[] = array("id" => $intervenant->getId(), "nom" => $intervenant->getNom(), "lot" => $intervenant->getIdlot()->getNom(), "localisation" => $intervenant->getIdadresse()->getIdadresse(), "email" => $intervenant->getIdadresse()->getEmail(), "telephone" => $intervenant->getIdadresse()->getTelephone());
                       return $response->setData(array("data" => $messages));
                       //$request->getSession()->getFlashBag()->add('message', $message);
                      // return $this->redirect($this->generateUrl('gp_intervenants'));
                   } catch (Exception $ex){
                       $message = $this->get('translator')->trans('Intervenant.created_failure', array(), "GestionProjetBundle");
                       //$request->getSession()->getFlashBag()->add('message', $message);
                       $messages[] = array("letype" => "error", "message" => $message);
                       return $response->setData(array("data" => $messages));
                       //return $this->render('GestionProjetBundle:Intervenants:add.html.twig', array('form' => $form->createView()));
                   }
               }else{
                   return $this->render('GestionProjetBundle:Intervenants:add.html.twig', array('form' => $form->createView()));
               }
            }
        }else{
            $message = $message = $this->get('translator')->trans('Intervenant.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }
    }
    
    /**
     * @Route("/update-intervenant/{id}")
     * @Template()
     */
    public function updateIntervenantAction(Intervenant $intervenant){
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $form = $this->createForm(new IntervenantType(), $intervenant);
        $request = $this->get("request");
        $form->handleRequest($request);
        $response = new JsonResponse();
        $repositoryIntervenant = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Intervenant");
        $user = $this->getUser();
        if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
            if($request->isMethod('POST')){
                if($form->isValid()){           
                   try {
                       $repositoryIntervenant->updateIntervenant($intervenant);
                       $message = $this->get('translator')->trans('Intervenant.updated_success', array(), "GestionProjetBundle");
                       $messages[] = array("letype" => "success", "message" => $message);
                       $messages[] = array("id" => $intervenant->getId(), "nom" => $intervenant->getNom(), "lot" => $intervenant->getIdlot()->getNom(), "localisation" => $intervenant->getIdadresse()->getIdadresse(), "email" => $intervenant->getIdadresse()->getEmail(), "telephone" => $intervenant->getIdadresse()->getTelephone());
                       return $response->setData(array("data" => $messages));
                       //$request->getSession()->getFlashBag()->add('message', $message);
                      // return $this->redirect($this->generateUrl('gp_intervenants'));
                   } catch (Exception $ex){
                       $message = $this->get('translator')->trans('Intervenant.updated_failure', array(), "GestionProjetBundle");
                       //$request->getSession()->getFlashBag()->add('message', $message);
                       $messages[] = array("letype" => "error", "message" => $message);
                       return $response->setData(array("data" => $messages));
                       //return $this->render('GestionProjetBundle:Intervenants:add.html.twig', array('form' => $form->createView()));
                   }
               }else{
                   return $this->render('GestionProjetBundle:Intervenants:add.html.twig', array('form' => $form->createView()));
               }
            }
        }else{
            $message = $message = $this->get('translator')->trans('Intervenant.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }
    }
    
    /**
     * @Route("/get-intervenant/{id}")
     * @Template()
     */
    public function getIntervenantAction(Intervenant $intervenant) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        return $this->render('GestionProjetBundle:Intervenants:view.html.twig', array('intervenant' => $intervenant));
    }
    
    /**
     * @Route("/delete-intervenant")
     * @Template()
     */
    public function deleteIntervenantAction(Intervenant $intervenant) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $request = $this->get("request");
        $user = new Utilisateur();
        $response = new JsonResponse();
        $repositoryIntervenant = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Intervenant");
        if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
            if ($request->isMethod('POST')) {
                $user = $this->getUser();
                try{
                    $repositoryIntervenant->deleteIntervenant($intervenant);
                    $message = $message = $this->get('translator')->trans('Intervenant.deleted_success', array(), "GestionProjetBundle");
                    $messages[] = array("letype" => "sucess", "message" => $message);
                    return $response->setData(array("data" => $messages));
                } catch (Exception $ex) {
                    $message = $message = $this->get('translator')->trans('Intervenant.deleted_failure', array(), "GestionProjetBundle");
                    $messages[] = array("letype" => "sucess", "message" => $message);
                    return $response->setData(array("data" => $messages));
                }                
            }
        }else {
            $message = $message = $this->get('translator')->trans('Intervenant.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }
    }
    
    
}
