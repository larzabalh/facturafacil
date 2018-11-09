<?php

namespace JOYAS\JoyasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ps\PdfBundle\Annotation\Pdf;
use Doctrine\Common\Collections\ArrayCollection;
use JOYAS\JoyasBundle\Afip\Exceptionhandler;
use JOYAS\JoyasBundle\Afip\WSAA;
use JOYAS\JoyasBundle\Afip\WSFEV1;
use JOYAS\JoyasBundle\Entity\Cliente;
use JOYAS\JoyasBundle\Form\ClienteType;
use JOYAS\JoyasBundle\Entity\Factura;
use JOYAS\JoyasBundle\Entity\ProductoFactura;
use JOYAS\JoyasBundle\Entity\Producto;
use JOYAS\JoyasBundle\Form\FacturaType;
use JOYAS\JoyasBundle\Services\SessionManager;
use JMS\DiExtraBundle\Annotation as DI;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Adapter\DoctrineCollectionAdapter;

/**
 * Factura controller.
 *
 */
class FacturaController extends Controller {

    /**
     * @var SessionManager
     * @DI\Inject("session.manager")
     */
    public $sessionSvc;

    /**
     * Lists all Factura entities.
     *
     */
    public function indexAction($page) {
        if (!isset($page)) {
            $page = 1;
        }
        $this->sessionSvc->setSession('fechaDesde', '');
        $this->sessionSvc->setSession('fechaHasta', '');
        $this->sessionSvc->setSession('listado', '');
        $em = $this->getDoctrine()->getManager();
        $this->sessionSvc->setSession('listaprecio', '');
        $entities = $em->getRepository('JOYASJoyasBundle:Factura')->findBy(array('tipodocumento' => 'F', 'usuario'=>$this->sessionSvc->getSession('usuario')->getId()));
        $clientesProveedores = $em->getRepository('JOYASJoyasBundle:Cliente')->findAll();

        $adapter = new ArrayAdapter($entities, false);
        $paginador = new Pagerfanta($adapter);
        $paginador->setMaxPerPage(200);
        $paginador->setCurrentPage($page);

        return $this->render('JOYASJoyasBundle:Factura:index.html.twig', array(
            'entities' => $paginador,
            'clientesProveedores' => $clientesProveedores,
        ));
    }

    public function notacreditoAction($page) {
        if (!isset($page)) {
            $page = 1;
        }
        $this->sessionSvc->setSession('fechaDesde', '');
        $this->sessionSvc->setSession('fechaHasta', '');
        $this->sessionSvc->setSession('listado', '');
        $em = $this->getDoctrine()->getManager();
        $this->sessionSvc->setSession('listaprecio', '');
        $entities = $em->getRepository('JOYASJoyasBundle:Factura')->findBy(array('tipodocumento' => 'C', 'usuario'=>$this->sessionSvc->getSession('usuario')->getId()));
        $clientesProveedores = $em->getRepository('JOYASJoyasBundle:Cliente')->findAll();

        $adapter = new ArrayAdapter($entities, false);
        $paginador = new Pagerfanta($adapter);
        $paginador->setMaxPerPage(200);
        $paginador->setCurrentPage($page);

        return $this->render('JOYASJoyasBundle:Factura:notacredito.html.twig', array(
                    'entities' => $paginador,
                    'clientesProveedores' => $clientesProveedores,
        ));
    }

    public function filtroAction(Request $request, $page) {
        if (!isset($page)) {
            $page = 1;
        }
        $em = $this->getDoctrine()->getManager();

        if ($request->get('fechaDesde') == '' and $request->get('fechaHasta') == '' and $request->get('listado') == '') {
            $desde = new \DateTime($this->sessionSvc->getSession('fechaDesde'));
            $hasta = new \DateTime($this->sessionSvc->getSession('fechaHasta'));
            $listado = $this->sessionSvc->getSession('listado');
        } else {
            if ($request->get('fechaDesde') == '' and $request->get('fechaHasta') == '') {
                $desde = new \DateTime('1/1/2000');
                $hasta = new \DateTime('NOW');
            } else {
                $desde = new \DateTime($request->get('fechaDesde'));
                $hasta = new \DateTime();
            }
            $listado = $request->get('listado');
            $this->sessionSvc->setSession('fechaDesde', $desde->format('Y-m-d'));
            $this->sessionSvc->setSession('fechaHasta', $hasta->format('Y-m-d'));
            $this->sessionSvc->setSession('listado', $request->get('listado'));
        }

        $facturas = $em->getRepository('JOYASJoyasBundle:Factura')->findEntreFechas($desde, $hasta, $listado);
        $clientesProveedores = $em->getRepository('JOYASJoyasBundle:Cliente')->findAll();

        $adapter = new ArrayAdapter($facturas);
        $paginador = new Pagerfanta($adapter);
        $paginador->setMaxPerPage(200);
        $paginador->setCurrentPage($page);

        return $this->render('JOYASJoyasBundle:Factura:index.html.twig', array(
                    'entities' => $paginador,
                    'clientesProveedores' => $clientesProveedores,
        ));
    }

    /**
     * Creates a new Factura entity.
     *
     */
    public function createAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $entity = new Factura();

        $cliente = $em->getRepository('JOYASJoyasBundle:Cliente')->find($request->get('cliente'));
        $usuario = $em->getRepository('JOYASJoyasBundle:Usuario')->find($this->sessionSvc->getSession('usuario')->getId());

        $entity->setUsuario($usuario);
        $tipofactura = $request->get('tipofactura');
        $fechadesde = $request->get('fechadesde');
        $fechahasta = $request->get('fechahasta');
        $concepto = $request->get('concepto');
        $iva = $request->get('iva');
        $ptovta = $request->get('puntoventa');
        $punto = $em->getRepository('JOYASJoyasBundle:PuntoVenta')->find($ptovta);
        $entity->setPunto($punto);

		if($concepto != 1){
			$entity->setFechadesde(new \DateTime($fechadesde));
			$entity->setFechahasta(new \DateTime($fechahasta));
		}else{
			$entity->setFechadesde(null);
			$entity->setFechahasta(null);
		}

