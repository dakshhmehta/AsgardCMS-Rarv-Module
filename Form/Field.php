<?php

namespace Modules\Rarv\Form;

class Field
{
    private $name;
    private $type;
    private $parameters;

    public function __construct($name, $type, $parameters = [])
    {
        $this->name = $name;
        $this->type = $type;
        $this->parameters = $parameters;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     *
     * @return self
     */
    public function setType($type)
    {
        $validTypes = [
            'i18nInput', 'i18nInputOfType', 'i18nTextarea', 'i18nCheckbox', 'i18nSelect',
            'i18nFile', 'normalInput', 'normalInputOfType', 'normalTextarea', 'normalCheckbox',
            'normalSelect', 'normalFile',
        ];

        if(! in_array($type, $validTypes)){
            throw new \Exception('Invalid field type given', -1);            
        }

        $this->type = $type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param mixed $parameters
     *
     * @return self
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }
}
