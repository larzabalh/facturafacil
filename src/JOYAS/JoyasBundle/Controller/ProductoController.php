<?php

namespace JOYAS\JoyasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use JOYAS\JoyasBundle\Entity\Precio;
use JOYAS\JoyasBundle\Entity\ImagenProducto;
use JOYAS\JoyasBundle\Entity\Producto;
use JOYAS\JoyasBundle\Entity\ValorTipoCosto;
use JOYAS\JoyasBundle\Form\ProductoType;
use Symfony\Component\HttpFoundation\Session\Session;
use JOYAS\JoyasBundle\Services\SessionManager;
use JMS\DiExtraBundle\Annotation as DI;
use Doctrine\Common\Collections\ArrayCollection;
use JOYAS\JoyasBundle\Entity\Resize;

/**
 * Producto controller.
 *
 */
class ProductoController extends Controller
{
	/**
	 * @var SessionManager
	 * @DI\Inject("session.manager")
	 */
	public $sessionSvc;
	
    /**
     * Lists all Producto entities.
     *
     */
    public function indexAction()
    {
		if(!$this->sessionSvc->isLogged()){
			return $this->redirect($this->generateUrl('joyas_joyas_homepage'));
		}
		$em = $this->getDoctrine()->getManager();
	
		if($this->sessionSvc->getSession('perfil')!='ADMINISTRADOR'){
			$entities = $em->getRepository('JOYASJoyasBundle:Producto')->getAllActivas($this->sessionSvc->getSession('unidad'));						
		}else{
			$entities = $em->getRepository('JOYASJoyasBundle:Producto')->getAllActivas();
		}		

		$unidades = $em->getRepository('JOYASJoyasBundle:UnidadNegocio')->findAll();

		return $this->render('JOYASJoyasBundle:Producto:index.html.twig', array(
			'entities' => $entities,
			'unidades' => $unidades,
		));
    }


    /**
     * Lists all Producto entities.
     *
     */
    public function ajusteAction()
    {
		if($this->sessionSvc->isLogged()){
			$em = $this->getDoctrine()->getManager();
	
			if($this->sessionSvc->getSession('perfil')!='ADMINISTRADOR'){
				$entities = $em->getRepository('JOYASJoyasBundle:Producto')->getAllActivas($this->sessionSvc->getSession('unidad'));						
			}else{
				$entities = $em->getRepository('JOYASJoyasBundle:Producto')->getAllActivas();
			}		
				
			$unidades = $em->getRepository('JOYASJoyasBundle:UnidadNegocio')->findAll();
			return $this->render('JOYASJoyasBundle:Producto:ajuste.html.twig', array(
				'entities' => $entities,
				'unidades' => $unidades,
			));
	    }else{
			return $this->redirect($this->generateUrl('joyas_joyas_homepage'));
		}
    }

    /**
     *
     */
    public function filtroAction(Request $request)
    {
		if($this->sessionSvc->isLogged()){
			$em = $this->getDoctrine()->getManager();
			$producto = NULL;
			
			if($request->get('codigo')!='000' and $this->sessionSvc->getSession('unidad')!=''){		
				$producto = $em->getRepository('JOYASJoyasBundle:Producto')->findOneBy(array('codigo' => $request->get('codigo'), 'unidadNegocio'=>$this->sessionSvc->getSession('unidad')));
			}else{
				if($this->sessionSvc->getSession('unidad')==''){		
					$producto = $em->getRepository('JOYASJoyasBundle:Producto')->findOneBy(array('codigo' => $request->get('codigo')));
				}
			}
						
			if(!is_null($producto)){
				$entities = new ArrayCollection();
				$entities->add($producto);
				return $this->render('JOYASJoyasBundle:Producto:ajuste.html.twig', array(
					'entities' => $entities,
				));
			}else{
				$this->sessionSvc->addFlash('msgWarn','No se han encontrado resultados.');		
				return $this->redirect($this->generateUrl('producto_ajuste'));
			}
	    }else{
			return $this->redirect($this->generateUrl('joyas_joyas_homepage'));
		}
    }

