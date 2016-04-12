<?php

namespace GestionProjetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class ProjetType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', HiddenType::class)
            ->add('code')
            ->add('intitule')
            ->add('description')
            ->add('datedebut', 'date')
            ->add('datefin', 'date')
            ->add('budget')
            ->add('demandeur')
            ->add('evolutionattendu')
            ->add('evolutionencours')
            ->add('statut','choice', array('choices' => array(1 => "activé", 0 => "desactivé"),
                                        'multiple' => false,
                                        'expanded' => true,
                                        'preferred_choices' => array(2),
                                        'empty_value' => '- Choisissez un statut -',
                                        'empty_data'  => -1
                                        ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {      
        $resolver->setDefaults(array(
            'data_class' => 'GestionProjetBundle\Entity\Projet',
           'csrf_protection' => true,
           'csrf_field_name' => '_token',
          // a unique key to help generate the secret token
          'intention'       => 'task_item_intention',
        )); 
    }
}
