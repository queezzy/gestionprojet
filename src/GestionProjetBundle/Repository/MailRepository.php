<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GestionProjetBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * Description of MailRepository
 *
 * @author TONYE
 */
class MailRepository extends EntityRepository{
    //put your code here
    public function deleteMail(\GestionProjetBundle\Entity\Mail $mail) {
        $em= $this->_em;
        $mail->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->remove($mail);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveMail(\GestionProjetBundle\Entity\Mail $mail) {
        $em= $this->_em;
        $mail->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($mail);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateMail(\GestionProjetBundle\Entity\Mail $mail) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($mail);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }
}


