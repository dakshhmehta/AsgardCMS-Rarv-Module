<?php

namespace Modules\Rarv\Button\Repositories;

use Modules\Rarv\Button\Button;
use Modules\Rarv\Table\Table;

class CreateButton extends Button
{
    private $table;
    protected $label = 'Add';
    protected $icon = 'fa fa-plus';
    protected $color = 'success';

    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    

    public function getUrl()
    {
        return route('admin.'.$this->table->getModule().'.create');
    }
}
