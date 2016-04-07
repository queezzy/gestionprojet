<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GestionProjetBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * Description of LotRepository
 *
 * @author TONYE
 */
class LotRepository extends EntityRepository{
    //put your code here
    public function deleteLot(\GestionProjetBundle\Entity\Lot $lot) {
        $em= $this->_em;
        $lot->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($lot);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveLot(\GestionProjetBundle\Entity\Lot $lot) {
        $em= $this->_em;
        $lot->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($lot);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateLot(\GestionProjetBundle\Entity\Lot $lot) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($lot);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }
}

