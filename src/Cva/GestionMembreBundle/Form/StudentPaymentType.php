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

class StudentPaymentType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setDataMapper(new MultiplePaymentsDataMapper());
        $builder->add("products", 'entity', array(
            'choices' => $options['products'],
            'expanded' => true,
            'multiple' => true,
            'class' => 'Cva\GestionMembreBundle\Entity\Produit'
        ));
        $builder->add('method', 'choice', array(
            'choices' => array(
                'CHQ' => 'Cheque',
                'CB' => 'Carte Bancaire',
                'ESP' => 'Espèces'
            ),
            'mapped' => true,
            'required'  => !$options['none_enabled'],
            'expanded' => true,
            'label' => "Moyen de paiement",
            'attr' => $options['none_enabled']?array('help_text' => "Si aucun moyen de paiement n'est selectionné, alors l'adhérent sera créé sans produit affecté."):array()));
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('none_enabled',true);
        $resolver->setRequired("products");
    }

    public function getName()
    {
        return 'payment_not_required';
    }
}