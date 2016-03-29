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
    public function deleteProjet($projet) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->remove($projet);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveProjet($projet) {
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

    public function updateProjet($projet) {
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
