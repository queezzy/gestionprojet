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
    public function deleteActualite(\GestionProjetBundle\Entity\Actualite $actualite) {
        $em= $this->_em;
        $actualite->setStatut(0);
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


    public function saveActualite(\GestionProjetBundle\Entity\Actualite $actualite) {
        $em= $this->_em;
        $actualite->setStatut(1);
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

    public function updateActualite(\GestionProjetBundle\Entity\Actualite $actualite) {
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
    
    public function findRecentsActualites(\GestionProjetBundle\Entity\Projet $projet){
        try{
            return $this->_em->createQuery('SELECT a FROM GestionProjetBundle:Actualite a JOIN a.idtheme t JOIN t.idprojet p WHERE p.idprojet = :idprojet ORDER BY a.datepublication LIMIT 10')
                    ->setParameter("idprojet", $projet->getIdprojet())
                    ->getResult();
        } catch (NoResultException $ex) {
            return null;
        }
    }
}
