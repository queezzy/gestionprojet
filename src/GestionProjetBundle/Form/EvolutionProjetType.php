<?php

namespace GestionProjetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class EvolutionProjetType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('evolutionattendu')
            ->add('evolutionencours')
           
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
