<?php

namespace GestionProjetBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use UserBundle\Entity\Utilisateur;
use GestionProjetBundle\Entity\Lot;
use GestionProjetBundle\Entity\Projet;
use GestionProjetBundle\Entity\Adresse;
use GestionProjetBundle\Form\LotType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Description of LotController
 *
 * @author TONYE
 */
class LotController extends Controller {
    
   //put your code here
    /**
	 * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Route("/lots/{id}")
     * @Template()
     */
    public function lotsAction(Projet $projet) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();

        $repositoryLot = $em->getRepository("GestionProjetBundle:Lot");
        $lot = new Lot();
        $form = $this->createForm(new LotType(), $lot);
        $display_tab = 1;
        //selectionne les lots du projet
        $lots = $repositoryLot->findBy(array("statut" => 1, "idprojet" =>$projet ));
        
        return $this->render('GestionProjetBundle:Lot:lot_content.html.twig', array('liste_lots' => $lots, 'projet' => $projet, 'form' => $form->createView(), "display_tab" => $display_tab));
    }
    
    /**
	 * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Route("/add-lot/{id}")
     * @Template()
     */
    public function addLotAction(Projet $projet){
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $lot = new Lot();
        $form = $this->createForm(new LotType(), $lot);
		$request = $this->get("request");
        $form->handleRequest($request);
        $repositoryLot = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Lot");
        //$user = $this->getUser();
       // if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
            //if($request->isMethod('POST')){
                if($form->isValid()){           
                   try {
					   $lot->setIdprojet($projet);
                       $repositoryLot->saveLot($lot);
                       $message = $this->get('translator')->trans('Lot.created_success', array(), "GestionProjetBundle");
                       $request->getSession()->getFlashBag()->add('message', $message);
                       return $this->redirect($this->generateUrl('gp_lot', array('id' => $projet->getId())));
                   } catch (Exception $ex){
                       $message = $this->get('translator')->trans('Lot.created_failure', array(), "GestionProjetBundle");
                       $request->getSession()->getFlashBag()->add('message_success', $message);
                       $lots = array();
                       $display_tab =0;
                       return $this->render('GestionProjetBundle:Lot:lot_content.html.twig', array('liste_lots' => $lots, 'projet' => $projet, 'form' => $form->createView(), "display_tab" => $display_tab));
                   }
               }else{
                   $message = $this->get('translator')->trans('Lot.created_failure', array(), "GestionProjetBundle");
                       $request->getSession()->getFlashBag()->add('message_failure', $message);
                       $lots = array();
                       $display_tab =0;
                       return $this->render('GestionProjetBundle:Lot:lot_content.html.twig', array('liste_lots' => $lots, 'projet' => $projet, 'form' => $form->createView(), "display_tab" => $display_tab));
               }
           // }
        /*}else{
            $message = $message = $this->get('translator')->trans('Lot.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }*/
    }
    
    /**
	 * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Route("/update-lot/{id}")
     * @Template()
     */
    public function updatelotAction(Lot $lot){
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }          
        $repositoryLot = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Lot");
        $form = $this->createForm(new LotType(), $lot); 
        $request = $this->get("request");
        $form->handleRequest($request);
        $user = $this->getUser();
        //if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
            if($request->isMethod('POST')){
                if($form->isValid()){           
                   try {
                       $repositoryLot->updateLot($lot);
                       $message = $this->get('translator')->trans('Lot.updated_success', array(), "GestionProjetBundle");
                       $request->getSession()->getFlashBag()->add('message_success', $message);
                       return $this->redirect($this->generateUrl('gp_lot', array('id' => $projet->getId())));
                   } catch (Exception $ex){
                       $message = $this->get('translator')->trans('Lot.updated_failure', array(), "GestionProjetBundle");
                       $request->getSession()->getFlashBag()->add('message_failure', $message);
                       $lots = array();
                       $display_tab =0;
                       return $this->render('GestionProjetBundle:Lot:lot_content.html.twig', array('liste_lots' => $lots, 'projet' => $lot->getIdprojet(), 'form' => $form->createView(), "display_tab" => $display_tab));
                   }
               }else{
                    $request->getSession()->getFlashBag()->add('message_failure', $message);
                    $lots = array();
                    $display_tab =0;
                    return $this->render('GestionProjetBundle:Lot:lot_content.html.twig', array('liste_lots' => $lots, 'projet' => $lot->getIdprojet(), 'form' => $form->createView(), "display_tab" => $display_tab));
               }
            }
       /* }else{
            $message = $message = $this->get('translator')->trans('Lot.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }*/
    }
    
    /**
	 * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Route("/delete-lot/{id}")
     * @Template()
     */
    public function deletelotAction(Lot $lot) {
        /*if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }*/
        $request = $this->get("request");
       // $user = new Utilisateur();
        $response = new JsonResponse();
        $repositoryLot = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Lot");
        //if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
            if ($request->isMethod('POST')) {
                $user = $this->getUser();
                try{
                    $repositoryLot->deleteLot($lot);
                    $message = $message = $this->get('translator')->trans('Lot.deleted_success', array(), "GestionProjetBundle");
                    $messages = array("letype" => "sucess", "message" => $message);
                    return $response->setData(array("data" => $messages));
                } catch (Exception $ex) {
                    $message = $message = $this->get('translator')->trans('Lot.deleted_failure', array(), "GestionProjetBundle");
                    $messages = array("letype" => "sucess", "message" => $message);
                    return $response->setData(array("data" => $messages));
                }                
            }
       /* }else {
            $message = $message = $this->get('translator')->trans('Lot.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }*/
    }
    
    /**
	 * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Route("/get-lot/{id}")
     * @Template()
     */
    public function getlotAction(Lot $lot) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $request = $this->get("request");
         $form = $this->createForm(new LotType(), $lot);
        $form->handleRequest($request);
 
        return $this->render('GestionProjetBundle:Lot:form.lot.html.twig', array('form' => $form->createView(), "lot" => $lot));
    }
    
    

}
