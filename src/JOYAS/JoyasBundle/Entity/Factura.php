<?php
namespace JOYAS\JoyasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="JOYAS\JoyasBundle\Entity\FacturaRepository")
 * @ORM\Table(name="factura")
 */
class Factura{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

	/**
	 * @ORM\Column(type="datetime")
     */
    protected $fecha;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
     */
    protected $fechadesde;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
     */
    protected $fechahasta;

	/**
	* @ORM\OneToMany(targetEntity="ProductoFactura", mappedBy="factura", cascade={"persist", "remove"} )
	*/
	protected $productosFactura;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $importe;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $tipofactura;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $tipodocumento;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $cae;

    /**
	 * @ORM\Column(type="datetime", nullable=true)
     */
    protected $fechavtocae;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $codigobarraafip;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $nrofactura;

	/**
	* @ORM\ManyToOne(targetEntity="PuntoVenta", inversedBy="facturas")
	* @ORM\JoinColumn(name="punto_id", referencedColumnName="id", nullable=false)
	*/
    protected $punto;

	/**
	* @ORM\ManyToOne(targetEntity="Usuario", inversedBy="facturas")
	* @ORM\JoinColumn(name="usuario_id", referencedColumnName="id", nullable=false)
	*/
    protected $usuario;

    /**
     * @ORM\Column(type="string", length=2000, nullable=true)
     */
    protected $observacion;

	/**
	* @ORM\ManyToOne(targetEntity="Cliente", inversedBy="facturas")
	* @ORM\JoinColumn(name="cliente_id", referencedColumnName="id")
	*/
    protected $cliente;

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
		$this->productosFactura = new ArrayCollection();
	}


	/**********************************
     * __toString()
     *
     * Este método sirve para poder popular los comboboxes en los forms.
     *********************************/
	 public function __toString()
	{
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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Factura
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set importe
     *
     * @param float $importe
     * @return Factura
     */
    public function setImporte($importe)
    {
        $this->importe = $importe;

        return $this;
    }

    /**
     * Get importe
     *
     * @return float
     */
    public function getImporte()
    {
        return $this->importe;
    }

    /**
     * Set tipofactura
     *
     * @param string $tipofactura
     * @return Factura
     */
    public function setTipofactura($tipofactura)
    {
        $this->tipofactura = $tipofactura;

        return $this;
    }

    /**
     * Get tipofactura
     *
     * @return string
     */
    public function getTipofactura()
    {
        return $this->tipofactura;
    }


    /**
     * Set tipodocumento
     *
     * @param string $tipodocumento
     * @return Factura
     */
    public function setTipodocumento($tipodocumento)
    {
        $this->tipodocumento = $tipodocumento;

        return $this;
    }

    /**
     * Get tipodocumento
     *
     * @return string
     */
    public function getTipodocumento()
    {
        return $this->tipodocumento;
    }

    /**
     * Set cae
     *
     * @param string $cae
     * @return Factura
     */
    public function setCae($cae)
    {
        $this->cae = $cae;

        return $this;
    }

    /**
     * Get cae
     *
     * @return string
     */
    public function getCae()
    {
        return $this->cae;
    }

    /**
     * Set fechavtocae
     *
     * @param \DateTime $fechavtocae
     * @return Factura
     */
    public function setFechavtocae($fechavtocae)
    {
        $this->fechavtocae = $fechavtocae;

        return $this;
    }

    /**
     * Get fechavtocae
     *
     * @return \DateTime
     */
    public function getFechavtocae()
    {
        return $this->fechavtocae;
    }

    /**
     * Set codigobarraafip
     *
     * @param string $codigobarraafip
     * @return Factura
     */
    public function setCodigobarraafip($codigobarraafip)
    {
        $this->codigobarraafip = $codigobarraafip;

        return $this;
    }

    /**
     * Get codigobarraafip
     *
     * @return string
     */
    public function getCodigobarraafip()
    {
        return $this->codigobarraafip;
    }

    /**
     * Set nrofactura
     *
     * @param integer $nrofactura
     * @return Factura
     */
    public function setNrofactura($nrofactura)
    {
        $this->nrofactura = $nrofactura;

        return $this;
    }

    /**
     * Get nrofactura
     *
     * @return integer
     */
    public function getNrofactura()
    {
        return $this->nrofactura;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     * @return Factura
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Set estado
     *
     * @param string $estado
     * @return Factura
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
     * Add productosFactura
     *
     * @param \JOYAS\JoyasBundle\Entity\ProductoFactura $productosFactura
     * @return Factura
     */
    public function addProductosFactura(\JOYAS\JoyasBundle\Entity\ProductoFactura $productosFactura)
    {
        $this->productosFactura[] = $productosFactura;

        return $this;
    }

    /**
     * Remove productosFactura
     *
     * @param \JOYAS\JoyasBundle\Entity\ProductoFactura $productosFactura
     */
    public function removeProductosFactura(\JOYAS\JoyasBundle\Entity\ProductoFactura $productosFactura)
    {
        $this->productosFactura->removeElement($productosFactura);
    }

    /**
     * Get productosFactura
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductosFactura()
    {
        return $this->productosFactura;
    }

    /**
     * Set cliente
     *
     * @param \JOYAS\JoyasBundle\Entity\Cliente $cliente
     * @return Factura
     */
    public function setCliente(\JOYAS\JoyasBundle\Entity\Cliente $cliente = null)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return \JOYAS\JoyasBundle\Entity\Cliente
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set punto
     *
     * @param \JOYAS\JoyasBundle\Entity\PuntoVenta $punto
     * @return Factura
     */
    public function setPunto(\JOYAS\JoyasBundle\Entity\PuntoVenta $punto)
    {
        $this->punto = $punto;

        return $this;
    }

    /**
     * Get punto
     *
     * @return \JOYAS\JoyasBundle\Entity\PuntoVenta
     */
    public function getPunto()
    {
        return $this->punto;
    }

    /**
     * Set usuario
     *
     * @param \JOYAS\JoyasBundle\Entity\Usuario $usuario
     * @return Factura
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

    /**
     * Set fechadesde
     *
     * @param \DateTime $fechadesde
     * @return Factura
     */
    public function setFechadesde($fechadesde)
    {
        $this->fechadesde = $fechadesde;
    
        return $this;
    }

    /**
     * Get fechadesde
     *
     * @return \DateTime 
     */
    public function getFechadesde()
    {
        return $this->fechadesde;
    }

    /**
     * Set fechahasta
     *
     * @param \DateTime $fechahasta
     * @return Factura
     */
    public function setFechahasta($fechahasta)
    {
        $this->fechahasta = $fechahasta;
    
        return $this;
    }

    /**
     * Get fechahasta
     *
     * @return \DateTime 
     */
    public function getFechahasta()
    {
        return $this->fechahasta;
    }
}