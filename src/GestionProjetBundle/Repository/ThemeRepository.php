<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GestionProjetBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * Description of Theme
 *
 * @author TONYE
 */
class ThemeRepository extends EntityRepository{
    //put your code here
    public function deleteTheme($theme) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->remove($theme);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveTheme($theme) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($theme);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateTheme($theme) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($theme);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }
}
