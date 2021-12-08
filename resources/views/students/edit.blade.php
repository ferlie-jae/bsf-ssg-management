<form action="{{ route('students.update', $student_edit->id) }}" method="POST" autocomplete="off">
    @csrf
    @method('PUT')
    <div class="modal fade" id="editStudent" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Student</h5>
                    <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Student ID:</label><br>
                                <input class="form-control" type="text" name="student_id" required value="{{ $student_edit->student_id }}">
                            </div>
                            <div class="form-group">
                                <label>Year/Section:</label><br>
                                <select class="form-control select2" name="section" required>
                                    <option></option>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}" @if($student_edit->section->section_id == $section->id) selected @endif>
                                            {{ $section->grade_level }}
                                            {{ $section->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>First Name:</label><br>
                                <input class="form-control" type="text" name="first_name" value="{{ $student_edit->first_name }}" required>
                            </div>
                            <div class="form-group">
                                <label>Middle Name:</label><br>
                                <input class="form-control" type="text" name="middle_name" value="{{ $student_edit->middle_name }}" required>
                            </div>
                            <div class="form-group">
                                <label>Last Name:</label><br>
                                <input class="form-control" type="text" name="last_name" value="{{ $student_edit->last_name }}" required>
                            </div>
                            <div class="form-group">
                                <label>Gender:</label><br>
                                <div class="form-row">
                                    <div class="radio col-md-4">
                                        <div class="custom-control custom-radio">
                                            <input required type="radio" class="custom-control-input" name="gender" value="Male" id="male" @if($student_edit->gender == 'Male') checked @endif>
                                            <label class="custom-control-label" for="male">Male</label>
                                        </div>
                                    </div>
                                    <div class="radio col-md-4">
                                        <div class="custom-control custom-radio">
                                            <input required type="radio" class="custom-control-input" name="gender" value="Female" id="female" @if($student_edit->gender == 'Female') checked @endif>
                                            <label class="custom-control-label" for="female">Female</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Birth Date:</label><br>
                                <input class="form-control" type="date" name="birth_date" value="{{ $student_edit->birth_date }}" required>
                            </div>
                            <div class="form-group">
                                <label>Contact #:</label><br>
                                <input class="form-control" type="text" name="contact_number" value="{{ $student_edit->contact_number }}">
                            </div>
                            <div class="form-group">
                                <label>Address:</label>
                                <textarea class="form-control" name="address" rows="3">{{ $student_edit->address }}</textarea>
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
{{-- <script>
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
</script> --}}