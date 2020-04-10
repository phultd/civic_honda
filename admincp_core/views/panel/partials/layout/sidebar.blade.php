<nav id="sidebar">
	<div class="btn-toolbar bg-white">
		<button type="button" class="btn btn-sm btn-primary sidebar-toggle" title="Toggle sidebar">
			<i class="fa fa-bars"></i>
		</button>
		<a href="{{ url('/') }}" target="_blank" class="btn btn-sm btn-primary ml-2 px-4" title="Visit site">
			<i class="fa fa-home"></i>
		</a>
	</div>

	<ul class="list-unstyled menu-list">

		<li class="menu-item {{ Request::is('admincp') ? 'active' : '' }}"><a href="{{ route('admincp.index') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>

		<li class="menu-item {{ Request::route()->getName() == 'admincp.banner.edit' ? 'active' : '' }}"><a href="{{ route('admincp.banner.edit') }}"><i class="fa fa-inbox"></i> <span>Banner</span></a></li>

		<li class="menu-item {{ Request::route()->getName() == 'admincp.message.edit' ? 'active' : '' }}"><a href="{{ route('admincp.message.edit') }}"><i class="fa fa-inbox"></i> <span>Thông điệp</span></a></li>

		<li class="menu-item {{ Request::is(['*exterior*']) ? 'active' : '' }}"><a href="{{ route('admincp.exterior.edit') }}"><i class="fa fa-inbox"></i> <span>Ngoại thất</span></a></li>

		<li class="menu-item {{ Request::is(['*interior*']) ? 'active' : '' }}"><a href="{{ route('admincp.interior.edit') }}"><i class="fa fa-inbox"></i> <span>Nội thất</span></a></li>

		<li class="menu-item {{ Request::is(['*operation*']) ? 'active' : '' }}"><a href="{{ route('admincp.operation.edit') }}"><i class="fa fa-inbox"></i> <span>Vận hành</span></a></li>

		<li class="menu-item {{ Request::is(['*utility*']) ? 'active' : '' }}"><a href="{{ route('admincp.utility.edit') }}"><i class="fa fa-inbox"></i> <span>Tiện ích</span></a></li>

		<li class="menu-item {{ Request::is(['*safety*']) ? 'active' : '' }}"><a href="{{ route('admincp.safety.edit') }}"><i class="fa fa-inbox"></i> <span>An toàn</span></a></li>

		<li class="menu-item {{ Request::is(['*accessory*']) ? 'active' : '' }}"><a href="{{ route('admincp.accessory.edit') }}"><i class="fa fa-inbox"></i> <span>Phụ kiện</span></a></li>

		<li class="menu-item {{ Request::route()->getName() == 'admincp.specification.edit' ? 'active' : '' }}"><a href="{{ route('admincp.specification.edit') }}"><i class="fa fa-inbox"></i> <span>Thông số kỹ thuật</span></a></li>

		<li class="menu-item {{ Request::is(['*gallery*']) ? 'active' : '' }}"><a href="{{ route('admincp.gallery.edit') }}"><i class="fa fa-inbox"></i> <span>Thư viện</span></a></li>

		<li class="menu-item {{ Request::is(['*hyperlink*']) ? 'active' : '' }}"><a href="{{ route('admincp.hyperlink.list') }}"><i class="fa fa-link"></i> <span>Các liên kết</span></a></li>

		<li class="menu-item {{ Request::is(['*password*']) ? 'active' : '' }}"><a href="{{ route('admincp.password.change') }}"><i class="fa fa-key"></i> <span>Change Password</span></a></li>

		@if( Auth::user()->role == 1 )
			<li class="menu-item {{ Request::is(['admincp/user*']) ? 'active' : '' }}"><a href="{{ route('admincp.user.list') }}"><i class="fa fa-user"></i> <span>Users</span></a></li>
		@endif
	</ul>
</nav>
