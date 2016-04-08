<?php

namespace GestionProjetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjetType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code')
            ->add('intitule')
            ->add('description')
            ->add('datedebut', 'datetime', array('required' => false,'widget' =>'single_text', 'format' =>'yyyy/MM/dd hh:mm:ss'))
            ->add('datefin', 'datetime', array('required' => false,'widget' =>'single_text', 'format' =>'yyyy/MM/dd hh:mm:ss'))
            ->add('budget')
            ->add('demandeur')
            ->add('evolutionattendu')
            ->add('evolutionencours')
            ->add('statut')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GestionProjetBundle\Entity\Projet'
        ));
    }
}
