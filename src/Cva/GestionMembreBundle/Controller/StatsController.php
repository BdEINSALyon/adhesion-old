<?php

namespace Cva\GestionMembreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StatsController extends Controller
{
    public function mainAction()
    {
        $statsService = $this->get("cva.gestion_membre.stats");
        return $this->render("@CvaGestionMembre/Stats/main.html.twig",array(
            'statsByProduct' => $statsService->getSellsByActiveProduct(),
            'statsByYear' => $statsService->getMembersByYear(),
            'statsByDepartment' => $statsService->getMembersByDepartment(),
            'amountSold' => $this->get('doctrine.orm.entity_manager')->getRepository('CvaGestionMembreBundle:Payment')->countMonthSales(),
        ));
    }
}
