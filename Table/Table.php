<?php

namespace Modules\Rarv\Table;

use Modules\Rarv\Button\Button;
use Modules\Rarv\Button\Repositories\CreateButton;
use Modules\Rarv\Button\Repositories\DeleteButton;
use Modules\Rarv\Button\Repositories\EditButton;
use Modules\Rarv\Button\Repositories\ExportButton;

class Table
{
    protected $repository;
    protected $columns = [];
    protected $module;
    protected $buttons    = [];
    protected $links      = [];
    protected $filterForm = null;

    public $with = []; // Relationships to eagerload.

    protected $exportable = false;

    public $perPage = 25;

    protected $massDeletable = false;

    public function __construct($module)
    {
        $this->module = $module;

        $this->prepareButtons();
        $this->prepareLinks();

        if(request()->get('_action') == 'doMassDelete'){
            $this->performMassDeletion();
        }
    }
    
    protected function performMassDeletion(){
        $ids = request()->get('deleteId', []);

        if(count($ids) == 0){
            return redirect()->back()->withError('Select atleast 1 record for deletion.')->withInput();
        }

        $deleted = 0;
        foreach($ids as &$id){
            $model = $this->getRepository()->find($id);

            if($model){
                $this->getRepository()->destroy($model);
                $deleted++;
            }
        }

        if($deleted > 0){
            session()->flash('success', $deleted.' records deleted successfully.');
        }

        return true;
    }

    public function isExportable():bool
    {
        return $this->exportable;
    }

    protected function prepareButtons()
    {
        $this->addButton(new CreateButton($this));

        if ($this->isExportable()) {
            $this->addButton(new ExportButton($this));
        }
    }

    protected function prepareLinks()
    {
        $this->addLink(new EditButton($this));
        $this->addLink(new DeleteButton($this));
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
        if (is_string($this->repository)) {
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
        if (is_string($repository)) {
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

    public function getRecords($paginate = true)
    {
        $records = $this->getBuilder();

        if ($this->getFilterForm()) {
            $records = $this->getFilterForm()->handle($this, $records);
        }

        if ($paginate) {
            $records = $records->paginate($this->perPage);
        } else {
            $records = $records->get();
        }

        return $records;
    }

    public function setButtons(array $buttons)
    {
        foreach ($buttons as &$b) {
            if ($b instanceof Button) {
                $this->addButton($b);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getButtons()
    {
        return collect($this->buttons)
            ->filter(function ($button) {
                return $button->hasPermission();
            })
            ->sortBy('weight');
    }

    public function addButton(Button $button)
    {
        if (!in_array($button, $this->buttons)) {
            $this->buttons[] = $button;
        }

        return $this;
    }

    public function setLinks(array $links)
    {
        foreach ($links as &$b) {
            if ($b instanceof Button) {
                $this->addLink($b);
            }
        }

        return $this;
    }

    public function addLink(Button $link)
    {
        if (!in_array($link, $this->links)) {
            $this->links[] = $link;
        }

        return $this;
    }

    public function getLinks()
    {
        return collect($this->links)
            ->filter(function ($link) {
                return $link->hasPermission();
            })
            ->sortBy('weight');
    }

    public function setFilterForm($form)
    {
        if (is_string($form)) {
            $form = app()->make($form, ['module' => $this->getModule()]);
        }

        $this->filterForm = $form;

        return $this;
    }

    public function getFilterForm()
    {
        if (is_string($this->filterForm)) {
            $this->filterForm = app()->make($this->filterForm, ['module' => $this->getModule()]);
        }

        return $this->filterForm;
    }

    public function getBuilder()
    {
        return $this->getRepository()->allWithBuilder()->with($this->with);
    }

    public function toExportable():?ExportTable
    {
        if ($this->isExportable()) {
            throw new \Exception("Define a toExportable method in your Table class or turn off the export feature.");
        }

        return null;
    }

    public function setExportable($exportable)
    {
        $this->exportable = $exportable;

        $this->prepareButtons();

        return $this;
    }

    public function getHeaders()
    {
        $columns = [];

        $module = $this->getModule();
        $module = explode('.', $module)[0];

        foreach ($this->getColumns() as $column => $value) {
            $col = &$column;

            if (is_numeric($col)) {
                $col = $value;
            }

            $columns[] = $module . '::' . $this->getEntity() . '.table.columns.' . $col;
        }
        // dd($columns);

        return $columns;
    }

    public function getEntity()
    {
        $module = explode('.', $this->getModule());

        if (isset($module[1])) {
            return $module[1];
        }

        return str_plural($module[0]);
    }

    public function isMassDeletable()
    {
        return $this->massDeletable;
    }

    public function setMassDeletable(bool $deletable)
    {
        $this->massDeletable = $deletable;
        return $this;
    }
}
