@extends('panel.layout')

@section('title'){{ __('Ngoại thất - Tổng quan') }}@endsection

@section('content')

<h4>Ngoại thất - Tổng quan</h4><br>

<form action="{{ route('admincp.exterior.update') }}" method="post">
	@csrf

	{{-- section background --}}
	<div class="card mb-3">
		<div class="card-header">
			Image
		</div>
		<div class="card-body">
			<div class="md-form">
				<button id="section_background" type="button" class="btn btn-primary btn-sm btn-wysiwyg">Select Image</button>
				<input type="text" hidden name="section_background"
				value="@if( old('section_background') )
					{{ old('section_background') }}
				@elseif( !empty($exterior) && $exterior->section_background )
					{{ $exterior->section_background }}
				@endif">

				<div class="image-preview">
					@if( old('section_background') )
						<img class="img-thumbnail" src="{{ url( old('section_background') ) }}">
						<a type="button" class="btn-floating btn-sm btn-warning btn-wysiwyg-remove"><i class="fa fa-trash-o"></i></a>
					@elseif( !empty($exterior) && $exterior->section_background )
						<img class="img-thumbnail" src="{{ url( $exterior->section_background ) }}">
						<a type="button" class="btn-floating btn-sm btn-warning btn-wysiwyg-remove"><i class="fa fa-trash-o"></i></a>
					@else
					<span>No image selected</span>
					@endif
				</div>
			</div>

		</div>
	</div>

	{{-- section background mobile --}}
	<div class="card mb-3">
		<div class="card-header">
			Image Mobile
		</div>
		<div class="card-body">
			<div class="md-form">
				<button id="section_background_mobile" type="button" class="btn btn-primary btn-sm btn-wysiwyg">Select Image</button>
				<input type="text" hidden name="section_background_mobile"
				value="@if( old('section_background_mobile') )
					{{ old('section_background_mobile') }}
				@elseif( !empty($exterior) && $exterior->section_background_mobile )
					{{ $exterior->section_background_mobile }}
				@endif">

				<div class="image-preview">
					@if( old('section_background_mobile') )
						<img class="img-thumbnail" src="{{ url( old('section_background_mobile') ) }}">
						<a type="button" class="btn-floating btn-sm btn-warning btn-wysiwyg-remove"><i class="fa fa-trash-o"></i></a>
					@elseif( !empty($exterior) && $exterior->section_background_mobile )
						<img class="img-thumbnail" src="{{ url( $exterior->section_background_mobile ) }}">
						<a type="button" class="btn-floating btn-sm btn-warning btn-wysiwyg-remove"><i class="fa fa-trash-o"></i></a>
					@else
					<span>No image selected</span>
					@endif
				</div>
			</div>

		</div>
	</div>

	{{-- section title --}}
	<div class="card mb-3">
		<div class="card-header">
			Heading
		</div>
		<div class="card-body">
			<div class="md-form">
				<input type="text" id="section_title" name="section_title" class="form-control"
				value="@if( old('section_title') ){{ old('section_title') }}@elseif( !empty($exterior) && $exterior->section_title ){{ $exterior->section_title }}@endif">
				<label for="popup_video">Input Heading</label>
			</div>

		</div>
	</div>

	{{-- section description --}}
	<div class="card mb-3">
		<div class="card-header">
			Description
		</div>
		<div class="card-body">
			<div class="md-form">
				<input type="text" id="section_description" name="section_description" class="form-control"
				value="@if( old('section_description') ){{ old('section_description') }}@elseif( !empty($exterior) && $exterior->section_description ){{ $exterior->section_description }}@endif">
				<label for="popup_video">Input Description</label>
			</div>

		</div>
	</div>

	{{-- button group --}}
	<div class="button-group mt-5">
		<button type="submit" class="btn blue-gradient">Save</button>
	</div>

</form>

<h4 class="mt-5">Danh sách Ngoại thất Category</h4>

<div class="button-group mb-2">
	<a href="{{ route('admincp.exterior.add.category') }}" type="submit" class="btn btn-sm btn-primary">Add New Category</a>
</div>

<table class="table table-list table-striped table-bordered table-sm table-hover">
        <thead>
            <tr class="text-center">
				<th>No.</th>
                <th>Title</th>
                <th>Heading</th>
                <th>Description</th>
                <th>Order</th>
            </tr>
        </thead>
        <tbody>

			@forelse( $exterior_categories as $category )
				<tr class="text-center">
					<td>{{ $loop->iteration }}</td>
	                <td><a class="btn-link text-primary" href="{{ route('admincp.exterior.edit.category', ['category'=>$category->id]) }}">{{ $category->title }}</a></td>
	                <td>{{ $category->heading }}</td>
	                <td>{{ $category->description }}</td>
	                <td>{{ $category->order }}</td>
	            </tr>
			@empty
				<tr><td colspan="5">{{ __('No data to display.') }}</td></tr>
            @endforelse

        </tbody>
    </table>

@endsection
