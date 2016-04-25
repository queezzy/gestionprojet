<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GestionProjetBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * Description of CourierenvoyeRepository
 *
 * @author TONYE
 */
class CourierenvoyeRepository extends EntityRepository{
    //put your code here
    public function deleteCourierenvoye(\GestionProjetBundle\Entity\Courierenvoye $courierenvoye) {
        $em= $this->_em;
        $courierenvoye->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($courierenvoye);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveCourierenvoye(\GestionProjetBundle\Entity\Courierenvoye $courierenvoye) {
        $em= $this->_em;
        $courierenvoye->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($courierenvoye);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateCourierenvoye(\GestionProjetBundle\Entity\Courierenvoye $courierenvoye) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($courierenvoye);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }
    
}
