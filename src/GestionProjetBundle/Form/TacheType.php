<?php

namespace GestionProjetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TacheType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('datedebut', 'date')
            ->add('datefin', 'date')
            ->add('description')
            //->add('statut')
            ->add('idprojet', 'entity', array(
                'class' => 'GestionProjetBundle:Projet',
                'property' => 'code',
                'empty_value' => "Choisissez un projet",
                'mapped' => false,
                'property_path' => "false",
                'data' => 2
            ))
            ->add('idlot', 'entity', array(
                'class' => 'GestionProjetBundle:Lot',
                'property' => 'nom',
                'empty_value' => "Choisissez un lot",
                'mapped' => false,
                'property_path' => "false",
                'data' => 2
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GestionProjetBundle\Entity\Tache'
        ));
    }
}
