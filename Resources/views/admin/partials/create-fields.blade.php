<div class="box-body">
	@foreach($fields as &$field)
		{!! $field->render() !!}
	@endforeach
</div>
