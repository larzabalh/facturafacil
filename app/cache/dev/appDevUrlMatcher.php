<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appDevUrlMatcher
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appDevUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);

        if (0 === strpos($pathinfo, '/_')) {
            // _wdt
            if (0 === strpos($pathinfo, '/_wdt') && preg_match('#^/_wdt/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_wdt')), array (  '_controller' => 'web_profiler.controller.profiler:toolbarAction',));
            }

            if (0 === strpos($pathinfo, '/_profiler')) {
                // _profiler_home
                if (rtrim($pathinfo, '/') === '/_profiler') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_profiler_home');
                    }

                    return array (  '_controller' => 'web_profiler.controller.profiler:homeAction',  '_route' => '_profiler_home',);
                }

                if (0 === strpos($pathinfo, '/_profiler/search')) {
                    // _profiler_search
                    if ($pathinfo === '/_profiler/search') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchAction',  '_route' => '_profiler_search',);
                    }

                    // _profiler_search_bar
                    if ($pathinfo === '/_profiler/search_bar') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchBarAction',  '_route' => '_profiler_search_bar',);
                    }

                }

                // _profiler_purge
                if ($pathinfo === '/_profiler/purge') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:purgeAction',  '_route' => '_profiler_purge',);
                }

                if (0 === strpos($pathinfo, '/_profiler/i')) {
                    // _profiler_info
                    if (0 === strpos($pathinfo, '/_profiler/info') && preg_match('#^/_profiler/info/(?P<about>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_info')), array (  '_controller' => 'web_profiler.controller.profiler:infoAction',));
                    }

                    // _profiler_import
                    if ($pathinfo === '/_profiler/import') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:importAction',  '_route' => '_profiler_import',);
                    }

                }

                // _profiler_export
                if (0 === strpos($pathinfo, '/_profiler/export') && preg_match('#^/_profiler/export/(?P<token>[^/\\.]++)\\.txt$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_export')), array (  '_controller' => 'web_profiler.controller.profiler:exportAction',));
                }

                // _profiler_phpinfo
                if ($pathinfo === '/_profiler/phpinfo') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  '_route' => '_profiler_phpinfo',);
                }

                // _profiler_search_results
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/search/results$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_search_results')), array (  '_controller' => 'web_profiler.controller.profiler:searchResultsAction',));
                }

                // _profiler
                if (preg_match('#^/_profiler/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler')), array (  '_controller' => 'web_profiler.controller.profiler:panelAction',));
                }

                // _profiler_router
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/router$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_router')), array (  '_controller' => 'web_profiler.controller.router:panelAction',));
                }

                // _profiler_exception
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception')), array (  '_controller' => 'web_profiler.controller.exception:showAction',));
                }

                // _profiler_exception_css
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception\\.css$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception_css')), array (  '_controller' => 'web_profiler.controller.exception:cssAction',));
                }

            }

            if (0 === strpos($pathinfo, '/_configurator')) {
                // _configurator_home
                if (rtrim($pathinfo, '/') === '/_configurator') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_configurator_home');
                    }

                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::checkAction',  '_route' => '_configurator_home',);
                }

                // _configurator_step
                if (0 === strpos($pathinfo, '/_configurator/step') && preg_match('#^/_configurator/step/(?P<index>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_configurator_step')), array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::stepAction',));
                }

                // _configurator_final
                if ($pathinfo === '/_configurator/final') {
                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::finalAction',  '_route' => '_configurator_final',);
                }

            }

        }

        if (0 === strpos($pathinfo, '/usuario')) {
            // usuario
            if (rtrim($pathinfo, '/') === '/usuario') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'usuario');
                }

                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\UsuarioController::indexAction',  '_route' => 'usuario',);
            }

            // usuario_web
            if ($pathinfo === '/usuario/usuarioweb') {
                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\UsuarioController::usuariowebAction',  '_route' => 'usuario_web',);
            }

            // usuario_desaprobarusuario
            if (preg_match('#^/usuario/(?P<id>[^/]++)/desaprobarusuario$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'usuario_desaprobarusuario')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\UsuarioController::desaprobarusuarioAction',));
            }

            // usuario_aprobarusuario
            if (preg_match('#^/usuario/(?P<id>[^/]++)/aprobarusuario$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'usuario_aprobarusuario')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\UsuarioController::aprobarusuarioAction',));
            }

            // usuario_show
            if (preg_match('#^/usuario/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'usuario_show')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\UsuarioController::showAction',));
            }

            // usuario_new
            if ($pathinfo === '/usuario/new') {
                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\UsuarioController::newAction',  '_route' => 'usuario_new',);
            }

            // usuario_create
            if ($pathinfo === '/usuario/create') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_usuario_create;
                }

                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\UsuarioController::createAction',  '_route' => 'usuario_create',);
            }
            not_usuario_create:

            // usuario_edit
            if (preg_match('#^/usuario/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'usuario_edit')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\UsuarioController::editAction',));
            }

            // usuario_update
            if (preg_match('#^/usuario/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                    $allow = array_merge($allow, array('POST', 'PUT'));
                    goto not_usuario_update;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'usuario_update')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\UsuarioController::updateAction',));
            }
            not_usuario_update:

            // usuario_delete
            if (preg_match('#^/usuario/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'usuario_delete')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\UsuarioController::deleteAction',));
            }

            // usuario_activar
            if (preg_match('#^/usuario/(?P<id>[^/]++)/activar$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'usuario_activar')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\UsuarioController::activarAction',));
            }

        }

        if (0 === strpos($pathinfo, '/producto')) {
            // producto
            if (rtrim($pathinfo, '/') === '/producto') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'producto');
                }

                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ProductoController::indexAction',  '_route' => 'producto',);
            }

            // producto_ajuste
            if ($pathinfo === '/producto/ajuste') {
                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ProductoController::ajusteAction',  '_route' => 'producto_ajuste',);
            }

            if (0 === strpos($pathinfo, '/producto/predictiva')) {
                // producto_predictiva
                if ($pathinfo === '/producto/predictiva') {
                    return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ProductoController::predictivaAction',  '_route' => 'producto_predictiva',);
                }

                // producto_predictivaconprecio
                if ($pathinfo === '/producto/predictivaconprecio') {
                    return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ProductoController::predictivaconprecioAction',  '_route' => 'producto_predictivaconprecio',);
                }

            }

            // producto_filtroprecios
            if ($pathinfo === '/producto/filtroprecios') {
                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ProductoController::filtropreciosAction',  '_route' => 'producto_filtroprecios',);
            }

            // producto_show
            if (preg_match('#^/producto/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'producto_show')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ProductoController::showAction',));
            }

            // producto_categorias
            if (preg_match('#^/producto/(?P<id>[^/]++)/categorias$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'producto_categorias')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ProductoController::categoriasAction',));
            }

            // producto_web
            if (preg_match('#^/producto/(?P<id>[^/]++)/web$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'producto_web')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ProductoController::webAction',));
            }

            // producto_carritoajax
            if ($pathinfo === '/producto/carritoajax') {
                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ProductoController::carritoajaxAction',  '_route' => 'producto_carritoajax',);
            }

            // producto_quitarajax
            if ($pathinfo === '/producto/quitarajax') {
                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ProductoController::quitarajaxAction',  '_route' => 'producto_quitarajax',);
            }

            // producto_vaciarajax
            if ($pathinfo === '/producto/vaciarajax') {
                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ProductoController::vaciarajaxAction',  '_route' => 'producto_vaciarajax',);
            }

            // producto_filtro
            if ($pathinfo === '/producto/filtro') {
                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ProductoController::filtroAction',  '_route' => 'producto_filtro',);
            }

            // producto_buscarweb
            if ($pathinfo === '/producto/buscarweb') {
                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ProductoController::buscarwebAction',  '_route' => 'producto_buscarweb',);
            }

            // producto_filtroP
            if ($pathinfo === '/producto/filtroP') {
                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ProductoController::filtroPAction',  '_route' => 'producto_filtroP',);
            }

            // producto_new
            if ($pathinfo === '/producto/new') {
                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ProductoController::newAction',  '_route' => 'producto_new',);
            }

            // producto_imprimirCodigo
            if ($pathinfo === '/producto/imprimirCodigo') {
                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ProductoController::imprimirCodigoAction',  '_route' => 'producto_imprimirCodigo',);
            }

            // producto_create
            if ($pathinfo === '/producto/create') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_producto_create;
                }

                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ProductoController::createAction',  '_route' => 'producto_create',);
            }
            not_producto_create:

            // producto_edit
            if (preg_match('#^/producto/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'producto_edit')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ProductoController::editAction',));
            }

            // producto_update
            if (preg_match('#^/producto/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_producto_update;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'producto_update')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ProductoController::updateAction',));
            }
            not_producto_update:

            // producto_stock
            if (preg_match('#^/producto/(?P<id>[^/]++)/stock$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                    $allow = array_merge($allow, array('POST', 'PUT'));
                    goto not_producto_stock;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'producto_stock')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ProductoController::stockAction',));
            }
            not_producto_stock:

            // producto_costo
            if (preg_match('#^/producto/(?P<id>[^/]++)/costo$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'producto_costo')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ProductoController::costoAction',));
            }

            // producto_altaCosto
            if (preg_match('#^/producto/(?P<id>[^/]++)/altaCosto$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'producto_altaCosto')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ProductoController::altaCostoAction',));
            }

            // producto_costoEditar
            if (preg_match('#^/producto/(?P<id>[^/]++)/costoEditar$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'producto_costoEditar')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ProductoController::costoEditarAction',));
            }

            // producto_editarCosto
            if (preg_match('#^/producto/(?P<id>[^/]++)/editarCosto$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'producto_editarCosto')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ProductoController::editarCostoAction',));
            }

            // producto_delete
            if (preg_match('#^/producto/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'DELETE'))) {
                    $allow = array_merge($allow, array('POST', 'DELETE'));
                    goto not_producto_delete;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'producto_delete')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ProductoController::deleteAction',));
            }
            not_producto_delete:

            // producto_informeStock
            if ($pathinfo === '/producto/informeStock') {
                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ProductoController::informeStockAction',  '_route' => 'producto_informeStock',);
            }

            if (0 === strpos($pathinfo, '/productofactura')) {
                // productofactura
                if (rtrim($pathinfo, '/') === '/productofactura') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'productofactura');
                    }

                    return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ProductoFacturaController::indexAction',  '_route' => 'productofactura',);
                }

                // productofactura_show
                if (preg_match('#^/productofactura/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'productofactura_show')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ProductoFacturaController::showAction',));
                }

                // productofactura_new
                if ($pathinfo === '/productofactura/new') {
                    return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ProductoFacturaController::newAction',  '_route' => 'productofactura_new',);
                }

                // productofactura_create
                if ($pathinfo === '/productofactura/create') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_productofactura_create;
                    }

                    return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ProductoFacturaController::createAction',  '_route' => 'productofactura_create',);
                }
                not_productofactura_create:

                // productofactura_edit
                if (preg_match('#^/productofactura/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'productofactura_edit')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ProductoFacturaController::editAction',));
                }

                // productofactura_update
                if (preg_match('#^/productofactura/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                        $allow = array_merge($allow, array('POST', 'PUT'));
                        goto not_productofactura_update;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'productofactura_update')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ProductoFacturaController::updateAction',));
                }
                not_productofactura_update:

                // productofactura_delete
                if (preg_match('#^/productofactura/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('POST', 'DELETE'))) {
                        $allow = array_merge($allow, array('POST', 'DELETE'));
                        goto not_productofactura_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'productofactura_delete')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ProductoFacturaController::deleteAction',));
                }
                not_productofactura_delete:

            }

        }

        if (0 === strpos($pathinfo, '/factura')) {
            // factura
            if (0 === strpos($pathinfo, '/factura/factura') && preg_match('#^/factura/factura(?:/(?P<page>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'factura')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\FacturaController::indexAction',  'page' => 1,));
            }

            if (0 === strpos($pathinfo, '/factura/i')) {
                // factura_irinformeimpuestos
                if ($pathinfo === '/factura/irinformeimpuestos') {
                    return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\FacturaController::irinformeimpuestosAction',  '_route' => 'factura_irinformeimpuestos',);
                }

                // factura_informeimpuestos
                if ($pathinfo === '/factura/informeimpuestos') {
                    return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\FacturaController::informeimpuestosAction',  '_route' => 'factura_informeimpuestos',);
                }

            }

            // notacredito
            if (0 === strpos($pathinfo, '/factura/notacredito') && preg_match('#^/factura/notacredito(?:/(?P<page>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'notacredito')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\FacturaController::notacreditoAction',  'page' => 1,));
            }

            // factura_show
            if (preg_match('#^/factura/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'factura_show')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\FacturaController::showAction',));
            }

            // factura_filtro
            if ($pathinfo === '/factura/filtroInforme') {
                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\FacturaController::filtroInformeAction',  '_route' => 'factura_filtro',);
            }

            // factura_remitofactura
            if (preg_match('#^/factura/(?P<id>[^/]++)/remitofactura$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'factura_remitofactura')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\FacturaController::remitofacturaAction',));
            }

            // factura_crearremitofactura
            if ($pathinfo === '/factura/crearremitofactura') {
                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\FacturaController::crearremitofacturaAction',  '_route' => 'factura_crearremitofactura',);
            }

            // factura_vercliente
            if ($pathinfo === '/factura/vercliente') {
                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\FacturaController::verclienteAction',  '_route' => 'factura_vercliente',);
            }

            // factura_altacliente
            if ($pathinfo === '/factura/altacliente') {
                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\FacturaController::altaclienteAction',  '_route' => 'factura_altacliente',);
            }

            // factura_borraremito
            if (preg_match('#^/factura/(?P<id>[^/]++)/borraremito$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'factura_borraremito')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\FacturaController::borraremitoAction',));
            }

            // factura_facturaremito
            if (preg_match('#^/factura/(?P<id>[^/]++)/facturaremito$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'factura_facturaremito')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\FacturaController::facturaremitoAction',));
            }

            // factura_crearfacturaremito
            if ($pathinfo === '/factura/crearfacturaremito') {
                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\FacturaController::crearfacturaremitoAction',  '_route' => 'factura_crearfacturaremito',);
            }

            // factura_imprimir
            if (preg_match('#^/factura/(?P<id>[^/]++)/imprimir$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'factura_imprimir')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\FacturaController::imprimirAction',));
            }

            if (0 === strpos($pathinfo, '/factura/new')) {
                // factura_new
                if ($pathinfo === '/factura/new') {
                    return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\FacturaController::newAction',  '_route' => 'factura_new',);
                }

                // factura_newcredito
                if ($pathinfo === '/factura/newcredito') {
                    return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\FacturaController::newcreditoAction',  '_route' => 'factura_newcredito',);
                }

            }

            // factura_create
            if ($pathinfo === '/factura/create') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_factura_create;
                }

                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\FacturaController::createAction',  '_route' => 'factura_create',);
            }
            not_factura_create:

            // factura_refacturar
            if (0 === strpos($pathinfo, '/factura/refacturar') && preg_match('#^/factura/refacturar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'factura_refacturar')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\FacturaController::refacturarAction',));
            }

            // factura_createcredito
            if ($pathinfo === '/factura/createcredito') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_factura_createcredito;
                }

                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\FacturaController::createcreditoAction',  '_route' => 'factura_createcredito',);
            }
            not_factura_createcredito:

            // factura_refacturarnota
            if (0 === strpos($pathinfo, '/factura/refacturarnota') && preg_match('#^/factura/refacturarnota/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'factura_refacturarnota')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\FacturaController::refacturarnotaAction',));
            }

            // factura_parcial
            if ($pathinfo === '/factura/parcial') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_factura_parcial;
                }

                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\FacturaController::parcialAction',  '_route' => 'factura_parcial',);
            }
            not_factura_parcial:

            // factura_edit
            if (preg_match('#^/factura/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'factura_edit')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\FacturaController::editAction',));
            }

            // factura_update
            if (preg_match('#^/factura/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                    $allow = array_merge($allow, array('POST', 'PUT'));
                    goto not_factura_update;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'factura_update')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\FacturaController::updateAction',));
            }
            not_factura_update:

            // factura_delete
            if (preg_match('#^/factura/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'DELETE'))) {
                    $allow = array_merge($allow, array('POST', 'DELETE'));
                    goto not_factura_delete;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'factura_delete')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\FacturaController::deleteAction',));
            }
            not_factura_delete:

            // factura_informe
            if ($pathinfo === '/factura/ventasInforme') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_factura_informe;
                }

                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\FacturaController::informeVentasAction',  '_route' => 'factura_informe',);
            }
            not_factura_informe:

        }

        if (0 === strpos($pathinfo, '/cliente')) {
            // cliente
            if (0 === strpos($pathinfo, '/cliente/pagina') && preg_match('#^/cliente/pagina(?:/(?P<page>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'cliente')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ClienteController::indexAction',  'page' => 1,));
            }

            // cliente_show
            if (preg_match('#^/cliente/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'cliente_show')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ClienteController::showAction',));
            }

            // cliente_cc
            if (preg_match('#^/cliente/(?P<id>[^/]++)/cc$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'cliente_cc')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ClienteController::ccAction',));
            }

            // cliente_imprimir
            if (preg_match('#^/cliente/(?P<id>[^/]++)/imprimir$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'cliente_imprimir')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ClienteController::imprimirAction',));
            }

            // cliente_new
            if ($pathinfo === '/cliente/new') {
                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ClienteController::newAction',  '_route' => 'cliente_new',);
            }

            // cliente_filtro
            if ($pathinfo === '/cliente/filtro') {
                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ClienteController::filtroAction',  '_route' => 'cliente_filtro',);
            }

            // cliente_create
            if ($pathinfo === '/cliente/create') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_cliente_create;
                }

                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ClienteController::createAction',  '_route' => 'cliente_create',);
            }
            not_cliente_create:

            // cliente_edit
            if (preg_match('#^/cliente/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'cliente_edit')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ClienteController::editAction',));
            }

            // cliente_update
            if (preg_match('#^/cliente/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                    $allow = array_merge($allow, array('POST', 'PUT'));
                    goto not_cliente_update;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'cliente_update')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ClienteController::updateAction',));
            }
            not_cliente_update:

            // cliente_delete
            if (preg_match('#^/cliente/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'DELETE'))) {
                    $allow = array_merge($allow, array('POST', 'DELETE'));
                    goto not_cliente_delete;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'cliente_delete')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\ClienteController::deleteAction',));
            }
            not_cliente_delete:

        }

        if (0 === strpos($pathinfo, '/puntoventa')) {
            // puntoventa
            if (rtrim($pathinfo, '/') === '/puntoventa') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'puntoventa');
                }

                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\PuntoVentaController::indexAction',  '_route' => 'puntoventa',);
            }

            // puntoventa_show
            if (preg_match('#^/puntoventa/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'puntoventa_show')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\PuntoVentaController::showAction',));
            }

            // puntoventa_new
            if ($pathinfo === '/puntoventa/new') {
                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\PuntoVentaController::newAction',  '_route' => 'puntoventa_new',);
            }

            // puntoventa_create
            if ($pathinfo === '/puntoventa/create') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_puntoventa_create;
                }

                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\PuntoVentaController::createAction',  '_route' => 'puntoventa_create',);
            }
            not_puntoventa_create:

            // puntoventa_edit
            if (preg_match('#^/puntoventa/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'puntoventa_edit')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\PuntoVentaController::editAction',));
            }

            // puntoventa_update
            if (preg_match('#^/puntoventa/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                    $allow = array_merge($allow, array('POST', 'PUT'));
                    goto not_puntoventa_update;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'puntoventa_update')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\PuntoVentaController::updateAction',));
            }
            not_puntoventa_update:

            // puntoventa_delete
            if (preg_match('#^/puntoventa/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'DELETE'))) {
                    $allow = array_merge($allow, array('POST', 'DELETE'));
                    goto not_puntoventa_delete;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'puntoventa_delete')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\PuntoVentaController::deleteAction',));
            }
            not_puntoventa_delete:

        }

        // joyas_joyas_homepage
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'joyas_joyas_homepage');
            }

            return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\DefaultController::indexAction',  '_route' => 'joyas_joyas_homepage',);
        }

        // joyas_joyas_inicio
        if ($pathinfo === '/inicio') {
            return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\DefaultController::inicioAction',  '_route' => 'joyas_joyas_inicio',);
        }

        // joyas_joyas_login
        if ($pathinfo === '/login') {
            return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\DefaultController::loginAction',  '_route' => 'joyas_joyas_login',);
        }

        // joyas_joyas_cerrarSession
        if ($pathinfo === '/cerrarSession') {
            return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\DefaultController::cerrarAction',  '_route' => 'joyas_joyas_cerrarSession',);
        }

        // joyas_joyas_olvideClave
        if ($pathinfo === '/olvideClave') {
            return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\DefaultController::olvideClaveAction',  '_route' => 'joyas_joyas_olvideClave',);
        }

        // joyas_joyas_restClave
        if ($pathinfo === '/restClave') {
            return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\DefaultController::restClaveAction',  '_route' => 'joyas_joyas_restClave',);
        }

        // joyas_joyas_generar
        if ($pathinfo === '/generar') {
            return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\DefaultController::generarAction',  '_route' => 'joyas_joyas_generar',);
        }

        if (0 === strpos($pathinfo, '/condicioniva')) {
            // condicioniva
            if (rtrim($pathinfo, '/') === '/condicioniva') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'condicioniva');
                }

                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\CondicionIvaController::indexAction',  '_route' => 'condicioniva',);
            }

            // condicioniva_show
            if (preg_match('#^/condicioniva/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'condicioniva_show')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\CondicionIvaController::showAction',));
            }

            // condicioniva_new
            if ($pathinfo === '/condicioniva/new') {
                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\CondicionIvaController::newAction',  '_route' => 'condicioniva_new',);
            }

            // condicioniva_create
            if ($pathinfo === '/condicioniva/create') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_condicioniva_create;
                }

                return array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\CondicionIvaController::createAction',  '_route' => 'condicioniva_create',);
            }
            not_condicioniva_create:

            // condicioniva_edit
            if (preg_match('#^/condicioniva/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'condicioniva_edit')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\CondicionIvaController::editAction',));
            }

            // condicioniva_update
            if (preg_match('#^/condicioniva/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                    $allow = array_merge($allow, array('POST', 'PUT'));
                    goto not_condicioniva_update;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'condicioniva_update')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\CondicionIvaController::updateAction',));
            }
            not_condicioniva_update:

            // condicioniva_delete
            if (preg_match('#^/condicioniva/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'DELETE'))) {
                    $allow = array_merge($allow, array('POST', 'DELETE'));
                    goto not_condicioniva_delete;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'condicioniva_delete')), array (  '_controller' => 'JOYAS\\JoyasBundle\\Controller\\CondicionIvaController::deleteAction',));
            }
            not_condicioniva_delete:

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