        $entity->setTipodocumento('F');
        $entity->setTipofactura($tipofactura);
        $entity->setCliente($cliente);
        $entity->setFecha(new \DateTime($request->get('fecha')));
        $entity->setImporte($request->get('resultadoFinal'));
        $condicionIva = $em->getRepository('JOYASJoyasBundle:CondicionIva')->findOneBy(array('descripcion' => $request->get('condicionivafac')));
        $cliente->setCondicioniva($condicionIva);
        $contador = $request->get('contador');

        $em->persist($entity);
        $em->flush();

        for ($x = 0; $x <= $contador; $x++) {
            $descripcion = $request->get('descripcion' . $x);
            if (!is_null($descripcion) and $descripcion != '') {
                $productoFactura = new ProductoFactura();
                $codigo = $request->get('codigo' . $x);

                $producto = new Producto();
                $producto->setDescripcion($descripcion);
                $producto->setCodigo($codigo);
                $em->persist($producto);

                $productoFactura->setProducto($producto);
                $productoFactura->setFactura($entity);
                $productoFactura->setDescuento($request->get('bonif' . $x));
                $productoFactura->setPrecio($request->get('precio' . $x));
                $productoFactura->setCantidad($request->get('cantidad' . $x));
                $entity->addProductosFactura($productoFactura);
                $em->persist($productoFactura);
                $em->flush();
            }
        }

        if (count($entity->getProductosFactura()) < 1) {
            $em->remove($entity);
            $em->flush();
            $this->sessionSvc->addFlash('msgError', 'La factura debe tener al menos un producto.');
            return $this->redirect($this->generateUrl('factura_new'));
        }

        try{
            $wsaa = new WSAA('./');

            // Si la fecha de expiracion es menor a hoy, obtengo un nuevo Ticket de Acceso.
			$now = new \DateTime('NOW');
            if ($wsaa->get_expiration() and  $wsaa->get_expiration() < $now ) {
                if (!$wsaa->generar_TA()) {
                    $this->sessionSvc->addFlash('msgError', 'Error al obtener el ticket de acceso.');
                    return $this->redirect($this->generateUrl('factura'));
                }
            }


            $wsfe = new WSFEV1('./');

            // Carga el archivo TA.xml
            $wsfe->openTA();

            // devuelve el cae
            if ($tipofactura == 'A') {
                $tipocbte = 01;
            } elseif ($tipofactura == 'C') {
                $tipocbte = 11;
            } else {
                $tipocbte = 06;
            }

            /*
              - 01, 02, 03, 04, 05,34,39,60, 63 para los clase A
              - 06, 07, 08, 09, 10, 35, 40,64, 61 para los clase B.
              - 11, 12, 13, 15 para los clase C.
              - 51, 52, 53, 54 para los clase M.
              - 49 para los Bienes Usados
              Consultar m�todo FEParamGetTiposCbte.
             */

            $nc = '';
            // Ultimo comprobante autorizado, a este le sumo uno para procesar el siguiente.
            $cuitEmisor = $this->sessionSvc->getSession('usuario')->getCuit();
            $cmp = $wsfe->FECompUltimoAutorizado($tipocbte, $punto->getNumero(), $cuitEmisor);

            //Armo array con valores hardcodeados de la factura.
            $regfac['concepto'] = $concepto;
			$regfac['fechadesde'] = !empty($entity->getFechadesde()) ? $entity->getFechadesde()->format('Ymd') : "";
			$regfac['fechahasta'] = !empty($entity->getFechahasta()) ? $entity->getFechahasta()->format('Ymd') : "";
			$regfac['fechaemision'] = $entity->getFecha()->format('Ymd');

			$regfac['numerodocumento'] = $cliente->getDni();

			if ($cliente->getCuit()) {
				$regfac['tipodocumento'] = 80;                  # 80: CUIT, 96: DNI, 99: Consumidor Final
			} else {
				$regfac['tipodocumento'] = 96;                  # 80: CUIT, 96: DNI, 99: Consumidor Final
			}

            $regfac['cuit'] = str_replace("-", "", $cliente->getCuit());
            $regfac['capitalafinanciar'] = 0;           # subtotal de conceptos no gravados
            if ($tipofactura == 'A') {
                $regfac['importetotal'] = round($entity->getImporte(), 2); # total del comprobante
                $regfac['importeiva'] = round(($entity->getImporte() - ($entity->getImporte() / 1.21)), 2);   # subtotal neto sujeto a IVA
                $regfac['importeneto'] = round(($entity->getImporte() / 1.21), 2);
            } else {
                $regfac['importetotal'] = $entity->getImporte(); # total del comprobante
                $regfac['importeneto'] = ($tipofactura=='C') ? $entity->getImporte() : 0;
                $regfac['importeiva'] = 0;   # subtotal neto sujeto a IVA
                $regfac['capitalafinanciar'] = ($tipofactura=='B') ? $entity->getImporte() : 0;
            }

            $regfac['imp_trib'] = 1.0;
            $regfac['imp_op_ex'] = 0.0;
            $regfac['nrofactura'] = $cmp->FECompUltimoAutorizadoResult->CbteNro + 1;
            $regfac['fecha_venc_pago'] = date('Ymd');

            // Armo con la factura los parametros de entrada para el pedido
            $params = $wsfe->armadoFacturaUnica(
                    $tipofactura, $punto->getNumero(), // el punto de venta
                    $nc, $regfac, $cuitEmisor  // los datos a facturar
            );

            //Solicito el CAE
            $cae = $wsfe->solicitarCAE($params, $cuitEmisor);
			if ($cae->FECAESolicitarResult->FeCabResp->Resultado == 'A' or $cae->FECAESolicitarResult->FeCabResp->Resultado == 'P') {
                $em->flush();
                $entity->setNrofactura($regfac['nrofactura']);
                $entity->setCae($cae->FECAESolicitarResult->FeDetResp->FECAEDetResponse->CAE);
                $busco = json_encode($cae->FECAESolicitarResult->FeDetResp->FECAEDetResponse);
                $pos = strpos($busco, 'Observaciones');
                if ($pos > 0) {
                    $entity->setObservacion($cae->FECAESolicitarResult->FeDetResp->FECAEDetResponse->Observaciones->Obs->Msg);
                }
                $entity->setFechavtocae(new \DateTime($cae->FECAESolicitarResult->FeDetResp->FECAEDetResponse->CAEFchVto));
                if (!$entity->getNrofactura()) {
                    $entity->setObservacion($cae);
                }
                $em->flush();

                return $this->redirect($this->generateUrl('factura_show', array('id' => $entity->getId(), 'tipo' => 'F')));
            } else {
                // $em->remove($entity);
                // $em->flush();

                if ($cae->FECAESolicitarResult->FeCabResp->Resultado == 'R') {
                    $this->sessionSvc->addFlash('msgError', 'Error al dar de alta factura: ' . json_encode($cae->FECAESolicitarResult->FeDetResp->FECAEDetResponse->Observaciones));
                }
                return $this->redirect($this->generateUrl('factura'));
            }
        }catch(\Exception $e){
            $this->sessionSvc->addFlash('msgError', 'Error al dar de alta factura: '.$e->getMessage());
        }

