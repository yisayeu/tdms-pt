<?php
namespace Tdms\Entity;

/**
 * @Entity(repositoryClass="Tdms\Repository\CategoryRepository")
 * @Table(name="categories")
 **/
class Category
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
}