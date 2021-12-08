@extends('configuration.role_permission.index')
@section('roles_configuration_tab_content')
    @can('permissions.create')
    <button class="btn btn-primary float-right" data-toggle="modal-ajax" data-href="{{ route('permissions.create') }}"  data-target="#addPermission">Add Permission</button>
    @endcan
    <table class="table table-sm" id="permissionsTable" style="width: 100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Group</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="3" class="text-info text-center">Loading <i class="fa fa-spinner fa-pulse fa-spin fa-lg"></i></td>
            </tr>
        </tbody>
    </table>
@endsection
@section('tab_content_script')
    <script type="text/javascript">
        $(function() {
            $('#permissionsTable').DataTable({
                /*scrollY           : "100vh",
                scrollCollapse    : true,
                paging            : false,*/
                // processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('permissions.index') }}',
                    type: 'GET'
                },
                columns: [
                    {data: 'name', name: 'name' },
                    {data: 'group', name: 'group' },
                    {data: 'action', name: 'action', orderable: false, className: "text-center"},
                    ],
                order: [[0, 'desc']]
            });
        })
    </script>
@endsection