<?php
/**
 * Products controller.
 */
class ProductsController extends Zend_Controller_Action
{
    public function init()
    {

    }

    public function indexAction()
    {
		$doctrine = $this->getInvokeArg('bootstrap')->getResource('doctrine');
    }
}