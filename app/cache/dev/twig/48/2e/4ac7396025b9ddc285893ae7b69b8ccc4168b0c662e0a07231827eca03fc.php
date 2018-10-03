<?php

/* JOYASJoyasBundle:PuntoVenta:index.html.twig */
class __TwigTemplate_482e4ac7396025b9ddc285893ae7b69b8ccc4168b0c662e0a07231827eca03fc extends Twig_Template
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
        echo "<div class=\"row\">
\t\t<div class=\"col-lg-12\">
\t\t\t<h1 class=\"page-header\">
                Puntos de Venta
    \t\t\t<a class=\"btn btn-primary\" href=\"";
        // line 8
        echo $this->env->getExtension('routing')->getPath("puntoventa_new");
        echo "\">
    \t\t\t\tCrear
    \t\t\t</a>
\t\t\t</h1>
\t\t</div>
\t\t<!-- /.col-lg-12 -->
\t</div>
\t<div class=\"tablasScroll\">
\t\t<table id=\"tablas\" class=\"display\">
            <thead>
                <tr>
                    <th>Descripcion</th>
                    <th>Numero</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            ";
        // line 25
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["entities"]) ? $context["entities"] : $this->getContext($context, "entities")));
        foreach ($context['_seq'] as $context["_key"] => $context["entity"]) {
            // line 26
            echo "                <tr>
                    <td>";
            // line 27
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "descripcion"), "html", null, true);
            echo "</td>
                    <td>";
            // line 28
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "numero"), "html", null, true);
            echo "</td>
                    <td>
                        <a class=\"btn btn-success\" href=\"";
            // line 30
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("puntoventa_edit", array("id" => $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "id"))), "html", null, true);
            echo "\"><i class=\"fa fa-pencil\"></i></a>
                        ";
            // line 31
            if (($this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "estado") == "A")) {
                // line 32
                echo "                        <a class=\"btn btn-danger\" href=\"";
                echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("puntoventa_delete", array("id" => $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "id"))), "html", null, true);
                echo "\"><i class=\"fa fa-times\"></i></a>
                        ";
            } else {
                // line 34
                echo "                        <a class=\"btn btn-primary\" href=\"";
                echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("puntoventa_activar", array("id" => $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "id"))), "html", null, true);
                echo "\">Activar</a>
                        ";
            }
            // line 36
            echo "                    </td>
                </tr>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['entity'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 39
        echo "            </tbody>
        </table>
    </div>
    ";
    }

    public function getTemplateName()
    {
        return "JOYASJoyasBundle:PuntoVenta:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  99 => 39,  91 => 36,  85 => 34,  79 => 32,  77 => 31,  73 => 30,  68 => 28,  64 => 27,  61 => 26,  57 => 25,  37 => 8,  31 => 4,  28 => 3,);
    }
}
