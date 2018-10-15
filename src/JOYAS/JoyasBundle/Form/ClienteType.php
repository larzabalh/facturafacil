<?php

namespace JOYAS\JoyasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClienteType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('razonSocial', 'text', array('label' => $options['razonSocialLabel']))
            ->add('cuit')
            ->add('dni', 'integer', array('label' => 'Dni', 'attr'=>array('min' => '0')))
    		->add('condicioniva', 'entity', array (
    			'class' => 'JOYASJoyasBundle:CondicionIva',
    			'label' => $options['condicioniva'],
                'empty_value' => false,
    			'query_builder' => function (\JOYAS\JoyasBundle\Entity\CondicionIvaRepository $repository)
    				 {
    					 return $repository->createQueryBuilder('u')
                                    ->where('u.estado = ?1')->setParameter(1, 'A')
                                    ->orderBy('u.descripcion');
    				 }
    				))
            ->add('domiciliocomercial', 'text', array('label' => $options['direccionLabel']))
            ->add('concepto', 'text', array('label' => "Concepto"))
            ->add('monto', 'number', array('label' => "Monto", "attr"=>array("type"=>"number", "step"=>0.1)))
            ->add('telefono', 'text', array('label' => $options['telefonoLabel']))
            ->add('mail')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JOYAS\JoyasBundle\Entity\Cliente',
			'razonSocialLabel' =>  'Razón Social',
			'condicioniva' =>  'Condición IVA',
			'direccionLabel' =>  'Domicilio Comercial',
			'telefonoLabel' =>  'Teléfono',
			'numremito' =>  'Número de Remito'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'joyas_joyasbundle_cliente';
    }
}
