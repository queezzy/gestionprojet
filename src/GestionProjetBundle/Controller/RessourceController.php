<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GestionProjetBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GestionProjetBundle\Form\RessourceType;

use GestionProjetBundle\Entity\Ressource;
use GestionProjetBundle\Entity\Intervenant;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Description of RessourceControlle
 *
 * @author Quentin
 */
class RessourceController extends Controller {

    /**
     * @Route("/ressource/ajouter", name="gestion_projet_ressource_new")
      @Method({"GET","POST"})
     */
    public function newRessourceAction(Request $request) {
        $ressource = new Ressource();
        $form = $this->createForm(new RessourceType(), $ressource);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $ressource_repo = $em->getRepository('GestionProjetBundle:Ressource');

            try {
                if ($ressource->getType() == 1 && $ressource->getStatut() == 1) {
                    $ressource->setStatut(2);
                }
                $ressource_repo->saveRessource($ressource);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }

            $request->getSession()->getFlashBag()->add('notice', 'Actualite bien enregistrée.');
            return $this->redirect($this->generateUrl('gestion_projet_ressource_all'));
        }

        return $this->render('GestionProjetBundle:formulaire:form.creation.ressource.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/ressource/modifier/{id}", name="gestion_projet_ressource_update",requirements={"id" = "\d+"})
     * @Method({"GET","POST"})
     */
    public function updateRessourceAction(Ressource $ressource) {

        $request = $this->get('request');


        $em = $this->getDoctrine()->getEntityManager();
        $ressource_repo = $em->getRepository('GestionProjetBundle:Ressource');
        $form = $this->createForm(new \GestionProjetBundle\Form\RessourceType, $ressource);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {

                try {
                    if ($ressource->getType() == 1 && $ressource->getStatut() == 1) {
                        $ressource->setStatut(2);
                    }
                    $ressource_repo->updateRessource($ressource);
                } catch (Exception $exc) {
                    echo $exc->getTraceAsString();
                }

                return $this->redirect($this->generateUrl('gestion_projet_ressource_all'));
            }
        }

        return $this->render('GestionProjetBundle:formulaire:form.modification.ressource.html.twig', array(
                    'form' => $form->createView(), 'idressource' => $ressource->getId()
        ));
    }

    /**
     * @Route("/ressources/{id}", name="gestion_projet_ressource_all",requirements={"id" = "\d+"})
     * @Method({"GET"})
     */
    public function getAllRessourcesAction(Intervenant $intervenant) {
		
        return $this->render("GestionProjetBundle:documentation:documentation.template.html.twig", array("intervenant" => $intervenant));
    }

    public function getRessourcesExecution() {

        $em = $this->getDoctrine()->getManager();

        $ressources_repo = $em->getRepository('GestionProjetBundle:Ressource');

        $ressources = $ressources_repo->findByType(1);

        return $this->render("GestionProjetBundle:documentation:liste.documents.executifs.template.html.twig", array("ressources" => $ressources));
    }

    public function getRessourcesAdministratifsAction($idintervenant) {
		$id = (int)$idintervenant;
        $em = $this->getDoctrine()->getManager();
        $ressources_repo = $em->getRepository('GestionProjetBundle:Ressource');
		$repositoryIntervenant = $em->getRepository('GestionProjetBundle:Intervenant');
		$intervenant = $repositoryIntervenant->find($id);
        $ressources = $ressources_repo->findBy(array('statut' => 1, 'type' => 0, 'idintervenant' => $intervenant));

        return $this->render("GestionProjetBundle:formulaire:liste.documents.administratifs.template.html.twig", array("ressources" => $ressources, "intervenant" => $intervenant));
    }
	
	/**
     * @Route("/documents-execution-valides/{id}", name="gestion_projet_documents_execution_valide",requirements={"id" = "\d+"})
     * @Method({"GET"})
     */
    public function getRessourcesValidesAction(Intervenant $intervenant) {
		//$id = (int)$idintervenant;
        $em = $this->getDoctrine()->getManager();

        $ressources_repo = $em->getRepository('GestionProjetBundle:Ressource');
		//$repositoryIntervenant = $em->getRepository('GestionProjetBundle:Intervenant');
		//$intervenant = $repositoryIntervenant->find($id);
        $ressources = $ressources_repo->findBy(array('statut' => 3, 'type' => 1, 'idintervenant' => $intervenant));

        return $this->render("GestionProjetBundle:formulaire:liste.documents.valides.maxi.template.html.twig", array("ressources" => $ressources, "intervenant" => $intervenant));
    }
	
