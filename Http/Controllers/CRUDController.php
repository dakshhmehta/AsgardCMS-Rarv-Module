<?php

namespace Modules\Rarv\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Rarv\Form\FormBuilder;
use Modules\Rarv\Table\TableBuilder;

abstract class CRUDController extends AdminBaseController
{
    protected $createForm;
    protected $editForm;
    protected $table;

    public function __construct()
    {
        parent::__construct();

        $this->boot();
    }

    abstract public function boot();

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(TableBuilder $builder)
    {
        return $builder->setTable($this->table)->view();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(FormBuilder $builder)
    {
        return $builder->setForm($this->createForm)->view();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(FormBuilder $builder)
    {
        return $builder->setForm($this->createForm)->handle();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Model $model
     * @return Response
     */
    public function edit(Model $model, FormBuilder $builder)
    {
        $this->editForm->setModel($model);

        return $builder->setMode('edit')->setForm($this->editForm)->view();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Model $model
     * @return Response
     */
    public function update(Model $model, FormBuilder $builder)
    {
        $this->editForm->setModel($model);

        return $builder->setMode('edit')->setForm($this->editForm)->handle();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Model $couriercompany
     * @return Response
     */
    public function destroy(Model $model)
    {
        try {
            $model->delete();
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }

        return redirect()->back()
            ->withSuccess('Record successfully deleted.');
    }
}
