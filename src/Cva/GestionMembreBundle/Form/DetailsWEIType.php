<?php
// src/Cva/GestionMembreBundle/Form/Type/DetailsWEIType.php
namespace Cva\GestionMembreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DetailsWEIType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
		->add('bus', 'text', array('required' => false))
		->add('bungalow', 'text', array('required' => false));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Cva\GestionMembreBundle\Entity\DetailsWEI'));
    }

    public function getName()
    {
        return 'detailsWEI';
    }
}

