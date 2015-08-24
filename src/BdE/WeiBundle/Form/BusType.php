<?php
namespace BdE\WeiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
		->add('nom', 'text', array('required' => true))
		->add('nbPlaces', 'integer', array('required' => true))
            ->add('actions', 'form_actions', [
                'buttons' => [
                    'save' => ['type' => 'submit', 'options' => ['label' => 'button.save']],
                    'cancel' => ['type' => 'button', 'options' => ['label' => 'button.cancel','attr' => ['onclick'=>"history.back()"]]],
                ]
            ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'BdE\WeiBundle\Entity\Bus'));
    }

    public function getName()
    {
        return 'bus';
    }
}

