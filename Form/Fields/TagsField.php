<?php

namespace Modules\Rarv\Form\Fields;

use Modules\Rarv\Form\Field;

class TagsField extends Field
{
    protected $type = 'tags';
    protected $name = 'tags';
    public $namespace = null;

    public function __construct()
    {
        
    }

    public function getView()
    {
        if ($this->namespace == null) {
            throw new \Exception("Set a namespace on a TagsField, use setNamespace method.", -1);
        }

        return 'rarv::fields.tags';
    }

    public function setNamespace(string $namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    public function setValue($value, $entity = null)
    {
        $this->value = $entity;

        return $this;
    }
}
