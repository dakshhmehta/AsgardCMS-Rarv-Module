<?php

namespace Modules\Rarv\Button\Repositories;

use Modules\Rarv\Button\Button;
use Modules\Rarv\Table\Table;

class EditButton extends Button
{
    private $table;
    protected $label = 'Edit';
    protected $icon  = 'fa fa-edit';
    protected $color = 'primary';

    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    public function getUrl($object = null)
    {
        return route('admin.' . $this->table->getModule() . '.edit', $object->id);
    }
}
