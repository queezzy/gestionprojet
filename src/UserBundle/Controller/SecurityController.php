<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\ProfileController as BaseController;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use GestionProjetBundle\Entity\Projet;
use UserBundle\Entity\Utilisateur;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\RememberMeToken;

class SecurityController extends BaseController {

    public function loginAction(Request $request) {
        /** @var $session \Symfony\Component\HttpFoundation\Session\Session */
        $session = $request->getSession();
        $repositoryProjet = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Projet");
        $projets = $repositoryProjet->findBy(array("statut" => 1));
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
            $csrfToken = $this->has('form.csrf_provider') ? $this->get('form.csrf_provider')->generateCsrfToken('authenticate') : null;
        }

        return $this->renderLogin(array(
                    'last_username' => $lastUsername,
                    'liste_projets' => $projets,
                    'error' => $error,
                    'csrf_token' => $csrfToken,
        ));
    }

    public function checkAction() {
        $request = $this->get('request');
        $user = new Utilisateur();
        $projetUser = new Projet();
        if ($request->isMethod('POST')) {
            $idprojet = htmlspecialchars(trim($request->request->get("_idprojet")));
            $username = htmlspecialchars(trim($request->request->get("_username")));
            $password = $request->request->get("_password");
            $rememberMe = $request->request->get("_remember_me");
            if (ctype_digit($idprojet)) {
                $idprojet = (int) $idprojet;
                $userManager = $this->get('fos_user.user_manager');
                $repositoryProjet = $this->getDoctrine()->getManager()->getRepository("GestionProjetBundle:Projet");
                $user = $userManager->findUserBy(array("username" => $username));
                $projet = $repositoryProjet->find($idprojet);
                if ($user) {
                    $encoder_service = $this->get('security.encoder_factory');
                    $encoder = $encoder_service->getEncoder($user);
                    if ($encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt())) {
                        $projetsUser = $repositoryProjet->findBy(array("statut" => 1));
                        $i = 0;
                        $trouve = false;
                        while ($i < count($projetsUser) && !$trouve) {
                            $projetUser = $projetsUser[$i];
                            if ($projetUser->getId() == $projet->getId()) {
                                $trouve = true;
                            }
							$i++;
                        }
                        if ($trouve) {
                            $user->setProjetActif($projet);
							$request->getSession()->set('projetactif', $projet);
                            $firewallName = $this->container->getParameter('fos_user.firewall_name');

                            $token = new UsernamePasswordToken($user, $user->getPassword(), $firewallName, $user->getRoles());
                            $this->get('security.context')->setToken($token);
                            $request->getSession()->set('_security_main', serialize($token));

                            $url = $this->generateUrl('gp_accueil');
                            $redirectResponse = new RedirectResponse($url);
                            if ($rememberMe == "on") {
                                //Remember me
                                $providerKey = $this->container->getParameter('fos_user.firewall_name');
                                $securityKey = $this->container->getParameter('secret');

                                $token2 = new RememberMeToken($user, $providerKey, $securityKey, $user->getRoles());
                                $this->container->get('security.context')->setToken($token2);
                                $redirectResponse->headers->setCookie(
                                        new \Symfony\Component\HttpFoundation\Cookie(
                                        'REMEMBERME', base64_encode(implode(':', array($user->getUsername(),
                                            $user->getPassword()))), time() + 60 * 60 * 24
                                        )
                                );
                            }
                            return $redirectResponse;
                            //return $this->redirect($url);
                        } else {
                            $url = $this->generateUrl('fos_user_security_login');
                            return $this->redirect($url);
                        }
                    }
                } else {
                    $url = $this->generateUrl('fos_user_security_login');
                    return $this->redirect($url);
                }
            } else {
                $url = $this->generateUrl('fos_user_security_login');
                return $this->redirect($url);
            }
        } else {
            $url = $this->generateUrl('fos_user_security_login');
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
    protected function renderLogin(array $data) {
        return $this->render('FOSUserBundle:Security:login.html.twig', $data);
    }

}
