<?php

/* CvaGestionMembreBundle::voirDetails.html.twig */
class __TwigTemplate_9eb26b0745817fb8133ea3b1994e2fd9 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "
\t\t\t  <p><span class=\"label label-info\">N° Etudiant</span><br />";
        // line 2
        if (isset($context["etu"])) { $_etu_ = $context["etu"]; } else { $_etu_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_etu_, "numEtudiant"), "html", null, true);
        echo "</p>
\t\t\t  <p><span class=\"label label-info\">Nom</span><br />";
        // line 3
        if (isset($context["etu"])) { $_etu_ = $context["etu"]; } else { $_etu_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_etu_, "name"), "html", null, true);
        echo "</p>
\t\t\t  <p><span class=\"label label-info\">Prénom</span><br />";
        // line 4
        if (isset($context["etu"])) { $_etu_ = $context["etu"]; } else { $_etu_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_etu_, "firstName"), "html", null, true);
        echo "</p>
\t\t\t  <p><span class=\"label label-info\">Etudes</span><br />";
        // line 5
        if (isset($context["etu"])) { $_etu_ = $context["etu"]; } else { $_etu_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_etu_, "annee"), "html", null, true);
        if (isset($context["etu"])) { $_etu_ = $context["etu"]; } else { $_etu_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_etu_, "departement"), "html", null, true);
        echo "</p>
\t\t\t  <p><span class=\"label label-info\">Téléphone</span><br />";
        // line 6
        if (isset($context["etu"])) { $_etu_ = $context["etu"]; } else { $_etu_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_etu_, "tel"), "html", null, true);
        echo "</p>
\t\t\t  <p><span class=\"label label-info\">Email</span><br />";
        // line 7
        if (isset($context["etu"])) { $_etu_ = $context["etu"]; } else { $_etu_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_etu_, "mail"), "html", null, true);
        echo "</p>
\t\t\t  <p><span class=\"label label-info\">Civilité</span><br />";
        // line 8
        if (isset($context["etu"])) { $_etu_ = $context["etu"]; } else { $_etu_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_etu_, "civilite"), "html", null, true);
        echo "</p>
\t\t\t  <p><span class=\"label label-info\">Naissance</span><br />";
        // line 9
        if (isset($context["etu"])) { $_etu_ = $context["etu"]; } else { $_etu_ = null; }
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($_etu_, "birthday"), "d-m-Y"), "html", null, true);
        echo "</p>
\t\t\t  ";
        // line 10
        if ($this->env->getExtension('security')->isGranted("ROLE_COWEI")) {
            // line 11
            echo "\t\t\t  <p><span class=\"label label-info\">Remarque</span><br />";
            if (isset($context["etu"])) { $_etu_ = $context["etu"]; } else { $_etu_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_etu_, "remarque"), "html", null, true);
            echo "</p>
\t\t\t  ";
        }
        // line 13
        echo "\t\t\t<p><span class=\"label label-info\">Produits</span><br />
\t\t\t  \t";
        // line 14
        if (isset($context["produits"])) { $_produits_ = $context["produits"]; } else { $_produits_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_produits_);
        foreach ($context['_seq'] as $context["_key"] => $context["prod"]) {
            // line 15
            echo "\t\t\t  \t\t<li>";
            if (isset($context["prod"])) { $_prod_ = $context["prod"]; } else { $_prod_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_prod_, "description"), "html", null, true);
            echo "</li>
\t\t\t  \t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['prod'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 17
        echo "\t\t\t  </p>
\t\t\t<td>
\t\t\t\t<form action=\"editetudiant\" class=\"text-center btModifierEtudiant\">
\t\t\t\t\t<input type=\"hidden\" name=\"id\" value=\"";
        // line 20
        if (isset($context["etu"])) { $_etu_ = $context["etu"]; } else { $_etu_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_etu_, "id"), "html", null, true);
        echo "\" />
