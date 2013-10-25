<?php

namespace Cva\GestionMembreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class resetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
		->add('username', 'text', array('required' => false))
		->add('oldPassword', 'password', array('required' => false))
		->add('newPassword', 'repeated', array('type' => 'password', 'invalid_message' => 'Les mots de passe doivent correspondre',
    'required' => false,
    'first_options'  => array('label' => 'Nouveau mot de passe :'),
    'second_options' => array('label' => 'Nouveau mot de passe (validation) :')));

   }

    public function getName()
    {
        return 'resetPassword';
    }
}
	
