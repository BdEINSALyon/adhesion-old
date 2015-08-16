<?php
namespace BdE\MainBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class MenuBuilder
{
    private $factory;
    /**
     * @var int[]
     */
    private $dividerCounts;
    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\TokenInterface
     */
    private $token;
    /**
     * @var AuthorizationChecker
     */
    private $acl;

    /**
     * @param TokenStorage $tokenStorage
     * @param AuthorizationChecker $authorizationChecker
     * @param FactoryInterface $factory
     */
    public function __construct(TokenStorage $tokenStorage, AuthorizationChecker $authorizationChecker,FactoryInterface $factory)
    {
        $this->token = $tokenStorage->getToken();
        $this->acl = $authorizationChecker;
        $this->factory = $factory;
    }

    public function createMainMenu(RequestStack $requestStack)
    {
        $this->dividerCounts = array();

        $menu = $this->factory->createItem('root');

        if(!$this->showMenu()){
            return $menu;
        }
        if($this->acl->isGranted("ROLE_PERM"))
            $menu->addChild('Ajouter Adhérant', array('route' => 'cva_gestion_membre_ajoutAdherent'));
        if($this->acl->isGranted("ROLE_PERM")) {
            $membres = $menu->addChild('Gestion des Membres');
            $membres->addChild("CheckVA", array('route' => 'cva_gestion_membre_assoCheck'));
            $this->addDivider($membres);
            $membres->addChild("Actuels", array('route' => 'cva_gestion_membre_adherent'));
            $membres->addChild("Anciens", array('route' => 'cva_gestion_membre_anciens'));
        } else if($this->acl->isGranted("ROLE_SOIREE")) {
            $menu->addChild("Verifier N°Etudiant", array('route' => 'cva_gestion_membre_assoCheck'));
            $menu->addChild("Liste Membres Actuels", array('route' => 'cva_gestion_membre_adherent'));
        } else if($this->acl->isGranted("ROLE_CONSULT")){
            $menu->addChild("CheckVA", array('route' => 'cva_gestion_membre_assoCheck'));
        }
        if($this->acl->isGranted("ROLE_COWEI")) {
            $wei = $menu->addChild('Zone CoWEI');
            $wei->addChild("Pré-Inscrits", array('route' => 'bde_wei_inscription_préInscrits'));
            $wei->addChild("Pré-Liste Attente", array('route' => 'bde_wei_inscription_listeAttentePre'));
            $this->addDivider($wei);
            $wei->addChild("Inscrits", array('route' => 'bde_wei_inscription_rechercheBizuthWEI'));
            $wei->addChild("Liste Attente", array('route' => 'bde_wei_inscription_listeAttente'));
            $this->addDivider($wei);
            $wei->addChild("A rembourser",array('route'=>'bde_wei_inscription_remboursements'));
            if($this->acl->isGranted("ROLE_EDIT_CONFIG") && !$this->acl->isGranted("ROLE_ADMIN")) {
                $this->addDivider($wei);
                $wei->addChild("Configuration WEI",array("route"=>"cva_gestion_membre_config"));
            }
        }
        if($this->acl->isGranted("ROLE_ADMIN")) {
            $admin = $menu->addChild('Zone Admin');
            $admin->addChild("Créer Utilisateur", array('route' => 'cva_gestion_membre_addUser'));
            $admin->addChild("Modifier Utilisateur", array('route' => 'cva_gestion_membre_editUser'));
            $this->addDivider($admin);
            $admin->addChild("Créer Produit", array('route' => 'cva_gestion_membre_addProduit'));
            $admin->addChild("Modifier Produit", array('route' => 'cva_gestion_membre_tableauProduits'));
            $this->addDivider($admin);
            $admin->addChild("Gestion AzureAD", array('route' => 'bde_main_azure_link_index'));
            $this->addDivider($admin);
            $admin->addChild("Configuration Général",array("route"=>"cva_gestion_membre_config"));
        }

        return $menu;
    }

    public function createUserMenu(RequestStack $requestStack)
    {
        $this->dividerCounts = array();

        $menu = $this->factory->createItem('root');

        if(!$this->showMenu()){
            return $menu;
        }

        if($this->acl->isGranted("ROLE_PERM")){
            $menu->addChild("Statistiques",array("route"=>"cva_gestion_membre_stats"));
            $this->addDivider($menu);
        }

        $user = $menu->addChild($this->token->getUsername());

        $user->addChild("Profil", array("route"=>"cva_gestion_membre_profil"));
        $user->addChild("Deconnexion", array("route"=>"fos_user_security_logout"));

        return $menu;
    }

    private function showMenu(){
        return $this->token->isAuthenticated() and $this->acl->isGranted("ROLE_USER");
    }

    private function addDivider(ItemInterface $menu){
        $id = spl_object_hash($menu);
        if (!array_key_exists($id,$this->dividerCounts)) {
            $this->dividerCounts[$id] = 0;
        }
        $count = $this->dividerCounts[$id];
        $menu->addChild("divider".strval($count))->setAttribute('divider',true);
        $this->dividerCounts[$id]++;
    }
}