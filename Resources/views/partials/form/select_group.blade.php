@stack($name . '_input_start')

<div class="form-group {{ $col }} {{ isset($attributes['required']) ? 'required' : '' }} {{ $errors->has($name) ? 'has-error' : ''}}">
    {!! Form::label($name, $text, ['class' => 'control-label']) !!}
    {!! isset($attributes['required']) ? '<span class="text-danger">*</span>' : '' !!}

    <div class="{{ $icon == '' ? 'form-group' : 'input-group' }}">
        @if($icon != '')
        <div class="input-group-addon"><i class="fa fa-{{ $icon }}"></i></div>
        @endif
        {!! Form::select($name, $values, $selected, array_merge(['class' => 'form-control', 
        'placeholder' => '-- Select --'], $attributes)) !!}
    </div>
    {!! $errors->first($name, '<p class="help-block">:message</p>') !!}
</div>

@stack($name . '_input_end')
