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



class ProjetController extends Controller 
{
    /**
     * @Route("/")
     * @Template()
     * @param Request $request
     */
    public function indexAction(Request $request) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();

        $repositoryProjet = $em->getRepository("GestionProjetBundle:Projet");
        /*//$repositoryCalendrier = $em->getRepository("GestionProjetBundle:Calendrier");
        $repositoryAcualite = $em->getRepository("GestionProjetBundle:Actualite");
        $intervenant = array();
        $calendriers = array();
        $actualites = array();*/
        //selectionne le seul projet actif
        $projet = $repositoryProjet->findByOne(array("status" => 1));
        /*if($projet){
            //intervenants du projet
            $interventions = $projet->getIntervenants();
            //les calendriers du projet
            $calendriers = $projet->getCalendriers();
            //les 10 actualités les plus recentes du projet
            $actualites = $repositoryAcualite->findRecentsActualites($projet);
        }*/
        
        return $this->render('GestionProjetBundle:Projets:projet.html.twig', array('projet' => $projet));
    }
    
    /**
     * @Route("/accueil")
     * @Template()
     * @param Request $request
     */
    public function projetAction(Request $request) {
        $this->indexAction($request);
    }
    
    /**
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
        $response = new JsonResponse();
        $repositoryProjet = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Projet");
        $user = $this->getUser();
        if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
            if($request->isMethod('POST')){
                if($form->isValid()){           
                   try {
                       $repositoryProjet->saveProjet($projet);
                       $message = $this->get('translator')->trans('Projet.created_success', array(), "GestionProjetBundle");
                       $messages[] = array("letype" => "success", "message" => $message);
                       $messages[] = array("id" => $projet->getId(), "nom" => $projet->getNom(), "lot" => $projet->getIdlot()->getNom(), "localisation" => $projet->getIdadresse()->getIdadresse(), "email" => $projet->getIdadresse()->getEmail(), "telephone" => $projet->getIdadresse()->getTelephone());
                       return $response->setData(array("data" => $messages));
                       //$request->getSession()->getFlashBag()->add('message', $message);
                      // return $this->redirect($this->generateUrl('gp_projets'));
                   } catch (Exception $ex){
                       $message = $this->get('translator')->trans('Projet.created_failure', array(), "GestionProjetBundle");
                       //$request->getSession()->getFlashBag()->add('message', $message);
                       $messages[] = array("letype" => "error", "message" => $message);
                       return $response->setData(array("data" => $messages));
                       //return $this->render('GestionProjetBundle:Projets:add.html.twig', array('form' => $form->createView()));
                   }
               }else{
                   return $this->render('GestionProjetBundle:Projets:add.html.twig', array('form' => $form->createView()));
               }
            }
        }else{
            $message = $message = $this->get('translator')->trans('Projet.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }
    }
    
    /**
     * @Route("/update-projet/{id}")
     * @Template()
     */
    public function updateProjetAction(Projet $projet){
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $form = $this->createForm(new ProjetType(), $projet);
        $request = $this->get("request");
        $form->handleRequest($request);
        $response = new JsonResponse();
        $repositoryProjet = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Projet");
        $user = $this->getUser();
        if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
            if($request->isMethod('POST')){
                if($form->isValid()){           
                   try {
                       $repositoryProjet->updateProjet($projet);
                       
                       $message = $this->get('translator')->trans('Projet.updated_success', array(), "GestionProjetBundle");
                       $messages[] = array("letype" => "success", "message" => $message);
                       
                       return $response->setData(array("data" => $messages));
                       //$request->getSession()->getFlashBag()->add('message', $message);
                      // return $this->redirect($this->generateUrl('gp_projets'));
                   } catch (Exception $ex){
                       $message = $this->get('translator')->trans('Projet.updated_failure', array(), "GestionProjetBundle");
                       //$request->getSession()->getFlashBag()->add('message', $message);
                       $messages[] = array("letype" => "error", "message" => $message);
                       return $response->setData(array("data" => $messages));
                       //return $this->render('GestionProjetBundle:Projets:add.html.twig', array('form' => $form->createView()));
                   }
               }else{
                   return $this->render('GestionProjetBundle:Projets:add.html.twig', array('form' => $form->createView()));
               }
            }
        }else{
            $message = $message = $this->get('translator')->trans('Projet.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }
    }
    
    /**
     * @Route("/delete-projet")
     * @Template()
     */
    public function deleteProjetAction(Projet $projet) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $request = $this->get("request");
        $user = new Utilisateur();
        $response = new JsonResponse();
        $repositoryProjet = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Projet");
        if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
            if ($request->isMethod('POST')) {
                $user = $this->getUser();
                try{
                    $repositoryProjet->deleteProjet($projet);
                    $message = $message = $this->get('translator')->trans('Projet.deleted_success', array(), "GestionProjetBundle");
                    $messages[] = array("letype" => "sucess", "message" => $message);
                    return $response->setData(array("data" => $messages));
                } catch (Exception $ex) {
                    $message = $message = $this->get('translator')->trans('Projet.deleted_failure', array(), "GestionProjetBundle");
                    $messages[] = array("letype" => "sucess", "message" => $message);
                    return $response->setData(array("data" => $messages));
                }                
            }
        }else {
            $message = $message = $this->get('translator')->trans('Projet.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }
    }
    
    /**
     * @Route("/get-projet/{id}")
     * @Template()
     */
    public function getProjetAction(Projet $projet) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        return $this->render('GestionProjetBundle:Projets:view.html.twig', array('projet' => $projet));
    }
    

}
