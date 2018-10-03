<?php

/* JOYASJoyasBundle::base.html.twig */
class __TwigTemplate_c8cb58b2651675eeb62895d18291c6608fb4add5662184c216e5ca11c5014fd0 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\">
    <head>
        <meta charset=\"utf-8\">
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
        <meta name=\"description\" content=\"Factura Electronica Fácil.\">
        <meta name=\"keywords\" content=\"Factura Electr&oacute;nica Fácil.\">
        <meta name=\"author\" content=\"Nicolas Corvalan\">

        <title>Factura Fácil</title>

        <!-- DATA TABLE -->
        <script type=\"text/javascript\" src=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/DataTable/jquery-1.11.3.min.js"), "html", null, true);
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 15
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/DataTable/jquery.dataTables.min.js"), "html", null, true);
        echo "\"></script>
        <link rel=\"stylesheet\" href=\"";
        // line 16
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/DataTable/jquery.dataTables.css"), "html", null, true);
        echo "\">

        <!-- Bootstrap Core CSS -->
        <link href=\"";
        // line 19
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/nuevo/bower_components/bootstrap/dist/css/bootstrap.min.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">

        <!-- MetisMenu CSS -->
        <link href=\"";
        // line 22
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/nuevo/bower_components/metisMenu/dist/metisMenu.min.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">

        <!-- Custom CSS -->
        <link href=\"";
        // line 25
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/nuevo/dist/css/sb-admin-2.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">

        <!-- Custom Fonts -->
        <link href=\"";
        // line 28
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/nuevo/bower_components/font-awesome/css/font-awesome.min.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\">

        <!-- Bootstrap Core JavaScript -->
        <script src=\"";
        // line 31
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/nuevo/bower_components/bootstrap/dist/js/bootstrap.min.js"), "html", null, true);
        echo "\"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src=\"";
        // line 34
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/nuevo/bower_components/metisMenu/dist/metisMenu.min.js"), "html", null, true);
        echo "\"></script>

        <!-- Custom Theme JavaScript -->
        <script src=\"";
        // line 37
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/nuevo/dist/js/sb-admin-2.js"), "html", null, true);
        echo "\"></script>
        <!-- Datepicker -->
        <link rel=\"stylesheet\" href=\"";
        // line 39
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/datetimepicker/jquery.datetimepicker.css"), "html", null, true);
        echo "\">
        <script src=\"";
        // line 40
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/datetimepicker/jquery.datetimepicker.js"), "html", null, true);
        echo "\"></script>


        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src=\"https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js\"></script>
            <script src=\"https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js\"></script>
        <![endif]-->
        <script>
            \$('input').blur(function () {
                var str = \$(this).val();
                \$(this).val(str.replace(\",\", \".\"));
            });

            var table;
            var tableSF;
            \$(document).ready(function () {
                \$('input').blur(function () {
                    var str = \$(this).val();
                    \$(this).val(str.replace(\",\", \".\"));
                });

                table = \$('#tablas').DataTable({
                    \"scrollY\": \"400px\",
                    \"scrollX\": true,
                    \"scrollCollapse\": true,
                    \"paging\": false,
                    \"info\": false,
                    responsive: true,
                    \"filter\": true,
                    \"order\": [[0, \"asc\"]],
                    \"oLanguage\": {
                        \"sSearch\": \"Buscar:\"
                    }
                });
                table = \$('#tablapedidos').DataTable({
                    \"scrollY\": \"400px\",
                    \"scrollX\": true,
                    \"scrollCollapse\": true,
                    \"paging\": false,
                    \"info\": false,
                    responsive: true,
                    \"filter\": true,
                    \"order\": [[0, \"desc\"]],
                    \"oLanguage\": {
                        \"sSearch\": \"Buscar:\"
                    }
                });

                tableSF = \$('#tablaSF').DataTable({
                    \"scrollY\": \"400px\",
                    \"scrollCollapse\": true,
                    \"scrollX\": true,
                    \"paging\": false,
                    \"info\": false,
                    responsive: true,
                    \"filter\": false,
                    \"order\": [[0, \"desc\"]]
                });

                \$(\"#fechavencimiento, #fechaDocumento, #fechaHasta, #fechaVencimientoDesde, #fechaVencimientoHasta\").datetimepicker({
                    format: 'd-m-Y'
                });
                \$(\".datetimepicker\").datetimepicker({
                    format: 'Y-m-d'
                });
                \$(\"select, input\").addClass('form-control');
                \$('[data-toggle=\"tooltip\"]').tooltip();
            });

            \$(window).resize(function () {
                \$('#tablas').DataTable().columns.adjust().draw();
                \$('#tablaSF').DataTable().columns.adjust().draw();
            });
            \$(window).load(function () {
                \$('.preloader').fadeOut(1000); // set duration in brackets
            });

        </script>
        <link href=\"";
        // line 120
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/style.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\">
    </head>

    <body>
        ";
        // line 124
        $context["login"] = $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "session"), "get", array(0 => "login"), "method");
        // line 125
        echo "
        <div id=\"wrapper\">
            <!-- Navigation -->
            <nav class=\"navbar navbar-default navbar-static-top\" role=\"navigation\" style=\"margin-bottom: 0\">
