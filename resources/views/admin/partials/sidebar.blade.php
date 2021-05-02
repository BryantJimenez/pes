<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar"> 
        <div class="profile-info">
            <figure class="user-cover-image"></figure>
            <div class="user-info">
                <img src="{{ image_exist('/admins/img/users/', Auth::user()->photo, true) }}" width="90" height="90" title="Foto de Perfil" alt="{{ Auth::user()->name." ".Auth::user()->lastname }}">
                <h6 class="">{{ Auth::user()->name." ".Auth::user()->lastname }}</h6>
                <p class="">{!! roleUser(Auth::user()) !!}</p>
            </div>
        </div>
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu {{ active(['admin', 'admin/perfil', 'admin/perfil/editar']) }}">
                <a href="{{ route('admin') }}" aria-expanded="{{ menu_expanded(['admin', 'admin/perfil', 'admin/perfil/editar']) }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span> Inicio</span>
                    </div>
                </a>
            </li>

            @can('users.index')
            <li class="menu {{ active('admin/usuarios', 0) }}">
                <a href="{{ route('usuarios.index') }}" aria-expanded="{{ menu_expanded('admin/usuarios', 0) }}" class="dropdown-toggle">
                    <div class="">
                        <span><i class="fa fa-users"></i> Usuarios</span>
                    </div>
                </a>
            </li>
            @endcan

            @if(Auth::user()->hasAllPermissions(['zip.index', 'colonies.index', 'sections.index']))
            <li class="menu {{ active(['admin/postales', 'admin/colonias', 'admin/secciones'], 0) }}">
                <a href="#sections" data-toggle="collapse" aria-expanded="{{ menu_expanded(['admin/postales', 'admin/colonias', 'admin/secciones'], 0) }}" class="dropdown-toggle">
                    <div class="">
                        <span><i class="fa fa-th"></i> Secciones</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ submenu(['admin/postales', 'admin/colonias', 'admin/secciones'], 0) }}" id="sections" data-parent="#accordionExample">
                    @can('zip.index')
                    <li {{ submenu('admin/postales') }}>
                        <a href="{{ route('postales.index') }}"> Códigos Postales</a>
                    </li>
                    @endcan
                    @can('colonies.index')
                    <li {{ submenu('admin/colonias') }}>
                        <a href="{{ route('colonias.index') }}"> Colonias</a>
                    </li>
                    @endcan
                    @can('sections.index')
                    <li {{ submenu('admin/secciones') }}>
                        <a href="{{ route('secciones.index') }}"> Secciones</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @elseif(Auth::user()->hasPermissionTo('colonies.index') || Auth::user()->hasPermissionTo('sections.index'))
            @can('colonies.index')
            <li class="menu {{ active('admin/colonias', 0) }}">
                <a href="{{ route('colonias.index') }}" aria-expanded="{{ menu_expanded('admin/colonias', 0) }}" class="dropdown-toggle">
                    <div class="">
                        <span><i class="fa fa-map-marker-alt"></i> Colonias</span>
                    </div>
                </a>
            </li>
            @endcan

            @can('sections.index')
            <li class="menu {{ active('admin/secciones', 0) }}">
                <a href="{{ route('secciones.index') }}" aria-expanded="{{ menu_expanded('admin/secciones', 0) }}" class="dropdown-toggle">
                    <div class="">
                        <span><i class="fa fa-th"></i> Secciones</span>
                    </div>
                </a>
            </li>
            @endcan
            
            @else
            @can('zip.index')
            <li class="menu {{ active('admin/postales', 0) }}">
                <a href="{{ route('postales.index') }}" aria-expanded="{{ menu_expanded('admin/postales', 0) }}" class="dropdown-toggle">
                    <div class="">
                        <span><i class="fa fa-address-card"></i> Códigos Postales</span>
                    </div>
                </a>
            </li>
            @endcan
            @endif

            @can('reports.index')
            <li class="menu {{ active('admin/informes', 0) }}">
                <a href="{{ route('informes.index') }}" aria-expanded="{{ menu_expanded('admin/informes', 0) }}" class="dropdown-toggle">
                    <div class="">
                        <span><i class="fa fa-list"></i> Informes</span>
                    </div>
                </a>
            </li>
            @endcan
        </ul>

    </nav>

</div>