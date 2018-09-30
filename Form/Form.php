<?php

namespace Modules\Rarv\Form;

use Illuminate\Support\ViewErrorBag;

class Form
{
    protected $module;
    protected $fields = [];
    protected $route;
    protected $errors;

    protected $repository;

    public function __construct($module)
    {
        $this->module = $module;

        $this->errors = new ViewErrorBag;

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
        if (!$field instanceof Field) {
            $field = new Field($field, $type);
        }

        $this->fields[$field->getName()] = $field;

        return $field;
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

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param mixed $route
     *
     * @return self
     */
    public function setRoute(string $route)
    {
        $this->route = $route;

        return $this;
    }

    public function validate()
    {
        $isValid = true;

        $rules = [];
        $input = [];

        if (count($this->getFields()) == 0) {
            return true;
        }

        foreach ($this->getFields() as &$field) {
            $rules[$field->getName()] = $field->getRules();
            $input[$field->getName()] = $field->getValue();
        }

        $validator = app('validator')->make($input, $rules);

        if ($validator->fails()) {
            $isValid      = false;
            $this->errors = $validator->errors();
        }

        return $isValid;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return BaseRepository
     */
    public function getRepository()
    {
        if (is_string($this->repository)) {
            $this->repository = app()->make($this->repository);
        }

        return $this->repository;
    }

    /**
     * @param BaseRepository $repository
     *
     * @return self
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;

        return $this;
    }
}
