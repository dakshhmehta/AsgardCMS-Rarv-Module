{{-- TODO: Implement min, max --}}

@stack($name . '_input_start')

<div class="form-group {{ $col }} {{ isset($attributes['required']) ? 'required' : '' }} {{ $errors->has($name) ? 'has-error' : '' }}">
    {!! Form::label($name, $text, ['class' => 'control-label']) !!}

    <div class="{{ $icon == '' ? '' : 'input-group' }}">
        @if($icon != '')
        <div class="input-group-addon"><i class="fa fa-{{ $icon }}"></i></div>
        @endif

        <ri-datepicker type="{{ ((isset($attributes['type'])) ? $attributes['type'] : 'date') }}" name="{{ $name }}" placeholder="{{ $text }}" value="{{ $value }}" is_future="{{ isset($attributes['future']) ? true : false }}">
    </div>
    {!! $errors->first($name, '<p class="help-block">:message</p>') !!}
</div>

@stack($name . '_input_end')
