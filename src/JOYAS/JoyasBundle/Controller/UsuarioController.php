<?php

namespace JOYAS\JoyasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections\ArrayCollection;
use JOYAS\JoyasBundle\Entity\Usuario;
use JOYAS\JoyasBundle\Form\UsuarioType;
use JOYAS\JoyasBundle\Services\SessionManager;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Usuario controller.
 *
 */
class UsuarioController extends Controller {

    /**
     * @var SessionManager
     * @DI\Inject("session.manager")
     */
    public $sessionSvc;

    /**
     * Lists all Usuario entities.
     *
     */
    public function indexAction() {
        if (!$this->sessionSvc->isLogged()) {
            return $this->redirect($this->generateUrl('joyas_joyas_homepage'));
        }
        $em = $this->getDoctrine()->getManager();
        $usuarioSession = $this->sessionSvc->getSession('usuario');
        if($usuarioSession->getPerfil() == 'ADMINISTRADOR'){
            $entities = $em->getRepository('JOYASJoyasBundle:Usuario')->findAll();
        }else{
            $entities = $em->getRepository('JOYASJoyasBundle:Usuario')->findBy(array('cuit'=>$usuarioSession->getCuit()));

        }
        return $this->render('JOYASJoyasBundle:Usuario:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    public function usuariowebAction() {
        if (!$this->sessionSvc->isLogged()) {
            return $this->redirect($this->generateUrl('joyas_joyas_homepage'));
        }

        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('JOYASJoyasBundle:UsuarioWeb')->getAll();

        return $this->render('JOYASJoyasBundle:UsuarioWeb:index.html.twig', array(
                    'entities' => $entities,
        ));
    }

    /**
     * Creates a new Usuario entity.
     *
     */
    public function createAction(Request $request) {
        if ($this->sessionSvc->isLogged()) {
            $entity = new Usuario();
            $form = $this->createCreateForm($entity);
            $form->handleRequest($request);
            $em = $this->getDoctrine()->getManager();

            $usuario = $em->getRepository('JOYASJoyasBundle:Usuario')->findOneBy(array('mail' => $entity->getMail()));
            if ($usuario) {
                $this->sessionSvc->addFlash('msgWarn', 'Email EXISTENTE, por favor ingrese otro.');
                return $this->render('JOYASJoyasBundle:Usuario:new.html.twig', array(
                            'entity' => $entity,
                            'form' => $form->createView(),
                ));
            }
            if ($form->isValid()) {
                $file = $form['logo']->getData();
    			if($file){
    				if($file->getSize()>0){
    					$strm = fopen($file->getRealPath(),'rb');
    					$entity->setImagen('data:'.$file->getClientMimeType().'/'.$file->getClientOriginalExtension().';base64,'.base64_encode(stream_get_contents(($strm))));
    				}
    			}
                $em->persist($entity);
                $em->flush();

                $this->sessionSvc->addFlash('msgOk', 'Usuario creado exitosamente.');

                return $this->redirect($this->generateUrl('usuario'));
            }

            return $this->render('JOYASJoyasBundle:Usuario:new.html.twig', array(
                        'entity' => $entity,
                        'form' => $form->createView(),
            ));
        } else {
            return $this->redirect($this->generateUrl('joyas_joyas_homepage'));
        }
    }

    /**
     * Creates a form to create a Usuario entity.
     *
     * @param Usuario $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Usuario $entity) {
        $form = $this->createForm(new UsuarioType(), $entity, array(
            'action' => $this->generateUrl('usuario_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Guardar', 'attr' => array('class' => 'btn middle-first')));

        return $form;
    }

    /**
     * Displays a form to create a new Usuario entity.
     *
     */
    public function newAction() {
        if ($this->sessionSvc->isLogged()) {
            $entity = new Usuario();
            $form = $this->createCreateForm($entity);

            return $this->render('JOYASJoyasBundle:Usuario:new.html.twig', array(
                        'entity' => $entity,
                        'form' => $form->createView(),
            ));
        } else {
            return $this->redirect($this->generateUrl('joyas_joyas_homepage'));
        }
    }

    /**
     * Finds and displays a Usuario entity.
     *
     */
    public function showAction($id) {
        if ($this->sessionSvc->isLogged()) {
            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('JOYASJoyasBundle:Usuario')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Usuario entity.');
            }

            $deleteForm = $this->createDeleteForm($id);

            return $this->render('JOYASJoyasBundle:Usuario:show.html.twig', array(
                        'entity' => $entity,
                        'delete_form' => $deleteForm->createView(),
            ));
        } else {
            return $this->redirect($this->generateUrl('joyas_joyas_homepage'));
        }
    }

