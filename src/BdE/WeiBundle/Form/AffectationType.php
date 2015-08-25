<?php
/**
 * Created by PhpStorm.
 * User: pvienne
 * Date: 25/08/15
 * Time: 09:37
 */

namespace BdE\WeiBundle\Form;


use BdE\WeiBundle\Entity\Bungalow;
use BdE\WeiBundle\Entity\Bus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AffectationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bungalow','entity',array(
                'class'=>'BdE\WeiBundle\Entity\Bungalow',
                'choices'=>$options['bungalow'],
                'property'=>'id',
                'choice_label' => function(Bungalow $bungalow){
                    return '('.$bungalow->getId() .") ".$bungalow->getNom();
                }
            ))
            ->add('bus','entity',array(
                'class'=>'BdE\WeiBundle\Entity\Bus',
                'choices'=>$options['bus'],
                'choice_label' => function(Bus $bus){
                    return '('.$bus->getId() .") ".$bus->getNom();
                }
            ))
            ->add('actions', 'form_actions', [
                'buttons' => [
                    'save' => ['type' => 'submit', 'options' => ['label' => 'button.save', 'attr'=>['class'=>'btn-block']]]
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(['bungalow','bus']);
    }


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "bde_wei_affectation";
    }
}