<?php

namespace GestionProjetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use GestionProjetBundle\Entity\Projet;
use GestionProjetBundle\Form\ProjetType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ProjetController extends Controller 
{
    
    /**
	 * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Route("/projets-admin")
     * @Template()
     * @param Request $request
     */
    public function projetAction(Request $request) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /*if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }*/
        $em = $this->getDoctrine()->getManager();

        $repositoryProjet = $em->getRepository("GestionProjetBundle:Projet");
        $projet = new Projet();
        $form = $this->createForm(new ProjetType(), $projet);
        $display_tab = 1;
        //selectionne les seuls projets actif
        $projets = $repositoryProjet->findBy(array("statut" => 1));
        
        return $this->render('GestionProjetBundle:Projet:projet_content.html.twig', array('liste_projets' => $projets, 'form' => $form->createView(), "display_tab" => $display_tab));
    }
    
    
    public function headerprojetactifAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $repositoryProjet = $em->getRepository("GestionProjetBundle:Projet");
        //selectionne le seul projet actif
        $projets = $repositoryProjet->findBy(array("statut" => 1));
        if($projets){
            $projet = $repositoryProjet->findBy(array("statut" => 1))[0];
        }else{
            $projet = null;
        }
        
        return $this->render('::header.template.html.twig', array('projetactif' => $projet));

    }
	
	public function menusgaleriephotosAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $repositoryProjet = $em->getRepository("GestionProjetBundle:Projet");
        //selectionne le seul projet actif
        $projets = $repositoryProjet->findBy(array("statut" => 1));
        if($projets){
            $projet = $repositoryProjet->findBy(array("statut" => 1))[0];
        }else{
            $projet = null;
        }
        
        return $this->render('GestionProjetBundle::menusgaleriephotos.template.html.twig', array('projet' => $projet));

    }
	public function sousmenugestionphotoAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $repositoryProjet = $em->getRepository("GestionProjetBundle:Projet");
        //selectionne le seul projet actif
        $projets = $repositoryProjet->findBy(array("statut" => 1));
        if($projets){
            $projet = $repositoryProjet->findBy(array("statut" => 1))[0];
        }else{
            $projet = null;
        }
        
        return $this->render('GestionProjetBundle::sousmenugestionphoto.template.html.twig', array('projet' => $projet));

    }
    
    /**
     * @Route("/get-presentation-projet-accueil")
     * @Template()
     * @param Request $request
     */
    public function getPresentationProjetAccueilAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $repositoryProjet = $em->getRepository("GestionProjetBundle:Projet");
        //selectionne le seul projet actif
        $projet = $repositoryProjet->findBy(array("statut" => 1))[0];
        
        return $this->render('GestionProjetBundle:accueil:accueil.presentation.projet.html.twig', array('projetactif' => $projet));

    }
	
	/**
     * @Route("/get-evolution-projet-accueil")
     * @Template()
     * @param Request $request
     */
    public function getEvolutionProjetAccueilAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $repositoryProjet = $em->getRepository("GestionProjetBundle:Projet");
        //selectionne le seul projet actif
        $projet = $repositoryProjet->findBy(array("statut" => 1))[0];
        return $this->render('GestionProjetBundle:accueil:accueil.evolution.projet.html.twig', array('projet' => $projet));

    }
    
    /**
	 * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Route("/add-projet")
     * @Template()
     * @param Request $request
     */
    public function addProjetAction(Request $request){
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $projet = new Projet();
        $form = $this->createForm(new ProjetType(), $projet);
        $form->handleRequest($request);
        $repositoryProjet = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Projet");
        //$user = $this->getUser();
       // if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
            //if($request->isMethod('POST')){
                if($form->isValid()){           
                   try {
                       if($projet->getEvolutionattendu()>= $projet->getEvolutionencours()){
                            $repositoryProjet->saveProjet($projet);
                            $message = $this->get('translator')->trans('Projet.created_success', array(), "GestionProjetBundle");
                            $request->getSession()->getFlashBag()->add('message', $message);
                            return $this->redirect($this->generateUrl('gp_projet_admin'));
                       }else{
                            $message = $this->get('translator')->trans('Projet.created_failure', array(), "GestionProjetBundle");
                            $request->getSession()->getFlashBag()->add('message_success', $message);
                            $projets = array();
                            $display_tab =0;
                       return $this->render('GestionProjetBundle:Projet:projet_content.html.twig', array('liste_projets' => $projets, 'form' => $form->createView(), "display_tab" => $display_tab));
                       }
                   } catch (Exception $ex){
                       $message = $this->get('translator')->trans('Projet.created_failure', array(), "GestionProjetBundle");
                       $request->getSession()->getFlashBag()->add('message_success', $message);
                       $projets = array();
                       $display_tab =0;
                       return $this->render('GestionProjetBundle:Projet:projet_content.html.twig', array('liste_projets' => $projets, 'form' => $form->createView(), "display_tab" => $display_tab));
                   }
               }else{
                   $message = $this->get('translator')->trans('Projet.created_failure', array(), "GestionProjetBundle");
                       $request->getSession()->getFlashBag()->add('message_failure', $message);
                       $projets = array();
                       $display_tab =0;
                       return $this->render('GestionProjetBundle:Projet:projet_content.html.twig', array('liste_projets' => $projets, 'form' => $form->createView(), "display_tab" => $display_tab));
               }
           // }
        /*}else{
            $message = $message = $this->get('translator')->trans('Projet.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }*/
    }
    
    /**
	 * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Route("/update-projet/{id}")
     * @Template()
     */
    public function updateprojetAction(Projet $projet){
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $repositoryProjet = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Projet");
        $form = $this->createForm(new ProjetType(), $projet); 
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
                            return $this->redirect($this->generateUrl('gp_projet_admin'));
                       }else{ 
                            $message = $this->get('translator')->trans('Projet.updated_failure', array(), "GestionProjetBundle");
                            $request->getSession()->getFlashBag()->add('message_failure', $message);
                            $projets = array();
                            $display_tab =0;
                            return $this->render('GestionProjetBundle:Projet:projet_content.html.twig', array('liste_projets' => $projets, 'form' => $form->createView(), "display_tab" => $display_tab));
                        }
                   } catch (Exception $ex){
                       $message = $this->get('translator')->trans('Projet.updated_failure', array(), "GestionProjetBundle");
                       $request->getSession()->getFlashBag()->add('message_failure', $message);
                       $projets = array();
                       $display_tab =0;
                       return $this->render('GestionProjetBundle:Projet:projet_content.html.twig', array('liste_projets' => $projets, 'form' => $form->createView(), "display_tab" => $display_tab));
                   }
               }else{
                    $request->getSession()->getFlashBag()->add('message_failure', $message);
                    $projets = array();
                    $display_tab =0;
                    return $this->render('GestionProjetBundle:Projet:projet_content.html.twig', array('liste_projets' => $projets, 'form' => $form->createView(), "display_tab" => $display_tab));
               }
            }
       /* }else{
            $message = $message = $this->get('translator')->trans('Projet.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }*/
    }
    
    /**
	 * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Route("/delete-projet/{id}")
     * @Template()
     */
    public function deleteprojetAction(Projet $projet) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $request = $this->get("request");
        //$user = new Utilisateur();
        $response = new JsonResponse();
        $repositoryProjet = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Projet");
        //if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
            if ($request->isMethod('POST')) {
                $user = $this->getUser();
                try{
                    $repositoryProjet->deleteProjet($projet);
                    $message = $message = $this->get('translator')->trans('Projet.deleted_success', array(), "GestionProjetBundle");
                    $messages = array("letype" => "sucess", "message" => $message);
                    return $response->setData(array("data" => $messages));
                } catch (Exception $ex) {
                    $message = $message = $this->get('translator')->trans('Projet.deleted_failure', array(), "GestionProjetBundle");
                    $messages = array("letype" => "sucess", "message" => $message);
                    return $response->setData(array("data" => $messages));
                }                
            }
       /* }else {
            $message = $message = $this->get('translator')->trans('Projet.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }*/
    }
    
    /**
	 * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Route("/get-projet/{id}")
     * @Template()
     */
    public function getprojetAction(Projet $projet) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        //$repositoryProjet = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Projet");
        //$idprojet = htmlspecialchars(trim($id));
        //$projet = $repositoryProjet->find($idprojet);
        $request = $this->get("request");
         $form = $this->createForm(new ProjetType(), $projet);
        $form->handleRequest($request);
        return $this->render('GestionProjetBundle:Projet:form.projet.html.twig', array('form' => $form->createView(), "idprojet" => $projet->getId()));
    }
    

}
