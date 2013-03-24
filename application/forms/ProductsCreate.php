<?php
/**
 * Create product form.
 */
class Application_Form_ProductsCreate extends Zend_Form
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
		$this->setAttrib('id', 'ProductsCreate');
		
		$this->addElement('text', 'name', array('required' => true, 'label' => 'Name:'));
		
		$this->addElement('select', 'category', array(
			'label' => 'Category:',
			'required' => true,
			'multiOptions' => $this->categories,
			'validators' => array(array('inArray', false, array('haystack' => array_keys($this->categories))))
		));

		$this->addElement('submit', 'submit');
	}
}