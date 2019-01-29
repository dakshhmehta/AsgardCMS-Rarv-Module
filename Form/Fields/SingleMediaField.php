<?php

namespace Modules\Rarv\Form\Fields;

use Illuminate\Support\ViewErrorBag;
use Modules\Media\Blade\Facades\MediaSingleDirective;
use Modules\Rarv\Form\Field;

class SingleMediaField extends Field
{
    protected $type = 'singleMedia';

    public function __construct($name)
    {
        parent::__construct($name, $this->type);
    }

    public function render()
    {
        $model = \Form::getModel();

        return MediaSingleDirective::show([$this->name, $model]);
    }

    public function getValue()
    {
        if (!$this->value) {
            $this->value = data_get(request()->get('medias_single', null), $this->getName());
        }

        return $this->value;
    }
}
