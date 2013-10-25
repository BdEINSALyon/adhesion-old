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
                echo twig_escape_filter($this->env, $this->getContext($context, "add"), "html", null, true);
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
                echo twig_escape_filter($this->env, $this->getContext($context, "search"), "html", null, true);
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
                echo twig_escape_filter($this->env, $this->getContext($context, "cowei"), "html", null, true);
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
                echo twig_escape_filter($this->env, $this->getContext($context, "admin"), "html", null, true);
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
                echo twig_escape_filter($this->env, $this->getContext($context, "stats"), "html", null, true);
                echo "\"><a href=\"";
                echo $this->env->getExtension('routing')->getPath("cva_gestion_membre_stats");
                echo "\">Statistiques</a></li>
\t\t\t\t\t<li class=\"";
                // line 44
                echo twig_escape_filter($this->env, $this->getContext($context, "profil"), "html", null, true);
                echo "\"><a href=\"";
                echo $this->env->getExtension('routing')->getPath("cva_gestion_membre_profil");
                echo "\">Profil ";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getContext($context, "app"), "user"), "username"), "html", null, true);
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
        return array (  153 => 46,  144 => 44,  137 => 43,  135 => 42,  129 => 38,  122 => 34,  118 => 33,  113 => 31,  109 => 30,  103 => 28,  101 => 27,  98 => 26,  81 => 19,  79 => 18,  70 => 14,  65 => 13,  63 => 12,  60 => 11,  50 => 8,  26 => 1,  19 => 53,  230 => 100,  224 => 98,  221 => 97,  214 => 98,  211 => 97,  207 => 96,  201 => 94,  198 => 93,  193 => 90,  183 => 86,  178 => 83,  174 => 82,  167 => 78,  126 => 39,  99 => 35,  95 => 34,  91 => 22,  87 => 21,  83 => 31,  76 => 17,  72 => 29,  55 => 14,  52 => 9,  45 => 9,  42 => 2,  39 => 7,  33 => 5,  28 => 3,);
    }
}
