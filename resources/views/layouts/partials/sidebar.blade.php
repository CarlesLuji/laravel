<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <!-- Brand -->
  <div class="sidebar-brand">
    <a href="{{ route('dashboard') }}" class="brand-link">
      <img src="{{ asset('adminlte/dist/assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image opacity-75 shadow">
      <span class="brand-text fw-light">AdminLTE 4</span>
    </a>
  </div>

  <!-- Sidebar -->
  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" aria-label="Main navigation">
          <!-- Dropdown Menu 1 -->
        <li class="nav-item has-treeview menu-open">
          <a href="#" class="nav-link active "style="background-color:#b12545;font-weight: bold;font-style: italic;">
             <i class="bi bi-person-fill-gear"></i>
            <p>
              ADMINISTRADOR&nbsp;
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.users.index') }}" class="nav-link"style="background-color:#b125459c;">
                <i class="bi bi-people-fill"></i>
                <p>Usuarios</p>
              </a>
            </li>
            <li class="nav-item">
               <a href="#" class="nav-link"style="background-color:#b125459c;">
                <i class="bi bi-person-vcard-fill"></i>
                <p>Roles</p>
              </a>
            </li>
            <li class="nav-item">
               <a href="#" class="nav-link"style="background-color:#b125459c;">
                <i class="bi bi-postcard-fill"></i>
                <p>Permisos</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Dashboard -->
        <li class="nav-item">
          <a href="{{ route('dashboard') }}" class="nav-link active">
            <i class="nav-icon bi bi-speedometer"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- Direct Link 1 -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-person"></i>
            <p>Users</p>
          </a>
        </li>

        <!-- Direct Link 2 -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-gear"></i>
            <p>Settings</p>
          </a>
        </li>

      

        <!-- Dropdown Menu 2 -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-pie-chart"></i>
            <p>
              Reports
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Monthly</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Annual</p>
              </a>
            </li>
          </ul>
        </li>

      </ul>
    </nav>
  </div>
</aside>

