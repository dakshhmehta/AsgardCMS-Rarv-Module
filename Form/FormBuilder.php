<?php

namespace Modules\Rarv\Form;

class FormBuilder
{
    protected $mode = 'create';
    protected $form;

    public function getMode()
    {
        return $this->mode;
    }

    public function setMode($mode)
    {
        if (!in_array($mode, ['create', 'edit'])) {
            throw new \Exception('Invalid mode being set: ' . $mode, -1);
        }

        $this->mode = $mode;

        return $this;
    }

    public function setForm(Form $form)
    {
        $this->form = $form;

        return $this;
    }

    public function getForm()
    {
        return $this->form;
    }

    public function view()
    {
        if (!$this->form) {
            throw new \Exception('Form is not defined', -1);
        }

        if ($this->mode == 'edit' and !$this->form->getModel()) {
            throw new \Exception('Model not set for editing', -1);
        }

        $this->form->populateValues();

        $module = $this->form->getModule();
        $entity = $this->form->getEntity();

        $route = $this->form->getRoute();

        if (!$route) {
            $route = $this->prepareRoute();
        }

        $fields = $this->form->getFields();

        $model = $this->form->getModel();

        return view($this->form->viewPath($this), compact('module', 'entity', 'route', 'fields', 'model'));
    }

    public function handle()
    {
        if (!$this->form) {
            throw new \Exception('Form is not defined', -1);
        }

        if (!$this->form->validate()) {
            return redirect()->back()->withErrors($this->form->getErrors())->withInput();
        }

        $data = [];
        foreach ($this->form->getFields() as &$field) {
            $data[$field->getName()] = $field->getValue();
        }

        if ($this->mode == 'create') {
            $this->form->getRepository()->create($data);
        } else {
            if (! $this->form->getModel()) {
                throw new \Exception('No model set for the editing', -1);
            }
            
            $this->form->getRepository()->update($this->form->getModel(), $data);
        }

        $route = 'admin.' . $this->form->getModule() . '.' . $this->form->getEntity().'.index';
        return redirect()->route($route);
    }

    public function prepareRoute()
    {
        if ($this->mode == 'create') {
            return route('admin.' . $this->form->getModule() .'.'. $this->form->getEntity() . '.store');
        } else {
            return route('admin.' . $this->form->getModule() .'.'. $this->form->getEntity() . '.update', $this->form->getModel()->id); // @todo test case missing
        }
    }
}
