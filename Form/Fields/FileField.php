<?php

namespace Modules\Rarv\Form\Fields;

use Illuminate\Support\ViewErrorBag;
use Modules\Rarv\Form\Field;

class FileField extends Field
{
    protected $type = 'normalFile';

    public function __construct($name)
    {
        parent::__construct($name, $this->type);
    }

    public function getParameters()
    {
        $options = $this->parameters;

        return [
            $this->getName(), $this->getLabel(), session()->get('errors', new ViewErrorBag),
            $this->getValue(), $options
        ];
    }

    public function getValue()
    {
        if (! $this->value) {
            $value = new \stdClass;
            $value->{$this->getName()} = request()->file($this->getName());

            return $value;
        }

        return $this->value;
    }
}
