<div class="modal fade" id="showStudent" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="Student" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
	          <h4 class="modal-title">{{ $student_show->getStudentName() }}</h4>
	          <button type="button" class="close" data-dismiss="modal-ajax" aria-hidden="true">&times;</button>
	    	</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label>Student ID: </label>
                        {{ $student_show->student_id }}
                        <br>
                        <label>Year/Section: </label>
                        {{ $student_show->section->section->grade_level }}
                        {{ $student_show->section->section->name }}
                        <br>
                        <label>First Name: </label>
                        {{ $student_show->first_name }}
                        <br>
                        <label>Middle Name: </label>
                        {{ $student_show->middle_name }}
                        <br>
                        <label>Last Name: </label>
                        {{ $student_show->last_name }}
                        <br>
                        <label>Gender: </label>
                        {{ $student_show->gender }}
                        <br>
                        <label>Birth Date: </label>
                        {{ date('F d, Y', strtotime($student_show->birth_date)) }}
                        <br>
                        <label>Contact #: </label>
                        {{ $student_show->contact_number }}
                        <br>
                        <label>Address: </label>
                        {{ $student_show->address }}
                    </div>
                    <div class="col-md-6">
                        <label>Account Status: </label>
                        @isset ($student_show->user)
                        <span class="text-success">Active</span>
                        <br>
                        <label>Username #: </label>
                        {{ $student_show->user->user->username }}
                        <br>
                        <label>Email #: </label>
                        {{ $student_show->user->user->email }}
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
                            <input type="hidden" name="user_id" value="{{ $student_show->id }}">
                            <div id="userCredentials">
                                <label>Role:</label><br>
                                <select class="form-control select2" name="role" required>
                                    <option></option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-group">
                                    <label>Username:</label><br>
                                    <input class="form-control" type="text" name="username" required>
                                </div>
                                <div class="form-group">
                                    <label>Email:</label><br>
                                    <input class="form-control" type="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label>Password:</label><br>
                                    <input id="password" type="password" class="form-control" name="password" required>
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password:</label><br>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                                <button class="btn btn-default text-success" type="submit"><i class="fas fa-save"></i> Save</button>
                            </form>
                        </div>
                        @endcan
                        @endif
                    </div>
                </div>
			</div>
			<div class="modal-footer">
				<div class="col">
					@if ($student_show->trashed())
                		@can('students.restore')
					    <a class="btn btn-default text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('students.restore', $student_show->id) }}"><i class="fad fa-download"></i> Restore</a>
						@endcan
					@else
						@can('students.destroy')
					    <a class="btn btn-default text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('students.destroy', $student_show->id) }}"><i class="fad fa-trash-alt"></i> Delete</a>
						@endcan
					@endif
					@can('students.edit')
					   <a class="btn btn-default text-primary" href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('students.edit', $student_show->id) }}" data-target="#editStudent"><i class="fad fa-edit"></i> Edit</a>
					@endcan
				</div>
				<div class="col text-right">
					<button class="btn btn-default" type="button" data-dismiss="modal-ajax"> Close</button>
				</div>
			</div>
	    </div>
	</div>
</div>
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