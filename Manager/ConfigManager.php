<?php
namespace Arnm\ConfigBundle\Manager;

use Doctrine\Common\Util\Inflector;
use Arnm\ConfigBundle\Entity\Config;
use Arnm\ConfigBundle\Entity\ConfigRepository;
use Arnm\ConfigBundle\Model\ConfigInterface;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Arnm\ConfigBundle\Manager\ConfigManagerInterface;
/**
 * Implementation of a config manager
 *
 * @author Alex Agulyansky <alex@iibspro.com>
 */
class ConfigManager implements ConfigManagerInterface
{
    /**
     * Instance of Registry
     *
     * @var Registry
     */
    private $doctrine;

    /**
     * Instance of config repository
     *
     * @var ConfigRepository
     */
    private $configRepository;

    /**
     * Constructor
     *
     * @param Registry $doctrine
     */
    public function __construct(Registry $doctrine)
    {
        $this->setDoctrine($doctrine);
    }

    /**
     * Sets doctrine instance
     *
     * @param Registry $doctrine
     *
     * @return ConfigManager
     */
    public function setDoctrine(Registry $doctrine)
    {
        $this->doctrine = $doctrine;

        return $this;
    }

    /**
     * Gets an instance of dictrine
     *
     * @return Registry
     */
    public function getDoctrine()
    {
        return $this->doctrine;
    }

    /**
     * Gets entity manager
     *
     * @return Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->getDoctrine()->getEntityManager();
    }

    /**
     * Gets/resolves a config repository intance
     *
     * @return Arnm\ConfigBundle\Entity\ConfigRepository
     */
    protected function getConfigRepository()
    {
        if (is_null($this->configRepository)) {
            $this->configRepository = $this->getEntityManager()->getRepository('ArnmConfigBundle:Config');
        }

        return $this->configRepository;
    }

    /**
     * {@inheritdoc}
     * @see Arnm\ConfigBundle\Manager.ConfigManagerInterface::load()
     */
    public function load(ConfigInterface $config)
    {
        //get the namespace from the config object
        $namespace = $config->getNamespace();
        //get the data from DB for this namespace
        $list = $this->getConfigRepository()->findAllForNamespace($namespace);
        //get the list of available config fields for the given config object
        $fields = $config->getFieldsList();
        foreach ($list as $item) {
            $name = $item->getName();
            if (! in_array($name, $fields)) {
                throw new \RuntimeException("Field must be defined in a list of available fields in configuration object!");
            }
            $setterMethod = 'set' . Inflector::classify($name);
            $config->$setterMethod($item->getValue());
        }
    }

    /**
     * {@inheritdoc}
     * @see Arnm\ConfigBundle\Manager.ConfigManagerInterface::save()
     */
    public function save(ConfigInterface $config)
    {
        //get the namespace from the config object
        $namespace = $config->getNamespace();
        //get the data from DB for this namespace
        $list = $this->getConfigRepository()->findAllForNamespace($namespace);
        //get the list of available config fields for the given config object
        $fields = $config->getFieldsList();

        $eMgr = $this->getEntityManager();
        //do it in transaction
        $eMgr->getConnection()->beginTransaction();
        try {
            //go though the provided list of data in the config object
            //check if it exists already and update and create and object to be saved
            foreach ($fields as $fieldName) {
                //check if there is an element with such name
                $confObj = $this->findConfigObjectByName($fieldName, $list);
                if (! ($confObj instanceof Config)) {
                    $confObj = new Config();
                    $confObj->setNamespace($namespace);
                    $confObj->setName($fieldName);
                }

                //set the value
                $getterMethod = 'get' . Inflector::classify($fieldName);
                $confObj->setValue($config->$getterMethod());

                $eMgr->persist($confObj);
            }
            $eMgr->flush();
            $eMgr->getConnection()->commit();
        } catch (\Exception $exc) {
            $eMgr->getConnection()->rollback();
            throw $exc;
        }
    }

    /**
     * Finds a config object by it's name from provided list
     *
     * @param string $name Object name
     * @param array  $list List of available objects to search in
     *
     * @return Config
     */
    private function findConfigObjectByName($name, array $list = array())
    {
        if (empty($list)) {
            return null;
        }

        foreach ($list as $item) {
            if ($item instanceof Config && $item->getName() == ($name)) {
                return $item;
            }
        }

        return null;
    }
}