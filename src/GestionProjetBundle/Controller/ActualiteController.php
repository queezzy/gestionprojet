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

/**
 * Description of ActualiteController
 *
 * @author Quentin
 */
class ActualiteController extends Controller {

     /**
     * @Route("/product/new", name="app_product_new")
     */
    public function newActualiteAction(Request $request,$actualite)
    {
        $actualite = new Actualite();
        $form = $this->createForm(ActualiteType::class, $actualite);
        $form->handleRequest($request);

        if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();

            $actu_repo = $em->getRepository('GestionProjetBundle:Actualite'); 
//            // $file stores the uploaded PDF file
//            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
//            $file = $product->getBrochure();
//
//            // Generate a unique name for the file before saving it
//            $fileName = md5(uniqid()).'.'.$file->guessExtension();
//
//            // Move the file to the directory where brochures are stored
//            $brochuresDir = $this->container->getParameter('kernel.root_dir').'/../web/uploads/brochures';
//            $file->move($brochuresDir, $fileName);
//
//            // Update the 'brochure' property to store the PDF file name
//            // instead of its contents
//            $product->setBrochure($fileName);

            // ... persist the $product variable or any other work
            
            try {
                $actu_repo->saveActualite($actualite);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            } 

            $request->getSession()->getFlashBag()->add('notice', 'Actualite bien enregistrée.');
            return $this->redirect($this->generateUrl('gp_accueil'));
        }
        
        return $this->render('product/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
     public function updateActualiteAction(Actualite $actu){
        
    $request = $this->get('request');

    $em = $this->getDoctrine()->getEntityManager();
    $actu_repo = $em->getRepository('GestionProjetBundle:Actualite');
    $form = $this->createForm(new \GestionProjetBundle\Form\ActualiteType(), $actu);

    if ($request->getMethod() == 'POST') {
        $form->handleRequest($request);

        if ($form->isValid()) {
            
            try {
                $actu_repo->updateActualite($actu);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }

            return $this->redirect($this->generateUrl('MyBundle_list_testimonials'));
        }
    }

    return $this->render('MyBundle:Testimonial:update.html.twig', array(
        'form' => $form->createView()
    ));
    }
    
    public function getAllActualitesAction(Request $request){
        
            $em = $this->getDoctrine()->getManager();

            $actu_repo = $em->getRepository('GestionProjetBundle:Actualite');
            
            $actualites=$actu_repo->findByStatus(0);
            
            render();
    }
    
    public function getOneActualiteAction(Actualite $actualite){
        
        
        render();
    }
}
