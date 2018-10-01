<?php
namespace JOYAS\JoyasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use	Symfony\Component\HttpFoundation\File\UploadedFile;														

/**
 * @ORM\Table(name="producto")
 * @ORM\Entity(repositoryClass="JOYAS\JoyasBundle\Entity\ProductoRepository")
 */
class Producto{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
	 * @Assert\NotBlank(
	 *       message = "Debe agregar una nombre."
	 *              )
     */
    protected $descripcion;

	/**
     * @ORM\Column(type="float", nullable=true)
	 * @Assert\NotBlank(
	 *       message = "Debe indicar el stock."
	 *              )
     */
    protected $stock;

	/**
	* @ORM\OneToMany(targetEntity="ProductoFactura", mappedBy="producto")
	*/
	protected $productosFactura;

	/**
     * @ORM\Column(type="float", nullable=true)
	 * @Assert\NotBlank(
	 *       message = "Debe agregar un costo."
	 *              )
     */
    protected $costo;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $codigo;

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
			return $this->getDescripcion().' - '.$this->getCodigo();
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Producto
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    
        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set stock
     *
     * @param float $stock
     * @return Producto
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
    
        return $this;
    }

    /**
     * Get stock
     *
     * @return float 
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set costo
     *
     * @param float $costo
     * @return Producto
     */
    public function setCosto($costo)
    {
        $this->costo = $costo;
    
        return $this;
    }

    /**
     * Get costo
     *
     * @return float 
     */
    public function getCosto()
    {
        return $this->costo;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     * @return Producto
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    
        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set estado
     *
     * @param string $estado
     * @return Producto
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
     * @return Producto
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
}