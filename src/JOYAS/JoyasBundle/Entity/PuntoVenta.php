<?php
namespace JOYAS\JoyasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="JOYAS\JoyasBundle\Entity\PuntoVentaRepository")
 * @ORM\Table(name="puntoventa")
 */
class PuntoVenta{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $descripcion;

    /**
     * @ORM\Column(type="integer")
     */
    protected $numero;
	
	/**
	* @ORM\ManyToOne(targetEntity="Usuario", inversedBy="puntos")
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
		return $this->getNumero();	
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
     * @return CondicionIva
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
     * Set estado
     *
     * @param string $estado
     * @return CondicionIva
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
     * Set numero
     *
     * @param integer $numero
     * @return PuntoVenta
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    
        return $this;
    }

    /**
     * Get numero
     *
     * @return integer 
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set usuario
     *
     * @param \JOYAS\JoyasBundle\Entity\Usuario $usuario
     * @return PuntoVenta
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