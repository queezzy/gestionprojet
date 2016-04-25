<?php

namespace GestionProjetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PhotoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('intitule')
            ->add('url',null,array(
                'attr' => array('class'=>'inputfile')
            ))
			// ->add('idprojet', 'entity', array(
                // 'class' => 'GestionProjetBundle:Projet',
                // 'property' => 'code',
                // 'empty_value' => "Choisissez un projet"
            // ))
			->add('dateprise', 'date')
			->add('description')
            //->add('statut')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GestionProjetBundle\Entity\Photo'
        ));
    }
}