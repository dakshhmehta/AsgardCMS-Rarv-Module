<?php

namespace Modules\Rarv\Table;

class Table
{
    protected $repository;
    protected $columns = [];
    protected $module;

    public function __construct($module)
    {
        $this->module = $module;
    }

    public function setColumns(array $columns)
    {
        $this->columns = $columns;

        return $this;
    }

    public function addColumn($column)
    {
        $this->columns[] = $column;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @return mixed
     */
    public function getRepository()
    {
        if(is_string($this->repository)){
            $this->repository = app()->make($this->repository);
        }

        return $this->repository;
    }

    /**
     * @param mixed $repository
     *
     * @return self
     */
    public function setRepository($repository)
    {
        if(is_string($repository)){
            $repository = app()->make($repository);
        }

        $this->repository = $repository;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param mixed $module
     *
     * @return self
     */
    public function setModule($module)
    {
        $this->module = $module;

        return $this;
    }

    public function getRecords()
    {
        $records = $this->getRepository()->paginate();

        return $records;
    }
}
