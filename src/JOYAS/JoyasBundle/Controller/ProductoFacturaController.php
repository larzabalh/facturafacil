<?php

namespace JOYAS\JoyasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use JOYAS\JoyasBundle\Entity\ProductoFactura;
use JOYAS\JoyasBundle\Form\ProductoFacturaType;

/**
 * ProductoFactura controller.
 *
 */
class ProductoFacturaController extends Controller
{

    /**
     * Lists all ProductoFactura entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JOYASJoyasBundle:ProductoFactura')->findAll();

        return $this->render('JOYASJoyasBundle:ProductoFactura:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new ProductoFactura entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new ProductoFactura();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('productofactura_show', array('id' => $entity->getId())));
        }

        return $this->render('JOYASJoyasBundle:ProductoFactura:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a ProductoFactura entity.
    *
    * @param ProductoFactura $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(ProductoFactura $entity)
    {
        $form = $this->createForm(new ProductoFacturaType(), $entity, array(
            'action' => $this->generateUrl('productofactura_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ProductoFactura entity.
     *
     */
    public function newAction()
    {
        $entity = new ProductoFactura();
        $form   = $this->createCreateForm($entity);

        return $this->render('JOYASJoyasBundle:ProductoFactura:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ProductoFactura entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JOYASJoyasBundle:ProductoFactura')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductoFactura entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('JOYASJoyasBundle:ProductoFactura:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing ProductoFactura entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JOYASJoyasBundle:ProductoFactura')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductoFactura entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('JOYASJoyasBundle:ProductoFactura:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a ProductoFactura entity.
    *
    * @param ProductoFactura $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ProductoFactura $entity)
    {
        $form = $this->createForm(new ProductoFacturaType(), $entity, array(
            'action' => $this->generateUrl('productofactura_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ProductoFactura entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JOYASJoyasBundle:ProductoFactura')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductoFactura entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('productofactura_edit', array('id' => $id)));
        }

        return $this->render('JOYASJoyasBundle:ProductoFactura:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a ProductoFactura entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('JOYASJoyasBundle:ProductoFactura')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ProductoFactura entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('productofactura'));
    }

    /**
     * Creates a form to delete a ProductoFactura entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('productofactura_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
