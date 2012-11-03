<?php
namespace Arnm\ConfigBundle\Model;

use Arnm\ConfigBundle\Model\ConfigInterface;
/**
 * A base abstract implementation of ConfigInterface
 *
 * @author Alex Agulyansky <alex@iibspro.com>
 */
abstract class ConfigImpl implements ConfigInterface
{

    /**
     * {@inheritdoc}
     * @see Arnm\ConfigBundle\Model.ConfigInterface::getFieldsList()
     */
    public function getFieldsList()
    {
        return array_keys(get_object_vars($this));
    }
}
