<?php

namespace Proxies\__CG__\JOYAS\JoyasBundle\Entity;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class Usuario extends \JOYAS\JoyasBundle\Entity\Usuario implements \Doctrine\ORM\Proxy\Proxy
{
    private $_entityPersister;
    private $_identifier;
    public $__isInitialized__ = false;
    public function __construct($entityPersister, $identifier)
    {
        $this->_entityPersister = $entityPersister;
        $this->_identifier = $identifier;
    }
    /** @private */
    public function __load()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;

            if (method_exists($this, "__wakeup")) {
                // call this after __isInitialized__to avoid infinite recursion
                // but before loading to emulate what ClassMetadata::newInstance()
                // provides.
                $this->__wakeup();
            }

            if ($this->_entityPersister->load($this->_identifier, $this) === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            unset($this->_entityPersister, $this->_identifier);
        }
    }

    /** @private */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    
    public function __toString()
    {
        $this->__load();
        return parent::__toString();
    }

    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int) $this->_identifier["id"];
        }
        $this->__load();
        return parent::getId();
    }

    public function setLogin($login)
    {
        $this->__load();
        return parent::setLogin($login);
    }

    public function getLogin()
    {
        $this->__load();
        return parent::getLogin();
    }

    public function setClave($clave)
    {
        $this->__load();
        return parent::setClave($clave);
    }

    public function getClave()
    {
        $this->__load();
        return parent::getClave();
    }

    public function setMail($mail)
    {
        $this->__load();
        return parent::setMail($mail);
    }

    public function getMail()
    {
        $this->__load();
        return parent::getMail();
    }

    public function setEstado($estado)
    {
        $this->__load();
        return parent::setEstado($estado);
    }

    public function getEstado()
    {
        $this->__load();
        return parent::getEstado();
    }

    public function setPerfil($perfil)
    {
        $this->__load();
        return parent::setPerfil($perfil);
    }

    public function getPerfil()
    {
        $this->__load();
        return parent::getPerfil();
    }

    public function setCuit($cuit)
    {
        $this->__load();
        return parent::setCuit($cuit);
    }

    public function getCuit()
    {
        $this->__load();
        return parent::getCuit();
    }

    public function setIibb($iibb)
    {
        $this->__load();
        return parent::setIibb($iibb);
    }

    public function getIibb()
    {
        $this->__load();
        return parent::getIibb();
    }

    public function setCondicioniva($condicioniva)
    {
        $this->__load();
        return parent::setCondicioniva($condicioniva);
    }

    public function getCondicioniva()
    {
        $this->__load();
        return parent::getCondicioniva();
    }

    public function setFechainicio($fechainicio)
    {
        $this->__load();
        return parent::setFechainicio($fechainicio);
    }

    public function getFechainicio()
    {
        $this->__load();
        return parent::getFechainicio();
    }

    public function setRazonsocial($razonsocial)
    {
        $this->__load();
        return parent::setRazonsocial($razonsocial);
    }

    public function getRazonsocial()
    {
        $this->__load();
        return parent::getRazonsocial();
    }

    public function setDomicilio($domicilio)
    {
        $this->__load();
        return parent::setDomicilio($domicilio);
    }

    public function getDomicilio()
    {
        $this->__load();
        return parent::getDomicilio();
    }

    public function setImagen($imagen)
    {
        $this->__load();
        return parent::setImagen($imagen);
    }

    public function getImagen()
    {
        $this->__load();
        return parent::getImagen();
    }

    public function getImagenBlob()
    {
        $this->__load();
        return parent::getImagenBlob();
    }

    public function addPunto(\JOYAS\JoyasBundle\Entity\PuntoVenta $puntos)
    {
        $this->__load();
        return parent::addPunto($puntos);
    }

    public function removePunto(\JOYAS\JoyasBundle\Entity\PuntoVenta $puntos)
    {
        $this->__load();
        return parent::removePunto($puntos);
    }

    public function getPuntos()
    {
        $this->__load();
        return parent::getPuntos();
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'id', 'login', 'clave', 'perfil', 'mail', 'cuit', 'iibb', 'fechainicio', 'razonsocial', 'domicilio', 'imagen', 'estado', 'condicioniva', 'puntos');
    }

    public function __clone()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;
            $class = $this->_entityPersister->getClassMetadata();
            $original = $this->_entityPersister->load($this->_identifier);
            if ($original === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            foreach ($class->reflFields as $field => $reflProperty) {
                $reflProperty->setValue($this, $reflProperty->getValue($original));
            }
            unset($this->_entityPersister, $this->_identifier);
        }
        
    }
}