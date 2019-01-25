<?php namespace Modules\Rarv\Form;

use Illuminate\Database\Eloquent\Builder;
use Modules\Rarv\Form\Fields\SelectField;
use Modules\Rarv\Form\Form as BaseForm;
use Modules\Rarv\Table\Table;

class FilterForm extends BaseForm
{
    public function viewPath(FormBuilder $builder)
    {
        return 'rarv::admin.filter-form';
    }

    public function handle(Table $table, Builder $query)
    {
        if (count($this->getFields()) == 0) {
            return false;
        }

        foreach ($this->getFields() as &$field) {
            if ($field instanceof SelectField) {
                $value = $field->getValue()->{$field->getName()};
                if ($value) {
                    $query->whereIn($field->getName(), ((is_array($value)) ? $value : [$value]));
                }
                continue;
            }

            if ($field->getValue()) {
                $query->where($field->getName(), 'LIKE', '%' . $field->getValue() . '%');
            }
        }

        return $query;
    }
}
