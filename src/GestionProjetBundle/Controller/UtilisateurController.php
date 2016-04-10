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

use GestionProjetBundle\Form\RessourceType;
use GestionProjetBundle\Entity\Ressource;

class UtilisateurController extends Controller{

    
     /**
     * @Route("/utilisateurs", name="gestion_projet_utilisateurs_all")
      *@Method({"GET"})
     */
    
    public function getAllUsersAction(){
        
        
        $userManager = $this->container->get('fos_user.user_manager');
        
        try {
            $users=$userManager->findUsers();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $this->render("GestionProjetBundle:utilisateurs:utilisateurs.templates.html.twig",array('utilisateurs'=>$users));
    }
    
    
    public function getOneUserAction($email){
        
       $userManager = $container->get('fos_user.user_manager');
        
        try {
            $user=$userManager->findUserByEmail($email);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    
}
