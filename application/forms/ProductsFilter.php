<?php
class Application_Form_ProductsFilter extends Zend_Form
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
		$this->addElement('select', 'category', array(
			'required' => false,
			'multiOptions' =>  array('' => 'All') + $this->categories,
			'validators' => array(array('inArray', false, array('haystack' => array_keys($this->categories))))
		));

		$this->addElement('submit', 'submit');
	}
}