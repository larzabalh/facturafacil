<?php

namespace JOYAS\JoyasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use JOYAS\JoyasBundle\Entity\Cliente;
use JOYAS\JoyasBundle\Form\ClienteType;
use JOYAS\JoyasBundle\Services\SessionManager;
use JMS\DiExtraBundle\Annotation as DI;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;

/**
 * Cliente controller.
 *
 */
class ClienteController extends Controller
{

	/**
	 * @var SessionManager
	 * @DI\Inject("session.manager")
	 */
	public $sessionSvc;

    /**
     * Lists all Cliente entities.
     *
     */
    public function indexAction($page)
    {
		if(!$this->sessionSvc->isLogged()){
            return $this->redirect($this->generateUrl('joyas_joyas_homepage'));
		}

        if(!isset($page)){
            $page = 1;
        }

        $em = $this->getDoctrine()->getManager();
		$usuarioSession = $this->sessionSvc->getSession('usuario');
		$entities = $em->getRepository('JOYASJoyasBundle:Cliente')->findBy(array('usuario'=>$usuarioSession->getId()));

        $adapter = new ArrayAdapter($entities);
        $paginador = new Pagerfanta($adapter);
		$paginador->setMaxPerPage(600);
		$paginador->setCurrentPage($page);

        return $this->render('JOYASJoyasBundle:Cliente:index.html.twig', array(
            'entities' => $paginador,
        ));
    }

    /**
     * Creates a new Cliente entity.
     * 23-37853378-3
     */
    public function createAction(Request $request)
    {
        $entity = new Cliente();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
		$usuario = $em->getRepository('JOYASJoyasBundle:Usuario')->find($this->sessionSvc->getSession('usuario')->getId());
		$entity->setUsuario($usuario);

		if ($form->isValid()){
			$entity->setCuit(str_replace('-', '', $entity->getCuit()));
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('cliente'));
        }

