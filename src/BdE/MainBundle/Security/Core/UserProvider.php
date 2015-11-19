<?php
/**
 * Created by PhpStorm.
 * User: pvienne
 * Date: 15/08/15
 * Time: 12:47
 */

namespace BdE\MainBundle\Security\Core;

use BdE\MainBundle\Entity\AzureRole;
use Buzz\Browser;
use Buzz\Client\Curl;
use Buzz\Message\Request;
use Doctrine\ORM\EntityManager;
use HWI\Bundle\OAuthBundle\Connect\AccountConnectorInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use Symfony\Component\Security\Core\Role\Role;
use BdE\MainBundle\Entity\User;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use FOS\UserBundle\Model\UserManagerInterface;


class UserProvider implements UserProviderInterface, AccountConnectorInterface, OAuthAwareUserProviderInterface
{
    /**
     * @var RoleHierarchyInterface
     */
    private $roleHierarchy;
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var string
     */
    private $tenant;
    /**
     * @var FlashBag
     */
    private $flashBag;

    /**
     * Constructor.
     *
     * @param UserManagerInterface $userManager FOSUB user provider.
     * @param RoleHierarchyInterface $roleHierarchy
     * @param EntityManager $entityManager
     * @param FlashBag $flashBag
     * @param string $tenant
     */
    public function __construct(UserManagerInterface $userManager,
                                RoleHierarchyInterface $roleHierarchy,
                                EntityManager $entityManager,
                                FlashBag $flashBag,
                                $tenant)
    {
        $this->userManager = $userManager;
        $this->roleHierarchy = $roleHierarchy;
        $this->entityManager = $entityManager;
        $this->tenant = $tenant;
        $this->flashBag = $flashBag;
    }

    /**
     * {@inheritDoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        var_dump($user);
        var_dump($response);
        exit;
    }
    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        // First, check if it's an Azure User
        if(get_class($response->getResourceOwner())!="HWI\\Bundle\\OAuthBundle\\OAuth\\ResourceOwner\\AzureResourceOwner"){
            throw new UnsupportedUserException("Can not load a user by ".get_class($response->getResourceOwner()).".");
        }
        // Check if this user exists
        $user = $this->userManager->findUserByEmail($response->getEmail());
        // Load groups ids
        $groups = $this->entityManager->createQueryBuilder()->select("azureRole.azureGid")->from("BdEMainBundle:AzureRole",'azureRole')->getQuery()->getArrayResult();
        $request = ['groupIds'=>[]];
        foreach ($groups as $group) {
            $request['groupIds'][] = $group['azureGid'];
        }
        // Load groups for this user
        $client = new Curl();
        $client->setTimeout(20000);
        $client = new Browser($client);
        $uid = $response->getResponse()['oid'];
        $uri = "https://graph.windows.net".
            "/".$this->tenant."/me/checkMemberGroups?api-version=1.6";
        $r = ($client->post($uri, array(
            "Authorization: Bearer ".$response->getAccessToken()."",
            "Content-Type: application/json",
            "Accept: application/json"
        ), json_encode($request)));
        $r = json_decode($r->getContent());
        $groups = $r->value;
        $roleRepo = $this->entityManager->getRepository("BdEMainBundle:AzureRole");
        /** @var AzureRole[] $azureRoles */
        $azureRoles = $roleRepo->createQueryBuilder('azureRole')->where('azureRole.azureGid IN (?1)')
            ->setParameter(1, $groups)->getQuery()->getResult();
        /** @var Role[] $roles */
        $roles = array();
        foreach($azureRoles as $azureRole){
            $roles = array_merge($roles,$azureRole->getRoles());
        }
        $roles = array_unique($roles);
        if(sizeof($roles)==0){
            // Try to get if it's a SuperAdmin
            $uri = "https://graph.windows.net".
                "/".$this->tenant."/me/memberOf?api-version=1.6";
	    $r = ($client->get($uri, array(
                "authorization: Bearer ".$response->getAccessToken())));
	    $userRoles = json_decode($r->getContent());
            if(!property_exists($userRoles,'value')){
                throw new UsernameNotFoundException(sprintf("Impossible to log you !", $response->getRealName()));
            }
            $userRoles = $userRoles->value;
            foreach($userRoles as $userRole){
               if($userRole->objectType=='Role') {
                    if ($userRole->displayName == "Company Administrator" && strpos($response->getEmail(), $this->tenant) !== false) {
                        // We found an Admin !
                        $roles[] = new Role("ROLE_SUPER_ADMIN");
                        break;
                    }
                }
            }
            if(count($roles) == 0) {
                $this->flashBag->add("error", $response->getEmail() . " ne peut pas se connecter à cette application");
                throw new UsernameNotFoundException(sprintf("User '%s' has no power here!", $response->getRealName()));
            }
        }
        /** @var User $user */
        if($user == null) {
            $user = $this->userManager->createUser();
        }
        $user->setRoles($roles);
        $user->setEmail($response->getEmail());
        $user->setEmailCanonical($response->getEmail());
        $user->setEnabled(true);
        $user->setUsername($response->getEmail());
        $user->setPlainPassword($response->getAccessToken());
        $user->setAzureAccessToken($response->getAccessToken());
        $user->setAzureRenewAccessToken($response->getRefreshToken());
        $this->userManager->updateUser($user);
        return $user;
    }

    public function loadUserByUsername($username)
    {
        var_dump($username);
        exit;
    }

    public function refreshUser(UserInterface $user)
    {
        var_dump($user);
        exit;
    }

    public function supportsClass($class)
    {
        return "BdE\\MainBundle\\Entity\\User";
    }
}
