<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GestionProjetBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * Description of Tache
 *
 * @author TONYE
 */
class TacheRepository extends EntityRepository{
    //put your code here
    public function deleteTache(\GestionProjetBundle\Entity\Tache $tache) {
        $em= $this->_em;
        $tache->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($tache);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveTache(\GestionProjetBundle\Entity\Tache $tache) {
        $em= $this->_em;
        $tache->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($tache);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateTache(\GestionProjetBundle\Entity\Tache $tache) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($tache);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }
}