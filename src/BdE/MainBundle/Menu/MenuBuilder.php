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
        if($this->acl->isGranted("ROLE_PERM")) {
            $menu->addChild("Chaine Inscription", array('route' => 'wizard_search'));
            $membres = $menu->addChild('Gestion des Membres');
            $membres->addChild("Actuels", array('route' => 'cva_membership_students_current'));
            $membres->addChild("Anciens", array('route' => 'cva_membership_students_old'));
            $this->addDivider($membres);
            $membres->addChild('Ajouter Adhérent', array('route' => 'cva_membership_student_new'));
            $this->addDivider($membres);
            $membres->addChild("Tous les Adhérents", array('route' => 'cva_membership_students'));
        } else if($this->acl->isGranted("ROLE_SOIREE")) {
            $menu->addChild("Verifier N°Etudiant", array('route' => 'cva_gestion_membre_assoCheck'));
            $menu->addChild("Liste Membres Actuels", array('route' => 'cva_membership_students'));
        } else if($this->acl->isGranted("ROLE_CONSULT")){
            $menu->addChild("CheckVA", array('route' => 'cva_gestion_membre_assoCheck'));
        }
        if($this->acl->isGranted("ROLE_COWEI")) {
            $wei = $menu->addChild('CoWEI');
            $wei->addChild("Pré-Inscrits", array('route' => 'bde_wei_registration_pre'));
            $wei->addChild("Pré-Liste Attente", array('route' => 'bde_wei_registration_pre_waiting'));
            $this->addDivider($wei);
            $wei->addChild("Inscrits", array('route' => 'bde_wei_registration_index'));
            $wei->addChild("Liste Attente", array('route' => 'bde_wei_registration_index_waiting'));
            $this->addDivider($wei);
//            $wei->addChild("A rembourser",array('route'=>'bde_wei_inscription_remboursements'));
            $wei->addChild("Bus",array('route'=>'bde_wei_bus'));
            $wei->addChild("Bungalows",array('route'=>'bde_wei_bungalow'));
            if($this->acl->isGranted("ROLE_EDIT_CONFIG")) {
                $this->addDivider($wei);
                $wei->addChild("Configuration WEI",array("route"=>"bde_wei"));
            }
        }
        if($this->acl->isGranted("ROLE_PERM"))
            $menu->addChild("Statistiques", array('route' => 'cva_membership_stats'));
        if($this->acl->isGranted("ROLE_SONATA_ADMIN")) {
            $menu->addChild("Administration", array('route' => 'sonata_admin_redirect'));
        }

        return $menu;
    }

    public function createUserMenu(RequestStack $requestStack)
    {
        $this->dividerCounts = array();

        $menu = $this->factory->createItem('root');

        if(!$this->showMenu()){
            $menu->addChild("Connexion",array("route"=>"fos_user_security_login"));
            return $menu;
        }

        if($this->acl->isGranted("ROLE_PERM")){
//            $menu->addChild("Statistiques",array("route"=>"cva_gestion_membre_stats"));
//            $this->addDivider($menu);
        }

        $user = $menu->addChild($this->token->getUsername());

        $user->addChild("Deconnexion", array("route"=>"fos_user_security_logout"));

        return $menu;
    }

    private function showMenu(){
        return $this->token && $this->token->isAuthenticated() and $this->acl->isGranted("ROLE_USER");
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