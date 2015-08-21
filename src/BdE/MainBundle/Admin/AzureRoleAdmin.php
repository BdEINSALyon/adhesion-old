<?php

namespace BdE\MainBundle\Admin;

use BdE\MainBundle\Entity\AzureRole;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

class AzureRoleAdmin extends Admin
{

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
            ->add('roles', 'choice', array(
                'label' => 'Roles',
                'multiple' => true,
                'choices' => $this->getConfigurationPool()->getContainer()->get("bde.main.roles_provider")->getRoles()
            ))
            ->add('azureGid', 'choice', array(
                'label' => 'Groupe Azure',
                'choices' => $this->getAzureGroupChoices(),
                'error_bubbling' => false,
                'translation_domain' => false
            ))
            ->add('comments') //if no type is specified, SonataAdminBundle tries to guess it
        ;
    }

    protected function getAzureGroupChoices(){
        $container = $this->getConfigurationPool()->getContainer();
        $azure = $container->get('bde.main.azure');
        return $azure->getAllSecurityGroupsNamesMappedByGID();
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('azureGroupName')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('azureGroupName')
            ->add('roles', 'choice', array(
                'multiple'=>true,
                'delimiter'=>", ",
                'choices' => $this->getConfigurationPool()->getContainer()->get("bde.main.roles_provider")->getRoles()
            ))->add("comments")
        ;
    }



    /**
     * @param ErrorElement $errorElement
     * @param AzureRole $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $r = $this->getConfigurationPool()->getContainer()->get("doctrine.orm.entity_manager")->getRepository("BdEMainBundle:AzureRole");
        $q = $r->createQueryBuilder('r')->where('r.azureGid = ?1')->setParameter(1,$object->getAzureGid());
        if($object->getId()!=null){
            $q->andWhere("r.id!=?2")->setParameter(2,$object->getId());
        }
        $ar=$q->getQuery()->getArrayResult();
        if(count($ar)>0) {
            $errorElement->with('azureGid')->addViolation("Il existe déjà une liaison avec ce groupe")->end();
        } else {
            $object->setAzureGroupName($this->getAzureGroupChoices()[$object->getAzureGid()]);
        }
    }

}