<?php
namespace Arnm\ConfigBundle\Manager;

use Arnm\ConfigBundle\Model\ConfigInterface;
/**
 * This is an interface for a config manager.
 *
 * Implementing classes are build to provide a functionality for managing configs.
 * Get, update, build etc...
 *
 * @author Alex Agulyansky <alex@iibspro.com>
 */
interface ConfigManagerInterface
{
    /**
     * Loads the data into the config object using it's namespace name
     *
     * @param ConfigInterface $config
     *
     * @return ConfigInterface
     */
    public function load(ConfigInterface $config);

    /**
     * Saves or updates the data for given config object
     *
     * @param ConfigInterface $config
     */
    public function save(ConfigInterface $config);
}
