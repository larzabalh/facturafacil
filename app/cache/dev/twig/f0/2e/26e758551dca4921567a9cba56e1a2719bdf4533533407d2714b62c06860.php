<?php

/* JOYASJoyasBundle:Usuario:index.html.twig */
class __TwigTemplate_f02e26e758551dca4921567a9cba56e1a2719bdf4533533407d2714b62c06860 extends Twig_Template
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
        echo "<h1 style=\"margin-bottom:10px;\">
        Usuarios
        ";
        // line 5
        if (($this->getAttribute((isset($context["usuario"]) ? $context["usuario"] : $this->getContext($context, "usuario")), "perfil") == "ADMINISTRADOR")) {
            // line 6
            echo "        <a style=\"float: right;\" class=\"btn btn-default\" href=\"";
            echo $this->env->getExtension('routing')->getPath("usuario_new");
            echo "\">
            Crear
        </a>
        ";
        }
        // line 10
        echo "    </h1>
    <div class=\"tablasScroll\">
        <table id=\"tablas\" class=\"display\">
            <thead>
                <tr>
                    <th>Razoón Social</th>
                    <th>CUIT</th>
                    <th>Mail</th>
                    <th>Login</th>
                    <th>Clave</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                ";
        // line 24
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["entities"]) ? $context["entities"] : $this->getContext($context, "entities")));
        foreach ($context['_seq'] as $context["_key"] => $context["entity"]) {
            // line 25
            echo "                    <tr>
                        <td>";
            // line 26
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "razonsocial"), "html", null, true);
            echo "</td>
                        <td>";
            // line 27
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "cuit"), "html", null, true);
            echo "</td>
                        <td>";
            // line 28
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "mail"), "html", null, true);
            echo "</td>
                        <td>";
            // line 29
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "login"), "html", null, true);
            echo "</td>
                        <td>";
            // line 30
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "clave"), "html", null, true);
            echo "</td>
                        <td>
                            <a class=\"btn btn-success\" href=\"";
            // line 32
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("usuario_edit", array("id" => $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "id"))), "html", null, true);
            echo "\"><i class=\"fa fa-pencil\"></i></a>
                            <a class=\"btn btn-info\" href=\"";
            // line 33
            echo $this->env->getExtension('routing')->getPath("puntoventa");
            echo "\"><i class=\"fa fa-home\"></i></a>
                            ";
            // line 34
            if (($this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "estado") == "A")) {
                // line 35
                echo "                                ";
                if (($this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "id") != $this->getAttribute((isset($context["usuario"]) ? $context["usuario"] : $this->getContext($context, "usuario")), "id"))) {
                    // line 36
                    echo "                                <a class=\"btn btn-danger\" href=\"";
                    echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("usuario_delete", array("id" => $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "id"))), "html", null, true);
                    echo "\"><i class=\"fa fa-times\"></i></a>
                                ";
                }
                // line 38
                echo "                            ";
            } else {
                // line 39
                echo "                            <a class=\"btn btn-primary\" href=\"";
                echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("usuario_activar", array("id" => $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "id"))), "html", null, true);
                echo "\"><i class=\"fa fa-spin fa-refresh\"></i></a>
                            ";
            }
            // line 41
            echo "                        </td>
                    </tr>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['entity'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 44
        echo "            </tbody>
        </table>
    </div>

    <script>

        activarActionsTab('usuario');
    </script>
";
    }

    public function getTemplateName()
    {
        return "JOYASJoyasBundle:Usuario:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  125 => 44,  117 => 41,  111 => 39,  108 => 38,  102 => 36,  99 => 35,  97 => 34,  93 => 33,  89 => 32,  84 => 30,  80 => 29,  76 => 28,  72 => 27,  68 => 26,  65 => 25,  61 => 24,  45 => 10,  37 => 6,  35 => 5,  31 => 3,  28 => 2,);
    }
}
