<?php

/* CvaGestionMembreBundle::editetudiant.html.twig */
class __TwigTemplate_ebb0732803d616e5494200fcb8620933 extends Twig_Template
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
        echo " Modification d'adherent";
    }

    // line 7
    public function block_navbar($context, array $blocks = array())
    {
        // line 8
        echo "\t\t";
        echo $context["navbar"]->getinput();
        echo "
\t";
    }

    // line 11
    public function block_content($context, array $blocks = array())
    {
        // line 12
        echo "
\t\t<div class=\"container well\">
\t\t\t\t<fieldset>
\t\t\t\t    <legend>Formulaire de modification d'adhérent</legend>
\t\t\t\t    
\t\t\t\t\t    <form action=\"";
        // line 17
        echo $this->env->getExtension('routing')->getPath("cva_gestion_membre_edit");
        echo "?id=";
        echo twig_escape_filter($this->env, $this->getContext($context, "id"), "html", null, true);
        echo "\" method=\"post\" ";
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getContext($context, "form"), 'enctype');
;
        echo "> 
\t\t\t\t\t    ";
        // line 18
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getContext($context, "form"), 'errors');
        echo "
\t\t\t\t\t    <div class=\"row\">

\t\t\t\t\t    <div class=\"span3\">
\t\t\t\t\t\t\t";
        // line 22
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getContext($context, "form"), "name"), 'row', array("label" => "Nom :", "attr" => array("placeholder" => "Nom")));
        echo "
\t\t\t\t\t\t</div>

\t\t\t\t\t\t<div class=\"span3\">
\t\t\t\t\t\t\t";
        // line 26
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getContext($context, "form"), "firstName"), 'row', array("label" => "Prenom :", "attr" => array("placeholder" => "Prenom")));
        echo "
\t\t\t\t\t\t</div>

\t\t\t\t\t\t<div class=\"span1\">
\t\t\t\t\t\t\t";
        // line 30
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getContext($context, "form"), "civilite"), 'row', array("label" => "Civilite :", "attr" => array("placeholder" => "Civilite")));
        echo "
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"span2\">
\t\t\t\t\t\t\t";
        // line 33
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getContext($context, "form"), "annee"), 'row', array("label" => "Annee :", "attr" => array("style" => "width:80px", "onchange" => "disableDeparts(this.value);")));
        // line 34
        echo "
";
        // line 35
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getContext($context, "form"), "departement"), 'row', array("label" => "Departement :", "attr" => array("style" => "width:80px")));
        echo "
\t\t\t\t\t\t</div>

\t\t\t\t\t\t<div class=\"span3\">
\t\t\t\t\t\t\t";
        // line 39
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getContext($context, "form"), "birthday"), 'row', array("label" => "Date de Naissance :"));
        echo "
\t\t\t\t\t\t</div>


\t\t\t\t\t   <div class=\"span3\">
\t\t\t\t\t    \t";
        // line 44
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getContext($context, "form"), "numEtudiant"), 'row', array("label" => "Numéro étudiant :", "attr" => array("placeholder" => "Numéro étudiant")));
        echo "
\t\t\t\t\t    </div>

\t\t\t\t\t    
\t\t\t\t\t    <div class=\"span3\">
\t\t\t\t\t    \t";
        // line 49
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getContext($context, "form"), "mail"), 'row', array("label" => "Mail :", "attr" => array("placeholder" => "Mail")));
        echo "
\t\t\t\t\t<button class=\"btn btn-mini\" type=\"button\" onclick=\"mailINSA();\"> Mail INSA </button>
\t\t\t\t\t    </div>

\t\t\t\t\t    

\t\t\t\t\t    <div class=\"span3\">
\t\t\t\t\t\t    ";
        // line 56
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getContext($context, "form"), "tel"), 'row', array("label" => "Téléphone :", "attr" => array("placeholder" => "Téléphone")));
        echo "
\t\t\t\t\t    </div>
\t\t\t\t\t\t
\t\t\t\t\t    ";
        // line 59
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getContext($context, "form"), 'rest');
        echo "


\t\t\t\t\t    <div class=\"span5 offset5\">
\t\t\t\t\t\t\t<br/>
\t\t\t\t\t\t\t<input type=\"hidden\" name=\"id\" value=\"<?php echo \$_GET['id'] ?>\" />
\t\t\t\t\t\t    <input class=\"btn btn-large btn-primary\" type=\"submit\" />
\t\t\t\t\t    </div>

\t\t\t\t\t    </div>
\t\t\t\t\t    </form>
\t\t\t\t\t
\t\t\t\t    
\t\t\t\t</fieldset>
\t\t\t
\t\t</div>
";
    }

    // line 76
    public function block_javascripts($context, array $blocks = array())
    {
        // line 77
        $this->displayParentBlock("javascripts", $context, $blocks);
        echo "
\t\t\t";
        // line 78
        if (isset($context['assetic']['debug']) && $context['assetic']['debug']) {
            // asset "be65024_0"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_be65024_0") : $this->env->getExtension('assets')->getAssetUrl("_controller/js/be65024_ajout_1.js");
            // line 79
            echo "\t\t\t\t
\t\t\t\t<script type=\"text/javascript\" src=\"";
            // line 80
            echo twig_escape_filter($this->env, $this->getContext($context, "asset_url"), "html", null, true);
            echo "\"></script>
\t\t\t";
        } else {
            // asset "be65024"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_be65024") : $this->env->getExtension('assets')->getAssetUrl("_controller/js/be65024.js");
            // line 79
            echo "\t\t\t\t
\t\t\t\t<script type=\"text/javascript\" src=\"";
            // line 80
            echo twig_escape_filter($this->env, $this->getContext($context, "asset_url"), "html", null, true);
            echo "\"></script>
\t\t\t";
        }
        unset($context["asset_url"]);
    }

    public function getTemplateName()
    {
        return "CvaGestionMembreBundle::editetudiant.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  184 => 80,  181 => 79,  174 => 80,  171 => 79,  167 => 78,  163 => 77,  160 => 76,  139 => 59,  133 => 56,  123 => 49,  115 => 44,  107 => 39,  100 => 35,  97 => 34,  95 => 33,  89 => 30,  82 => 26,  75 => 22,  68 => 18,  59 => 17,  52 => 12,  49 => 11,  42 => 8,  39 => 7,  33 => 5,  28 => 3,);
    }
}
