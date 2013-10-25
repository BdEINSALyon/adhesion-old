<?php

namespace Cva\GestionMembreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use \Cva\GestionMembreBundle\Service\ServiceMembre;

class ListeProduitType extends AbstractType
{
    private $serviceMembre;

    public function __construct(ServiceMembre $serviceMembre)
    {
        $this->serviceMembre = $serviceMembre;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $produitsDispo = $serviceMembre->GetAllProduitDispo();
	$resolver->setDefaults(array(
            'choices' => $produitsDispo,
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'listeProduit';
    }
}
