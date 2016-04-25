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
class PhotoRepository extends EntityRepository{
    //put your code here
    public function deletePhoto(\GestionProjetBundle\Entity\Photo $photo) {
        $em= $this->_em;
        $photo->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($photo);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function savePhoto(\GestionProjetBundle\Entity\Photo $photo) {
        $em= $this->_em;
        $photo->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($photo);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updatePhoto(\GestionProjetBundle\Entity\Photo $photo) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($photo);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }
	
	public function getAnneesPhotos($idprojet) {
        try{
            return $this->_em->createQuery('SELECT DISTINCT YEAR(p.dateprise)  FROM GestionProjetBundle:Photo p WHERE p.statut = 1 AND idprojet = :idprojet ORDER BY YEAR(p.dateprise)')
                    ->setParameter('idprojet', $idprojet)
                    ->getResult();
        } catch (NoResultException $ex) {
            return null;
        }
    }
	
	public function getPhotoAnnuels($idprojet, $annee) {
        try{
            return $this->_em->createQuery('SELECT  p  FROM GestionProjetBundle:Photo p  WHERE  p.statut = 1 AND YEAR(p.dateprise)= :annee AND idprojet = :idprojet ORDER BY p.dateprise')
                    ->setParameter('idprojet', $idprojet)
                    ->setParameter('annee', $annee)
                    ->getScalarResult();
        } catch (NoResultException $ex) {
            return null;
        }
    }
}

