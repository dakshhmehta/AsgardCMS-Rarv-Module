<?php

namespace Modules\Rarv\Form;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

        $this->form->boot();

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
            if ($field->isTranslatable()) {
                foreach (LaravelLocalization::getSupportedLocales() as $locale => $language) {
                    $data[$locale][$field->getName()] = $field->setLocale($locale)->getValue();
                }
            } else {
                $data[$field->getName()] = $field->getValue();
            }
        }

        if ($this->mode == 'create') {
            $model = $this->form->getRepository()->create($data);
        } else {
            if (! $this->form->getModel()) {
                throw new \Exception('No model set for the editing', -1);
            }

            $model = $this->form->getRepository()->update($this->form->getModel(), $data);
        }


        if ($model) {
            $this->form->setModel($model);
        }


        if (request()->ajax()) {
            return response()->json([
                'data' => $model,
                'success' => true,
                'message' => 'Model updated successfully',
            ]);
        }

        return redirect()->to($this->form->getRedirectUrl($this->mode));
    }

    public function prepareRoute()
    {
        return $this->form->getSubmitUrl($this->mode);
    }
}
