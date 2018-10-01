<?php

namespace JOYAS\JoyasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use JOYAS\JoyasBundle\Entity\CondicionIva;
use JOYAS\JoyasBundle\Form\CondicionIvaType;
use JOYAS\JoyasBundle\Services\SessionManager;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * CondicionIva controller.
 *
 */
class CondicionIvaController extends Controller
{
	/**
	 * @var SessionManager
	 * @DI\Inject("session.manager")
	 */
	public $sessionSvc;	

    /**
     * Lists all CondicionIva entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JOYASJoyasBundle:CondicionIva')->findBy(array('estado'=>'A'),array('descripcion' => 'ASC'));

        return $this->render('JOYASJoyasBundle:CondicionIva:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new CondicionIva entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new CondicionIva();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('condicioniva'));
        }

        return $this->render('JOYASJoyasBundle:CondicionIva:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a CondicionIva entity.
     *
     * @param CondicionIva $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CondicionIva $entity)
    {
        $form = $this->createForm(new CondicionIvaType(), $entity, array(
            'action' => $this->generateUrl('condicioniva_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Guardar', 'attr'=> array('class'=>'btn middle-first', 'onclick'=>'ocultar(this.id)')));

        return $form;
    }

    /**
     * Displays a form to create a new CondicionIva entity.
     *
     */
    public function newAction()
    {
        $entity = new CondicionIva();
        $form   = $this->createCreateForm($entity);

        return $this->render('JOYASJoyasBundle:CondicionIva:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CondicionIva entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JOYASJoyasBundle:CondicionIva')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CondicionIva entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('JOYASJoyasBundle:CondicionIva:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing CondicionIva entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JOYASJoyasBundle:CondicionIva')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CondicionIva entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('JOYASJoyasBundle:CondicionIva:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a CondicionIva entity.
    *
    * @param CondicionIva $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(CondicionIva $entity)
    {
        $form = $this->createForm(new CondicionIvaType(), $entity, array(
            'action' => $this->generateUrl('condicioniva_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modificar', 'attr'=> array('class'=>'btn middle-first')));

        return $form;
    }
    /**
     * Edits an existing CondicionIva entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JOYASJoyasBundle:CondicionIva')->find($id);

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('condicioniva'));
        }

        return $this->render('JOYASJoyasBundle:CondicionIva:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a CondicionIva entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('JOYASJoyasBundle:CondicionIva')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CondicionIva entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('condicioniva'));
    }

    /**
     * Creates a form to delete a CondicionIva entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('condicioniva_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
