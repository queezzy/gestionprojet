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
use GestionProjetBundle\Entity\Utilisateur;
use GestionProjetBundle\Entity\Tache;
use GestionProjetBundle\Form\TacheType;

/**
 * Description of TacheController
 *
 * @author TONYE
 */
class TacheController extends Controller {

    //put your code here
    /**
     * @Route("/taches")
     * @Template()
     * @param Request $request
     */
    public function tachesAction(Request $request) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();
        $repositoryTache = $em->getRepository("GestionProjetBundle:Tache");
        $taches = $repositoryTache->findBy(array("status" => 1));
        return $this->render('GestionProjetBundle:tache:tache.html.twig', array('taches' => $taches));
    }

    /**
     * @Route("/add-tache")
     * @Template()
     * @param Request $request
     */
    public function addTacheAction(Request $request){
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $tache = new Tache();
        $form = $this->createForm(new TacheType(), $tache);
        $form->handleRequest($request);
        $response = new JsonResponse();
        $repositoryTache = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Tache");
        $user = $this->getUser();
        if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
            if($request->isMethod('POST')){
                if($form->isValid()){           
                   try {
                       $repositoryTache->saveTache($tache);
                       $tache = $repositoryTache->findOneBy(array("nom" => $tache->getNom(), "idadresse" => $tache->getIdadresse()));
                       $message = $this->get('translator')->trans('Tache.created_success', array(), "GestionProjetBundle");
                       $messages[] = array("letype" => "success", "message" => $message);
                       //$messages[] = array("id" => $tache->getId(), "nom" => $tache->getNom(), "lot" => $tache->getIdlot()->getNom(), "localisation" => $tache->getIdadresse()->getIdadresse(), "email" => $tache->getIdadresse()->getEmail(), "telephone" => $tache->getIdadresse()->getTelephone());
                       return $response->setData(array("data" => $messages));
                       //$request->getSession()->getFlashBag()->add('message', $message);
                      // return $this->redirect($this->generateUrl('gp_taches'));
                   } catch (Exception $ex){
                       $message = $this->get('translator')->trans('Tache.created_failure', array(), "GestionProjetBundle");
                       //$request->getSession()->getFlashBag()->add('message', $message);
                       $messages[] = array("letype" => "error", "message" => $message);
                       return $response->setData(array("data" => $messages));
                       //return $this->render('GestionProjetBundle:Taches:add.html.twig', array('form' => $form->createView()));
                   }
               }else{
                   return $this->render('GestionProjetBundle:Taches:add.html.twig', array('form' => $form->createView()));
               }
            }
        }else{
            $message = $message = $this->get('translator')->trans('Tache.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }
    }
    
    /**
     * @Route("/update-tache/{id}")
     * @Template()
     */
    public function updateTacheAction(Tache $tache){
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $form = $this->createForm(new TacheType(), $tache);
        $request = $this->get("request");
        $form->handleRequest($request);
        $response = new JsonResponse();
        $repositoryTache = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Tache");
        $user = $this->getUser();
        if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
            if($request->isMethod('POST')){
                if($form->isValid()){           
                   try {
                       $repositoryTache->updateTache($tache);
                       $message = $this->get('translator')->trans('Tache.updated_success', array(), "GestionProjetBundle");
                       $messages[] = array("letype" => "success", "message" => $message);
                       //$messages[] = array("id" => $tache->getId(), "nom" => $tache->getNom(), "lot" => $tache->getIdlot()->getNom(), "localisation" => $tache->getIdadresse()->getIdadresse(), "email" => $tache->getIdadresse()->getEmail(), "telephone" => $tache->getIdadresse()->getTelephone());
                       return $response->setData(array("data" => $messages));
                       //$request->getSession()->getFlashBag()->add('message', $message);
                      // return $this->redirect($this->generateUrl('gp_taches'));
                   } catch (Exception $ex){
                       $message = $this->get('translator')->trans('Tache.updated_failure', array(), "GestionProjetBundle");
                       //$request->getSession()->getFlashBag()->add('message', $message);
                       $messages[] = array("letype" => "error", "message" => $message);
                       return $response->setData(array("data" => $messages));
                       //return $this->render('GestionProjetBundle:Taches:add.html.twig', array('form' => $form->createView()));
                   }
               }else{
                   return $this->render('GestionProjetBundle:Taches:add.html.twig', array('form' => $form->createView()));
               }
            }
        }else{
            $message = $message = $this->get('translator')->trans('Tache.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }
    }
    
    /**
     * @Route("/get-tache/{id}")
     * @Template()
     */
    public function getTacheAction(Tache $tache) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        return $this->render('GestionProjetBundle:Taches:view.html.twig', array('tache' => $tache));
    }
    
    /**
     * @Route("/delete-tache")
     * @Template()
     */
    public function deleteTacheAction(Tache $tache) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $request = $this->get("request");
        $user = new Utilisateur();
        $response = new JsonResponse();
        $repositoryTache = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Tache");
        if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
            if ($request->isMethod('POST')) {
                $user = $this->getUser();
                try{
                    $repositoryTache->deleteTache($tache);
                    $message = $message = $this->get('translator')->trans('Tache.deleted_success', array(), "GestionProjetBundle");
                    $messages[] = array("letype" => "sucess", "message" => $message);
                    return $response->setData(array("data" => $messages));
                } catch (Exception $ex) {
                    $message = $message = $this->get('translator')->trans('Tache.deleted_failure', array(), "GestionProjetBundle");
                    $messages[] = array("letype" => "sucess", "message" => $message);
                    return $response->setData(array("data" => $messages));
                }                
            }
        }else {
            $message = $message = $this->get('translator')->trans('Tache.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }
    }
    
    
}

