<?php

/* ::base.html.twig */
class __TwigTemplate_ae1b77a247e0bb9d646a3b0eeffa5835 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'stylesheets' => array($this, 'block_stylesheets'),
            'title' => array($this, 'block_title'),
            'navbar' => array($this, 'block_navbar'),
            'error' => array($this, 'block_error'),
            'content' => array($this, 'block_content'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
\t\t";
        // line 5
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 8
        echo "
\t\t<title>";
        // line 9
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
    </head>
    <body>

\t";
        // line 13
        $this->displayBlock('navbar', $context, $blocks);
        // line 14
        echo "
\t";
        // line 15
        $this->displayBlock('error', $context, $blocks);
        // line 38
        echo "
\t";
        // line 39
        $this->displayBlock('content', $context, $blocks);
        // line 40
        echo "
        ";
        // line 41
        $this->displayBlock('javascripts', $context, $blocks);
        // line 45
        echo "    </body>
</html>
";
    }

    // line 5
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 6
        echo "\t\t\t<link href=\"//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css\" rel=\"stylesheet\">
\t\t";
    }

    // line 9
    public function block_title($context, array $blocks = array())
    {
        echo " ";
    }

    // line 13
    public function block_navbar($context, array $blocks = array())
    {
        echo " ";
    }

    // line 15
    public function block_error($context, array $blocks = array())
    {
        echo " 
\t\t<div class=\"container\">
\t\t\t<div class=\"row\">
\t\t\t\t";
        // line 18
        if (isset($context["app"])) { $_app_ = $context["app"]; } else { $_app_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute($_app_, "session"), "flashbag"), "get", array(0 => "notice"), "method"));
        foreach ($context['_seq'] as $context["_key"] => $context["flashMessage"]) {
            // line 19
            echo "\t\t\t\t
\t\t\t\t\t\t\t\t<div class=\"span4 alert alert-success\">
\t\t\t\t\t\t\t\t\t<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
\t\t\t\t\t\t\t\t\t<strong>";
            // line 22
            if (isset($context["flashMessage"])) { $_flashMessage_ = $context["flashMessage"]; } else { $_flashMessage_ = null; }
            echo twig_escape_filter($this->env, $_flashMessage_, "html", null, true);
            echo "</strong>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t
\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['flashMessage'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 26
        echo "\t\t\t\t";
        if (isset($context["app"])) { $_app_ = $context["app"]; } else { $_app_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute($_app_, "session"), "flashbag"), "get", array(0 => "warning"), "method"));
        foreach ($context['_seq'] as $context["_key"] => $context["flashMessage"]) {
            // line 27
            echo "\t\t\t\t
\t\t\t\t\t\t\t\t<div class=\"span4 alert alert-error\">
\t\t\t\t\t\t\t\t\t<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
\t\t\t\t\t\t\t\t\t<strong>";
            // line 30
            if (isset($context["flashMessage"])) { $_flashMessage_ = $context["flashMessage"]; } else { $_flashMessage_ = null; }
            echo twig_escape_filter($this->env, $_flashMessage_, "html", null, true);
            echo "</strong>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t
\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['flashMessage'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 34
        echo "\t\t</div>
\t\t\t</div>

\t";
    }

    // line 39
    public function block_content($context, array $blocks = array())
    {
        echo " ";
    }

    // line 41
    public function block_javascripts($context, array $blocks = array())
    {
        // line 42
        echo "\t\t\t<script src=\"http://code.jquery.com/jquery-2.0.3.min.js\"></script>
\t\t\t<script src=\"//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js\"></script>
\t";
    }

    public function getTemplateName()
    {
        return "::base.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  152 => 42,  149 => 41,  143 => 39,  136 => 34,  125 => 30,  120 => 27,  114 => 26,  103 => 22,  93 => 18,  86 => 15,  80 => 13,  74 => 9,  69 => 6,  66 => 5,  60 => 45,  58 => 41,  55 => 40,  48 => 15,  45 => 14,  43 => 13,  33 => 8,  31 => 5,  25 => 1,  98 => 19,  91 => 43,  88 => 42,  70 => 28,  62 => 23,  53 => 39,  50 => 38,  36 => 9,  30 => 3,);
    }
}
