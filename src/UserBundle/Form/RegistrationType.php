<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use GestionProjetBundle\Repository\IntervenantRepository;

class RegistrationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('fonction')
            ->add('titre')
            ->add('telephone')
            ->add('personnelcle','choice',array('choices'=> array(
                false => 'Non',
                true => 'Oui',
                
            )))
            ->add('file',null,array(
                'attr' => array('class'=>'inputfile')
            ))
            ->add('idintervenant','entity',array(
                'class'=> 'GestionProjetBundle\Entity\Intervenant',
                'property' => 'nom',
				'empty_value' => 'Choisir un intervenant',
				'multiple'=>false,
                'query_builder' => function(IntervenantRepository $repo) {
                    return $repo->getIntervenantQueryBuilder();
                }
            ))
            
            
           ->add('roles', 'choice', array(
                       'label' => 'Privileges',
                       'multiple' => true,
                       'expanded' => true,
                       'choices' => array(
                           'ROLE_SUPER_ADMIN' => 'Super Administrateur',
                           'ROLE_ADMIN_ACTIF' => 'Administrateur de l\'intervenant',
                           'ROLE_USER_PASSIF' => 'Simple utilisateur'
                   )
               )
           );
        
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\Utilisateur'
        ));
    }
    
     public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
