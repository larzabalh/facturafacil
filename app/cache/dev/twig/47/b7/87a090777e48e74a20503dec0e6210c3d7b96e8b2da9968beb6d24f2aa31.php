<?php

/* JOYASJoyasBundle:PuntoVenta:new.html.twig */
class __TwigTemplate_47b787a090777e48e74a20503dec0e6210c3d7b96e8b2da9968beb6d24f2aa31 extends Twig_Template
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
        echo "<h1>
        Alta de Punto Venta
        <a class=\"btn btn-primary\" href=\"";
        // line 6
        echo $this->env->getExtension('routing')->getPath("puntoventa");
        echo "\">
            Volver
        </a>
    </h1>
    <div class=\"tablasScroll col-md-6 col-md-offset-2\">
        ";
        // line 11
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'form');
        echo "
    </div>
";
    }

    public function getTemplateName()
    {
        return "JOYASJoyasBundle:PuntoVenta:new.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  43 => 11,  35 => 6,  31 => 4,  28 => 3,);
    }
}
