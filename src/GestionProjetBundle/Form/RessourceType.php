<?php

namespace GestionProjetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RessourceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reference')
            ->add('type')
            ->add('url')
            ->add('description')
            ->add('statut')
            ->add('file',null,array(
                'attr' => array('class'=>'inputfile')
            ))
            ->add('idintervenant','entity',array(
                'class'=> 'GestionProjetBundle\Entity\Intervenant',
                'property' => 'nom'
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GestionProjetBundle\Entity\Ressource'
        ));
    }
}
