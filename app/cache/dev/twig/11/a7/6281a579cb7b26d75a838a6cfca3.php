<?php

/* CvaGestionMembreBundle::stats.html.twig */
class __TwigTemplate_11a76281a579cb7b26d75a838a6cfca3 extends Twig_Template
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
        echo " Statistiques ";
    }

    // line 7
    public function block_navbar($context, array $blocks = array())
    {
        // line 8
        echo "\t\t";
        echo $context["navbar"]->getinput("", "", "", "", "active");
        echo "
\t";
    }

    // line 11
    public function block_content($context, array $blocks = array())
    {
        // line 12
        echo "\t
\t\t<div class = container>
\t\t\t<div class=\"row\">
\t\t\t\t<div class=\"span4\">
\t\t\t\t\t<table class=\"table table-bordered\">
\t\t\t\t\t  <thead>
 \t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t<th>Produit</th>
\t\t\t\t\t\t\t<th>Vendus</th>
\t\t\t\t\t\t\t<th>Magot</th>
\t\t\t\t\t\t</tr> 
\t\t\t\t\t  </thead>\t\t\t\t\t  
\t\t\t\t\t  <tbody>
\t\t\t\t\t  \t";
        // line 25
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getContext($context, "venteProds"));
        foreach ($context['_seq'] as $context["_key"] => $context["prod"]) {
            // line 26
            echo "\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t<td>";
            // line 27
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getContext($context, "prod"), "prod", array(), "array"), "description"), "html", null, true);
            echo "</td>
\t\t\t\t\t\t\t<td>";
            // line 28
            echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "prod"), "vendus", array(), "array"), "html", null, true);
            echo "</td>
\t\t\t\t\t\t\t<td>";
            // line 29
            echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "prod"), "magot", array(), "array"), "html", null, true);
            echo "€</td>\t\t\t\t\t\t
\t\t\t\t\t\t</tr>
\t\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['prod'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 31
        echo "\t\t\t\t\t\t\t
\t\t\t\t\t  </tbody>
\t\t\t\t\t</table>
\t\t\t\t</div>

\t\t\t\t<div class=\"span4\">
\t\t\t\t\t<table class=\"table table-bordered\">
\t\t\t\t\t  <thead>
 \t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t<th>
\t\t\t\t\t\t\t\tAnnée
\t\t\t\t\t\t\t</th>
\t\t\t\t\t\t\t<th>
\t\t\t\t\t\t\t\tAdhésions VA
\t\t\t\t\t\t\t</th>
\t\t\t\t\t\t</tr> 
\t\t\t\t\t  </thead>\t\t\t\t\t  
\t\t\t\t\t  <tbody>
\t\t\t\t\t  \t";
        // line 49
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getContext($context, "venteAnnee"));
        foreach ($context['_seq'] as $context["key"] => $context["value"]) {
            // line 50
            echo "\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t<td>";
            // line 51
            echo twig_escape_filter($this->env, $this->getContext($context, "key"), "html", null, true);
            echo "</td>
\t\t\t\t\t\t\t<td>";
            // line 52
            echo twig_escape_filter($this->env, $this->getContext($context, "value"), "html", null, true);
            echo "</td>
\t\t\t\t\t\t</tr>
\t\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['value'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 54
        echo "\t\t\t\t\t\t\t
\t\t\t\t\t  </tbody>
\t\t\t\t\t</table>
\t\t\t\t<div class=\"well\">";
        // line 57
        echo twig_escape_filter($this->env, $this->getContext($context, "ventesMois"), "html", null, true);
        echo " adhesions depuis le début du mois.<br />";
        echo twig_escape_filter($this->env, $this->getContext($context, "message"), "html", null, true);
        echo "</div>
\t\t\t\t</div>

\t\t\t\t<div class=\"span4\">
\t\t\t\t\t<table class=\"table table-bordered\">
\t\t\t\t\t  <thead>
 \t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t<th>
\t\t\t\t\t\t\t\tDépartement
\t\t\t\t\t\t\t</th>
\t\t\t\t\t\t\t<th>
\t\t\t\t\t\t\t\tAdhésions VA
\t\t\t\t\t\t\t</th>
\t\t\t\t\t\t</tr> 
\t\t\t\t\t  </thead>\t\t\t\t\t  
\t\t\t\t\t  <tbody>
\t\t\t\t\t  \t";
        // line 73
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getContext($context, "venteDepart"));
        foreach ($context['_seq'] as $context["key"] => $context["value"]) {
            // line 74
            echo "\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t<td>";
            // line 75
            echo twig_escape_filter($this->env, $this->getContext($context, "key"), "html", null, true);
            echo "</td>
\t\t\t\t\t\t\t<td>";
            // line 76
            echo twig_escape_filter($this->env, $this->getContext($context, "value"), "html", null, true);
            echo "</td>
\t\t\t\t\t\t</tr>
\t\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['value'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 79
        echo "\t\t\t\t\t\t\t
\t\t\t\t\t  </tbody>
\t\t\t\t\t</table>
\t\t\t\t</div>
\t\t\t
\t\t\t\t
\t\t\t</div>
\t\t</div>
\t\t
";
    }

    public function getTemplateName()
    {
        return "CvaGestionMembreBundle::stats.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  176 => 79,  167 => 76,  163 => 75,  160 => 74,  156 => 73,  135 => 57,  130 => 54,  121 => 52,  117 => 51,  114 => 50,  110 => 49,  90 => 31,  81 => 29,  77 => 28,  73 => 27,  70 => 26,  66 => 25,  51 => 12,  48 => 11,  41 => 8,  38 => 7,  32 => 5,  27 => 3,);
    }
}
