<?php

namespace Shopping\CartBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Shopping\CartBundle\Entity\ProductCategories;
use Symfony\Component\HttpFoundation\Request;
use Shopping\CartBundle\Form\Type\CategoryType;

class CategoryController extends Controller
{
    public function indexAction()
    {
    }
    
    
    public function addAction(Request $request)
    {
        
        $category = new ProductCategories();
        $form = $this->createForm(new CategoryType(), $category, array(
            'action' => $this->generateUrl('shopping_cart_addcategory'),
            'method' => 'POST'
        ));     
        
        if ($this->getRequest()->getMethod() == 'POST') {
            
            $form->bind($request);
            if ($form->isValid()) 
            {
                $entityManager = $this->getDoctrine()->getEntityManager();
                $entityManager->persist($category);
                $entityManager->flush();
            }
        }
       
        return $this->render('ShoppingCartBundle:Products:addCategory.html.twig', array(
            'form' => $form->createView(),
        ));
        
    }
    
   
}
