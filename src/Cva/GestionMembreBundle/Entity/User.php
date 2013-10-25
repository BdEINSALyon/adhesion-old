<?php
// src/Cva/GestionMembreBundle/Entity/Utilisateur.php
namespace Cva\GestionMembreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
/**
 * @ORM\Entity
 */
class User implements UserInterface
{
  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;
 
  /**
   * @ORM\Column(name="username", type="string", length=255, unique=true)
   */
  private $username;
 
  /**
   * @ORM\Column(name="password", type="string", length=255)
   */
  private $password;
 
  /**
   * @ORM\Column(name="salt", type="string", length=255, nullable=true)
   */
  private $salt;
 
  /**
   * @ORM\Column(name="roles", type="array")
   */
  private $roles;
 
  public function __construct()
  {
    $this->roles = array();
  }
 
  public function getId()
  {
    return $this->id;
  }
 
  public function setUsername($username)
  {
    $this->username = $username;
    return $this;
  }
 
  public function getUsername()
  {
    return $this->username;
  }
 
  public function setPassword($password)
  {
    $this->password = $password;
    return $this;
  }
 
  public function getPassword()
  {
    return $this->password;
  }
 
  public function setSalt($salt)
  {
    $this->salt = $salt;
    return $this;
  }
 
  public function getSalt()
  {
    return $this->salt;
  }
 
  public function setRoles(array $roles)
  {
    $this->roles = $roles;
    return $this;
  }
 
  public function getRoles()
  {
    return $this->roles;
  }
 
  public function eraseCredentials()
  {
  }

    /**
     * Set role
     *
     * @param string $role
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;
    
        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }
}
