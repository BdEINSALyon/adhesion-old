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
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "etu"), "numEtudiant"), "html", null, true);
        echo "</p>
\t\t\t  <p><span class=\"label label-info\">Nom</span><br />";
        // line 3
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "etu"), "name"), "html", null, true);
        echo "</p>
\t\t\t  <p><span class=\"label label-info\">Prénom</span><br />";
        // line 4
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "etu"), "firstName"), "html", null, true);
        echo "</p>
\t\t\t  <p><span class=\"label label-info\">Etudes</span><br />";
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "etu"), "annee"), "html", null, true);
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "etu"), "departement"), "html", null, true);
        echo "</p>
\t\t\t  <p><span class=\"label label-info\">Téléphone</span><br />";
        // line 6
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "etu"), "tel"), "html", null, true);
        echo "</p>
\t\t\t  <p><span class=\"label label-info\">Email</span><br />";
        // line 7
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "etu"), "mail"), "html", null, true);
        echo "</p>
\t\t\t  <p><span class=\"label label-info\">Civilité</span><br />";
        // line 8
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "etu"), "civilite"), "html", null, true);
        echo "</p>
\t\t\t  <p><span class=\"label label-info\">Naissance</span><br />";
        // line 9
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($this->getContext($context, "etu"), "birthday"), "d-m-Y"), "html", null, true);
        echo "</p>
\t\t\t  <p><span class=\"label label-info\">Remarque</span><br />";
        // line 10
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "etu"), "remarque"), "html", null, true);
        echo "</p>
\t\t\t<p><span class=\"label label-info\">Produits</span><br />
\t\t\t  \t";
        // line 12
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getContext($context, "produits"));
        foreach ($context['_seq'] as $context["_key"] => $context["prod"]) {
            // line 13
            echo "\t\t\t  \t\t<li>";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "prod"), "description"), "html", null, true);
            echo "</li>
\t\t\t  \t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['prod'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 15
        echo "\t\t\t  </p>
\t\t\t<td>
\t\t\t\t<form action=\"editetudiant\" class=\"text-center btModifierEtudiant\">
\t\t\t\t\t<input type=\"hidden\" name=\"id\" value=\"";
        // line 18
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "etu"), "id"), "html", null, true);
        echo "\" />
\t\t\t\t\t";
        // line 19
        if ($this->env->getExtension('security')->isGranted("ROLE_PERM")) {
            // line 20
            echo "\t\t\t\t\t<button type=\"submit\" class=\"btn\">Modifier</button>
\t\t\t\t\t";
        }
        // line 22
        echo "\t\t\t\t\t";
        if ($this->env->getExtension('security')->isGranted("ROLE_MODO")) {
            // line 23
            echo "\t\t\t\t\t\t<a href=\"#myModal";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "etu"), "id"), "html", null, true);
            echo "\" role=\"button\" class=\"btn\" data-toggle=\"modal\">Supprimer</a>
\t\t\t\t\t";
        }
        // line 25
        echo "\t\t\t\t\t";
        if (($this->env->getExtension('security')->isGranted("ROLE_COWEI") && (!$this->env->getExtension('security')->isGranted("ROLE_ADMIN")))) {
            // line 26
            echo "\t\t\t\t\t\t<a href=\"";
            echo $this->env->getExtension('routing')->getPath("cva_gestion_membre_ajoutDetailsWEI");
            echo "?id=";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "etu"), "id"), "html", null, true);
            echo "\" role=\"button\" class=\"btn\" data-toggle=\"modal\">Details WEI</a>
\t\t\t\t\t";
        }
        // line 28
        echo "\t\t\t\t\t";
        if ($this->env->getExtension('security')->isGranted("ROLE_PERM")) {
            // line 29
            echo "\t\t\t\t\t\t<a href=\"";
            echo $this->env->getExtension('routing')->getPath("cva_gestion_membre_editPaiement");
            echo "?id=";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "etu"), "id"), "html", null, true);
            echo "\" role=\"button\" class=\"btn\" data-toggle=\"modal\">Produits</a>
\t\t\t\t\t";
        }
        // line 31
        echo "\t\t\t\t</form>
\t\t\t\t
\t\t\t\t
\t\t\t\t
\t\t\t</td>
\t\t\t<div id=\"myModal";
        // line 36
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "etu"), "id"), "html", null, true);
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
        // line 46
        echo $this->env->getExtension('routing')->getPath("cva_gestion_membre_deleteAdherent");
        echo "?id=";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "etu"), "id"), "html", null, true);
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
        return array (  139 => 46,  126 => 36,  119 => 31,  111 => 29,  108 => 28,  100 => 26,  97 => 25,  91 => 23,  88 => 22,  84 => 20,  82 => 19,  78 => 18,  73 => 15,  64 => 13,  60 => 12,  55 => 10,  51 => 9,  47 => 8,  43 => 7,  39 => 6,  34 => 5,  30 => 4,  26 => 3,  22 => 2,  19 => 1,);
    }
}
