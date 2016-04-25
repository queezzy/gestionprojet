<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UtilisateurController
 *
 * @author Quentin
 * 
 * Il s'agit de quelques fonction qui ne sont pas gerées par fosuserbundle
 */

namespace GestionProjetBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UserBundle\Entity\Utilisateur;
use Symfony\Bundle\SwiftmailerBundle;
use GestionProjetBundle\Entity\Mail;
use GestionProjetBundle\Form\MailType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UtilisateurController extends Controller {

    /**
     * @Route("/utilisateurs", name="gestion_projet_utilisateurs_all")
     * @Method({"GET"})
     */
    public function getAllUsersAction() {
		if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }

        $userManager = $this->container->get('fos_user.user_manager');

        try {
            $users = $userManager->findUsers();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $this->render("GestionProjetBundle:utilisateurs:utilisateurs.templates.html.twig", array('utilisateurs' => $users));
    }

    /**
	 * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Route("/blockutilisateur/{id}", name="gestion_projet_utilisateurs_bloques")
     * @Method({"GET"})
     */
    public function lockUserAction(\UserBundle\Entity\Utilisateur $user) {

        $userManager = $this->container->get('fos_user.user_manager');
        if($user->isEnabled() && !$user->isLocked()){
            $user->setLocked(true);
            $user->setEnabled(false);
        }else{
            $user->setLocked(false);
            $user->setEnabled(true);
        }
        $userManager->updateUser($user);
        return $this->redirect($this->generateUrl('gestion_projet_utilisateurs_all'));
    }

    public function getOneUserAction($email) {

        $userManager = $container->get('fos_user.user_manager');

        try {
            $user = $userManager->findUserByEmail($email);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /**
     * @Route("/sendmail", name="gestion_projet_send_mail")
      @Method({"GET","POST"})
     */
    public function sendMailAction(Request $request) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }

		$mail = new Mail();
        $form = $this->createForm(new MailType(), $mail);
		$request = $this->get("request");
        $form->handleRequest($request);
		$userManager = $this->container->get('fos_user.user_manager');
		$liste_utilisateurs = $userManager->findUsers();
        
        if ($form->isValid()) {

           //$data = $form->getData();
           $user = $this->container->get('security.context')->getToken()->getUser();
            try {
               $message = \Swift_Message::newInstance()
                    ->setSubject($mail->getObjet())
//                    ->setFrom($user->getEmail())
                    ->setFrom('issola.ruben@gmail.com')
//                    ->setTo($data['Destinataires'])
                    ->setTo('tonye.eric@gmail.com')
                    ->setBody($mail->getContenu(),'text/html');

               $message = "Votre mail a été envoyé";
			   $request->getSession()->getFlashBag()->add('notice', $message);
			   return $this->redirect($this->generateUrl('gestion_projet_send_mail'));
            } catch (Exception $exc) {
                //echo $exc->getTraceAsString();
				$message = "Echec de l'envoie du mail";
			   $request->getSession()->getFlashBag()->add('notice', $message);
			   return $this->redirect($this->generateUrl('gestion_projet_send_mail'));
            }
		}

        return $this->render('GestionProjetBundle:collaboration:collaboration.template.html.twig', array('form' => $form->createView(), "liste_utilisateurs" => $liste_utilisateurs));
    }

}
