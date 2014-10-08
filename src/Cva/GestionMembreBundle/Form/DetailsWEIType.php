<?php
// src/Cva/GestionMembreBundle/Form/Type/DetailsWEIType.php
namespace Cva\GestionMembreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Cva\GestionMembreBundle\Entity\BungalowRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DetailsWEIType extends AbstractType
{
    private $sexeEtu;
    private $busCourant;
    private $bungCourant;

    function __construct($sexeEtu,$bus,$bung)
    {
        $this->sexeEtu = $sexeEtu;
        $this->busCourant = $bus;
        $this->bungCourant = $bung;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

       $sexe= $this->sexeEtu;
       $bus= $this->busCourant;
       $bung= $this->bungCourant;
        $builder
            ->add('bus', 'entity', 
                array('class' => 'CvaGestionMembreBundle:Bus',
                      'empty_value' => 'Choisissez une option',
                      'query_builder' => function(\Cva\GestionMembreBundle\Entity\BusRepository $er) use ($bus)
                        {
                                return $er->GetAllBusNonPleins($bus);
                        },
                ))
            ->add('bungalow', 'entity', array('class' => 'CvaGestionMembreBundle:Bungalow',
                      'empty_value' => 'Choisissez une option',
                'query_builder' => function(\Cva\GestionMembreBundle\Entity\BungalowRepository $er) use ($sexe,$bung)
                {
                        return $er->GetAllBungBySexe($sexe,$bung);
                },
                ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Cva\GestionMembreBundle\Entity\DetailsWEI'));
    }

    public function getName()
    {
        return 'detailsWEI';
    }
}

