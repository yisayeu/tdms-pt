<?php
/**
 * Filter products form.
 */
class Application_Form_ProductsFilter extends Zend_Form
{
    /**
     * @car \Tdms\Entity\Category[]
     */
    protected $categories = array();
    
    /**
     * Constructor.
     *
     * @param \Tdms\Entity\Category[] $categories Categories list.
     */
    public function __construct($categories)
    {                    
        // Convert categoreis entities collection into an array.
        foreach ($categories as $category) {
            $this->categories[$category->getId()] = $category->getName();
        }

        parent::__construct();
    }
    
    /**
     * Inits the form.
     */
    public function init()
    {                            
        $this->addElement('select', 'category', array(
            'required' => false,
            'multiOptions' =>  array('' => 'All') + $this->categories,
            'validators' => array(array('inArray', false, array('haystack' => array_keys($this->categories))))
        ));        
    }
}