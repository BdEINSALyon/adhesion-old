<?php
/**
 * Created by PhpStorm.
 * User: pvienne
 * Date: 21/08/15
 * Time: 09:32
 */

namespace BdE\WeiBundle\Admin;


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
                ->add('sexe','choice',array('choices'=>array("M"=>"Mens","F"=>"Womens","ND"=>"Multiples")))
            ->end();
        $form->with("students")->add('etudiants');
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->add('nom')->add('nbPlaces')->add('sexe');
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('nom')->add('sexe','choice',array('choices'=>array("M"=>"Mens","F"=>"Womens","ND"=>"Multiples")));
    }

}