    /**
     * Displays a form to edit an existing Usuario entity.
     *
     */
    public function editAction($id) {
        if ($this->sessionSvc->isLogged()) {
            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('JOYASJoyasBundle:Usuario')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Usuario entity.');
            }

            $editForm = $this->createEditForm($entity);
            $deleteForm = $this->createDeleteForm($id);

            return $this->render('JOYASJoyasBundle:Usuario:edit.html.twig', array(
                        'entity' => $entity,
                        'edit_form' => $editForm->createView(),
                        'delete_form' => $deleteForm->createView(),
            ));
        } else {
            return $this->redirect($this->generateUrl('joyas_joyas_homepage'));
        }
    }

    /**
     * Creates a form to edit a Usuario entity.
     *
     * @param Usuario $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Usuario $entity) {
        $form = $this->createForm(new UsuarioType(), $entity, array(
            'action' => $this->generateUrl('usuario_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modificar', 'attr' => array('class' => 'btn middle-first')));

        return $form;
    }

    /**
     * Edits an existing Usuario entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JOYASJoyasBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $file = $editForm['logo']->getData();
            if($file){
                if($file->getSize()>0){
                    $strm = fopen($file->getRealPath(),'rb');
                    $entity->setImagen('data:'.$file->getClientMimeType().'/'.$file->getClientOriginalExtension().';base64,'.base64_encode(stream_get_contents(($strm))));
                }
            }
            $em->flush();
            $this->sessionSvc->addFlash('msgOk', 'Usuario modificado exitosamente.');
            return $this->redirect($this->generateUrl('usuario'));
        }

        return $this->render('JOYASJoyasBundle:Usuario:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a Usuario entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JOYASJoyasBundle:Usuario')->find($id);
        $entity->setEstado('B');
        $em->flush();
        $this->sessionSvc->addFlash('msgOk', 'Usuario deshabilitado exitosamente.');
        return $this->redirect($this->generateUrl('usuario'));
    }

    public function activarAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JOYASJoyasBundle:Usuario')->find($id);
        $entity->setEstado('A');
        $em->flush();
        $this->sessionSvc->addFlash('msgOk', 'Usuario habilitado exitosamente.');
        return $this->redirect($this->generateUrl('usuario'));
    }

    public function aprobarusuarioAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JOYASJoyasBundle:UsuarioWeb')->find($id);
        $entity->setEstado('A');
        $em->flush();
        $this->sessionSvc->addFlash('msgOk', 'Usuario aprobado.');

        $message = \Swift_Message::newInstance()
                ->setSubject('Titanio - Aprobado.')
                ->setFrom('info@sistemastitanio.com.ar')
                ->setTo($entity->getMail())
                ->setBody('Hola ' . $entity->getNombre() . '! Se ha confimado su cuenta en Titanio, ahora puede operar en nuestro sitio de ventas online.  www.sistemastitanio.com.ar');

        $this->get('mailer')->send($message);

        return $this->redirect($this->generateUrl('usuario_web'));
    }

    public function desaprobarusuarioAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JOYASJoyasBundle:UsuarioWeb')->find($id);
        $entity->setEstado('B');
        $em->flush();
        $this->sessionSvc->addFlash('msgOk', 'Usuario desaprobado.');

        return $this->redirect($this->generateUrl('usuario_web'));
    }

    public function iniciarAction() {
        return $this->render('JOYASJoyasBundle:Web:login.html.twig');
    }

    public function loginarusuariowebAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $usuario = $em->getRepository('JOYASJoyasBundle:UsuarioWeb')->findOneBy(array('mail' => $request->get('mail'), 'clave' => $request->get('clave')));

        if (!is_null($usuario)) {
            if ($usuario->getEstado() == 'B') {
                $this->sessionSvc->addFlash('msgWarn', 'Usted todavia no fue aprobado para navegar en la web.');
            } else {
                $this->sessionSvc->addFlash('msgOkn', 'Bienvenido a TITANIO!');
                $this->sessionSvc->setSession('idusuarioweb', $usuario->getId());
                $this->sessionSvc->setSession('nombreusuarioweb', $usuario->getNombre());
                return $this->redirect($this->generateUrl('joyas_joyas_web'));
            }
        } else {
            $this->sessionSvc->addFlash('msgWarn', 'Mail o clave incorrecto.');
        }
        return $this->redirect($this->generateUrl('joyas_joyas_iniciar'));
    }

    /**
     * Creates a form to delete a Usuario entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('usuario_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Borrar', 'attr' => array('class' => 'btn')))
                        ->getForm()
        ;
    }

}

function encryptIt($q) {
    $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
    $qEncoded = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), $q, MCRYPT_MODE_CBC, md5(md5($cryptKey))));
    return( $qEncoded );
}
