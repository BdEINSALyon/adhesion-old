<?php
/**
 * Created by PhpStorm.
 * User: pvienne
 * Date: 18/08/15
 * Time: 21:24
 */

namespace Cva\GestionMembreBundle\Form;


use Cva\GestionMembreBundle\Entity\Produit;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PaymentType extends AbstractType
{

    /**
     * @var Produit[]
     */
    private $produits;

    function __construct(array $produit)
    {
        $this->produits = $produit;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("product", 'entity', array(
            'query_builder'=>function(EntityRepository $repository){
                return $repository->findBy(array('disponibilite'=>'OUI'));
            },
            'expanded' => true,
            'class' => 'Cva\GestionMembreBundle\Entity\Payment'
        ));
        $builder->add('method', 'choice', array('choices' => array('CHQ' => '1. Cheque', 'CB' => '2. Carte Bancaire', 'ESP' => '3. Espèces' ),'mapped' => true, 'required'  => true, 'expanded' => true ));
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Cva\GestionMembreBundle\Entity\Payment'));
    }

    public function getName()
    {
        return 'payment';
    }
}