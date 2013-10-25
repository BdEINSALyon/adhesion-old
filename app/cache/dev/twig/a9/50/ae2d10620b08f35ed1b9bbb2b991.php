<?php

/* CvaGestionMembreBundle::AjoutAdherent.html.twig */
class __TwigTemplate_a950ae2d10620b08f35ed1b9bbb2b991 extends Twig_Template
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
        echo " Ajout adhérent ";
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

    // line 11
    public function block_content($context, array $blocks = array())
    {
        // line 12
        echo "
<fieldset>
\t<form action=\"";
        // line 14
        echo $this->env->getExtension('routing')->getPath("cva_gestion_membre_ajoutAdherent");
        echo "\" method=\"post\" ";
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getContext($context, "form"), 'enctype');
;
        echo "> 
\t\t
\t\t<div class=\"container well\">\t
\t\t\t<div class=\"row\">
\t\t\t\t<div class=\"span12\">
\t\t\t\t\t<legend>Formulaire d'ajout d'adhérent</legend>
\t\t\t\t</div>

\t\t\t\t<div class=\"span3\">
\t\t\t\t\t";
        // line 23
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getContext($context, "form"), "name"), 'row', array("label" => "Nom :", "attr" => array("placeholder" => "Nom")));
        echo "
\t\t\t\t</div>

\t\t\t\t<div class=\"span3\">
\t\t\t\t\t";
        // line 27
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getContext($context, "form"), "firstName"), 'row', array("label" => "Prenom :", "attr" => array("placeholder" => "Prenom")));
        echo "
\t\t\t\t</div>

\t\t\t\t<div class=\"span1\">
\t\t\t\t\t";
        // line 31
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getContext($context, "form"), "civilite"), 'row');
        echo "
\t\t\t\t</div>
\t\t\t\t<div class=\"span2\">
\t\t\t\t\t";
        // line 34
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getContext($context, "form"), "annee"), 'row', array("label" => "Annee :", "attr" => array("style" => "width:80px", "onchange" => "disableDeparts(this.value);")));
        // line 35
        echo "
\t\t\t\t\t";
        // line 36
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getContext($context, "form"), "departement"), 'row', array("label" => "Departement :", "attr" => array("style" => "width:80px")));
        echo "
\t\t\t\t</div>

\t\t\t\t<div class=\"span3\">
\t\t\t\t\t";
        // line 40
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getContext($context, "form"), "birthday"), 'row', array("label" => "Date de Naissance :"));
        echo "
\t\t\t\t</div>

\t\t\t</div>

\t\t\t<div class=\"row\">
\t\t\t\t<div class=\"span3\">
\t\t\t\t\t";
        // line 47
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getContext($context, "form"), "numEtudiant"), 'row', array("label" => "Numéro étudiant :", "attr" => array("placeholder" => "Numéro étudiant")));
        echo "
\t\t\t\t</div>

\t\t\t\t<div class=\"span3\">
\t\t\t\t\t";
        // line 51
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getContext($context, "form"), "mail"), 'row', array("label" => "Mail :", "attr" => array("placeholder" => "Mail")));
        echo "
\t\t\t\t\t<button class=\"btn btn-mini\" type=\"button\" onclick=\"mailINSA();\"> Mail INSA </button>
\t\t\t\t</div>

\t\t\t\t<div class=\"span3\">
\t\t\t\t\t";
        // line 56
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getContext($context, "form"), "tel"), 'row', array("label" => "Téléphone :", "attr" => array("placeholder" => "Téléphone")));
        echo "
\t\t\t\t</div>\t\t\t\t
\t\t\t\t<div class=\"span3\">
\t\t\t\t\t";
        // line 59
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getContext($context, "form"), "remarque"), 'row', array("label" => "Remarque :", "attr" => array("placeholder" => "Remarque")));
        echo "
\t\t\t\t</div>
\t\t\t</div>
\t\t\t<div class=\"row\">
\t\t\t\t<div class=\"span2 offset5\">
\t\t\t\t\t<br/>
\t\t\t\t\t<br/>\t\t\t\t
\t\t\t\t\t\t";
        // line 66
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getContext($context, "form"), 'rest');
        echo "
\t\t\t\t\t\t<input class=\"btn btn-large btn-primary\" type=\"submit\" />
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t</form>
</fieldset>

</div>
";
    }

    // line 77
    public function block_javascripts($context, array $blocks = array())
    {
        // line 78
        $this->displayParentBlock("javascripts", $context, $blocks);
        echo "
\t\t\t";
        // line 79
        if (isset($context['assetic']['debug']) && $context['assetic']['debug']) {
            // asset "be65024_0"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_be65024_0") : $this->env->getExtension('assets')->getAssetUrl("_controller/js/be65024_ajout_1.js");
            // line 80
            echo "\t\t\t\t
\t\t\t\t<script type=\"text/javascript\" src=\"";
            // line 81
            echo twig_escape_filter($this->env, $this->getContext($context, "asset_url"), "html", null, true);
            echo "\"></script>
\t\t\t";
        } else {
            // asset "be65024"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_be65024") : $this->env->getExtension('assets')->getAssetUrl("_controller/js/be65024.js");
            // line 80
            echo "\t\t\t\t
\t\t\t\t<script type=\"text/javascript\" src=\"";
            // line 81
            echo twig_escape_filter($this->env, $this->getContext($context, "asset_url"), "html", null, true);
            echo "\"></script>
\t\t\t";
        }
        unset($context["asset_url"]);
    }

    public function getTemplateName()
    {
        return "CvaGestionMembreBundle::AjoutAdherent.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  182 => 81,  179 => 80,  172 => 81,  169 => 80,  165 => 79,  161 => 78,  158 => 77,  144 => 66,  134 => 59,  128 => 56,  120 => 51,  113 => 47,  103 => 40,  96 => 36,  93 => 35,  91 => 34,  85 => 31,  78 => 27,  71 => 23,  56 => 14,  52 => 12,  49 => 11,  42 => 8,  39 => 7,  33 => 5,  28 => 3,);
    }
}
