<?php
namespace Shopping\CartBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('categoryName', 'text', array(
                    'label' => 'Category Name','attr' => array(
                        'class' => 'form-control',
                        'name' =>'categoryname'))
                    )
                ->add('save', 'submit', array(
                    'label' => 'Add Category','attr' => array(
                        'class' => 'btn btn-primary'))
                     );
    }
    
    public function getName()
    {
        return 'productcategory';
    }
    
    


}