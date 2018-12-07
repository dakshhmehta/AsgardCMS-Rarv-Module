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

        $module = $this->form->getModule();
        $entity = $this->form->getEntity();

        $route = $this->form->getRoute();

        if (!$route) {
            $route = $this->prepareRoute();
        }

        $fields = $this->form->getFields();

        return view('rarv::admin.' . $this->mode, compact('module', 'entity', 'route', 'fields'));
    }

    public function handle()
    {
        if (!$this->form) {
            throw new \Exception('Form is not defined', -1);
        }

        if (!$this->form->validate()) {
            return redirect()->back()->withErrors($this->form->getErrors())->withInput();
        }

        if ($this->mode == 'create') {
            $data = [];
            foreach ($this->form->getFields() as &$field) {
                $data[$field->getName()] = $field->getValue();
            }

            return $this->form->getRepository()->create($data);

            $route = 'admin.' . $this->form->getModule() . '.' . $this->form->getModule().'.index';
            return redirect()->route($route);
        }

        // @todo handle update

        return $this;
    }

    public function prepareRoute()
    {
        if ($this->mode == 'create') {
            return route('admin.' . $this->form->getModule() .'.'. $this->form->getEntity() . '.store');
        } else {
            return route('admin.' . $this->form->getModule() .'.'. $this->form->getEntity() . '.update'); // @todo test case missing
        }
    }
}
