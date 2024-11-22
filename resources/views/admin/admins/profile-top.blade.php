<div class="card card-default card-profile">

    <div class="card-header-bg" style="background-image:url('{{ asset('assets/admin/images/user/user-bg-01.jpg') }}')">
        <h4 class="bg-secondary text-light d-inline-block m-2">{{ $admin->userName }}</h4>
        <h6 class="bg-secondary text-light d-inline-block m-2">
            {{ $admin->possition ? $admin->possition : 'Unknown' }}</h6>
    </div>

    <div class="card-body card-profile-body">

        <div class="profile-avatar">
            <img class="rounded-circle" src="{{ asset('assets/admin/images/user/user-md-01.jpg') }}" alt="Avatar Image">
            <span
                class="h5 d-block mt-3 mb-2">{{ $admin->profile ? $admin->profile->first_name . ' ' . $admin->profile->last_name : explode('@', $admin->email)[0] }}</span>
            <span class="d-block">{{ $admin->email }}</span>
        </div>

        <ul class="nav nav-profile-follow">
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span class="h5 d-block">1503</span>
                    <span class="text-color d-block">Friends</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span class="h5 d-block">2905</span>
                    <span class="text-color d-block">Followers</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span class="h5 d-block">1200</span>
                    <span class="text-color d-block">Following</span>
                </a>
            </li>

        </ul>

        <div class="profile-button">
            <a class="btn btn-primary btn-pill" href="">Upgrade Plan</a>
        </div>

    </div>

    <div class="card-footer card-profile-footer p-0">
        <ul class="nav nav-border-top justify-content-center">
            <li class="nav-item {{ request()->is('admin/admins/display/profile*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('display-admin', [$admin->id]) }}">Profile</a>
            </li>
            <li class="nav-item {{ request()->is('admin/admins/display/roles*') ? 'active' : '' }}">

                <a class="nav-link" href="{{ route('display-admin-roles', [$admin->id]) }}">Roles & Permissions</a>
            </li>
            <li class="nav-item {{ request()->is('admin/admins/display/log/*') ? 'active' : '' }}">

                <a class="nav-link" href="{{ route('display-admin-log', [$admin->id]) }}">activity Log</a>
            </li>

        </ul>
    </div>

</div>
