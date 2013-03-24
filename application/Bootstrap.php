<?php
/**
 * Application main bootstrap class.
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	/**
	 * In addition to the parent constructor initializes a couple of used namespaces.
	 *
	 * @param Zend_Application $application Application instance.
	 */
	public function __construct($application)
	{
		parent::__construct($application);
		Zend_Loader_Autoloader::getInstance()->registerNamespace('Tdms');
	}
}