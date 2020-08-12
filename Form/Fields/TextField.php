<?php

namespace Modules\Rarv\Form\Fields;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Modules\Rarv\Form\Field;

class TextField extends Field {
    protected $model = null;

    public function __construct($name, Model $model = null, $parameters = [])
    {
        parent::__construct($name, 'text', $parameters);

        $this->model = $model;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getValue()
    {
        $this->value = parent::getValue();

        if($this->isTranslatable() and !$this->value and $this->model && $this->model->getAttribute($this->name)){
            $this->value = $this->model->translate($this->locale)->{$this->name};
        }

        return $this->value;
    }

    public function getView()
    {
        if($this->isTranslatable()){
            return 'rarv::partials.form.fields.translatable.text';
        }

        return 'rarv::partials.form.fields.text';
    }
}