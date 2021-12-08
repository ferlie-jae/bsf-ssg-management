@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Users</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <table id="datatable" class="table table-bordered table-hover table-sm">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Role</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            @role('System Administrator')
                            <th class="text-center">Action</th>
                            @endrole
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $index => $user)
                        <tr @unlessrole('System Administrator') @can('users.show') data-toggle="modal-ajax" data-target="#showUser" data-href="{{ route('users.show', $user->id) }}"  @endcan @else class="{{ $user->trashed() ? 'table-danger' : '' }}" @endunlessrole>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $user->role->role->name }}</td>
                        <td>
                            @isset($user->student->student)
                                {{ $user->student->student->fullname('f-m-l') }}
                            @else
                                {{ $user->faculty->faculty->fullname('f-m-l') }}
                            @endif
                        </td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        @role('System Administrator')
                            <td class="text-center">
                                <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#showUser" data-href="{{ route('users.show',$user->id) }}"><i class="fad fa-file-user fa-lg"></i></a>
                                @if ($user->trashed())
                                    <a class="text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('users.restore', $user->id) }}"><i class="fad fa-download fa-lg"></i></a>
                                @else
                                    @if($user->id != 1)
                                    <a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('users.destroy', $user->id) }}"><i class="fad fa-trash-alt fa-lg"></i></a>
                                    @endif
                                @endif
                            </td>
                        @endrole
                        </tr>
                        @endforeach
                        @if (count($users) == 0)
                        <tr>
                            <td class="text-danger text-center" colspan="6">*** Empty ***</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