    /**
     *
     */
    public function filtroPAction(Request $request)
    {
		if($this->sessionSvc->isLogged()){
			$em = $this->getDoctrine()->getManager();			

			$producto = NULL;

			if($request->get('codigo')=='' and $request->get('unidadnegocio')!='' and $this->sessionSvc->getSession('perfil') == 'ADMINISTRADOR'){
				$entities = $em->getRepository('JOYASJoyasBundle:Producto')->getAllActivas($request->get('unidadnegocio'));								
				$unidades = $em->getRepository('JOYASJoyasBundle:UnidadNegocio')->findAll();
				return $this->render('JOYASJoyasBundle:Producto:index.html.twig', array(
					'entities' => $entities,
					'unidades' => $unidades,
				));
			}

			if($request->get('codigo')!='000' and $this->sessionSvc->getSession('unidad')!=''){		
				$producto = $em->getRepository('JOYASJoyasBundle:Producto')->findOneBy(array('codigo' => $request->get('codigo'), 'unidadNegocio'=>$this->sessionSvc->getSession('unidad')));
			}else{
				if($this->sessionSvc->getSession('unidad')==''){
					$producto = $em->getRepository('JOYASJoyasBundle:Producto')->findOneBy(array('codigo' => $request->get('codigo'), 'unidadNegocio'=>$request->get('unidadnegocio')));
				}
			}

			$entities = new ArrayCollection();
			if(!is_null($producto)){
				$entities->add($producto);
				
				$unidades = $em->getRepository('JOYASJoyasBundle:UnidadNegocio')->findAll();
				
				return $this->render('JOYASJoyasBundle:Producto:index.html.twig', array(
					'entities' => $entities,
					'unidades' => $unidades,
				));
			}else{
				return $this->redirect($this->generateUrl('producto'));
			}
	    }else{
			return $this->redirect($this->generateUrl('joyas_joyas_homepage'));
		}
    }
	
    /**
     * Creates a new Producto entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Producto();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

		$em = $this->getDoctrine()->getManager();
		$unidades = $em->getRepository('JOYASJoyasBundle:UnidadNegocio')->findAll();

		if($this->sessionSvc->getSession('perfil')!='ADMINISTRADOR'){
			$unidad = $em->getRepository('JOYASJoyasBundle:UnidadNegocio')->find($this->sessionSvc->getSession('unidad'));
		}else{
			$unidad = $em->getRepository('JOYASJoyasBundle:UnidadNegocio')->find($request->get('unidadnegocio'));
		}
		$error = 'no';
		$entity->setUnidadNegocio($unidad);
		$codigo = $entity->getCodigo();
		if(isset($codigo) and $codigo!=''){
			$producto = $em->getRepository('JOYASJoyasBundle:Producto')->findOneBy(array('codigo' => $entity->getCodigo(), 'unidadNegocio'=>$unidad->getId()));
			if(!is_null($producto)){
				$error = 'si';		
			}
		}

        if ($error=='no' and $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

			$uploaddir = "uploads/documents/productos/".$entity->getId();	
			if (!file_exists($uploaddir)) {
				mkdir($uploaddir, 0777, true);
			}
			$archivo = '';
			for($i=1; $i<6 ; $i++){
				$archivo = 'archivo'.$i;
				$filename = trim($_FILES[$archivo]['name']);
				$filesize = $_FILES[$archivo]['size'];		
				if($filesize > 0){ 
					$uploadfile = $uploaddir . $filename;
					$name = $_FILES[$archivo]["name"];
					$files = $request->files;
					$uploadedFile = $files->get($archivo);
					$file = $uploadedFile->move($uploaddir, $name);
					$obj = new Resize();
					$obj->max_width(600);
					$obj->max_height(600);
					$obj->image_path($this->get('kernel')->getRootDir()."/../titanio/$uploaddir/$name");
					$obj->image_resize();
					$imagenproducto = new ImagenProducto();
					$imagenproducto->setPath($name);					
					$imagenproducto->setProducto($entity);
					$em->persist($imagenproducto);
					$em->flush();							
				}
			}

			$this->sessionSvc->addFlash('msgOk', 'Alta satisfactoria, puede continuar.');

			$entity = new Producto();
        	$form = $this->createCreateForm($entity);
			return $this->render('JOYASJoyasBundle:Producto:new.html.twig', array(
 	           'entity' => $entity,
	            'unidades' => $unidades,
			   'form'   => $form->createView(),
			));			
        }
		
        if ($form->isValid()) {
			$this->sessionSvc->addFlash('msgError', 'El codigo debe ser unico.');
       	} 
		return $this->render('JOYASJoyasBundle:Producto:new.html.twig', array(
            'entity' => $entity,
            'unidades' => $unidades,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Producto entity.
     *
     * @param Producto $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Producto $entity)
    {
        $form = $this->createForm(new ProductoType(), $entity, array(
            'action' => $this->generateUrl('producto_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Guardar', 'attr'=> array('class'=>'btn middle-first')));

        return $form;
    }

    /**
     * Displays a form to create a new Producto entity.
     *
     */
    public function newAction()
    {
		if($this->sessionSvc->isLogged()){
			$em = $this->getDoctrine()->getManager();
			$entity = new Producto();
			$form   = $this->createCreateForm($entity);
			$unidades = $em->getRepository('JOYASJoyasBundle:UnidadNegocio')->findAll();
	
			return $this->render('JOYASJoyasBundle:Producto:new.html.twig', array(
				'entity' => $entity,
				'unidades' => $unidades,
				'form'   => $form->createView(),
			));
	    }else{
			return $this->redirect($this->generateUrl('joyas_joyas_homepage'));
		}
    }

