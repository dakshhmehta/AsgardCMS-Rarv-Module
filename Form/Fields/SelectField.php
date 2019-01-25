<?php

namespace Modules\Rarv\Form\Fields;

use Illuminate\Support\ViewErrorBag;
use Modules\Rarv\Form\Field;

class SelectField extends Field
{
	protected $type = 'normalSelect';
	protected $choice = [];

	public function __construct($name, $choice)
    {
    	parent::__construct($name, $this->type);
    	$this->choice = $choice;
    }

    public function getParameters()
    {
    	$options = $this->parameters;

    	return [
    		$this->getName(), $this->getLabel(), session()->get('errors', new ViewErrorBag), $this->choice, $this->getValue(), $options
    	];
    }

    public function getValue()
    {
    	$value = new \stdClass;
    	$value->{$this->getName()} = parent::getValue();

    	return $value;
    }
}
