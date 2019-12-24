<?php

namespace Modules\Rarv\Form\Fields;

use Modules\Rarv\Form\Field;

class SelectField extends Field
{
    protected $type   = 'selectGroup';
    protected $choice = [];

    public function __construct($name, array $choice)
    {
        parent::__construct($name, $this->type);
        $this->choice = collect($choice);
    }

    public function getParameters()
    {
        $options = $this->parameters;
        $data    = $this->choice->toArray();

        if (in_array('required', $this->rules)) {
            $options['required'] = 'required';
        }

        // @todo need to pass error log session()->get('errors', new ViewErrorBag)
        return [
            $this->getName(), $this->getLabel(), (isset($options['icon']) ? $options['icon'] : ''), $data, $this->getValue(), $options,
        ];
    }

    /*public function getValue()
    {
        $value                     = new \stdClass;
        $value->{$this->getName()} = parent::getValue();

        return $value;
    }*/

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
