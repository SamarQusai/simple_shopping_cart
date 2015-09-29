<?php

namespace Shopping\CartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Products
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Shopping\CartBundle\Entity\ProductsRepository")
 */
class Products
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="product_name", type="string", length=300)
     */
    private $productName;

    /**
     * @var integer
     *
     * @ORM\Column(name="product_price", type="integer")
     */
    private $productPrice;

    /**
     * @var integer
     *
     * @ORM\Column(name="product_quantity", type="integer")
     */
    private $productQuantity;

    /**
     * @var string
     *
     * @ORM\Column(name="product_image", type="string", length=500)
     */
    private $productImage;

    /**
     * @var string
     *
     * @ORM\Column(name="product_description", type="string", length=700)
     */
    private $productDescription;
    
    /**
     * @ORM\ManyToOne(targetEntity="ProductCategories", inversedBy="productCategory")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $categoryId;


    /** @ORM\OneToMany(targetEntity="Orders", mappedBy="productId") */
    private $orderProducts;
    
    
    public function addOrderProducts($orderProducts)
    {
        $orderProducts->setProductId($this);
        $this->orderProducts = $orderProducts;
    }
    
//    public function __toString() {
//    return $this->productDescription;
//}
    
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set productName
     *
     * @param string $productName
     *
     * @return Products
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;

        return $this;
    }

    /**
     * Get productName
     *
     * @return string
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * Set productPrice
     *
     * @param integer $productPrice
     *
     * @return Products
     */
    public function setProductPrice($productPrice)
    {
        $this->productPrice = $productPrice;

        return $this;
    }

    /**
     * Get productPrice
     *
     * @return integer
     */
    public function getProductPrice()
    {
        return $this->productPrice;
    }

    /**
     * Set productQuantity
     *
     * @param integer $productQuantity
     *
     * @return Products
     */
    public function setProductQuantity($productQuantity)
    {
        $this->productQuantity = $productQuantity;

        return $this;
    }

    /**
     * Get productQuantity
     *
     * @return integer
     */
    public function getProductQuantity()
    {
        return $this->productQuantity;
    }

    /**
     * Set productImage
     *
     * @param string $productImage
     *
     * @return Products
     */
    public function setProductImage($productImage)
    {
        $this->productImage = $productImage;

        return $this;
    }

    /**
     * Get productImage
     *
     * @return string
     */
    public function getProductImage()
    {
        return $this->productImage;
    }

    /**
     * Set productDescription
     *
     * @param string $productDescription
     *
     * @return Products
     */
    public function setProductDescription($productDescription)
    {
        $this->productDescription = $productDescription;

        return $this;
    }

    /**
     * Get productDescription
     *
     * @return string
     */
    public function getProductDescription()
    {
        return $this->productDescription;
    }
    
    /**
     * Set categoryId
     *
     * @param integer $categoryId
     *
     * @return Products
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * Get categoryId
     *
     * @return integer
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    
    
}
