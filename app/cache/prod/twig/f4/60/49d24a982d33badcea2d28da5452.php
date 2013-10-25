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
        if (isset($context["navbar"])) { $_navbar_ = $context["navbar"]; } else { $_navbar_ = null; }
        echo $_navbar_->getinput("", "", "active");
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
        // line 32
        if (isset($context["adherent"])) { $_adherent_ = $context["adherent"]; } else { $_adherent_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_adherent_);
        foreach ($context['_seq'] as $context["_key"] => $context["adh"]) {
            // line 33
            echo "\t\t\t\t\t\t\t\t<tr id=\"";
            if (isset($context["adh"])) { $_adh_ = $context["adh"]; } else { $_adh_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($_adh_, "bizuth"), "id"), "html", null, true);
            echo "\" onclick=\"return voir(";
            if (isset($context["adh"])) { $_adh_ = $context["adh"]; } else { $_adh_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($_adh_, "bizuth"), "id"), "html", null, true);
            echo ");\">
\t\t\t\t\t\t\t\t\t  <td>";
            // line 34
            if (isset($context["adh"])) { $_adh_ = $context["adh"]; } else { $_adh_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($_adh_, "bizuth"), "name"), "html", null, true);
            echo "</td>
\t\t\t\t\t\t\t\t\t  <td>";
            // line 35
            if (isset($context["adh"])) { $_adh_ = $context["adh"]; } else { $_adh_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($_adh_, "bizuth"), "firstName"), "html", null, true);
            echo "</td>
\t\t\t\t\t\t\t\t\t  <td>";
            // line 36
            if (isset($context["adh"])) { $_adh_ = $context["adh"]; } else { $_adh_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_adh_, "bus"), "html", null, true);
            echo "</td>
\t\t\t\t\t\t\t\t\t  <td>";
            // line 37
            if (isset($context["adh"])) { $_adh_ = $context["adh"]; } else { $_adh_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_adh_, "bung"), "html", null, true);
            echo "</td>
\t\t\t\t\t\t\t\t\t<td class=\"hidden\"> ";
            // line 38
            if (isset($context["adh"])) { $_adh_ = $context["adh"]; } else { $_adh_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_adh_, "majeur"), "html", null, true);
            echo " </td>
\t\t\t\t\t\t\t\t\t<td style=\"text-align:center;\">";
            // line 39
            if (isset($context["adh"])) { $_adh_ = $context["adh"]; } else { $_adh_ = null; }
            if (($this->getAttribute($_adh_, "majeur") == "Mineur")) {
                echo "<img src=";
                echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("img/18.jpg"), "html", null, true);
                echo " height=\"20\" width=\"20\"> ";
            }
            echo "</td>
\t\t\t\t\t\t\t\t\t<td class=\"hidden\"> ";
            // line 40
            if (isset($context["adh"])) { $_adh_ = $context["adh"]; } else { $_adh_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($_adh_, "bizuth"), "remarque"), "html", null, true);
            echo " </td>
\t\t\t\t\t\t\t\t\t<td class=\"hidden\">";
            // line 41
            if (isset($context["adh"])) { $_adh_ = $context["adh"]; } else { $_adh_ = null; }
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($_adh_, "prods"));
            foreach ($context['_seq'] as $context["_key"] => $context["paiement"]) {
                echo " ";
                if (isset($context["paiement"])) { $_paiement_ = $context["paiement"]; } else { $_paiement_ = null; }
                $context['_parent'] = (array) $context;
                $context['_seq'] = twig_ensure_traversable($_paiement_);
                foreach ($context['_seq'] as $context["_key"] => $context["prod"]) {
                    if (isset($context["prod"])) { $_prod_ = $context["prod"]; } else { $_prod_ = null; }
                    echo twig_escape_filter($this->env, $this->getAttribute($_prod_, "description"), "html", null, true);
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
        // line 43
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
        // line 83
        echo $this->env->getExtension('routing')->getPath("cva_gestion_membre_exportCSV");
        echo "\" method=\"post\" name=\"formCSV\">
\t\t<input type=\"hidden\" name=\"csvText\" id=\"csvText\"/>
\t\t</form>
\t\t
\t\t";
    }

    // line 88
    public function block_javascripts($context, array $blocks = array())
    {
        // line 89
        echo "\t\t\t   ";
        $this->displayParentBlock("javascripts", $context, $blocks);
        echo "
\t\t\t\t<script src=\"http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js\"></script>\t
\t\t\t";
        // line 91
        if (isset($context['assetic']['debug']) && $context['assetic']['debug']) {
            // asset "29f8d6d_0"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_29f8d6d_0") : $this->env->getExtension('assets')->getAssetUrl("js/29f8d6d_tableau_1.js");
            // line 92
            echo "\t\t\t\t
\t\t\t\t<script type=\"text/javascript\" src=\"";
            // line 93
            if (isset($context["asset_url"])) { $_asset_url_ = $context["asset_url"]; } else { $_asset_url_ = null; }
            echo twig_escape_filter($this->env, $_asset_url_, "html", null, true);
            echo "\"></script>
\t\t\t";
        } else {
            // asset "29f8d6d"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_29f8d6d") : $this->env->getExtension('assets')->getAssetUrl("js/29f8d6d.js");
            // line 92
            echo "\t\t\t\t
\t\t\t\t<script type=\"text/javascript\" src=\"";
            // line 93
            if (isset($context["asset_url"])) { $_asset_url_ = $context["asset_url"]; } else { $_asset_url_ = null; }
            echo twig_escape_filter($this->env, $_asset_url_, "html", null, true);
            echo "\"></script>
\t\t\t";
        }
        unset($context["asset_url"]);
        // line 95
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
        return array (  241 => 95,  234 => 93,  231 => 92,  223 => 93,  220 => 92,  216 => 91,  210 => 89,  207 => 88,  198 => 83,  156 => 43,  127 => 41,  122 => 40,  113 => 39,  108 => 38,  103 => 37,  98 => 36,  93 => 35,  88 => 34,  79 => 33,  74 => 32,  53 => 13,  50 => 12,  42 => 8,  39 => 7,  33 => 5,  28 => 3,);
    }
}
