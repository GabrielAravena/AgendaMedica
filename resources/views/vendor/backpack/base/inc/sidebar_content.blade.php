<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
@can('panel.listar')
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
@endcan
@can('doctores.listar')
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('doctor') }}'><i class='nav-icon la la-question'></i> Doctores</a></li>
@endcan
@can('autenticacion.listar')
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Authentication</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> <span>Users</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
    </ul>
</li>
@endcan
@can('horas.listar')
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('hora') }}'><i class='nav-icon la la-question'></i> Horas</a></li>
@endcan
@can('agendas.listar')
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('agenda') }}'><i class='nav-icon la la-question'></i> Agendas</a></li>
@endcan
@can('agendar')
<li class='nav-item'><a class='nav-link' href='{{ route('agendar.index') }}'><i class='nav-icon la la-question'></i> Agendar</a></li>
@endcan
@can('especialidades.listar')
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('especialidad') }}'><i class='nav-icon la la-question'></i> Especialidades</a></li>
@endcan