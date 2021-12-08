@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Create Election</h1>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <form action="{{ route('elections.update', $election->id) }}" method="POST" autocomplete="off">
            @csrf
            @method('PUT')
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
                            <input type="text" name="start_date" value="{{ date('m/d/Y h:i A', strtotime($election->start_date)) }}" class="form-control datetimepicker-input" data-target="#startDate" data-toggle="datetimepicker" required/>
                            <div class="input-group-append" data-target="#startDate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Election End Date:</label>
                        <div class="input-group datetimepicker" id="endDate" data-target-input="nearest">
                            <input type="text" name="end_date" value="{{ date('m/d/Y h:i A', strtotime($election->end_date)) }}" class="form-control datetimepicker-input" data-target="#endDate" data-toggle="datetimepicker" required/>
                            <div class="input-group-append" data-target="#endDate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <legend>Candidates:</legend>
                    @foreach ($election->candidates->groupBy('position_id') as $position => $candidates)
                    {{-- <script type="text/javascript">
                        $(function(){
                            $('#oldInput').find('input[name="old_candidates[{{ $position->id}}][]"]').each(function(){
                                $('select[name="candidates[{{ $position->id}}][]"] > option[value="'+$(this).val()+'"').prop('selected', true)
                            })
                        })
                    </script> --}}
                    <div class="form-group">
                        <label>{{ App\Models\Configuration\Position::find($position)->name }}:</label>
                        <a href="javascript:void(0)" onclick="addCandidate({{ $position }})"><i class="fa fa-plus"></i> Add Candidate</a>
                        <div class="candidates-container" data-position-id="{{ $position }}">
                            @foreach ($candidates as $index => $candidate)
                                <div class="row candidate-selection" data-id="{{ $index }}" data-position-id="{{ $position }}">
                                    <div class="col-sm-6">
                                        <select class="form-control candidates-select2" name="candidates[{{ $position }}][]" data-id="{{ $index }}" data-position-id="{{ $position }}" onchange="updateCandidateSelection(this)">
                                            <option></option>
                                            @foreach ($students as $student)
                                                <option value="{{ $student->id }}" {{ $candidate->student_id == $student->id ? 'selected' : '' }}>{{ $student->student_id }} - {{ $student->fullname('') }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-group mb-2">
                                            <select class="form-control select2" name="candidate-partylists[{{ $position }}][]" data-id="{{ $index }}" data-position-id="{{ $position }}">
                                                <option></option>
                                                @foreach ($partylists as $partylist)
                                                    <option value="{{ $partylist->id }}" {{ $candidate->partylist_id == $partylist->id ? 'selected' : '' }}>{{ $partylist->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-danger remove-candidate-btn" onclick="filterCandidates({{ $position }},{{ $index }}, 0)">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                    <div class="form-group text-right">
                        <a href="{{ route('elections.index') }}" class="btn btn-default"><i class="fa fa-times"></i> Cancel</a>
                        <button type="submit" class="btn btn-default text-success"><i class="fad fa-save"></i> Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
@section('script')
<script type="text/javascript">
    
    var finalSelectedCandidates = [];

    $(function(){
        $('.candidates-select2').each(function(){
            $(this).select2({
                // sorter: data => data.sort((a, b) => a.text.localeCompare(b.text)),
                theme: "bootstrap4",
                placeholder: "Select",
                allowClear: true
            })
            filterCandidates($(this).data('position-id'), $(this).data('id'), 'select')
        })
    })
    

    function addCandidate(positionID){
        var candidateSelectionIDs = [];
        $('.candidates-container[data-position-id="'+positionID+'"]').find('.candidate-selection').each(function(){
            candidateSelectionIDs.push($(this).data('id'))
        });
        var dataID = candidateSelectionIDs[candidateSelectionIDs.length-1];
        if(dataID >= 0){
            dataID+=1;
        }else{
            dataID = 0;
        }
        var finalClone = 
        '<div class="row candidate-selection" data-id="'+dataID+'" data-position-id="'+positionID+'">'+
            '<div class="col-sm-6">' +
                '<div class="input-group-prepend">' +
                    '<select class="form-control candidates-select2" name="candidates['+positionID+'][]" data-id="'+dataID+'" data-position-id="'+positionID+'" onchange="updateCandidateSelection(this)">' +
                        '<option></option>' +
                        @foreach ($students as $student)
                            '<option value="{{ $student->id }}">{{ $student->student_id }} - {{ $student->fullname("") }}</option>' +
                        @endforeach
                    '</select>' +
                '</div>' +
            '</div>' +
            '<div class="col-sm-6">' +
                '<div class="input-group mb-2">' +
                    '<select class="form-control partylist-select" name="candidate-partylists['+positionID+'][]" data-position-id="'+positionID+'" data-id="'+dataID+'">' +
                        '<option></option>' +
                        @foreach ($partylists as $partylists)
                            '<option value="{{ $partylists->id }}">{{ $partylists->name }}</option>' +
                        @endforeach
                    '</select>' +
                    '<div class="input-group-append">' +
                        '<button type="button" class="btn btn-danger remove-candidate-btn" onclick="filterCandidates('+positionID+','+dataID+', 0)">' +
                            '<i class="fa fa-minus"></i>' +
                        '</button>' +
                    '</div>' +
                '</div>' +
            '</div>' +
        '</div>';

        $('.candidates-container[data-position-id="'+positionID+'"]').append(finalClone)
        $('.partylist-select[data-position-id="'+positionID+'"][data-id="'+dataID+'"]').select2({
            theme: "bootstrap4",
            placeholder: "Select",
            allowClear: true
        });
        
        filterCandidates(positionID, dataID, 'add-candidate')
    }
    
    function filterCandidates(positionID, dataID, triggeredFrom){
        // $('#loader').fadeIn();
        var selectedCandidate
        if(triggeredFrom == 'select'){
            var thisSelect = $('.candidates-select2[data-position-id="'+positionID+'"][data-id="'+dataID+'"]');
            var valueFromThisSelect = thisSelect.val();
            // relist removed candidate
            var removedCandidateOption
            for (let index = 0; index < finalSelectedCandidates.length; index++) {
                if(finalSelectedCandidates[index].id == (positionID+'-'+dataID)){
                    removedCandidateOption = '<option value="'+finalSelectedCandidates[index].value+'">'+finalSelectedCandidates[index].text+'</option>'
                    finalSelectedCandidates.splice(index, 1)
                    break
                }
            }
            $('.candidates-select2').each(function(){
                if($(this).data('position-id') != positionID || $(this).data('id') != dataID) {
                    $(this).append(removedCandidateOption)
                }
            })

            // remove selected candidates
            var selectedCandidates = [];
            $('.candidates-select2').each(function(){
                if($(this).val() != ''){
                    selectedCandidates.push($(this).val())
                    finalSelectedCandidates.push({
                        id: $(this).data('position-id')+'-'+$(this).data('id'),
                        value: $(this).val(),
                        text: $(this).find('option:selected').html()
                    })
                }
            })
            $('.candidates-select2').each(function(){
                if($(this).data('position-id') != positionID || $(this).data('id') != dataID) {
                    for (let index = 0; index < selectedCandidates.length; index++) {
                        var option = $(this).find('option[value="'+selectedCandidates[index]+'"]')
                        if(!option.is(':selected')){
                            option.remove()
                        }
                    }
                }
            })

            // reload select
            $('.candidates-select2').each(function(){
                if($(this).data('position-id') != positionID && $(this).data('id') != dataID) {
                    $(this).select2({
                        // sorter: data => data.sort((a, b) => a.text.localeCompare(b.text)),
                        theme: "bootstrap4",
                        placeholder: "Select",
                        allowClear: true
                    })
                }
            })
        }
        else if(triggeredFrom == 'add-candidate'){
            var selectedCandidates = [];
            $('.candidates-select2').each(function(){
                selectedCandidates.push($(this).val())
            })
            for (let index = 0; index < selectedCandidates.length; index++) {
                $('.candidates-select2[data-position-id="'+positionID+'"][data-id="'+dataID+'"] option[value="'+selectedCandidates[index]+'"]').remove()
            }
            $('.candidates-select2[data-position-id="'+positionID+'"][data-id="'+dataID+'"]').select2({
                // sorter: data => data.sort((a, b) => a.text.localeCompare(b.text)),
                theme: "bootstrap4",
                placeholder: "Select",
                allowClear: true
            })
        }
        else if(triggeredFrom == 0){
            if(dataID > 0){
                var removedCandidateOption
                for (let index = 0; index < finalSelectedCandidates.length; index++) {
                    if(finalSelectedCandidates[index].id == (positionID+'-'+dataID)){
                        removedCandidateOption = '<option value="'+finalSelectedCandidates[index].value+'">'+finalSelectedCandidates[index].text+'</option>'
                        finalSelectedCandidates.splice(index, 1)
                        break
                    }
                }
                
                $('.candidate-selection[data-id="'+dataID+'"][data-position-id="'+positionID+'"]').remove();

                $('.candidates-select2').each(function(){
                    if($(this).data('position-id') != positionID || $(this).data('id') != dataID) {
                        $(this).append(removedCandidateOption)
                    }
                })
                $('.candidates-select2').select2({
                    theme: "bootstrap4",
                    placeholder: "Select",
                    allowClear: true
                })
            }
        }
        // $('#loader').fadeOut();
    }

    function updateCandidateSelection(select){
        var dataID = $(select).data('id');
        var positionID = $(select).data('position-id');
        filterCandidates(positionID, dataID, 'select')
    }

</script>
@endsection