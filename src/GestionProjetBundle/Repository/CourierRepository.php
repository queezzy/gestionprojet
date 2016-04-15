<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GestionProjetBundle\Repository;

use Doctrine\ORM\EntityRepository;
use GestionProjetBundle\Entity\Courierenvoye;
/**
 * Description of CourierRepository
 *
 * @author TONYE
 */
class CourierRepository extends EntityRepository{
    //put your code here
    public function deleteCourier(\GestionProjetBundle\Entity\Courier $courier) {
        $em= $this->_em;
        $courier->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($courier);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveCourier(\GestionProjetBundle\Entity\Courier $courier) {
        $em= $this->_em;
        $courier->setStatut(1);
        $courierenvoye = new Courierenvoye();
        $repositoryCourierenvoye = $em->getRepository("GestionProjetBundle:Courierenvoye");
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($courier);
            $em->flush();
            //$idcourier = $em->getConnection()->lastInsertId();
            $couriersenvoyes = $courier->getCourierenvoyes();
            foreach ($couriersenvoyes as $courierenvoye) {
                $courierenvoye->setIdcourier($courier);
                $repositoryCourierenvoye->updateCourierenvoye($courierenvoye);
            }
            $em->getConnection()->commit(); 
            
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateCourier(\GestionProjetBundle\Entity\Courier $courier) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($courier);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }
}
