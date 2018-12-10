<div class='form-group'>
    {!! Form::label($settingName, trans($moduleInfo['description'])) !!}
	<select name="{{ $settingName }}" class="form-control" id="{{ $settingName }}">
	</select>
</div>


@push('js-stack')
<script type="text/javascript" src="{{ asset('modules/rarv/js/countries.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		@if(isset($dbSettings[$settingName]))
		populateCountries("{{ $settingName }}", "state", "{{ $dbSettings[$settingName]->plainValue }}", "{{ setting('accounting::company_state', '') }}");
		@else
		populateCountries("{{ $settingName }}", "state");
		@endif
	});
</script>
@endpush