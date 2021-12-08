@extends('layouts.adminlte')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Positions</h1>
            </div>
            <div class="col-sm-6 text-right">
                @can('positions.create')
                    <button class="btn btn-default" type="button" data-toggle="modal-ajax" data-href="{{ route('positions.create') }}" data-target="#createPosition"><i class="fa fa-plus"></i> Add</button>
                @endcan
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-sm table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Candidate to Elect</th>
                            @role('System Administrator')
                            <th class="text-center">Action</th>
                            @endrole
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($positions as $index => $position)
                        <tr @unlessrole('System Administrator') @can('positions.show') data-toggle="modal-ajax" data-target="#showPosition" data-href="{{ route('positions.show', $position->id) }}"  @endcan @else class="{{ $position->trashed() ? 'table-danger' : '' }}" @endunlessrole>
                            <td>{{ $index+1 }}</td>
                            <td>{{ $position->name }}</td>
                            <td>{{ $position->candidate_to_elect }}</td>
                            @role('System Administrator')
                                <td class="text-center">
                                    <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#showPosition" data-href="{{ route('positions.show',$position->id) }}"><i class="fad fa-file fa-lg"></i></a>
                                    {{-- <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#editPosition" data-href="{{ route('positions.edit',$position->id) }}"><i class="fad fa-edit fa-lg"></i></a> --}}
                                    @if ($position->trashed())
                                        <a class="text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('positions.restore', $position->id) }}"><i class="fad fa-download fa-lg"></i></a>
                                    @else
                                        <a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('positions.destroy', $position->id) }}"><i class="fad fa-trash-alt fa-lg"></i></a>
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