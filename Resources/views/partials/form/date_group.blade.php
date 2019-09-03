{{-- TODO: Implement min, max --}}

@stack($name . '_input_start')

<div class="form-group {{ $col }} {{ isset($attributes['required']) ? 'required' : '' }} {{ $errors->has($name) ? 'has-error' : '' }}">
    {!! Form::label($name, $text, ['class' => 'control-label']) !!}
    <div class="input-group">
        <div class="input-group-addon"><i class="fa fa-{{ $icon }}"></i></div>
        <ri-datepicker type="date" name="{{ $name }}" placeholder="{{ $text }}" value="{{ $value }}">
            
        </ri-datepicker>
    </div>
    {!! $errors->first($name, '<p class="help-block">:message</p>') !!}
</div>

@stack($name . '_input_end')
