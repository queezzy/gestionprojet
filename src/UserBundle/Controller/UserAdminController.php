<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use GestionProjetBundle\Entity\Projet;
use UserBundle\Entity\Utilisateur;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\RememberMeToken;
/**
 * Description of UserAdminController
 *
 * @author TONYE
 */
class UserAdminController extends controller{
    //put your code here
	
	public function loginAction(Request $request)
    {
        /** @var $session \Symfony\Component\HttpFoundation\Session\Session */
        $session = $request->getSession();
        if (class_exists('\Symfony\Component\Security\Core\Security')) {
            $authErrorKey = Security::AUTHENTICATION_ERROR;
            $lastUsernameKey = Security::LAST_USERNAME;
        } else {
            // BC for SF < 2.6
            $authErrorKey = SecurityContextInterface::AUTHENTICATION_ERROR;
            $lastUsernameKey = SecurityContextInterface::LAST_USERNAME;
        }

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        if ($this->has('security.csrf.token_manager')) {
            $csrfToken = $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue();
        } else {
            // BC for SF < 2.4
            $csrfToken = $this->has('form.csrf_provider')
                ? $this->get('form.csrf_provider')->generateCsrfToken('authenticate')
                : null;
        }

        return $this->renderLogin(array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
        ));
    }
	
    public function checkAction()
    {
		$request = $this->get('request');
		$user = new Utilisateur();
        if ($request->isMethod('POST')) {
            $username = htmlspecialchars(trim($request->request->get("_username")));
            $password = $request->request->get("_password");
			$rememberMe = $request->request->get("_remember_me");
			$userManager = $this->get('fos_user.user_manager');
			$user = $userManager->findUserBy(array("username" => $username));
			if ($user) {
				$encoder_service = $this->get('security.encoder_factory');
				$encoder = $encoder_service->getEncoder($user);
				if ($encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt())) {
					$user->setProjetActif(null);				
					$firewallName = $this->container->getParameter('fos_user.firewall_name');
			
					$token = new UsernamePasswordToken($user, $user->getPassword(), $firewallName, $user->getRoles());
					$this->get('security.context')->setToken($token);
					$request->getSession()->set('_security_main', serialize($token));
					
					
					$url = $this->generateUrl('gp_projet_admin');
					$redirectResponse = new RedirectResponse($url);
					if($rememberMe == "on"){
						//Remember me
						$providerKey = $this->container->getParameter('fos_user.firewall_name');
						$securityKey = $this->container->getParameter('secret');

						$token2 = new RememberMeToken($user, $providerKey, $securityKey,
						$user->getRoles());
						$this->container->get('security.context')->setToken($token2);
						$redirectResponse->headers->setCookie(
						   new \Symfony\Component\HttpFoundation\Cookie(
							   'REMEMBERME',
							   base64_encode(implode(':', array($user->getUsername(),
						$user->getPassword()))),
							   time() + 60*60*24
						   )
						);
					}
					return $redirectResponse;
					//return $this->redirect($url);
				}else{
					$url = $this->generateUrl('gp_login');
					return $this->redirect($url);
				}		
			}else{
				$url = $this->generateUrl('gp_login');
				return $this->redirect($url);
			}
            
        }else{
            $url = $this->generateUrl('gp_login');
            return $this->redirect($url);
        }
    }
	
	/**
     * Renders the login template with the given parameters. Overwrite this function in
     * an extended controller to provide additional data for the login template.
     *
     * @param array $data
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderLogin(array $data)
    {
        return $this->render('UserBundle:Security:loginadmin.html.twig', $data);
    }
}
