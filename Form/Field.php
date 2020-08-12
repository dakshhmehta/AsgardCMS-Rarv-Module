<?php

namespace Modules\Rarv\Form;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ViewErrorBag;

class Field
{
    protected $name;
    protected $type;
    protected $label;
    protected $parameters;

    protected $rules = [];
    protected $value;

    protected $column = 12;

    protected $permission = true;

    protected $view = null;

    protected $translatable = false;
    protected $locale = 'en';

    public function __construct($name, $type, $parameters = [])
    {
        $this->name = $name;
        $this->setType($type);

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

    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    public function getView()
    {
        return $this->view;
    }

    public function render($locale = null)
    {
        $this->locale = $locale;
        if ($this->getView()) {
            return view($this->getView(), ['field' => $this, 'locale' => $locale]);
        }

        $builder = app('form');

        $errors = session()->get('errors', new ViewErrorBag);

        $parameters = [
            $this->name,
            $this->label,
            'errors' => $errors,
        ];

        $parameters[] = '';

        if (in_array('required', $this->rules) && in_array($this->type, ['textGroup', 'textareaGroup'])) {
            $parameters[]['required'] = 'required';
        }

        if (count($this->getParameters()) > 0) {
            $parameters = $this->getParameters();
        }

        try {
            $html = $builder->macroCall($this->type, $parameters);
        } catch (\Exception $e) {
            Log::error($e);
            // Its macro
            $html = $builder->componentCall($this->type, $parameters);
        }

        return $html;
    }

    /**
     * @return array
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @param array $rules
     *
     * @return self
     */
    public function setRules(array $rules)
    {
        $this->rules = $rules;

        return $this;
    }

    public function setValue($value, $entity = null)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        if (!$this->value) {
            $this->value = request()->get($this->name, null);
        }

        return $this->value;
    }

    public function validate()
    {
        $validator = app('validator')->make([
            $this->name => $this->getValue(),
        ], [
            $this->name => $this->rules,
        ]);

        return $validator->passes();

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     *
     * @return self
     */
    public function setLabel(string $label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * @param mixed $column
     *
     * @return self
     */
    public function setColumn($column)
    {
        if ($column >= 1 and $column <= 12) {
            $this->column = $column;
            return $this;
        }

        throw new \Exception('Invalid column set for "' . $this->label . '" field', -1);
    }

    public function permission($permission)
    {
        $this->permission = value($permission);

        if ($this->permission !== true and $this->permission !== false) {
            throw new \Exception('Permission must return a boolean value', -1);
        }

        return $this;
    }

    public function hasPermission()
    {
        return $this->permission;
    }

    public function filter(Builder $query)
    {
        if ($this->getValue() !== null) {
            $query->where($this->getName(), 'LIKE', '%' . $this->getValue() . '%');
        }
    }

    public function setTranslatable($translatable = true)
    {
        $this->translatable = $translatable;

        return $this;
    }

    public function isTranslatable()
    {
        return $this->translatable;
    }

    public function setLocale($l)
    {
        $this->locale = $l;

        return $this;
    }

    public function getLocale()
    {
        return $this->locale;
    }
}
