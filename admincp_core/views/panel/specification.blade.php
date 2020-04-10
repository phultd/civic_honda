@extends('panel.layout')

@section('title'){{ __('Thông số kỹ thuật') }}@endsection

@section('content')

<h4>Thông số kỹ thuật</h4><br>

<form action="{{ route('admincp.specification.save') }}" method="post" autocomplete="off">
	@csrf

	{{-- specification table --}}
	<div class="card mb-3">
		<div class="card-header">
			Specification table
		</div>
		<div class="card-body">
			<div class="md-form">
				<textarea id="specification" name="specification" class="md-textarea form-control wysiwyg" rows="3" value="@if( old('specification') ){{ old('specification') }}@elseif( !empty($specification) && $specification->specification ){{ $specification->specification }}@endif">@if( old('specification') ){{ old('specification') }}@elseif( !empty($specification) && $specification->specification ){{ $specification->specification }}@endif</textarea>
			</div>
		</div>
	</div>

	{{-- button group --}}
	<div class="button-group mt-5">
		<button type="submit" class="btn blue-gradient">Save</button>
	</div>

</form>

@endsection
