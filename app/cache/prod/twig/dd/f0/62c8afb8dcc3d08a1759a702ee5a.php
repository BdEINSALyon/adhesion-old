<?php

/* ::navbar.html.twig */
class __TwigTemplate_ddf062c8afb8dcc3d08a1759a702ee5a extends Twig_Template
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
        // line 53
        echo " 


";
    }

    // line 1
    public function getinput($_add = null, $_search = null, $_cowei = null, $_admin = null, $_stats = null, $_profil = null)
    {
        $context = $this->env->mergeGlobals(array(
            "add" => $_add,
            "search" => $_search,
            "cowei" => $_cowei,
            "admin" => $_admin,
            "stats" => $_stats,
            "profil" => $_profil,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 2
            echo "<br/>
<div class=\"container\">
\t<div class=\"navbar\">
  \t\t<div class=\"navbar-inner\">
\t    \t\t<a class=\"brand\" >Menu</a>
\t    \t\t\t<ul class=\"nav\">
\t\t\t\t\t\t";
            // line 8
            if ($this->env->getExtension('security')->isGranted("ROLE_SOIREE")) {
                // line 9
                echo "\t\t\t\t\t\t\t<li class=\"";
                if (isset($context["add"])) { $_add_ = $context["add"]; } else { $_add_ = null; }
                echo twig_escape_filter($this->env, $_add_, "html", null, true);
                echo "\"><a href=\"";
                echo $this->env->getExtension('routing')->getPath("cva_gestion_membre_ajoutAdherent");
                echo "\">Ajout d'Adherent</a></li>
\t\t\t\t\t\t";
            }
            // line 11
            echo "\t\t\t\t\t\t
\t\t\t\t\t\t";
            // line 12
            if ($this->env->getExtension('security')->isGranted("ROLE_CONSULT")) {
                // line 13
                echo "\t\t\t\t\t\t\t<li  class=\"";
                if (isset($context["search"])) { $_search_ = $context["search"]; } else { $_search_ = null; }
                echo twig_escape_filter($this->env, $_search_, "html", null, true);
                echo "\">
\t\t\t\t\t\t\t\t<a href=\"";
                // line 14
                echo $this->env->getExtension('routing')->getPath("cva_gestion_membre_adherent");
                echo "\">Recherche d'Adherent</a>
\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t";
            }
            // line 17
            echo "
\t\t\t\t\t\t";
            // line 18
            if ($this->env->getExtension('security')->isGranted("ROLE_COWEI")) {
                // line 19
                echo "\t\t\t\t\t\t\t<li class=\"dropdown ";
                if (isset($context["cowei"])) { $_cowei_ = $context["cowei"]; } else { $_cowei_ = null; }
                echo twig_escape_filter($this->env, $_cowei_, "html", null, true);
                echo "\"> <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\"> Zone CoWEI <b class=\"caret\"></b> </a>
\t\t\t\t\t\t\t\t<ul class=\"dropdown-menu\">
\t\t\t\t\t\t\t\t\t<li><a href=\"";
                // line 21
                echo $this->env->getExtension('routing')->getPath("cva_gestion_membre_ajoutBizuthWEI");
                echo "\">Ajout Bizuth</a></li>
\t\t\t\t\t\t\t\t\t<li><a href=\"";
                // line 22
                echo $this->env->getExtension('routing')->getPath("cva_gestion_membre_rechercheBizuthWEI");
                echo "\">Recherche Bizuth</a></li>
\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t";
            }
            // line 26
            echo "\t\t\t\t\t\t\t
\t\t\t\t\t\t";
            // line 27
            if ($this->env->getExtension('security')->isGranted("ROLE_ADMIN")) {
                // line 28
                echo "\t\t\t\t\t\t\t<li class=\"dropdown ";
                if (isset($context["admin"])) { $_admin_ = $context["admin"]; } else { $_admin_ = null; }
                echo twig_escape_filter($this->env, $_admin_, "html", null, true);
                echo "\"> <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\"> Zone Admin <b class=\"caret\"></b> </a>
\t\t\t\t\t\t\t\t  <ul class=\"dropdown-menu\">
\t\t\t\t\t\t\t\t\t<li><a href=\"";
                // line 30
                echo $this->env->getExtension('routing')->getPath("cva_gestion_membre_addUser");
                echo "\">Ajout Utilisateur</a></li>
\t\t\t\t\t\t\t\t\t<li><a href=\"";
                // line 31
                echo $this->env->getExtension('routing')->getPath("cva_gestion_membre_editUser");
                echo "\">Modif Utilisateur</a></li>
\t\t\t\t\t\t\t\t\t<li class=\"divider\"></li>
\t\t\t\t\t\t\t\t\t<li><a href=\"";
                // line 33
                echo $this->env->getExtension('routing')->getPath("cva_gestion_membre_addProduit");
                echo "\">Ajout Produit</a></li>
\t\t\t\t\t\t\t\t\t<li><a href=\"";
                // line 34
                echo $this->env->getExtension('routing')->getPath("cva_gestion_membre_tableauProduits");
                echo "\">Modif Produit</a></li>
\t\t\t\t\t\t\t\t  </ul>
\t\t\t\t\t\t\t</li>\t
\t\t\t\t\t\t";
            }
            // line 38
            echo "\t\t\t\t\t</li>\t\t\t\t\t\t
\t      \t\t\t</ul>

\t\t\t\t<ul class=\"nav pull-right\">
\t\t\t\t";
            // line 42
            if ($this->env->getExtension('security')->isGranted("ROLE_PERM")) {
                // line 43
                echo "\t\t\t\t\t<li class=\"";
                if (isset($context["stats"])) { $_stats_ = $context["stats"]; } else { $_stats_ = null; }
                echo twig_escape_filter($this->env, $_stats_, "html", null, true);
                echo "\"><a href=\"";
                echo $this->env->getExtension('routing')->getPath("cva_gestion_membre_stats");
                echo "\">Statistiques</a></li>
\t\t\t\t\t<li class=\"";
                // line 44
                if (isset($context["profil"])) { $_profil_ = $context["profil"]; } else { $_profil_ = null; }
                echo twig_escape_filter($this->env, $_profil_, "html", null, true);
                echo "\"><a href=\"";
                echo $this->env->getExtension('routing')->getPath("cva_gestion_membre_profil");
                echo "\">Profil ";
                if (isset($context["app"])) { $_app_ = $context["app"]; } else { $_app_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($_app_, "user"), "username"), "html", null, true);
                echo " </a></li> 
\t\t\t\t";
            }
            // line 46
            echo "\t\t\t\t\t<li><a href=\"";
            echo $this->env->getExtension('routing')->getPath("logout");
            echo "\">Deconnexion</a></li>
\t    \t\t\t</ul>
\t \t\t</div>
\t\t</div>

</div>

";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    public function getTemplateName()
    {
        return "::navbar.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  160 => 46,  149 => 44,  141 => 43,  139 => 42,  133 => 38,  126 => 34,  122 => 33,  117 => 31,  113 => 30,  106 => 28,  104 => 27,  101 => 26,  94 => 22,  90 => 21,  83 => 19,  81 => 18,  72 => 14,  66 => 13,  64 => 12,  61 => 11,  52 => 9,  50 => 8,  26 => 1,  19 => 53,  245 => 100,  238 => 98,  235 => 97,  227 => 98,  224 => 97,  220 => 96,  214 => 94,  211 => 93,  206 => 90,  195 => 86,  190 => 83,  185 => 82,  178 => 78,  137 => 39,  107 => 35,  102 => 34,  97 => 33,  92 => 32,  87 => 31,  78 => 17,  73 => 29,  56 => 14,  53 => 13,  45 => 9,  42 => 2,  39 => 7,  33 => 5,  28 => 3,);
    }
}
