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
        if (isset($context["navbar"])) { $_navbar_ = $context["navbar"]; } else { $_navbar_ = null; }
        echo $_navbar_->getinput("active");
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
        if (isset($context["form"])) { $_form_ = $context["form"]; } else { $_form_ = null; }
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($_form_, 'enctype');
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
        if (isset($context["form"])) { $_form_ = $context["form"]; } else { $_form_ = null; }
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($_form_, "name"), 'row', array("label" => "Nom :", "attr" => array("placeholder" => "Nom")));
        echo "
\t\t\t\t</div>

\t\t\t\t<div class=\"span3\">
\t\t\t\t\t";
        // line 27
        if (isset($context["form"])) { $_form_ = $context["form"]; } else { $_form_ = null; }
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($_form_, "firstName"), 'row', array("label" => "Prenom :", "attr" => array("placeholder" => "Prenom")));
        echo "
\t\t\t\t</div>

\t\t\t\t<div class=\"span1\">
\t\t\t\t\t";
        // line 31
        if (isset($context["form"])) { $_form_ = $context["form"]; } else { $_form_ = null; }
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($_form_, "civilite"), 'row');
        echo "
\t\t\t\t</div>
\t\t\t\t<div class=\"span2\">
\t\t\t\t\t";
        // line 34
        if (isset($context["form"])) { $_form_ = $context["form"]; } else { $_form_ = null; }
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($_form_, "annee"), 'row', array("label" => "Annee :", "attr" => array("style" => "width:80px", "onchange" => "disableDeparts(this.value);")));
        // line 35
        echo "
\t\t\t\t\t";
        // line 36
        if (isset($context["form"])) { $_form_ = $context["form"]; } else { $_form_ = null; }
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($_form_, "departement"), 'row', array("label" => "Departement :", "attr" => array("style" => "width:80px")));
        echo "
\t\t\t\t</div>

\t\t\t\t<div class=\"span3\">
\t\t\t\t\t";
        // line 40
        if (isset($context["form"])) { $_form_ = $context["form"]; } else { $_form_ = null; }
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($_form_, "birthday"), 'row', array("label" => "Date de Naissance :"));
        echo "
\t\t\t\t</div>

\t\t\t</div>

\t\t\t<div class=\"row\">
\t\t\t\t<div class=\"span3\">
\t\t\t\t\t";
        // line 47
        if (isset($context["form"])) { $_form_ = $context["form"]; } else { $_form_ = null; }
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($_form_, "numEtudiant"), 'row', array("label" => "Numéro étudiant :", "attr" => array("placeholder" => "Numéro étudiant")));
        echo "
\t\t\t\t</div>

\t\t\t\t<div class=\"span3\">
\t\t\t\t\t";
        // line 51
        if (isset($context["form"])) { $_form_ = $context["form"]; } else { $_form_ = null; }
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($_form_, "mail"), 'row', array("label" => "Mail :", "attr" => array("placeholder" => "Mail")));
        echo "
\t\t\t\t\t<button class=\"btn btn-mini\" type=\"button\" onclick=\"mailINSA();\"> Mail INSA </button>
\t\t\t\t</div>

\t\t\t\t<div class=\"span3\">
\t\t\t\t\t";
        // line 56
        if (isset($context["form"])) { $_form_ = $context["form"]; } else { $_form_ = null; }
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($_form_, "tel"), 'row', array("label" => "Téléphone :", "attr" => array("placeholder" => "Téléphone")));
        echo "
\t\t\t\t</div>\t\t\t\t
\t\t\t\t<div class=\"span3\">
\t\t\t\t\t";
        // line 59
        if (isset($context["form"])) { $_form_ = $context["form"]; } else { $_form_ = null; }
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($_form_, "remarque"), 'row', array("label" => "Remarque :", "attr" => array("placeholder" => "Remarque")));
        echo "
\t\t\t\t</div>
\t\t\t</div>
\t\t\t<div class=\"row\">
\t\t\t\t<div class=\"span2 offset5\">
\t\t\t\t\t<br/>
\t\t\t\t\t<br/>\t\t\t\t
\t\t\t\t\t\t";
        // line 66
        if (isset($context["form"])) { $_form_ = $context["form"]; } else { $_form_ = null; }
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($_form_, 'rest');
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
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_be65024_0") : $this->env->getExtension('assets')->getAssetUrl("js/be65024_ajout_1.js");
            // line 80
            echo "\t\t\t\t
\t\t\t\t<script type=\"text/javascript\" src=\"";
            // line 81
            if (isset($context["asset_url"])) { $_asset_url_ = $context["asset_url"]; } else { $_asset_url_ = null; }
            echo twig_escape_filter($this->env, $_asset_url_, "html", null, true);
            echo "\"></script>
\t\t\t";
        } else {
            // asset "be65024"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_be65024") : $this->env->getExtension('assets')->getAssetUrl("js/be65024.js");
            // line 80
            echo "\t\t\t\t
\t\t\t\t<script type=\"text/javascript\" src=\"";
            // line 81
            if (isset($context["asset_url"])) { $_asset_url_ = $context["asset_url"]; } else { $_asset_url_ = null; }
            echo twig_escape_filter($this->env, $_asset_url_, "html", null, true);
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
        return array (  196 => 81,  193 => 80,  185 => 81,  182 => 80,  178 => 79,  174 => 78,  171 => 77,  156 => 66,  145 => 59,  138 => 56,  129 => 51,  121 => 47,  110 => 40,  102 => 36,  99 => 35,  96 => 34,  89 => 31,  81 => 27,  73 => 23,  57 => 14,  53 => 12,  50 => 11,  42 => 8,  39 => 7,  33 => 5,  28 => 3,);
    }
}