    /**
     * Finds and displays a Producto entity.
     *
     */
    public function showAction($id)
    {
		if($this->sessionSvc->isLogged()){
			$em = $this->getDoctrine()->getManager();
	
			$entity = $em->getRepository('JOYASJoyasBundle:Producto')->find($id);
	
			if (!$entity) {
				throw $this->createNotFoundException('Unable to find Producto entity.');
			}
	
			$deleteForm = $this->createDeleteForm($id);
	
			return $this->render('JOYASJoyasBundle:Producto:show.html.twig', array(
				'entity'      => $entity,
				'delete_form' => $deleteForm->createView(),
			));
	    }else{
			return $this->redirect($this->generateUrl('joyas_joyas_homepage'));
		}
    }

    public function webAction($id)
    {
		$em = $this->getDoctrine()->getManager();
		$lista = $em->getRepository('JOYASJoyasBundle:ListaPrecio')->findOneBy(array('descripcion' => 'Lista Web'));
		$entity = $em->getRepository('JOYASJoyasBundle:Precio')->findOneBy(array('producto'=>$id, 'listaPrecio'=>$lista->getId()));

		if(!$entity->getProducto()->getVisible()){
			$this->sessionSvc->addFlash('msgWarn', 'No puede visualizarse el producto');
			return $this->redirect($this->generateUrl('joyas_joyas_web'));
		}
		if(!is_null($entity->getProducto()->getCategoriasubcategoria())){
			$relacionados = $em->getRepository('JOYASJoyasBundle:Producto')->relacionados($entity->getProducto()->getCategoriasubcategoria()->getId());
		}else{
			$relacionados = new ArrayCollection();
		}
		return $this->render('JOYASJoyasBundle:Web:single.html.twig', array(
			'entity' => $entity,
			'relacionados' => $relacionados
		));
    }

    public function categoriasAction($id)
    {
		$em = $this->getDoctrine()->getManager();
		$categoria = $em->getRepository('JOYASJoyasBundle:Categoria')->find($id);
		$subcategorias = $em->getRepository('JOYASJoyasBundle:Categoriasubcategoria')->porcategoria($id);
		$precios = $em->getRepository('JOYASJoyasBundle:Producto')->porcategoria($id);
		
		return $this->render('JOYASJoyasBundle:Web:categorias.html.twig', array(
			'categoria' => $categoria,
			'subcategorias' => $subcategorias,
			'precios' => $precios,
		));
    }

