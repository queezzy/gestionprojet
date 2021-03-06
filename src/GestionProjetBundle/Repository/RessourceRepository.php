<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GestionProjetBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * Description of RessourceRepository
 *
 * @author TONYE
 */
class RessourceRepository extends EntityRepository{
    //put your code here
    public function deleteRessource(\GestionProjetBundle\Entity\Ressource $ressource) {
        $em= $this->_em;
        $ressource->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($ressource);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveRessource(\GestionProjetBundle\Entity\Ressource $ressource) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($ressource);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateRessource(\GestionProjetBundle\Entity\Ressource $ressource) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($ressource);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }
}