\t\t\t";
        // line 129
        if (((isset($context["login"]) ? $context["login"] : $this->getContext($context, "login")) == true)) {
            // line 130
            echo "                ";
            $context["usuario"] = $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "session"), "get", array(0 => "usuario"), "method");
            // line 131
            echo "                <div class=\"navbar-header\">
                    <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\".navbar-collapse\">
                        <span class=\"sr-only\">Toggle navigation</span>
                        <span class=\"icon-bar\"></span>
                        <span class=\"icon-bar\"></span>
                        <span class=\"icon-bar\"></span>
                    </button>
                    <a class=\"navbar-brand\" href=\"";
            // line 138
            echo $this->env->getExtension('routing')->getPath("joyas_joyas_inicio");
            echo "\" style=\"font-family: fantasy; letter-spacing: 3px;font-size: 1em;line-height: 45px;\">
\t\t\t\t\t\t<span style=\"color:black;\">FACTURA</span><small>Fácil</small>
                    </a>
                </div>
\t\t\t\t<ul class=\"nav navbar-top-links navbar-right\">
\t\t\t\t\t<li class=\"dropdown\">
\t\t\t\t\t\t<a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">
\t\t\t\t\t\t\t";
            // line 145
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["usuario"]) ? $context["usuario"] : $this->getContext($context, "usuario")), "razonsocial"), "html", null, true);
            echo "<i class=\"fa fa-user fa-fw\"></i>  <i class=\"fa fa-caret-down\"></i>
\t\t\t\t\t\t</a>
\t\t\t\t\t\t<ul class=\"dropdown-menu dropdown-user\">
\t\t\t\t\t\t\t<li><a href=\"";
            // line 148
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("usuario_edit", array("id" => $this->getAttribute((isset($context["usuario"]) ? $context["usuario"] : $this->getContext($context, "usuario")), "id"))), "html", null, true);
            echo "\"><i class=\"fa fa-gear fa-fw\"></i>Mis Datos</a>
\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t<li class=\"divider\"></li>
\t\t\t\t\t\t\t<li><a href=\"";
            // line 151
            echo $this->env->getExtension('routing')->getPath("joyas_joyas_cerrarSession");
            echo "\"><i class=\"fa fa-sign-out fa-fw\"></i> Cerrar Sesi&oacute;n</a>
