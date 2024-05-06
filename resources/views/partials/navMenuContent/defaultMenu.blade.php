<ul id="js-nav-menu" class="nav-menu">
	{{-- landing / beranda --}}
	@can('landing_access')
		<li class="c-sidebar-nav-item {{ request()->is('/') ? 'active' : '' }}">
			<a href="{{route('home')}}" class="c-sidebar-nav-link"
				data-filter-tags="home beranda landing informasi berita pesan">
				<i class="c-sidebar-nav-icon fal fa-home-alt">
				</i>
				<span class="nav-link-text">{{ trans('cruds.landing.title_lang') }}</span>
			</a>
		</li>
	@endcan

	{{-- user main menu --}}
	@can('user_task_access')
		<li class="nav-title">Pelaporan Realisasi</li>
		@can('pull_access')
			<li class="c-sidebar-nav-item {{ request()->is('importir/commitment/synchronize') ? 'active' : '' }}">
				<a href="{{ route('importir.commitment.pull') }}"
					data-filter-tags="sinkronisasi sync tarik data siap riph">
					<i class="fa-fw fal fa-sync-alt c-sidebar-nav-icon">
					</i>
					{{ trans('cruds.pullSync.title_lang') }}
				</a>
			</li>
		@endcan
		@can('commitment_access')
			@if (Auth::user()->roles[0]->title == 'User')
				<li class="c-sidebar-nav-item {{ request()->is('importir/commitment') ||
				request()->is('importir/commitment/pks*') ? 'active' : '' }}">
					<a href="{{ route('importir.commitment.index') }}"
						data-filter-tags="daftar komitmen riph index">
						<i class="fa-fw fal fa-ballot c-sidebar-nav-icon"></i>
						{{ trans('cruds.commitment.title_lang') }}
					</a>
				</li>
			@endif
		@endcan
	@endcan

	@if (Auth::user()->roles[0]->title == 'Admin' )
		<li class="nav-title" data-i18n="nav.superadmin">Administrator</li>
	@endif
	@can('can_sroot')
		<li class="nav-title" data-i18n="nav.superadmin">SUPERADMIN</li></li>
		<li class="{{ request()->is('sroot/gmapapi*') ? 'active open' : '' }} ">
			<a href="{{route('sroot.gmapapi.edit')}}" title="Goole Map API"
				data-filter-tags="google map api key">
				<i class="fab fa-google"></i>
				<span class="nav-link-text">Google Map API</span>
			</a>
		</li>
	@endcan
	@can('broadcast_access')
		<li class="{{ request()->is('admin/broadcasts*') ? 'active open' : '' }} ">
			<a href="{{route('admin.broadcasts.index')}}" title="Create Broadcast Messages"
				data-filter-tags="info broadcast pengumuman">
				<i class="fal fa-speaker"></i>
				<span class="nav-link-text">Broadcasting</span>
			</a>
		</li>
	@endcan
	@can('user_management_access')
	<li class="{{ request()->is('*/permissions*')
		|| request()->is('*/roles*') || request()->is('*/users*')
		|| request()->is('*/audit-logs*') ? 'active open' : '' }} ">
		<a href="#" title="User Management"
			data-filter-tags="setting permission user">
			<i class="fal fal fa-users"></i>
			<span class="nav-link-text">{{ trans('cruds.userManagement.title_lang') }}</span>
		</a>
		<ul>
			@can('can_sroot')
				<li class="c-sidebar-nav-item {{ request()->is('sroot/permissions')
					|| request()->is('*/permissions/*') ? 'active' : '' }}">
					<a href="{{route('sroot.permissions.index')}}" title="Permission"
						data-filter-tags="setting daftar permission user">
						<i class="fa-fw fal fa-unlock-alt c-sidebar-nav-icon"></i>
						<span class="nav-link-text">{{ trans('cruds.permission.title_lang') }}</span>
					</a>
				</li>
			@endcan
			@can('can_sroot')
				<li class="c-sidebar-nav-item {{ request()->is('sroot/roles')
					|| request()->is('*/roles/*') ? 'active' : '' }}">
					<a href="{{route('sroot.roles.index')}}" title="Roles"
						data-filter-tags="setting role user">
						<i class="fa-fw fal fa-briefcase c-sidebar-nav-icon"></i>
						<span class="nav-link-text">{{ trans('cruds.role.title_lang') }}</span>
					</a>
				</li>
			@endcan
			@can('user_access')
				<li class="c-sidebar-nav-item {{ request()->is('*/users')
					|| request()->is('*/users/*') ? 'active' : '' }}">
					<a href="{{route('admin.users.index')}}" title="Users Management"
						data-filter-tags="setting user pengguna">
						<i class="fa-fw fal fa-user-tie c-sidebar-nav-icon"></i>
						<span class="nav-link-text">Pelaku Usaha</span>
					</a>
				</li>
				<li class="c-sidebar-nav-item {{ request()->is('*/users')
					|| request()->is('*/users/*') ? 'active' : '' }}">
					<a href="{{route('admin.users.index')}}" title="Users Management"
						data-filter-tags="setting user pengguna">
						<i class="fa-fw fal fa-user c-sidebar-nav-icon"></i>
						<span class="nav-link-text">Pengguna Subdit</span>
					</a>
				</li>
			@endcan
			@can('audit_log_access')
				<li class="c-sidebar-nav-item {{ request()->is('admin/audit-logs')
					|| request()->is('admin/audit-logs/*') ? 'active' : '' }}">
					<a href="" title="Audit Log"
						data-filter-tags="setting log_access audit">
						<i class="fa-fw fal fa-file-alt c-sidebar-nav-icon"></i>
						<span class="nav-link-text">{{ trans('cruds.auditLog.title_lang') }}</span>
					</a>
				</li>
			@endcan
		</ul>
	</li>
	@endcan

	{{-- logout --}}
	<li class="c-sidebar-nav-item">
		<a href="#" class="c-sidebar-nav-link"
			data-filter-tags="keluar log out tutup"
			onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
			<i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

			</i>
			{{ trans('global.logout') }}
		</a>
	</li>
</ul>
