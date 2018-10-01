<?php
namespace JOYAS\JoyasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="JOYAS\JoyasBundle\Entity\UsuarioRepository")
 * @ORM\Table(name="usuario")
 * @UniqueEntity(
 *		fields = {"login", "mail"},
 *			message = "LOGIN o MAIL existentes, elija otro."
 *		)
 */
class Usuario{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $login;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $clave;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $perfil = 'EMPRESA';

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $mail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $cuit;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $iibb;

    /**
	* @ORM\ManyToOne(targetEntity="CondicionIva", inversedBy="usuarios")
	* @ORM\JoinColumn(name="condicioniva_id", referencedColumnName="id")
	*/
    protected $condicioniva;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $fechainicio;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $razonsocial;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $domicilio;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    protected $imagen;

	/**
	* @ORM\OneToMany(targetEntity="PuntoVenta", mappedBy="usuario" )
	*/
	protected $puntos;

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
		$this->puntos = new ArrayCollection();
	}

	/**********************************
     * __toString()
     *
     * Este método sirve para poder popular los comboboxes en los forms.
     *********************************/
	 public function __toString()
	{
		return $this->getLogin();
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
     * Set login
     *
     * @param string $login
     * @return Usuario
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set clave
     *
     * @param string $clave
     * @return Usuario
     */
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * Get clave
     *
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Set mail
     *
     * @param string $mail
     * @return Usuario
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
     * Set estado
     *
     * @param string $estado
     * @return Usuario
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
     * Set perfil
     *
     * @param string $perfil
     * @return Usuario
     */
    public function setPerfil($perfil)
    {
        $this->perfil = $perfil;

        return $this;
    }

    /**
     * Get perfil
     *
     * @return string
     */
    public function getPerfil()
    {
        return $this->perfil;
    }

    /**
     * Set cuit
     *
     * @param string $cuit
     * @return Usuario
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
     * Set iibb
     *
     * @param string $iibb
     * @return Usuario
     */
    public function setIibb($iibb)
    {
        $this->iibb = $iibb;

        return $this;
    }

    /**
     * Get iibb
     *
     * @return string
     */
    public function getIibb()
    {
        return $this->iibb;
    }

    /**
     * Set condicioniva
     *
     * @param string $condicioniva
     * @return Usuario
     */
    public function setCondicioniva($condicioniva)
    {
        $this->condicioniva = $condicioniva;

        return $this;
    }

    /**
     * Get condicioniva
     *
     * @return string
     */
    public function getCondicioniva()
    {
        return $this->condicioniva;
    }

    /**
     * Set fechainicio
     *
     * @param string $fechainicio
     * @return Usuario
     */
    public function setFechainicio($fechainicio)
    {
        $this->fechainicio = $fechainicio;

        return $this;
    }

    /**
     * Get fechainicio
     *
     * @return string
     */
    public function getFechainicio()
    {
        return $this->fechainicio;
    }

    /**
     * Set razonsocial
     *
     * @param string $razonsocial
     * @return Usuario
     */
    public function setRazonsocial($razonsocial)
    {
        $this->razonsocial = $razonsocial;

        return $this;
    }

    /**
     * Get razonsocial
     *
     * @return string
     */
    public function getRazonsocial()
    {
        return $this->razonsocial;
    }

    /**
     * Set domicilio
     *
     * @param string $domicilio
     * @return Usuario
     */
    public function setDomicilio($domicilio)
    {
        $this->domicilio = $domicilio;

        return $this;
    }

    /**
     * Get domicilio
     *
     * @return string
     */
    public function getDomicilio()
    {
        return $this->domicilio;
    }

    /**
     * Set imagen
     *
     * @param string $imagen
     * @return Usuario
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Get imagen
     *
     * @return string
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    public function getImagenBlob()
    {
        if(!empty($this->imagen)){
            return stream_get_contents( $this->imagen );
        }else{
            return "";
        }
    }

    /**
     * Add puntos
     *
     * @param \JOYAS\JoyasBundle\Entity\PuntoVenta $puntos
     * @return Usuario
     */
    public function addPunto(\JOYAS\JoyasBundle\Entity\PuntoVenta $puntos)
    {
        $this->puntos[] = $puntos;

        return $this;
    }

    /**
     * Remove puntos
     *
     * @param \JOYAS\JoyasBundle\Entity\PuntoVenta $puntos
     */
    public function removePunto(\JOYAS\JoyasBundle\Entity\PuntoVenta $puntos)
    {
        $this->puntos->removeElement($puntos);
    }

    /**
     * Get puntos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPuntos()
    {
        return $this->puntos;
    }
}
