<div class="row">
    <div class="col-md-12">
        <div class="nav-align-top">
            <ul class="nav nav-pills flex-column flex-sm-row mb-6 gap-sm-0 gap-2">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('users/details') ? 'active' : '' }}" href="{{route('admin.users.details', ['client_id' => $client['id']])}}"><i
                            class="icon-base ti tabler-users icon-sm me-1_5"></i> Summary</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.users.edit') ? 'active' : '' }}"
                        href="{{ route('admin.users.edit', $client['id']) }}">
                        <i class="icon-base ti tabler-users icon-sm me-1_5"></i> Profile
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ request()->routeIs('admin.users.contact') ? 'active' : '' }}" href="{{route('admin.users.contact', $client['id'])}}"><i
                            class="icon-base ti tabler-layout-grid icon-sm me-1_5"></i> Contacts </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages-profile-connections.html"><i
                            class="icon-base ti tabler-link icon-sm me-1_5"></i> Connections</a>
                </li>
            </ul>
        </div>
    </div>
</div>
