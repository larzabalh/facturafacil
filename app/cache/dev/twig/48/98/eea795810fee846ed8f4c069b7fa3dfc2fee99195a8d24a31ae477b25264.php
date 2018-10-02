<?php

/* JOYASJoyasBundle:Cliente:index.html.twig */
class __TwigTemplate_4898eea795810fee846ed8f4c069b7fa3dfc2fee99195a8d24a31ae477b25264 extends Twig_Template
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
\t\t\t<h1 class=\"page-header\">Clientes
\t\t\t<a style=\"float:right;\" class=\"btn btn-default\" href=\"";
        // line 7
        echo $this->env->getExtension('routing')->getPath("cliente_new");
        echo "\">
\t\t\t\tCrear
\t\t\t</a>
\t\t\t</h1>
\t\t</div>
\t\t<!-- /.col-lg-12 -->
\t</div>
\t<div class=\"tablasScroll\">
\t\t<table id=\"tablas\" class=\"display\">
\t\t\t<thead>
\t\t\t\t<tr>
\t\t\t\t\t<th>Raz&oacute;n Social</th>
\t\t\t\t\t<th>CUIT / DNI</th>
\t\t\t\t\t<th>Mail</th>
\t\t\t\t\t<th>Acciones</th>
\t\t\t\t</tr>
\t\t\t</thead>
\t\t\t<tbody>
\t\t\t";
        // line 25
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["entities"]) ? $context["entities"] : $this->getContext($context, "entities")));
        foreach ($context['_seq'] as $context["_key"] => $context["entity"]) {
            // line 26
            echo "\t\t\t\t<tr>
\t\t\t\t\t<td><a title=\"Cuenta Corriente\" href=\"";
            // line 27
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("cliente_show", array("id" => $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "id"))), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "razonSocial"), "html", null, true);
            echo "</a></td>
\t\t\t\t\t<td>";
            // line 28
            echo twig_escape_filter($this->env, (($this->getAttribute((isset($context["entity"]) ? $context["entity"] : null), "cuit", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["entity"]) ? $context["entity"] : null), "cuit"), $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "dni"))) : ($this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "dni"))), "html", null, true);
            echo "</td>
\t\t\t\t\t<td>";
            // line 29
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "mail"), "html", null, true);
            echo "</td>
\t\t\t\t\t<td>
\t\t\t\t\t\t<a title=\"Editar\" class=\"btn btn-default\" href=\"";
            // line 31
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("cliente_edit", array("id" => $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "id"))), "html", null, true);
            echo "\"><i class=\"fa fa-pencil\"></i></a>
\t\t\t\t\t</td>
\t\t\t\t</tr>
\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['entity'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 35
        echo "\t\t\t</tbody>
\t\t</table>
\t</div>
\t<div class=\"col-sm-12\">
\t\t";
        // line 39
        echo $this->env->getExtension('pagerfanta')->renderPagerfanta((isset($context["entities"]) ? $context["entities"] : $this->getContext($context, "entities")), "twitter_bootstrap_translated", array("prev_message" => "Anterior", "next_message" => "Siguiente"));
        echo "
\t</div>
    <script>
    \t\$('document').ready(function(){
    \t\t\$('td').css('padding', '2px');
    \t\t\$('.pagination a').attr('class', 'btn btn-default');
    \t\t\$('.pagination li').css('float', 'left');
    \t\t\$('.pagination').css('width', '100%');
    \t});
    </script>
    <style>
    .active .btn
    {
        background-color: #9E9E9E;
    }
    </style>

";
    }

    public function getTemplateName()
    {
        return "JOYASJoyasBundle:Cliente:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  95 => 39,  89 => 35,  79 => 31,  74 => 29,  70 => 28,  64 => 27,  61 => 26,  57 => 25,  36 => 7,  31 => 4,  28 => 3,);
    }
}
