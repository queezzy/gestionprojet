<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GestionProjetBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * Description of CalendrierRepository
 *
 * @author TONYE
 */
class CalendrierRepository extends EntityRepository {
    //put your code here
    public function deleteCalendrier($calendrier) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->remove($calendrier);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveCalendrier($calendrier) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($calendrier);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateCalendrier($calendrier) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($calendrier);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }
}
