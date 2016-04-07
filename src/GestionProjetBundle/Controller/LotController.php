<?php
namespace GestionProjetBundle\Controller;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use GestionProjetBundle\Entity\Utilisateur;
use GestionProjetBundle\Entity\Lot;
use GestionProjetBundle\Entity\Projet;
use GestionProjetBundle\Entity\Adresse;
use GestionProjetBundle\Form\LotType;

/**
 * Description of LotController
 *
 * @author TONYE
 */
class LotController extends Controller {

    //put your code here
    /**
     * @Route("/lots")
     * @Template()
     * @param Request $request
     */
    public function lotsAction(Request $request) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();
        $repositoryLot = $em->getRepository("GestionProjetBundle:Lot");
        $lots = $repositoryLot->findBy(array("status" => 1));
        return $this->render('GestionProjetBundle:lot:lot.html.twig', array('lots' => $lots));
    }

    /**
     * @Route("/add-lot")
     * @Template()
     * @param Request $request
     */
    public function addLotAction(Request $request){
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $lot = new Lot();
        $form = $this->createForm(new LotType(), $lot);
        $form->handleRequest($request);
        $response = new JsonResponse();
        $repositoryLot = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Lot");
        $user = $this->getUser();
        if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
            if($request->isMethod('POST')){
                if($form->isValid()){           
                   try {
                       $repositoryLot->saveLot($lot);
                       $lot = $repositoryLot->findOneBy(array("nom" => $lot->getNom(), "idadresse" => $lot->getIdadresse()));
                       $message = $this->get('translator')->trans('Lot.created_success', array(), "GestionProjetBundle");
                       $messages[] = array("letype" => "success", "message" => $message);
                       //$messages[] = array("id" => $lot->getId(), "nom" => $lot->getNom(), "lot" => $lot->getIdlot()->getNom(), "localisation" => $lot->getIdadresse()->getIdadresse(), "email" => $lot->getIdadresse()->getEmail(), "telephone" => $lot->getIdadresse()->getTelephone());
                       return $response->setData(array("data" => $messages));
                       //$request->getSession()->getFlashBag()->add('message', $message);
                      // return $this->redirect($this->generateUrl('gp_lots'));
                   } catch (Exception $ex){
                       $message = $this->get('translator')->trans('Lot.created_failure', array(), "GestionProjetBundle");
                       //$request->getSession()->getFlashBag()->add('message', $message);
                       $messages[] = array("letype" => "error", "message" => $message);
                       return $response->setData(array("data" => $messages));
                       //return $this->render('GestionProjetBundle:Lots:add.html.twig', array('form' => $form->createView()));
                   }
               }else{
                   return $this->render('GestionProjetBundle:Lots:add.html.twig', array('form' => $form->createView()));
               }
            }
        }else{
            $message = $message = $this->get('translator')->trans('Lot.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }
    }
    
    /**
     * @Route("/update-lot/{id}")
     * @Template()
     */
    public function updateLotAction(Lot $lot){
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $form = $this->createForm(new LotType(), $lot);
        $request = $this->get("request");
        $form->handleRequest($request);
        $response = new JsonResponse();
        $repositoryLot = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Lot");
        $user = $this->getUser();
        if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
            if($request->isMethod('POST')){
                if($form->isValid()){           
                   try {
                       $repositoryLot->updateLot($lot);
                       $message = $this->get('translator')->trans('Lot.updated_success', array(), "GestionProjetBundle");
                       $messages[] = array("letype" => "success", "message" => $message);
                       //$messages[] = array("id" => $lot->getId(), "nom" => $lot->getNom(), "lot" => $lot->getIdlot()->getNom(), "localisation" => $lot->getIdadresse()->getIdadresse(), "email" => $lot->getIdadresse()->getEmail(), "telephone" => $lot->getIdadresse()->getTelephone());
                       return $response->setData(array("data" => $messages));
                       //$request->getSession()->getFlashBag()->add('message', $message);
                      // return $this->redirect($this->generateUrl('gp_lots'));
                   } catch (Exception $ex){
                       $message = $this->get('translator')->trans('Lot.updated_failure', array(), "GestionProjetBundle");
                       //$request->getSession()->getFlashBag()->add('message', $message);
                       $messages[] = array("letype" => "error", "message" => $message);
                       return $response->setData(array("data" => $messages));
                       //return $this->render('GestionProjetBundle:Lots:add.html.twig', array('form' => $form->createView()));
                   }
               }else{
                   return $this->render('GestionProjetBundle:Lots:add.html.twig', array('form' => $form->createView()));
               }
            }
        }else{
            $message = $message = $this->get('translator')->trans('Lot.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }
    }
    
    /**
     * @Route("/get-lot/{id}")
     * @Template()
     */
    public function getLotAction(Lot $lot) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        return $this->render('GestionProjetBundle:Lots:view.html.twig', array('lot' => $lot));
    }
    
    /**
     * @Route("/delete-lot")
     * @Template()
     */
    public function deleteLotAction(Lot $lot) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $request = $this->get("request");
        $user = new Utilisateur();
        $response = new JsonResponse();
        $repositoryLot = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Lot");
        if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
            if ($request->isMethod('POST')) {
                $user = $this->getUser();
                try{
                    $repositoryLot->deleteLot($lot);
                    $message = $message = $this->get('translator')->trans('Lot.deleted_success', array(), "GestionProjetBundle");
                    $messages[] = array("letype" => "sucess", "message" => $message);
                    return $response->setData(array("data" => $messages));
                } catch (Exception $ex) {
                    $message = $message = $this->get('translator')->trans('Lot.deleted_failure', array(), "GestionProjetBundle");
                    $messages[] = array("letype" => "sucess", "message" => $message);
                    return $response->setData(array("data" => $messages));
                }                
            }
        }else {
            $message = $message = $this->get('translator')->trans('Lot.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }
    }
}
