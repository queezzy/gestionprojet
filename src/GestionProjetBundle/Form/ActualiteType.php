<?php

namespace GestionProjetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActualiteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('datepublication')
            ->add('contenu')
            ->add('description')
            ->add('statut')
            ->add('idtheme','entity',array(
                'class'=> 'GestionProjetBundle\Entity\Theme',
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
            'data_class' => 'GestionProjetBundle\Entity\Actualite'
        ));
    }
}
