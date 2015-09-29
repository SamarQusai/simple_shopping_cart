<?php

namespace Shopping\CartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Shopping\CartBundle\Entity\Users;
use Symfony\Component\HttpFoundation\Session\Session;



class UserController extends Controller
{
    public function indexAction(Request $request)
    {
        if($request->getMethod()=="POST")
        {
            $username = $request->get('username');
            $password = md5($request->get('password'));
            
            $entityManager = $this->getDoctrine()->getEntityManager();
            $repository = $entityManager->getRepository('ShoppingCartBundle:Users');
            
            $user = $repository->findOneBy(array('userName' => $username, 'userPassword' => $password));
            if($user)
            {
                $session = new Session();
                $session->set('username', $username);
                
                return $this->forward('ShoppingCartBundle:Products:index');
            }
            else
            {
                return $this->render('ShoppingCartBundle:Users:login.html.twig', array(
                    'error' => 'Please check your name or password.'
                ));
            }
        }
        return $this->render('ShoppingCartBundle:Users:login.html.twig');
    }
    
    public function signupAction(Request $request)
    {
        if($request->getMethod()=="POST")
        {
            $username = $request->get('username');
            $password = md5($request->get('password'));
            $creditnumber = $request->get('creditlimit');
            
            $user = new Users();
            $user->setUserName($username);
            $user->setUserPassword($password);
            $user->setUserCredit($creditnumber);
            $entityManager = $this->getDoctrine()->getEntityManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->render('ShoppingCartBundle:Users:login.html.twig');
        }
        return $this->render('ShoppingCartBundle:Users:registeration.html.twig');

    }
    
    
    public function logoutAction()
    {
        $this->container->get('security.context')->setToken(null);
        return $this->render('ShoppingCartBundle:Users:login.html.twig');

    }
}
