@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Sections</h1>
            </div>
            <div class="col-sm-6 text-right">
                @can('sections.create')
                    <button class="btn btn-default" type="button" data-toggle="modal-ajax" data-href="{{ route('sections.create') }}" data-target="#createSection"><i class="fa fa-plus"></i> Add</button>
                @endcan
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col" id="accordion">
                @foreach ($gradeLevels as $gradeLevel => $sections)
                    <div class="card card-info card-outline">
                        <a class="d-block" data-toggle="collapse" href="#grade-{{ $gradeLevel }}">
                            <div class="card-header d-flex p-0">
                                <h4 class="card-title p-3 text-dark">
                                    Grade {{ $gradeLevel }}
                                </h4>
                            </div>
                        </a>
                        <div id="grade-{{ $gradeLevel }}" class="collapse" data-parent="#accordion">
                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover datatable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Grade Level</th>
                                            <th>Name</th>
                                            @role('System Administrator')
                                            <th class="text-center">Action</th>
                                            @endrole
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sections as $index => $section)
                                        <tr @unlessrole('System Administrator') @can('sections.edit') data-toggle="modal-ajax" data-target="#editSection" data-href="{{ route('sections.edit', $section->id) }}"  @endcan @else class="{{ $section->trashed() ? 'table-danger' : '' }}" @endunlessrole>
                                            <td>{{ $index+1 }}</td>
                                            <td>Grade {{ $section->grade_level }}</td>
                                            <td>{{ $section->name }}</td>
                                            @role('System Administrator')
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#showSection" data-href="{{ route('sections.show',$section->id) }}"><i class="fad fa-file fa-lg"></i></a>
                                                    {{-- <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#editSection" data-href="{{ route('sections.edit',$section->id) }}"><i class="fad fa-edit fa-lg"></i></a> --}}
                                                    @if ($section->trashed())
                                                        <a class="text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('sections.restore', $section->id) }}"><i class="fad fa-download fa-lg"></i></a>
                                                    @else
                                                        <a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('sections.destroy', $section->id) }}"><i class="fad fa-trash-alt fa-lg"></i></a>
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
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection