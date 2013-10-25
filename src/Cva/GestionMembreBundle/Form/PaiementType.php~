<?php
// src/Cva/GestionMembreBundle/Form/Type/PaiementType.php
namespace Cva\GestionMembreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PaiementType extends AbstractType
{
   private $produits;

    function __construct(array $produit)
    {
		$this->produits = $produit;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	$formProd = array();
	foreach($this->produits as $prod)
	{
		$formProd[$prod->getDescription()] = $prod->getDescription() . ' - ' . $prod->getPrice() . ' €';
	}

	$builder->add('Produits', 'choice', array('choices' => $formProd, 'required'  => true, 'expanded' => true,'mapped' => false, 'multiple' => true ));
	$builder->add('moyenPaiement', 'choice', array('choices' => array('Cheque' => '1. Cheque', 'CB' => '2. Carte Bancaire', 'Especes' => '3. Espèces' ),'mapped' => true, 'required'  => true, 'expanded' => true ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Cva\GestionMembreBundle\Entity\Paiement'));
    }

    public function getName()
    {
        return 'paiement';
    }
}