    public function filtropreciosAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$id = $request->get('categoria');

		$rangos = explode('-',$request->get('filtro'));
		if($request->get('pantalla')=='categoria'){
			$categoria = $em->getRepository('JOYASJoyasBundle:Categoria')->find($id);
			$subcategorias = $em->getRepository('JOYASJoyasBundle:Categoriasubcategoria')->porcategoria($id);
			$precios = $em->getRepository('JOYASJoyasBundle:Producto')->porcategoriayprecio($id, $rangos[0], $rangos[1]);
			return $this->render('JOYASJoyasBundle:Web:categorias.html.twig', array(
				'categoria' => $categoria,
				'subcategorias' => $subcategorias,
				'precios' => $precios,
			));
		}
		if($request->get('pantalla')=='novedades'){
			$precios = $em->getRepository('JOYASJoyasBundle:Producto')->novedadesxprecio($rangos[0], $rangos[1]);
			return $this->render('JOYASJoyasBundle:Web:novedades.html.twig', array(
				'novedades' => $precios,
			));
		}
		if($request->get('pantalla')=='ofertas'){
			$precios = $em->getRepository('JOYASJoyasBundle:Producto')->ofertasxprecio($rangos[0], $rangos[1]);
			return $this->render('JOYASJoyasBundle:Web:ofertas.html.twig', array(
				'ofertas' => $precios,
			));
		}
		
