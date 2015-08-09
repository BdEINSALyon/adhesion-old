<?php
namespace BdE\WeiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BungalowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
		->add('nom', 'text', array('required' => true))
        ->add('sexe', 'choice', array('choices' => array('F' => 'F','M' => 'M', "ND" =>'Non Determiné'),'required'  => false, 'expanded' => false,'empty_value' => false ))
		->add('nbPlaces', 'integer', array('required' => true));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'BdE\WeiBundle\Entity\Bungalow'));
    }

    public function getName()
    {
        return 'bungalow';
    }
}

