<?php

namespace BdE\MainBundle\Controller;

use BdE\MainBundle\Entity\AzureRole;
use BdE\MainBundle\Form\AzureRoleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormFactoryBuilder;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AzureLinkManagementController
 * @package BdE\MainBundle\Controller
 * @Security("has_role('ROLE_AZURE_ADMIN') or has_role('ROLE_SUPER_ADMIN')")
 */
class AzureLinkManagementController extends Controller
{

    /**
     * @Route(name="bde_main_azure_link_index",path="/")
     * @return Response A Response instance
     */
    public function indexAction()
    {
        $repository = $this->get("doctrine.orm.entity_manager")->getRepository("BdEMainBundle:AzureRole");
        $azureService = $this->get('bde.main.azure');
        $form = $this->createForm(new AzureRoleType(),null,array(
            "azure_groups"=>$azureService->getAllSecurityGroupsNamesMappedByGID()
        ));
        return $this->render('@BdEMain/AzureLinkManagement/index.html.twig', array('roles' => $repository->findAll(),'new_form'=> $form->createView()));
    }

    /**
     * @Route(name="bde_main_azure_link_new",path="/new")
     * @return Response A Response instance
     */
    public function newAction(){
        $repository = $this->get("doctrine.orm.entity_manager")->getRepository("BdEMainBundle:AzureRole");
        $azureService = $this->get('bde.main.azure');
        $form = $this->createForm(new AzureRoleType(),null,array(
            "azure_groups"=>$azureService->getAllSecurityGroupsNamesMappedByGID()
        ));
        $form->handleRequest($this->container->get('request_stack')->getCurrentRequest());

        /** @var AzureRole $azureRole */
        $azureRole = $form->getData();

        $roleInDb = $repository->findOneBy(array("azureGid"=>$azureRole->getAzureGid()));
        if($roleInDb){
            $roleInDb->setRoles(array_unique(array_merge($roleInDb->getRoles(),$azureRole->getRoles())));
            $azureRole = $roleInDb;
        } else {
            $azureGroup = $azureService->getGroupByID($form->get("azureGid")->getData());
            if (!$azureGroup)
                return $this->createNotFoundException("Azure Group (" . $azureRole->getAzureGid() . ") was not found.");
            $azureRole->setAzureGroupName($azureGroup->displayName);
        }

        $em = $this->get("doctrine.orm.entity_manager");
        $em->persist($azureRole);
        $em->flush();

        $this->addFlash("notice","Le rôle a bien été sauvegardé");

        return $this->redirectToRoute("bde_main_azure_link_index");
    }

    /**
     * @Route(name="bde_main_azure_link_delete",path="/{id}/delete")
     * @param $id
     * @return Response A Response instance
     */
    public function deleteAction($id){
        $em = $this->get("doctrine.orm.entity_manager");
        $role = $em->getRepository("BdEMainBundle:AzureRole")->find($id);
        if(!$role){
            $this->addFlash("error","AzureRole ".strval($id)." n'as pas pu être supprimé car il n'existe pas.");
            return $this->redirectToRoute("bde_main_azure_link_index");
        }
        $em->remove($role);
        $em->flush();
        $this->addFlash("notice","Le rôle ".$id." a bien été supprimé.");
        return $this->redirectToRoute("bde_main_azure_link_index");
    }
}
