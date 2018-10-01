<?php
namespace JOYAS\JoyasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="JOYAS\JoyasBundle\Entity\ProductoFacturaRepository")
 * @ORM\Table(name="productofactura")
 */
class ProductoFactura{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

	/**
	* @ORM\ManyToOne(targetEntity="Producto", inversedBy="productosFactura")
	* @ORM\JoinColumn(name="producto_id", referencedColumnName="id", nullable=false)
	*/
    protected $producto;

	/**
	* @ORM\ManyToOne(targetEntity="Factura", inversedBy="productosFactura")
	* @ORM\JoinColumn(name="factura_id", referencedColumnName="id", nullable=false)
	*/
    protected $factura;

	/**
     * @ORM\Column(type="float")
     */
    protected $cantidad;

	/**
     * @ORM\Column(type="float")
     */
    protected $precio;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $descuento;

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
     * Set cantidad
     *
     * @param float $cantidad
     * @return ProductoFactura
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    
        return $this;
    }

    /**
     * Get cantidad
     *
     * @return float 
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set precio
     *
     * @param float $precio
     * @return ProductoFactura
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    
        return $this;
    }

    /**
     * Get precio
     *
     * @return float 
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set descuento
     *
     * @param float $descuento
     * @return ProductoFactura
     */
    public function setDescuento($descuento)
    {
        $this->descuento = $descuento;
    
        return $this;
    }

    /**
     * Get descuento
     *
     * @return float 
     */
    public function getDescuento()
    {
        return $this->descuento;
    }

    /**
     * Set estado
     *
     * @param string $estado
     * @return ProductoFactura
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
     * Set producto
     *
     * @param \JOYAS\JoyasBundle\Entity\Producto $producto
     * @return ProductoFactura
     */
    public function setProducto(\JOYAS\JoyasBundle\Entity\Producto $producto)
    {
        $this->producto = $producto;
    
        return $this;
    }

    /**
     * Get producto
     *
     * @return \JOYAS\JoyasBundle\Entity\Producto 
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * Set factura
     *
     * @param \JOYAS\JoyasBundle\Entity\Factura $factura
     * @return ProductoFactura
     */
    public function setFactura(\JOYAS\JoyasBundle\Entity\Factura $factura)
    {
        $this->factura = $factura;
    
        return $this;
    }

    /**
     * Get factura
     *
     * @return \JOYAS\JoyasBundle\Entity\Factura 
     */
    public function getFactura()
    {
        return $this->factura;
    }
}