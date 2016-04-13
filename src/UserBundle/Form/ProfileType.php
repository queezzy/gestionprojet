<?php
namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProfileType
 *
 * @author Quentin
 */
class ProfileType extends AbstractType{
 
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('fonction')
            ->add('titre')
            ->add('telephone')
            ->add('personnelcle')
            ->add('idintervenant','entity',array(
                'class'=> 'GestionProjetBundle\Entity\Intervenant',
                'property' => 'nom'
            ))
            ->add('roles', 'choice', array(
                       'label' => 'Privileges',
                       'expanded' => true,
                       'multiple' => true,
                       'expanded' => true,
                       'choices' => array(
                           'ROLE_SUPER_ADMIN' => 'Admin',
                           'ROLE_ADMIN_ACTIF' => 'Actif',
                           'ROLE_USER_PASSIF' => 'Passif'
                   )
               )
           )
           ->add('file',null,array(
                'attr' => array('class'=>'inputfile')
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\Utilisateur'
        ));
    }
    
    
    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }

    public function getBlockPrefix()
    {
        return 'app_user_profile';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }}
