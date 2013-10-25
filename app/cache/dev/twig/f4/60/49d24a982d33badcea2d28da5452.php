<?php

/* CvaGestionMembreBundle::rechercheBizuthWEI.html.twig */
class __TwigTemplate_f46049d24a982d33badcea2d28da5452 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("::base.html.twig");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'navbar' => array($this, 'block_navbar'),
            'content' => array($this, 'block_content'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 3
        $context["navbar"] = $this->env->loadTemplate("::navbar.html.twig");
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        echo " Rechercher Bizuth WEI ";
    }

    // line 7
    public function block_navbar($context, array $blocks = array())
    {
        // line 8
        echo "\t\t";
        echo $context["navbar"]->getinput("", "", "active");
        echo "
\t";
    }

    // line 12
    public function block_content($context, array $blocks = array())
    {
        // line 13
        echo "\t
\t\t<div class =\"container\">
\t\t<div class=\"row\">
\t\t\t\t<div class=\"span9\">
\t\t\t\t\t<table class=\"table table-bordered table-hover table-striped\" id=\"table_adherent\">
\t\t\t\t\t  <thead>
 \t\t\t\t\t\t<tr id=\"search\">
\t\t\t\t\t\t\t<th>Nom</th>
\t\t\t\t\t\t\t<th>Prénom</th>
\t\t\t\t\t\t\t<th>Date de Naissance</th>
\t\t\t\t\t\t\t<th>Bus</th>
\t\t\t\t\t\t\t<th>Bungalow</th>
\t\t\t\t\t\t\t<th class=\"hidden\">Majeur ?</th>
\t\t\t\t\t\t\t<th >Majeur ?</th>
\t\t\t\t\t\t\t<th class=\"hidden\">Remarque</th>
\t\t\t\t\t\t\t<th class=\"hidden\">Produits</th>
\t\t\t\t\t\t</tr> 
\t\t\t\t\t  </thead>\t\t\t\t\t  
\t\t\t\t\t  <tbody id=\"etudiants\">\t\t\t  

\t\t\t\t\t\t";
        // line 33
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getContext($context, "adherent"));
        foreach ($context['_seq'] as $context["_key"] => $context["adh"]) {
            // line 34
            echo "\t\t\t\t\t\t\t\t<tr id=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getContext($context, "adh"), "bizuth"), "id"), "html", null, true);
            echo "\" onclick=\"return voir(";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getContext($context, "adh"), "bizuth"), "id"), "html", null, true);
            echo ");\">
\t\t\t\t\t\t\t\t\t  <td>";
            // line 35
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getContext($context, "adh"), "bizuth"), "name"), "html", null, true);
            echo "</td>
\t\t\t\t\t\t\t\t\t  <td>";
            // line 36
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getContext($context, "adh"), "bizuth"), "firstName"), "html", null, true);
            echo "</td>
\t\t\t\t\t\t\t\t\t<td>";
            // line 37
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($this->getAttribute($this->getContext($context, "adh"), "bizuth"), "birthday"), "d-m-Y"), "html", null, true);
            echo "</td>
\t\t\t\t\t\t\t\t\t  <td>";
            // line 38
            echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "adh"), "bus"), "html", null, true);
            echo "</td>
\t\t\t\t\t\t\t\t\t  <td>";
            // line 39
            echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "adh"), "bung"), "html", null, true);
            echo "</td>
\t\t\t\t\t\t\t\t\t<td class=\"hidden\"> ";
            // line 40
            echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "adh"), "majeur"), "html", null, true);
            echo " </td>
\t\t\t\t\t\t\t\t\t<td style=\"text-align:center;\">";
            // line 41
            if (($this->getAttribute($this->getContext($context, "adh"), "majeur") == "Mineur")) {
                echo "<img src=";
                echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("img/18.jpg"), "html", null, true);
                echo " height=\"20\" width=\"20\"> ";
            }
            echo "</td>
\t\t\t\t\t\t\t\t\t<td class=\"hidden\"> ";
            // line 42
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getContext($context, "adh"), "bizuth"), "remarque"), "html", null, true);
            echo " </td>
