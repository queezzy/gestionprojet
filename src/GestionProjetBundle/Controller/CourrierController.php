<?php

namespace GestionProjetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use UserBundle\Entity\Utilisateur;
use GestionProjetBundle\Entity\Courier;
use GestionProjetBundle\Entity\Courierenvoye;
use GestionProjetBundle\Form\CourierType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Description of CourierController
 *
 * @author TONYE
 */
class CourrierController extends Controller {
    
    //put your code here
    /**
     * @Route("/couriers-envoyes")
     * @Template()
     * @param Request $request
     */
    public function courriersenvoyesAction(Request $request) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /*if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }*/
        $em = $this->getDoctrine()->getManager();

        $repositoryCourier = $em->getRepository("GestionProjetBundle:Courier");
        $repositoryIntervenant = $em->getRepository("GestionProjetBundle:Intervenant");
        $courier = new Courier();
        $form = $this->createForm(new CourierType(), $courier);
        $display_tab = 1;
        //selectionne le seul courier actif
        $couriers = $repositoryCourier->findBy(array("statut" => 1));
        $intervenants = $repositoryIntervenant->findBy(array("statut" => 1));
        
        return $this->render('GestionProjetBundle:Courier:courier_content_envoyes.html.twig', array('liste_couriers' => $couriers, 'liste_intervenants' => $intervenants, 'form' => $form->createView(), "display_tab" => $display_tab));
    }
    
    /**
     * @Route("/couriers-recus")
     * @Template()
     * @param Request $request
     */
    public function courriersrecusAction(Request $request) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /*if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }*/
        $user = $this->getUser();
        //selectionne le seul courier actif
        $couriersenvoyes= array();
        if(!$this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)){
            $couriersenvoyes = $user->getIdintervenant()->getCourierenvoyes();
        }
        return $this->render('GestionProjetBundle:Courier:courier_content_recus.html.twig', array('liste_couriers' => $couriersenvoyes));
    }
    
    /**
     * @Route("/add-courier")
     * @Template()
     * @param Request $request
     */
    public function addCourierAction(Request $request){
        /*if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }*/
        $courier = new Courier();
        $courierenvoye = new Courierenvoye();
        $form = $this->createForm(new CourierType(), $courier);
        $form->handleRequest($request);
        $repositoryCourier = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Courier");
         $repositoryIntervenant = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Intervenant");
        //$user = $this->getUser();
       // if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
            //if($request->isMethod('POST')){
                if($form->isValid()){           
                   try {
                       $destinataires= $request->request->get("destinataires");
                       foreach ($destinataires as $destinataire) {
                            $iddestinataire = (int)$destinataire;
                            $intervenant = $repositoryIntervenant->find($iddestinataire);
                            $courierenvoye= new Courierenvoye();
                            $courierenvoye->setIdintervenant($intervenant);
                            $courier->addCourierenvoye($courierenvoye);
                        }
                        $emetteur = $repositoryIntervenant->find(2);
                        $courier->setEmetteur($emetteur);
                       $repositoryCourier->saveCourier($courier);
                       $message = $this->get('translator')->trans('Courier.created_success', array(), "GestionProjetBundle");
                       $request->getSession()->getFlashBag()->add('message', $message);
                       return $this->redirect($this->generateUrl('gp_courier'));
                   } catch (Exception $ex){
                       $message = $this->get('translator')->trans('Courier.created_failure', array(), "GestionProjetBundle");
                       $request->getSession()->getFlashBag()->add('message_success', $message);
                       $couriers = array();
                       $display_tab =0;
                       return $this->render('GestionProjetBundle:Courier:courier_content.html.twig', array('liste_couriers' => $couriers, 'form' => $form->createView(), "display_tab" => $display_tab));
                   }
               }else{
                   $message = $this->get('translator')->trans('Courier.created_failure', array(), "GestionProjetBundle");
                       $request->getSession()->getFlashBag()->add('message_failure', $message);
                       $couriers = array();
                       $display_tab =0;
                       return $this->render('GestionProjetBundle:Courier:courier_content.html.twig', array('liste_couriers' => $couriers, 'form' => $form->createView(), "display_tab" => $display_tab));
               }
           // }
        /*}else{
            $message = $message = $this->get('translator')->trans('Courier.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }*/
    }
    
    /**
     * @Route("/update-courier/{id}")
     * @Template()
     */
    public function updatecourierAction(Courier $courier){
        /*if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }*/          
        $repositoryCourier = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Courier");
        $form = $this->createForm(new CourierType(), $courier); 
        $request = $this->get("request");
        $form->handleRequest($request);
        $user = $this->getUser();
        //if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
            if($request->isMethod('POST')){
                if($form->isValid()){           
                   try {
                       $repositoryCourier->updateCourier($courier);
                       $message = $this->get('translator')->trans('Courier.updated_success', array(), "GestionProjetBundle");
                       $request->getSession()->getFlashBag()->add('message_success', $message);
                       return $this->redirect($this->generateUrl('gp_courier'));
                   } catch (Exception $ex){
                       $message = $this->get('translator')->trans('Courier.updated_failure', array(), "GestionProjetBundle");
                       $request->getSession()->getFlashBag()->add('message_failure', $message);
                       $couriers = array();
                       $display_tab =0;
                       return $this->render('GestionProjetBundle:Courier:courier_content.html.twig', array('liste_couriers' => $couriers, 'form' => $form->createView(), "display_tab" => $display_tab));
                   }
               }else{
                    $request->getSession()->getFlashBag()->add('message_failure', $message);
                    $couriers = array();
                    $display_tab =0;
                    return $this->render('GestionProjetBundle:Courier:courier_content.html.twig', array('liste_couriers' => $couriers, 'form' => $form->createView(), "display_tab" => $display_tab));
               }
            }
       /* }else{
            $message = $message = $this->get('translator')->trans('Courier.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }*/

    }
    
    
    /**
     * @Route("/delete-courier/{id}")
     * @Template()
     */
    public function deletecourierAction(Courier $courier) {
        /*if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }*/
        $request = $this->get("request");
        //$user = new Utilisateur();
        $response = new JsonResponse();
        $repositoryCourier = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Courier");
        //if ($this->get('gp_bundle.service.role')->isGranted('ROLE_SUPER_ADMIN', $user)) {
            if ($request->isMethod('POST')) {
                $user = $this->getUser();
                try{
                    $repositoryCourier->deleteCourier($courier);
                    $message = $message = $this->get('translator')->trans('Courier.deleted_success', array(), "GestionProjetBundle");
                    $messages = array("letype" => "sucess", "message" => $message);
                    return $response->setData(array("data" => $messages));
                } catch (Exception $ex) {
                    $message = $message = $this->get('translator')->trans('Courier.deleted_failure', array(), "GestionProjetBundle");
                    $messages = array("letype" => "sucess", "message" => $message);
                    return $response->setData(array("data" => $messages));
                }                
            }
       /* }else {
            $message = $message = $this->get('translator')->trans('Courier.access_denied', array(), "GestionProjetBundle");
            $messages[] = array("letype" => "error", "message" => $message);
            return $response->setData(array("data" => $messages));
        }*/
    }
    
    /**
     * @Route("/get-courier/{id}")
     * @Template()
     */
    public function getcourierAction(Courier $courier) {
        /*if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }*/
        $request = $this->get("request");
         $form = $this->createForm(new CourierType(), $courier);
        $form->handleRequest($request);
 
        return $this->render('GestionProjetBundle:Courier:form.courier.html.twig', array('form' => $form->createView(), "idcourier" => $courier->getId()));
    }
    
    public function sendMailForCourrier(Courier $courrier){
        $message = \Swift_Message::newInstance()
               ->setSubject($courrier->getObjet())
               ->setFrom($courrier->getEmetteur()->getIdadresse()->getEmail());
    }

}
