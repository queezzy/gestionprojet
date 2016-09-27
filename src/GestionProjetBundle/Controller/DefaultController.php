<?php

namespace GestionProjetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use GestionProjetBundle\Entity\Projet;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    
    /**
     * @Route("/accueil")
     * @Template()
     * @param Request $request
     */
    public function accueilAction(Request $request) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
		$projet = $request->getSession()->get('projetactif');
		if($projet==null){
			return $this->redirect($this->generateUrl('fos_user_security_login'));
		}
        return $this->render('GestionProjetBundle:accueil:accueil.template.html.twig', array("projetactif"=> $projet));
    }
    
    /*
     * @Route("/",name="homepage")
     */
    public function indexAction()
    {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
		
		$request = $this->get("request");
		$projet = $request->getSession()->get('projetactif');
		if($projet==null){
			return $this->redirect($this->generateUrl('fos_user_security_login'));
		}
        return $this->render('GestionProjetBundle:accueil:accueil.template.html.twig', array("projetactif"=> $projet));
        
    }
}
