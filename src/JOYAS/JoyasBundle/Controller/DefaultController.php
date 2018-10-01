<?php

namespace JOYAS\JoyasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use JOYAS\JoyasBundle\Services\SessionManager;
use JMS\DiExtraBundle\Annotation as DI;
use JOYAS\JoyasBundle\Entity\ListaPrecio;
use JOYAS\JoyasBundle\Entity\Precio;
use JOYAS\JoyasBundle\Entity\Producto;

class DefaultController extends Controller
{
	/**
	 * @var SessionManager
	 * @DI\Inject("session.manager")
	 */
	public $sessionSvc;

    public function indexAction()
    {
		$this->sessionSvc->startSession();
		return $this->render('JOYASJoyasBundle:Default:index.html.twig');
	}

	public function generarAction()
    {
		$hoy = new \DateTime('NOW');

		$pdfGenerator = $this->get('siphoc.pdf.generator');
		$pdfGenerator->setName('imprimirPrueba'.$hoy->format('Y-m-d H:i:s').'.pdf');
		return $pdfGenerator->downloadFromView('JOYASJoyasBundle:Default:imprimir.html.twig');
	}

    public function inicioAction()
    {

		if($this->sessionSvc->isLogged()){
			return $this->render('JOYASJoyasBundle:Default:inicio.html.twig');
		}

		$this->sessionSvc->startSession();
		return $this->render('JOYASJoyasBundle:Default:index.html.twig');

	}
    public function loginAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$session = $request->getSession();

		$login = $request->get('usuario');
		$pass = $request->get('contrasena');

		if ($this->sessionSvc->login($login, $pass)){
			return $this->redirect($this->generateUrl('factura_new'));
		}

        return $this->render('JOYASJoyasBundle:Default:index.html.twig');
    }

    public function cerrarAction()
    {
		$this->sessionSvc->closeSession();
		return $this->redirect($this->generateUrl('joyas_joyas_homepage'));
	}

    public function restClaveAction(Request $request)
    {
        return $this->render('JOYASJoyasBundle:Default:olvideClave.html.twig');
    }

	public function olvideClaveAction(Request $request)
	{
		$username = $request->get('usuario');
		$em = $this->getDoctrine()->getManager();

		$usuario = $em->getRepository('JOYASJoyasBundle:Usuario')->findOneBy(array('login' => $username));
		if(!is_null($usuario)){
			$mail = $usuario->getClave();
			if($mail!='' and isset($mail)){
				//crear mail y mandar
				$message = \Swift_Message::newInstance()
				->setSubject('Recuperacion de clave')
				->setFrom('info@sistemastitanio.com.ar')
				->setTo($usuario->getMail())
				->setBody(
							$this->renderView('JOYASJoyasBundle:Default:email.txt.twig', array('login' => $usuario->getLogin(), 'pass' => $usuario->getClave()))
						);
				$this->get('mailer')->send($message);

				//mensaje ok
				$this->sessionSvc->addFlash('msgOk','Su contraseña ha sido enviada a su dirección de correo electrónico.');
			}else{
				$this->sessionSvc->addFlash('msgOk','No pudimos reestablecer su clave, ya que no tiene mail.');
			}

		}else{
			$this->sessionSvc->addFlash('msgErr','Usuario inexistente.');
		}
		return $this->redirect($this->generateUrl('joyas_joyas_homepage'));

	}

}

function decryptIt( $q ) {
    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
    $qDecoded  = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
    return( $qDecoded );
}
?>
