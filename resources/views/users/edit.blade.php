<form method="POST" action="{{ route('users.update', $user->id) }}" autocomplete="off">
@csrf
@method('PUT')
    <div class="modal fade" id="editUser" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <a href="javascript:void(0)" class="close" data-dismiss="modal-ajax">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Role:</label>
                                <select style="width: 100%" class="form-control select2{{ $errors->has('role') ? ' is-invalid' : '' }}" name="role">
                                    <option></option>
                                    @foreach ($roles as $role)
                                        <option @if(old('role') == $role->id){{'selected'}}@elseif($user->role->role_id == $role->id){{'selected'}}@endif value="{{ $role->id }}">
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('role'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('E-Mail Address') }}:</label>
                                <input type="email" value="@if(old('email')){{ old('email') }}@else{{ $user->email }}@endif" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email">
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="username">{{ __('Username') }}:</label>
                                <input id="username" value="@if(old('username')){{ old('username') }}@else{{ $user->username }}@endif" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username">
                                @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button class="btn btn-default btn-block text-primary" type="button" data-target="#changePassword" data-toggle="collapse" aria-expanded="false" aria-controls="changePassword"><i class="fa fa-lock"></i> Change Password</button>
                            <div id="changePassword" class="callout callout-warning pt-2 pb-2 pr-5 pl-5 collapse">
                                <div class="form-group">
                                    <label for="password">{{ __('Password') }}:</label>
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
                                    @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="password-confirm">{{ __('Confirm Password') }}:</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    @if(Auth::user()->id != $user->id)
                    <div class="col">
                        @if ($user->trashed())
                            @can('users.restore')
                            <a class="btn btn-default text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('users.restore', $user->id) }}"><i class="fad fa-download"></i> Restore</a>
                            @endcan
                        @else
                            @can('users.destroy')
                            <a class="btn btn-default text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('users.destroy', $user->id) }}"><i class="fad fa-trash-alt"></i> Delete</a>
                            @endcan
                        @endif
                    </div>
                    @endif
                    <div class="col text-right">
                        <button class="btn btn-default" type="button" data-dismiss="modal-ajax">Cancel</button>
                        <button type="submit" class="btn btn-default text-success btn-submit"><i class="fad fa-save"></i> Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>