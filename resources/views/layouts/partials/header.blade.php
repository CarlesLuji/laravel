<nav class="app-header navbar navbar-expand bg-body">
  <div class="container-fluid">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
          <i class="bi bi-list"></i>
        </a>
      </li>
      <li class="nav-item d-none d-md-block">
        <a href="#" class="nav-link">Home</a>
      </li>
    </ul>

    <ul class="navbar-nav ms-auto">
      @auth
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
          <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}" class="user-image rounded-circle shadow" alt="User Image">
          <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
          <li class="user-header text-bg-primary">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}" class="rounded-circle shadow" alt="User Image">
            <p>
              {{ Auth::user()->name }}
              <small>Member since {{ Auth::user()->created_at->format('M. Y') }}</small>
            </p>
          </li>
          <li class="user-footer">
            <a href="{{ route('profile.edit') }}" class="btn btn-default btn-flat">Profile</a>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
              @csrf
              <button type="submit" class="btn btn-default btn-flat float-end">Sign out</button>
            </form>
          </li>
        </ul>
      </li>
      @endauth
    </ul>
  </div>
</nav>
