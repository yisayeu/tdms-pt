<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

/**
 * Doctrine resoruce.
 */
class Tdms_Application_Resource_Doctrine extends Zend_Application_Resource_ResourceAbstract
{
    /**
     * @var Doctrine\ORM\EntityManager
     */
	protected $em;
	
	/**
	 * Inits resource.
	 * 
	 * @return Tdms_Application_Resource_Doctrine
	 */
	public function init()
    {    	    
    	$options = $this->getBootstrap()->getOption('doctrine');
    	    	    	    	
    	$this->em = EntityManager::create(
    		$options['connection'],
    		Setup::createAnnotationMetadataConfiguration(array($options['entities']), true)
    	);
    	
    	return $this;
    }
    
    /**
     * Gets entity manager.
     * 
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
    	return $this->em;
    }
}