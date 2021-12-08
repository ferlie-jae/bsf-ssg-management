@extends('layouts.adminlte')
@section('style')
<link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/summernote/summernote-bs4.min.css') }}">
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Achievements</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6 text-right">
                @can('achievements.create')
                    {{-- <button class="btn btn-default" type="button" data-toggle="modal-ajax" data-href="{{ route('achievements.create') }}" data-target="#createAchievement"><i class="fa fa-plus"></i> Add</button> --}}
                    <a class="btn btn-default" href="{{ route('achievements.create') }}"><i class="fa fa-plus"></i> Add</a>
                @endcan
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col" id="accordion">
                @forelse ($achievements as $achievement)
                    <div class="card @if($achievement->trashed()) card-danger @else card-success @endif card-outline">
                        <a class="d-block" data-toggle="collapse" href="#achievement-{{ $achievement->id }}">
                            <div class="card-header d-flex p-0">
                                {{-- <div class="row"> --}}
                                    {{-- <div class="col-md-6"> --}}
                                    <h4 class="card-title p-3 text-dark">
                                        {{ $achievement->title }}
                                        @if($achievement->trashed())
                                        <strong class="text-danger">
                                            [DELETED]
                                        </strong>
                                        @endif
                                    </h4>
                                    {{-- </div> --}}
                                    <ul class="nav nav-pills ml-auto p-2">
                                        @if ($achievement->trashed())
                                            @can('achievements.restore')
                                            <li class="nav-item">
                                                <a class="nav-link text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('achievements.restore', $achievement->id) }}"><i class="fad fa-download"></i> Restore</a>
                                            </li>
                                            @endcan
                                        @else
                                            @can('achievements.destroy')
                                            <li class="nav-item">
                                                <a class="nav-link text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('achievements.destroy', $achievement->id) }}"><i class="fad fa-trash-alt"></i> Delete</a>
                                            </li>
                                            @endcan
                                        @endif
                                        @can('achievements.edit')
                                        <li class="nav-item">
                                            <a class="nav-link text-primary" href="{{ route('achievements.edit', $achievement->id) }}"><i class="fad fa-edit"></i> Edit</a>
                                        </li>
                                        @endcan
                                    </ul>
                                {{-- </div> --}}
                            </div>
                        </a>
                        <div id="achievement-{{ $achievement->id }}" class="collapse @if($loop->first) show @endif" data-parent="#accordion">
                            <div class="card-body">
                                {!! $achievement->content !!}
                                <br>
                                <label>Date Published:</label>
                                {{ date('F d, Y h:i A', strtotime($achievement->created_at)) }}
                            </div>
                        </div>
                    </div>
                @empty
                <div class="alert alert-warning text-center">
                    *** EMPTY ***
                </div>
                @endforelse
            </div>
            {{-- <div class="col">
                <table id="datatable" class="table table-sm table-bordered table-striped">
                    <thead>
                        <tr>
                            @role('System Administrator')
                            <th>ID</th>
                            @endrole
                            <th>Title</th>
                            <th>Description</th>
                            <th>Date Created</th>
                            @role('System Administrator')
                            <th class="text-center">Action</th>
                            @endrole
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($achievements as $achievement)
                        <tr @unlessrole('System Administrator') @can('achievements.show') data-toggle="modal-ajax" data-target="#showAchievement" data-href="{{ route('achievements.show', $achievement->id) }}"  @endcan @else class="{{ $achievement->trashed() ? 'table-danger' : '' }}" @endunlessrole>
                            @role('System Administrator')
                            <td>{{ $achievement->id }}</td>
                            @endrole
                            <td>{{ $achievement->title }}</td>
                            <td>{{ $achievement->description }}</td>
                            <td>
                                {{ date('F d, Y h:i A', strtotime($achievement->created_at)) }}
                            </td>
                            @role('System Administrator')
                                <td class="text-center">
                                    <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#showAchievement" data-href="{{ route('achievements.show',$achievement->id) }}"><i class="fad fa-file fa-lg"></i></a>
                                    @if ($achievement->trashed())
                                        <a class="text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('achievements.restore', $achievement->id) }}"><i class="fad fa-download fa-lg"></i></a>
                                    @else
                                        <a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('achievements.destroy', $achievement->id) }}"><i class="fad fa-trash-alt fa-lg"></i></a>
                                    @endif
                                </td>
                            @endrole
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> --}} 
        </div>
    </div>
</section>
@endsection