        return $this->render('JOYASJoyasBundle:Cliente:edit.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Cliente entity.
    *
    * @param Cliente $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Cliente $entity)
    {
        $form = $this->createForm(new ClienteType(), $entity, array(
            'action' => $this->generateUrl('cliente_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Guardar', 'attr'=> array('class'=>'btn middle-first', 'onclick'=>'ocultar(this.id)')));

        return $form;
    }

    /**
     * Displays a form to create a new Cliente entity.
     *
     */
    public function newAction()
    {
        $entity = new Cliente();
        $form   = $this->createCreateForm($entity);

        $em = $this->getDoctrine()->getManager();

		return $this->render('JOYASJoyasBundle:Cliente:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Cliente entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JOYASJoyasBundle:Cliente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cliente entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('JOYASJoyasBundle:Cliente:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    public function ccAction($id)
    {
		if($this->sessionSvc->isLogged()){
			$em = $this->getDoctrine()->getManager();
			$entity = $em->getRepository('JOYASJoyasBundle:Cliente')->find($id);
			$movimientos = $em->getRepository('JOYASJoyasBundle:MovimientoCC')->getMovimientos($id);
            if (!$entity) {
				throw $this->createNotFoundException('Unable to find Cliente entity.');
			}

			return $this->render('JOYASJoyasBundle:Cliente:cuentacorriente.html.twig', array(
				'entity' => $entity,
				'movimientos' => $movimientos,
			));
	    }else{
			return $this->redirect($this->generateUrl('joyas_joyas_homepage'));
		}
    }

    public function imprimirAction($id)
    {
			$em = $this->getDoctrine()->getManager();

	        $clienteProveedor = $em->getRepository('JOYASJoyasBundle:Cliente')->find($id);

			$phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

			$phpExcelObject->getProperties()->setCreator("Willy Jhons")
			   ->setLastModifiedBy("Willy Jhons")
			   ->setTitle("Informe")
			   ->setSubject("Willy Jhons");

			$phpExcelObject->setActiveSheetIndex(0)
			   ->setCellValue('A1', 'Cuenta Corriente: "'.$clienteProveedor->getRazonSocial().'"')
			   ->setCellValue('D1', 'Pesos ($)')
			   ->setCellValue('G1', 'Dolar(u$s)');

			$phpExcelObject->setActiveSheetIndex(0)
			   ->setCellValue('A2', 'Fecha')
			   ->setCellValue('B2', 'Movimiento')
			   ->setCellValue('C2', 'Debe')
			   ->setCellValue('D2', 'Haber')
			   ->setCellValue('E2', 'Saldo')
			   ->setCellValue('F2', 'Debe')
			   ->setCellValue('G2', 'Haber')
			   ->setCellValue('H2', 'Saldo');

			$count = 3;
			$suma = 0;

			$pesosD = 0;
			$pesosH = 0;
			$dolaresD = 0;
			$dolaresH = 0;
			$tipo = '';

			if ($clienteProveedor->getSaldo() != '' and $clienteProveedor->getSaldo() > 0){
				 $tipo = 'SALDO INICIAL';
			     if ($clienteProveedor->getMoneda() == '1'){
                	$pesosD = $pesosD + $clienteProveedor->getSaldo();
					$phpExcelObject->setActiveSheetIndex(0)
					   ->setCellValue('B'.$count,$tipo)
					   ->setCellValue('C'.$count,'$ '.$clienteProveedor->getSaldo())
					   ->setCellValue('E'.$count,'$ '.round($pesosD, 2));
    			}else{
                	$dolaresD = $dolaresD + $clienteProveedor->getSaldo();
					$phpExcelObject->setActiveSheetIndex(0)
					   ->setCellValue('B'.$count,$tipo)
					   ->setCellValue('F'.$count,'u$s '.$clienteProveedor->getSaldo())
					   ->setCellValue('H'.$count,'u$s '.round($dolaresD, 2));
                }
				$count++;
 			}else{
                $tipo = 'SALDO INICIAL';
       			if ($clienteProveedor->getSaldo() != '' and $clienteProveedor->getSaldo() < 0){
        			if ($clienteProveedor->getMoneda == '1'){
                    	$pesosH = $pesosH + ($clienteProveedor->getSaldo()*(-1));
    					$phpExcelObject->setActiveSheetIndex(0)
    					   ->setCellValue('B'.$count,$tipo)
    					   ->setCellValue('D'.$count,'$ '.$clienteProveedor->getSaldo()*(-1))
    					   ->setCellValue('E'.$count,'$ '.round($pesosD, 2));
        			}else{
                    	$dolaresH = $dolaresH + ($clienteProveedor->getSaldo()*(-1));
    					$phpExcelObject->setActiveSheetIndex(0)
    					   ->setCellValue('B'.$count,$tipo)
    					   ->setCellValue('G'.$count,'u$s '.$clienteProveedor->getSaldo()*(-1))
    					   ->setCellValue('H'.$count,'u$s '.round($dolaresH, 2));
        			}
    				$count++;
    			}
			}
			foreach ($clienteProveedor->getMovimientoscc() as $entity){
				if ($entity->getTipoDocumento() == 'C'){
					$tipo = 'NOTA DE CREDITO '.$entity->getId();
				}
				if ($entity->getTipoDocumento() == 'D'){
					$tipo = 'NOTA DE DEBITO '.$entity->getId();
				}
				if ($entity->getTipoDocumento() == 'FC' or $entity->getTipoDocumento() == 'F'){
					$tipo = 'FACTURA '.$entity->getId();
				}
				if ($entity->getTipoDocumento() == 'R'){
					$tipo = 'RECIBO CLIENTE '.$entity->getId();
				}
				if ($entity->getTipoDocumento() == 'RP'){
					$tipo = 'RECIBO PROV '. $entity->getId();
				}

				if ($entity->getTipoDocumento() == 'FC'){
					$phpExcelObject->setActiveSheetIndex(0)
					   ->setCellValue('A'.$count,$entity->getFactura()->getFecha()->format('d-m-Y'))
					   ->setCellValue('B'.$count, $tipo);
				}else{
					$phpExcelObject->setActiveSheetIndex(0)
					   ->setCellValue('A'.$count,$entity->getDocumento()->getFecha()->format('d-m-Y'))
					   ->setCellValue('B'.$count, $tipo);
				}

				if ($entity->getEstado() == 'A' and $entity->getCliente()->getCliente() == '2'){
					if ($entity->getTipoDocumento() == 'RP' or $entity->getTipoDocumento() == 'C'){
						if($entity->getMonedaStr() == 'ARG'){
							$pesosD = $entity->getDocumento()->getImporte() + $pesosD;
							$operacion = $pesosD - $pesosH;
							$phpExcelObject->setActiveSheetIndex(0)
							   ->setCellValue('C'.$count,'$ '.$entity->getDocumento()->getImporte())
							   ->setCellValue('E'.$count,'$ '.round($operacion, 2));
						}else{
							$dolaresD = $entity->getDocumento()->getImporte() + $dolaresD;
							$operacion = $dolaresD - $dolaresH;
							$phpExcelObject->setActiveSheetIndex(0)
							   ->setCellValue('F'.$count,'U$S '.$entity->getDocumento()->getImporte())
							   ->setCellValue('H'.$count,'U$S '.round($operacion, 2));
						}
					}
					if ($entity->getTipoDocumento() == 'F' or $entity->getTipoDocumento() == 'D'){
						if ($entity->getMonedaStr() == 'ARG'){
							$pesosH = $entity->getDocumento()->getImporte() + $pesosH;
							$operacion = $pesosD - $pesosH;
							$phpExcelObject->setActiveSheetIndex(0)
							   ->setCellValue('D'.$count,'$ '.$entity->getDocumento()->getImporte())
							   ->setCellValue('E'.$count,'$ '.round($operacion, 2));
						}else{
							$dolaresH = $entity->getDocumento()->getImporte() + $dolaresH;
							$operacion = $dolaresD - $dolaresH;
							$phpExcelObject->setActiveSheetIndex(0)
							   ->setCellValue('G'.$count,'U$S '.$entity->getDocumento()->getImporte())
							   ->setCellValue('H'.$count,'U$S '.round($operacion, 2));
						}
					}
				}else{
					if ($entity->getEstado() == 'A' and $entity->getCliente()->getCliente() == '1'){
						if ($entity->getTipoDocumento() == 'D' or $entity->getTipoDocumento() == 'FC'){
							$this->sessionSvc->setSession('segundoIF cliente', 'SI');
							if ($entity->getMonedaStr() == 'ARG'){
								if ($entity->getTipoDocumento() == 'D'){
									$pesosD = $entity->getDocumento()->getImporte() + $pesosD;
									$operacion = $pesosD - $pesosH;
									$phpExcelObject->setActiveSheetIndex(0)
									   ->setCellValue('C'.$count,'$ '.$entity->getDocumento()->getImporte())
									   ->setCellValue('E'.$count,'$ '.round($operacion, 2));
								}else{
									$importeFC = $entity->getFactura()->getImporte();

									$pesosD = $importeFC + $pesosD;
									$operacion = $pesosD - $pesosH;
									$this->sessionSvc->setSession('importefactura'.$entity->getId() , $importeFC);
									$phpExcelObject->setActiveSheetIndex(0)
									   ->setCellValue('C'.$count,'$ '.round($importeFC, 2))
									   ->setCellValue('E'.$count,'$ '.round($operacion, 2));
								}
							}else{
								if ($entity->getTipoDocumento() == 'D'){
									$dolaresD = $entity->getDocumento()->getImporte() + $dolaresD;
									$operacion = $dolaresD - $dolaresH;
									$phpExcelObject->setActiveSheetIndex(0)
									   ->setCellValue('F'.$count,'U$S '.$entity->getDocumento()->getImporte())
									   ->setCellValue('H'.$count,'U$S '.round($operacion, 2));
								}else{
									$importeFC = 0;
									foreach ($entity->getFactura()->getProductosFactura() as $prodFact ){
										$importeFC = ($prodFact->getPrecio() * $prodFact->getCantidad()) + $importeFC;
									}

									if ($entity->getFactura()->getDescuento() != ''){
										$desc = '0.'.(100 - $entity->getFactura()->getDescuento());
										$importeFC = $importeFC * $desc;
									}

									if ($entity->getFactura()->getBonificacion() != ''){
										$importeFC = $importeFC - $entity->getFactura()->getBonificacion();
									}

									$dolaresD = $importeFC + $dolaresD;
									$operacion = $dolaresD - $dolaresH;
									$phpExcelObject->setActiveSheetIndex(0)
									   ->setCellValue('F'.$count,'U$S '.round($importeFC, 2))
									   ->setCellValue('H'.$count,'U$S '.round($operacion, 2));
								}
							}
						}
						if ($entity->getTipoDocumento() == 'R' or $entity->getTipoDocumento() == 'C'){
							if ($entity->getMonedaStr() == 'ARG'){
								$pesosH = $entity->getDocumento()->getImporte() + $pesosH;
								$operacion = $pesosD - $pesosH;
								$phpExcelObject->setActiveSheetIndex(0)
								   ->setCellValue('D'.$count,'$ '.$entity->getDocumento()->getImporte())
								   ->setCellValue('E'.$count,'$ '.round($operacion, 2));
							}else{
								$dolaresH = $entity->getDocumento()->getImporte() + $dolaresH;
								$operacion = $dolaresD - $dolaresH;
								$phpExcelObject->setActiveSheetIndex(0)
								   ->setCellValue('G'.$count,'U$S '.$entity->getDocumento()->getImporte())
								   ->setCellValue('H'.$count,'U$S '.round($operacion, 2));
							}
						}
					}
				}
				$count++;
			}


			$sumaPesos = $pesosD - $pesosH;
			$sumaDolares = $dolaresD - $dolaresH;

			$phpExcelObject->setActiveSheetIndex(0)
			   ->setCellValue('D'.$count, 'SALDO CAJA $ '.round($sumaPesos, 2))
			   ->setCellValue('G'.$count, 'SALDO CAJA U$S '.round($sumaDolares, 2));

			$phpExcelObject->getActiveSheet()->getStyle('A2:H2')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('B2B2B2B2');

			$phpExcelObject->getActiveSheet()->setTitle('Cuentas por Cobrar');
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$phpExcelObject->setActiveSheetIndex(0);
			$phpExcelObject->getActiveSheet()->getStyle('D'.$count)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('B2B2B2B2');
			$phpExcelObject->getActiveSheet()->getStyle('G'.$count)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('B2B2B2B2');
			$phpExcelObject->getActiveSheet()->getColumnDimension('A')->setWidth(30);
			$phpExcelObject->getActiveSheet()->getColumnDimension('B')->setWidth(20);
			$phpExcelObject->getActiveSheet()->getColumnDimension('C')->setWidth(25);
			$phpExcelObject->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$phpExcelObject->getActiveSheet()->getColumnDimension('E')->setWidth(25);
			$phpExcelObject->getActiveSheet()->getColumnDimension('F')->setWidth(25);
			$phpExcelObject->getActiveSheet()->getColumnDimension('H')->setWidth(25);
			$phpExcelObject->getActiveSheet()->getColumnDimension('G')->setWidth(25);
			$writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
			// create the response
			$response = $this->get('phpexcel')->createStreamedResponse($writer);
			// adding headers
			$response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
			$response->headers->set('Content-Disposition', 'attachment;filename=CuentaCorriente-'.$clienteProveedor->getRazonSocial().'.xls');
			$response->headers->set('Pragma', 'public');
			$response->headers->set('Cache-Control', 'maxage=1');

			return $response;
    }

    /**
     * Displays a form to edit an existing Cliente entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JOYASJoyasBundle:Cliente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cliente entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('JOYASJoyasBundle:Cliente:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Cliente entity.
    *
    * @param Cliente $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Cliente $entity)
    {
        $form = $this->createForm(new ClienteType(), $entity, array(
            'action' => $this->generateUrl('cliente_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modificar', 'attr'=> array('class'=>'btn middle-first')));

        return $form;
    }
    /**
     * Edits an existing Cliente entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JOYASJoyasBundle:Cliente')->find($id);

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()){
			$entity->setCuit(str_replace('-', '', $entity->getCuit()));
            $em->flush();

            return $this->redirect($this->generateUrl('cliente'));
        }

        return $this->render('JOYASJoyasBundle:Cliente:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a Cliente entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('JOYASJoyasBundle:Cliente')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Cliente entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cliente'));
    }

    /**
     * Creates a form to delete a Cliente entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cliente_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
