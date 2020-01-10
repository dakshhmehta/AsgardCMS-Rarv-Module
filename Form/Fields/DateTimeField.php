<?php

namespace Modules\Rarv\Form\Fields;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Modules\Rarv\Form\Field;

class DateTimeField extends Field
{
    public function __construct($name, $parameters = array())
    {
        parent::__construct($name, null, $parameters);

        $this->type = 'dateGroup';
    }

    public function getParameters()
    {
        $parameters = $this->parameters;

        return [
            $this->name,
            $this->label,
            'calendar',
            $parameters,
            $this->getValue(),
        ];
    }

    protected function type()
    {
        $parameters = $this->parameters;

        if (!isset($parameters['type'])) {
            return 'date';
        }

        return $parameters['type'];
    }

    public function getValue()
    {
        $type = $this->type();

        if ($type == 'daterangepicker') {
            $m = request()->get('m', null);
            $o = request()->get('o', null);

            if ($m != null and $o != null) {
                return $m . ',' . $o;
            }
        }

        return Carbon::parse(parent::getValue())->format('Y-m-d');
    }

    public function filter(Builder $query)
    {
        $name = $this->getName();

        $type = $this->type();

        if ($type == 'date') {
            if ($this->getValue() != null) {
                $query->where($name, '=', $this->getValue());
            }
        } elseif ($type == 'daterange') {
            $from = request()->get(substr($name, 0, 1), null);
            $to   = request()->get(substr($name, 1, 1), null);

            if ($from != null and $to != null) {
                $query->where(function ($q) use ($name, $from, $to) {
                    $q->where($name, '>=', $from)->where($name, '<=', $to);
                });
            }
        }
    }
}
