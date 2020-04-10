@if( Session::has( 'success' ) )
{{-- <div class="alert alert-success alert-dismissible fade show" role="alert"> --}}
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ Session::get( 'success' ) }}
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<i class="fa fa-times-circle"></i>
	</button>
</div>
@endif

@if( Session::has( 'warning' ) )
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    {!! Session::get( 'warning' ) !!}
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<i class="fa fa-times-circle"></i>
	</button>
</div>
@endif

@if( Session::has( 'danger' ) )
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {!! Session::get( 'danger' ) !!}
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<i class="fa fa-times-circle"></i>
	</button>
</div>
@endif

@if( Session::has( 'info' ) )
<div class="alert alert-info alert-dismissible fade show" role="alert">
    {{ Session::get( 'info' ) }}
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<i class="fa fa-times-circle"></i>
	</button>
</div>
@endif

@if( $errors->any() )
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>{{ __( 'Error') }}</strong>:
    <ul>
        @foreach( $errors->all() as $error )
            <li>{{ $error }}</li>
        @endforeach
    </ul>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<i class="fa fa-times-circle text-dark"></i>
	</button>
</div>
@endif