\t\t\t\t\t";
        // line 21
        if ($this->env->getExtension('security')->isGranted("ROLE_PERM")) {
            // line 22
            echo "\t\t\t\t\t<button type=\"submit\" class=\"btn\">Modifier</button>
\t\t\t\t\t";
        }
        // line 24
        echo "\t\t\t\t\t";
        if ($this->env->getExtension('security')->isGranted("ROLE_MODO")) {
            // line 25
            echo "\t\t\t\t\t\t<a href=\"#myModal";
            if (isset($context["etu"])) { $_etu_ = $context["etu"]; } else { $_etu_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_etu_, "id"), "html", null, true);
            echo "\" role=\"button\" class=\"btn\" data-toggle=\"modal\">Supprimer</a>
\t\t\t\t\t";
        }
        // line 27
        echo "\t\t\t\t\t";
        if (($this->env->getExtension('security')->isGranted("ROLE_COWEI") && (!$this->env->getExtension('security')->isGranted("ROLE_ADMIN")))) {
            // line 28
            echo "\t\t\t\t\t\t<a href=\"";
            echo $this->env->getExtension('routing')->getPath("cva_gestion_membre_ajoutDetailsWEI");
            echo "?id=";
            if (isset($context["etu"])) { $_etu_ = $context["etu"]; } else { $_etu_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_etu_, "id"), "html", null, true);
            echo "\" role=\"button\" class=\"btn\" data-toggle=\"modal\">Details WEI</a>
\t\t\t\t\t";
        }
        // line 30
        echo "\t\t\t\t\t";
        if ($this->env->getExtension('security')->isGranted("ROLE_PERM")) {
            // line 31
            echo "\t\t\t\t\t\t<a href=\"";
            echo $this->env->getExtension('routing')->getPath("cva_gestion_membre_editPaiement");
            echo "?id=";
            if (isset($context["etu"])) { $_etu_ = $context["etu"]; } else { $_etu_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_etu_, "id"), "html", null, true);
            echo "\" role=\"button\" class=\"btn\" data-toggle=\"modal\">Produits</a>
\t\t\t\t\t";
        }
        // line 33
        echo "\t\t\t\t</form>
\t\t\t\t
\t\t\t\t
\t\t\t\t
\t\t\t</td>
\t\t\t<div id=\"myModal";
        // line 38
        if (isset($context["etu"])) { $_etu_ = $context["etu"]; } else { $_etu_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_etu_, "id"), "html", null, true);
        echo "\" class=\"modal hide fade\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
\t\t\t\t\t  <div class=\"modal-header\">
\t\t\t\t\t\t\t<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">x</button>
\t\t\t\t\t\t\t<h3 id=\"myModalLabel\">Confirmation</h3>
\t\t\t\t\t  </div>
\t\t\t\t\t  <div class=\"modal-body\">
\t\t\t\t\t\t\t<p>Voulez-vous vraiment supprimer cet utilisateur ?</p>
\t\t\t\t\t  </div>
\t\t\t\t\t  <div class=\"modal-footer\">
\t\t\t\t\t\t\t<button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Non</button>
\t\t\t\t\t\t\t<a role=\"button\" href=\"";
        // line 48
        echo $this->env->getExtension('routing')->getPath("cva_gestion_membre_deleteAdherent");
        echo "?id=";
        if (isset($context["etu"])) { $_etu_ = $context["etu"]; } else { $_etu_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_etu_, "id"), "html", null, true);
        echo "\" class=\"btn btn-primary\">Oui</a>
\t\t\t\t\t  </div>
\t\t\t</div>
";
    }

    public function getTemplateName()
    {
        return "CvaGestionMembreBundle::voirDetails.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  162 => 48,  148 => 38,  141 => 33,  132 => 31,  129 => 30,  120 => 28,  117 => 27,  110 => 25,  107 => 24,  103 => 22,  101 => 21,  96 => 20,  91 => 17,  81 => 15,  76 => 14,  73 => 13,  66 => 11,  64 => 10,  59 => 9,  54 => 8,  49 => 7,  44 => 6,  37 => 5,  32 => 4,  27 => 3,  22 => 2,  19 => 1,);
    }
}
