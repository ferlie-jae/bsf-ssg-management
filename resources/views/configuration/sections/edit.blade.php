<form action="{{ route('sections.update', $section->id) }}" method="POST" autocomplete="off">
    @csrf
    @method('PUT')
    <div class="modal fade" id="editSection" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Sections</h5>
                    <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
						        <label for="name">Year Level:</label>
						        {{-- <input id="name" type="text" class="form-control{{ $errors->has('grade_level') ? ' is-invalid' : '' }}" name="grade_level" value="{{ old('grade_level') ?? $section->grade_level }}"> --}}
                                <select name="grade_level" class="form-control{{ $errors->has('grade_level') ? ' is-invalid' : '' }} select2">
                                    <option value="7" @if($section->grade_level == 7) selected @endif>Grade 7</option>
                                    <option value="8" @if($section->grade_level == 8) selected @endif>Grade 8</option>
                                    <option value="9" @if($section->grade_level == 9) selected @endif>Grade 9</option>
                                    <option value="10" @if($section->grade_level == 10) selected @endif>Grade 10</option>
                                    <option value="11" @if($section->grade_level == 11) selected @endif>Grade 11</option>
                                    <option value="12" @if($section->grade_level == 12) selected @endif>Grade 12</option>
                                </select>
                                @if ($errors->has('grade_level'))
						            <span class="invalid-feedback" role="alert">
						                <strong>{{ $errors->first('grade_level') }}</strong>
						            </span>
						        @endif
                            </div>
                            <div class="form-group">
						        <label for="name">Name:</label>
						        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') ?? $section->name }}">
						        @if ($errors->has('name'))
						            <span class="invalid-feedback" role="alert">
						                <strong>{{ $errors->first('name') }}</strong>
						            </span>
						        @endif
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