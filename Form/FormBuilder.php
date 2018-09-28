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
        return $module . '::admin.' . str_plural($module) . '.' . $this->mode;
    }

    public function handle()
    {
        if (!$this->form) {
            throw new \Exception('Form is not defined', -1);
        }

        return $this;
    }
}
