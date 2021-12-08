@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Elections</h1>
            </div>
            <div class="col-sm-6 text-right">
                @can('elections.create')
                    <a class="btn btn-default" href="{{ route('elections.create') }}"><i class="fa fa-plus"></i> Add</a>
                @endcan
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <table id="datatable" class="table table-sm table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Status</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Date of Election</th>
                            @role('System Administrator')
                            <th class="text-center">Action</th>
                            @endrole
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($elections as $index => $election)
                        <tr @unlessrole('System Administrator') @can('elections.show') data-toggle="tr-link" data-target="#showElection" data-href="{{ route('elections.show', $election->id) }}"  @endcan @else class="{{ $election->trashed() ? 'table-danger' : '' }}" @endunlessrole>
                            <td>{{ $index+1 }}</td>
                            <td>
                                {{ $election->status }}
                            </td>
                            <td>{{ $election->title }}</td>
                            <td>{{ $election->description }}</td>
                            <td>
                                {{ date('F d, Y h:i A', strtotime($election->start_date)) }}
                                -
                                {{ date('F d, Y h:i A', strtotime($election->end_date)) }}
                            </td>
                            @role('System Administrator')
                                <td class="text-center">
                                    {{-- <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#showElection" data-href="{{ route('elections.show',$election->id) }}"><i class="fad fa-file fa-lg"></i></a> --}}
                                    <a href="{{ route('elections.show',$election->id) }}"><i class="fad fa-file fa-lg"></i></a>
                                    @if ($election->trashed())
                                        <a class="text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('elections.restore', $election->id) }}"><i class="fad fa-download fa-lg"></i></a>
                                    @else
                                        <a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('elections.destroy', $election->id) }}"><i class="fad fa-trash-alt fa-lg"></i></a>
                                    @endif
                                </td>
                            @endrole
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection