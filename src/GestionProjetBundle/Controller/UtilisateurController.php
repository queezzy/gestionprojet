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

class UtilisateurController extends Controller {

    /**
     * @Route("/utilisateurs", name="gestion_projet_utilisateurs_all")
     * @Method({"GET"})
     */
    public function getAllUsersAction() {


        $userManager = $this->container->get('fos_user.user_manager');

        try {
            $users = $userManager->findUsers();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $this->render("GestionProjetBundle:utilisateurs:utilisateurs.templates.html.twig", array('utilisateurs' => $users));
    }

    /**
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
     * @Route("/sendmail/", name="gestion_projet_send")
      @Method({"GET","POST"})
     */
    public function sendMailAction(Request $request) {
        
       $data =array();
        
        $form = $this->createFormBuilder($data)
                ->add('Objet')
                ->add('Message','textarea')
                ->add('Destinataires', 'entity',array(
                      'class'=> 'UserBundle\Entity\Utilisateur',
                      'property' => 'email'
                      ))
                ->getForm();
        
            
            
        $form->handleRequest($request);
        
        if ($form->isValid()) {

           $data = $form->getData();
           $user = $this->container->get('security.context')->getToken()->getUser();

            try {
               $message = \Swift_Message::newInstance()
                    ->setSubject($data['Objet'])
//                    ->setFrom($user->getEmail())
                    ->setFrom('tonye.eric@gmail.com')
//                    ->setTo($data['Destinataires'])
                    ->setTo('franckquentinnfotabong@gmail.com')
                    ->setBody($data['Message'],'text/html');

                $this->get('mailer')->send($message);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }

            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('GestionProjetBundle:formulaire:form.send.mail.html.twig', array(
                    'form' => $form->createView(),
        ));
        
        
    }

}
