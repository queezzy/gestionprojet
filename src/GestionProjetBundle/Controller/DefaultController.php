<?php

namespace GestionProjetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use GestionProjetBundle\Entity\Projet;

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
        $repositoryProjet = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Projet");
        $projets = $repositoryProjet->findBy(array("statut" => 1));
        if($projets){
            $projet = $repositoryProjet->findBy(array("statut" => 1))[0];
        }else{
            $projet = null;
        }
        return $this->render('GestionProjetBundle:accueil:accueil.template.html.twig', array("projet"=> $projet));
    }
    
    /*
     * @Route("/",name="homepage")
     */
    public function indexAction()
    {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }else{
            $repositoryProjet = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Projet");
            $projets = $repositoryProjet->findBy(array("statut" => 1));
            if($projets){
                $projet = $repositoryProjet->findBy(array("statut" => 1))[0];
            }else{
                $projet = null;
            }
            return $this->render('GestionProjetBundle:accueil:accueil.template.html.twig', array("projet"=> $projet));
        }
        
    }
}
