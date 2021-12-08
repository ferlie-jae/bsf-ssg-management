<form action="{{ route('students.store') }}" method="POST" autocomplete="off">
    @csrf
    <div class="modal fade" id="createStudent" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Student</h5>
                    <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Student ID:</label><br>
                                <input class="form-control" type="text" name="student_id" required>
                            </div>
                            <div class="form-group">
                                <label>Grade/Section:</label><br>
                                <select class="form-control select2" name="section">
                                    <option></option>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}" @if(old('section') == $section->id) selected @endif >
                                            {{ $section->grade_level }}
                                            {{ $section->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>First Name:</label><br>
                                <input class="form-control" type="text" name="first_name" value="{{ old('first_name') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Middle Name:</label><br>
                                <input class="form-control" type="text" name="middle_name" value="{{ old('middle_name') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Last Name:</label><br>
                                <input class="form-control" type="text" name="last_name" value="{{ old('last_name') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Gender:</label><br>
                                <div class="form-row">
                                    <div class="radio col-md-4">
                                        <div class="custom-control custom-radio">
                                            <input required type="radio" class="custom-control-input" name="gender" value="Male" id="male" @if(old('gender') == 'Male') checked @endif>
                                            <label class="custom-control-label" for="male">Male</label>
                                        </div>
                                    </div>
                                    <div class="radio col-md-4">
                                        <div class="custom-control custom-radio">
                                            <input required type="radio" class="custom-control-input" name="gender" value="Female" id="female" @if(old('gender') == 'Female') checked @endif>
                                            <label class="custom-control-label" for="female">Female</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Birth Date:</label><br>
                                <input class="form-control" type="date" name="birth_date" value="{{ old('birth_date') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Contact #:</label><br>
                                <input class="form-control" type="text" name="contact_number" value="{{ old('contact_number') }}">
                            </div>
                            <div class="form-group">
                                <label>Address:</label>
                                <textarea class="form-control" name="address" rows="3">{{ old('address') }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="checkbox">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="add_user_account" value="1" id="addUserAccount">
                                        <label class="custom-control-label" for="addUserAccount">Add User Account</label>
                                    </div>
                                </div>
                            </div>
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal-ajax">Cancel</button>
                    <button class="btn btn-default text-success" type="submit"><i class="fas fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
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
            }else{
                $('#userCredentials input').attr('disabled', true)
                $('#userCredentials select').attr('disabled', true)
            }
        }
    })
</script>