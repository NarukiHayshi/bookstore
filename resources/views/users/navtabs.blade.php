<ul class="nav nav-pills nav-fill" style="margin-top:50px;">
    <li class="nav-item col-md-3"><a href="{{ route('users.show', ['id' => $user->id]) }}" class="nav-link {{ Request::is('users/' . $user->id) ? 'active' : '' }}">TimeLine <span class="badge badge-secondary">{{ $count_books }}</span></a></li>
    <li class="nav-item col-md-3"><a href="{{ route('users.followings', ['id' => $user->id]) }}" class="nav-link {{ Request::is('users/*/followings') ? 'active' : '' }} ">Followings <span class="badge badge-secondary">{{ $count_followings }}</span></a></li>
    <li class="nav-item col-md-3"><a href="{{ route('users.followers', ['id' => $user->id]) }}" class="nav-link {{ Request::is('users/*/followers') ? 'active' : '' }}">Followers <span class="badge badge-secondary">{{ $count_followers }}</span></a></li>
    <li class="nav-item col-md-3"><a href="{{ route('users.favorites', ['id' => $user->id]) }}" class="nav-link {{ Request::is('users/*/favorites') ? 'active' : '' }}">いいね <span class="badge badge-secondary">{{ $count_favorites }}</span></a></li>
</ul>