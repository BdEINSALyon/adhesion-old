<?php
/**
 * Created by PhpStorm.
 * User: pvienne
 * Date: 21/08/15
 * Time: 09:32
 */

namespace BdE\WeiBundle\Admin;

use Cva\GestionMembreBundle\Entity\ProduitRepository;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class WaitingAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->with("information")->add('student', 'entity', [
            'disabled' => true,
            'class'=>'Cva\GestionMembreBundle\Entity\Etudiant'])
            ->add('payment.product', 'entity', [
                'disabled' => true,
                'class'=>'Cva\GestionMembreBundle\Entity\Produit']
            )
            ->add('rank')->end();
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('rank')->add('payment.product')->add('student');
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('payment.product', null, [], null, [
            'class' => 'CvaGestionMembreBundle:Produit',
            'query_builder' => function(ProduitRepository $er) {
                return $er->createQueryBuilder('p')->where('p.active = true')->andWhere('p.hasWaitingList = true')
                    ->orderBy('p.price', 'ASC');
            },
        ]);
    }

}