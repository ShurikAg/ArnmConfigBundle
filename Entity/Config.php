<?php
namespace Arnm\ConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Arnm\ConfigBundle\Entity\Config
 *
 * @ORM\Table(name="config", uniqueConstraints={@ORM\UniqueConstraint(name="namespace_name_idx", columns={"namespace", "name"})})
 * @ORM\Entity(repositoryClass="Arnm\ConfigBundle\Entity\ConfigRepository")
 */
class Config
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string $value
     *
     * @ORM\Column(name="value", type="string", length=1000)
     */
    private $value;

    /**
     * @var string $namespace
     *
     * @ORM\Column(name="namespace", type="string", length=50)
     */
    private $namespace;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * 
     * @return Config
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set value
     *
     * @param string $value
     * 
     * @return Config
     */
    public function setValue($value)
    {
        $this->value = $value;
        
        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set namespace
     *
     * @param string $namespace
     * 
     * @return Config
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
        
        return $this;
    }

    /**
     * Get namespace
     *
     * @return string 
     */
    public function getNamespace()
    {
        return $this->namespace;
    }
}