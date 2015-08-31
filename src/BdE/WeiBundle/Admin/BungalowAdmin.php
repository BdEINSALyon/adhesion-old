<?php
/**
 * Created by PhpStorm.
 * User: pvienne
 * Date: 21/08/15
 * Time: 09:32
 */

namespace BdE\WeiBundle\Admin;


use BdE\WeiBundle\Entity\Bungalow;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class BungalowAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->with("information")
                ->add('nom')
                ->add('nbPlaces')
                ->add('sexe','choice',array('choices'=>Bungalow::getSexChoices()))
            ->end();
        $form->with("students")->add('students');
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('nom')->add('nbPlaces')->add('sexe');
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('nom')->add(
            'sexe','doctrine_orm_string', array(),
            'choice', array(
                'choices' => Bungalow::getSexChoices(),
                'multiple' => false,
                'required' => false
            ));
    }

}