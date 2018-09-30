<?php

namespace Modules\Rarv\Table;

class TableBuilder
{
    protected $table;

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

        $module    = $this->table->getModule();
        $pageTitle = $module . '::' . str_plural($module) . '.title.' . str_plural($module);

        $columns = $this->table->getColumns();
        $records = $this->table->getRecords();
        $headers = $this->getHeaders();

        return view('rarv::table', compact('pageTitle', 'records', 'headers', 'columns'));
    }

    public function getHeaders()
    {
        $columns = [];

        $module = $this->table->getModule();

        foreach ($this->table->getColumns() as &$column) {
            $columns[] = $module . '::' . str_plural($module) . '.table.columns.' . $column;
        }

        return $columns;
    }
}
