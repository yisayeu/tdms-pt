<?php
/**
 * Products controller.
 */
class ProductsController extends Zend_Controller_Action
{
    /**
     * @var \Tdms\Repository\CategoryRepository
     */
	protected $cr;
	
	/**
	 * @var \Tdms\Repository\ProductRepository
	 */
	protected $pr;
	
	/**
	 * Inits controller.
	 */
	public function init()
    {
    	$doctrine = $this->getInvokeArg('bootstrap')->getResource('doctrine');
    	
    	$this->cr = $doctrine->getRepository('Tdms\Entity\Category');
    	$this->pr = $doctrine->getRepository('Tdms\Entity\Product');
    }
    
    /**
     * Shows products list. 
     */
    public function indexAction()
    {			
		$productsFilterCriteria = array();
		
		$form = new Application_Form_ProductsFilter($this->cr->findAll());
		
		if ($this->getRequest()->isPost()) {
			if ($form->isValid($this->getRequest()->getPost())) {
				if ($selectedCategory = $form->getValue('category')) {
					$productsFilterCriteria['category'] = $this->cr->find($selectedCategory);
				}
			}
		}
		
		$products = $this->pr->findBy($productsFilterCriteria, array('id' => 'DESC'), 15);
		
		$this->view->assign('products', $products);
		$this->view->assign('form', $form);
    }
    
    /**
     * Creates a products.
     */
    public function createAction()
    {     	    	
    	$form = new Application_Form_ProductsCreate($this->cr->findAll());
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			$this->pr->createFromForm($form);
    			$this->_helper->redirector('index');
    		}
    	}
    	
    	$this->view->assign('form', $form);
    }
}