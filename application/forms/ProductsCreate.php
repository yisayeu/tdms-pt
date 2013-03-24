<?php
class Application_Form_ProductsCreate extends Zend_Form
{
	protected $categories = array();
	
	public function __construct($categories)
	{					
		// Convert categoreis entities collection into an array.
		foreach ($categories as $category) {
			$this->categories[$category->getId()] = $category->getName();
		}

		parent::__construct();
	}
	
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