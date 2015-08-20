<?php
/**
 * Created by PhpStorm.
 * User: pvienne
 * Date: 14/08/15
 * Time: 22:46
 */

namespace BdE\MainBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\Role;

/**
 * @ORM\Entity
 * @ORM\Table(name="Users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    protected $azureAccessToken;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    protected $azureRenewAccessToken;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    public function setAzureAccessToken($accessToken)
    {
        $this->azureAccessToken=$accessToken;
    }

    public function getAzureAccessToken()
    {
        return $this->azureAccessToken;
    }

    /**
     * @return string
     */
    public function getAzureRenewAccessToken()
    {
        return $this->azureRenewAccessToken;
    }

    /**
     * @param string $azureRenewAccessToken
     */
    public function setAzureRenewAccessToken($azureRenewAccessToken)
    {
        $this->azureRenewAccessToken = $azureRenewAccessToken;
    }

    public function addRole($role){
        if(is_string($role)){
            return parent::addRole($role);
        } elseif($role instanceof Role){
            return parent::addRole($role->getRole());
        } else {
            throw new \InvalidArgumentException("Role must be a string or Role symfony object");
        }
    }
}