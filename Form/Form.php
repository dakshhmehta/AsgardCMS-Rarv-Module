<?php

namespace Modules\Rarv\Form;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ViewErrorBag;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Rarv\Form\FormBuilder;

class Form
{
    protected $module;
    protected $fields = [];
    protected $route;
    protected $errors;
    protected $entity;
    protected $model = null;

    protected $repository;

    public function __construct($module, $model = null)
    {
        $this->module = $module;

        $this->errors = new ViewErrorBag;
        $this->model = $model;

        static::boot();
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
        return collect($this->fields)->filter(function ($field) {
            return $field->hasPermission();
        });
    }

    /**
     * @param mixed $fields
     *
     * @return self
     */
    public function setFields(array $fields)
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

        $defaultLocale = app()->getLocale();
        foreach ($this->getFields() as &$field) {
            if ($field->isTranslatable()) {
                foreach (LaravelLocalization::getSupportedLocales() as $locale => $language) {
                    $field->setLocale($locale);

                    $rules[$locale . '.' . $field->getName()] = $field->getRules();
                    $input[$locale][$field->getName()] = $field->getValue();
                }
                $field->setLocale($defaultLocale);
            } else {
                $rules[$field->getName()] = $field->getRules();
                $input[$field->getName()] = $field->getValue();
            }
        }
        $defaultLocale = app()->getLocale();
        
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

    public function getEntity()
    {
        $module = explode('.', $this->module);

        if (isset($module[1])) {
            return $module[1];
        }

        return \Str::plural($module[0]);
    }

    public function getModule()
    {
        $module = explode('.', $this->module);

        return $module[0];
    }

    public function setModel(Model $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    public function populateValues()
    {
        foreach ($this->fields as &$field) {
            if ($field->isTranslatable()) {
                if ($this->model && $this->model->getAttribute($field->getName())) {
                    // $field->setValue($this->model->translate($this->getLocale())->{$this->name};
                }
            }

            try {
                $value = $this->model->{$field->getName()};
                if ($value) {
                    $field->setValue($value, $this->model);
                }
            } catch (\Exception $e) {
                Log::warning('Unable to populate field value for ' . $field->getName());
                // We just pass if attribute not found.
            }
        }
    }

    public function viewPath(FormBuilder $builder)
    {
        return 'rarv::admin.' . $builder->getMode();
    }

    public function getAllFields()
    {
        return $this->fields;
    }

    public function getSubmitUrl($mode)
    {
        if ($mode != 'create' and $mode != 'edit') {
            throw new \Exception('Invalid mode set.', -1);
        }

        if ($mode == 'create') {
            return route('admin.' . $this->getModule() . '.' . $this->getEntity() . '.store');
        } else {
            return route('admin.' . $this->getModule() . '.' . $this->getEntity() . '.update', $this->getModel()->id); // @todo test case missing
        }
    }

    public function getRedirectUrl($mode)
    {
        return route('admin.' . $this->getModule() . '.' . $this->getEntity() . '.index');
    }
}