		return $this->redirect($this->generateUrl('joyas_joyas_web'));		
    }

    public function buscarwebAction(Request $request)
    {
		$desc = $request->get('buscar');

		$em = $this->getDoctrine()->getManager();

		$precios = $em->getRepository('JOYASJoyasBundle:Producto')->porbusqueda(trim($desc));
		
		return $this->render('JOYASJoyasBundle:Web:resultado.html.twig', array(
			'precios' => $precios,
			'busc' => $desc,
		));
    }

    /**
     * Displays a form to edit an existing Producto entity.
     *
     */
    public function editAction($id)
    {
		if($this->sessionSvc->isLogged()){
			$em = $this->getDoctrine()->getManager();
	
			$entity = $em->getRepository('JOYASJoyasBundle:Producto')->find($id);
	
			if (!$entity) {
				throw $this->createNotFoundException('Unable to find Producto entity.');
			}
	
			$editForm = $this->createEditForm($entity);
			$deleteForm = $this->createDeleteForm($id);
	
			return $this->render('JOYASJoyasBundle:Producto:edit.html.twig', array(
				'entity'      => $entity,
				'edit_form'   => $editForm->createView(),
				'delete_form' => $deleteForm->createView(),
			));
	    }else{
			return $this->redirect($this->generateUrl('joyas_joyas_homepage'));
		}
    }

    /**
    * Creates a form to edit a Producto entity.
    *
    * @param Producto $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Producto $entity)
    {
        $form = $this->createForm(new ProductoType(), $entity, array(
            'action' => $this->generateUrl('producto_update', array('id' => $entity->getId())),
            'method' => 'post',
        ));

        $form->add('submit', 'submit', array('label' => 'Modificar', 'attr'=> array('class'=>'btn middle-first')));

        return $form;
    }
    /**
     * Edits an existing Producto entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JOYASJoyasBundle:Producto')->find($id);
		$conAnt = $entity->getCodigo();

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
		$editForm->handleRequest($request);
		$error = 'no';

        if ($editForm->isValid()) {
			$producto = $em->getRepository('JOYASJoyasBundle:Producto')->findOneBy(array('codigo' => $entity->getCodigo(), 'unidadNegocio'=>$entity->getUnidadNegocio()->getId()));
			if($conAnt!=$entity->getCodigo() and !is_null($producto)){
				$error = 'si';		
			}
			if($error == 'no'){
				$misDato = $request->get('checks');
				if($misDato!=''){
					foreach ($misDato as $mi_dato){
						$imagen = $em->getRepository('JOYASJoyasBundle:ImagenProducto')->find($mi_dato);
						if(!is_null($imagen)){
							unlink("uploads/documents/productos/".$id."/".$imagen->getPath());
							$em->remove($imagen);
							$em->flush();
						}
					}
				}
				$uploaddir = "uploads/documents/productos/".$entity->getId();	
				if (!file_exists($uploaddir)) {
					mkdir($uploaddir, 0777, true);
				}
				$archivo = '';
				for($i=1; $i<6; $i++){
					$archivo = 'archivo'.$i;
					$filename = trim($_FILES[$archivo]['name']);
					$filesize = $_FILES[$archivo]['size'];		
					if($filesize > 0){ 
    					$uploadfile = $uploaddir . $filename;
    					$name = $_FILES[$archivo]["name"];
    					$files = $request->files;
    					$uploadedFile = $files->get($archivo);
    					$file = $uploadedFile->move($uploaddir, $name);
    					$obj = new Resize();
    					$obj->max_width(600);
    					$obj->max_height(600);
    					$obj->image_path($this->get('kernel')->getRootDir()."/../titanio/$uploaddir/$name");
    					$obj->image_resize();
    					$imagenproducto = new ImagenProducto();
    					$imagenproducto->setPath($name);					
    					$imagenproducto->setProducto($entity);
    					$em->persist($imagenproducto);
    					$em->flush();							
					}
				}	
	
				$em->flush();
	
				$this->sessionSvc->addFlash('msgOk', 'Se ha modificado el producto con codigo: '.$entity->getCodigo() );
				return $this->redirect($this->generateUrl('producto'));
			}
        }

        if ($editForm->isValid()) {
			$this->sessionSvc->addFlash('msgError', 'El codigo debe ser unico.');
       	} 

        return $this->render('JOYASJoyasBundle:Producto:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Producto entity.
     *
     */
    public function stockAction(Request $request, $id)
    {
		if($this->sessionSvc->isLogged()){
			$em = $this->getDoctrine()->getManager();
	
			$entity = $em->getRepository('JOYASJoyasBundle:Producto')->find($id);
			$stock = 'stock'.$id;
			$entity->setStock($request->get($stock));
	
			$em->flush();
		
			$this->sessionSvc->addFlash('msgOk', 'Se ha modificado el stock.');
			return $this->redirect($this->generateUrl('producto_ajuste'));
	    }else{
			return $this->redirect($this->generateUrl('joyas_joyas_homepage'));
		}
    }

    /**
     * Deletes a Producto entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('JOYASJoyasBundle:Producto')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Producto entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('producto'));
    }

    /**
     * Creates a form to delete a Producto entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('producto_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Borrar', 'attr'=> array('class'=>'btn')))
            ->getForm()
        ;
    }

    /**
     * Genera la pantalla para definir el costo apropiado al producto.
     *
     */
    public function costoAction($id)
    {
		if($this->sessionSvc->isLogged()){
			$em = $this->getDoctrine()->getManager();
	
			$entity = $em->getRepository('JOYASJoyasBundle:Producto')->find($id);
			$categorias = $em->getRepository('JOYASJoyasBundle:Categoria')->findAll();
	
			if (!$entity) {
				throw $this->createNotFoundException('Unable to find Producto entity.');
			}
	
			return $this->render('JOYASJoyasBundle:Producto:costo.html.twig', array(
				'entity'      => $entity,
				'categorias'      => $categorias,
			));
	    }else{
			return $this->redirect($this->generateUrl('joyas_joyas_homepage'));
		}
    }

    /**
     * Guarda el costo del producto.
     *
     */
    public function altaCostoAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
		$entity = $em->getRepository('JOYASJoyasBundle:Producto')->find($id);		
		
		$cantCostos = $request->request->get('cantCostos');	

		if($cantCostos>0){
			for($i = 0; $i<$cantCostos; $i++) {
				
				$idCosto = 'idCosto'.$i;
				$costoValor = 'costoValor'.$i;
				$costoCantidad = 'costoCantidad'.$i;
				$resultado = 'resultado'.$i;
				
				$idTipoCosto = $request->request->get($idCosto);

				$tipoCosto = $em->getRepository('JOYASJoyasBundle:TipoCosto')->find($idTipoCosto);		
				
				$valorTipoCosto = new ValorTipoCosto();
				$precio = new Precio();
				$hoy = new \DateTime();
				
				$precio->setValor($request->request->get('precio'));
				$precio->setFecha($hoy);
				$precio->setProducto($entity);

				$valorTipoCosto->setProducto($entity);
				$valorTipoCosto->setTipoCosto($tipoCosto);
				$valorTipoCosto->setCantidad($request->request->get($costoCantidad));
				$valorTipoCosto->setValor($request->request->get($costoValor));
	            
				$em->persist($precio);
				$em->persist($valorTipoCosto);
	            $em->flush();	 
			}
			
			$this->sessionSvc->addFlash('msgOk', 'Alta de Costo satisfactoria.');

            return $this->redirect($this->generateUrl('producto'));
			
		}else{
				
			$this->sessionSvc->addFlash('msgWarn', 'No existen tipos de costo para dar el alta.');
			$categorias = $em->getRepository('JOYASJoyasBundle:Categoria')->findAll();

			return $this->render('JOYASJoyasBundle:Producto:costo.html.twig', array(
				'entity'      => $entity,
			));

		}
    }

    /**
     * Lists all Producto entities.
     *
     */
    public function informeStockAction()
    {
		if($this->sessionSvc->isLogged()){
			$em = $this->getDoctrine()->getManager();
	
			if($this->sessionSvc->getSession('perfil')!='ADMINISTRADOR'){	
				$entities = $em->getRepository('JOYASJoyasBundle:Producto')->getAllActivas($this->sessionSvc->getSession('unidad'));
			}else{
				$entities = $em->getRepository('JOYASJoyasBundle:Producto')->getAllActivas();
			}
			
			// ask the service for a Excel5
			$phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
			
			$phpExcelObject->getProperties()->setCreator("Willy Jhons")
			   ->setLastModifiedBy("Willy Jhons")
			   ->setTitle("Informe")
			   ->setSubject("Willy Jhons");
	
			$phpExcelObject->setActiveSheetIndex(0)
			   ->setCellValue('A1', 'Fecha')
			   ->setCellValue('B1', date('d-m-Y'));
	
	
			$phpExcelObject->setActiveSheetIndex(0)
			   ->setCellValue('A2', 'CODIGO')
			   ->setCellValue('B2', 'DESCRIPCION')
			   ->setCellValue('C2', 'STOCK')
			   ->setCellValue('D2', 'COSTO UNITARIO $/U$S')
			   ->setCellValue('E2', 'TOTAL COSTO  $/U$S')
			   ;
	
				$count = 3;
				$sumaP = 0;
				$sumaD = 0;
				$stock = 0;
	
				foreach($entities as $ent){
	
					if($ent->getMoneda()=="1"){
						$sumaP = $sumaP + ($ent->getCosto()*$ent->getStock());
					}else{
						$sumaD = $sumaD + ($ent->getCosto()*$ent->getStock());
					}
					
					$totalCosto = $ent->getStock() * $ent->getCosto(); 
					
					$phpExcelObject->setActiveSheetIndex(0)
					   ->setCellValue('A'.$count, $ent->getCodigo())
					   ->setCellValue('B'.$count, $ent->getDescripcion())
					   ->setCellValue('C'.$count, $ent->getStock())
					   ->setCellValue('D'.$count, $ent->getMonedaStr().' '.$ent->getCosto())
					   ->setCellValue('E'.$count, $totalCosto);		
					
					
					$stock = $ent->getStock() + $stock;
					$count = $count + 1;
				}			
				
				$c2 = $count+1;
				$c3 = $c2+1;
				
				$phpExcelObject->setActiveSheetIndex(0)
				   ->setCellValue('D'.$count, 'Total')
				   ->setCellValue('E'.$count, $stock.' UNIDADDES')
				   ->setCellValue('D'.$c2, 'Total costo ($)')
				   ->setCellValue('E'.$c2, $sumaP)
				   ->setCellValue('D'.$c3, 'Total costo (U$S)')
				   ->setCellValue('E'.$c3, $sumaD);		
	
				$phpExcelObject->getActiveSheet()->getStyle('A2:E2')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('B2B2B2B2');
	
				$phpExcelObject->getActiveSheet()->setTitle('Informe Stock');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet
				$phpExcelObject->setActiveSheetIndex(0);
				$phpExcelObject->getActiveSheet()->getColumnDimension('A')->setWidth(30);
				$phpExcelObject->getActiveSheet()->getColumnDimension('B')->setWidth(20);
				$phpExcelObject->getActiveSheet()->getColumnDimension('C')->setWidth(25);
				$phpExcelObject->getActiveSheet()->getColumnDimension('D')->setWidth(20);
				$phpExcelObject->getActiveSheet()->getColumnDimension('E')->setWidth(25);
				$writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
				// create the response
				$response = $this->get('phpexcel')->createStreamedResponse($writer);
				// adding headers
				$response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
				$response->headers->set('Content-Disposition', 'attachment;filename=InformeStock.xls');
				$response->headers->set('Pragma', 'public');
				$response->headers->set('Cache-Control', 'maxage=1');
				
				return $response;
	    }else{
			return $this->redirect($this->generateUrl('joyas_joyas_homepage'));
		}
    }

    public function imprimirCodigoAction()
    {	
		$cantidad = $_GET['num'];
		$codigo = $_GET['cod'];
		if(!isset($cantidad) or $cantidad==0){
			$cantidad = 1;
		}

		return $this->render('JOYASJoyasBundle:Producto:imprimirCodigo.html.twig', array(
			'cantidad' => $cantidad,
			'codigo' => $codigo,
		));
    }
    public function carritoajaxAction(Request $request)
    {	
		$search = $request->get('data');
		$this->sessionSvc->agregaralcarrito($search);
		$response = 'Producto agregado al carrito.';

		return new Response(json_encode($response));		
    }

    public function quitarajaxAction(Request $request)
    {	
		$search = $request->get('data');
		$this->sessionSvc->quitardelcarrito($search);
		$response = 'Producto sacado del carrito.';

		return new Response(json_encode($response));		
    }

    public function vaciarajaxAction()
    {	
		$this->sessionSvc->vaciarcarrito();
		$response = 'Se ha vaciado el carrito.';

		return new Response(json_encode($response));		
    }

    public function predictivaAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$search = $request->get('data');
	    $string = '<ul>';
		if(strlen($search) >= 3){
	        $productos = $em->getRepository('JOYASJoyasBundle:Producto')->predictiva($search);
			foreach($productos as $prod){
				$string = $string.'<li class=suggest-element id='.$prod->getId().'><a href="#" data='.$prod->getId().' id=producto'.$prod->getId().'>'.$prod->getDescripcion().' ( '.$prod->getCodigo().' )';
			}
		}
		$response = $string;
		return new Response($response);		
    }

    public function predictivaconprecioAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$search = $request->get('data');
		$idlista = $request->get('data2');
	    $string = '<ul>';
		if(strlen($search) >= 3){
	        $precios = $em->getRepository('JOYASJoyasBundle:Producto')->predictivaprecio($search);
			foreach($precios as $pre){
				$string = $string.'<li class=suggest-element precio='.$pre->getValor().' id='.$pre->getProducto()->getId().'><a href="#" data='.$pre->getProducto()->getId().' id=producto'.$pre->getProducto()->getId().'>'.$pre->getProducto()->getDescripcion().' ( '.$pre->getProducto()->getCodigo().' )';
			}
		}
		$response = $string;
		return new Response($response);		
    }

}
