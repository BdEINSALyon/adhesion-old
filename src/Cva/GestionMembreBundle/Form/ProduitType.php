<?php
// src/Cva/GestionMembreBundle/Form/Type/ProduitType.php
namespace Cva\GestionMembreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
		->add('description', 'text')
		->add('price', 'integer')
		->add('disponibilite', 'choice', array('choices' => array('OUI' => 'Oui', 'NON' => 'Non'),'required'  => false, 'expanded' => true ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Cva\GestionMembreBundle\Entity\Produit'));
    }

    public function getName()
    {
        return 'produit';
    }
}

