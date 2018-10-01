<?php
namespace JOYAS\JoyasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="JOYAS\JoyasBundle\Entity\ClienteRepository")
 * @ORM\Table(name="cliente")
 */
class Cliente{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $razonSocial;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $cuit;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    protected $dni;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    protected $domiciliocomercial;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    protected $concepto;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $monto;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $telefono;
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $mail;

    /**
     * @ORM\Column(type="string", length=1)
     */
    protected $clienteProveedor='1';

	/**
	* @ORM\ManyToOne(targetEntity="CondicionIva", inversedBy="clientes")
	* @ORM\JoinColumn(name="condicioniva_id", referencedColumnName="id")
	*/
    protected $condicioniva;

	/**
	* @ORM\OneToMany(targetEntity="Factura", mappedBy="cliente")
	*/
	protected $facturas;

	/**
	* @ORM\ManyToOne(targetEntity="Usuario", inversedBy="clientes")
	* @ORM\JoinColumn(name="usuario_id", referencedColumnName="id", nullable=false)
	*/
    protected $usuario;

    /**
     * @ORM\Column(type="string", length=1)
     */
    protected $estado = 'A';


    /**********************************
     * __construct
     *
     *
     **********************************/
	public function __construct()
	{
	}

	/**********************************
     * __toString()
     *
     * Este método sirve para poder popular los comboboxes en los forms.
     *********************************/
	 public function __toString()
	{
		return $this->getRazonSocial();
	}

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set razonSocial
     *
     * @param string $razonSocial
     * @return Cliente
     */
    public function setRazonSocial($razonSocial)
    {
        $this->razonSocial = $razonSocial;

        return $this;
    }

    /**
     * Get razonSocial
     *
     * @return string
     */
    public function getRazonSocial()
    {
        return $this->razonSocial;
    }

    /**
     * Set cuit
     *
     * @param string $cuit
     * @return Cliente
     */
    public function setCuit($cuit)
    {
        $this->cuit = $cuit;

        return $this;
    }

    /**
     * Get cuit
     *
     * @return string
     */
    public function getCuit()
    {
        return $this->cuit;
    }

    /**
     * Set dni
     *
     * @param string $dni
     * @return Cliente
     */
    public function setDni($dni)
    {
        $this->dni = $dni;

        return $this;
    }

    /**
     * Get dni
     *
     * @return string
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set domiciliocomercial
     *
     * @param string $domiciliocomercial
     * @return Cliente
     */
    public function setDomiciliocomercial($domiciliocomercial)
    {
        $this->domiciliocomercial = $domiciliocomercial;

        return $this;
    }

    /**
     * Get domiciliocomercial
     *
     * @return string
     */
    public function getDomiciliocomercial()
    {
        return $this->domiciliocomercial;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Cliente
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set mail
     *
     * @param string $mail
     * @return Cliente
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set clienteProveedor
     *
     * @param string $clienteProveedor
     * @return Cliente
     */
    public function setClienteProveedor($clienteProveedor)
    {
        $this->clienteProveedor = $clienteProveedor;

        return $this;
    }

    /**
     * Get clienteProveedor
     *
     * @return string
     */
    public function getClienteProveedor()
    {
        return $this->clienteProveedor;
    }

    /**
     * Set estado
     *
     * @param string $estado
     * @return Cliente
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set condicioniva
     *
     * @param \JOYAS\JoyasBundle\Entity\CondicionIva $condicioniva
     * @return Cliente
     */
    public function setCondicioniva(\JOYAS\JoyasBundle\Entity\CondicionIva $condicioniva = null)
    {
        $this->condicioniva = $condicioniva;

        return $this;
    }

    /**
     * Get condicioniva
     *
     * @return \JOYAS\JoyasBundle\Entity\CondicionIva
     */
    public function getCondicioniva()
    {
        return $this->condicioniva;
    }

    /**
     * Set concepto
     *
     * @param string $concepto
     * @return Cliente
     */
    public function setConcepto($concepto)
    {
        $this->concepto = $concepto;

        return $this;
    }

    /**
     * Get concepto
     *
     * @return string
     */
    public function getConcepto()
    {
        return $this->concepto;
    }

    /**
     * Set monto
     *
     * @param float $monto
     * @return Cliente
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;

        return $this;
    }

    /**
     * Get monto
     *
     * @return float
     */
    public function getMonto()
    {
        return $this->monto;
    }

    /**
     * Add facturas
     *
     * @param \JOYAS\JoyasBundle\Entity\Factura $facturas
     * @return Cliente
     */
    public function addFactura(\JOYAS\JoyasBundle\Entity\Factura $facturas)
    {
        $this->facturas[] = $facturas;

        return $this;
    }

    /**
     * Remove facturas
     *
     * @param \JOYAS\JoyasBundle\Entity\Factura $facturas
     */
    public function removeFactura(\JOYAS\JoyasBundle\Entity\Factura $facturas)
    {
        $this->facturas->removeElement($facturas);
    }

    /**
     * Get facturas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFacturas()
    {
        return $this->facturas;
    }

    /**
     * Set usuario
     *
     * @param \JOYAS\JoyasBundle\Entity\Usuario $usuario
     * @return Cliente
     */
    public function setUsuario(\JOYAS\JoyasBundle\Entity\Usuario $usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \JOYAS\JoyasBundle\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}