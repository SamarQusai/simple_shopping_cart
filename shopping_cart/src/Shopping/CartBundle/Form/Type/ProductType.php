<?php
namespace Shopping\CartBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('productName', 'text', array(
                    'label' => 'Product Name','attr' => array(
                        'class' => 'form-control',
                        'name' =>'productname'))
                    )
                ->add('productPrice', 'integer', array(
                    'label' => 'Product Price','attr' => array(
                        'class' => 'form-control'))
                    )
                ->add('productQuantity','integer', array(
                    'label' => 'Product Quantity','attr' => array(
                        'class' => 'form-control'))
                    )
                ->add('productDescription','textarea', array(
                    'label' => 'Product Description','attr' => array(
                        'class' => 'form-control'))
                    )
//                ->add('productType','choice', array(
//                    'choices'  => array('0' => 'Normal', '1' => 'Sale'),
//                    'required' => false,
//                    'attr' => array(
//                        'class' => 'producttype'),
//                    'label' => 'Product Type',)
//                    )
                ->add('productImage','file',  array(
                    'label' => 'Product Image')
                    )
                ->add('save', 'submit', array(
                    'label' => 'Create Product','attr' => array(
                        'class' => 'btn btn-primary'))
                     );
    }
    
    public function getName()
    {
        return NULL;
    }
    
    public function getDefaultOptions(array $options)
    {
        return array(
                'data_class' => 'Shopping\CartBundle\Entity\Product',
            );
    }


}