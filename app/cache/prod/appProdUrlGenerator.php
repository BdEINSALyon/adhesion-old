<?php

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Psr\Log\LoggerInterface;

/**
 * appProdUrlGenerator
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appProdUrlGenerator extends Symfony\Component\Routing\Generator\UrlGenerator
{
    static private $declaredRoutes = array(
        'cva_gestion_membre_ajoutAdherent' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::ajoutAdherentAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/ajoutAdherent',    ),  ),  4 =>   array (  ),),
        'cva_gestion_membre_caca' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::cacaAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/',    ),  ),  4 =>   array (  ),),
        'cva_gestion_membre_paiement' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::paiementAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/paiement',    ),  ),  4 =>   array (  ),),
        'cva_gestion_membre_editPaiement' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::editPaiementAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/editPaiement',    ),  ),  4 =>   array (  ),),
        'cva_gestion_membre_deletePaiement' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::deletePaiementAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/deletePaiement',    ),  ),  4 =>   array (  ),),
        'cva_gestion_membre_deleteAdherent' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::deleteAdherentAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/admin/deleteAdherent',    ),  ),  4 =>   array (  ),),
        'cva_gestion_membre_adherent' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::adherentAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/adherent',    ),  ),  4 =>   array (  ),),
        'cva_gestion_membre_admin' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::adminAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/admin',    ),  ),  4 =>   array (  ),),
        'cva_gestion_membre_voirDetails' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::voirDetailsAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/voirDetails',    ),  ),  4 =>   array (  ),),
        'cva_gestion_membre_edit' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::editEtudiantAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/editetudiant',    ),  ),  4 =>   array (  ),),
        'cva_gestion_membre_editConfirm' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::editEtudiantConfirmAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/editetudiantConfirm',    ),  ),  4 =>   array (  ),),
        'cva_gestion_membre_addUser' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::addUserAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/admin/addUser',    ),  ),  4 =>   array (  ),),
        'cva_gestion_membre_stats' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::statsAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/stats',    ),  ),  4 =>   array (  ),),
        'cva_gestion_membre_modifUser' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::modifUserAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/admin/modifUser',    ),  ),  4 =>   array (  ),),
        'cva_gestion_membre_editUser' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::editUserAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/admin/editUser',    ),  ),  4 =>   array (  ),),
        'cva_gestion_membre_deleteUser' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::deleteUserAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/admin/deleteUser',    ),  ),  4 =>   array (  ),),
        'cva_gestion_membre_addProduit' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::addProduitAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/admin/addProduit',    ),  ),  4 =>   array (  ),),
        'cva_gestion_membre_editProduit' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::editProduitAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/admin/editProduit',    ),  ),  4 =>   array (  ),),
        'cva_gestion_membre_tableauProduits' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::tableauProduitsAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/admin/tableauProduits',    ),  ),  4 =>   array (  ),),
        'cva_gestion_membre_deleteProduit' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::deleteProduitAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/admin/deleteProduit',    ),  ),  4 =>   array (  ),),
        'cva_gestion_membre_profil' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::profilAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/profil',    ),  ),  4 =>   array (  ),),
        'cva_gestion_membre_exportCSV' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::exportCSVAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/exportCSV',    ),  ),  4 =>   array (  ),),
        'cva_gestion_membre_ajoutBizuthWEI' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::ajoutBizuthWEIAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/wei/ajoutBizuthWEI',    ),  ),  4 =>   array (  ),),
        'cva_gestion_membre_rechercheBizuthWEI' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::rechercheBizuthWEIAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/wei/rechercheBizuthWEI',    ),  ),  4 =>   array (  ),),
        'cva_gestion_membre_editBizuthWEI' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::editEtudiantAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/wei/editetudiant',    ),  ),  4 =>   array (  ),),
        'cva_gestion_membre_paiementBizuthWEI' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::paiementAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/wei/paiement',    ),  ),  4 =>   array (  ),),
        'cva_gestion_membre_ajoutDetailsWEI' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::ajoutDetailsWEIAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/wei/ajoutDetailsWEI',    ),  ),  4 =>   array (  ),),
        'cva_gestion_membre_voirDetails2' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::voirDetailsAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/wei/voirDetails',    ),  ),  4 =>   array (  ),),
        'login' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::loginAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/login',    ),  ),  4 =>   array (  ),),
        'login_check' => array (  0 =>   array (  ),  1 =>   array (  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/login_check',    ),  ),  4 =>   array (  ),),
        'logout' => array (  0 =>   array (  ),  1 =>   array (  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/logout',    ),  ),  4 =>   array (  ),),
    );

    /**
     * Constructor.
     */
    public function __construct(RequestContext $context, LoggerInterface $logger = null)
    {
        $this->context = $context;
        $this->logger = $logger;
    }

    public function generate($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH)
    {
        if (!isset(self::$declaredRoutes[$name])) {
            throw new RouteNotFoundException(sprintf('Unable to generate a URL for the named route "%s" as such route does not exist.', $name));
        }

        list($variables, $defaults, $requirements, $tokens, $hostTokens) = self::$declaredRoutes[$name];

        return $this->doGenerate($variables, $defaults, $requirements, $tokens, $parameters, $name, $referenceType, $hostTokens);
    }
}
