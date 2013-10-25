<?php
// src/Cva/GestionMembreBundle/Form/Type/UserType.php
namespace Cva\GestionMembreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
		->add('username', 'text')
		->add('password', 'repeated', array('type' => 'password', 'invalid_message' => 'Les mots de passe doivent correspondre',
    'options' => array('required' => true),
    'first_options'  => array('label' => 'Mot de passe'),
    'second_options' => array('label' => 'Mot de passe (validation)')))
		->add('salt', 'hidden')
		->add('roles', 'choice', array('choices' => array('ROLE_CONSULT' => 'Consultation','ROLE_SOIREE' => 'Entree Soiree', 'ROLE_PERM' => 'Permanencier', 'ROLE_COWEI' => 'CoWEI', 'ROLE_MODO' => 'Moderateur', 'ROLE_ADMIN' => 'Admin'), 'multiple'  => true,));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Cva\GestionMembreBundle\Entity\USer'));
    }

    public function getName()
    {
        return 'user';
    }
}

