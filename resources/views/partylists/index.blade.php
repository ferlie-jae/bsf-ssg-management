@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Partylists</h1>
            </div>
            <div class="col-sm-6 text-right">
                @can('partylists.create')
                    <button class="btn btn-default" type="button" data-toggle="modal-ajax" data-href="{{ route('partylists.create') }}" data-target="#createPartylist"><i class="fa fa-plus"></i> Add</button>
                @endcan
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <table id="datatable" class="table table-sm table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Partylist</th>
                            <th>Color</th>
                            @role('System Administrator')
                            <th class="text-center">Action</th>
                            @endrole
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($partylists as $index => $partylist)
                        <tr @unlessrole('System Administrator') @can('partylists.show') data-toggle="modal-ajax" data-target="#showPartylist" data-href="{{ route('partylists.show', $partylist->id) }}"  @endcan @else class="{{ $partylist->trashed() ? 'table-danger' : '' }}" @endunlessrole>
                            <td>{{ $index+1 }}</td>
                            <td>{{ $partylist->name }}</td>
                            <td>
                                <div class="alert mb-0" style="background-color: {{ $partylist->color }};color: {{ $partylist->color }}"></div>
                            </td>
                            @role('System Administrator')
                                <td class="text-center">
                                    <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#showPartylist" data-href="{{ route('partylists.show',$partylist->id) }}"><i class="fad fa-file fa-lg"></i></a>
                                    {{-- <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#editpartylist" data-href="{{ route('partylists.edit',$partylist->id) }}"><i class="fad fa-edit fa-lg"></i></a> --}}
                                    @if ($partylist->trashed())
                                        <a class="text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('partylists.restore', $partylist->id) }}"><i class="fad fa-download fa-lg"></i></a>
                                    @else
                                        <a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('partylists.destroy', $partylist->id) }}"><i class="fad fa-trash-alt fa-lg"></i></a>
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