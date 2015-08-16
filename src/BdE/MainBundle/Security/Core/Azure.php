<?php
/**
 * Created by PhpStorm.
 * User: pvienne
 * Date: 15/08/15
 * Time: 19:45
 */

namespace BdE\MainBundle\Security\Core;


use BdE\MainBundle\Entity\User;
use Buzz\Browser;
use Buzz\Client\Curl;
use Buzz\Message\Request;
use Buzz\Message\Response;
use FOS\UserBundle\Model\UserManagerInterface;
use HWI\Bundle\OAuthBundle\Security\OAuthUtils;
use Buzz\Message\Form\FormRequest;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;

class Azure
{

    private $token;
    private $tenant;
    private $accessToken;
    private $clientId;
    private $clientSecret;
    /**
     * @var UserManagerInterface
     */
    private $users;

    public function __construct(TokenStorage $token, UserManagerInterface $users, $tenant, $clientId, $clientSecret){
        $this->token = $token;
        $this->tenant = $tenant;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->users = $users;
    }

    public function getAllGroups(){ // Think in future to cache this request for half-hours at least
        $token = $this->getAccessToken();
        if($token == "") return array();
        $client = new Curl();
        $req = new Request(Request::METHOD_GET,"/beta/" . $this->tenant . "/groups","https://graph.microsoft.com");
        $req->addHeader("authorization: Bearer " . $token);
        $res = new Response();
        $client->send($req,$res);
        if($res->getStatusCode() < 299){
            return json_decode($res->getContent())->value;
        }
        if($res->getStatusCode() == 401){
            $this->refreshToken($this->token->getToken()->getUser());
            return $this->getAllGroups();
        }
        return array();
    }

    public function getAllSecurityGroups(){
        $groups = array();
        foreach($this->getAllGroups() as $group){
            if($group->securityEnabled)
                $groups[] = $group;
        }
        return $groups;
    }

    public function getAllSecurityGroupsNamesMappedByGID(){
        $groups = array();
        foreach($this->getAllGroups() as $group){
            if($group->securityEnabled)
                $groups[$group->objectId] = $group->displayName;
        }
        return $groups;
    }

    private function getAccessToken(){
        if(!$this->accessToken){
            $this->accessToken = $this->retrieveToken();
        }
        return $this->accessToken;
    }

    /**
     * @return string
     */
    private function retrieveToken()
    {
        $t = $this->token->getToken();
        if (!$t) return "";
        /** @var User $user */
        $user = $t->getUser();
        if (!($user instanceof User)) return "";
        $token = $user->getAzureAccessToken();
        if (!$token || $token == "") return "";
        return $token;
    }

    /**
     * @param User $user
     */
    private function refreshToken($user)
    {
        $req = new FormRequest(Request::METHOD_POST,"/".$this->tenant."/oauth2/token","https://login.windows.net");
        $req->setFields(array(
            "client_id" => $this->clientId,
            "client_secret" => $this->clientSecret,
            "grant_type" => "refresh_token",
            "refresh_token" => $user->getAzureRenewAccessToken(),
            "resource" => "https://graph.microsoft.com"
        ));
        $res = new Response();
        (new Curl())->send($req,$res);
        if($res->getStatusCode() == 200){
            $data = json_decode($res->getContent());
            $user->setAzureAccessToken($data->access_token);
            $user->setAzureRenewAccessToken($data->refresh_token);
            $this->users->updateUser($user);
            $this->accessToken = $data->access_token;
        } else {
            $this->token->getToken()->setAuthenticated(false);
            throw new AccountExpiredException("Link with Office 365 has expired");
        }
    }

    /**
     * @param $id
     * @return mixed|null
     */
    public function getGroupByID($id)
    {
        $token = $this->getAccessToken();
        if($token == "") return null;
        $client = new Curl();
        $req = new Request(Request::METHOD_GET,"/beta/" . $this->tenant . "/groups/".$id,"https://graph.microsoft.com");
        $req->addHeader("authorization: Bearer " . $token);
        $res = new Response();
        $client->send($req,$res);
        if($res->getStatusCode() < 299){
            return json_decode($res->getContent());
        }
        if($res->getStatusCode() == 401){
            $this->refreshToken($this->token->getToken()->getUser());
            return $this->getGroupByID($id);
        }
        return null;
    }

}