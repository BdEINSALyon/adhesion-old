<?php

namespace BdE\MainBundle\Admin;

use BdE\MainBundle\Entity\AzureRole;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

class MailAdmin extends Admin
{

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
            ->with("general")
            ->add("name")
            ->add("active",null,array('required'=>false))
            ->add("priority")
            ->end()
            ->with("conditions")
            ->add("forProducts")
            ->add("forYears", "choice",array(
                "multiple"=>true,
                "choices"=>array(
                    '1' => 'Première année',
                    '2' => 'Deuxième année',
                    '3' => 'Troisième année',
                    '4' => 'Quatrième année',
                    '5' => 'Cinquième année',
                    '3CYCLE' => 'Doctorants',
                    'AUTRE' => 'Non INSA',
                    'Personnel' => 'Personnel',
                )
            ))
            ->add("forNewMembers","choice",array(
                "choices"=>array(
                    0 => 'Critère désactivé',
                    1 => 'Nouveau membres (< 3 mois)',
                    2 => 'Anciens membres (>= 3 mois)'
                ),
                "label"=>"Ancienneté"
            ))
            ->end()
            ->with("content")
            ->add("content","ckeditor")
            ->end()
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
        ;
    }

}