<?php

namespace JOYAS\JoyasBundle\Services;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\DependencyInjection\Container;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;

class SessionManager
{
    /**
     *
     * @var Container
     */
    public $container;

    /**
     * @var EntityManager
     */
    public $em;

    /**
     * @var Session
     */
    public $session;

    public function __construct(Container $container){
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.entity_manager');
        $this->session = $container->get('session');
    }

    public function startSession(){
		$this->session->start();
		$this->setSession('login', false);
    }

    public function clearSession(){
        $this->session->clear();
        $this->session->getFlashBag()->clear();
    }

    public function closeSession(){
        $this->clearSession();
        $this->startSession();
    }

	public function login($login, $pass){
		$usuario = $this->em->getRepository('JOYASJoyasBundle:Usuario')->findOneBy(array('login' => $login, 'clave'=>$pass, 'estado'=>'A'));
		if ($usuario){
			$this->setSession('login', true);
			$this->setSession('usuario', $usuario);
			return true;
		}else{
			$this->addFlash('msgError','Usuario o clave incorrecto. Vuelva a intentar.');
		}

    	return false;
	}

	/**
    * Agrega un mensaje de tipo msgType a la siguiente response.
    * msgType validos: msgOk, msgInfo, msgWarn, msgError.
    * @param string $msgType
    * @param string $msg
    */
    public function addFlash($msgType, $msg){
        $this->session->getFlashBag()->add($msgType, $msg);
    }

    /**
     * Setea un parametro en la sesion
     * @param string $attr
     * @param string $value
     * @return mixed
     */
    public function setSession($attr, $value){
        $this->session->set($attr, $value);
    }

   /**
     * Devuelve un valor de la sesion
     * @param string $attr
     * @return mixed
     */
    public function getSession($attr){
        return $this->session->get($attr);
    }

    public function isLogged(){
        return !empty($this->getSession('login')) ? $this->getSession('login') : false;
    }

	public function decryptIt( $q ) {
		$cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
		$qDecoded  = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
		return( $qDecoded );
	}

    public function encryptIt( $q ) {
    	$cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
    	$qEncoded = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
    	return( $qEncoded );
    }
}
