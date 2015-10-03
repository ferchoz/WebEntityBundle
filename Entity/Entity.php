<?php

namespace Ferchoz\WebEntityBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Entity
{
    /**
     * @var string
     */
    private $bundle;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \Ferchoz\WebEntityBundle\Entity\Field
     */
    private $fields;

    public function __construct()
    {
        $this->fields = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getBundle()
    {
        return $this->bundle;
    }

    /**
     * @param string $bundle
     */
    public function setBundle($bundle)
    {
        $this->bundle = $bundle;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return Field
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param Field $fields
     */
    public function addFields(Field $fields)
    {
        $this->fields[] = $fields;
    }

}