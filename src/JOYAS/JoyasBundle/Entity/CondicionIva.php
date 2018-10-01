<?php
namespace JOYAS\JoyasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JOYAS\JoyasBundle\Entity\TipoCosto;
use JOYAS\JoyasBundle\Entity\Ganancia;

/**
 * @ORM\Entity(repositoryClass="JOYAS\JoyasBundle\Entity\CondicionIvaRepository")
 * @ORM\Table(name="condicioniva")
 */
class CondicionIva{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $descripcion;

	/**
	* @ORM\OneToMany(targetEntity="Cliente", mappedBy="condicioniva")
	*/
	protected $clientes;

	/**
	* @ORM\OneToMany(targetEntity="Usuario", mappedBy="condicioniva")
	*/
	protected $usuarios;

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
		return $this->descripcion;
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
     * Add clientes
     *
     * @param \JOYAS\JoyasBundle\Entity\Cliente $clientes
     * @return CondicionIva
     */
    public function addCliente(\JOYAS\JoyasBundle\Entity\Cliente $clientes)
    {
        $this->clientes[] = $clientes;

        return $this;
    }

    /**
     * Remove clientes
     *
     * @param \JOYAS\JoyasBundle\Entity\Cliente $clientes
     */
    public function removeCliente(\JOYAS\JoyasBundle\Entity\Cliente $clientes)
    {
        $this->clientes->removeElement($clientes);
    }

    /**
     * Get clientes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClientes()
    {
        return $this->clientes;
    }
}
