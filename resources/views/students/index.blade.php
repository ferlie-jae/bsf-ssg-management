@extends('layouts.adminlte')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Students</h1>
            </div>
            <div class="col-sm-6 text-right">
                @hasrole('System Administrator')
                <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#importStudents"><i class="fa fa-upload"></i> Import Students</button>
                @endhasrole
                @can('students.create')
                    <button class="btn btn-default" type="button" data-toggle="modal-ajax" data-href="{{ route('students.create') }}" data-target="#createStudent"><i class="fa fa-plus"></i> Add</button>
                @endcan
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card card-success card-outline card-tabs">
                    <div class="card-header p-0 pt-1 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                            @forelse ($gradeLevels as $gradeLevel => $sections)
                                <li class="nav-item">
                                    <a class="nav-link @if($loop->first) active @endif text-dark" id="grade-{{ $gradeLevel }}-tab" data-toggle="pill" href="#grade-{{ $gradeLevel }}" role="tab" aria-controls="grade-{{ $gradeLevel }}" @if($loop->first) aria-selected="true" @endif>
                                        Grade {{ $gradeLevel }}
                                    </a>
                                </li>
                            @empty
                            @endforelse
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="grade-tabContent">
                            @forelse ($gradeLevels as $gradeLevel => $sections)
                                <div class="tab-pane fade @if($loop->first) show active @endif" id="grade-{{ $gradeLevel }}" role="tabpanel" aria-labelledby="grade-{{ $gradeLevel }}-tab">
                                    @forelse ($sections as $section)
                                        <div class="col" id="accordion-{{ $section->id }}">
                                            <div class="card card-info  card-outline">
                                                <a class="d-block" data-toggle="collapse" href="#section-{{ $section->id }}-students">
                                                    <div class="card-header d-flex p-0">
                                                        <div class="col-md-6">
                                                            <h4 class="card-title p-3 text-dark">
                                                                {{ $section->name }}
                                                            </h4>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6 class="p-3 text-dark text-right">
                                                                ({{ $section->students->count() }} Students)
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </a>
                                                <div id="section-{{ $section->id }}-students" class="collapse" data-parent="#accordion-{{ $section->id }}">
                                                    <div class="card-body">
                                                        <table class="table table-sm table-bordered table-hover datatable">
                                                            <thead>
                                                                <tr>
                                                                    <th>ID</th>
                                                                    <th>Account Status</th>
                                                                    <th>Student ID</th>
                                                                    <th>Year Level</th>
                                                                    <th>Section</th>
                                                                    <th>First Name</th>
                                                                    <th>Middle Name</th>
                                                                    <th>Last Name</th>
                                                                    @role('System Administrator')
                                                                    <th class="text-center">Action</th>
                                                                    @endrole
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($section->students as $index => $student)
                                                                @php
                                                                    $student = $student->student;
                                                                @endphp
                                                                <tr @unlessrole('System Administrator') @can('students.show') data-toggle="tr-link" data-href="{{ route('students.show', $student->id) }}"  @endcan @else class="{{ $student->trashed() ? 'table-danger' : '' }}" @endunlessrole>
                                                                    <td>{{ $index+1 }}</td>
                                                                    <td>
                                                                        @isset ($student->user)
                                                                            @if($student->user->user->trashed())
                                                                                <span class="badge badge-danger">User data DELETED</span>
                                                                            @else
                                                                                @if($student->user->user->is_verified == 1)
                                                                                    <span class="badge badge-success">Verified</span>
                                                                                @else
                                                                                    <span class="badge badge-warning">Under Validation</span>
                                                                                @endif
                                                                            @endif
                                                                        @else
                                                                            <span class="text-danger">N/A</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $student->student_id }}</td>
                                                                    <td>
                                                                        Grade
                                                                        {{ $student->section->section->grade_level ?? "" }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $student->section->section->name ?? "" }}
                                                                    </td>
                                                                    <td>{{ $student->first_name }}</td>
                                                                    <td>{{ $student->middle_name }}</td>
                                                                    <td>{{ $student->last_name }}</td>
                                                                    @role('System Administrator')
                                                                        <td class="text-center">
                                                                            @if ($student->trashed())
                                                                                <a class="text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('students.restore', $student->id) }}"><i class="fad fa-download fa-lg"></i></a>
                                                                            @else
                                                                                <a href="{{ route('students.show',$student->id) }}"><i class="fad fa-file fa-lg"></i></a>
                                                                                <a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('students.destroy', $student->id) }}"><i class="fad fa-trash-alt fa-lg"></i></a>
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
                                        </div>
                                    @empty
                                    @endforelse
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            @role('System Administrator')
                @if(config('app.env') == 'local')
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            Insert Dummy Student
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" action="{{ route('dummy_identity.insert_student') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <hr>
                                <div class="form-group">
                                    <label>Number of Students: </label>
                                    <input class="form-control" type="number" name="number" max="15000" min="1" value="1">
                                </div>
                                <div class="form-group">
                                    <div class="checkbox">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="add_account" value="add_account" id="addAccount" checked>
                                            <label class="custom-control-label" for="addAccount">Add User Account</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="radio">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="stage" value="secondary" id="secondaryStage" checked>
                                            <label class="custom-control-label" for="secondaryStage">Secondary</label>
                                        </div>{{-- 
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="stage" value="tertiary" id="tertiaryStage">
                                            <label class="custom-control-label" for="tertiaryStage">Tertiary</label>
                                        </div> --}}
                                    </div>
                                </div>
                                <hr>
                                <button type="submit" class="btn btn-danger">Submit</button>					
                            </form>
                        </div>
                    </div>
                </div>	
                @endif
            @endrole
        </div>
    </div>
</section>
@hasrole('System Administrator')
<form action="{{ route('students.import') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="importStudents" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Student</h5>
                    <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="file" name="excel_file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal-ajax">Cancel</button>
                    <button id="btnSubmit" class="btn btn-default text-success" type="submit"><i class="fas fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endhasrole
@endsection