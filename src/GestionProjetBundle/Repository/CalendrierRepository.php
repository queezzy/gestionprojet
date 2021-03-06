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
    
    
    public function deleteCalendrier(\GestionProjetBundle\Entity\Calendrier $calendrier) {
        $em= $this->_em;
        $calendrier->setStatut(0);
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


    public function saveCalendrier(\GestionProjetBundle\Entity\Calendrier $calendrier) {
        $em= $this->_em;
        $calendrier->setStatut(1);
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
    
    
    public function getEvent($from,$to) {

        $qb = $this->_em->createQueryBuilder();
        $qb->select('e')
                ->from('GestionProjetBundle:Calendrier', 'e')
                //->join('f.adresse', 'a')
                ->where("1=1");
                
        if ($from != null and $to !=null) {

            $qb->andWhere('e.datedebut between :deb and :fin')
                    ->setParameter('deb', $from)
                    ->setParameter('fin', $to);
        }
        

        var_dump($qb->getQuery());
        return
                        $qb->getQuery()
                        ->getResult();
    }

}
