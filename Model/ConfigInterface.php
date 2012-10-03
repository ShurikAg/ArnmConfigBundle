<?php
namespace Arnm\ConfigBundle\Model;

/**
 * This interface defines the model for any config type of class.
 *
 * Config classes based on a single database table throughout the whole application.
 * Every config class is part of a specific namespace, which allows separation of configs.
 * For example: global config or config for a cpecific module.
 * The user of this class in responsible for providing the namespace.
 *
 * @author Alex Agulyansky <alex@iibspro.com>
 */
interface ConfigInterface
{
    /**
     * Gets the namespace of this config
     *
     * @return string
     */
    public function getNamespace();

    /**
     * Sets namespace of this class
     *
     * @param string $namespace
     */
    public function setNamespace($namespace);

    /**
     * Gets a list of fields defined for this namespace
     *
     * @return array
     */
    public function getFieldsList();
}
