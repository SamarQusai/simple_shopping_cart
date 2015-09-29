<?php
namespace Shopping\CartBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class CartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('amount','integer', array(
                    'label' => 'Product Quantity','attr' => array(
                        ))
                    )
                ->add('submit', 'submit', array(
                    'label' => 'Add to cart','attr' => array(
                    'class' => 'btn btn-primary'))
                     );
    }
    
    public function getName()
    {
        return 'cart';
    }
    
//    public function getDefaultOptions(array $options)
//    {
//        return array(
//                'data_class' => 'Shopping\CartBundle\Entity\P',
//            );
//    }


}