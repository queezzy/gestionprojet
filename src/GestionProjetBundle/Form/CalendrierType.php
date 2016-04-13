<?php

namespace GestionProjetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalendrierType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datedebut', 'datetime',array('date_widget' => "single_text", 'time_widget' => "single_text"))
            ->add('datefin', 'datetime',array('date_widget' => "single_text", 'time_widget' => "single_text"))
            ->add('titre')
            ->add('description')
            ->add('codecouleur','choice',array('choices'=> array(
                '#2D241E' => 'Noir',
                '#FF0000' => 'Rouge',
                '#C71585' => "Magenta",
                '#0000FF' => "Bleu Primaire"
            )))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GestionProjetBundle\Entity\Calendrier'
        ));
    }
}
