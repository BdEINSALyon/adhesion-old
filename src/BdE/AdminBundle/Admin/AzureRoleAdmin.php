<?php

namespace BdE\AdminBundle\Admin;

use BdE\MainBundle\Entity\AzureRole;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;

class AzureRoleAdmin extends Admin
{

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
            ->add('roles', 'choice', array(
                'label' => 'Roles',
                'multiple' => true,
                'choices' => $this->getRolesChoices()
            ))
            ->add('azureGid', 'choice', array(
                'label' => 'Groupe Azure',
                'choices' => $this->getAzureGroupChoices(),
                'error_bubbling' => false,
            ))
            ->add('comments') //if no type is specified, SonataAdminBundle tries to guess it
        ;
    }

    protected function getRolesChoices(){
        $container = $this->getConfigurationPool()->getContainer();
        $roles = $container->getParameter('security.role_hierarchy.roles');
        return self::flattenRoles($roles);
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
                'choices' => $this->getRolesChoices()
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


    /**
     * Turns the role's array keys into string <ROLES_NAME> keys.
     * @param $rolesHierarchy
     * @param array $flatRoles
     * @return array
     */
    protected static function flattenRoles($rolesHierarchy, $flatRoles = array())
    {
        foreach($rolesHierarchy as $role) {
            if(empty($role)) {
                continue;
            } elseif (is_array($role)) {
                $flatRoles = self::flattenRoles($role, $flatRoles);
            } elseif (!isset($flatRoles[$role])){
                $flatRoles[$role] = $role;
            }
        }

        return $flatRoles;
    }

}