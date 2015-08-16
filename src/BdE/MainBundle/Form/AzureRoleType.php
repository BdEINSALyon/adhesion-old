<?php

namespace BdE\MainBundle\Form;

use BdE\MainBundle\Security\Core\Azure;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AzureRoleType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('azureGid','choice',array(
                'choices'=>$options["azure_groups"]
            ))
            ->add('roles', 'choice', array(
                'choices' =>
                    array(
                        'ROLE_CONSULT' => 'Consultation',
                        'ROLE_SOIREE' => 'Entree Soiree',
                        'ROLE_PERM' => 'Permanencier',
                        'ROLE_COWEI' => 'CoWEI',
                        'ROLE_MODO' => 'Moderateur',
                        'ROLE_ADMIN' => 'Admin'
                    ),
                'multiple'  => true)
            )
            ->add("send","submit", array(
                'label' => "Ajouter"
            ))
        ;

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BdE\MainBundle\Entity\AzureRole',
            'azure_groups' => array()
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bde_mainbundle_azurerole';
    }
}
