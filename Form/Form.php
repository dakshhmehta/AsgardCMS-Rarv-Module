<?php

namespace Modules\Rarv\Form;

class Form
{
	protected $module;
	protected $fields;

    public function __construct($module)
    {
    	$this->module = $module;

    	static::boot();
    }

    public function getModule()
    {
    	return $this->module;
    }

    public function setModule($module)
    {
    	$this->module = $module;

    	return $this;
    }

    public function setField($field, $type = null)
    {
    	if(! $field instanceof Field){
	    	$field = new Field($field, $type);
    	}

        $this->fields[$field->getName()] = $field;

        return $this;
    }

    public function getField($key)
    {
    	return $this->fields[$key];
    }

    /**
     * @return mixed
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param mixed $fields
     *
     * @return self
     */
    public function setFields($fields)
    {
        $this->fields = $fields;

        return $this;
    }

    public function boot()
    {
    	return true;
    }
}
