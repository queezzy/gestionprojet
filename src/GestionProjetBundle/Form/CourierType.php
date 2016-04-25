<?php

namespace GestionProjetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourierType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('type')
            //->add('date', 'datetime')
            ->add('objet')
            //->add('reference')
            ->add('contenu')
            //->add('statut')
            ->add('file',null,array(
                'attr' => array('class'=>'inputfile')
            ))
            ->add('uploadedFiles', 'file', array(
                'multiple' => true, 
                'data_class' => null,
                ))
            //->add('emetteur')
            ->add('courierreference', 'entity', array(
                'class' => 'GestionProjetBundle:Courier',
                'property' => 'reference',
                'empty_value' => "Courier de reference",
                //'mapped' => false,
                //'property_path' => "false",
                //'data' => 2
            ))
            ->add('destinataire', 'entity', array(
                'class' => 'GestionProjetBundle:Intervenant',
                'property' => 'nom',
                'empty_value' => "Destinataire",
                //'mapped' => false,
                //'property_path' => "false",
                //'data' => 2
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GestionProjetBundle\Entity\Courier'
        ));
    }
}
