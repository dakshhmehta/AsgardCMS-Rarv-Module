<?php

namespace Modules\Rarv\Form\Fields;

use Carbon\Carbon;
use Modules\Rarv\Form\Field;

class DateTimeField extends Field
{
    public function __construct($name, $parameters = array())
    {
        parent::__construct($name, null, $parameters);

        $this->type = 'datetime';
    }

    public function getParameters()
    {
        $parameters = $this->parameters;

        return [
            $this->name,
            $this->label,
            'clock',
            $this->getValue(),
            $parameters
        ];
    }

    public function getValue()
    {
        $value = parent::getValue();

        return Carbon::parse($value)->format('Y-m-d');
    }
}
