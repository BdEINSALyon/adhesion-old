<?php

/* TwigBundle:Exception:error404.html.twig */
class __TwigTemplate_854b47c6e4ba50ece140dc1366a1b601 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"utf-8\" />\t\t
 \t\t\t<link rel=\"stylesheet\" href=\"/GestionMembreCVA/web/app_dev.php/css/13a217f_bootstrap_1.css\" type=\"text/css\" />\t\t
 \t\t\t<link rel=\"stylesheet\" href=\"/GestionMembreCVA/web/app_dev.php/css/13a217f_bootstrap_2.css\" type=\"text/css\" />\t\t
 \t\t\t<link rel=\"stylesheet\" href=\"/GestionMembreCVA/web/app_dev.php/css/13a217f_bootstrap-responsive.min_3.css\" type=\"text/css\" />\t\t
 \t\t\t<link rel=\"stylesheet\" href=\"/GestionMembreCVA/web/app_dev.php/css/13a217f_style_4.css\" type=\"text/css\" />\t\t
 \t\t\t<link rel=\"stylesheet\" href=\"/GestionMembreCVA/web/app_dev.php/css/13a217f_style_5.css\" type=\"text/css\" />
\t\t<title>Accès refusé</title>
    </head>
    <body>
        <div class=\"container\">
\t\t\t<div class=\"navbar\">
\t  \t\t\t<div class=\"navbar-inner\">
\t    \t\t\t<a class=\"brand\" href=\"#\">Menu</a>
\t    \t\t\t\t<ul class=\"nav\">
\t      \t\t\t\t\t<li><a href=\"#\" onClick=\"javascript:window.history.go(-1)\">Retour</a></li>\t \t\t\t\t\t\t\t
\t \t\t\t</div>
\t\t\t</div>
\t\t</div>
\t
\t\t<div class=\"alert alert-error\">
\t\t\t<b>Page introuvable !</b>
\t\t</div>
\t\t<div class=\"container well\">
\t\t\t<img src=\"http://www.unefilleanantes.com/wp-content/uploads/2011/12/autruche_bouche.jpg\" />
\t\t</div>

        \t\t\t\t\t\t\t
\t\t\t\t<script type=\"text/javascript\" src=\"/GestionMembreCVA/web/app_dev.php/js/aa2fcd0_jquery-1.9.1.min_1.js\"></script>
\t\t\t\t\t\t\t
\t\t\t\t<script type=\"text/javascript\" src=\"/GestionMembreCVA/web/app_dev.php/js/aa2fcd0_bootstrap.min_2.js\"></script>
\t\t\t\t\t    
<div id=\"sfwdt90affa6ebafd711f0c3e5898dd45a8623ebf1385\" class=\"sf-toolbar\" style=\"display: none\"></div><script type=\"text/javascript\">/*<![CDATA[*/    Sfjs = (function() {        \"use strict\";        var noop = function() {},            profilerStorageKey = 'sf2/profiler/',            request = function(url, onSuccess, onError, payload, options) {                var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');                options = options || {};                xhr.open(options.method || 'GET', url, true);                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');                xhr.onreadystatechange = function(state) {                    if (4 === xhr.readyState && 200 === xhr.status) {                        (onSuccess || noop)(xhr);                    } else if (4 === xhr.readyState && xhr.status != 200) {                        (onError || noop)(xhr);                    }                };                xhr.send(payload || '');            },            hasClass = function(el, klass) {                return el.className.match(new RegExp('\\\\b' + klass + '\\\\b'));            },            removeClass = function(el, klass) {                el.className = el.className.replace(new RegExp('\\\\b' + klass + '\\\\b'), ' ');            },            addClass = function(el, klass) {                if (!hasClass(el, klass)) { el.className += \" \" + klass; }            },            getPreference = function(name) {                if (!window.localStorage) {                    return null;                }                return localStorage.getItem(profilerStorageKey + name);            },            setPreference = function(name, value) {                if (!window.localStorage) {                    return null;                }                localStorage.setItem(profilerStorageKey + name, value);            };        return {            hasClass: hasClass,            removeClass: removeClass,            addClass: addClass,            getPreference: getPreference,            setPreference: setPreference,            request: request,            load: function(selector, url, onSuccess, onError, options) {                var el = document.getElementById(selector);                if (el && el.getAttribute('data-sfurl') !== url) {                    request(                        url,                        function(xhr) {                            el.innerHTML = xhr.responseText;                            el.setAttribute('data-sfurl', url);                            removeClass(el, 'loading');                            (onSuccess || noop)(xhr, el);                        },                        function(xhr) { (onError || noop)(xhr, el); },                        options                    );                }                return this;            },            toggle: function(selector, elOn, elOff) {                var i,                    style,                    tmp = elOn.style.display,                    el = document.getElementById(selector);                elOn.style.display = elOff.style.display;                elOff.style.display = tmp;                if (el) {                    el.style.display = 'none' === tmp ? 'none' : 'block';                }                return this;            }        }    })();/*]]>*/</script><script type=\"text/javascript\">/*<![CDATA[*/    (function () {                Sfjs.load(            'sfwdt90affa6ebafd711f0c3e5898dd45a8623ebf1385',            '/GestionMembreCVA/web/app_dev.php/_wdt/90affa6ebafd711f0c3e5898dd45a8623ebf1385',            function(xhr, el) {                el.style.display = -1 !== xhr.responseText.indexOf('sf-toolbarreset') ? 'block' : 'none';                if (el.style.display == 'none') {                    return;                }                if (Sfjs.getPreference('toolbar/displayState') == 'none') {                    document.getElementById('sfToolbarMainContent-90affa6ebafd711f0c3e5898dd45a8623ebf1385').style.display = 'none';                    document.getElementById('sfToolbarClearer-90affa6ebafd711f0c3e5898dd45a8623ebf1385').style.display = 'none';                    document.getElementById('sfMiniToolbar-90affa6ebafd711f0c3e5898dd45a8623ebf1385').style.display = 'block';                } else {                    document.getElementById('sfToolbarMainContent-90affa6ebafd711f0c3e5898dd45a8623ebf1385').style.display = 'block';                    document.getElementById('sfToolbarClearer-90affa6ebafd711f0c3e5898dd45a8623ebf1385').style.display = 'block';                    document.getElementById('sfMiniToolbar-90affa6ebafd711f0c3e5898dd45a8623ebf1385').style.display = 'none';                }            },            function(xhr) {                if (xhr.status !== 0) {                    confirm('An error occurred while loading the web debug toolbar (' + xhr.status + ': ' + xhr.statusText + ').\\n\\nDo you want to open the profiler?') && (window.location = '/GestionMembreCVA/web/app_dev.php/_profiler/90affa6ebafd711f0c3e5898dd45a8623ebf1385');                }            }        );    })();/*]]>*/</script>
</body>
</html>
";
    }

    public function getTemplateName()
    {
        return "TwigBundle:Exception:error404.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}
