@stack("{$locale}[{$field->getName()}]" . '_input_start')

<div class="{{ (in_array('required', $field->getRules())) ? 'required' : '' }} {{ $errors->has($locale.$field->getName()) ? 'has-error' : '' }}">
    {!! Form::label("{$locale}[{$field->getName()}]", $field->getLabel(), ['class' => 'control-label']) !!}
    @if(in_array('required', $field->getRules()))
    <span class="text-danger">*</span>
    @endif

    <div class="{{ data_get($field->getParameters(), 'icon') == '' ? '' : 'input-group' }}">
        @if(data_get($field->getParameters(), 'icon') != '')
        <div class="input-group-addon"><i class="fa fa-{{ data_get($field->getParameters(), 'icon') }}"></i></div>
        @endif

        <input name="{{ $locale }}[{{$field->getName()}}]" id="{{ $locale }}[{{$field->getName()}}]" type="text" value="{{ $field->getValue($locale) }}" class="form-control" {{ (in_array('required', $field->getRules())) ? 'required' : '' }}>
    </div>

    {!! $errors->first("{$locale}[{$field->getName()}]", '<p class="help-block">:message</p>') !!}
</div>

@stack("{$locale}[{$field->getName()}]" . '_input_end')
