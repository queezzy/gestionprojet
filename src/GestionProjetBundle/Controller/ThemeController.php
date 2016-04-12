<?php

namespace GestionProjetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GestionProjetBundle\Form\ThemeType;
use GestionProjetBundle\Entity\Theme;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ThemeController extends Controller
{
    /**
     * @Route("/theme/ajouter", name="gestion_projet_theme_new")
       @Method({"GET","POST"})
     */
    public function addThemeAction(Request $request)
    {
        $theme = new Theme();
        $form = $this->createForm(ThemeType::class, $theme);
        $form->handleRequest($request);

        if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();

            $theme_repo = $em->getRepository('GestionProjetBundle:Theme'); 

            try {
                $theme_repo->saveTheme($theme);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            } 

            $request->getSession()->getFlashBag()->add('notice', 'Theme bien enregistrée.');
            return $this->redirect($this->generateUrl('gestion_projet_actualite_all'));
        }
        
        return $this->render('GestionProjetBundle:formulaire:form.creation.theme.html.twig', array(
            'form' => $form->createView(),
        ));
       
    }

    /**
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

            return $this->redirect($this->generateUrl('gestion_projet_actualite_all'));
        }
    }  
        return $this->render('GestionProjetBundle:formulaire:form.modification.theme.html.twig', array(
                    'form' => $form->createView(),'idtheme'=>$theme->getIdtheme()
        ));
    }

    /**
     * @Route("/listTheme")
     */
    public function listThemeAction()
    {
         $em = $this->getDoctrine()->getManager();

           $theme_repo = $em->getRepository('GestionProjetBundle:Theme');
            
            try {
                $themes = $theme_repo->findByStatut(0);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }



            return $this->render('GestionProjetBundle:Theme:liste.theme.html.twig');
        
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
     * @Route("/listOneTheme/{id}",name="gestion_projet_theme_unique",requirements={"id" = "\d+"})
     */
    public function listOneThemeAction(Theme $theme)
    {
        
        return $this->render('GestionProjetBundle:actualite:actualite.template.html.twig', array('actualites'=>$theme->getActualites()
        ));
    }
    
     /**
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
        return $this->redirect($this->generateUrl('gestion_projet_actualite_all'));        
    }

}
