<?php

namespace JOYAS\JoyasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JOYAS\JoyasBundle\Entity\PuntoVenta;
use JOYAS\JoyasBundle\Form\PuntoVentaType;
use JOYAS\JoyasBundle\Services\SessionManager;
use JMS\DiExtraBundle\Annotation as DI;

class PuntoVentaController extends Controller
{
	/**
	 * @var SessionManager
	 * @DI\Inject("session.manager")
	 */
	public $sessionSvc;

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JOYASJoyasBundle:PuntoVenta')->findBy(array('usuario'=>$this->sessionSvc->getSession('usuario')->getId()));

        return $this->render('JOYASJoyasBundle:PuntoVenta:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    public function createAction(Request $request)
    {
        $entity = new PuntoVenta();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $usuario = $em->getRepository('JOYASJoyasBundle:Usuario')->find($this->sessionSvc->getSession('usuario')->getId());
            $entity->setUsuario($usuario);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('puntoventa'));
        }

        return $this->render('JOYASJoyasBundle:PuntoVenta:edit.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    private function createCreateForm(PuntoVenta $entity)
    {
        $form = $this->createForm(new PuntoVentaType(), $entity, array(
            'action' => $this->generateUrl('puntoventa_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Guardar', 'attr'=> array('class'=>'btn middle-first')));

        return $form;
    }

    public function newAction()
    {
        $entity = new PuntoVenta();
        $form   = $this->createCreateForm($entity);

        return $this->render('JOYASJoyasBundle:PuntoVenta:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JOYASJoyasBundle:PuntoVenta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PuntoVenta entity.');
        }

        return $this->render('JOYASJoyasBundle:PuntoVenta:show.html.twig', array(
            'entity'      => $entity,
        ));
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JOYASJoyasBundle:PuntoVenta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PuntoVenta entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('JOYASJoyasBundle:PuntoVenta:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    private function createEditForm(PuntoVenta $entity)
    {
        $form = $this->createForm(new PuntoVentaType(), $entity, array(
            'action' => $this->generateUrl('puntoventa_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modificar', 'attr'=> array('class'=>'btn middle-first')));

        return $form;
    }

    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JOYASJoyasBundle:PuntoVenta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PuntoVenta entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('puntoventa'));
        }

        return $this->render('JOYASJoyasBundle:PuntoVenta:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JOYASJoyasBundle:PuntoVenta')->find($id);
        $entity->setEstado('B');
        $em->flush();

        return $this->redirect($this->generateUrl('puntoventa'));
    }

    public function activarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JOYASJoyasBundle:PuntoVenta')->find($id);
        $entity->setEstado('A');
        $em->flush();

        return $this->redirect($this->generateUrl('puntoventa'));
    }
}
