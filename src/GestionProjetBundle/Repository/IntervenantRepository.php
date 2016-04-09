<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GestionProjetBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * Description of IntervenantRepository
 *
 * @author TONYE
 */
class IntervenantRepository extends EntityRepository{
    //put your code here
    public function deleteIntervenant(\GestionProjetBundle\Entity\Intervenant $intervenant) {
        $em= $this->_em;
        $intervenant->setStatut(0);
        $calendrier = new \GestionProjetBundle\Entity\Calendrier();
        $courierenvoye = new \GestionProjetBundle\Entity\Courierenvoye();
        $utilisateur = new \UserBundle\Entity\Utilisateur();
        $ressource = new \GestionProjetBundle\Entity\Ressource();
        $repositoryCalendrier = $em->getRepository("GestionProjetBundle:Calendrier");
        $repositoryCourierenvoye = $em->getRepository("GestionProjetBundle:Courierenvoye");
        $repositoryRessource = $em->getRepository("GestionProjetBundle:Ressource");
        $userManager = $this->get('fos_user.user_manager');
        $em->getConnection()->beginTransaction();
        try{
            $calendriers = $intervenant->getCalendriers();
            foreach ($calendriers as $calendrier) {
                $repositoryCalendrier->deleteCalendrier($calendrier);
            }
            $couriersenvoyes = $intervenant->getCourierenvoyes();
            foreach ($couriersenvoyes as $courierenvoye) {
                $repositoryCourierenvoye->deleteCourierenvoye($courierenvoye);
            }
            $utilisateurs = $intervenant->getUtilisateurs();
            foreach ($utilisateurs as $utilisateur) {
                $userManager->deleteUser($utilisateur);
            }
            $ressources = $intervenant->getRessources();
            foreach ($ressources as $ressource) {
                $repositoryRessource->deleteRessource($ressource);
            }
            $em->persist($intervenant);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveIntervenant(\GestionProjetBundle\Entity\Intervenant $intervenant) {
        $em= $this->_em;
        $intervenant->setStatut(1);
        $intervenant->upload();
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($intervenant);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateIntervenant(\GestionProjetBundle\Entity\Intervenant $intervenant) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($intervenant);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }
}
