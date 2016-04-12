<?php

namespace GestionProjetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use GestionProjetBundle\Entity\Tache;
use GestionProjetBundle\Form\TacheType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class TacheController extends Controller 
{
    
    //put your code here
    /**
     * @Route("/taches")
     * @Template()
     * @param Request $request
     */
    public function tachesAction(Request $request) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /*if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }*/
        $em = $this->getDoctrine()->getManager();

        $repositoryTache = $em->getRepository("GestionProjetBundle:Tache");
        $tache = new Tache();
        $form = $this->createForm(new TacheType(), $tache);
        $display_tab = 1;
        //selectionne le seul tache actif
        $taches = $repositoryTache->findBy(array("statut" => 1));
        
        return $this->render('GestionProjetBundle:Tache:tache_content.html.twig', array('liste_taches' => $taches, 'form' => $form->createView(), "display_tab" => $display_tab));
    }
    
    /**
     * @Route("/add-tache")
     * @Template()
     * @param Request $request
     */
    public function addTacheAction(Request $request){
        /*if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }*/
        $tache = new Tache();
        $form = $this->createForm(new TacheType(), $tache);
        $form->handleRequest($request);
        $repositoryTache = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Tache");
        //$user = $this->getUser();
       // if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
            //if($request->isMethod('POST')){
                if($form->isValid()){           
                   try {
                       $repositoryTache->saveTache($tache);
                       $message = $this->get('translator')->trans('Tache.created_success', array(), "GestionProjetBundle");
                       $request->getSession()->getFlashBag()->add('message', $message);
                       return $this->redirect($this->generateUrl('gp_tache'));
                   } catch (Exception $ex){
                       $message = $this->get('translator')->trans('Tache.created_failure', array(), "GestionProjetBundle");
                       $request->getSession()->getFlashBag()->add('message_success', $message);
                       $taches = array();
                       $display_tab =0;
                       return $this->render('GestionProjetBundle:Tache:tache_content.html.twig', array('liste_taches' => $taches, 'form' => $form->createView(), "display_tab" => $display_tab));
                   }
               }else{
                   $message = $this->get('translator')->trans('Tache.created_failure', array(), "GestionProjetBundle");
                       $request->getSession()->getFlashBag()->add('message_failure', $message);
                       $taches = array();
                       $display_tab =0;
                       return $this->render('GestionProjetBundle:Tache:tache_content.html.twig', array('liste_taches' => $taches, 'form' => $form->createView(), "display_tab" => $display_tab));
               }
           // }
        /*}else{
            $message = $message = $this->get('translator')->trans('Tache.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }*/
    }
    
    /**
     * @Route("/update-tache/{id}")
     * @Template()
     */
    public function updatetacheAction(Tache $tache){
        /*if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }*/          
        $repositoryTache = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Tache");
        $form = $this->createForm(new TacheType(), $tache); 
        $request = $this->get("request");
        $form->handleRequest($request);
        $user = $this->getUser();
        //if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
            if($request->isMethod('POST')){
                if($form->isValid()){           
                   try {
                       $repositoryTache->updateTache($tache);
                       $message = $this->get('translator')->trans('Tache.updated_success', array(), "GestionProjetBundle");
                       $request->getSession()->getFlashBag()->add('message_success', $message);
                       return $this->redirect($this->generateUrl('gp_tache'));
                   } catch (Exception $ex){
                       $message = $this->get('translator')->trans('Tache.updated_failure', array(), "GestionProjetBundle");
                       $request->getSession()->getFlashBag()->add('message_failure', $message);
                       $taches = array();
                       $display_tab =0;
                       return $this->render('GestionProjetBundle:Tache:tache_content.html.twig', array('liste_taches' => $taches, 'form' => $form->createView(), "display_tab" => $display_tab));
                   }
               }else{
                    $request->getSession()->getFlashBag()->add('message_failure', $message);
                    $taches = array();
                    $display_tab =0;
                    return $this->render('GestionProjetBundle:Tache:tache_content.html.twig', array('liste_taches' => $taches, 'form' => $form->createView(), "display_tab" => $display_tab));
               }
            }
       /* }else{
            $message = $message = $this->get('translator')->trans('Tache.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }*/
    }
    
    /**
     * @Route("/delete-tache/{id}")
     * @Template()
     */
    public function deletetacheAction(Tache $tache) {
        /*if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }*/
        $request = $this->get("request");
        //$user = new Utilisateur();
        $response = new JsonResponse();
        $repositoryTache = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Tache");
        //if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
            if ($request->isMethod('POST')) {
                $user = $this->getUser();
                try{
                    $repositoryTache->deleteTache($tache);
                    $message = $message = $this->get('translator')->trans('Tache.deleted_success', array(), "GestionProjetBundle");
                    $messages = array("letype" => "sucess", "message" => $message);
                    return $response->setData(array("data" => $messages));
                } catch (Exception $ex) {
                    $message = $message = $this->get('translator')->trans('Tache.deleted_failure', array(), "GestionProjetBundle");
                    $messages = array("letype" => "sucess", "message" => $message);
                    return $response->setData(array("data" => $messages));
                }                
            }
       /* }else {
            $message = $message = $this->get('translator')->trans('Tache.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }*/
    }
    
    /**
     * @Route("/get-tache/{id}")
     * @Template()
     */
    public function gettacheAction(Tache $tache) {
        /*if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }*/
        $request = $this->get("request");
         $form = $this->createForm(new TacheType(), $tache);
        $form->handleRequest($request);
 
        return $this->render('GestionProjetBundle:Tache:form.tache.html.twig', array('form' => $form->createView(), "idtache" => $tache->getId()));
    }
    

}
