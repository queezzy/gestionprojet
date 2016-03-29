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
    public function deleteIntervenant($intervenant) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->remove($intervenant);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveIntervenant($intervenant) {
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

    public function updateIntervenant($intervenant) {
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
