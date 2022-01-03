@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $student->student_id }} | {{ $student->fullname('') }}</h1>
            </div>
            <div class="col-sm-6 text-right">
                @if ($student->trashed())
                    @can('students.restore')
                    <a class="btn btn-default text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('students.restore', $student->id) }}"><i class="fad fa-download"></i> Restore</a>
                    @endcan
                @else
                    @can('students.destroy')
                    <a class="btn btn-default text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('students.destroy', $student->id) }}"><i class="fad fa-trash-alt"></i> Delete</a>
                    @endcan
                @endif
                @can('students.edit')
                    <a class="btn btn-default text-primary" href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('students.edit', $student->id) }}" data-target="#editStudent"><i class="fad fa-edit"></i> Edit</a>
                @endcan
                <a class="btn btn-default text-default" href="{{ route('students.index') }}" ><i class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <form action="{{ route('students.change_avatar', $student->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <img id="img" width="100%" class="img-thumbnail" src="{{ asset($student->avatar()) }}" />
                        <div class="btn-group btn-block">
                            <label type="button" class="btn btn-primary">
                                Browse&hellip;<input value="" type="file" name="image" style="display: none;" id="upload" accept="image/png, image/jpeg" required/>
                            </label>
                            <label type="button" class="btn btn-primary">
                                Upload<input type="submit" style="display: none;" />
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-3">
                <label>Student ID: </label>
                {{ $student->student_id }}
                <br>
                <label>Grade Level: </label>
                Grade 
                {{ $student->section->section->grade_level }}
                <br>
                <label>Section: </label>
                {{ $student->section->section->name }}
                <br>
                <label>First Name: </label>
                {{ $student->first_name }}
                <br>
                <label>Middle Name: </label>
                {{ $student->middle_name }}
                <br>
                <label>Last Name: </label>
                {{ $student->last_name }}
                <br>
                <label>Suffix: </label>
                {{ $student->suffix }}
            </div>
            <div class="col-md-3">
                <label>Gender: </label>
                {{ $student->gender }}
                <br>
                <label>Contact #: </label>
                {{ $student->contact_number }}
                <br>
                <label>Address: </label>
                {{ $student->address }}
            </div>
            <div class="col-md-3">
                <label>Account Status: </label>
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
                    <br>
                    <label>Username: </label>
                    @can('users.show')
                    <a href="{{ route('users.show',  $student->user->user->id) }}">
                        {{ $student->user->user->username }}
                    </a>
                    @else
                    {{ $student->user->user->username }}
                    @endcan
                    <br>
                    <label>Email: </label>
                    {{ $student->user->user->email }}
                @else
                    <span class="text-danger">N/A</span>
                    @can('users.create')
                        <div class="checkbox">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="add_user_account" value="1" id="addUserAccount">
                                <label class="custom-control-label" for="addUserAccount">Add User Account?</label>
                            </div>
                        </div>
                        <form action="{{ route('users.store') }}" method="POST" autocomplete="off">
                            @csrf
                            <input type="hidden" name="type" value="student">
                            <input type="hidden" name="user_id" value="{{ $student->id }}">
                            <input type="hidden" name="username" value="{{ $student->student_id }}">
                            <div id="userCredentials">
                                <div class="form-group">
                                    <label>Email: <strong class="text-danger">*</strong></label><br>
                                    <input class="form-control" type="email" name="email" required>
                                </div>
                                <button class="btn btn-default text-success" type="submit"><i class="fas fa-save"></i> Save</button>
                            </form>
                        </div>
                    @endcan
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
    <script>
        $(function(){
            $('#upload').change(function(){
                var input = this;
                var url = $(this).val();
                var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
                if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
                {
                    var reader = new FileReader();
                    
                    reader.onload = function (e) {
                        $('#img').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            });
        });
    </script>
    @can('users.create')
    <script>
        $(function(){
            addUserCredentials()

            $('#addUserAccount').on('change', function(){
                addUserCredentials()
            })

            function addUserCredentials(){
                if($('#addUserAccount').prop('checked')){
                    $('#userCredentials input').attr('disabled', false)
                    $('#userCredentials select').attr('disabled', false)
                    $('#userCredentials').css('display', 'block')
                }else{
                    $('#userCredentials input').attr('disabled', true)
                    $('#userCredentials select').attr('disabled', true)
                    $('#userCredentials').css('display', 'none')
                }
            }
        })
    </script>
    @endcan
@endsection