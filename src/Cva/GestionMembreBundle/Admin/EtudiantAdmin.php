<?php
/**
 * Created by PhpStorm.
 * User: pvienne
 * Date: 21/08/15
 * Time: 09:57
 */

namespace Cva\GestionMembreBundle\Admin;


use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class EtudiantAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->with("information")
            ->add('name')
            ->add('firstName')
            ->add('numEtudiant')
            ->add('annee')
            ->add('departement')
            ->end();
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('id')
            ->addIdentifier("name")
            ->add('firstName')
            ->add('numEtudiant')
            ->add('annee')
            ->add('depatement');
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('name');
    }
}