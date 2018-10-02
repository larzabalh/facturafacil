<?php

/* JOYASJoyasBundle:Factura:index.html.twig */
class __TwigTemplate_3fb3b879cf5b6a60b46eea9fb10a123b9269494e51090fd0929a637a193281fa extends Twig_Template
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

    // line 2
    public function block_content($context, array $blocks = array())
    {
        // line 3
        echo "<div class=\"row\">
\t\t<div class=\"col-lg-12\">
\t\t\t<h1 class=\"page-header\">Ventas
                <a class=\"btn btn-success\" href=\"";
        // line 6
        echo $this->env->getExtension('routing')->getPath("factura_new");
        echo "\" style=\"float: right;\">
    \t\t\t\tRegistrar Venta
                </a>
\t\t\t</h1>
\t\t</div>
\t\t<!-- /.col-lg-12 -->
\t</div>
\t<div class=\"row-fluid filtro\">
\t\t<form id=\"searchForm\" action=\"";
        // line 14
        echo $this->env->getExtension('routing')->getPath("factura_filtro");
        echo "\" method=\"POST\">
\t\t\t<li class=\"sidebar-search\" style=\"width\">
\t\t\t\t<div class=\"input-group custom-search-form\" style=\"width: 70%;\">
\t\t\t\t\t<input type=\"text\" style=\"width:30%;\" value=\"";
        // line 17
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "request"), "get", array(0 => "fechaDesde"), "method"), "html", null, true);
        echo "\" id=\"fechaDesde\" class=\"form-control\" name=\"fechaDesde\" placeholder=\"fecha desde\">
\t\t\t\t\t<input type=\"text\" style=\"width:30%;\" value=\"";
        // line 18
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "request"), "get", array(0 => "fechaHasta"), "method"), "html", null, true);
        echo "\" id=\"fechaHasta\" class=\"form-control\" name=\"fechaHasta\" placeholder=\"fecha hasta\">
\t\t\t\t\t<select name=\"listado\" style=\"width:30%;\" class=\"form-control\">
\t\t\t\t\t\t<option value=\"0\">Elegir Cliente</option>
\t\t\t\t\t\t";
        // line 21
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["clientesProveedores"]) ? $context["clientesProveedores"] : $this->getContext($context, "clientesProveedores")));
        foreach ($context['_seq'] as $context["_key"] => $context["clienteProveedor"]) {
            // line 22
            echo "\t\t\t\t\t\t\t<option value=\"";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["clienteProveedor"]) ? $context["clienteProveedor"] : $this->getContext($context, "clienteProveedor")), "id"), "html", null, true);
            echo "\">
\t\t\t\t\t\t\t\t";
            // line 23
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["clienteProveedor"]) ? $context["clienteProveedor"] : $this->getContext($context, "clienteProveedor")), "razonSocial"), "html", null, true);
            echo "
\t\t\t\t\t\t\t</option>
\t\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['clienteProveedor'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 26
        echo "\t\t\t        </select>
\t\t\t\t\t<button class=\"btn btn-default\" type=\"button\" onclick=\"\$('#searchForm').submit();\">
\t\t\t\t\t\t<i class=\"fa fa-search\"></i>
\t\t\t\t\t</button>
\t\t\t\t</div>
\t\t\t\t<!-- /input-group -->
\t\t\t</li>
\t\t</form>
\t</div>

\t<div class=\"tablasScroll\">
\t\t<table id=\"tablaSF\" class=\"display\">
\t\t\t<thead>
\t\t\t\t<tr>
\t\t\t\t\t<th>Fecha</th>
\t\t\t\t\t<th>Factura</th>
\t\t\t\t\t<th>Cliente</th>
\t\t\t\t\t<th>Importe</th>
\t\t\t\t</tr>
\t\t\t</thead>
\t\t\t<tbody>
\t\t\t";
        // line 47
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["entities"]) ? $context["entities"] : $this->getContext($context, "entities")));
        foreach ($context['_seq'] as $context["_key"] => $context["entity"]) {
            // line 48
            echo "\t\t\t\t<tr>
\t\t\t\t\t<td>";
            // line 49
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "fecha"), "Y-m-d H:i"), "html", null, true);
            echo "</td>
\t\t\t\t\t<td>
                        ";
            // line 51
            if ($this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "nrofactura")) {
                // line 52
                echo "                        <a href=\"";
                echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("factura_show", array("id" => $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "id"), "tipo" => "F")), "html", null, true);
                echo "\">Factura ";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "tipofactura"), "html", null, true);
                echo " - Nro: ";
                echo twig_escape_filter($this->env, (($this->getAttribute((isset($context["entity"]) ? $context["entity"] : null), "nrofactura", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["entity"]) ? $context["entity"] : null), "nrofactura"), $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "id"))) : ($this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "id"))), "html", null, true);
                echo "</a> - Pto. Vta.: ";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "punto"), "numero"), "html", null, true);
                echo "
                        ";
            } else {
                // line 54
                echo "                        <a style=\"color: red;\" href=\"";
                echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("factura_show", array("id" => $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "id"), "tipo" => "F")), "html", null, true);
                echo "\">Factura ";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "tipofactura"), "html", null, true);
                echo " - Nro:  ";
                echo twig_escape_filter($this->env, (($this->getAttribute((isset($context["entity"]) ? $context["entity"] : null), "nrofactura", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["entity"]) ? $context["entity"] : null), "nrofactura"), $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "id"))) : ($this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "id"))), "html", null, true);
                echo "</a> - Pto. Vta.: ";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "punto"), "numero"), "html", null, true);
                if ($this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "punto")) {
                    echo " - <a class=\"btn btn-default\" href=\"";
                    echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("factura_refacturar", array("id" => $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "id"))), "html", null, true);
                    echo "\"><i class=\"fa fa-spin fa-refresh\"></i></a>";
                }
                // line 55
                echo "                        ";
            }
            // line 56
            echo "                    </td>
\t\t\t\t\t<td>";
            // line 57
            echo twig_escape_filter($this->env, (($this->getAttribute((isset($context["entity"]) ? $context["entity"] : null), "cliente", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["entity"]) ? $context["entity"] : null), "cliente"), "")) : ("")), "html", null, true);
            echo "</a></td>
\t\t\t\t\t<td>
    \t\t\t\t\t\$ ";
            // line 59
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "importe"), "html", null, true);
            echo "
\t\t\t\t\t</td>
\t\t\t\t</tr>
\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['entity'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 63
        echo "\t\t\t</tbody>
\t\t</table>
\t</div>
\t<div class=\"col-sm-12\">
\t\t";
        // line 67
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
        return "JOYASJoyasBundle:Factura:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  171 => 67,  165 => 63,  155 => 59,  150 => 57,  147 => 56,  144 => 55,  130 => 54,  118 => 52,  116 => 51,  111 => 49,  108 => 48,  104 => 47,  81 => 26,  72 => 23,  67 => 22,  63 => 21,  57 => 18,  53 => 17,  47 => 14,  36 => 6,  31 => 3,  28 => 2,);
    }
}
