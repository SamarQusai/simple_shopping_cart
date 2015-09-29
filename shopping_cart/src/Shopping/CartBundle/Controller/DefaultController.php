<?php

namespace Shopping\CartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ShoppingCartBundle:Default:index.html.twig', array('name' => $name));
    }
   
}
