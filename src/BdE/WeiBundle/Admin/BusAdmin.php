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

class BusAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->with("information")->add('nom')->add('nbPlaces')->end();
        $form->with("students")->add('etudiants','sonata_type_collection');
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('nom')->add('nbPlaces');
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('nom');
    }

}