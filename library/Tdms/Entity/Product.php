<?php
namespace Tdms\Entity;

use Tdms\Entity\Category;

/**
 * @Entity(repositoryClass="Tdms\Repository\ProductRepository")
 * @Table(name="products")
 **/
class Product
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     **/
    protected $id;
    
    /**
     * @Column(type="string")
     **/
    protected $name;
    
    /**
     * @ManyToOne(targetEntity="Category")
     **/
    protected $category;

    /**
     * Gets id.
     * 
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Gets name.
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Sets name.
     * 
     * @param string $name Product name.
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * Gets category.
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }
    
    /**
     * Gets category.
     * 
     * @param Category $category Product category.
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;
    }
}