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
/**
 * Description of RessourceControlle
 *
 * @author Quentin
 */
class RessourceController extends Controller {
   
    public function newActualiteAction(Request $request)
    {
        $ressource = new Ressource();
        $form = $this->createForm(RessourceType::class, $ressource);
        $form->handleRequest($request);

        if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();

            $ressource_repo = $em->getRepository('GestionProjetBundle:Ressource'); 
            // $file stores the uploaded PDF file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $ressource->getUrl();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $brochuresDir = $this->container->getParameter('kernel.root_dir').'/../web/uploads/ressources';
            $file->move($brochuresDir, $fileName);

            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $ressource->setUrl($fileName);

            // ... persist the $product variable or any other work
            
            try {
                $actu_repo->saveRessource($ressource);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            } 

            $request->getSession()->getFlashBag()->add('notice', 'Actualite bien enregistrée.');
            return $this->redirect($this->generateUrl('gp_accueil'));
        }
        
        render();
    }
    
    public function getAllRessourcesAction(Request $request){
        
            $em = $this->getDoctrine()->getManager();

            $ressources_repo = $em->getRepository('GestionProjetBundle:Ressource');
            
            $ressources=$ressources_repo->findByStatus(0);
            
            render();
    }
    
    public function getOneRessourceAction(Ressource $ressource){
        
        
        render();
    }
}
