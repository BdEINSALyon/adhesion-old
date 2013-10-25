<?php

/* CvaGestionMembreBundle::ajoutUser.html.twig */
class __TwigTemplate_6fa9f7b58d1c87fa51db30c78e22b1ba extends Twig_Template
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
        echo " Ajout d'Utilisateur";
    }

    // line 7
    public function block_navbar($context, array $blocks = array())
    {
        // line 8
        echo "
\t\t";
        // line 9
        if (isset($context["navbar"])) { $_navbar_ = $context["navbar"]; } else { $_navbar_ = null; }
        echo $_navbar_->getinput("", "", "", "active");
        echo "

\t";
    }

    // line 13
    public function block_content($context, array $blocks = array())
    {
        echo "\t\t\t\t\t

\t\t<div class=\"container well\">
\t\t\t\t<fieldset>
\t\t\t\t    <legend>Formulaire d'ajout d'utilisateur</legend>
\t\t\t\t    
\t\t\t\t\t    <form action=\"";
        // line 19
        echo $this->env->getExtension('routing')->getPath("cva_gestion_membre_addUser");
        echo "\" method=\"post\" ";
        if (isset($context["form"])) { $_form_ = $context["form"]; } else { $_form_ = null; }
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($_form_, 'enctype');
;
        echo "> 
\t\t\t\t\t    ";
        // line 20
        if (isset($context["form"])) { $_form_ = $context["form"]; } else { $_form_ = null; }
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($_form_, 'errors');
        echo "
\t\t\t\t\t    <div class=\"row\">

\t\t\t\t\t\t\t<div class=\"span3\">
\t\t\t\t\t\t\t\t";
        // line 24
        if (isset($context["form"])) { $_form_ = $context["form"]; } else { $_form_ = null; }
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($_form_, "username"), 'row', array("label" => "Nom :", "attr" => array("placeholder" => "Nom")));
        echo "
\t\t\t\t\t\t\t</div>

\t\t\t\t\t\t\t<div class=\"span3\">
\t\t\t\t\t\t\t\t";
        // line 28
        if (isset($context["form"])) { $_form_ = $context["form"]; } else { $_form_ = null; }
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($_form_, "password"), 'row', array("label" => "Mot de Passe :", "attr" => array("placeholder" => "Mot de Passe")));
        echo "
\t\t\t\t\t\t\t</div>

\t\t\t\t\t\t\t<div class=\"span3\">
\t\t\t\t\t\t\t\t";
        // line 32
        if (isset($context["form"])) { $_form_ = $context["form"]; } else { $_form_ = null; }
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($_form_, "roles"), 'row', array("label" => "Roles :"));
        echo "
\t\t\t\t\t\t\t</div>


\t\t\t\t\t\t\t";
        // line 36
        if (isset($context["form"])) { $_form_ = $context["form"]; } else { $_form_ = null; }
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($_form_, 'rest');
        echo "
\t\t\t\t\t\t\t<div class=\"span3\">
\t\t\t\t\t\t\t\t<br/>
\t\t\t\t\t\t\t\t<br/>
\t\t\t\t\t\t\t\t<input class=\"btn btn-large btn-primary\" type=\"submit\" />
\t\t\t\t\t\t\t</div>

\t\t\t\t\t    </div>
\t\t\t\t\t    </form>


\t\t\t\t    
\t\t\t\t</fieldset>
\t\t\t
\t\t</div>

";
    }

    public function getTemplateName()
    {
        return "CvaGestionMembreBundle::ajoutUser.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  102 => 36,  94 => 32,  86 => 28,  78 => 24,  70 => 20,  62 => 19,  52 => 13,  44 => 9,  41 => 8,  38 => 7,  32 => 5,  27 => 3,);
    }
}
