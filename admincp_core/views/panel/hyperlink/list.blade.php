@extends('panel.layout')

@section('title'){{ __('Các liên kết') }}@endsection

@section('content')

<h4>Danh sách Các liên kết</h4>

<table class="table table-list table-striped table-bordered table-sm table-hover">
        <thead>
            <tr class="text-center">
				<th>No.</th>
                <th>Title</th>
                <th>URL</th>
            </tr>
        </thead>
        <tbody>

			@forelse( $links as $link )
				<tr class="text-center">
					<th>{{ $loop->iteration }}</th>
	                <th><a class="btn-link text-primary" href="{{ route('admincp.hyperlink.edit', ['link'=>$link->id]) }}">{{ $link->title }}</a></th>
	                <th>{{ $link->url }}</th>
	            </tr>
			@empty
				<tr><td colspan="4">{{ __('No data to display.') }}</td></tr>
            @endforelse

        </tbody>
    </table>

@endsection
