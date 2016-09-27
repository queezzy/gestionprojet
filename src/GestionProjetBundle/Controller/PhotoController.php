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
use GestionProjetBundle\Entity\Photo;
use GestionProjetBundle\Entity\Projet;
use GestionProjetBundle\Entity\Adresse;
use GestionProjetBundle\Form\PhotoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Description of PhotoController
 *
 * @author TONYE
 */
class PhotoController extends Controller {
    
   //put your code here
    /**
	 * @Security("has_role('ROLE_ADMIN_ACTIF')")
     * @Route("/photos/{id}")
     * @Template()
     * @param Request $request
     */
    public function photosAction(Projet $projet) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();

        $repositoryPhoto = $em->getRepository("GestionProjetBundle:Photo");
        $photo = new Photo();
        $form = $this->createForm(new PhotoType(), $photo);
        $display_tab = 1;
        //selectionne le seul photo actif
        $photos = $projet->getPhotos();
        
        return $this->render('GestionProjetBundle:Photo:photo_content.html.twig', array('liste_photos' => $photos, 'form' => $form->createView(), "display_tab" => $display_tab, "projet" =>$projet ));
    }
	
	/**
     * @Route("/galerie-photos")
     * @Template()
     * @param Request $request
     */
    public function galeriephotosAction(Request $request) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();

        $repositoryPhoto = $em->getRepository("GestionProjetBundle:Photo");
        $photo = new Photo();
        $form = $this->createForm(new PhotoType(), $photo);
        $display_tab = 1;
        //selectionne le seul photo actif
        //$annees = $repositoryPhoto->getAnneesPhotos($projet->getId());
		$annees = array();
		$session = $this->get("session");
		$projet = $session->get('projetactif');
		$photos = $projet->getPhotos();
		foreach($photos as $photo){
			$mydate = date_format($photo->getDateprise(), 'Y');
			if(!in_array($mydate, $annees)) array_push($annees, $mydate);
		}
        
        return $this->render('GestionProjetBundle:Photo:galerie_photo_content.html.twig', array('projet' => $projet, 'annees' => $annees));
    }
	
	public function listephotosAction($idprojet) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();

        $repositoryPhoto = $em->getRepository("GestionProjetBundle:Photo");
		$repositoryProjet = $em->getRepository("GestionProjetBundle:Projet");
        
        //$photos = $repositoryPhoto->getPhotoAnnuels($idprojet, $annee);
		$projet = $repositoryProjet->find($idprojet);
		$photos = $repositoryPhoto->findBy(array("statut" => 1, "idprojet" =>$projet ));
        
        return $this->render('GestionProjetBundle:Photo:liste_photo_content.html.twig', array('photos' => $photos));
    }
    
    /**
	 * @Security("has_role('ROLE_ADMIN_ACTIF')")
     * @Route("/add-photo/{id}")
     * @Template()
     * @param Request $request
     */
    public function addPhotoAction(Projet $projet){
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $photo = new Photo();
        $form = $this->createForm(new PhotoType(), $photo);
		$request = $this->get("request");
        $form->handleRequest($request);
        $repositoryPhoto = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Photo");
        //$user = $this->getUser();
       // if ($this->get('gp_bundle.service.role')->isGranted('ROLE_ADMIN_ACTIF', $user)) {
            //if($request->isMethod('POST')){
                if($form->isValid()){           
                   try {
					   $photo->setIdprojet($projet);
                       $repositoryPhoto->savePhoto($photo);
                       $message = $this->get('translator')->trans('Photo.created_success', array(), "GestionProjetBundle");
                       $request->getSession()->getFlashBag()->add('message', $message);
                       return $this->redirect($this->generateUrl('gp_photo', array('id'=> $projet->getId())));
                   } catch (Exception $ex){
                       $message = $this->get('translator')->trans('Photo.created_failure', array(), "GestionProjetBundle");
                       $request->getSession()->getFlashBag()->add('message_success', $message);
                       $photos = array();
                       $display_tab =0;
                       return $this->render('GestionProjetBundle:Photo:photo_content.html.twig', array('liste_photos' => $photos, 'form' => $form->createView(), "display_tab" => $display_tab, "projet" =>$projet));
                   }
               }else{
                   $message = $this->get('translator')->trans('Photo.created_failure', array(), "GestionProjetBundle");
                       $request->getSession()->getFlashBag()->add('message_failure', $message);
                       $photos = array();
                       $display_tab =0;
                       return $this->render('GestionProjetBundle:Photo:photo_content.html.twig', array('liste_photos' => $photos, 'form' => $form->createView(), "display_tab" => $display_tab, "projet" =>$projet));
               }
           // }
        /*}else{
            $message = $message = $this->get('translator')->trans('Photo.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }*/
    }
    
    /**
	 * @Security("has_role('ROLE_ADMIN_ACTIF')")
     * @Route("/update-photo/{id}")
     * @Template()
     */
    public function updatephotoAction(Photo $photo){
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }          
        $repositoryPhoto = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Photo");
        $form = $this->createForm(new PhotoType(), $photo); 
        $request = $this->get("request");
        $form->handleRequest($request);
        $user = $this->getUser();
		$projet = $photo->getIdprojet();
        //if ($this->get('gp_bundle.service.role')->isGranted('ROLE_ADMIN_ACTIF', $user)) {
            if($request->isMethod('POST')){
                if($form->isValid()){           
                   try {
                       $repositoryPhoto->updatePhoto($photo);
                       $message = $this->get('translator')->trans('Photo.updated_success', array(), "GestionProjetBundle");
                       $request->getSession()->getFlashBag()->add('message_success', $message);
                       return $this->redirect($this->generateUrl('gp_photo', array('id' => $projet->getId())));
                   } catch (Exception $ex){
                       $message = $this->get('translator')->trans('Photo.updated_failure', array(), "GestionProjetBundle");
                       $request->getSession()->getFlashBag()->add('message_failure', $message);
                       $photos = array();
                       $display_tab =0;
                       return $this->render('GestionProjetBundle:Photo:photo_content.html.twig', array('liste_photos' => $photos, 'form' => $form->createView(), "display_tab" => $display_tab, "projet" =>$projet));
                   }
               }else{
					$message = $this->get('translator')->trans('Photo.updated_failure', array(), "GestionProjetBundle");
                    $request->getSession()->getFlashBag()->add('message_failure', $message);
                    $photos = array();
                    $display_tab =0;
                    return $this->render('GestionProjetBundle:Photo:photo_content.html.twig', array('liste_photos' => $photos, 'form' => $form->createView(), "display_tab" => $display_tab, "projet" =>$projet));
               }
            }
       /* }else{
            $message = $message = $this->get('translator')->trans('Photo.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }*/
    }
    
    /**
	 * @Security("has_role('ROLE_ADMIN_ACTIF')")
     * @Route("/delete-photo/{id}")
     * @Template()
     */
    public function deletephotoAction(Photo $photo) {
        /*if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }*/
        $request = $this->get("request");
       // $user = new Utilisateur();
        $response = new JsonResponse();
        $repositoryPhoto = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Photo");
        //if ($this->get('gp_bundle.service.role')->isGranted('ROLE_ADMIN_ACTIF', $user)) {
            if ($request->isMethod('POST')) {
                $user = $this->getUser();
                try{
                    $repositoryPhoto->deletePhoto($photo);
                    $message = $message = $this->get('translator')->trans('Photo.deleted_success', array(), "GestionProjetBundle");
                    $messages = array("letype" => "sucess", "message" => $message);
                    return $response->setData(array("data" => $messages));
                } catch (Exception $ex) {
                    $message = $message = $this->get('translator')->trans('Photo.deleted_failure', array(), "GestionProjetBundle");
                    $messages = array("letype" => "sucess", "message" => $message);
                    return $response->setData(array("data" => $messages));
                }                
            }
       /* }else {
            $message = $message = $this->get('translator')->trans('Photo.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }*/
    }
    
    /**
	 * @Security("has_role('ROLE_ADMIN_ACTIF')")
     * @Route("/get-photo/{id}")
     * @Template()
     */
    public function getphotoAction(Photo $photo) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $request = $this->get("request");
         $form = $this->createForm(new PhotoType(), $photo);
        $form->handleRequest($request);
		$projet = $photo->getIdprojet();
        return $this->render('GestionProjetBundle:Photo:form.photo.html.twig', array('form' => $form->createView(), "photo" => $photo));
    }
    
    /**
     * @Route("/get-details-photo/{id}")
     * @Template()
     */
    public function getdetailsphotoAction(Photo $photo) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $request = $this->get("request");
         $form = $this->createForm(new PhotoType(), $photo);
        $form->handleRequest($request);
		$projet = $photo->getIdprojet();
        return $this->render('GestionProjetBundle:Photo:show_details_photo_content.html.twig', array('form' => $form->createView(), "photo" => $photo));
    }

}
