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
use GestionProjetBundle\Entity\Courier;
use GestionProjetBundle\Entity\Projet;
use GestionProjetBundle\Entity\Adresse;
use GestionProjetBundle\Form\CourierType;

/**
 * Description of CourierController
 *
 * @author TONYE
 */
class CourrierController extends Controller {

    //put your code here
    /**
     * @Route("/couriers")
     * @Template()
     * @param Request $request
     */
    public function courriersAction(Request $request) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();
        $repositoryCourier = $em->getRepository("GestionProjetBundle:Courier");
        $couriers = $repositoryCourier->findBy(array("status" => 1));
        return $this->render('GestionProjetBundle:courier:courier.html.twig', array('couriers' => $couriers));
    }

    /**
     * @Route("/add-courier")
     * @Template()
     * @param Request $request
     */
    public function addCourrierAction(Request $request){
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $courier = new Courier();
        $form = $this->createForm(new CourierType(), $courier);
        $form->handleRequest($request);
        $response = new JsonResponse();
        $repositoryCourier = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Courier");
        $user = $this->getUser();
        if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
            if($request->isMethod('POST')){
                if($form->isValid()){           
                   try {
                       $repositoryCourier->saveCourier($courier);
                       $courier = $repositoryCourier->findOneBy(array("nom" => $courier->getNom(), "idadresse" => $courier->getIdadresse()));
                       $message = $this->get('translator')->trans('Courier.created_success', array(), "GestionProjetBundle");
                       $messages[] = array("letype" => "success", "message" => $message);
                       //$messages[] = array("id" => $courier->getId(), "nom" => $courier->getNom(), "courier" => $courier->getIdcourier()->getNom(), "localisation" => $courier->getIdadresse()->getIdadresse(), "email" => $courier->getIdadresse()->getEmail(), "telephone" => $courier->getIdadresse()->getTelephone());
                       return $response->setData(array("data" => $messages));
                       //$request->getSession()->getFlashBag()->add('message', $message);
                      // return $this->redirect($this->generateUrl('gp_couriers'));
                   } catch (Exception $ex){
                       $message = $this->get('translator')->trans('Courier.created_failure', array(), "GestionProjetBundle");
                       //$request->getSession()->getFlashBag()->add('message', $message);
                       $messages[] = array("letype" => "error", "message" => $message);
                       return $response->setData(array("data" => $messages));
                       //return $this->render('GestionProjetBundle:Couriers:add.html.twig', array('form' => $form->createView()));
                   }
               }else{
                   return $this->render('GestionProjetBundle:Couriers:add.html.twig', array('form' => $form->createView()));
               }
            }
        }else{
            $message = $message = $this->get('translator')->trans('Courier.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }
    }
    
    /**
     * @Route("/update-courier/{id}")
     * @Template()
     */
    public function updateCourrierAction(Courier $courier){
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $form = $this->createForm(new CourierType(), $courier);
        $request = $this->get("request");
        $form->handleRequest($request);
        $response = new JsonResponse();
        $repositoryCourier = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Courier");
        $user = $this->getUser();
        if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
            if($request->isMethod('POST')){
                if($form->isValid()){           
                   try {
                       $repositoryCourier->updateCourier($courier);
                       $message = $this->get('translator')->trans('Courier.updated_success', array(), "GestionProjetBundle");
                       $messages[] = array("letype" => "success", "message" => $message);
                       //$messages[] = array("id" => $courier->getId(), "nom" => $courier->getNom(), "courier" => $courier->getIdcourier()->getNom(), "localisation" => $courier->getIdadresse()->getIdadresse(), "email" => $courier->getIdadresse()->getEmail(), "telephone" => $courier->getIdadresse()->getTelephone());
                       return $response->setData(array("data" => $messages));
                       //$request->getSession()->getFlashBag()->add('message', $message);
                      // return $this->redirect($this->generateUrl('gp_couriers'));
                   } catch (Exception $ex){
                       $message = $this->get('translator')->trans('Courier.updated_failure', array(), "GestionProjetBundle");
                       //$request->getSession()->getFlashBag()->add('message', $message);
                       $messages[] = array("letype" => "error", "message" => $message);
                       return $response->setData(array("data" => $messages));
                       //return $this->render('GestionProjetBundle:Couriers:add.html.twig', array('form' => $form->createView()));
                   }
               }else{
                   return $this->render('GestionProjetBundle:Couriers:add.html.twig', array('form' => $form->createView()));
               }
            }
        }else{
            $message = $message = $this->get('translator')->trans('Courier.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }
    }
    
    /**
     * @Route("/get-courier/{id}")
     * @Template()
     */
    public function getCourrierAction(Courier $courier) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        return $this->render('GestionProjetBundle:Couriers:view.html.twig', array('courier' => $courier));
    }
    
    /**
     * @Route("/delete-courier")
     * @Template()
     */
    public function deleteCourrierAction(Courier $courier) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $request = $this->get("request");
        $user = new Utilisateur();
        $response = new JsonResponse();
        $repositoryCourier = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Courier");
        if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
            if ($request->isMethod('POST')) {
                $user = $this->getUser();
                try{
                    $repositoryCourier->deleteCourier($courier);
                    $message = $message = $this->get('translator')->trans('Courier.deleted_success', array(), "GestionProjetBundle");
                    $messages[] = array("letype" => "sucess", "message" => $message);
                    return $response->setData(array("data" => $messages));
                } catch (Exception $ex) {
                    $message = $message = $this->get('translator')->trans('Courier.deleted_failure', array(), "GestionProjetBundle");
                    $messages[] = array("letype" => "sucess", "message" => $message);
                    return $response->setData(array("data" => $messages));
                }                
            }
        }else {
            $message = $message = $this->get('translator')->trans('Courier.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }
    }
}