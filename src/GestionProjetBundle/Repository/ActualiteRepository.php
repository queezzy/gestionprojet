<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GestionProjetBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * Description of ActualiteRepository
 *
 * @author TONYE
 */
class ActualiteRepository extends EntityRepository{
    //put your code here
    public function deleteActualite($actualite) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->remove($actualite);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveActualite($actualite) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($actualite);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateActualite($actualite) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($actualite);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }
}