\t\t\t\t\t\t\t\t\t<td class=\"hidden\">";
            // line 43
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getContext($context, "adh"), "prods"));
            foreach ($context['_seq'] as $context["_key"] => $context["paiement"]) {
                echo " ";
                $context['_parent'] = (array) $context;
                $context['_seq'] = twig_ensure_traversable($this->getContext($context, "paiement"));
                foreach ($context['_seq'] as $context["_key"] => $context["prod"]) {
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "prod"), "description"), "html", null, true);
                    echo " ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['prod'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                echo " ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['paiement'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            echo " </td>
\t\t\t\t\t\t\t\t</tr>\t
\t\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['adh'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 45
        echo "\t

\t\t\t\t\t  </tbody>
\t\t\t\t\t</table>
<div align=\"right\"><button class=\"btn btn-medium btn-info\" onclick=\"createCSV('table_adherent',3)\"> Export CSV </button></div>
\t\t\t\t</div>
\t\t\t\t\t\t
\t\t\t\t<div class=\"span3\">\t\t
\t\t\t\t
\t\t\t\t\t<table id=\"details_droite\" class=\"table table-bordered detailed-table\">
\t\t\t\t\t\t<thead>
\t\t\t\t\t\t\t<th>
\t\t\t\t\t\t\t\tDétails:
\t\t\t\t\t\t\t</th>
\t\t\t\t\t\t</thead>
\t\t\t\t\t  <tbody id=\"detailed-body\" class=\"details\">
\t\t\t\t\t\t<tr class=\"infos\">
\t\t\t\t\t\t\t<td id=\"voirEtudiant\"></td>
\t\t\t\t\t\t</tr>

\t\t\t\t\t\t<div id=\"myModal\" class=\"modal hide fade\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
\t\t\t\t\t\t\t\t  <div class=\"modal-header\">
\t\t\t\t\t\t\t\t\t\t<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">x</button>
\t\t\t\t\t\t\t\t\t\t<h3 id=\"myModalLabel\">Confirmation</h3>
\t\t\t\t\t\t\t\t  </div>
\t\t\t\t\t\t\t\t  <div class=\"modal-body\">
\t\t\t\t\t\t\t\t\t\t<p>Voulez-vous vraiment supprimer cet utilisateur ?</p>
\t\t\t\t\t\t\t\t  </div>
\t\t\t\t\t\t\t\t  <div class=\"modal-footer\">
\t\t\t\t\t\t\t\t\t\t<button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Non</button>
\t\t\t\t\t\t\t\t\t\t<a role=\"button\" href=\"\" class=\"btn btn-primary\">Oui</a>
\t\t\t\t\t\t\t\t  </div>
\t\t\t\t\t\t</div>
\t\t\t\t\t  </tbody>
\t\t\t\t\t</table>
\t\t\t\t</div>
\t\t\t</div>
\t\t\t
\t\t</div>

\t\t<form action=\"";
        // line 85
        echo $this->env->getExtension('routing')->getPath("cva_gestion_membre_exportCSV");
        echo "\" method=\"post\" name=\"formCSV\">
\t\t<input type=\"hidden\" name=\"csvText\" id=\"csvText\"/>
\t\t</form>
\t\t
\t\t";
    }

    // line 90
    public function block_javascripts($context, array $blocks = array())
    {
        // line 91
        echo "\t\t\t   ";
        $this->displayParentBlock("javascripts", $context, $blocks);
        echo "
\t\t\t\t<script src=\"http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js\"></script>\t
\t\t\t";
        // line 93
        if (isset($context['assetic']['debug']) && $context['assetic']['debug']) {
            // asset "29f8d6d_0"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_29f8d6d_0") : $this->env->getExtension('assets')->getAssetUrl("_controller/js/29f8d6d_tableau_1.js");
            // line 94
            echo "\t\t\t\t
\t\t\t\t<script type=\"text/javascript\" src=\"";
            // line 95
            echo twig_escape_filter($this->env, $this->getContext($context, "asset_url"), "html", null, true);
            echo "\"></script>
\t\t\t";
        } else {
            // asset "29f8d6d"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_29f8d6d") : $this->env->getExtension('assets')->getAssetUrl("_controller/js/29f8d6d.js");
            // line 94
            echo "\t\t\t\t
\t\t\t\t<script type=\"text/javascript\" src=\"";
            // line 95
            echo twig_escape_filter($this->env, $this->getContext($context, "asset_url"), "html", null, true);
            echo "\"></script>
\t\t\t";
        }
        unset($context["asset_url"]);
        // line 97
        echo "\t\t";
    }

    public function getTemplateName()
    {
        return "CvaGestionMembreBundle::rechercheBizuthWEI.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  230 => 97,  224 => 95,  221 => 94,  214 => 95,  211 => 94,  207 => 93,  201 => 91,  198 => 90,  189 => 85,  147 => 45,  121 => 43,  117 => 42,  109 => 41,  105 => 40,  101 => 39,  97 => 38,  93 => 37,  89 => 36,  85 => 35,  78 => 34,  74 => 33,  52 => 13,  49 => 12,  42 => 8,  39 => 7,  33 => 5,  28 => 3,);
    }
}
