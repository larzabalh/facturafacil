<?php

/* JOYASJoyasBundle:Default:index.html.twig */
class __TwigTemplate_97ea697abdd8c39eb681dfe44259a67ae3be279b85c52a33f8597c5dfc987d8d extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("JOYASJoyasBundle::base.html.twig");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'subtitle' => array($this, 'block_subtitle'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "JOYASJoyasBundle::base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        // line 4
        echo "\tInicio ";
        $this->displayBlock('subtitle', $context, $blocks);
        echo " 
";
    }

    public function block_subtitle($context, array $blocks = array())
    {
        echo " Login ";
    }

    // line 8
    public function block_content($context, array $blocks = array())
    {
        // line 9
        echo "\t
<style>\t
\tinput, textarea, .uneditable-input {
\t\twidth: inherit;
\t}
</style>

<h1 style=\"text-align: center;font-family: fantasy; letter-spacing: 3px;font-size: 3em;\">
\tFACTURA<small>Fácil</small>
</h1>
<div class=\"row-fluid\" >
  ";
        // line 20
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "session"), "flashbag"), "get", array(0 => "msgError"), "method"));
        foreach ($context['_seq'] as $context["_key"] => $context["flashMessage"]) {
            // line 21
            echo "\t  <div class=\"span4 offset4\" >
\t\t<div class=\"alert alert-block fade in alert-error\">
\t\t  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
\t\t<h4>";
            // line 24
            echo twig_escape_filter($this->env, (isset($context["flashMessage"]) ? $context["flashMessage"] : $this->getContext($context, "flashMessage")), "html", null, true);
            echo "</h4> 
\t  </div>
\t  </div>
  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['flashMessage'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 28
        echo "  ";
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "session"), "flashbag"), "get", array(0 => "msgWarn"), "method"));
        foreach ($context['_seq'] as $context["_key"] => $context["flashMessage"]) {
            // line 29
            echo "\t  <div class=\"span4 offset4\" >
\t\t<div class=\"alert alert-block fade in alert-warning\">
\t\t  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
\t\t<h4>";
            // line 32
            echo twig_escape_filter($this->env, (isset($context["flashMessage"]) ? $context["flashMessage"] : $this->getContext($context, "flashMessage")), "html", null, true);
            echo "</h4>
\t  </div>
\t  </div>
  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['flashMessage'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 36
        echo "  ";
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "session"), "flashbag"), "get", array(0 => "msgOk"), "method"));
        foreach ($context['_seq'] as $context["_key"] => $context["flashMessage"]) {
            // line 37
            echo "\t  <div class=\"span4 offset4\" >
\t\t<div class=\"alert alert-block fade in alert-success\">
\t\t  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
\t\t<h4>";
            // line 40
            echo twig_escape_filter($this->env, (isset($context["flashMessage"]) ? $context["flashMessage"] : $this->getContext($context, "flashMessage")), "html", null, true);
            echo "</h4>
\t  </div>
\t  </div>
  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['flashMessage'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 44
        echo "  ";
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "session"), "flashbag"), "get", array(0 => "msgInfo"), "method"));
        foreach ($context['_seq'] as $context["_key"] => $context["flashMessage"]) {
            // line 45
            echo "\t  <div class=\"span4 offset4\" >
\t\t<div class=\"alert alert-block fade in alert-info\">
\t\t  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
\t\t<h4>";
            // line 48
            echo twig_escape_filter($this->env, (isset($context["flashMessage"]) ? $context["flashMessage"] : $this->getContext($context, "flashMessage")), "html", null, true);
            echo "</h4>
\t  </div>
\t  </div>
  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['flashMessage'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 52
        echo "</div>
<div class=\"row\">
\t<div class=\"col-md-4 col-md-offset-4\">
\t\t<div class=\"panel panel-default\">
\t\t\t<div class=\"panel-heading\">
\t\t\t\t<h3 class=\"panel-title\">Inicio de Sesi&oacute;n</h3>
\t\t\t</div>
\t\t\t<div class=\"panel-body\">
\t\t\t\t<form action=\"";
        // line 60
        echo $this->env->getExtension('routing')->getPath("joyas_joyas_login");
        echo "\" method=\"POST\" autocomplete=\"off\">
\t\t\t\t\t<fieldset>
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<input class=\"form-control\" placeholder=\"Usuario\" name=\"usuario\" type=\"text\" autofocus=\"\">
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<input class=\"form-control\" placeholder=\"Clave\" name=\"contrasena\" type=\"password\" value=\"\">
\t\t\t\t\t\t</div>
\t\t\t\t\t    <button class=\"btn btn-lg btn-success btn-block\" type=\"submit\">Ingresar</button>
\t\t\t\t\t</fieldset>
\t\t\t\t</form>
\t\t\t</div>
\t\t</div>
\t\t<div class=\"row-fluid\">
\t\t\t<div style=\"text-align: center;\">\t
\t\t\t\t<a href=\"";
        // line 75
        echo $this->env->getExtension('routing')->getPath("joyas_joyas_restClave");
        echo "\" >Olvid&eacute; mi contraseña</a>
\t\t\t</div>
\t\t</div>
\t</div>
</div>

<div class=\"row-fluid\" style=\"margin-top: 30px\">
\t<div class=\"span6 offset3\" style=\"text-align: center; font-size: 100%\">
\t</div>
</div>
";
    }

    public function getTemplateName()
    {
        return "JOYASJoyasBundle:Default:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  168 => 75,  150 => 60,  140 => 52,  130 => 48,  125 => 45,  120 => 44,  110 => 40,  105 => 37,  100 => 36,  90 => 32,  85 => 29,  80 => 28,  70 => 24,  65 => 21,  61 => 20,  48 => 9,  45 => 8,  33 => 4,  30 => 3,);
    }
}
