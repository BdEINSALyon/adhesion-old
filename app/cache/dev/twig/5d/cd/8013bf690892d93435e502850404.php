<?php

/* CvaGestionMembreBundle::ajoutDetailsWEI.html.twig */
class __TwigTemplate_5dcd8013bf690892d93435e502850404 extends Twig_Template
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
        echo " Details WEI ";
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

    // line 11
    public function block_content($context, array $blocks = array())
    {
        echo "\t\t\t\t\t

\t\t<div class=\"container well\">
\t\t\t\t<fieldset>
\t\t\t\t    <legend>Ajout des Details WEI</legend>
\t\t\t\t    
\t\t\t\t\t    <form action=\"";
        // line 17
        echo $this->env->getExtension('routing')->getPath("cva_gestion_membre_ajoutDetailsWEI");
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
\t\t\t\t\t\t    ";
        // line 22
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getContext($context, "form"), "bus"), 'row', array("label" => "Bus :", "attr" => array("placeholder" => "Bus")));
        echo "
\t\t\t\t\t    </div>
\t\t\t\t\t\t
\t\t\t\t\t\t<div class=\"span3\">
\t\t\t\t\t\t\t";
        // line 26
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getContext($context, "form"), "bungalow"), 'row', array("label" => "Bungalow :", "attr" => array("placeholder" => "Bungalow")));
        echo "
\t\t\t\t\t\t</div>
\t\t\t\t\t    
\t\t\t\t\t    ";
        // line 29
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getContext($context, "form"), 'rest');
        echo "
\t\t\t\t\t    <div class=\"span3 offset1\">
\t\t\t\t\t\t\t\t<br/>
\t\t\t\t\t\t\t\t<input type=\"hidden\" name=\"id\" value=\"";
        // line 32
        echo twig_escape_filter($this->env, $this->getContext($context, "id"), "html", null, true);
        echo "\" />
\t\t\t\t\t\t\t\t<input class=\"btn btn-large btn-primary\" type=\"submit\" />
\t\t\t\t\t\t\t</div>

\t\t\t\t\t    </div>
\t\t\t\t\t    </form>
\t\t\t\t\t

\t\t\t\t    
\t\t\t\t</fieldset>
\t\t\t
\t\t</div>

";
    }

    public function getTemplateName()
    {
        return "CvaGestionMembreBundle::ajoutDetailsWEI.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  91 => 32,  85 => 29,  79 => 26,  72 => 22,  65 => 18,  58 => 17,  48 => 11,  41 => 8,  38 => 7,  32 => 5,  27 => 3,);
    }
}
