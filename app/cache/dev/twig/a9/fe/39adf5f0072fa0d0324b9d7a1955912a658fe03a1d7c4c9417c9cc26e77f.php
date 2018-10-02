<?php

/* JOYASJoyasBundle:Usuario:new.html.twig */
class __TwigTemplate_a9fe39adf5f0072fa0d0324b9d7a1955912a658fe03a1d7c4c9417c9cc26e77f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("JOYASJoyasBundle::base.html.twig");

        $this->blocks = array(
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
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "<h1>Nuevo usuario</h1>
<div class=\"joyas-container\" style=\"width: 50%; margin: 0 auto;\">
\t<div class=\"container\">
\t\t";
        // line 7
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'form_start');
        echo "
\t\t\t";
        // line 8
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'errors');
        echo "
\t\t\t";
        // line 9
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'form');
        echo "
\t\t\t<a class=\"btn middle-second\"  href=\"";
        // line 10
        echo $this->env->getExtension('routing')->getPath("usuario");
        echo "\">
\t\t\t\tVolver
\t\t\t</a>
\t\t";
        // line 13
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'form_end');
        echo "
\t</div>
</div>

<script>
\t\$(document).ready(function (){
\t\t\$(\"#joyas_joyasbundle_usuario_logo\").removeAttr('required');
\t});
</script>
";
    }

    public function getTemplateName()
    {
        return "JOYASJoyasBundle:Usuario:new.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  54 => 13,  48 => 10,  44 => 9,  40 => 8,  36 => 7,  31 => 4,  28 => 3,);
    }
}
