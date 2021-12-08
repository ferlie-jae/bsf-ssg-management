<form method="POST" action="{{ route('users.store') }}" autocomplete="off">
    @csrf
        <div class="modal fade" id="addUser" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add User</h5>
                        <a href="javascript:void(0)" class="close" data-dismiss="modal-ajax">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name">First Name:</label>
                                    <input id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}">
                                    {{-- @if ($errors->has('first_name')) --}}
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                                    {{-- @endif --}}
                                </div>
                                <div class="form-group">
                                    <label for="middle_name">Middle Name:</label>
                                    <input id="middle_name" type="text" class="form-control{{ $errors->has('middle_name') ? ' is-invalid' : '' }}" name="middle_name" value="{{ old('middle_name') }}">
                                    {{-- @if ($errors->has('middle_name')) --}}
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('middle_name') }}</strong>
                                        </span>
                                    {{-- @endif --}}
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Last Name:</label>
                                    <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}">
                                    {{-- @if ($errors->has('last_name')) --}}
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                    {{-- @endif --}}
                                </div>
                                <div class="form-group">
                                    <label for="contact_number">Contact Number:</label>
                                    <input id="contact_number" type="text" class="form-control{{ $errors->has('contact_number') ? ' is-invalid' : '' }}" name="contact_number" value="{{ old('contact_number') }}">
                                    {{-- @if ($errors->has('contact_number')) --}}
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('contact_number') }}</strong>
                                        </span>
                                    {{-- @endif --}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Role:</label>
                                    <select class="form-control select2{{-- {{ $errors->has('role') ? ' is-invalid' : '' }} --}}" name="role" style="width: 100%">
                                        <option></option>
                                        @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" @if(old('role') == $role->id){{'selected'}} @endif>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback">
                                        <strong class="text-danger">{{ $errors->first('role') }}</strong>
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label for="username">{{ __('Username') }}:</label>
                                    <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}">
                                    {{-- @if ($errors->has('username')) --}}
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                    {{-- @endif --}}
                                </div>
                                <div class="form-group">
                                    <label for="email">{{ __('E-Mail Address') }}:</label>
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}">
                                    {{-- @if ($errors->has('email')) --}}
                                        <span class="invalid-feedback" role="alert">
                                               <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    {{-- @endif --}}
                                </div>
                                <div class="form-group">
                                    <label for="password">{{ __('Password') }}:</label>
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
                                    {{-- @if ($errors->has('password')) --}}
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    {{-- @endif --}}
                                </div>
                                <div class="form-group">
                                    <label for="password-confirm">{{ __('Confirm Password') }}:</label>
                                    <input id="password-confirm" type="password" new-password class="form-control" name="password_confirmation">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default text-success"><i class="fad fa-save"></i> Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script type="application/javascript">
        $(function() {
            $('#employee').on('change', function(){
                var email = $(this).find(':selected').data('email');
                $('#email').val(email);
            })
        })
    </script>
    