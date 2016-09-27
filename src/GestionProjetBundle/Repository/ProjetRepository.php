<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GestionProjetBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * Description of ProjetRepository
 *
 * @author TONYE
 */
class ProjetRepository extends EntityRepository{
    //put your code here
    public function deleteProjet(\GestionProjetBundle\Entity\Projet $projet) {
        $em= $this->_em;
        $projet->setStatut(0);
        $intervenant = new \GestionProjetBundle\Entity\Intervenant();
        $repositoryPhoto = $em->getRepository("GestionProjetBundle:Photo");
        $photo = new \GestionProjetBundle\Entity\Photo();
        $repositoryTheme = $em->getRepository("GestionProjetBundle:Theme");
        $theme = new \GestionProjetBundle\Entity\Theme();
        $repositoryIntervenant = $em->getRepository("GestionProjetBundle:Theme");
        $em->getConnection()->beginTransaction();
        try{
            $intervenants = $projet->getIntervenants();
            foreach ($intervenants as $intervenant) {
                $repositoryIntervenant->deleteIntervenant($intervenant);
            }
            $themes = $projet->getThemes();
            foreach ($themes as $theme) {
                $repositoryTheme->deleteTheme($theme);
            }
            $photos = $projet->getPhotos();
            foreach ($photo as $photos) {
                $repositoryPhoto->deletePhoto($photo);
            }
            $em->persist($projet);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveProjet(\GestionProjetBundle\Entity\Projet $projet) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        $projet->setStatut(1);
        try{
            $em->persist($projet);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateProjet(\GestionProjetBundle\Entity\Projet $projet) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($projet);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }
}
