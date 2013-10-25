<?php

/* CvaGestionMembreBundle::rechercheAdherent.html.twig */
class __TwigTemplate_f705bdfc8700767746ed151bcac4acab extends Twig_Template
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
        echo " Rechercher Adherent ";
    }

    // line 7
    public function block_navbar($context, array $blocks = array())
    {
        // line 8
        echo "
\t\t";
        // line 9
        echo $context["navbar"]->getinput("", "active");
        echo "

\t";
    }

    // line 13
    public function block_content($context, array $blocks = array())
    {
        // line 14
        echo "\t
\t\t<div class =\"container\">
\t\t<div class=\"row\">
\t\t\t\t<div class=\"span9\" id=\"put_table_here\">
\t\t\t\t\t<table id=\"table_adherent\" class=\"table table-bordered table-hover table-striped\">
\t\t\t\t\t  <thead>
 \t\t\t\t\t\t<tr id=\"search\">
\t\t\t\t\t\t\t<th>N°Etudiant</th>
\t\t\t\t\t\t\t<th>Nom</th>
\t\t\t\t\t\t\t<th>Prénom</th>
\t\t\t\t\t\t\t<th>Email</th>
\t\t\t\t\t\t\t<th class=\"hidden\">Produits</th>
\t\t\t\t\t\t</tr> 
\t\t\t\t\t  </thead>\t\t\t\t\t  
\t\t\t\t\t  <tbody id=\"etudiants\">\t
\t\t\t\t\t\t";
        // line 29
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getContext($context, "adherent"));
        foreach ($context['_seq'] as $context["_key"] => $context["adh"]) {
            // line 30
            echo "\t\t\t\t\t\t\t\t<tr id=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getContext($context, "adh"), "bizuth"), "id"), "html", null, true);
            echo "\" onclick=\"return voir(";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getContext($context, "adh"), "bizuth"), "id"), "html", null, true);
            echo ");\">
\t\t\t\t\t\t\t\t\t  <td>";
            // line 31
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getContext($context, "adh"), "bizuth"), "numEtudiant"), "html", null, true);
            echo "</td>
\t\t\t\t\t\t\t\t\t  <td>";
            // line 32
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getContext($context, "adh"), "bizuth"), "name"), "html", null, true);
            echo "</td>
\t\t\t\t\t\t\t\t\t  <td>";
            // line 33
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getContext($context, "adh"), "bizuth"), "firstName"), "html", null, true);
            echo "</td>
\t\t\t\t\t\t\t\t\t  <td>";
            // line 34
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getContext($context, "adh"), "bizuth"), "mail"), "html", null, true);
            echo "</td>
\t\t\t\t\t\t\t\t\t  <td class=\"hidden\">";
            // line 35
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
        // line 39
        echo "\t\t\t\t\t  </tbody>
\t\t\t\t\t</table>
\t\t\t\t<div align=\"right\"><button class=\"btn btn-medium btn-info\" onclick=\"createCSV('table_adherent',1)\"> Export CSV </button></div>
\t\t\t\t</div>
\t\t\t\t\t
\t\t\t\t<div class=\"span3\">\t

\t\t\t\t\t<table id =\"details_droite\" class=\"table table-bordered detailed-table\">
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
        // line 78
        echo $this->env->getExtension('routing')->getPath("cva_gestion_membre_exportCSV");
        echo "\" method=\"post\" name=\"formCSV\">
\t\t<input type=\"hidden\" name=\"csvText\" id=\"csvText\"/>
\t\t</form>

\t\t";
        // line 82
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute($this->getContext($context, "app"), "session"), "flashbag"), "get", array(0 => "notice"), "method"));
        foreach ($context['_seq'] as $context["_key"] => $context["flashMessage"]) {
            // line 83
            echo "\t\t\t<div class=\"row\">
\t\t\t\t<div class=\"span4 offset2 alert alert-success\">
\t\t\t\t  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
\t\t\t\t  <strong>";
            // line 86
            echo twig_escape_filter($this->env, $this->getContext($context, "flashMessage"), "html", null, true);
            echo "</strong>
\t\t\t\t</div>
\t\t\t</div>
\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['flashMessage'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 90
        echo "\t\t
\t\t";
    }

    // line 93
    public function block_javascripts($context, array $blocks = array())
    {
        // line 94
        echo "\t\t\t   ";
        $this->displayParentBlock("javascripts", $context, $blocks);
        echo "
\t\t\t\t<script src=\"http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js\"></script>\t
\t\t\t";
        // line 96
        if (isset($context['assetic']['debug']) && $context['assetic']['debug']) {
            // asset "29f8d6d_0"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_29f8d6d_0") : $this->env->getExtension('assets')->getAssetUrl("_controller/js/29f8d6d_tableau_1.js");
            // line 97
            echo "\t\t\t\t
\t\t\t\t<script type=\"text/javascript\" src=\"";
            // line 98
            echo twig_escape_filter($this->env, $this->getContext($context, "asset_url"), "html", null, true);
            echo "\"></script>
\t\t\t";
        } else {
            // asset "29f8d6d"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_29f8d6d") : $this->env->getExtension('assets')->getAssetUrl("_controller/js/29f8d6d.js");
            // line 97
            echo "\t\t\t\t
\t\t\t\t<script type=\"text/javascript\" src=\"";
            // line 98
            echo twig_escape_filter($this->env, $this->getContext($context, "asset_url"), "html", null, true);
            echo "\"></script>
\t\t\t";
        }
        unset($context["asset_url"]);
        // line 100
        echo "\t\t";
    }

    public function getTemplateName()
    {
        return "CvaGestionMembreBundle::rechercheAdherent.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  230 => 100,  224 => 98,  221 => 97,  214 => 98,  211 => 97,  207 => 96,  201 => 94,  198 => 93,  193 => 90,  183 => 86,  178 => 83,  174 => 82,  167 => 78,  126 => 39,  99 => 35,  95 => 34,  91 => 33,  87 => 32,  83 => 31,  76 => 30,  72 => 29,  55 => 14,  52 => 13,  45 => 9,  42 => 8,  39 => 7,  33 => 5,  28 => 3,);
    }
}
