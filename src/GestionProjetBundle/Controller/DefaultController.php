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
     * @Route("/")
     * @Template()
     * @param Request $request
     */
    public function indexAction(Request $request) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /*if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }*/
        $em = $this->getDoctrine()->getManager();

        $repositoryProjet = $em->getRepository("GestionProjetBundle:Projet");
        /*//$repositoryCalendrier = $em->getRepository("GestionProjetBundle:Calendrier");
        $repositoryAcualite = $em->getRepository("GestionProjetBundle:Actualite");
        $intervenant = array();
        $calendriers = array();
        $actualites = array();*/
        //selectionne le seul projet actif
        $projet = $repositoryProjet->findOneBy(array("statut" => 1));
        /*if($projet){
            //intervenants du projet
            $interventions = $projet->getIntervenants();
            //les calendriers du projet
            $calendriers = $projet->getCalendriers();
            //les 10 actualités les plus recentes du projet
            $actualites = $repositoryAcualite->findRecentsActualites($projet);
        }*/
        
        return $this->render('GestionProjetBundle:accueil:accueil.template.html.twig', array('projet' => $projet));
    }
    
    /**
     * @Route("/accueil")
     * @Template()
     * @param Request $request
     */
    public function accueilAction(Request $request) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /*if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }*/
        $em = $this->getDoctrine()->getManager();

        $repositoryProjet = $em->getRepository("GestionProjetBundle:Projet");
        /*//$repositoryCalendrier = $em->getRepository("GestionProjetBundle:Calendrier");
        $repositoryAcualite = $em->getRepository("GestionProjetBundle:Actualite");
        $intervenant = array();
        $calendriers = array();
        $actualites = array();*/
        //selectionne le seul projet actif
        $projet = $repositoryProjet->findOneBy(array("statut" => 1));
        /*if($projet){
            //intervenants du projet
            $interventions = $projet->getIntervenants();
            //les calendriers du projet
            $calendriers = $projet->getCalendriers();
            //les 10 actualités les plus recentes du projet
            $actualites = $repositoryAcualite->findRecentsActualites($projet);
        }*/
        
        return $this->render('GestionProjetBundle:accueil:accueil.template.html.twig', array('projet' => $projet));
    }
}
