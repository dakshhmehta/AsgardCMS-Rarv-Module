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
    <div class="row hidden-print">
        <div class="col-xs-12">
            {!! $filterForm->view() !!}
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-xs-12">
            <div class="row hidden-print">
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
                    <div class="row hidden-print">
                        <div class="col-md-12 text-center">
                            {!! $records->appends(request()->all())->links() !!}
                        </div>
                    </div>

                    <form method="GET">
                        @if($isMassDeletable)
                        <input type="hidden" name="_action" value="doMassDelete" />
                        <button type="submit" class="btn btn-danger hidden-print"><i class="fa fa-trash"></i> Delete Selected</button><br/><br/>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    @if($isMassDeletable == true)
                                        <th><input type="checkbox" id="checkAll" /></th>
                                    @endif
                                    @foreach($headers as &$header)
                                        @if(strpos($header, '__index') !== false)
                                            <th>#</th>
                                        @else
                                            <th>{{ trans($header) }}</th>
                                        @endif
                                    @endforeach
                                    @if(count($links) > 0)
                                    <th class="hidden-print" data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (isset($records)) : ?>
                                    <?php foreach ($records as $i => $record) : ?>
                                <tr>
                                    @if($isMassDeletable == true)
                                        <td><input type="checkbox" class="delete" name="deleteId[]" value="{{ $record->id }}" /></td>
                                    @endif
                                    @foreach($columns as $column => $value)
                                    <td>
                                        @if($value == '__index')
                                        {{ $i + 1}}
                                        @elseif(is_string($value))
                                            {!! $record->{$value} !!}
                                            @else
                                            {!! transform($record, $value) !!}
                                        @endif
                                    </td>
                                    @endforeach
                                    @if(count($links) > 0)
                                    <td class="hidden-print">
                                        <div class="btn-group">
                                            @foreach($links as &$link)
                                            @can($link->getPolicy(), $record)
                                                <a href="{{ $link->getURL($record) }}" 
                                                    class="btn btn-{{ $link->getColor() }} btn-flat {{ $link->getClass() }}" 
                                                    {!! $link->getAttributesLine() !!}>
                                                    @if($link->getIcon() != '')
                                                    <i class="{{ $link->getIcon() }}"></i>
                                                    @endif
                                                    &nbsp;{{ $link->getLabel() }}
                                                </a>
                                            @endcan
                                            {{-- @cannot($link->getPolicy(), $record)
                                                @php $link->getURL($record) @endphp
                                                <a disabled="disabled" 
                                                    class="btn btn-{{ $link->getColor() }} btn-flat" 
                                                    {!! $link->getAttributesLine() !!}>
                                                    @if($link->getIcon() != '')
                                                    <i class="{{ $link->getIcon() }}"></i>
                                                    @endif
                                                    &nbsp;{{ $link->getLabel() }}
                                                </a>
                                            @endcannot --}}
                                            @endforeach
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    @if($isMassDeletable == true)
                                    <th></th>
                                    @endif
                                    @foreach($headers as &$header)
                                        @if(strpos($header, '__index') !== false)
                                            <th>#</th>
                                        @else
                                            <th>{{ trans($header) }}</th>
                                        @endif
                                    @endforeach
                                    @if(count($links) > 0)
                                    <th>{{ trans('core::core.table.actions') }}</th>
                                    @endif
                                </tr>
                                </tfoot>
                            </table>
                            <!-- /.box-body -->
                        </div>
                    </form>

                    <div class="row hidden-print">
                        <div class="col-md-12 text-center">
                            {!! $records->appends(request()->all())->links() !!}
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
    <script type="text/javascript">
        $(document).ready(function(){
            $("#checkAll").click(function(){
                $('input:checkbox.delete').not(this).prop('checked', this.checked);
            });
        });
    </script>
@stop
