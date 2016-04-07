<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GestionProjetBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * Description of ProjetRepository
 *
 * @author TONYE
 */
class ProjetRepository extends EntityRepository{
    //put your code here
    public function deleteProjet(\GestionProjetBundle\Entity\Projet $projet) {
        $em= $this->_em;
        $projet->setStatut(0);
        $intervenant = new \GestionProjetBundle\Entity\Intervenant();
        $repositoryIntervenant = $em->getRepository("GestionProjetBundle:Intervenant");
        $em->getConnection()->beginTransaction();
        try{
            $intervenants = $projet->getIntervenants();
            foreach ($intervenants as $intervenant) {
                $repositoryIntervenant->deleteIntervenant($intervenant);
            }
            $em->persist($projet);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveProjet(\GestionProjetBundle\Entity\Projet $projet) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($projet);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateProjet(\GestionProjetBundle\Entity\Projet $projet) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($projet);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }
}
