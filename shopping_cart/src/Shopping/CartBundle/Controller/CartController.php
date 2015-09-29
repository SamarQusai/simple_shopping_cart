<?php

namespace Shopping\CartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Shopping\CartBundle\Entity\Orders;
use Shopping\CartBundle\Entity\Products;
use Shopping\CartBundle\Entity\Users;
use Shopping\CartBundle\Form\Type\CartType;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Symfony\Component\HttpFoundation\Session\Session;

class CartController extends Controller {
    
    
//    public function __construct(EntityManager $entityManager) {
////        $entityManager = $this->getDoctrine()->getEntityManager();
//        $repository = $this->getDoctrine()->getRepository('ShoppingCartBundle:Products');
//        $result = $repository->ifIssetSession();
//        if($result == FALSE){
//            return $this->forward('ShoppingCartBundle:User:index');
//        }
//    }

    public function indexAction() {
       
        return $this->render('ShoppingCartBundle:Cart:cart.html.twig');
    }


    public function addAction(Request $request) {
        
        $entityManager = $this->getDoctrine()->getEntityManager();
        $repository = $this->getDoctrine()->getRepository('ShoppingCartBundle:Users');
        $orderRepository = $entityManager->getRepository('ShoppingCartBundle:Orders');
        $result = $repository->ifIssetSession();
        
        if($result == TRUE){
            if ($request->getMethod() == "POST") 
            {
                $productId = $request->get('productId');
                $amount = $request->get('amount');
                $userId = $repository->findOneByname();
                
                // Check if the items is already in user's cart or not
                $result = $orderRepository->isItemsExisted($productId, $userId);
                
                //if existed -- update quantity
                if($result == FALSE)
                {
                    //echo 'exist';
                    $orderRepository->updateQuantity($userId, $productId, $amount);
                    return $this->forward('ShoppingCartBundle:Cart:displayCartData');
                }
                // if not add item to cart
                else
                {
                    $product_id = $entityManager->getReference('Shopping\CartBundle\Entity\Products', $productId);
                    $user_id = $entityManager->getReference('Shopping\CartBundle\Entity\Users', $userId);

                    $order = new Orders();
                    $order->setAmount($amount);
                    $order->setUserId($user_id);
                    $order->setProductId($product_id);
                    $entityManager->persist($order);
                    $entityManager->flush();
                    return $this->forward('ShoppingCartBundle:Cart:displayCartData');
                }
            }
        }
        else
        {
            return $this->forward('ShoppingCartBundle:User:index');
        }
    }

    
    public function displayCartDataAction()
    {
        $entityManager = $this->getDoctrine()->getEntityManager();
        $repository = $entityManager->getRepository('ShoppingCartBundle:Users');
        $result = $repository->ifIssetSession();
        if($result == TRUE){
            $userid = $repository->findOneByname();

            $Repository = $entityManager->getRepository('ShoppingCartBundle:Orders');
            $data = $Repository->findAllCartDataForUser($userid);

            return $this->render('ShoppingCartBundle:Cart:cart.html.twig', array(
                            'cartdata' => $data,
            ));
        }
        else
        {
            return $this->forward('ShoppingCartBundle:User:index');
        }
    }

    
    
    public function deleteItemAction($pid) 
    {
        $entityManager = $this->getDoctrine()->getEntityManager();
        $repository = $entityManager->getRepository('ShoppingCartBundle:Users');
        $result = $repository->ifIssetSession();
        if($result == TRUE){
            $userid = $repository->findOneByname();

            $repository1 = $entityManager->getRepository('ShoppingCartBundle:Orders');
            $repository1->removeCartItem($pid,$userid);

            return $this->forward('ShoppingCartBundle:Cart:displayCartData');
        }
        else
        {
            return $this->forward('ShoppingCartBundle:User:index');
        }
    }

    
    
    
    public function deleteAllItemsAction()
    {
        $entityManager = $this->getDoctrine()->getEntityManager();
        
        $repository = $entityManager->getRepository('ShoppingCartBundle:Users');
        $result = $repository->ifIssetSession();
        if($result == TRUE){
            $userid = $repository->findOneByname();

            $repository1 = $entityManager->getRepository('ShoppingCartBundle:Orders');
            $repository1->RemoveAllCartItems($userid);

            return $this->forward('ShoppingCartBundle:Cart:displayCartData');
        }
        else
        {
            return $this->forward('ShoppingCartBundle:User:index');
        }
    }

    
    
    
    public function updateItemsAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getEntityManager();
        
        $quantity = $request->request->get('qty');
        $productid = $request->request->get('pid');
        
        $repository = $entityManager->getRepository('ShoppingCartBundle:Users');
        $result = $repository->ifIssetSession();
        if($result == TRUE){
            $userid = $repository->findOneByname();

            $repository1 = $entityManager->getRepository('ShoppingCartBundle:Orders');
            $repository1->updateCartItem($productid, $userid, $quantity);

            $repository2 = $entityManager->getRepository('ShoppingCartBundle:Orders');
            $data = $repository2->findAllCartDataForUser($userid);

            echo json_encode($data);
            exit();
        }
        else
        {
            return $this->forward('ShoppingCartBundle:User:index');
        }
    }
    
    
    
    public function showOrderSummaryAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getEntityManager();
        $repository = $entityManager->getRepository('ShoppingCartBundle:Users');

        $result = $repository->ifIssetSession();
        if($result == TRUE)
        {
            $total = $request->get('total');
            $userid = $repository->findOneByname();
            $user = $repository->find($userid);
            $creditLimit = $user->getUserCredit();
            
            if($creditLimit >= $total)
            {
                //1-user's new credit
                $Repository = $entityManager->getRepository('ShoppingCartBundle:Orders');
                
                $data = $Repository->findAllCartDataForUser($userid);
                $newCredit = $creditLimit - $total;
                return $this->render('ShoppingCartBundle:Cart:orderSummary.html.twig', array(
                                'cartdata' => $data,
                                'newCredit' => $newCredit
                ));
            }
            else
            {
                return $this->render('ShoppingCartBundle:Cart:creditLimitMessage.html.twig');
            }
        }
        else
        {
            return $this->forward('ShoppingCartBundle:User:index');
        }
    }

    
    
    public function confirmAnOrderAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('ShoppingCartBundle:Users');
        $result = $repository->ifIssetSession();
        if($result == TRUE)
        {
            //1-Update user's credit
            $userid = $repository->findOneByname();
            $newCredit = $request->get('newCredit');
            $repository->updateCreditLimit($newCredit, $userid);
            
            //2-Update product's quantity
            $productRepository = $this->getDoctrine()->getRepository('ShoppingCartBundle:Products');
            $orderRepository = $this->getDoctrine()->getRepository('ShoppingCartBundle:Orders');
            $productInfo = $orderRepository->findAllCartDataForUser($userid);

            for( $i = 0; $i < count($productInfo); $i++ )
            {                
                $originalQuantity = $productInfo[$i]['productQuantity'];
                $orderAmount = $productInfo[$i]['amount'];
                $updatedQuantity = $originalQuantity - $orderAmount;
                $productId = $productInfo[$i]['id'];
                $productRepository->updateProductQuantity($updatedQuantity, $productId);               
            }
            
            //3-Delete all items of cart
                $orderRepository->RemoveAllCartItems($userid);
                return $this->render('ShoppingCartBundle:Cart:confirmationMessage.html.twig');
        }
        else
        {
            return $this->forward('ShoppingCartBundle:User:index');
        }
        
    }

}
