<?php

namespace JOYAS\JoyasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsuarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('razonsocial','text', array ('label'=> 'Razón Social'))
            ->add('cuit')
            ->add('iibb','text', array ('label'=> 'Ingresos Brutos'))
            ->add('fechainicio', 'text', array ('attr'=> array('class'=>'datetimepicker')))
            ->add('domicilio')
            ->add('condicioniva', 'entity', array (
    			'class' => 'JOYASJoyasBundle:CondicionIva',
    			'label' => 'Condición IVA',
                'empty_value' => false,
    			'query_builder' => function (\JOYAS\JoyasBundle\Entity\CondicionIvaRepository $repository)
    				 {
    					 return $repository->createQueryBuilder('u')
                                    ->where('u.estado = ?1')->setParameter(1, 'A')
                                    ->orderBy('u.descripcion');
    				 }
    				))
            ->add('logo', 'file', array('label'=>'Logo', 'mapped'=>false, 'attr'=>array('accept'=>'image/*')))
            ->add('mail')
            ->add('login', 'text', array ('attr'=> array('pattern'=>'|^[a-zA-Z0-9]*$|', 'title'=>'Solo letras y numeros. Sin espacios ni caracteres especiales.')))
            ->add('clave')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JOYAS\JoyasBundle\Entity\Usuario'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'joyas_joyasbundle_usuario';
    }
}
