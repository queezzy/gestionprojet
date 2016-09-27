<?php

namespace GestionProjetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GestionProjetBundle\Form\ThemeType;
use GestionProjetBundle\Entity\Theme;
use GestionProjetBundle\Entity\Projet;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ThemeController extends Controller
{
    /**
	 * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Route("/theme/ajouter/{id}", name="gestion_projet_theme_new")
       @Method({"GET", "POST"})
     */
    public function addThemeAction(Projet $projet)
    {
        $theme = new Theme();
		$request = $this->get("request");
        $form = $this->createForm(ThemeType::class, $theme);
        $form->handleRequest($request);

        if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();

            $theme_repo = $em->getRepository('GestionProjetBundle:Theme'); 

            try {
				$theme->setIdprojet($projet);
                $theme_repo->saveTheme($theme);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            } 

            $request->getSession()->getFlashBag()->add('notice', 'Theme bien enregistrée.');
            return $this->redirect($this->generateUrl('gestion_projet_theme_list', array("id" => $projet->getId())));
        }
        
        return $this->render('GestionProjetBundle:formulaire:form.creation.theme.html.twig', array(
            'form' => $form->createView(), 'projet' => $projet,
        ));
       
    }

    /**
	 * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Route("/theme/modifier/{id}", name="gestion_projet_theme_update",requirements={"id" = "\d+"})
     * @Method({"GET","POST"})
     */
    public function updateThemeAction(Theme $theme)
    {
        $request = $this->get('request');

    $em = $this->getDoctrine()->getEntityManager();
    $theme_repo = $em->getRepository('GestionProjetBundle:Theme');
    $form = $this->createForm(ThemeType::class, $theme);

    if ($request->getMethod() == 'POST') {
        $form->handleRequest($request);

        if ($form->isValid()) {
            
            try {
                $theme_repo->updateTheme($theme);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }

           return $this->redirect($this->generateUrl('gestion_projet_theme_list', array("id" => $projet->getId())));
        }
    }  
        return $this->render('GestionProjetBundle:formulaire:form.modification.theme.html.twig', array(
                    'form' => $form->createView(),'theme'=>$theme
        ));
    }

    /**
	 * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Route("/listTheme/{id}", name="gestion_projet_theme_list",requirements={"id" = "\d+"})
     */
    public function listThemeAction(Projet $projet)
    {
         $em = $this->getDoctrine()->getManager();

           $theme_repo = $em->getRepository('GestionProjetBundle:Theme');
            
            try {
                $themes = $theme_repo->findBy(array("idprojet" => $projet, "statut" => 1));
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }



            return $this->render('GestionProjetBundle:Theme:list_theme.html.twig', array("liste_themes" => $themes, "projet" => $projet));
        
    }
    
    public function getAllThemeAction(){
        
        $em = $this->getDoctrine()->getManager();

           $theme_repo = $em->getRepository('GestionProjetBundle:Theme');
            
            try {
                $themes = $theme_repo->findByStatut(1);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }


            return $this->render('GestionProjetBundle:formulaire:liste.theme.mini.html.twig',array("themes"=>$themes));
    }

    /**
	 * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Route("/listOneTheme/{id}",name="gestion_projet_theme_unique",requirements={"id" = "\d+"})
     */
    public function listOneThemeAction(Theme $theme)
    {
        $em = $this->getDoctrine()->getManager();

           $actualite_repo = $em->getRepository('GestionProjetBundle:Actualite');
		   $actualites = $actualite_repo->findBy(array("idtheme" => $theme, "statut" => 1));
        return $this->render('GestionProjetBundle:actualite:actualite.template.html.twig', array('actualites'=>$actualites
        ));
    }
    
     /**
	  * @Security("has_role('ROLE_SUPER_ADMIN')")
      * @Route("/theme/supprimer/{id}", name="gestion_projet_theme_delete",requirements={"id" = "\d+"})
      *@Method({"GET"})
     */
    
    public function deleteAThemeAction(Theme $theme){
    
        $em = $this->getDoctrine()->getManager();

        $theme_repo = $em->getRepository('GestionProjetBundle:Theme');
        
        try {
            $theme_repo->deleteTheme($theme);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $this->redirect($this->generateUrl('gestion_projet_theme_list', array("id" => $projet->getId())));        
    }

}
