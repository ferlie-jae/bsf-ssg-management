@extends('configuration.role_permission.index')

@section('roles_configuration_tab_content')
    @can('roles.create')
    <button class="btn btn-default text-primary float-right" data-toggle="modal-ajax" data-href="{{ route('roles.create') }}" data-target="#addRole">Add Role</button>
    @endcan
    <table class="table table-sm" id="rolesTable" width="100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            {{-- @forelse($roles as $role)
            <tr>
                <td>{{ $role->name }}</td>
                <td></td>
            </tr>
            @empty --}}
            {{-- <tr>
                <td colspan="3" class="text-danger text-center">*** EMPTY ***</td>
            </tr> --}}
            <tr>
                <td colspan="3" class="text-info text-center">Loading <i class="fa fa-spinner fa-pulse fa-spin fa-lg"></i></td>
            </tr>
            {{-- @endforelse --}}
        </tbody>
    </table>
    @endsection
@section('tab_content_script')
    <script type="text/javascript">
        $(function() {
            $('#rolesTable').DataTable({
                /*scrollY           : "100vh",
                scrollCollapse    : true,
                paging            : false,*/
                // processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('roles.index') }}',
                    type: 'GET'
                },
                columns: [
                    {data: 'name', name: 'name' },
                    {data: 'action', name: 'action', orderable: false, className: "text-center"},
                     ],
                order: [[0, 'desc']]
            });
        })
    </script>
@endsection