\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t\t<!-- /.dropdown-user -->
\t\t\t\t\t</li>
\t\t\t\t\t<!-- /.dropdown -->
\t\t\t\t</ul>
\t\t\t\t<!-- /.navbar-top-links -->
\t\t\t";
        }
        // line 160
        echo "\t\t\t";
        if (((isset($context["login"]) ? $context["login"] : $this->getContext($context, "login")) == true)) {
            // line 161
            echo "                <div class=\"navbar-default sidebar\" role=\"navigation\">
                    <div class=\"sidebar-nav navbar-collapse\">
                        <ul class=\"nav\" id=\"side-menu\">
                                <li class=\"dropdown\">
                                    <a href=\"#\"><i class=\"fa fa-sitemap fa-fw\"></i>GESTI&Oacute;N<span class=\"fa arrow\"></span></a>
                                    <ul class=\"nav nav-second-level\">
                                        <li>
                                            <a href=\"";
            // line 168
            echo $this->env->getExtension('routing')->getPath("factura_new");
            echo " \">
                                                Nueva Factura
                                            </a>
                                        </li>
                                        <li>
                                            <a href=\"";
            // line 173
            echo $this->env->getExtension('routing')->getPath("factura");
            echo " \">
                                                Facturas
                                            </a>
                                        </li>
                                        <li>
                                            <a href=\"";
            // line 178
            echo $this->env->getExtension('routing')->getPath("factura_newcredito");
            echo " \">
                                                Nueva Nota de Cr&eacute;dito
                                            </a>
                                        </li>
                                        <li>
                                            <a href=\"";
            // line 183
            echo $this->env->getExtension('routing')->getPath("notacredito");
            echo " \">
                                                Notas de Cr&eacute;dito
                                            </a>
                                        </li>
                                        <li>
                                            <a href=\"";
            // line 188
            echo $this->env->getExtension('routing')->getPath("cliente");
            echo "\">Clientes</a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-second-level -->
                                </li>
                                <li class=\"dropdown\">
                                    <a href=\"#\"><i class=\"fa fa-info-circle fa-fw\"></i> Informes <span class=\"fa arrow\"></span></a>
                                    <ul class=\"nav nav-second-level\">
                                        <li>
                                            <a href=\"";
            // line 197
            echo $this->env->getExtension('routing')->getPath("factura_filtro");
            echo "\">
                                                Informe de Ventas
                                            </a>
                                        </li>
                                        <li>
                                            <a href=\"";
            // line 202
            echo $this->env->getExtension('routing')->getPath("factura_irinformeimpuestos");
            echo "\">
                                                CITI VENTAS
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-second-level -->
                                </li>
                                <li>
                                    <a href=\"#\"><i class=\"fa fa-lock fa-fw\"></i> Seguridad<span class=\"fa arrow\"></span></a>
                                    <ul class=\"nav nav-second-level\">
                                        <li id=\"usuario\">
                                            <a href=\"";
            // line 213
            echo $this->env->getExtension('routing')->getPath("usuario");
            echo "\">
                                                Usuarios
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                        </ul>
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
\t\t\t\t";
        }
        // line 224
        echo "                <!-- /.navbar-static-side -->
            </nav>

            <!-- Page Content -->
            ";
        // line 228
        if (((isset($context["login"]) ? $context["login"] : $this->getContext($context, "login")) == false)) {
            // line 229
            echo "                <div id=\"page-wrapper\" style=\"margin: 0 0 0 0;\">
                ";
        } else {
            // line 231
            echo "                    <div id=\"page-wrapper\">
                    ";
        }
        // line 233
        echo "                    <div class=\"container-fluid\">
                        <div class=\"row-fluid\" >
                            ";
        // line 235
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "session"), "flashbag"), "get", array(0 => "msgError"), "method"));
        foreach ($context['_seq'] as $context["_key"] => $context["flashMessage"]) {
            // line 236
            echo "                                <div class=\"span4 offset4\" >
                                    <div class=\"alert alert-block fade in alert-error\">
                                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
                                        <h4>";
            // line 239
            echo twig_escape_filter($this->env, (isset($context["flashMessage"]) ? $context["flashMessage"] : $this->getContext($context, "flashMessage")), "html", null, true);
            echo "</h4>
                                    </div>
                                </div>
                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['flashMessage'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 243
        echo "                            ";
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "session"), "flashbag"), "get", array(0 => "msgWarn"), "method"));
        foreach ($context['_seq'] as $context["_key"] => $context["flashMessage"]) {
            // line 244
            echo "                                <div class=\"span4 offset4\" >
                                    <div class=\"alert alert-block fade in alert-warning\">
                                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
                                        <h4>";
            // line 247
            echo twig_escape_filter($this->env, (isset($context["flashMessage"]) ? $context["flashMessage"] : $this->getContext($context, "flashMessage")), "html", null, true);
            echo "</h4>
                                    </div>
                                </div>
                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['flashMessage'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 251
        echo "                            ";
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "session"), "flashbag"), "get", array(0 => "msgOk"), "method"));
        foreach ($context['_seq'] as $context["_key"] => $context["flashMessage"]) {
            // line 252
            echo "                                <div class=\"span4 offset4\" >
                                    <div class=\"alert alert-block fade in alert-success\">
                                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
                                        <h4>";
            // line 255
            echo twig_escape_filter($this->env, (isset($context["flashMessage"]) ? $context["flashMessage"] : $this->getContext($context, "flashMessage")), "html", null, true);
            echo "</h4>
                                    </div>
                                </div>
                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['flashMessage'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 259
        echo "                            ";
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "session"), "flashbag"), "get", array(0 => "msgInfo"), "method"));
        foreach ($context['_seq'] as $context["_key"] => $context["flashMessage"]) {
            // line 260
            echo "                                <div class=\"span4 offset4\" >
                                    <div class=\"alert alert-block fade in alert-info\">
                                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
                                        <h4>";
            // line 263
            echo twig_escape_filter($this->env, (isset($context["flashMessage"]) ? $context["flashMessage"] : $this->getContext($context, "flashMessage")), "html", null, true);
            echo "</h4>
                                    </div>
                                </div>
                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['flashMessage'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 267
        echo "                        </div>
\t\t\t\t\t\t<div class=\"preloader\">
\t\t\t\t\t\t\t<i class=\"fa fa-cog fa-spin fa-3x fa-fw\"></i>
\t\t\t\t\t\t</div>
                        ";
        // line 271
        $this->displayBlock('content', $context, $blocks);
        // line 274
        echo "                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- /#page-wrapper -->
            </div>
            <!-- /#wrapper -->
            <script>
                \$('.arrowToggle').click(function () {
                    if (\$('.actionsColumn').css('display') == 'none') {

                        \$('.contentColumn').addClass('span9').removeClass('span12');
                        window.setTimeout(function () {
                            \$('.actionsColumn').toggle('slide');
                            \$('.icon-chevron-right').addClass('icon-chevron-left').removeClass('icon-chevron-right');
                        }, 1);

                    } else {
                        \$('.actionsColumn').toggle('slide');
                        window.setTimeout(function () {
                            \$('.icon-chevron-left').addClass('icon-chevron-right').removeClass('icon-chevron-left');
                            \$('.contentColumn').addClass('span12').removeClass('span9');
                        },
                                500);
                    }
                });
            </script>
            <footer style=\"text-align:center;\">
                <strong>Factura Electr&oacute;nica Fácil V2.0</strong>
            </footer>
    </body>

</html>
";
    }

    // line 271
    public function block_content($context, array $blocks = array())
    {
        // line 272
        echo "
                        ";
    }

    public function getTemplateName()
    {
        return "JOYASJoyasBundle::base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  478 => 272,  475 => 271,  439 => 274,  437 => 271,  431 => 267,  421 => 263,  416 => 260,  411 => 259,  401 => 255,  396 => 252,  391 => 251,  381 => 247,  376 => 244,  371 => 243,  361 => 239,  356 => 236,  352 => 235,  348 => 233,  344 => 231,  340 => 229,  338 => 228,  332 => 224,  318 => 213,  304 => 202,  296 => 197,  284 => 188,  276 => 183,  268 => 178,  260 => 173,  252 => 168,  243 => 161,  240 => 160,  228 => 151,  222 => 148,  216 => 145,  206 => 138,  197 => 131,  194 => 130,  192 => 129,  186 => 125,  184 => 124,  177 => 120,  94 => 40,  79 => 34,  73 => 31,  67 => 28,  55 => 22,  49 => 19,  43 => 16,  39 => 15,  35 => 14,  20 => 1,  168 => 75,  150 => 60,  140 => 52,  130 => 48,  125 => 45,  120 => 44,  110 => 40,  105 => 37,  100 => 36,  90 => 39,  85 => 37,  80 => 28,  70 => 24,  65 => 21,  61 => 25,  48 => 9,  45 => 8,  33 => 4,  30 => 3,);
    }
}
