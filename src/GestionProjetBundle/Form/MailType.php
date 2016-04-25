<?php

namespace GestionProjetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MailType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('objet')
            //->add('date', 'datetime')
            ->add('contenu')
            ->add('uploadedFiles', 'file', array(
                'multiple' => true, 
                'data_class' => null,
                ))
            ->add('destinataire', 'entity', array(
                'class' => 'UserBundle:Utilisateur',
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
            'data_class' => 'GestionProjetBundle\Entity\Mail'
        ));
    }
}
