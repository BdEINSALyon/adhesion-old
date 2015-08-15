<?php
/**
 * Created by PhpStorm.
 * User: pvienne
 * Date: 15/08/15
 * Time: 12:47
 */

namespace BdE\MainBundle\Security\Core;

use Buzz\Browser;
use Buzz\Client\Curl;
use Buzz\Message\Request;
use HWI\Bundle\OAuthBundle\Connect\AccountConnectorInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use Symfony\Component\Security\Core\Role\Role;
use BdE\MainBundle\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use FOS\UserBundle\Model\UserManagerInterface;


class UserProvider implements UserProviderInterface, AccountConnectorInterface, OAuthAwareUserProviderInterface
{
    private $domain = "bde-insa-lyon.fr";

    /**
     * Constructor.
     *
     * @param UserManagerInterface $userManager FOSUB user provider.
     */
    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
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
        // Load groups for this user
        $client = new Browser(new Curl());
        $uid = $response->getResponse()['oid'];
        $request = new Request(
            Request::METHOD_GET,
            "/beta/".$this->domain."/".$uid."/Microsoft.Graph.DirectoryObject/Microsoft.Graph.getMemberGroups",
            "https://graph.microsoft.com");
        $request->addHeader("authorization: Bearer ".$response->getAccessToken());
        $uri = "https://graph.microsoft.com".
            "/beta/bde-insa-lyon.fr/users('".$uid."')/memberOf";
        $r = ($client->get($uri, array("authorization: Bearer ".$response->getAccessToken())));
        $r = json_decode($r->getContent());
        if(!property_exists($r,'value')){
            throw new \OAuthException("Can not load groups.");
        }
        $groups = $r->value;
        $role = null;
        foreach($groups as $group){
            if($group->objectType=='Group'){
                if($group->mail) continue;
            } elseif($group->objectType=='Role'){
                if(!$group->isSystem) continue;
                if($group->displayName=="Company Administrator"){
                    // We found an Admin !
                    $role = "ROLE_SUPER_ADMIN";
                    break;
                }
            }
        }
        if($role == null){
            throw new UsernameNotFoundException(sprintf("User '%s' has no power here!", $response->getRealName()));
        }
        /** @var User $user */
        if($user == null)
            $user = $this->userManager->createUser();
        $user->addRole($role);
        $user->setEmail($response->getEmail());
        $user->setEmailCanonical($response->getEmail());
        $user->setEnabled(true);
        $user->setUsername($response->getEmail());
        $user->setPlainPassword($response->getAccessToken());
        $user->setAzureAccessToken($response->getAccessToken());
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