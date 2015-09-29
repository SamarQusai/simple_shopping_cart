<?php

namespace Shopping\CartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Orders
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Shopping\CartBundle\Entity\OrdersRepository")
 */
class Orders
{

    /**
     * @var integer
     *
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;
    
    /** 
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="Users", cascade={"persist"}, inversedBy="orderProducts") 
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false) 
     */
    private $userId;

    /** 
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="Products", cascade={"persist"}, inversedBy="orderProducts") 
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false) 
     */
    private $productId;

    
    
 

    /**
     * Set amount
     *
     * @param integer $amount
     *
     * @return Orders
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set userId
     *
     * @param \Shopping\CartBundle\Entity\Users $userId
     *
     * @return Orders
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return \Shopping\CartBundle\Entity\Users
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set productId
     *
     * @param \Shopping\CartBundle\Entity\Products $productId
     *
     * @return Orders
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * Get productId
     *
     * @return \Shopping\CartBundle\Entity\Products
     */
    public function getProductId()
    {
        return $this->productId;
    }
}
