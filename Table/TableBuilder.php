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

        $module  = $this->getModule();
        $entity  = $this->getEntity();
        $buttons = $this->table->getButtons();
        $columns = $this->table->getColumns();
        $records = $this->table->getRecords();
        $headers = $this->getHeaders();

        return view('rarv::table', compact('module', 'entity', 'records', 'headers', 'columns', 'buttons'));
    }

    public function getHeaders()
    {
        $columns = [];

        $module = $this->getModule();

        foreach ($this->table->getColumns() as &$column) {
            $columns[] = $module . '::' . $this->getEntity() . '.table.columns.' . $column;
        }

        return $columns;
    }

    public function getEntity()
    {
        $module = explode('.', $this->table->getModule());

        if (isset($module[1])) {
            return $module[1];
        }

        return str_plural($module);
    }

    public function getModule()
    {
        $module = explode('.', $this->table->getModule());

        return $module[0];
    }
}
