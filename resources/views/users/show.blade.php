@php
    $user_info;
    if(isset($user->student->id)){
        $user_info = $user->student->student;
    }else{
        $user_info = $user->faculty->faculty;
    }
@endphp
<div class="modal fade" id="showUser" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    User - {{ $user_info->fullname('f-m-l') }}
                </h5>
                <a href="javascript:void(0)" class="close" data-dismiss="modal-ajax">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <label class="col-sm-4">Role</label>
                            <span class="col-sm-8">:
                                {{ $user->role->role->name }}
                            </span>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Username</label>
                            <span class="col-sm-8">:
                                {{ $user->username }}
                            </span>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Email</label>
                            <span class="col-sm-8">:
                                {{ $user->email }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        @isset($user->student->id)
                        <div class="row">
                            <label class="col-sm-4">Student ID</label>
                            <span class="col-sm-8">:
                                {{ $user_info->student_id }}
                            </span>
                        </div>
                        @else
                        <div class="row">
                            <label class="col-sm-4">Faculty ID</label>
                            <span class="col-sm-8">:
                                {{ $user_info->faculty_id }}
                            </span>
                        </div>
                        @endisset
                        <div class="row">
                            <label class="col-sm-4">First Name</label>
                            <span class="col-sm-8">:
                                {{ $user_info->first_name }}
                            </span>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Middle Name</label>
                            <span class="col-sm-8">:
                                {{ $user_info->middle_name }}
                            </span>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Last Name</label>
                            <span class="col-sm-8">:
                                {{ $user_info->last_name }}
                            </span>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Gender</label>
                            <span class="col-sm-8">:
                                {{ $user_info->gender }}
                            </span>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Contact #</label>
                            <span class="col-sm-8">:
                                {{ $user_info->last_name }}
                            </span>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Address #</label>
                            <span class="col-sm-8">:
                                {{ $user_info->address }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
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
					@can('users.edit')
					   <a class="btn btn-default text-primary" href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('users.edit', $user->id) }}" data-target="#editUser"><i class="fad fa-edit"></i> Edit</a>
					@endcan
				</div>
				<div class="col text-right">
					<button class="btn btn-default" type="button" data-dismiss="modal-ajax"> Close</button>
				</div>
			</div>
        </div>
    </div>
</div>