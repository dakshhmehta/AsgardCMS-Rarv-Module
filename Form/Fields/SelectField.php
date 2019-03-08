<?php

namespace Modules\Rarv\Form\Fields;

use Illuminate\Support\ViewErrorBag;
use Modules\Rarv\Form\Field;

class SelectField extends Field
{
    protected $type = 'normalSelect';
    protected $choice = [];

    public function __construct($name, array $choice)
    {
        parent::__construct($name, $this->type);
        $this->choice = collect($choice);
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

    /**
     * @return mixed
     */
    public function getChoice()
    {
        return $this->choice;
    }

    /**
     * @param mixed $choice
     *
     * @return self
     */
    public function setChoice($choice)
    {
        $this->choice = collect($choice);

        return $this;
    }

    public function setDefault($default)
    {
        $this->choice->prepend($default, '');

        return $this;
    }
}
