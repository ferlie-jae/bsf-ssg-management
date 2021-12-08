<form action="{{ route('elections.update', $election->id) }}" method="POST" autocomplete="off">
    @csrf
    @method('PUT')
	<div class="modal fade" id="editElection" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Election</h5>
                    <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <legend>Election Info:</legend>
                            <div class="form-group">
                                <label>Title:</label>
                                <input class="form-control" type="text" name="title" value="{{ $election->title }}" required>
                            </div>
                            <div class="form-group">
                                <label>Description:</label>
                                <textarea name="description" rows="4" class="form-control">{{ $election->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Election Start Date:</label>
                                <div class="input-group datetimepicker" id="startDate" data-target-input="nearest">
                                    <input type="text" name="start_date" class="form-control datetimepicker-input" data-target="#startDate" data-toggle="datetimepicker" value="{{ date('m/d/Y h:i A', strtotime($election->start_date)) }}" required/>
                                    <div class="input-group-append" data-target="#startDate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Election End Date:</label>
                                <div class="input-group datetimepicker" id="endDate" data-target-input="nearest">
                                    <input type="text" name="end_date" class="form-control datetimepicker-input" data-target="#endDate" data-toggle="datetimepicker" value="{{ date('m/d/Y h:i A', strtotime($election->end_date)) }}" required/>
                                    <div class="input-group-append" data-target="#endDate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <legend>Candidates:</legend>
                            @foreach ($positions as $position)
                            <script type="text/javascript">
                                $(function(){
                                    $('#oldInput').find('input[name="old_candidates[{{ $position->id}}][]"]').each(function(){
                                        $('select[name="candidates[{{ $position->id}}][]"] > option[value="'+$(this).val()+'"').prop('selected', true)
                                    })
                                })
                            </script>
                            <div class="form-group col-md-12">
                                <label>{{ $position->name }}:</label>
                                <select class="form-control candidates-select2" multiple name="candidates[{{ $position->id}}][]" data-position-id="{{ $position->id}}" style="width: 100%">
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}" @if($election->findCandidate($student->id, $position->id)) selected @endif>{{ $student->getStudentNameLNF() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endforeach
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
<script type="text/javascript">
    $(function(){
        $('.candidates-select2').select2({
            sorter: data => data.sort((a, b) => a.text.localeCompare(b.text)),
            theme: "bootstrap4",
            placeholder: "Select",
            allowClear: true
        })

        var selectedCandidatesOptions = [];
        $('.candidates-select2').each(function(){
            filterCandidates($(this))
        })
        $('.candidates-select2').change(function(){
            filterCandidates($(this))
        })

        function filterCandidates(candidateSelect){
            var value = $(candidateSelect).val();
            var id = $(candidateSelect).data('position-id');
            // removed options on other position options
            var selectedOptions = [];
            $('.candidates-select2').each(function(){
                // insert all selected candidates on array
                $('.candidates-select2[data-position-id="'+$(this).data('position-id')+'"] :selected').each(function(){
                    var candidate = '<option value="' + $(this).attr('value') + '">' + $(this).html() + '</option>';
                    selectedOptions.push(candidate)
                })
                if($(this).data('position-id') != id) {
                    for (let index = 0; index < value.length; index++) {
                        var removeCandidate = $('.candidates-select2[data-position-id="'+$(this).data('position-id')+'"] > option[value="'+value[index]+'"]');
                        var candidateOption = '<option value="' + value[index] + '">' + removeCandidate.html() + '</option>';
                        if(selectedCandidatesOptions.indexOf(candidateOption) == -1 && removeCandidate.html() != undefined){
                            selectedCandidatesOptions.push(candidateOption)
                        }
                        // remove selected candidate on other position options
                        removeCandidate.remove() 
                    }

                }
                
            })

            // Finalized selected candidates
            for (let index = 0; index < selectedCandidatesOptions.length; index++) {
                var removedOption = selectedCandidatesOptions[index]
                var indexOfFinalSelected = selectedOptions.indexOf(selectedCandidatesOptions[index]);
                if(indexOfFinalSelected == -1){
                    // insert removed candidate
                    $('.candidates-select2').each(function(){
                        if($(this).data('position-id') != id) {
                            $('.candidates-select2[data-position-id="'+$(this).data('position-id')+'"]').prepend(removedOption)
                        }
                    })
                    selectedCandidatesOptions.splice(index, 1)
                }
            }

            $('.candidates-select2').each(function(){
                if($(this).data('position-id') != id) {
                    $(this).select2({
                        sorter: data => data.sort((a, b) => a.text.localeCompare(b.text)),
                        theme: "bootstrap4",
                        placeholder: "Select",
                        allowClear: true
                    })
                }
            })
        }
    })
</script>
