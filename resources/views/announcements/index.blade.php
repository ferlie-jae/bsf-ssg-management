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
                <h1 class="m-0">Announcements</h1>
            </div>
            <div class="col-sm-6 text-right">
                @can('announcements.create')
                    <a class="btn btn-default" href="{{ route('announcements.create') }}"><i class="fa fa-plus"></i> Add</a>
                @endcan
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col" id="accordion">
                @forelse ($announcements as $announcement)
                    <div class="card @if($announcement->trashed()) card-danger @else card-success @endif card-outline">
                        <a class="d-block" data-toggle="collapse" href="#announcement-{{ $announcement->id }}">
                            <div class="card-header d-flex p-0">
                                {{-- <div class="row"> --}}
                                    {{-- <div class="col-md-6"> --}}
                                    <h4 class="card-title p-3 text-dark">
                                        {{ $announcement->title }}
                                        @if($announcement->trashed())
                                        <span class="alert alert-danger">
                                            [DELETED]
                                        </span>
                                        @endif
                                    </h4>
                                    {{-- </div> --}}
                                    <ul class="nav nav-pills ml-auto p-2">
                                        @if ($announcement->trashed())
                                            @can('announcements.restore')
                                            <li class="nav-item">
                                                <a class="nav-link text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('announcements.restore', $announcement->id) }}"><i class="fad fa-download"></i> Restore</a>
                                            </li>
                                            @endcan
                                        @else
                                            @can('announcements.destroy')
                                            <li class="nav-item">
                                                <a class="nav-link text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('announcements.destroy', $announcement->id) }}"><i class="fad fa-trash-alt"></i> Delete</a>
                                            </li>
                                            @endcan
                                        @endif
                                        @can('announcements.edit')
                                        <li class="nav-item">
                                            <a class="nav-link text-primary" href="{{ route('announcements.edit', $announcement->id) }}"><i class="fad fa-edit"></i> Edit</a>
                                        </li>
                                        @endcan
                                    </ul>
                                {{-- </div> --}}
                            </div>
                        </a>
                        <div id="announcement-{{ $announcement->id }}" class="collapse @if($loop->first) show @endif" data-parent="#accordion">
                            <div class="card-body">
                                {!! $announcement->content !!}
                                <br>
                                <label>Date Published:</label>
                                {{ date('F d, Y h:i A', strtotime($announcement->created_at)) }}
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
                        @foreach ($announcements as $announcement)
                        <tr @unlessrole('System Administrator') @can('announcements.show') data-toggle="modal-ajax" data-target="#showAnnouncement" data-href="{{ route('announcements.show', $announcement->id) }}"  @endcan @else class="{{ $announcement->trashed() ? 'table-danger' : '' }}" @endunlessrole>
                            @role('System Administrator')
                            <td>{{ $announcement->id }}</td>
                            @endrole
                            <td>{{ $announcement->title }}</td>
                            <td>{{ $announcement->description }}</td>
                            <td>
                                {{ date('F d, Y h:i A', strtotime($announcement->created_at)) }}
                            </td>
                            @role('System Administrator')
                                <td class="text-center">
                                    <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#showAnnouncement" data-href="{{ route('announcements.show',$announcement->id) }}"><i class="fad fa-file fa-lg"></i></a>
                                    @if ($announcement->trashed())
                                        <a class="text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('announcements.restore', $announcement->id) }}"><i class="fad fa-download fa-lg"></i></a>
                                    @else
                                        <a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('announcements.destroy', $announcement->id) }}"><i class="fad fa-trash-alt fa-lg"></i></a>
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