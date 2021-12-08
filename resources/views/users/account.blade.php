@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Account</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <form action="{{ route('account.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <legend>Profile Picture</legend>
                    <div class="row">
                        <div class="form-group col-md-7">
                            <img id="img" width="100%" class="img-thumbnail" style="border: none; background-color: transparent" src="{{ asset($user->avatar()) }}" />
                            <label class="btn btn-primary btn-block">
                                Browse&hellip;<input value="" type="file" name="image" style="display: none;" id="upload" accept="image/png, image/jpeg" />
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <legend>Change Password</legend>
                    <div class="form-group">
                        <label for="old_password">Old Password</label>
                        <input id="old_password" name="old_password" type="password" class="form-control {{ $errors->has('old_password') ? 'is-invalid' : '' }}" requred>
                        @if($errors->has('old_password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('old_password') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input id="new_password" name="new_password" type="password" class="form-control {{ $errors->has('new_password') ? 'is-invalid' : '' }}" requred>
                        @if($errors->has('new_password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('new_password') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="new_password_confirmation">Confirm New Password</label>
                        <input id="new_password_confirmation" name="new_password_confirmation" type="password" class="form-control {{ $errors->has('new_password_confirmation') ? 'is-invalid' : '' }}" requred>
                        @if($errors->has('new_password_confirmation'))
                            <div class="invalid-feedback">
                                {{ $errors->first('new_password_confirmation') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-right mb-5">
                    <button class="btn btn-success text-right" type="submit"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
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
@endsection