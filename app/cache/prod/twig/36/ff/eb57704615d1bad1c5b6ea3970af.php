<?php

/* CvaGestionMembreBundle::index.html.twig */
class __TwigTemplate_36ffeb57704615d1bad1c5b6ea3970af extends Twig_Template
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
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        echo " Accueil ";
    }

    // line 5
    public function block_navbar($context, array $blocks = array())
    {
        echo " 
\t\t<div class=\"container\">
\t\t\t<div class=\"navbar\">
\t  \t\t\t<div class=\"navbar-inner\">
\t    \t\t\t<a class=\"brand\" href=\"#\">Bienvenue sur le site de gestion des adhérents de la VA</a>
\t \t\t\t</div>
\t\t\t</div>
\t\t</div>
\t";
    }

    // line 15
    public function block_content($context, array $blocks = array())
    {
        // line 16
        echo "
\t\t

\t\t<div class=\"container\">  
\t\t
\t\t\t<div class=\"row\">
\t\t\t\t<div class=\"span6 offset3\">
\t\t\t\t\t<form class=\"form-horizontal\" action=\"";
        // line 23
        echo $this->env->getExtension('routing')->getPath("login_check");
        echo "\" method=\"post\" >

\t\t\t\t\t \t<div class=\"control-group\">
\t\t\t\t\t    \t<label class=\"control-label\" for=\"username\">Identifiant :</label>
\t\t\t\t\t    \t<div class=\"controls\">
\t\t\t\t\t     \t\t<input type=\"text\" id=\"username\"  placeholder=\"Identifiant\" name=\"_username\" \t\t\tvalue=\"";
        // line 28
        if (isset($context["last_username"])) { $_last_username_ = $context["last_username"]; } else { $_last_username_ = null; }
        echo twig_escape_filter($this->env, $_last_username_, "html", null, true);
        echo "\" />
\t\t\t\t\t    \t</div>
\t\t\t\t\t \t</div>

\t\t\t\t\t\t
\t\t\t\t\t  \t<div class=\"control-group\">
\t\t\t\t\t    \t<label class=\"control-label\" for=\"password\">Mot de Passe :</label>
\t\t\t\t\t    \t<div class=\"controls\">
\t\t\t\t\t      \t\t<input name=\"_password\" type=\"password\" id=\"password\" placeholder=\"Mot de Passe\">
\t\t\t\t\t    \t</div>
\t\t\t\t\t  \t</div>

\t\t\t\t\t  \t<div class=\"control-group\">
\t\t\t\t\t    \t<div class=\"controls\">
\t\t\t\t\t      \t\t";
        // line 42
        if (isset($context["error"])) { $_error_ = $context["error"]; } else { $_error_ = null; }
        if ($_error_) {
            // line 43
            echo "\t\t\t\t\t\t\t\t\t\t<div class=\"alert alert-error\">";
            if (isset($context["error"])) { $_error_ = $context["error"]; } else { $_error_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_error_, "message"), "html", null, true);
            echo "</div>
\t\t\t\t\t\t\t\t";
        }
        // line 44
        echo "\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t<label for=\"remember_me\"><input type=\"checkbox\" id=\"remember_me\" name=\"_remember_me\" checked />  Rester connecté</label>
\t\t\t\t\t\t\t\t</br>
\t\t\t\t\t\t\t\t<input type=\"submit\" value=\"Connexion\" />
\t\t\t\t\t    \t</div>
\t\t\t\t\t  \t</div>
\t\t\t\t\t</form>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t\t<footer>
\t\t\t<div class=\"container text-center\">
\t\t\t\tContactez nous : <A HREF=\"mailto:mael.ogier.38@gmail.com?subject=Probleme avec le site VA&cc=leo.vetter@insa-lyon.fr\">Par ici</A>
\t\t\t</div>
\t\t</footer>

\t";
    }

    public function getTemplateName()
    {
        return "CvaGestionMembreBundle::index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  98 => 44,  91 => 43,  88 => 42,  70 => 28,  62 => 23,  53 => 16,  50 => 15,  36 => 5,  30 => 3,);
    }
}
