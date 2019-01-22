<div class="box-body">
	@foreach($fields as &$field)
	<div class="form-group col-sm-{{ $field->getColumn() }}">
		{!! $field->render() !!}
	</div>
	@endforeach
</div>
