<?php
/**
 * Created by PhpStorm.
 * User: pvienne
 * Date: 20/08/15
 * Time: 11:58
 */

namespace BdE\MainBundle\Security;

use Symfony\Component\Translation\DataCollectorTranslator;

class RolesProvider
{

    private $roles;

    public function __construct($roleHierarchy, DataCollectorTranslator $t){
        $roleHierarchy = self::flattenRoles($roleHierarchy);
        foreach($roleHierarchy as $role){
            $roles[$role] = $t->trans($role, array(), "roles");
        }
        $this->roles = $roles;
    }

    public function getRoles(){
        return $this->roles;
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