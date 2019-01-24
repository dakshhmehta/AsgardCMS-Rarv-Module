<?php

namespace Modules\Rarv\Button\Repositories;

use Modules\Rarv\Button\Button;
use Modules\Rarv\Table\Table;

class DeleteButton extends Button
{
    private $table;
    protected $label = 'Delete';
    protected $icon  = 'fa fa-trash';
    protected $color = 'danger';
    protected $object = null;

    public $weight = 100;

    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    public function getUrl($object = null)
    {
        $this->object = $object;

        return '#';
    }

    public function getAttributes()
    {
        return [
            'data-toggle' => 'modal',
            'data-target' => '#modal-delete-confirmation',
            'data-target-action' => route('admin.'.$this->table->getModule().'.destroy', [$this->object->id])
        ];
    }
}