        return $this->redirect($this->generateUrl('factura'));
    }

    /**
     * Creates a form to create a Factura entity.
     *
     * @param Factura $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Factura $entity) {
        $form = $this->createForm(new FacturaType(), $entity, array(
            'action' => $this->generateUrl('factura_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Guardar', 'attr' => array('class' => 'btn middle-first', 'onclick' => 'ocultar(this.id)')));

        return $form;
    }

    /**
     * Displays a form to create a new Factura entity.
     *
     */
    public function newAction(Request $request) {
        if (!$this->sessionSvc->isLogged()) {
            return $this->redirect($this->generateUrl('joyas_joyas_homepage'));
        }

        $em = $this->getDoctrine()->getManager();
        $entity = new Factura();
        $puntos = $em->getRepository('JOYASJoyasBundle:PuntoVenta')->findBy(array("usuario"=>$this->sessionSvc->getSession('usuario')->getId()));
        $condiciones = $em->getRepository('JOYASJoyasBundle:CondicionIva')->findAll();
        $condicionIvaEmisor = $em->getRepository('JOYASJoyasBundle:Usuario')->find($this->sessionSvc->getSession('usuario')->getId())->getCondicioniva()->getDescripcion();

        return $this->render('JOYASJoyasBundle:Factura:new.html.twig', array(
            'entity' => $entity,
            'condiciones' => $condiciones,
            'condicionIvaEmisor' => $condicionIvaEmisor,
            'puntos' => $puntos
        ));
    }

    public function newcreditoAction(Request $request) {
        if (!$this->sessionSvc->isLogged()) {
            return $this->redirect($this->generateUrl('joyas_joyas_homepage'));
        }

        $em = $this->getDoctrine()->getManager();
        $entity = new Factura();
        $condiciones = $em->getRepository('JOYASJoyasBundle:CondicionIva')->findAll();
        $puntos = $em->getRepository('JOYASJoyasBundle:PuntoVenta')->findBy(array("usuario"=>$this->sessionSvc->getSession('usuario')->getId()));
        $condicionIvaEmisor = $em->getRepository('JOYASJoyasBundle:Usuario')->find($this->sessionSvc->getSession('usuario')->getId())->getCondicioniva()->getDescripcion();


        return $this->render('JOYASJoyasBundle:Factura:newcredito.html.twig', array(
            'entity' => $entity,
            'condiciones' => $condiciones,
            'condicionIvaEmisor' => $condicionIvaEmisor,
            'puntos' => $puntos
        ));
    }

    public function showAction(Request $request, $id) {
        if (!$this->sessionSvc->isLogged()) {
            return $this->redirect($this->generateUrl('joyas_joyas_homepage'));
        }
        $tipodoc = $request->get('tipo');
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JOYASJoyasBundle:Factura')->find($id);
        if ($tipodoc == 'F') {
            if ($entity->getTipofactura() == 'A') {
                return $this->render('JOYASJoyasBundle:Factura:showA.html.twig', array(
                            'entity' => $entity));
            }
            if ($entity->getTipofactura() == 'B' or $entity->getTipofactura() == 'C') {
                return $this->render('JOYASJoyasBundle:Factura:showB.html.twig', array(
                            'entity' => $entity,
                            'tipofactura' => $entity->getTipofactura(),
                            'nrocomprobante' => ($entity->getTipofactura()=='C') ? '11'  : '06'
                            ));
            }
        } else {
            if ($entity->getTipofactura() == 'A') {
                return $this->render('JOYASJoyasBundle:Factura:creditoA.html.twig', array(
                            'entity' => $entity));
            }
            if ($entity->getTipofactura() == 'B' or $entity->getTipofactura() == 'C') {
                return $this->render('JOYASJoyasBundle:Factura:creditoB.html.twig', array(
                            'entity' => $entity,
                            'tipofactura' => $entity->getTipofactura(),
                            'nrocomprobante' => ($entity->getTipofactura()=='C') ? '13'  : '08'
                            ));
            }
        }
    }

    public function imprimirAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JOYASJoyasBundle:Factura')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Factura entity.');
        }


        return $this->render('JOYASJoyasBundle:Factura:imprimir.html.twig', array(
                    'entity' => $entity
        ));
    }

    /**
     * Displays a form to edit an existing Factura entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JOYASJoyasBundle:Factura')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Factura entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('JOYASJoyasBundle:Factura:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Factura entity.
     *
     * @param Factura $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Factura $entity) {
        $form = $this->createForm(new FacturaType(), $entity, array(
            'action' => $this->generateUrl('factura_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modificar', 'attr' => array('class' => 'btn middle-first')));

        return $form;
    }

    /**
     * Edits an existing Factura entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JOYASJoyasBundle:Factura')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Factura entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('factura_edit', array('id' => $id)));
        }

        return $this->render('JOYASJoyasBundle:Factura:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Factura entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('JOYASJoyasBundle:Factura')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Factura entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('factura'));
    }

    public function borraremitoAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JOYASJoyasBundle:Factura')->find($id);
        $entity->setEstado('B');
        $entity->getMovimientocc()->setEstado('B');

        $em->flush();

        return $this->redirect($this->generateUrl('factura'));
    }

    /**
     * Creates a form to delete a Factura entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('factura_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

    public function verclienteAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $search = $request->get('data');
        $string = '';
        $cliente = $em->getRepository('JOYASJoyasBundle:Cliente')->findOneBy(array('cuit' => $search, "usuario"=>$this->sessionSvc->getSession('usuario')->getId()));
        if (empty($cliente)) {
            $cliente = $em->getRepository('JOYASJoyasBundle:Cliente')->findOneBy(array('dni' => $search, "usuario"=>$this->sessionSvc->getSession('usuario')->getId()));
        }
        if (empty($cliente)) {
            $response = '0///0';
        } else {
            $response = $cliente->getId() . '///' . $cliente->getRazonSocial();
        }
        return new Response($response);
    }

    public function altaclienteAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $condicion = $em->getRepository('JOYASJoyasBundle:CondicionIva')->find(1);
        $tipo = $request->get('data');
        $nrodoc = $request->get('data1');
        $direc = $request->get('data2');
        $razon = $request->get('data3');
        $telefono = $request->get('data4');
        $email = $request->get('data5');

        $respuesta = '0';

        $cliente = new Cliente();
        $cliente->setRazonSocial($razon);
        if ($tipo == 'CUIT') {
            $cliente->setCuit(str_replace('-', '', $nrodoc));
        } else {
            $cliente->setDni($nrodoc);
        }
        $cliente->setCondicioniva($condicion);
        $cliente->setDomiciliocomercial($direc);
        $cliente->setTelefono($telefono);
        $cliente->setMail($email);
        $usuarioSession = $this->sessionSvc->getSession('usuario');

        $usuario = $em->getRepository('JOYASJoyasBundle:Usuario')->find($usuarioSession->getId());

		$cliente->setUsuario($usuario);
        $em->persist($cliente);
        $em->flush();

        $respuesta = $nrodoc;

        return new Response($respuesta);
    }

    public function filtroInformeAction() {
        if ($this->sessionSvc->isLogged()) {
            $em = $this->getDoctrine()->getManager();
            return $this->render('JOYASJoyasBundle:Factura:informeVentas.html.twig');
        } else {
            return $this->redirect($this->generateUrl('joyas_joyas_homepage'));
        }
    }

    public function informeVentasAction(Request $request) {
        if ($this->sessionSvc->isLogged()) {
            $desde = new \DateTime($request->get('fechaDesde'));
            $hasta = new \DateTime($request->get('fechaHasta'));
            $puntoVenta = $request->get('puntoVenta');
            $porcentaje = 0;

            $em = $this->getDoctrine()->getManager();
            // ask the service for a Excel5
            $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

            $phpExcelObject->getProperties()->setCreator("María del Carmen Joyas")
                    ->setLastModifiedBy("María del Carmen Joyas")
                    ->setTitle("Informe de Ventas")
                    ->setSubject("María del Carmen Joyas");
            $phpExcelObject->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Fecha: ' . date('d-m-Y'))
                    ->setCellValue('A2', 'Período')
                    ->setCellValue('B2', 'Desde: ' . $desde->format('d-m-Y'))
                    ->setCellValue('C2', 'Hasta: ' . $hasta->format('d-m-Y'));

            $count = 4;
            $phpExcelObject->getActiveSheet()->setTitle('Informe de Ventas');
            $phpExcelObject->setActiveSheetIndex(0)
                    ->setCellValue('A3', 'Punto de Venta')
                    ->setCellValue('C3', '% del total del período')
                    ->setCellValue('D3', 'Ventas ($)');

            if ($request->get('agrupado') == '1') {
                $phpExcelObject->setActiveSheetIndex(0)->setCellValue('B3', 'Día/Mes');
                $ventas = $em->getRepository('JOYASJoyasBundle:Factura')->findEntreFechasDiario($desde, $hasta, $puntoVenta);
            }
            if ($request->get('agrupado') == '2') {
                $phpExcelObject->setActiveSheetIndex(0)->setCellValue('B3', 'Año/Mes');
                $ventas = $em->getRepository('JOYASJoyasBundle:Factura')->findEntreFechasMensual($desde, $hasta, $puntoVenta);
            }
            $ventasPeriodo = $em->getRepository('JOYASJoyasBundle:Factura')->getTotalVentasPeriodo($desde, $hasta, $puntoVenta);
            foreach ($ventas as $venta) {
                if ($puntoVenta != '') {
                    $phpExcelObject->setActiveSheetIndex(0)->setCellValue('A' . $count, $venta['ptovta']);
                } else {
                    $phpExcelObject->setActiveSheetIndex(0)->setCellValue('A' . $count, 'TODOS');
                }
                $phpExcelObject->setActiveSheetIndex(0)
                        ->setCellValue('B' . $count, $venta['fecha'])
                        ->setCellValue('C' . $count, round($venta['total'] * 100 / $ventasPeriodo, 2))
                        ->setCellValue('D' . $count, $venta['total']);
                $count++;
            }

            $phpExcelObject->setActiveSheetIndex(0)
                    ->setCellValue('A' . $count, 'TOTALES')
                    ->setCellValue('C' . $count, '100%')
                    ->setCellValue('D' . $count, '$ ' . $ventasPeriodo);

            $phpExcelObject->getActiveSheet()->getStyle('A3:D3')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('B2B2B2B2');

            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $phpExcelObject->setActiveSheetIndex(0);
            $phpExcelObject->getActiveSheet()->getStyle('A' . $count . ':d' . $count)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('B2B2B2B2');
            $phpExcelObject->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $phpExcelObject->getActiveSheet()->getColumnDimension('B')->setWidth(30);
            $phpExcelObject->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $phpExcelObject->getActiveSheet()->getColumnDimension('D')->setWidth(25);
            $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
            // create the response
            $response = $this->get('phpexcel')->createStreamedResponse($writer);
            // adding headers
            $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
            $response->headers->set('Content-Disposition', 'attachment;filename=InformeVentas.xls');
            $response->headers->set('Pragma', 'public');
            $response->headers->set('Cache-Control', 'maxage=1');
            return $response;
        } else {
            return $this->redirect($this->generateUrl('joyas_joyas_homepage'));
        }
    }

    public function createcreditoAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $entity = new Factura();

        $cliente = $em->getRepository('JOYASJoyasBundle:Cliente')->find($request->get('cliente'));
        $usuario = $em->getRepository('JOYASJoyasBundle:Usuario')->find($this->sessionSvc->getSession('usuario')->getId());
        $entity->setUsuario($usuario);

        $tipofactura = $request->get('tipofactura');
        $fechadesde = $request->get('fechadesde');
        $fechahasta = $request->get('fechahasta');
        $concepto = $request->get('concepto');
        $iva = $request->get('iva');
        $ptovta = $request->get('puntoventa');
        $punto = $em->getRepository('JOYASJoyasBundle:PuntoVenta')->find($ptovta);
        $entity->setPunto($punto);

		if($concepto != 1){
			$entity->setFechadesde(new \DateTime($fechadesde));
			$entity->setFechahasta(new \DateTime($fechahasta));
		}else{
			$entity->setFechadesde(null);
			$entity->setFechahasta(null);
		}

        $entity->setTipodocumento('C');
        $entity->setTipofactura($tipofactura);
        $entity->setCliente($cliente);
        $entity->setFecha(new \DateTime($request->get('fecha')));
        $entity->setImporte($request->get('resultadoFinal'));
        $condicionIva = $em->getRepository('JOYASJoyasBundle:CondicionIva')->findOneBy(array('descripcion' => $request->get('condicionivafac')));
        $cliente->setCondicioniva($condicionIva);
        $contador = $request->get('contador');

        $em->persist($entity);
        $em->flush();

        for ($x = 0; $x <= $contador; $x++) {
            $descripcion = $request->get('descripcion' . $x);
            if (!is_null($descripcion) and $descripcion != '') {
                $productoFactura = new ProductoFactura();
                $codigo = $request->get('codigo' . $x);

                $producto = new Producto();
                $producto->setDescripcion($descripcion);
                $producto->setCodigo($codigo);
                $em->persist($producto);

                $productoFactura->setProducto($producto);
                $productoFactura->setFactura($entity);
                $productoFactura->setDescuento($request->get('bonif' . $x));
                $productoFactura->setPrecio($request->get('precio' . $x));
                $productoFactura->setCantidad($request->get('cantidad' . $x));
                $entity->addProductosFactura($productoFactura);
                $em->persist($productoFactura);
                $em->flush();
            }
        }

        if (count($entity->getProductosFactura()) < 1) {
            $em->remove($entity);
            $em->flush();
            $this->sessionSvc->addFlash('msgError', 'La factura debe tener al menos un producto.');
            return $this->redirect($this->generateUrl('factura_newcredito'));
        }

        try{

            $wsaa = new WSAA('./');

            // Si la fecha de expiracion es menor a hoy, obtengo un nuevo Ticket de Acceso.
			$now = new \DateTime('NOW');
            if ($wsaa->get_expiration() and  $wsaa->get_expiration() < $now ) {
                if (!$wsaa->generar_TA()) {
                    $this->sessionSvc->addFlash('msgError', 'Error al obtener el ticket de acceso.');
                    return $this->redirect($this->generateUrl('factura'));
                }
            }


            $wsfe = new WSFEV1('./');

            // Carga el archivo TA.xml
            $wsfe->openTA();

            if ($tipofactura == 'A') {
                $tipocbte = 3;
            } elseif ($tipofactura == 'C') {
                $tipocbte = 13;
            } else {
                $tipocbte = 8;
            }

            /*
              - 01, 02, 03, 04, 05,34,39,60, 63 para los clase A
              - 06, 07, 08, 09, 10, 35, 40,64, 61 para los clase B.
              - 11, 12, 13, 15 para los clase C.
              - 51, 52, 53, 54 para los clase M.
              - 49 para los Bienes Usados
              Consultar m�todo FEParamGetTiposCbte.
             */

            $nc = 'SI';

            $cuitEmisor = $this->sessionSvc->getSession('usuario')->getCuit();
            // Ultimo comprobante autorizado, a este le sumo uno para procesar el siguiente.
            $cmp = $wsfe->FECompUltimoAutorizado($tipocbte, $punto->getNumero(), $cuitEmisor);


            //Armo array con valores hardcodeados de la factura.
            $regfac['concepto'] = $concepto;                  # 1: productos, 2: servicios, 3: ambos
			$regfac['fechadesde'] = !empty($entity->getFechadesde()) ? $entity->getFechadesde()->format('Ymd') : "";
			$regfac['fechahasta'] = !empty($entity->getFechahasta()) ? $entity->getFechahasta()->format('Ymd') : "";
			$regfac['fechaemision'] = $entity->getFecha()->format('Ymd');

            if ($request->get('condicionivafac') == 'Consumidor Final') {
                $regfac['tipodocumento'] = 99;                  # 80: CUIT, 96: DNI, 99: Consumidor Final
                if ($entity->getImporte() >= 1000) {
                    $regfac['numerodocumento'] = $cliente->getDni();
                } else {
                    $regfac['numerodocumento'] = 0;                 # 0 para Consumidor Final (<$1000)
                }
            } else {
                $regfac['numerodocumento'] = $cliente->getDni();
                if ($cliente->getCuit()) {
                    $regfac['tipodocumento'] = 80;                  # 80: CUIT, 96: DNI, 99: Consumidor Final
                } else {
                    $regfac['tipodocumento'] = 96;                  # 80: CUIT, 96: DNI, 99: Consumidor Final
                }
            }

            $regfac['cuit'] = str_replace("-", "", $cliente->getCuit());
            $regfac['capitalafinanciar'] = 0;           # subtotal de conceptos no gravados
            if ($tipofactura == 'A') {
                $regfac['importetotal'] = round($entity->getImporte(), 2); # total del comprobante
                $regfac['importeiva'] = round(($entity->getImporte() - ($entity->getImporte() / 1.21)), 2);   # subtotal neto sujeto a IVA
                $regfac['importeneto'] = round(($entity->getImporte() / 1.21), 2);
            } else {
                $regfac['importetotal'] = $entity->getImporte(); # total del comprobante
                $regfac['importeneto'] = ($tipofactura=='C') ? $entity->getImporte() : 0;
                $regfac['importeiva'] = 0;   # subtotal neto sujeto a IVA
                $regfac['capitalafinanciar'] = ($tipofactura=='B') ? $entity->getImporte() : 0;
            }

            $regfac['imp_trib'] = 1.0;
            $regfac['imp_op_ex'] = 0.0;
            $regfac['nrofactura'] = $cmp->FECompUltimoAutorizadoResult->CbteNro + 1;
            $regfac['fecha_venc_pago'] = date('Ymd');

            // Armo con la factura los parametros de entrada para el pedido
            $params = $wsfe->armadoFacturaUnica(
                    $tipofactura, $punto->getNumero(), // el punto de venta
                    $nc, $regfac, $cuitEmisor  // los datos a facturar
            );

            //Solicito el CAE
            $cae = $wsfe->solicitarCAE($params, $cuitEmisor);

            if ($cae->FECAESolicitarResult->FeCabResp->Resultado == 'A' or $cae->FECAESolicitarResult->FeCabResp->Resultado == 'P') {
                $em->flush();
                $entity->setNrofactura($regfac['nrofactura']);
                $entity->setCae($cae->FECAESolicitarResult->FeDetResp->FECAEDetResponse->CAE);
                $busco = json_encode($cae->FECAESolicitarResult->FeDetResp->FECAEDetResponse);
                $pos = strpos($busco, 'Observaciones');
                if ($pos > 0) {
                    $entity->setObservacion($cae->FECAESolicitarResult->FeDetResp->FECAEDetResponse->Observaciones->Obs->Msg);
                }
                $entity->setFechavtocae(new \DateTime($cae->FECAESolicitarResult->FeDetResp->FECAEDetResponse->CAEFchVto));
                if (!$entity->getNrofactura()) {
                    $entity->setObservacion($cae);
                }
                $em->flush();

                return $this->redirect($this->generateUrl('factura_show', array('id' => $entity->getId(), 'tipo' => 'C')));
            } else {
                // $em->remove($entity);
                // $em->flush();

                if ($cae->FECAESolicitarResult->FeCabResp->Resultado == 'R') {
                    $this->sessionSvc->addFlash('msgError', 'Error al dar de alta la nota: ' . json_encode($cae->FECAESolicitarResult->FeDetResp->FECAEDetResponse->Observaciones));
                }
                return $this->redirect($this->generateUrl('notacredito'));
            }
        }catch(\Exception $e){
            $this->sessionSvc->addFlash('msgError', 'Error al dar de alta la Nota de Credito: '.$e->getMessage());
        }

        return $this->redirect($this->generateUrl('notacredito'));
    }

    public function irinformeimpuestosAction(Request $request) {
        return $this->render('JOYASJoyasBundle:Factura:irimpuestos.html.twig');
    }

    public function informeimpuestosAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $tipo = $request->get('tipo');
        $fechaDesde = $request->get('fechaDesde');
        $fechaHasta = $request->get('fechaHasta');

        return $this->citiventas($fechaDesde, $fechaHasta);
    }

    public function citiventas($fechaDesde, $fechaHasta) {
        $em = $this->getDoctrine()->getManager();
        $facturas = $em->getRepository('JOYASJoyasBundle:Factura')->citiventas($fechaDesde, $fechaHasta, $this->sessionSvc->getSession('usuario')->getId());

        $archivo = 'VENTAS-'.date('dmY').'.txt';
        file_put_contents($archivo, "");

        foreach ($facturas as $entity) {

            $tipocmb = '';
            if ($entity->getTipoDocumento() == 'F') {
                if ($entity->getTipofactura() == 'A') {
                    $tipocmb = '001';
                } else {
                    $tipocmb = '006';
                }
            } else {
                if ($entity->getTipoDocumento() == 'C') {
                    if ($entity->getTipofactura() == 'A') {
                        $tipocmb = '003';
                    } else {
                        $tipocmb = '008';
                    }
                }
            }
            if ($tipocmb == '001') {
                $fecha = $entity->getFecha()->format('d/m/Y');
                $nrofactura = $entity->getNrofactura();
                $importe = $entity->getImporte();
                $importeneto = round(($entity->getImporte() * 100 / 121), 2);
                $iva = 21;
                $importeiva = round($entity->getImporte() - ($entity->getImporte() * 100 / 121), 2);
            } else {
                $fecha = $entity->getFecha()->format('d/m/Y');
                $nrofactura = $entity->getNrofactura();
                $importe = $entity->getImporte();
                $importeneto = round(($entity->getImporte() * 100 / 121), 2);
                $iva = 21;
                $importeiva = round($entity->getImporte() - ($entity->getImporte() * 100 / 121), 2);
            }
            if ($entity->getCliente()->getCuit()) {
                $tipodoc = 80;
                $documento = str_replace('-', '', $entity->getCliente()->getCuit());
            } else {
                $tipodoc = 96;
                $documento = str_replace(' ', '', $entity->getCliente()->getDni());
            }
            $punto = $entity->getPunto()->getNumero();
            $clienteNombre = $entity->getCliente()->getRazonSocial();
            // ->setCellValue('AA' . $count, '////TEXTO(B' . $count . ';"AAAAmmdd")&TEXTO(C' . $count . ';"###000")&TEXTO(D' . $count . ';"#####00000")&TEXTO(E' . $count . ';"####################00000000000000000000")&TEXTO(F' . $count . ';"####################00000000000000000000")&TEXTO(G' . $count . ';"##00")&TEXTO(H' . $count . ';"####################00000000000000000000")&I' . $count . '&REPETIR(" ";30-LARGO(I' . $count . '))&TEXTO(J' . $count . '*100;"###############000000000000000")&TEXTO(K' . $count . '*100;"###############000000000000000")&TEXTO(L' . $count . '*100;"###############000000000000000")&TEXTO(M' . $count . '*100;"###############000000000000000")&TEXTO(N' . $count . '*100;"###############000000000000000")&TEXTO(O' . $count . '*100;"###############000000000000000")&TEXTO(P' . $count . '*100;"###############000000000000000")&TEXTO(Q' . $count . '*100;"###############000000000000000")&TEXTO(R' . $count . ';"###000")&TEXTO(S' . $count . '*1000000;"##########0000000000")&TEXTO(T' . $count . ';"#0")&TEXTO(U' . $count . ';"#0")&TEXTO(V' . $count . ';"###############000000000000000")&TEXTO(W' . $count . ';"AAAAmmdd")')
            // ->setCellValue('AB' . $count, '////TEXTO(C' . $count . ';"###000")&TEXTO(D' . $count . ';"#####00000")&TEXTO(E' . $count . ';"####################00000000000000000000")&TEXTO(X' . $count . '*100;"###############000000000000000")&SI(Y' . $count . '=21;"0005";SI(Y' . $count . '=27;"0006";SI(Y' . $count . '=0;"0003";SI(Y' . $count . '=5;"0008";SI(Y' . $count . '=2,5;"0009";SI(Y' . $count . '=10,5;"0004";SI(Y' . $count . '="Exento";"0002";SI(Y' . $count . '="No Gravado";"0001"))))))))&TEXTO(Z' . $count . '*100;"###############000000000000000")')
            // $linea = "$fecha$tipocomprobante$ptoventa$numero$despachoimportacion$codigo$documento$razonsocial$importetotal$importetotalconceptos$importeoperacionesexentas$importepercepcioniva$importepercepcionimpuestosnacionales$importepercepcioniibb$importepercepcionimpuestosmunicipales$importeimpuestosinternos$moneda$tipocambio$cantidadalicuotasiva$codigooperacion$creditofiscalcomputable$otrostributos$cuitemisor$denominaciondelemisor$ivacomision\n";
            $linea = "$tipocmb$fecha\n";
            file_put_contents($archivo, $linea, FILE_APPEND);
        }

        return new Response($archivo);
    }

    public function refacturarAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JOYASJoyasBundle:Factura')->find($id);
        $tipofactura = $entity->getTipofactura();
        $ptovta = $entity->getPunto()->getNumero();

        try{
            $wsaa = new WSAA('./');

            // Si la fecha de expiracion es menor a hoy, obtengo un nuevo Ticket de Acceso.
			$now = new \DateTime('NOW');
            if ($wsaa->get_expiration() and  $wsaa->get_expiration() < $now ) {
                if (!$wsaa->generar_TA()) {
                    $this->sessionSvc->addFlash('msgError', 'Error al obtener el ticket de acceso.');
                    return $this->redirect($this->generateUrl('factura'));
                }
            }
			echo $wsaa->get_expiration()->format('Y-m-d');
            $wsfe = new WSFEV1('./');

            // Carga el archivo TA.xml
            $wsfe->openTA();

            if ($tipofactura == 'A') {
                $tipocbte = 01;
            } elseif ($tipofactura == 'C') {
                $tipocbte = 11;
            } else {
                $tipocbte = 06;
            }

            $cuitEmisor = $this->sessionSvc->getSession('usuario')->getCuit();
            $nc = '';
            $cmp = $wsfe->FECompUltimoAutorizado($tipocbte, $ptovta, $cuitEmisor);


            $regfac['concepto'] = !empty($entity->getFechadesde()) ? 2 : 1;                  # 1: productos, 2: servicios, 3: ambos
			$regfac['fechadesde'] = !empty($entity->getFechadesde()) ? $entity->getFechadesde()->format('Ymd') : "";
			$regfac['fechahasta'] = !empty($entity->getFechahasta()) ? $entity->getFechahasta()->format('Ymd') : "";
			$regfac['fechaemision'] = $entity->getFecha()->format('Ymd');

            if ($entity->getCliente()->getCondicioniva() == 'Consumidor Final') {
                $regfac['tipodocumento'] = 99;                  # 80: CUIT, 96: DNI, 99: Consumidor Final
                if ($entity->getImporte() >= 1000) {
                    $regfac['numerodocumento'] = $entity->getCliente()->getDni();
                } else {
                    $regfac['numerodocumento'] = 0;                 # 0 para Consumidor Final (<$1000)
                }
            } else {
                $regfac['numerodocumento'] = $entity->getCliente()->getDni();
                if ($entity->getCliente()->getCuit()) {
                    $regfac['tipodocumento'] = 80;                  # 80: CUIT, 96: DNI, 99: Consumidor Final
                } else {
                    $regfac['tipodocumento'] = 96;                  # 80: CUIT, 96: DNI, 99: Consumidor Final
                }
            }

            $regfac['cuit'] = str_replace("-", "", $entity->getCliente()->getCuit());
            $regfac['capitalafinanciar'] = 0;           # subtotal de conceptos no gravados
            if ($tipofactura == 'A') {
                $regfac['importetotal'] = round($entity->getImporte(), 2); # total del comprobante
                $regfac['importeiva'] = round(($entity->getImporte() - ($entity->getImporte() / 1.21)), 2);   # subtotal neto sujeto a IVA
                $regfac['importeneto'] = round(($entity->getImporte() / 1.21), 2);
            } else {
                $regfac['importetotal'] = $entity->getImporte(); # total del comprobante
                $regfac['importeneto'] = ($tipofactura=='C') ? $entity->getImporte() : 0;
                $regfac['importeiva'] = 0;   # subtotal neto sujeto a IVA
                $regfac['capitalafinanciar'] = ($tipofactura=='B') ? $entity->getImporte() : 0;
            }

            $regfac['imp_trib'] = 1.0;
            $regfac['imp_op_ex'] = 0.0;
            $regfac['nrofactura'] = $cmp->FECompUltimoAutorizadoResult->CbteNro + 1;
            $regfac['fecha_venc_pago'] = date('Ymd');

            // Armo con la factura los parametros de entrada para el pedido
            $params = $wsfe->armadoFacturaUnica(
                    $tipofactura, $ptovta, // el punto de venta
                    $nc, $regfac, $cuitEmisor  // los datos a facturar
            );

            //Solicito el CAE
            $cae = $wsfe->solicitarCAE($params, $cuitEmisor);
			if ($cae->FECAESolicitarResult->FeCabResp->Resultado == 'A' or $cae->FECAESolicitarResult->FeCabResp->Resultado == 'P') {
                $entity->setNrofactura($regfac['nrofactura']);
                $entity->setCae($cae->FECAESolicitarResult->FeDetResp->FECAEDetResponse->CAE);
                $busco = json_encode($cae->FECAESolicitarResult->FeDetResp->FECAEDetResponse);
                $pos = strpos($busco, 'Observaciones');
                if ($pos > 0) {
                    $entity->setObservacion($cae->FECAESolicitarResult->FeDetResp->FECAEDetResponse->Observaciones->Obs->Msg);
                }
                $entity->setFechavtocae(new \DateTime($cae->FECAESolicitarResult->FeDetResp->FECAEDetResponse->CAEFchVto));
                if (!$entity->getNrofactura()) {
                    $entity->setObservacion($cae);
                }
                $em->flush();

                return $this->redirect($this->generateUrl('factura_show', array('id' => $entity->getId(), 'tipo' => 'F')));
            } else {
                if ($cae->FECAESolicitarResult->FeCabResp->Resultado == 'R') {
                    $this->sessionSvc->addFlash('msgError', 'Error al dar de alta factura: ' . json_encode($cae->FECAESolicitarResult->FeDetResp->FECAEDetResponse->Observaciones));
                }
                return $this->redirect($this->generateUrl('factura'));
            }
        }catch(\Exception $e){
            $this->sessionSvc->addFlash('msgError', 'Error al dar de alta factura: '.$e->getMessage());
        }

        return $this->redirect($this->generateUrl('factura'));
    }

    public function refacturarnotaAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JOYASJoyasBundle:Factura')->find($id);
        $tipofactura = $entity->getTipofactura();
        $ptovta = $entity->getPunto()->getNumero();

        try{

            $wsaa = new WSAA('./');

            // Si la fecha de expiracion es menor a hoy, obtengo un nuevo Ticket de Acceso.
			$now = new \DateTime('NOW');
            if ($wsaa->get_expiration() and  $wsaa->get_expiration() < $now ) {
                if (!$wsaa->generar_TA()) {
                    $this->sessionSvc->addFlash('msgError', 'Error al obtener el ticket de acceso.');
                    return $this->redirect($this->generateUrl('factura'));
                }
            }


            $wsfe = new WSFEV1('./');

            // Carga el archivo TA.xml
            $wsfe->openTA();

            if ($tipofactura == 'A') {
                $tipocbte = 3;
            } elseif ($tipofactura == 'C') {
                $tipocbte = 13;
            } else {
                $tipocbte = 8;
            }

            $nc = 'SI';

            $cuitEmisor = $this->sessionSvc->getSession('usuario')->getCuit();
            // Ultimo comprobante autorizado, a este le sumo uno para procesar el siguiente.
            $cmp = $wsfe->FECompUltimoAutorizado($tipocbte, $ptovta, $cuitEmisor);


            //Armo array con valores hardcodeados de la factura.
            $regfac['concepto'] = !empty($entity->getFechadesde()) ? 2 : 1; # 1: productos, 2: servicios, 3: ambos
			$regfac['fechadesde'] = !empty($entity->getFechadesde()) ? $entity->getFechadesde()->format('Ymd') : "";
			$regfac['fechahasta'] = !empty($entity->getFechahasta()) ? $entity->getFechahasta()->format('Ymd') : "";
			$regfac['fechaemision'] = $entity->getFecha()->format('Ymd');

            if ($entity->getCliente()->getCondicioniva() == 'Consumidor Final') {
                $regfac['tipodocumento'] = 99;                  # 80: CUIT, 96: DNI, 99: Consumidor Final
                if ($entity->getImporte() >= 1000) {
                    $regfac['numerodocumento'] = $entity->getCliente()->getDni();
                } else {
                    $regfac['numerodocumento'] = 0;                 # 0 para Consumidor Final (<$1000)
                }
            } else {
                $regfac['numerodocumento'] = $entity->getCliente()->getDni();
                if ($entity->getCliente()->getCuit()) {
                    $regfac['tipodocumento'] = 80;                  # 80: CUIT, 96: DNI, 99: Consumidor Final
                } else {
                    $regfac['tipodocumento'] = 96;                  # 80: CUIT, 96: DNI, 99: Consumidor Final
                }
            }

            $regfac['cuit'] = str_replace("-", "", $entity->getCliente()->getCuit());
            $regfac['capitalafinanciar'] = 0;           # subtotal de conceptos no gravados
            if ($tipofactura == 'A') {
                $regfac['importetotal'] = round($entity->getImporte(), 2); # total del comprobante
                $regfac['importeiva'] = round(($entity->getImporte() - ($entity->getImporte() / 1.21)), 2);   # subtotal neto sujeto a IVA
                $regfac['importeneto'] = round(($entity->getImporte() / 1.21), 2);
            } else {
                $regfac['importetotal'] = $entity->getImporte(); # total del comprobante
                $regfac['importeneto'] = ($tipofactura=='C') ? $entity->getImporte() : 0;
                $regfac['importeiva'] = 0;   # subtotal neto sujeto a IVA
                $regfac['capitalafinanciar'] = ($tipofactura=='B') ? $entity->getImporte() : 0;
            }

            $regfac['imp_trib'] = 1.0;
            $regfac['imp_op_ex'] = 0.0;
            $regfac['nrofactura'] = $cmp->FECompUltimoAutorizadoResult->CbteNro + 1;
            $regfac['fecha_venc_pago'] = date('Ymd');

            // Armo con la factura los parametros de entrada para el pedido
            $params = $wsfe->armadoFacturaUnica(
                    $tipofactura, $ptovta, // el punto de venta
                    $nc, $regfac, $cuitEmisor  // los datos a facturar
            );

            //Solicito el CAE
            $cae = $wsfe->solicitarCAE($params, $cuitEmisor);

            if ($cae->FECAESolicitarResult->FeCabResp->Resultado == 'A' or $cae->FECAESolicitarResult->FeCabResp->Resultado == 'P') {
                $entity->setNrofactura($regfac['nrofactura']);
                $entity->setCae($cae->FECAESolicitarResult->FeDetResp->FECAEDetResponse->CAE);
                $busco = json_encode($cae->FECAESolicitarResult->FeDetResp->FECAEDetResponse);
                $pos = strpos($busco, 'Observaciones');
                if ($pos > 0) {
                    $entity->setObservacion($cae->FECAESolicitarResult->FeDetResp->FECAEDetResponse->Observaciones->Obs->Msg);
                }
                $entity->setFechavtocae(new \DateTime($cae->FECAESolicitarResult->FeDetResp->FECAEDetResponse->CAEFchVto));
                if (!$entity->getNrofactura()) {
                    $entity->setObservacion($cae);
                }
                $em->flush();

                return $this->redirect($this->generateUrl('factura_show', array('id' => $entity->getId(), 'tipo' => 'C')));
            } else {
                // $em->remove($entity);
                // $em->flush();

                if ($cae->FECAESolicitarResult->FeCabResp->Resultado == 'R') {
                    $this->sessionSvc->addFlash('msgError', 'Error al dar de alta la nota: ' . json_encode($cae->FECAESolicitarResult->FeDetResp->FECAEDetResponse->Observaciones));
                }
                return $this->redirect($this->generateUrl('notacredito'));
            }
        }catch(\Exception $e){
            $this->sessionSvc->addFlash('msgError', 'Error al dar de alta la Nota de Credito: '.$e->getMessage());
        }

        return $this->redirect($this->generateUrl('notacredito'));
    }
}

?>
