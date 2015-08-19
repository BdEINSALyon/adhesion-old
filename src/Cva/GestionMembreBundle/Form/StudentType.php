<?php
// src/Cva/GestionMembreBundle/Form/Type/EtudiantType.php
namespace Cva\GestionMembreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label'=>"Nom"))
            ->add('firstName', 'text', array('label'=>"Prénom"))
            ->add('annee', 'choice', array(
                'choices' => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '3CYCLE' => '3eme Cycle',
                    'Personnel' => 'Personnel',
                    'Autre' => 'Autre'
                ),
                "label" => "Année",
                'required' => true,
                'expanded' => false,
                'empty_value' => false
            ))
            ->add('departement', 'choice', array(
                'choices' => array(
                    'BB' => 'BB',
                    'BIM' => 'BIM',
                    'GCU' => 'GCU',
                    'GE' => 'GE',
                    'GEN' => 'GEN',
                    'GI' => 'GI',
                    'GMC' => 'GMC',
                    'GMD' => 'GMD',
                    'GMPP' => 'GMPP',
                    'IF' => 'IF',
                    'PC' => 'PC',
                    'SGM' => 'SGM',
                    'TC' => 'TC'
                ),
                "label" => "Département INSA",
                'required' => false,
                'expanded' => false,
                'empty_value' => '',
                'empty_data' => null
            ))
            ->add('numEtudiant', 'text', array('required' => false, 'label'=>"N° Etudiant"))
            ->add('birthday', 'birthday', array(
                'format' => 'dd MMMM yyyy',
                'widget' => 'choice',
                'years' => range(date('Y') - 15, date('Y') - 70),
                'label' => 'Date de Naissance'
            ))
            ->add('mail', 'email', array(
                'label'=>'EMail'
            ))
            ->add('tel', 'text', array(
                'required' => false,
                'label'=>'Téléphone'
            ))
            ->add('civilite', 'choice', array(
                'choices' => array(
                    'F' => 'Mme.',
                    'M' => 'M.'
                ), 'required' => true, 'expanded' => false, 'label'=>'Civilité'))
            ->add('remarque', 'textarea', array('required' => false, 'label'=>'Remarques'))
            ->add('id', 'hidden');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Cva\GestionMembreBundle\Entity\Etudiant'));
    }

    public function getName()
    {
        return 'etudiant';
    }
}
