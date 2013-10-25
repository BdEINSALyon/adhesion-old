<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appDevUrlMatcher
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appDevUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);

        if (0 === strpos($pathinfo, '/_')) {
            // _wdt
            if (0 === strpos($pathinfo, '/_wdt') && preg_match('#^/_wdt/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_wdt')), array (  '_controller' => 'web_profiler.controller.profiler:toolbarAction',));
            }

            if (0 === strpos($pathinfo, '/_profiler')) {
                // _profiler_home
                if (rtrim($pathinfo, '/') === '/_profiler') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_profiler_home');
                    }

                    return array (  '_controller' => 'web_profiler.controller.profiler:homeAction',  '_route' => '_profiler_home',);
                }

                if (0 === strpos($pathinfo, '/_profiler/search')) {
                    // _profiler_search
                    if ($pathinfo === '/_profiler/search') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchAction',  '_route' => '_profiler_search',);
                    }

                    // _profiler_search_bar
                    if ($pathinfo === '/_profiler/search_bar') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchBarAction',  '_route' => '_profiler_search_bar',);
                    }

                }

                // _profiler_purge
                if ($pathinfo === '/_profiler/purge') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:purgeAction',  '_route' => '_profiler_purge',);
                }

                if (0 === strpos($pathinfo, '/_profiler/i')) {
                    // _profiler_info
                    if (0 === strpos($pathinfo, '/_profiler/info') && preg_match('#^/_profiler/info/(?P<about>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_info')), array (  '_controller' => 'web_profiler.controller.profiler:infoAction',));
                    }

                    // _profiler_import
                    if ($pathinfo === '/_profiler/import') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:importAction',  '_route' => '_profiler_import',);
                    }

                }

                // _profiler_export
                if (0 === strpos($pathinfo, '/_profiler/export') && preg_match('#^/_profiler/export/(?P<token>[^/\\.]++)\\.txt$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_export')), array (  '_controller' => 'web_profiler.controller.profiler:exportAction',));
                }

                // _profiler_phpinfo
                if ($pathinfo === '/_profiler/phpinfo') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  '_route' => '_profiler_phpinfo',);
                }

                // _profiler_search_results
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/search/results$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_search_results')), array (  '_controller' => 'web_profiler.controller.profiler:searchResultsAction',));
                }

                // _profiler
                if (preg_match('#^/_profiler/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler')), array (  '_controller' => 'web_profiler.controller.profiler:panelAction',));
                }

                // _profiler_router
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/router$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_router')), array (  '_controller' => 'web_profiler.controller.router:panelAction',));
                }

                // _profiler_exception
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception')), array (  '_controller' => 'web_profiler.controller.exception:showAction',));
                }

                // _profiler_exception_css
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception\\.css$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception_css')), array (  '_controller' => 'web_profiler.controller.exception:cssAction',));
                }

            }

            if (0 === strpos($pathinfo, '/_configurator')) {
                // _configurator_home
                if (rtrim($pathinfo, '/') === '/_configurator') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_configurator_home');
                    }

                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::checkAction',  '_route' => '_configurator_home',);
                }

                // _configurator_step
                if (0 === strpos($pathinfo, '/_configurator/step') && preg_match('#^/_configurator/step/(?P<index>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_configurator_step')), array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::stepAction',));
                }

                // _configurator_final
                if ($pathinfo === '/_configurator/final') {
                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::finalAction',  '_route' => '_configurator_final',);
                }

            }

        }

        // cva_gestion_membre_ajoutAdherent
        if ($pathinfo === '/ajoutAdherent') {
            return array (  '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::ajoutAdherentAction',  '_route' => 'cva_gestion_membre_ajoutAdherent',);
        }

        // cva_gestion_membre_caca
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'cva_gestion_membre_caca');
            }

            return array (  '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::cacaAction',  '_route' => 'cva_gestion_membre_caca',);
        }

        // cva_gestion_membre_paiement
        if ($pathinfo === '/paiement') {
            return array (  '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::paiementAction',  '_route' => 'cva_gestion_membre_paiement',);
        }

        // cva_gestion_membre_editPaiement
        if ($pathinfo === '/editPaiement') {
            return array (  '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::editPaiementAction',  '_route' => 'cva_gestion_membre_editPaiement',);
        }

        // cva_gestion_membre_deletePaiement
        if ($pathinfo === '/deletePaiement') {
            return array (  '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::deletePaiementAction',  '_route' => 'cva_gestion_membre_deletePaiement',);
        }

        if (0 === strpos($pathinfo, '/ad')) {
            // cva_gestion_membre_deleteAdherent
            if ($pathinfo === '/admin/deleteAdherent') {
                return array (  '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::deleteAdherentAction',  '_route' => 'cva_gestion_membre_deleteAdherent',);
            }

            // cva_gestion_membre_adherent
            if ($pathinfo === '/adherent') {
                return array (  '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::adherentAction',  '_route' => 'cva_gestion_membre_adherent',);
            }

            // cva_gestion_membre_admin
            if ($pathinfo === '/admin') {
                return array (  '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::adminAction',  '_route' => 'cva_gestion_membre_admin',);
            }

        }

        // cva_gestion_membre_voirDetails
        if ($pathinfo === '/voirDetails') {
            return array (  '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::voirDetailsAction',  '_route' => 'cva_gestion_membre_voirDetails',);
        }

        if (0 === strpos($pathinfo, '/editetudiant')) {
            // cva_gestion_membre_edit
            if ($pathinfo === '/editetudiant') {
                return array (  '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::editEtudiantAction',  '_route' => 'cva_gestion_membre_edit',);
            }

            // cva_gestion_membre_editConfirm
            if ($pathinfo === '/editetudiantConfirm') {
                return array (  '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::editEtudiantConfirmAction',  '_route' => 'cva_gestion_membre_editConfirm',);
            }

        }

        // cva_gestion_membre_addUser
        if ($pathinfo === '/admin/addUser') {
            return array (  '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::addUserAction',  '_route' => 'cva_gestion_membre_addUser',);
        }

        // cva_gestion_membre_stats
        if ($pathinfo === '/stats') {
            return array (  '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::statsAction',  '_route' => 'cva_gestion_membre_stats',);
        }

        if (0 === strpos($pathinfo, '/admin')) {
            // cva_gestion_membre_modifUser
            if ($pathinfo === '/admin/modifUser') {
                return array (  '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::modifUserAction',  '_route' => 'cva_gestion_membre_modifUser',);
            }

            // cva_gestion_membre_editUser
            if ($pathinfo === '/admin/editUser') {
                return array (  '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::editUserAction',  '_route' => 'cva_gestion_membre_editUser',);
            }

            // cva_gestion_membre_deleteUser
            if ($pathinfo === '/admin/deleteUser') {
                return array (  '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::deleteUserAction',  '_route' => 'cva_gestion_membre_deleteUser',);
            }

            // cva_gestion_membre_addProduit
            if ($pathinfo === '/admin/addProduit') {
                return array (  '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::addProduitAction',  '_route' => 'cva_gestion_membre_addProduit',);
            }

            // cva_gestion_membre_editProduit
            if ($pathinfo === '/admin/editProduit') {
                return array (  '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::editProduitAction',  '_route' => 'cva_gestion_membre_editProduit',);
            }

            // cva_gestion_membre_tableauProduits
            if ($pathinfo === '/admin/tableauProduits') {
                return array (  '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::tableauProduitsAction',  '_route' => 'cva_gestion_membre_tableauProduits',);
            }

            // cva_gestion_membre_deleteProduit
            if ($pathinfo === '/admin/deleteProduit') {
                return array (  '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::deleteProduitAction',  '_route' => 'cva_gestion_membre_deleteProduit',);
            }

        }

        // cva_gestion_membre_profil
        if ($pathinfo === '/profil') {
            return array (  '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::profilAction',  '_route' => 'cva_gestion_membre_profil',);
        }

        // cva_gestion_membre_get
        if ($pathinfo === '/get') {
            return array (  '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::getAction',  '_route' => 'cva_gestion_membre_get',);
        }

        // cva_gestion_membre_exportCSV
        if ($pathinfo === '/exportCSV') {
            return array (  '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::exportCSVAction',  '_route' => 'cva_gestion_membre_exportCSV',);
        }

        if (0 === strpos($pathinfo, '/wei')) {
            // cva_gestion_membre_ajoutBizuthWEI
            if ($pathinfo === '/wei/ajoutBizuthWEI') {
                return array (  '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::ajoutBizuthWEIAction',  '_route' => 'cva_gestion_membre_ajoutBizuthWEI',);
            }

            // cva_gestion_membre_rechercheBizuthWEI
            if ($pathinfo === '/wei/rechercheBizuthWEI') {
                return array (  '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::rechercheBizuthWEIAction',  '_route' => 'cva_gestion_membre_rechercheBizuthWEI',);
            }

            // cva_gestion_membre_editBizuthWEI
            if ($pathinfo === '/wei/editetudiant') {
                return array (  '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::editEtudiantAction',  '_route' => 'cva_gestion_membre_editBizuthWEI',);
            }

            // cva_gestion_membre_paiementBizuthWEI
            if ($pathinfo === '/wei/paiement') {
                return array (  '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::paiementAction',  '_route' => 'cva_gestion_membre_paiementBizuthWEI',);
            }

            // cva_gestion_membre_ajoutDetailsWEI
            if ($pathinfo === '/wei/ajoutDetailsWEI') {
                return array (  '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::ajoutDetailsWEIAction',  '_route' => 'cva_gestion_membre_ajoutDetailsWEI',);
            }

            // cva_gestion_membre_voirDetails2
            if ($pathinfo === '/wei/voirDetails') {
                return array (  '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::voirDetailsAction',  '_route' => 'cva_gestion_membre_voirDetails2',);
            }

        }

        if (0 === strpos($pathinfo, '/log')) {
            if (0 === strpos($pathinfo, '/login')) {
                // login
                if ($pathinfo === '/login') {
                    return array (  '_controller' => 'Cva\\GestionMembreBundle\\Controller\\GestionMembreController::loginAction',  '_route' => 'login',);
                }

                // login_check
                if ($pathinfo === '/login_check') {
                    return array('_route' => 'login_check');
                }

            }

            // logout
            if ($pathinfo === '/logout') {
                return array('_route' => 'logout');
            }

        }

        if (0 === strpos($pathinfo, '/js')) {
            if (0 === strpos($pathinfo, '/js/be65024')) {
                // _assetic_be65024
                if ($pathinfo === '/js/be65024.js') {
                    return array (  '_controller' => 'assetic.controller:render',  'name' => 'be65024',  'pos' => NULL,  '_format' => 'js',  '_route' => '_assetic_be65024',);
                }

                // _assetic_be65024_0
                if ($pathinfo === '/js/be65024_ajout_1.js') {
                    return array (  '_controller' => 'assetic.controller:render',  'name' => 'be65024',  'pos' => 0,  '_format' => 'js',  '_route' => '_assetic_be65024_0',);
                }

            }

            if (0 === strpos($pathinfo, '/js/29f8d6d')) {
                // _assetic_29f8d6d
                if ($pathinfo === '/js/29f8d6d.js') {
                    return array (  '_controller' => 'assetic.controller:render',  'name' => '29f8d6d',  'pos' => NULL,  '_format' => 'js',  '_route' => '_assetic_29f8d6d',);
                }

                // _assetic_29f8d6d_0
                if ($pathinfo === '/js/29f8d6d_tableau_1.js') {
                    return array (  '_controller' => 'assetic.controller:render',  'name' => '29f8d6d',  'pos' => 0,  '_format' => 'js',  '_route' => '_assetic_29f8d6d_0',);
                }

            }

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
