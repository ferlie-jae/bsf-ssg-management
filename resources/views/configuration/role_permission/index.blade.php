@extends('layouts.adminlte')

@section('content')
{{-- Content Header (Page header) --}}
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Roles/Permissions</h1>
            </div>
        </div>
    </div>
</div>
{{-- /.content-header --}}
{{-- Main content --}}
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link {{ url()->current()==route('roles.index') ? 'active' : '' }}" href="{{ route('roles.index') }}">Roles</a>
                    @can('permissions.index')
                    <a class="nav-link {{ url()->current()==route('permissions.index') ? 'active' : '' }}" href="{{ route('permissions.index') }}">Permissions</a>
                    @endcan
                </div>
            </div>
            <div class="col-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-roles" role="tabpanel" aria-labelledby="v-pills-roles-tab">
                        {{-- @include('configuration.role_permission.roles.index') --}}
                        @yield('roles_configuration_tab_content')
                    </div>
                    {{-- @can('permissions.index')
                    <div class="tab-pane fade" id="v-pills-permissions" role="tabpanel" aria-labelledby="v-pills-permissions-tab">
                        <div class="tab-pane fade show active" id="v-pills-permissions" role="tabpanel" aria-labelledby="v-pills-permissions-tab">
                            @include('configuration.role_permission.permissions.index')
                        </div>
                    </div>
                    @endcan --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    @yield('tab_content_script')
@endsection
