@extends('panel.layout')

@section('title'){{ __('Edit An toàn') }}@endsection

@section('content')

<h4>Edit An toàn</h4><br>

<form action="{{ route('admincp.safety.item.save', ['item'=>$safety->id]) }}" method="post">
	@csrf

	{{-- item title --}}
	<div class="card mb-3">
		<div class="card-header">
			Title
		</div>
		<div class="card-body">
			<div class="md-form">
				<input type="text" id="title" name="title" class="form-control"
				value="@if( old('title') ){{ old('title') }}@elseif( !empty($safety) && $safety->title ){{ $safety->title }}@endif">
				<label for="title">Input Title</label>
			</div>
		</div>
	</div>

	{{-- item description --}}
	<div class="card mb-3">
		<div class="card-header">
			Description
		</div>
		<div class="card-body">
			<div class="md-form">
				<textarea id="description" name="description" class="md-textarea form-control" rows="3" value="@if( old('description') ){{ old('description') }}@elseif( !empty($safety) && $safety->description ){{ $safety->description }}@endif">@if( old('description') ){{ old('description') }}@elseif( !empty($safety) && $safety->description ){{ $safety->description }}@endif</textarea>
				<label for="description">Input Description</label>
			</div>
		</div>
	</div>

	{{-- image --}}
	<div class="card mb-3">
		<div class="card-header">
			Display Image
		</div>
		<div class="card-body">
			<div class="md-form">
				<button id="image" type="button" class="btn btn-primary btn-sm btn-wysiwyg">Select Image</button>
				<input type="text" hidden name="image"
				value="@if( old('image') )
					{{ old('image') }}
				@elseif( !empty($safety) && $safety->image )
					{{ $safety->image }}
				@endif">

				<div class="image-preview">
					@if( old('image') )
						<img class="img-thumbnail" src="{{ url( old('image') ) }}">
						<a type="button" class="btn-floating btn-sm btn-warning btn-wysiwyg-remove"><i class="fa fa-trash-o"></i></a>
					@elseif( !empty($safety) && $safety->image )
						<img class="img-thumbnail" src="{{ url( $safety->image ) }}">
						<a type="button" class="btn-floating btn-sm btn-warning btn-wysiwyg-remove"><i class="fa fa-trash-o"></i></a>
					@else
					<span>No image selected</span>
					@endif
				</div>
			</div>

		</div>
	</div>

	{{-- image mobile --}}
	<div class="card mb-3">
		<div class="card-header">
			Display Image Mobile
		</div>
		<div class="card-body">
			<div class="md-form">
				<button id="image_mobile" type="button" class="btn btn-primary btn-sm btn-wysiwyg">Select Image</button>
				<input type="text" hidden name="image_mobile"
				value="@if( old('image_mobile') )
					{{ old('image_mobile') }}
				@elseif( !empty($safety) && $safety->image_mobile )
					{{ $safety->image_mobile }}
				@endif">

				<div class="image-preview">
					@if( old('image_mobile') )
						<img class="img-thumbnail" src="{{ url( old('image_mobile') ) }}">
						<a type="button" class="btn-floating btn-sm btn-warning btn-wysiwyg-remove"><i class="fa fa-trash-o"></i></a>
					@elseif( !empty($safety) && $safety->image_mobile )
						<img class="img-thumbnail" src="{{ url( $safety->image_mobile ) }}">
						<a type="button" class="btn-floating btn-sm btn-warning btn-wysiwyg-remove"><i class="fa fa-trash-o"></i></a>
					@else
					<span>No image selected</span>
					@endif
				</div>
			</div>

		</div>
	</div>

	{{-- item order --}}
	<div class="card mb-3">
		<div class="card-header">
			Order
		</div>
		<div class="card-body">
			<div class="md-form">
				<input type="number" id="order" name="order" class="form-control"
				value="@if( old('order') ){{ old('order') }}@elseif( !empty($safety) && $safety->order ){{ $safety->order }}@endif">
				<label for="title">Input Order</label>
			</div>
		</div>
	</div>

	{{-- button group --}}
	<div class="button-group mt-5">
		<button type="submit" class="btn blue-gradient">Save</button>
		<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal_delete">Delete Item</button>
	</div>

</form>

<form id="form_delete" class="d-none" action="{{ route('admincp.safety.item.delete', ['item'=>$safety->id]) }}" method="post">
	@csrf
	@method('delete')
</form>

<div class="modal fade" id="modal_delete" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title">Confirm Delete</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			Are you sure to delete?
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-danger" onclick="$('#form_delete').submit()">Delete</button>
		</div>
	</div>
</div>
</div>

@endsection
