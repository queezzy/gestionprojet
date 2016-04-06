<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GestionProjetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use GestionProjetBundle\Entity\Utilisateur;
use GestionProjetBundle\Entity\Intervenant;
use GestionProjetBundle\Entity\Projet;
use GestionProjetBundle\Entity\Lot;
use GestionProjetBundle\Entity\Adresse;

/**
 * Description of InterventionController
 *
 * @author TONYE
 */
class IntervenantsController extends Controller {

    //put your code here
    /**
     * @Route("/intervenants")
     * @Template()
     * @param Request $request
     */
    public function intervenantsAction(Request $request) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();
        $repositoryIntervenant = $em->getRepository("GestionProjetBundle:Intervenant");
        $intervenants = $repositoryIntervenant->findBy(array("status" => 1));
        return $this->render('GestionProjetBundle:intervenant:intervenant.html.twig', array('intervenants' => $intervenants));
    }

    /**
     * @Route("/add-intervenant")
     * @Template()
     * @param Request $request
     */
    public function addIntervenantAction(Request $request) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();
        $repositoryIntervenant = $em->getRepository("GestionProjetBundle:Intervenant");
        $repositoryProjet = $em->getRepository("GestionProjetBundle:Projet");
        $repositoryLot = $em->getRepository("GestionProjetBundle:Lot");
        $user = new Utilisateur();
        $intervenant = new Intervenant();
        $projet = new Projet();
        $lot = new Lot();
        $adresse = new Adresse();
        //reponse ajax
        $response = new JsonResponse();
        if ($request->isXmlHttpRequest()) {
            //recuperation de l'utilisateur connnecté
            $user = $this->getUser();
            //reception des variables du formulaire d'inscription en ajax
            $nom = htmlspecialchars(trim($request->request->get('nom')));
            $presentation = htmlspecialchars(trim($request->request->get('presentation')));
            $description = htmlspecialchars(trim($request->request->get('description')));
            $rolemission = htmlspecialchars(trim($request->request->get('rolemission')));
            $evolutionattendu = floatval(htmlspecialchars(trim($request->request->get('evolutionattendu'))));
            $evolutionencours = floatval(htmlspecialchars(trim($request->request->get('evolutionencours'))));
            $idprojet = htmlspecialchars(trim($request->request->get('idprojet')));
            $idlot = htmlspecialchars(trim($request->request->get('idlot')));
            //reception des attributs de l'adresse
            $telephone = htmlspecialchars(trim($request->request->get('telephone')));
            $email = htmlspecialchars(trim($request->request->get('email')));
            $latitude = htmlspecialchars(trim($request->request->get('latitude')));
            $longitude = htmlspecialchars(trim($request->request->get('longitude')));
            $boitepostale = htmlspecialchars(trim($request->request->get('boitepostale')));
            $lieu = htmlspecialchars(trim($request->request->get('lieu')));

            //creation de l'objet Intervenant
            $intervenant->setNom($nom);
            $intervenant->setPresentation($presentation);
            $intervenant->setDescription($description);
            $intervenant->setRolemission($rolemission);
            $intervenant->setEvolutionattendu($evolutionattendu);
            $intervenant->setEvolutionencours($evolutionencours);

            //Creation de l'objet Adresse
            $adresse->setBoitepostale($boitepostale);
            $adresse->setEmail($email);
            $adresse->setLatitude($latitude);
            $adresse->setLongitude($longitude);
            $adresse->setTelephone($telephone);
            $adresse->setLieu($lieu);
            $adresse->setStatut(1);
            if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
                if (ctype_digit($idprojet) && ctype_digit($idlot)) {
                    $idprojet = (int) $idprojet;
                    $idlot = (int) $idlot;
                    $projet = $repositoryProjet->findOneBy(array("idprojet" => $idprojet, "statut" => 1));
                    $lot = $repositoryLot->findOneBy(array("idlot" => $idlot, "statut" => 1));
                    
                    //attribution des attributs class : projet et lot à l'objet intervenant
                    $intervenant->setIdprojet($projet);
                    $intervenant->setIdlot($idlot);
                    $intervenant->setIdadresse($adresse);
                    
                    //Verifions si un intervenant avec cet email existe
                    $intervenantUnique = $repositoryIntervenant->findOneBy(array("email" =>$intervenant->getIdadresse()->getEmail(), "statut"=>1));
                    if ($intervenantUnique) {
                        $message = $message = $this->get('translator')->trans('Intervenant.exist_already', array(), "GestionProjetBundle");
                        $messages[] = array("letype" => "error", "message" => $message);
                        return $response->setData(array("data" => $messages));
                    } else {
                        return $response->setData(array("data" => $this->saveIntervenant($intervenant)));
                    }                    
                }
            } else {
                $message = $message = $this->get('translator')->trans('Intervention.access_denied', array(), "GestionProjetBundle");
                $messages[] = array("letype" => "error", "message" => $message);
                return $response->setData(array("data" => $messages));
            }
        }
    }
    
    /**
     * @Route("/update-intervenant")
     * @Template()
     * @param Request $request
     */
    public function updateIntervenantAction(Request $request) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();
        $repositoryIntervenant = $em->getRepository("GestionProjetBundle:Intervenant");
        $repositoryProjet = $em->getRepository("GestionProjetBundle:Projet");
        $repositoryLot = $em->getRepository("GestionProjetBundle:Lot");
        $user = new Utilisateur();
        $intervenant = new Intervenant();
        $projet = new Projet();
        $lot = new Lot();
        $adresse = new Adresse();
        //reponse ajax
        $response = new JsonResponse();
        if ($request->isXmlHttpRequest()) {
            //recuperation de l'utilisateur connnecté
            $user = $this->getUser();
            //reception des variables du formulaire d'inscription en ajax
            $idintervenant = htmlspecialchars(trim($request->request->get('idintervenant')));
            $nom = htmlspecialchars(trim($request->request->get('nom')));
            $presentation = htmlspecialchars(trim($request->request->get('presentation')));
            $description = htmlspecialchars(trim($request->request->get('description')));
            $rolemission = htmlspecialchars(trim($request->request->get('rolemission')));
            $evolutionattendu = htmlspecialchars(trim($request->request->get('evolutionattendu')));
            $evolutionencours = htmlspecialchars(trim($request->request->get('evolutionencours')));
            $idprojet = htmlspecialchars(trim($request->request->get('idprojet')));
            $idlot = htmlspecialchars(trim($request->request->get('idlot')));
            //reception des attributs de l'adresse
            $telephone = htmlspecialchars(trim($request->request->get('telephone')));
            $email = htmlspecialchars(trim($request->request->get('email')));
            $latitude = htmlspecialchars(trim($request->request->get('latitude')));
            $longitude = htmlspecialchars(trim($request->request->get('longitude')));
            $boitepostale = htmlspecialchars(trim($request->request->get('boitepostale')));
            $lieu = htmlspecialchars(trim($request->request->get('lieu')));

            if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
                if(ctype_digit($idintervenant)){
                    $idintervenant = (int)$idintervenant;
                    //recuperation de l'objet intervenant à modifier
                    $intervenant = $repositoryIntervenant->findOneBy(array("idintervenant" => $idintervenant, "statut" => 1));
                    //creation de l'objet Intervenant
                    $intervenant->setNom($nom); 
                    $intervenant->setPresentation($presentation);
                    $intervenant->setDescription($description);
                    $intervenant->setRolemission($rolemission);
                    $intervenant->setEvolutionattendu($evolutionattendu);
                    $intervenant->setEvolutionencours($evolutionencours);

                    //Creation de l'objet Adresse
                    $adresse->setBoitepostale($boitepostale);
                    $adresse->setEmail($email);
                    $adresse->setLatitude($latitude);
                    $adresse->setLongitude($longitude);
                    $adresse->setTelephone($telephone);
                    $adresse->setLieu($lieu);
                    $adresse->setStatut(1);
                    if (ctype_digit($idprojet) && ctype_digit($idlot)) {
                        $idprojet = (int) $idprojet;
                        $idlot = (int) $idlot;
                        $projet = $repositoryProjet->findOneBy(array("idprojet" => $idprojet, "status" => 1));
                        $lot = $repositoryLot->findOneBy(array("idlot" => $idlot, "status" => 1));

                        //attribution des attributs class : projet et lot à l'objet intervenant
                        $intervenant->setIdprojet($projet);
                        $intervenant->setIdlot($idlot);
                        $intervenant->setIdadresse($adresse);
                        
                        //Renvoie des infos de l'objet mis à jour
                        return $response->setData(array("data" => $this->updateIntervenant($intervenant)));                    
                    }
                }else{
                    $message = $this->get('translator')->trans('Intervenant_updated_id_incorrect', array(), "GestionProjetBundle");
                    $messages[] = array("letype" => "error", "message" => $message);
                    return $messages;
                }
                
            } else {
                $message = $message = $this->get('translator')->trans('Intervention.access_denied', array(), "GestionProjetBundle");
                $messages[] = array("letype" => "error", "message" => $message);
                return $response->setData(array("data" => $messages));
            }
        }
    }
    
    /**
     * @Route("/get-intervenant")
     * @Template()
     * @param Request $request
     */
    public function getIntervenantAction(Request $request) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();
        $repositoryIntervenant = $em->getRepository("GestionProjetBundle:Intervenant");
        if ($request->isXmlHttpRequest()) {
            $idintervenant = htmlspecialchars(trim($request->request->get('idintervenant')));
            $intervenant = new Intervenant();
            if (ctype_digit($idintervenant)) {
                $idintervenant = (int) $idintervenant;
                $intervenant = $repositoryIntervenant->findOneBy(array("idintervenant" => $idintervenant, "statut" => 1));
                $response = new JsonResponse();
                $infosintervenant = array();
                $infosintervenant[] = array("id" => $intervenant->getId(), "nom" => $intervenant->getNom(), "lot" => $intervenant->getIdlot()->getNom(), "localisation" => $intervenant->getIdadresse()->getIdadresse(), "email" => $intervenant->getIdadresse()->getEmail(), "telephone" => $intervenant->getIdadresse()->getTelephone());
                return $response->setData(array("letype" => "success", "data" => $infosintervenant));
            }else{
                $message = $this->get('translator')->trans('Intervenant_updated_id_incorrect', array(), "GestionProjetBundle");
                $messages[] = array("letype" => "error", "message" => $message);
                return $messages;
            }
        }
    }
    
    /**
     * @Route("/delete-intervention")
     * @Template()
     * @param Request $request
     */
    public function deleteIntervenantAction(Request $request) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();
        $repositoryIntervenant = $em->getRepository("GestionProjetBundle:Intervenant");
        $user = new Utilisateur();
        $intervenant = new Intervenant();
        if ($request->isXmlHttpRequest()) {
            $user = $this->getUser();
            if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
                $idintervenant = htmlspecialchars(trim($request->request->get('idintervenant')));
                if (ctype_digit($idintervenant)) {
                    $idintervenant = (int) $idintervenant;
                    $intervenant = $repositoryIntervenant->findOneBy(array("idintervenant" => $idintervenant, "statut" => 1));
                    $response = new JsonResponse();
                    return $response->setData(array("data" => $this->deleteIntervenant($intervenant)));
                }
            }else {
                $message = $message = $this->get('translator')->trans('Intervention.access_denied', array(), "GestionProjetBundle");
                $messages[] = array("letype" => "error", "message" => $message);
                return $response->setData(array("data" => $messages));
            }
        }
    }
    
    
    /**
     * Save the Intervenant in database
     */
    public function saveIntervenant(Intervenant $intervenant_to_save) { 
        $messages = array();
        $em = $this->getDoctrine()->getManager();
        $repositoryIntervenant = $em->getRepository("GestionProjetBundle:Intervenant");
        try {
            $repositoryIntervenant->saveIntervenant($intervenant_to_save);
            $intervenant = $repositoryIntervenant->findOneBy(array("nom" => $intervenant_to_save->getNom(), "idadresse" => $intervenant_to_save->getIdadresse()));
            //$intervenants = $repositoryIntervenant->findBy(array("status" => 1));
            $message = $this->get('translator')->trans('Intervenant.created_success', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "success", "message" => $message);
            $messages[] = array("id" => $intervenant->getId(), "nom" => $intervenant->getNom(), "lot" => $intervenant->getIdlot()->getNom(), "localisation" => $intervenant->getIdadresse()->getIdadresse(), "email" => $intervenant->getIdadresse()->getEmail(), "telephone" => $intervenant->getIdadresse()->getTelephone());
            return $messages;
        } catch (Exception $ex){
            $message = $this->get('translator')->trans('Intervenant.created_failure', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $messages;
        }
    }
    
    /**
     * update the Intervenant in database
     */
    public function updateIntervenant(Intervenant $intervenant) {
        $messages = array();
        $em = $this->getDoctrine()->getManager();
        $repositoryIntervenant = $em->getRepository("GestionProjetBundle:Intervenant");
        try {
            $repositoryIntervenant->updateIntervenant($intervenant);
            $message = $this->get('translator')->trans('Intervenant.updated_success', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "success", "message" => $message);
            $messages[] = array("id" => $intervenant->getId(), "nom" => $intervenant->getNom(), "lot" => $intervenant->getIdlot()->getNom(), "localisation" => $intervenant->getIdadresse()->getIdadresse(), "email" => $intervenant->getIdadresse()->getEmail(), "telephone" => $intervenant->getIdadresse()->getTelephone());
            return $messages;
        } catch (Exception $ex){
            $message = $this->get('translator')->trans('Intervenant.updated_failure', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $messages;
        }
    }
    
    /**
     * delete the Intervenant in database
     */
    public function deleteIntervenant(Intervenant $intervenant_to_delete) {
        $messages = array();
        $em = $this->getDoctrine()->getManager();
        $repositoryIntervenant = $em->getRepository("GestionProjetBundle:Intervenant");
        try {
            $repositoryIntervenant->deleteIntervenant($intervenant_to_delete);
            $message = $this->get('translator')->trans('Intervenant.deleted_success', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "success", "message" => $message);
            return $messages;
        } catch (Exception $ex){
            $message = $this->get('translator')->trans('Intervenant.deleted_failure', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $messages;
        }
    }

}
