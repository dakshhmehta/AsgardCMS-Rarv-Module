<?php

namespace Modules\Rarv\Form;

class Form
{
	protected $module;

    public function __construct($module)
    {
    	$this->module = $module;
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
}
