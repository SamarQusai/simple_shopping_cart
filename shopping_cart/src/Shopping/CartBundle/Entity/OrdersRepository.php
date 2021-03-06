<?php

namespace Shopping\CartBundle\Entity;

/**
 * OrdersRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OrdersRepository extends \Doctrine\ORM\EntityRepository
{
    public function removeCartItem($pid, $uid)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('DELETE FROM Shopping\CartBundle\Entity\Orders o WHERE o.userId=:userId AND o.productId = :productId');
        $query->setParameter('userId', $uid);
        $query->setParameter('productId', $pid);
        $query->execute();
    }
    
    public function RemoveAllCartItems($uid)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('DELETE FROM Shopping\CartBundle\Entity\Orders o WHERE o.userId=:userId');
        $query->setParameter('userId', $uid);
        $query->execute();
        return TRUE;
    }

    public function findAllCartDataForUser($userid)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
            SELECT DISTINCT o.amount,u.id,p.id,p.productName,p.productPrice,p.productQuantity
            FROM Shopping\CartBundle\Entity\Orders o
            JOIN Shopping\CartBundle\Entity\Users u WITH o.userId = u.id
            JOIN Shopping\CartBundle\Entity\Products p WITH o.productId = p.id
            WHERE o.userId = :userId
        ');
        $query->setParameter('userId', $userid);
        $data = $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        return $data;
    }
        
    public function updateCartItem($productid, $userid, $quantity)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('UPDATE Shopping\CartBundle\Entity\Orders o SET o.amount = :amount WHERE o.productId = :productId AND o.userId = :userId ');
        $query->setParameter('productId', $productid);
        $query->setParameter('userId', $userid);
        $query->setParameter('amount', $quantity);
        $query->execute();
    }
    
    public function isItemsExisted($productid, $userid)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('SELECT o FROM Shopping\CartBundle\Entity\Orders o WHERE o.productId = :productId AND o.userId = :userId ');
        $query->setParameter('productId', $productid);
        $query->setParameter('userId', $userid);
        $query->execute();
        $data = $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        if(empty($data))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
        
    }
    
    public function updateQuantity($userid, $productid, $quantity)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('UPDATE Shopping\CartBundle\Entity\Orders o SET o.amount = o.amount+:amount WHERE o.productId = :productId AND o.userId = :userId ');
        $query->setParameter('productId', $productid);
        $query->setParameter('userId', $userid);
        $query->setParameter('amount', $quantity);
        $query->execute();
    }
    

}
