<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GestionProjetBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * Description of UtilisateurRepository
 *
 * @author TONYE
 */
class UtilisateurRepository extends EntityRepository{
    //put your code here
    public function deleteUtilisateur($utilisateur) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->remove($utilisateur);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveUtilisateur($utilisateur) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($utilisateur);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateUtilisateur($utilisateur) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($utilisateur);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }
}