	/**
     * @Route("/documents-execution-non-valides/{id}", name="gestion_projet_documents_execution_non_valide",requirements={"id" = "\d+"})
     * @Method({"GET"})
     */
    public function getRessourcesNonValidesAction(Intervenant $intervenant) {
		//$id = (int)$idintervenant;
        $em = $this->getDoctrine()->getManager();

        $ressources_repo = $em->getRepository('GestionProjetBundle:Ressource');
		//$repositoryIntervenant = $em->getRepository('GestionProjetBundle:Intervenant');
		//$intervenant = $repositoryIntervenant->find($id);
        $ressources = $ressources_repo->findBy(array('statut' => 2, 'type' => 1, 'idintervenant' => $intervenant));

        return $this->render("GestionProjetBundle:formulaire:liste.documents.nonvalides.maxi.template.html.twig", array("ressources" => $ressources, "intervenant" => $intervenant));
    }
    
    /**
     * @Route("/ressource/administratifs/{id}", name="gestion_projet_ressource_administratifs",requirements={"id" = "\d+"})
     * @Method({"GET"})
     */
    public function getAllRessourcesAdministratifsForIntervenantAction(Intervenant $intervenant) {

        $em = $this->getDoctrine()->getManager();

        $ressources_repo = $em->getRepository('GestionProjetBundle:Ressource');

        $ressources = $ressources_repo->findBy(array('statut' => 1, 'type' => 0, 'idintervenant' => $intervenant));

        return $this->render("GestionProjetBundle:formulaire:liste.documents.administratifs.maxi.template.html.twig", array("ressources" => $ressources, "intervenant" => $intervenant));
    }

    /**
     * @Route("/ressource/valides", name="gestion_projet_ressource_valides")
     * @Method({"GET"})
     */
    public function getAllRessourcesValidesAction() {

        $em = $this->getDoctrine()->getManager();

        $ressources_repo = $em->getRepository('GestionProjetBundle:Ressource');

        $ressources = $ressources_repo->findBy(array('statut' => 3, 'type' => 1));

        return $this->render("GestionProjetBundle:formulaire:liste.documents.valides.maxi.template.html.twig", array("ressources" => $ressources));
    }

    /**
     * @Route("/ressource/nonvalides", name="gestion_projet_ressource_nonvalides")
     * @Method({"GET"})
     */
    public function getAllRessourcesNonValidesAction() {

        $em = $this->getDoctrine()->getManager();

        $ressources_repo = $em->getRepository('GestionProjetBundle:Ressource');

        $ressources = $ressources_repo->findBy(array('statut' => 2, 'type' => 1));

        return $this->render("GestionProjetBundle:formulaire:liste.documents.nonvalides.maxi.template.html.twig", array("ressources" => $ressources));
    }

    /**
     * @Route("/ressource/ref={reference}", name="gestion_projet_ressource_reference")
     * @Method({"GET"})
     */
    public function getRessourcesByReferenceAction(Request $request, $reference) {

        $em = $this->getDoctrine()->getManager();

        $ressources_repo = $em->getRepository('GestionProjetBundle:Ressource');

        $ressources = $ressources_repo->findByReference($reference);

        render();
    }

    /**
     * @Route("/ressource/{id}", name="gestion_projet_ressource_unique",requirements={"id" = "\d+"})
     * @Method({"GET"})
     */
    public function getOneRessourceAction(Ressource $ressource) {

        render();
    }

    /**
     * @Route("/ressource/supprimer/{id}", name="gestion_projet_ressource_delete",requirements={"id" = "\d+"})
     * @Method({"GET"})
     */
    public function deleteRessourceAction(Ressource $ressource) {

        $em = $this->getDoctrine()->getManager();

        $ressource_repo = $em->getRepository('GestionProjetBundle:Ressource');

        try {
            $ressource_repo->deleteRessource($ressource);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $this->redirect($this->generateUrl('gestion_projet_ressource_all'));
    }

}
