<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

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
        
        if (!($isDevMode = (APPLICATION_ENV == 'development'))) {
            $cache = new Doctrine\Common\Cache\ApcCache();
        }    
        
        $config = Setup::createAnnotationMetadataConfiguration(
            array($options['entities']), $isDevMode, $options['proxies'], isset($cache) ? $cache : null
        );    
        
        if (!$isDevMode) {            
            $config->setMetadataCacheImpl($cache);
            $config->setQueryCacheImpl($cache);
            $config->setAutoGenerateProxyClasses(false);
        }
                                
        $this->em = EntityManager::create($options['connection'], $config);
        
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
    
    /**
     * Gets the repository for an entity class.
     *
     * @param string $entityName The name of the entity.
     * @return EntityRepository The repository class.
     */
    public function getRepository($entityName)
    {
        return $this->getEntityManager()->getRepository($entityName);
    }
}