<?php

namespace Shopping\CartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Shopping\CartBundle\Entity\Products;
use Shopping\CartBundle\Entity\ProductCategories;
use Symfony\Component\HttpFoundation\Request;
use Shopping\CartBundle\Form\Type\ProductType;

class ProductsController extends Controller
{
    
//     public function __construct() {
////        $entityManager = $this->getDoctrine()->getEntityManager();
//        $repository = $this->getDoctrine()->getRepository('ShoppingCartBundle:Products');
//        $result = $repository->ifIssetSession();
//        if($result == FALSE){
//            return $this->forward('ShoppingCartBundle:User:index');
//        }
//    }
    
    public function addAction(Request $request)
    {
        
        $product = new Products();
        $form = $this->createForm(new ProductType(), $product, array(
            'action' => $this->generateUrl('shopping_cart_addproduct'),
            'method' => 'POST'
        ));        
        $em = $this->getDoctrine()->getEntityManager();
        $repository = $em->getRepository('ShoppingCartBundle:ProductCategories');
        $categories = $repository->findAll();

        if ($this->getRequest()->getMethod() == 'POST') {
            $salePercentage = $request->get('percentage');
            $productPrice = $request->get('productPrice');

            if($salePercentage > 0)
            {
                $sale = $productPrice * $salePercentage/100;
                $productPrice = $productPrice - $sale;
            }

            $entityManager = $this->getDoctrine()->getEntityManager();
            $id = $request->get('categoryId');          
            $category = $entityManager->getReference('Shopping\CartBundle\Entity\ProductCategories', $id);

            $product = new Products();
       
            $product->setProductName($request->get('productName'));
            $product->setProductPrice($productPrice);
            $product->setProductQuantity($request->get('productQuantity'));
            $product->setProductImage('port05.jpg');
            $product->setProductDescription($request->get('productDescription'));
            $product->setCategoryId($category);
            $entityManager->persist($product);
            $entityManager->flush();
            return $this->forward('ShoppingCartBundle:Products:index');
//            }
        }
       
        return $this->render('ShoppingCartBundle:Products:add.html.twig', array(
            'form' => $form->createView(),
            'categories' => $categories

        ));
        
    }
    
    

    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('ShoppingCartBundle:Products');
        $products = $repository->findAllProductData();
        return $this->render('ShoppingCartBundle:Home:home.html.twig', array(
            'products' => $products
        ));
    }
    
    
    public function productdetailsAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('ShoppingCartBundle:Products');
        $product = $repository->find($id);
        return $this->render('ShoppingCartBundle:Home:product.html.twig', array(
            'product' => $product
        ));
    }
}
