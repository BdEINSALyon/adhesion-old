<?php

/* CvaGestionMembreBundle::paiement.html.twig */
class __TwigTemplate_9d46ec3327fabac71957c0c8dcfce326 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("::base.html.twig");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'navbar' => array($this, 'block_navbar'),
            'content' => array($this, 'block_content'),
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
        echo " Paiement ";
    }

    // line 7
    public function block_navbar($context, array $blocks = array())
    {
        // line 8
        echo "\t";
        echo $context["navbar"]->getinput("active");
        echo "
";
    }

    // line 12
    public function block_content($context, array $blocks = array())
    {
        echo " 

";
        // line 14
        if (array_key_exists("paiementsEtud", $context)) {
            // line 15
            echo "<div class=\"container well\">
<div class = container>
\t\t\t<div class=\"row\">
\t\t\t\t<div class=\"span8\">
\t\t\t\t\t<table class=\"table table-bordered\">
\t\t\t\t\t  <thead>
 \t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t<th>
\t\t\t\t\t\t\t\tProduit deja achete
\t\t\t\t\t\t\t</th>
\t\t\t\t\t\t\t<th>
\t\t\t\t\t\t\t</th>
\t\t\t\t\t\t</tr> 
\t\t\t\t\t  </thead>\t\t\t\t\t  
\t\t\t\t\t  <tbody id=\"products\">
\t\t\t\t\t  
\t\t\t\t\t\t";
            // line 31
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getContext($context, "paiementsEtud"));
            foreach ($context['_seq'] as $context["_key"] => $context["paiement"]) {
                // line 32
                echo "\t\t\t\t\t\t\t";
                $context['_parent'] = (array) $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getContext($context, "paiement"), "produits"));
                foreach ($context['_seq'] as $context["_key"] => $context["prod"]) {
                    // line 33
                    echo "\t\t\t\t\t\t\t\t<tr id=\"";
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "prod"), "id"), "html", null, true);
                    echo "\">
\t\t\t\t\t\t\t\t\t  <td>";
                    // line 34
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "prod"), "description"), "html", null, true);
                    echo "</td>
\t\t\t\t\t\t\t\t\t  <td> <a href=\"#id";
                    // line 35
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "paiement"), "id"), "html", null, true);
                    echo "\" role=\"button\" class=\"btn\" data-toggle=\"modal\">Supprimer</a> </td>
\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t<div id=\"id";
                    // line 37
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "paiement"), "id"), "html", null, true);
                    echo "\" class=\"modal hide fade\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
\t\t\t\t\t\t\t\t\t\t  <div class=\"modal-header\">
\t\t\t\t\t\t\t\t\t\t\t\t<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">x</button>
\t\t\t\t\t\t\t\t\t\t\t\t<h3 id=\"myModalLabel\">Confirmation</h3>
\t\t\t\t\t\t\t\t\t\t  </div>
\t\t\t\t\t\t\t\t\t\t  <div class=\"modal-body\">
\t\t\t\t\t\t\t\t\t\t\t\t<p>Voulez-vous vraiment supprimer le produit de cet adherent ?</p>
\t\t\t\t\t\t\t\t\t\t  </div>
\t\t\t\t\t\t\t\t\t\t  <div class=\"modal-footer\">
\t\t\t\t\t\t\t\t\t\t\t\t<button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Non</button>
\t\t\t\t\t\t\t\t\t\t\t\t<a role=\"button\" href=\"";
                    // line 47
                    echo $this->env->getExtension('routing')->getPath("cva_gestion_membre_deletePaiement");
                    echo "?idPaiement=";
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "paiement"), "id"), "html", null, true);
                    echo "&idProduit=";
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "prod"), "id"), "html", null, true);
                    echo "&idEtu=";
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getContext($context, "paiement"), "idEtudiant"), "id"), "html", null, true);
                    echo "\" class=\"btn btn-primary\">Oui</a>
\t\t\t\t\t\t\t\t\t\t  </div>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['prod'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 50
                echo "\t\t\t\t\t\t\t\t
\t\t\t\t\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['paiement'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 51
            echo "\t
\t\t\t\t\t  </tbody>
\t\t\t\t\t</table>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t</div>
";
        }
        // line 58
        echo "\t
<fieldset>
\t<form action=\"";
        // line 60
        echo $this->env->getExtension('routing')->getPath("cva_gestion_membre_paiement");
        echo "\" method=\"post\" ";
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getContext($context, "form"), 'enctype');
;
        echo "> 
\t\t<div class=\"container well\">\t
\t\t\t<div class=\"row\">
\t\t\t<div class=\"span12\">
\t\t\t\t\t<legend>Ajout paiement</legend>
\t\t\t\t</div>
\t\t\t\t<div class=\"span4\">
\t\t\t\t\t";
        // line 67
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getContext($context, "form"), "Produits"), 'row', array("label" => "Produits Disponibles :"));
        echo "
\t\t\t\t</div>
\t\t\t\t<div class=\"span4\">
\t\t\t\t\t";
        // line 70
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getContext($context, "form"), "moyenPaiement"), 'row', array("label" => "Moyen de paiement :"));
        echo "
\t\t\t\t</div>
\t\t\t\t<div class=\"span4\">
\t\t\t\t\t<br/>
\t\t\t\t\t<br/>
\t\t\t\t\t";
        // line 75
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getContext($context, "form"), 'rest');
        echo "
\t\t\t\t\t<input type=\"hidden\" name =\"id\" value=\"";
        // line 76
        echo twig_escape_filter($this->env, $this->getContext($context, "id"), "html", null, true);
        echo "\" />
\t\t\t\t\t<input class=\"btn btn-large btn-primary\" type=\"submit\" />
\t\t\t\t</div>
\t\t\t</div>
";
    }

    public function getTemplateName()
    {
        return "CvaGestionMembreBundle::paiement.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  178 => 76,  174 => 75,  166 => 70,  160 => 67,  147 => 60,  143 => 58,  133 => 51,  126 => 50,  110 => 47,  97 => 37,  92 => 35,  88 => 34,  83 => 33,  78 => 32,  74 => 31,  56 => 15,  54 => 14,  48 => 12,  41 => 8,  38 => 7,  32 => 5,  27 => 3,);
    }
}
