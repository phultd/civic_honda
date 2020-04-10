@extends('panel.layout')

@section('title'){{ __('Edit Ngoại thất Category') }}@endsection

@section('content')

<h4>Edit Ngoại thất Category</h4><br>

<form action="{{ route('admincp.exterior.update.category',['category'=>$category->id]) }}" method="post">
	@csrf

	{{-- category title --}}
	<div class="card mb-3">
		<div class="card-header">
			Title
		</div>
		<div class="card-body">
			<div class="md-form">
				<input type="text" id="title" name="title" class="form-control"
				value="@if( old('title') ){{ old('title') }}@elseif( !empty($category->title) ){{ $category->title }}@endif">
				<label for="title">Input Title</label>
			</div>
		</div>
	</div>

	{{-- category heading --}}
	<div class="card mb-3">
		<div class="card-header">
			Heading
		</div>
		<div class="card-body">
			<div class="md-form">
				<input type="text" id="heading" name="heading" class="form-control"
				value="@if( old('heading') ){{ old('heading') }}@elseif( !empty($category->heading) ){{ $category->heading }}@endif">
				<label for="heading">Input Heading</label>
			</div>
		</div>
	</div>

	{{-- category description --}}
	<div class="card mb-3">
		<div class="card-header">
			Description
		</div>
		<div class="card-body">
			<div class="md-form">
				<textarea id="description" name="description" class="md-textarea form-control" rows="3" value="@if( old('description') ){{ old('description') }}@elseif( !empty($category->description) ){{ $category->description }}@endif">@if( old('description') ){{ old('description') }}@elseif( !empty($category->description) ){{ $category->description }}@endif</textarea>
				<label for="description">Input Description</label>
			</div>
		</div>
	</div>

	{{-- image --}}
	<div class="card mb-3">
		<div class="card-header">
			Image
		</div>
		<div class="card-body">
			<div class="md-form">
				<button id="image" type="button" class="btn btn-primary btn-sm btn-wysiwyg">Select Image</button>
				<input type="text" hidden name="image"
				value="@if( old('image') )
					{{ old('image') }}
				@elseif( !empty($category) && $category->image )
					{{ $category->image }}
				@endif">

				<div class="image-preview">
					@if( old('image') )
						<img class="img-thumbnail" src="{{ url( old('image') ) }}">
						<a type="button" class="btn-floating btn-sm btn-warning btn-wysiwyg-remove"><i class="fa fa-trash-o"></i></a>
					@elseif( !empty($category) && $category->image )
						<img class="img-thumbnail" src="{{ url( $category->image ) }}">
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
			Image Mobile
		</div>
		<div class="card-body">
			<div class="md-form">
				<button id="image_mobile" type="button" class="btn btn-primary btn-sm btn-wysiwyg">Select Image</button>
				<input type="text" hidden name="image_mobile"
				value="@if( old('image_mobile') )
					{{ old('image_mobile') }}
				@elseif( !empty($category) && $category->image_mobile )
					{{ $category->image_mobile }}
				@endif">

				<div class="image-preview">
					@if( old('image_mobile') )
						<img class="img-thumbnail" src="{{ url( old('image_mobile') ) }}">
						<a type="button" class="btn-floating btn-sm btn-warning btn-wysiwyg-remove"><i class="fa fa-trash-o"></i></a>
					@elseif( !empty($category) && $category->image_mobile )
						<img class="img-thumbnail" src="{{ url( $category->image_mobile ) }}">
						<a type="button" class="btn-floating btn-sm btn-warning btn-wysiwyg-remove"><i class="fa fa-trash-o"></i></a>
					@else
					<span>No image selected</span>
					@endif
				</div>
			</div>

		</div>
	</div>

	{{-- category order --}}
	<div class="card mb-3">
		<div class="card-header">
			Order
		</div>
		<div class="card-body">
			<div class="md-form">
				<input type="number" id="order" name="order" class="form-control"
				value="@if( old('order') ){{ old('order') }}@elseif( !empty($category->order) ){{ $category->order }}@endif">
				<label for="title">Input Order</label>
			</div>
		</div>
	</div>

	{{-- button group --}}
	<div class="button-group mt-5">
		<button type="submit" class="btn blue-gradient">Save</button>
		<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal_delete">Delete Category</button>
	</div>

</form>

<form id="form_delete" class="d-none" action="{{ route('admincp.exterior.delete.category', ['category'=>$category->id]) }}" method="post">
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
			<button type="button" class="btn btn-danger" onclick="$('#form_delete').submit()">Delete Category</button>
		</div>
	</div>
</div>
</div>

<h4 class="mt-5">Danh sách Ngoại thất Item</h4>

<div class="button-group mb-2">
	<a href="{{ route('admincp.exterior.add.item',['category'=>$category->id]) }}" type="submit" class="btn btn-sm btn-primary">Add New Item</a>
</div>

<table class="table table-list table-striped table-bordered table-sm table-hover">
    <thead>
        <tr class="text-center">
			<th>No.</th>
            <th>Image</th>
            <th>Title</th>
            <th>Description</th>
            <th>Order</th>
        </tr>
    </thead>
    <tbody>

		@forelse( $items as $item )
			<tr class="text-center">
				<td>
					{{ $loop->iteration }}<br>
					<a class="btn-link text-primary" href="{{ route('admincp.exterior.edit.item', ['category'=>$category->id,'item'=>$item->id]) }}">
						Edit
					</a>
				</td>
                <td>
					@if( !empty($item->image) )
						<a class="btn-link text-primary" href="{{ route('admincp.exterior.edit.item', ['category'=>$category->id,'item'=>$item->id]) }}">
							<div class="image-preview img-thumbnail">
								<img src="{{ $item->image }}" alt="">
							</div>
						</a>
					@endif
				</td>
                <td>{{ $item->title }}</td>
                <td>{{ $item->description }}</td>
                <td>{{ $item->order }}</td>
            </tr>
		@empty
			<tr><td colspan="5">{{ __('No data to display.') }}</td></tr>
        @endforelse

    </tbody>
</table>

@endsection
