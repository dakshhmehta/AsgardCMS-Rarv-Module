<?php

namespace Modules\Rarv\Button\Repositories;

use Modules\Rarv\Button\Button;
use Modules\Rarv\Table\Table;

class ExportButton extends Button
{
    private $table;
    protected $label = 'Export';
    protected $icon  = 'fa fa-download';
    protected $color = 'info';

    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    public function getUrl($object = null)
    {
        $query = array_merge(request()->all(), ['export' => 'yes']);
        return route('admin.' . $this->table->getModule() . '.index', $query);
    }
}
