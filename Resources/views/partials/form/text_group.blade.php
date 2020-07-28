@stack($name . '_input_start')

<div class="{{ isset($attributes['required']) ? 'required' : '' }} {{ $errors->has($name) ? 'has-error' : '' }}">
    {!! Form::label($name, $text, ['class' => 'control-label']) !!}
    @if(isset($attributes['required']))
    <span class="text-danger">*</span>
    @endif

    <div class="input-group">
        @if($icon != '')
        <div class="input-group-addon"><i class="fa fa-{{ $icon }}"></i></div>
        @endif
        {!! Form::text($name, $value, array_merge(['class' => 'form-control', 'placeholder' => $text], $attributes)) !!}
    </div>
    {!! $errors->first($name, '<p class="help-block">:message</p>') !!}
</div>

@stack($name . '_input_end')
