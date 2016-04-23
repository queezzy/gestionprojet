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
use \GestionProjetBundle\Form\ActualiteType;
use \GestionProjetBundle\Entity\Actualite;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Description of ActualiteController
 *
 * @author Quentin
 */
class ActualiteController extends Controller {

    /**
	 * @Security("has_role('ROLE_ADMIN_ACTIF')")
     * @Route("/actualite/ajouter", name="gestion_projet_actualite_new")
      @Method({"GET","POST"})
     */
    public function newActualiteAction(Request $request) {
        $actualite = new Actualite();
        $form = $this->createForm(ActualiteType::class, $actualite);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $actu_repo = $em->getRepository('GestionProjetBundle:Actualite');

            try {
                $user = $this->container->get('security.context')->getToken()->getUser();
                $actualite->setUtilisateur($user);
                $actu_repo->saveActualite($actualite);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }

            $request->getSession()->getFlashBag()->add('notice', 'Actualite bien enregistrée.');
            return $this->redirect($this->generateUrl('gestion_projet_actualite_all'));
        }

        return $this->render('GestionProjetBundle:formulaire:form.creation.actualite.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    /**
	* @Security("has_role('ROLE_ADMIN_ACTIF')")
     * @Route("/actualite/modifier/{id}", name="gestion_projet_actualite_update",requirements={"id" = "\d+"})
     * @Method({"GET","POST"})
     */
    public function updateActualiteAction(Actualite $actu) {

        $request = $this->get('request');

        $em = $this->getDoctrine()->getEntityManager();
        $actu_repo = $em->getRepository('GestionProjetBundle:Actualite');
        $form = $this->createForm(new \GestionProjetBundle\Form\ActualiteType(), $actu);

        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            if ($form->isValid()) {

                try {

//                    $actu_bd=$actu_repo->find($actu->getIdactualite());
//                    
//                    $actu_bd->setContenu($actu->getContenu());
//                    $actu_bd->setDatepublication($actu->getDatepublication());
//                    $actu_bd->setDescription($actu->getDescription());
//                    $actu_bd->setIdtheme($actu->getIdtheme());
//                    $actu_bd->setTitre($actu->getTitre());
//                    
//                    if($actu->getFile() != null){
//                    
//                        $actu_bd->setFile($actu->getFile());
//                    }
//                    $actu_bd->setStatut($actu->getStatut());
//                    

                    $actu_repo->updateActualite($actu);
                } catch (Exception $exc) {
                    echo $exc->getTraceAsString();
                }

                return $this->redirect($this->generateUrl('gestion_projet_actualite_all'));
            }
        }

        return $this->render('GestionProjetBundle:formulaire:form.modification.actualite.html.twig', array(
                    'form' => $form->createView(), 'idactualite' => $actu->getId()
        ));
    }

    /**
     * @Route("/actualites", name="gestion_projet_actualite_all")
     * @Method({"GET"})
     */
    public function getAllActualitesAction() {
		if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }

        return $this->render('GestionProjetBundle:actualite:actualite.template.html.twig');
    }

    public function getActualitesAction($nbre_actualite = 0) {

        if ($nbre_actualite == 0) {

            $em = $this->getDoctrine()->getManager();

            $actu_repo = $em->getRepository('GestionProjetBundle:Actualite');

            try {
                $actualites = $actu_repo->findByStatut(1);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }



            return $this->render('GestionProjetBundle:formulaire:liste.actualite.template.html.twig', array("actualites" => $actualites));
        } else {
            $em = $this->getDoctrine()->getManager();

            $actu_repo = $em->getRepository('GestionProjetBundle:Actualite');

            try {
                $actualites = $actu_repo->findBy(array("statut" => 1), null, $nbre_actualite);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }



            return $this->render('GestionProjetBundle:formulaire:liste.actualite.mini.html.twig', array("actualites" => $actualites));
        }
    }

    /**
     * @Route("/actualite/{id}", name="gestion_projet_actualite_unique",requirements={"id" = "\d+"})
     * @Method({"GET"})
     */
    public function getOneActualiteAction(Actualite $actualite) {
		if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }

        return $this->render('GestionProjetBundle:formulaire:form.affichage.actualite.html.twig', array("actualite" => $actualite));
    }

    /**
	 * @Security("has_role('ROLE_ADMIN_ACTIF')")
     * @Route("/actualite/supprimer/{id}", name="gestion_projet_actualite_delete",requirements={"id" = "\d+"})
     * @Method({"GET"})
     */
    public function deleteActualiteAction(Actualite $actualite) {

        $em = $this->getDoctrine()->getManager();

        $actu_repo = $em->getRepository('GestionProjetBundle:Actualite');
		if(! $user->getId()== $actualite->getUtilisateur()->getId()){
             throw $this->createAccessDeniedException('Vous ne pouvez pas supprimez cette actualite!');
        }
        try {
            $actu_repo->deleteActualite($actualite);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

        return $this->redirect($this->generateUrl('gestion_projet_actualite_all'));
    }

}
