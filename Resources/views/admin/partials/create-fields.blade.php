<div class="box-body">
	@foreach($fields as &$field)
		@if($lang == 'en' || $field->isTranslatable())
			<div class="form-group col-sm-{{ $field->getColumn() }}">
				{!! $field->render($lang) !!}
			</div>
		@endif
	@endforeach
</div>
