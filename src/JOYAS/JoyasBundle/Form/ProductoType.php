<?php

namespace JOYAS\JoyasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('categoriasubcategoria')
			->add('cliente')
            ->add('codigo', 'text', array ('label' => 'Codigo', 'attr'=> array('class'=>'form-control')))
            ->add('descripcion', 'text', array ('label' => 'Nombre', 'attr'=> array('class'=>'form-control')))
            ->add('stock', 'text', array ('label' => 'Stock', 'attr'=> array('class'=>'form-control','pattern'=>'[0-9]+([\.,][0-9]+)?','step'=>'0.01','title'=>'Se espera un numero de la forma 000000.00 o 000000,00')))
            ->add('precio', 'text', array ('label' => 'Costo', 'attr'=> array('class'=>'form-control','pattern'=>'[0-9]+([\.,][0-9]+)?','step'=>'0.01','title'=>'Se espera un numero de la forma 000000.00 o 000000,00')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JOYAS\JoyasBundle\Entity\Producto'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'joyas_joyasbundle_producto';
    }
}
