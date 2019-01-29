@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans($module.'::'.$entity.'.title.'.$entity) }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans($module.'::'.$entity.'.title.'.$entity) }}</li>
    </ol>
@stop

@section('content')
    @if($filterForm)
    <div class="row">
        <div class="col-xs-12">
            {!! $filterForm->view() !!}
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    @foreach($buttons as &$button)
                    <a href="{{ $button->getURL() }}" class="btn btn-{{ $button->getColor() }} btn-flat" style="padding: 4px 10px;" {!! $button->getAttributesLine() !!}>
                        @if($button->getIcon() != '')
                        <i class="{{ $button->getIcon() }}"></i>
                        @endif
                        &nbsp;{{ $button->getLabel() }}
                    </a>
                    @endforeach
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            {!! $records->links() !!}
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                @foreach($headers as &$header)
                                <th>{{ trans($header) }}</th>
                                @endforeach
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($records)) : ?>
                                <?php foreach ($records as $record) : ?>
                            <tr>
                                @foreach($columns as &$column)
                                <td>{!! $record->{$column} !!}</td>
                                @endforeach
                                <td>
                                    <div class="btn-group">
                                        @foreach($links as &$link)
                                        @can($link->getPolicy(), $record)
                                            <a href="{{ $link->getURL($record) }}" 
                                                class="btn btn-{{ $link->getColor() }} btn-flat" 
                                                {!! $link->getAttributesLine() !!}>
                                                @if($link->getIcon() != '')
                                                <i class="{{ $link->getIcon() }}"></i>
                                                @endif
                                                &nbsp;{{ $link->getLabel() }}
                                            </a>
                                        @endcan
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                @foreach($headers as &$header)
                                <th>{{ trans($header) }}</th>
                                @endforeach
                                <th>{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </tfoot>
                        </table>
                        <!-- /.box-body -->
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-center">
                            {!! $records->links() !!}
                        </div>
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    @include('core::partials.delete-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop