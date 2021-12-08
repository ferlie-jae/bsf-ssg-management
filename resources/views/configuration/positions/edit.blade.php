<form action="{{ route('positions.update', $position_edit->id) }}" method="POST" autocomplete="off">
    @csrf
    @method('PUT')
    <div class="modal fade" id="editPosition" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Position</h5>
                    <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
						        <label for="name">Name:</label>
						        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') ?? $position_edit->name }}">
						        @if ($errors->has('name'))
						            <span class="invalid-feedback" role="alert">
						                <strong>{{ $errors->first('name') }}</strong>
						            </span>
						        @endif
                            </div>
                            <div class="form-group">
						        <label for="candidate_to_elect">Candidate to Elect:</label>
						        <input id="candidate_to_elect" type="number" min="1" class="form-control{{ $errors->has('candidate_to_elect') ? ' is-invalid' : '' }}" name="candidate_to_elect" value="{{ old('candidate_to_elect') ?? $position_edit->candidate_to_elect }}">
						        @if ($errors->has('candidate_to_elect'))
						            <span class="invalid-feedback" role="alert">
						                <strong>{{ $errors->first('candidate_to_elect') }}</strong>
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