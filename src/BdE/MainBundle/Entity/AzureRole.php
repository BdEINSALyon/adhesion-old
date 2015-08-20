<?php

namespace BdE\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AzureRole
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="BdE\MainBundle\Entity\AzureRoleRepository")
 */
class AzureRole
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var guid
     *
     * @ORM\Column(name="azure_gid", type="guid", unique=true)
     */
    private $azureGid;

    /**
     * @var string
     *
     * @ORM\Column(name="azure_group_name", type="string", length=255)
     */
    private $azureGroupName;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="simple_array")
     */
    private $roles;

    /**
     * @var string
     *
     * @ORM\Column(name="comments", type="text", nullable=true)
     */
    private $comments;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set azureGid
     *
     * @param guid $azureGid
     *
     * @return AzureRole
     */
    public function setAzureGid($azureGid)
    {
        $this->azureGid = $azureGid;

        return $this;
    }

    /**
     * Get azureGid
     *
     * @return string
     */
    public function getAzureGid()
    {
        return $this->azureGid;
    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return AzureRole
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set comments
     *
     * @param string $comments
     *
     * @return AzureRole
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @return string
     */
    public function getAzureGroupName()
    {
        return $this->azureGroupName;
    }

    /**
     * @param string $azureGroupName
     */
    public function setAzureGroupName($azureGroupName)
    {
        $this->azureGroupName = $azureGroupName;
    }

    function __toString()
    {
        return $this->getAzureGroupName();
    }


}

