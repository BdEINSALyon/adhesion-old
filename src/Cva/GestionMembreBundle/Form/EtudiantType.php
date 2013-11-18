<?php
// src/Cva/GestionMembreBundle/Form/Type/EtudiantType.php
namespace Cva\GestionMembreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
		->add('name', 'text')
		->add('firstName', 'text')
		->add('annee', 'choice', array('choices' => array('1' => '1','2' => '2','3' => '3','4' => '4','5' => '5','3CYCLE' => '3eme Cycle', 'Personnel' => 'Personnel','Autre' => 'Autre'),'required'  => false, 'expanded' => false,'empty_value' => false ))
		->add('departement','choice', array('choices' => array('BB' => 'BB','BIM' => 'BIM','GCU' => 'GCU','GE' => 'GE','GEN' => 'GEN','GI' => 'GI','GMC' => 'GMC','GMD' => 'GMD','GMPP' => 'GMPP','IF' => 'IF','PC' => 'PC','SGM' => 'SGM','TC' => 'TC'),'required'  => false, 'expanded' => false,
    'empty_value' => '',
    'empty_data'  => null ))
		->add('numEtudiant', 'text', array('required' => false))
		->add('birthday', 'birthday', array('format' => 'dd MMMM yyyy','widget' => 'choice','years' => range( date('Y')-15,date('Y')-70)))
		->add('mail', 'email')
		->add('tel', 'text', array('required' => false))
		->add('civilite', 'choice', array('choices' => array('Mme' => 'Mme.', 'M' => 'M.'),'required'  => true, 'expanded' => true ))
		->add('remarque','text', array('required' => false))
		->add('id', 'hidden')
		->add('Valider', 'submit')
    		->add('Prod', 'submit');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Cva\GestionMembreBundle\Entity\Etudiant'));
    }

    public function getName()
    {
        return 'etudiant';
    }
}
