<?php

namespace Modules\Rarv\Table;

use Maatwebsite\Excel\Facades\Excel;
use Modules\Rarv\Form\FormBuilder;

class TableBuilder
{
    protected $table;
    protected $formBuilder;

    public function __construct()
    {
        $this->formBuilder = app(FormBuilder::class);
    }

    /**
     * @return mixed
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param mixed $table
     *
     * @return self
     */
    public function setTable(Table $table)
    {
        $this->table = $table;

        return $this;
    }

    public function view()
    {
        if (!$this->table) {
            throw new \Exception('Table not set', -1);
        }

        $headers = $this->table->getHeaders();
        $module  = $this->getModule();
        $entity  = $this->getEntity();

        if ($this->table->isExportable() && request()->get('export', 'no') == 'yes') {
            return Excel::download($this->table->toExportable(), $this->getEntity().time().'.xlsx');
        }

        $buttons = $this->table->getButtons();
        $links = $this->table->getLinks();
        $columns = $this->table->getColumns();
        $records = $this->table->getRecords();
        $filterForm = $this->table->getFilterForm();
        $isMassDeletable = $this->table->isMassDeletable();

        if ($filterForm) {
            $filterForm = $this->formBuilder->setForm($filterForm);
        }

        return view('rarv::table', compact(
            'module',
            'entity',
            'records',
            'headers',
            'columns',
            'buttons',
            'links',
            'filterForm',
            'isMassDeletable'
        ));
    }

    public function getEntity()
    {
        return $this->table->getEntity();
    }

    public function getModule()
    {
        $module = explode('.', $this->table->getModule());

        return $module[0];
    }
}
