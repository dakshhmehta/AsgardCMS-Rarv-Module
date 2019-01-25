<div class="box box-primary">
    <div class="box-header">
    </div>
    <!-- /.box-header -->
    <div class="box-body">
    	<form action="{{ request()->url() }}" method="GET">
	    	<div class="row">
	    		<div class="col-md-10">
					@foreach($fields as &$field)
						<div class="form-group col-sm-{{ $field->getColumn() }}">
							{!! $field->render() !!}
						</div>
					@endforeach
				</div>
				<div class="col-md-2 text-right">
					<button type="submit" value="filter" class="btn btn-success btn-flat">Filter</button><br/><br/>
					<a href="{{ request()->url() }}" class="btn btn-danger btn-flat">Reset</a>
				</div>
			</div>
		</form>
	</div>
</div>