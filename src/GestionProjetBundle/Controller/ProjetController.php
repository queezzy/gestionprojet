<?php

namespace GestionProjetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use GestionProjetBundle\Entity\Projet;
use GestionProjetBundle\Entity\Intervenant;
use GestionProjetBundle\Form\ProjetType;
use UserBundle\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Session\Session;

class ProjetController extends Controller {

    /**
     * @Route("/projets-admin")
     * @Template()
     * @param Request $request
     */
    public function projetAction(Request $request) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        if (!$this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            return $this->redirect($this->generateUrl('gp_login'));
        }
        $em = $this->getDoctrine()->getManager();

        $repositoryProjet = $em->getRepository("GestionProjetBundle:Projet");
        $projet = new Projet();
        $form = $this->createForm(new ProjetType(), $projet);
        $display_tab = 1;
        //selectionne les seuls projets actif
        $projets = $repositoryProjet->findBy(array("statut" => 1));

        return $this->render('GestionProjetBundle:Projet:projet_content.html.twig', array('liste_projets' => $projets, 'form' => $form->createView(), "display_tab" => $display_tab));
    }

    /**
     * @Route("/users-projet/{id}")
     * @Template()
     */
    public function usersprojetAction(Projet $projet) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        if (!$this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            return $this->redirect($this->generateUrl('gp_login'));
        }
        //selectionne les seuls projets actif
        $users = $projet->getUtilisateurs();

        return $this->render('GestionProjetBundle:Projet:users_projet_content.html.twig', array('utilisateurs' => $users, 'projet' => $projet));
    }
	
	/**
     * @Route("/gestion-projet/{id}")
     * @Template()
     */
    public function gestionprojetAction(Projet $projet) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        if (!$this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            return $this->redirect($this->generateUrl('gp_login'));
        }
        //selectionne les seuls projets actif
        $users = $projet->getUtilisateurs();

        return $this->render('GestionProjetBundle:Projet:gestion_projet_content.html.twig', array('projet' => $projet));
    }
    
    /**
     * @Route("/intervenants-projet/{id}")
     * @Template()
     */
    public function intervenantsprojetAction(Projet $projet) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        if (!$this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            return $this->redirect($this->generateUrl('gp_login'));
        }
		$repositoryIntervenant = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Intervenant");
        //selectionne les seuls intervenants actif
        $intervenants = $repositoryIntervenant->findBy(array("statut" => 1, "idprojet" =>$projet ));

        return $this->render('GestionProjetBundle:Intervenant:intervenants_projet.template.html.twig', array('liste_intervenants' => $intervenants, 'projet' => $projet));
    }

    public function headerprojetactifAction() {
        $session = $this->get("session");
		$projet = $session->get('projetactif');
        return $this->render('::header.template.html.twig', array('projetactif' => $projet));
    }

    public function menusgaleriephotosAction() {
        //selectionne le seul projet actif
        $session = $this->get("session");
		$projet = $session->get('projetactif');
        return $this->render('GestionProjetBundle::menusgaleriephotos.template.html.twig', array('projetactif' => $projet));
    }

    public function sousmenugestionphotoAction() {
        $session = $this->get("session");
		$projet = $session->get('projetactif');
        return $this->render('GestionProjetBundle::sousmenugestionphoto.template.html.twig', array('projetactif' => $projet));
    }

    public function menuAction() {
        $session = $this->get("session");
		$projet = $session->get('projetactif');
        return $this->render('GestionProjetBundle::menu.template.html.twig', array('projetactif' => $projet));
    }

    /**
     * @Route("/get-presentation-projet-accueil")
     * @Template()
     */
    public function getPresentationProjetAccueilAction() {
        $session = $this->get("session");
		$projet = $session->get('projetactif');
        return $this->render('GestionProjetBundle:accueil:accueil.presentation.projet.html.twig', array('projetactif' => $projet));
    }

    /**
     * @Route("/get-evolution-projet-accueil")
     * @Template()
     */
    public function getEvolutionProjetAccueilAction() {
        $session = $this->get("session");
		$projet = $session->get('projetactif');
        return $this->render('GestionProjetBundle:accueil:accueil.evolution.projet.html.twig', array('projetactif' => $projet));
    }

    /**
     * @Route("/add-projet")
     * @Template()
     * @param Request $request
     */
    public function addProjetAction(Request $request) {
        if (!$this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            return $this->redirect($this->generateUrl('gp_login'));
        }
        $projet = new Projet();
        $form = $this->createForm(new ProjetType(), $projet);
        $form->handleRequest($request);
        $repositoryProjet = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Projet");
        //$user = $this->getUser();
        // if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
        //if($request->isMethod('POST')){
        if ($form->isValid()) {
            try {
                if ($projet->getEvolutionattendu() >= $projet->getEvolutionencours()) {
                    $repositoryProjet->saveProjet($projet);
                    $message = $this->get('translator')->trans('Projet.created_success', array(), "GestionProjetBundle");
                    $request->getSession()->getFlashBag()->add('message', $message);
                    return $this->redirect($this->generateUrl('gp_projet_admin'));
                } else {
                    $message = $this->get('translator')->trans('Projet.created_failure', array(), "GestionProjetBundle");
                    $request->getSession()->getFlashBag()->add('message_success', $message);
                    $projets = array();
                    $display_tab = 0;
                    return $this->render('GestionProjetBundle:Projet:projet_content.html.twig', array('liste_projets' => $projets, 'form' => $form->createView(), "display_tab" => $display_tab));
                }
            } catch (Exception $ex) {
                $message = $this->get('translator')->trans('Projet.created_failure', array(), "GestionProjetBundle");
                $request->getSession()->getFlashBag()->add('message_success', $message);
                $projets = array();
                $display_tab = 0;
                return $this->render('GestionProjetBundle:Projet:projet_content.html.twig', array('liste_projets' => $projets, 'form' => $form->createView(), "display_tab" => $display_tab));
            }
        } else {
            $message = $this->get('translator')->trans('Projet.created_failure', array(), "GestionProjetBundle");
            $request->getSession()->getFlashBag()->add('message_failure', $message);
            $projets = array();
            $display_tab = 0;
            return $this->render('GestionProjetBundle:Projet:projet_content.html.twig', array('liste_projets' => $projets, 'form' => $form->createView(), "display_tab" => $display_tab));
        }
        // }
        /* }else{
          $message = $message = $this->get('translator')->trans('Projet.access_denied', array(), "GestionProjetBundle");
          $messages[] = array("letype" => "error", "message" => $message);
          return $response->setData(array("data" => $messages));
          } */
    }

    /**
     * @Route("/update-projet/{id}")
     * @Template()
     */
    public function updateprojetAction(Projet $projet) {
        if (!$this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            return $this->redirect($this->generateUrl('gp_login'));
        }
        $repositoryProjet = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Projet");
        $form = $this->createForm(new ProjetType(), $projet);
        $request = $this->get("request");
        $form->handleRequest($request);
        $user = $this->getUser();
        //if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
        if ($request->isMethod('POST')) {
            if ($form->isValid()) {
                try {
                    if ($projet->getEvolutionattendu() >= $projet->getEvolutionencours()) {
                        $repositoryProjet->updateProjet($projet);
                        $message = $this->get('translator')->trans('Projet.updated_success', array(), "GestionProjetBundle");
                        $request->getSession()->getFlashBag()->add('message_success', $message);
                        return $this->redirect($this->generateUrl('gp_projet_admin'));
                    } else {
                        $message = $this->get('translator')->trans('Projet.updated_failure', array(), "GestionProjetBundle");
                        $request->getSession()->getFlashBag()->add('message_failure', $message);
                        $projets = array();
                        $display_tab = 0;
                        return $this->render('GestionProjetBundle:Projet:projet_content.html.twig', array('liste_projets' => $projets, 'form' => $form->createView(), "display_tab" => $display_tab));
                    }
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Projet.updated_failure', array(), "GestionProjetBundle");
                    $request->getSession()->getFlashBag()->add('message_failure', $message);
                    $projets = array();
                    $display_tab = 0;
                    return $this->render('GestionProjetBundle:Projet:projet_content.html.twig', array('liste_projets' => $projets, 'form' => $form->createView(), "display_tab" => $display_tab));
                }
            } else {
                $request->getSession()->getFlashBag()->add('message_failure', $message);
                $projets = array();
                $display_tab = 0;
                return $this->render('GestionProjetBundle:Projet:projet_content.html.twig', array('liste_projets' => $projets, 'form' => $form->createView(), "display_tab" => $display_tab));
            }
        }
        /* }else{
          $message = $message = $this->get('translator')->trans('Projet.access_denied', array(), "GestionProjetBundle");
          $messages[] = array("letype" => "error", "message" => $message);
          return $response->setData(array("data" => $messages));
          } */
    }

    /**
     * @Route("/delete-projet/{id}")
     * @Template()
     */
    public function deleteprojetAction(Projet $projet) {
        if (!$this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            return $this->redirect($this->generateUrl('gp_login'));
        }
        $request = $this->get("request");
        //$user = new Utilisateur();
        $response = new JsonResponse();
        $repositoryProjet = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Projet");
        //if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
        if ($request->isMethod('POST')) {
            $user = $this->getUser();
            try {
                $repositoryProjet->deleteProjet($projet);
                $message = $message = $this->get('translator')->trans('Projet.deleted_success', array(), "GestionProjetBundle");
                $messages = array("letype" => "sucess", "message" => $message);
                return $response->setData(array("data" => $messages));
            } catch (Exception $ex) {
                $message = $message = $this->get('translator')->trans('Projet.deleted_failure', array(), "GestionProjetBundle");
                $messages = array("letype" => "error", "message" => $message);
                return $response->setData(array("data" => $messages));
            }
        }
        /* }else {
          $message = $message = $this->get('translator')->trans('Projet.access_denied', array(), "GestionProjetBundle");
          $messages[] = array("letype" => "error", "message" => $message);
          return $response->setData(array("data" => $messages));
          } */
    }
	
	/**
     * @Route("/delete-user-projet/{idprojet}/{id}")
     * @Template()
     */
    public function deleteuserprojetAction($idprojet, Utilisateur $user) {
        if (!$this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            return $this->redirect($this->generateUrl('gp_login'));
        }
        $request = $this->get("request");
        //$user = new Utilisateur();
        $response = new JsonResponse();
        //$session = $this->get("session");
		$projet = new Projet();
		$userManager = $this->container->get('fos_user.user_manager');
		$repositoryProjet = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Projet");
        if ($request->isMethod('GET')) {
			$idprojet = (int)$idprojet;
			$projet = $repositoryProjet->find($idprojet);
            $user->removeProjet($projet);
			$projet->removeUtilisateur($user);
            try {
				$userManager->updateUser($user);
                $repositoryProjet->updateProjet($projet);
                $message = $message = $this->get('translator')->trans('User.deleted_success', array(), "GestionProjetBundle");
				$request->getSession()->getFlashBag()->add('message', $message);
                return $this->redirect($this->generateUrl('gp_users_projet', array("id" => $projet->getId())));
            } catch (Exception $ex) {
				$message = $message = $this->get('translator')->trans('User.deleted_failure', array(), "GestionProjetBundle");
				$request->getSession()->getFlashBag()->add('message', $message);
                return $this->redirect($this->generateUrl('gp_users_projet', array("id" => $projet->getId())));
            }
        }
         return $this->redirect($this->generateUrl('gp_users_projet', array("id" => $projet->getId())));
    }

    /**
     * @Route("/get-projet/{id}")
     * @Template()
     */
    public function getprojetAction(Projet $projet) {
        if (!$this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            return $this->redirect($this->generateUrl('gp_login'));
        }
        //$repositoryProjet = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Projet");
        //$idprojet = htmlspecialchars(trim($id));
        //$projet = $repositoryProjet->find($idprojet);
        $request = $this->get("request");
        $form = $this->createForm(new ProjetType(), $projet);
        $form->handleRequest($request);
        return $this->render('GestionProjetBundle:Projet:form.projet.html.twig', array('form' => $form->createView(), "idprojet" => $projet->getId()));
    }

    /**
     * Creates a new user for projet entity.
     *
     * @Route("/add-user-projet/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function adduserprojetAction(Request $request, Projet $projet) {
        $user = new \UserBundle\Entity\Utilisateur();
        $userProjet = new \UserBundle\Entity\Utilisateur();
        $repositoryProjet = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Projet");
        $userManager = $this->container->get('fos_user.user_manager');
        $usersProjet = $projet->getUtilisateurs();
        $utilisateurs = $userManager->findUsers();
        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($request->isMethod("POST")) {
                $infosutilisateurs = $request->request->get("utilisateurs");
                if ($infosutilisateurs) {
                    foreach ($infosutilisateurs as $infouser) {
                        $user = $userManager->findUserByUsernameOrEmail($infouser);
                        $i = 0;
                        $trouve = false;
                        while ($i < count($usersProjet) && !$trouve) {
                            $userProjet = $usersProjet[i];
                            if ($userProjet->getId() == $user->getId() && !$user->isEnabled()&& !$user->isLocked()) {
                                $trouve = true;
                            }
							$i++;
                        }
                        if (!$trouve) {
                            $user->addProjet($projet);
                            $projet->addUtilisateur($user);
                        }
                    }
                }
                try {
                    $repositoryProjet->updateProjet($projet);
                    $message = $this->get('translator')->trans('User.added_success', array(), "GestionProjetBundle");
                    $request->getSession()->getFlashBag()->add('message', $message);
                    return $this->render('GestionProjetBundle:utilisateurs:form_add_user_projet.html.twig', array('utilisateurs' => $utilisateurs, 'projet' => $projet));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('User.added_failure', array(), "GestionProjetBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('GestionProjetBundle:utilisateurs:form_add_user_projet.html.twig', array('utilisateurs' => $utilisateurs, 'projet' => $projet));
                }
            }
            return $this->render('GestionProjetBundle:utilisateurs:form_add_user_projet.html.twig', array('utilisateurs' => $utilisateurs, 'projet' => $projet));
        } else {
            return $this->redirect($this->generateUrl('gp_users_projet', array("id" => $projet->getId())));
        }
    }
	
	
	/**
     * Creates a new user for projet entity.
     *
     * @Route("/add-intervenant-projet/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function addintervenantprojetAction(Request $request, Projet $projet) {
        $intervenant = new \GestionProjetBundle\Entity\Intervenant();
        $intervenantProjet = new \GestionProjetBundle\Entity\Intervenant();
        $repositoryProjet = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Projet");
        $repositoryIntervenant = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Intervenant");
        $intervenantsProjet = $repositoryIntervenant->findBy(array("statut" => 1, "idprojet" =>$projet ));
        $intervenants = $repositoryIntervenant->findBy(array("statut" => 1));
        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($request->isMethod("POST")) {
                $idintervenants = $request->request->get("intervenants");
                if ($idintervenants) {
                    foreach ($idintervenants as $idintervenant) {
						$idintervenant = (int)$idintervenant;
                        $intervenant = $repositoryIntervenant->find($idintervenant);
                        $i = 0;
                        $trouve = false;
                        while ($i < count($intervenantsProjet) && !$trouve) {
                            $intervenantProjet = $intervenantsProjet[i];
                            if ($intervenantProjet->getId() == $intervenant->getId()) {
                                $trouve = true;
                            }
							$i++;
                        }
                        if (!$trouve) {
                            $intervenant->addProjet($projet);
                            $projet->addIntervenant($intervenant);
                        }
                    }
                }
                try {
                    $repositoryProjet->updateProjet($projet);
                    $message = $this->get('translator')->trans('Intervenant.added_success', array(), "GestionProjetBundle");
                    $request->getSession()->getFlashBag()->add('message', $message);
                    return $this->render('GestionProjetBundle:Intervenant:form_add_intervenant_projet.html.twig', array('intervenants' => $intervenants, 'projet' => $projet));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Intervenant.added_failure', array(), "GestionProjetBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('GestionProjetBundle:Intervenant:form_add_intervenant_projet.html.twig', array('intervenants' => $intervenants, 'projet' => $projet));
                }
            }
            return $this->render('GestionProjetBundle:Intervenant:form_add_intervenant_projet.html.twig', array('intervenants' => $intervenants, 'projet' => $projet));
        } else {
            return $this->redirect($this->generateUrl('gp_intervenants_projet', array("id" => $projet->getId())));
        }
    }

	
	/**
     * @Route("/delete-intervenant-projet/{idprojet}/{id}")
     * @Template()
     */
    public function deleteintervenantprojetAction($idprojet, Intervenant $intervenant) {
        if (!$this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            return $this->redirect($this->generateUrl('gp_login'));
        }
        $request = $this->get("request");
        //$user = new Utilisateur();
        $response = new JsonResponse();
        //$session = $this->get("session");
		$projet = new Projet();
		$repositoryIntervenant = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Intervenant");
		$repositoryProjet = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Projet");
        if ($request->isMethod('GET')) {
			$idprojet = (int)$idprojet;
			$projet = $repositoryProjet->find($idprojet);
            $intervenant->removeProjet($projet);
			$projet->removeIntervenant($intervenant);
            try {
				$repositoryIntervenant->updateIntervenant($intervenant);
                $repositoryProjet->updateProjet($projet);
                $message = $message = $this->get('translator')->trans('Intervenant.deleted_success', array(), "GestionProjetBundle");
				$request->getSession()->getFlashBag()->add('message', $message);
                return $this->redirect($this->generateUrl('gp_intervenants_projet', array("id" => $projet->getId())));
            } catch (Exception $ex) {
				$message = $message = $this->get('translator')->trans('Intervenant.deleted_failure', array(), "GestionProjetBundle");
				$request->getSession()->getFlashBag()->add('message', $message);
                return $this->redirect($this->generateUrl('gp_intervenants_projett', array("id" => $projet->getId())));
            }
        }
         return $this->redirect($this->generateUrl('gp_intervenants_projet', array("id" => $projet->getId())));
    }
}
