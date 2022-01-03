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
                                <label>Student ID: <strong class="text-danger">*</strong></label><br>
                                <input class="form-control" type="text" name="student_id" required>
                            </div>
                            <div class="form-group">
                                <label>Grade/Section: <strong class="text-danger">*</strong></label><br>
                                <select class="form-control select2" name="section">
                                    <option></option>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}" @if(old('section') == $section->id) selected @endif >
                                            Grade {{ $section->grade_level }}
                                            {{ $section->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>First Name: <strong class="text-danger">*</strong></label><br>
                                <input class="form-control" type="text" name="first_name" value="{{ old('first_name') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Middle Name:</label><br>
                                <input class="form-control" type="text" name="middle_name" value="{{ old('middle_name') }}">
                            </div>
                            <div class="form-group">
                                <label>Last Name: <strong class="text-danger">*</strong></label><br>
                                <input class="form-control" type="text" name="last_name" value="{{ old('last_name') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Suffix:</label><br>
                                <input class="form-control" type="text" name="suffix">
                            </div>
                            <div class="form-group">
                                <label>Gender: <strong class="text-danger">*</strong></label><br>
                                <div class="form-row">
                                    <div class="radio col-md-4">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="gender" value="male" id="male" @if(old('gender') == 'male') checked @endif required>
                                            <label class="custom-control-label" for="male">Male</label>
                                        </div>
                                    </div>
                                    <div class="radio col-md-4">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="gender" value="female" id="female" @if(old('gender') == 'female') checked @endif required>
                                            <label class="custom-control-label" for="female">Female</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="birthDate">Birth Date: <strong class="text-danger">*</strong></label><br>
                                <input id="birthDate" onchange="calculateAge(this)" class="form-control" type="date" name="birth_date" value="{{ old('birth_date') }}" required>
                                <span id="age"></span>
                                <span class="invalid-feedback" role="alert">
                                    <strong>Age must be 6 years old and above.</strong>
                                </span>
                            </div>
                            <div class="form-group">
                                <label>Contact #:</label><br>
                                <input class="form-control" type="tel" pattern="^(09|\+639)\d{9}$" name="contact_number" value="{{ old('contact_number') }}">
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
                                <div class="form-group">
                                    <label>Email: <strong class="text-danger">*</strong></label>
                                    <input class="form-control" type="email" name="email" required>
                                </div>
                            </div>
                        </div>
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
<script>
    function calculateAge(input){
        var dob = $(input).val();
        dob = new Date(dob);
        var today = new Date();
        var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
        if(age < 6){
            $('#btnSubmit').prop('disabled', true)
            $(input).addClass('is-invalid');
        }else{
            $('#btnSubmit').prop('disabled', false)
            $(input).removeClass('is-invalid');
        }
        if(age > -1){
            $('#age').html(age+' years old');
        }else{
            $('#age').html('0 years old');
        }
    }
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