<?php
/**
 * Products controller.
 */
class ProductsController extends Zend_Controller_Action
{
	/**
	 * @var Tdms_Application_Resource_Doctrine
	 */
	protected $doctrine;
    
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
    	$this->doctrine = $this->getInvokeArg('bootstrap')->getResource('doctrine');
    	
    	$this->cr = $this->doctrine->getRepository('Tdms\Entity\Category');
    	$this->pr = $this->doctrine->getRepository('Tdms\Entity\Product');
    }
    
    /**
     * Shows products list. 
     */
    public function indexAction()
    {			
    	$this->_helper->getHelper('AjaxContext')->addActionContext('index', 'html')->initContext('html');
    	
    	$productsFilterCriteria = array();
		
    	// Not sure that it's the proper way to instantiate a form in a controller, but ZF manual shows the following.
    	$form = new Application_Form_ProductsFilter($this->cr->findAll());
		
		$form->setAction($this->_helper->url('index', 'products'));
		
		if ($this->getRequest()->isPost() && !$this->_getParam('ignorePost')) {
			if ($form->isValid($this->getRequest()->getPost())) {
				if ($selectedCategory = $form->getValue('category')) {									
					$productsFilterCriteria['category'] = $this->cr->find($selectedCategory);
				}
			}
		}
		
		$products = $this->pr->findBy($productsFilterCriteria, array('id' => 'DESC'));
		
		$this->view->assign('products', $products);
		$this->view->assign('form', $form);
    }
    
    /**
     * Creates a products.
     */
    public function createAction()
    {     	    	    	    	
    	$this->_helper->getHelper('AjaxContext')->addActionContext('create', 'html')->initContext('html');
    	
    	// Not sure that it's the proper way to instantiate a form in a controller, but ZF manual shows the following.
    	$form = new Application_Form_ProductsCreate($this->cr->findAll());
    	
    	$form->setAction($this->_helper->url('create', 'products'));
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			$this->pr->createFromForm($form);    			    		
    			$this->_forward('index', null, null, array('ignorePost' => true));
    		}
    	}
    	
    	$this->view->assign('form', $form);
    }
    
    /**
     * Deletes a product.
     */
    public function deleteAction()
    {
		if (!($id = $this->_getParam('id'))) {
			throw new Zend_Controller_Exception('Wrong action argument');
		}
		
		$this->pr->remove($id);
		
		$this->_forward('index');
    }
    
    /**
     * Clears the product list.
     */
    public function clearAction()
    {
    	$this->pr->removeAll();
    	return $this->_helper->redirector('index');
    }
}