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
        //$repositoryCalendrier = $em->getRepository("GestionProjetBundle:Calendrier");
        $repositoryAcualite = $em->getRepository("GestionProjetBundle:Actualite");
        $projet = new Projet();
        $interventions = array();
        $calendriers = array();
        $actualites = array();
        //selectionne le seul projet actif
        $projet = $repositoryProjet->findByOne(array("status" => 1));
        if($projet){
            //intervenants du projet
            $interventions = $projet->getIntervenants();
            //les calendriers du projet
            $calendriers = $projet->getCalendriers();
            //les 10 actualités les plus recentes du projet
            $actualites = $repositoryAcualite->findRecentsActualites($projet);
        }
        
        return $this->render('GestionProjetBundle:intervenant:accueil.html.twig', array('projet' => $projet, 'intervenants' => $interventions, 'calendriers' => $calendriers, 'actualites' => $actualites));
    }
    
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
        $em = $this->getDoctrine()->getManager();
        $repositoryProjet = $em->getRepository("GestionProjetBundle:Projet");
        //$repositoryCalendrier = $em->getRepository("GestionProjetBundle:Calendrier");
        $repositoryAcualite = $em->getRepository("GestionProjetBundle:Actualite");
        $projet = new Projet();
        $interventions = array();
        $calendriers = array();
        $actualites = array();
        //selectionne le seul projet actif
        $projet = $repositoryProjet->findByOne(array("status" => 1));
        if($projet){
            //intervenants du projet
            $interventions = $projet->getIntervenants();
            //les calendriers du projet
            $calendriers = $projet->getCalendriers();
            //les 10 actualités les plus recentes du projet
            $actualites = $repositoryAcualite->findRecentsActualites($projet);
        }
        
        return $this->render('GestionProjetBundle:intervenant:accueil.html.twig', array('projet' => $projet, 'intervenants' => $interventions, 'calendriers' => $calendriers, 'actualites' => $actualites));
    }
    
    /**
     * @Route("/add-projet")
     * @Template()
     * @param Request $request
     */
    public function addProjetAction(Request $request) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();
        $repositoryProjet = $em->getRepository("GestionProjetBundle:Projet");
        $user = new Utilisateur();
        $projet = new Projet();
        //reponse ajax
        $response = new JsonResponse();
        if ($request->isXmlHttpRequest()) {
            //recuperation de l'utilisateur connnecté
            $user = $this->getUser();
            //reception des variables du formulaire d'inscription en ajax
            $code = htmlspecialchars(trim($request->request->get('code')));
            $intitule = htmlspecialchars(trim($request->request->get('intitule')));
            $description = htmlspecialchars(trim($request->request->get('description')));
            $datedebut = date_create(htmlspecialchars(trim($request->request->get('datedebut'))));
            $datefin = date_create(htmlspecialchars(trim($request->request->get('datefin'))));
            $evolutionattendu = floatval(htmlspecialchars(trim($request->request->get('evolutionattendu'))));
            $evolutionencours = floatval(htmlspecialchars(trim($request->request->get('evolutionencours'))));
            $budget = floatval(htmlspecialchars(trim($request->request->get('budget'))));
            $demandeur = htmlspecialchars(trim($request->request->get('demandeur')));
            $statut = htmlspecialchars(trim($request->request->get('statut')));

            //creation de l'objet Projet
            $projet->setCode($code);
            $projet->setIntitule($intitule);
            $projet->setDescription($description);
            $projet->setDatedebut($datedebut);
            $projet->setDatefin($datefin); 
            $projet->setEvolutionattendu($evolutionattendu);
            $projet->setEvolutionencours($evolutionencours);
            $projet->setBudget($budget);
            $projet->setDemandeur($demandeur); 
            if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
                if (ctype_digit($statut)) {
                    $statut = (int) $statut;
                    
                    //attribution du statut au projet
                    $projet->setStatut($statut);

                    //Verifions si un intervenant avec cet email existe
                    $projetUnique = $repositoryProjet->findOneBy(array("code" =>$projet->getCode(), "statut"=>1));
                    if ($projetUnique) {
                        $message = $message = $this->get('translator')->trans('Projet.exist_already', array(), "GestionProjetBundle");
                        $messages[] = array("letype" => "error", "message" => $message);
                        return $response->setData(array("data" => $messages));
                    } else {
                        return $response->setData(array("data" => $this->saveProjet($projet)));
                    }                    
                }
            } else {
                $message = $message = $this->get('translator')->trans('Projet.access_denied', array(), "GestionProjetBundle");
                $messages[] = array("letype" => "error", "message" => $message);
                return $response->setData(array("data" => $messages));
            }
        }
    }
    
    /**
     * @Route("/update-projet")
     * @Template()
     * @param Request $request
     */
    public function updateProjetAction(Request $request) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();
        $repositoryProjet = $em->getRepository("GestionProjetBundle:Projet");
        $user = new Utilisateur();
        $projet = new Projet();
        //reponse ajax
        $response = new JsonResponse();
        if ($request->isXmlHttpRequest()) {
            //recuperation de l'utilisateur connnecté
            $user = $this->getUser();
                     
            //reception des variables du formulaire d'inscription en ajax
            $idprojet = htmlspecialchars(trim($request->request->get('idprojet')));
            $code = htmlspecialchars(trim($request->request->get('code')));
            $intitule = htmlspecialchars(trim($request->request->get('intitule')));
            $description = htmlspecialchars(trim($request->request->get('description')));
            $datedebut = date_create(htmlspecialchars(trim($request->request->get('datedebut'))));
            $datefin = date_create(htmlspecialchars(trim($request->request->get('datefin'))));
            $evolutionattendu = floatval(htmlspecialchars(trim($request->request->get('evolutionattendu'))));
            $evolutionencours = floatval(htmlspecialchars(trim($request->request->get('evolutionencours'))));
            $budget = floatval(htmlspecialchars(trim($request->request->get('budget'))));
            $demandeur = htmlspecialchars(trim($request->request->get('demandeur')));
            $statut = htmlspecialchars(trim($request->request->get('statut')));
            if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
                if (ctype_digit($idprojet)) {
                    //creation de l'objet Projet
                    $projet->setCode($code);
                    $projet->setIntitule($intitule);
                    $projet->setDescription($description);
                    $projet->setDatedebut($datedebut);
                    $projet->setDatefin($datefin); 
                    $projet->setEvolutionattendu($evolutionattendu);
                    $projet->setEvolutionencours($evolutionencours);
                    $projet->setBudget($budget);
                    $projet->setDemandeur($demandeur); 

                    if (ctype_digit($statut)) {
                        $statut = (int) $statut;

                        //attribution du statut au projet
                        $projet->setStatut($statut);
                        //mise à jour du projet
                        return $response->setData(array("data" => $this->saveProjet($projet)));                    
                    }
                }
            }else {
                $message = $message = $this->get('translator')->trans('Projet.access_denied', array(), "GestionProjetBundle");
                $messages[] = array("letype" => "error", "message" => $message);
                return $response->setData(array("data" => $messages));
            }                   
        }
    }
    
    /**
     * @Route("/delete-projet")
     * @Template()
     * @param Request $request
     */
    public function deleteProjetAction(Request $request) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();
        $repositoryProjet = $em->getRepository("GestionProjetBundle:Projet");
        $user = new Utilisateur();
        $projet = new Projet();
        if ($request->isXmlHttpRequest()) {
            $user = $this->getUser();
            if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
                $idprojet = htmlspecialchars(trim($request->request->get('idprojet')));
                if (ctype_digit($idprojet)) {
                    $idprojet = (int) $idprojet;
                    $projet = $repositoryProjet->findOneBy(array("idprojet" => $idprojet, "statut" => 1));
                    $response = new JsonResponse();
                    return $response->setData(array("data" => $this->deleteProjet($projet)));
                }
            }else {
                $message = $message = $this->get('translator')->trans('Projet.access_denied', array(), "GestionProjetBundle");
                $messages[] = array("letype" => "error", "message" => $message);
                return $response->setData(array("data" => $messages));
            }
        }
    }
    
    /**
     * Save the Projet in database
     */
    public function saveProjet(Projet $projet_to_save) {
        $messages = array();
        $em = $this->getDoctrine()->getManager();
        $repositoryProjet = $em->getRepository("GestionProjetBundle:Projet");
        try {
            $repositoryProjet->saveProjet($projet_to_save);
            $message = $this->get('translator')->trans('Projet.created_success', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "success", "message" => $message);
            return $messages;
        } catch (Exception $ex){
            $message = $this->get('translator')->trans('Projet.created_failure', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $messages;
        }
    }
    
    /**
     * Update the Projet in database
     */
    public function updateProjet(Projet $projet_to_update) {
        $messages = array();
        $em = $this->getDoctrine()->getManager();
        $repositoryProjet = $em->getRepository("GestionProjetBundle:Projet");
        try {
            $repositoryProjet->updateProjet($projet_to_update);
            $message = $this->get('translator')->trans('Projet.updated_success', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "success", "message" => $message);
            return $messages;
        } catch (Exception $ex){
            $message = $this->get('translator')->trans('Projet.updated_failure', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $messages;
        }
    }
    
    /**
     * Delete the Projet in database
     */
    public function deleteProjet(Projet $projet_to_delete) {
        $messages = array();
        $em = $this->getDoctrine()->getManager();
        $repositoryProjet = $em->getRepository("GestionProjetBundle:Projet");
        try {
            $repositoryProjet->deleteProjet($projet_to_delete);
            $message = $this->get('translator')->trans('Projet.deleted_success', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "success", "message" => $message);
            return $messages;
        } catch (Exception $ex){
            $message = $this->get('translator')->trans('Projet.deleted_failure', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $messages;
        }
    }
}
