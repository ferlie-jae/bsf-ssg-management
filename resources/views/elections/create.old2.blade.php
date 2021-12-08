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
        <div class="row">
            <div class="col-md-3">
                <legend>Election Info:</legend>
                <div class="form-group">
                    <label>Title:</label>
                    <input class="form-control" type="text" name="title" required>
                </div>
                <div class="form-group">
                    <label>Description:</label>
                    <textarea name="description" rows="4" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label>Election Start Date:</label>
                    <div class="input-group datetimepicker" id="startDate" data-target-input="nearest">
                        <input type="text" name="start_date" class="form-control datetimepicker-input" data-target="#startDate" data-toggle="datetimepicker" required/>
                        <div class="input-group-append" data-target="#startDate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Election End Date:</label>
                    <div class="input-group datetimepicker" id="endDate" data-target-input="nearest">
                        <input type="text" name="end_date" class="form-control datetimepicker-input" data-target="#endDate" data-toggle="datetimepicker" required/>
                        <div class="input-group-append" data-target="#endDate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <legend>Partylists:</legend>
                <div class="form-group">
                    <label for="">Partylist</label>
                    <a href="javascript:void(0)" id="addPartylist"><i class="fa fa-plus"></i> Add Partylist</a>
                    <div id="partylistContainer">
                        <div class="input-group mb-3 partylist-input-group" data-id="0">
                            <input type="text" class="form-control partylist-input" onchange="updatePartylistSelect()">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-danger remove-partylist" onclick="removePartylist(0)" data-id="0">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <legend>Candidates:</legend>
                @foreach ($positions as $position)
                {{-- <script type="text/javascript">
                    $(function(){
                        $('#oldInput').find('input[name="old_candidates[{{ $position->id}}][]"]').each(function(){
                            $('select[name="candidates[{{ $position->id}}][]"] > option[value="'+$(this).val()+'"').prop('selected', true)
                        })
                    })
                </script> --}}
                <div class="form-group">
                    <label>{{ $position->name }}:</label>
                    <a href="javascript:void(0)" onclick="addCandidate({{ $position->id }})"><i class="fa fa-plus"></i> Add Candidate</a>
                    <div class="candidates-container" data-position-id="{{ $position->id }}">
                        <div class="row candidate-selection" data-id="0">
                            <div class="col-sm-12">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <select class="form-control candidates-select2" name="candidates[{{ $position->id}}][]" data-id="0" data-position-id="{{ $position->id}}" onchange="updateCandidateSelection(this)">
                                            <option></option>
                                            @foreach ($students as $student)
                                                <option value="{{ $student->id }}">{{ $student->getStudentNameLNF() }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <select class="form-control partylist-select" name="candidate-partylist[{{ $position->id}}][]" data-position-id="{{ $position->id}}" required>
                                    </select>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-danger remove-candidate-btn" onclick="removeCandidate(0)">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script type="text/javascript">

    // for adding of partylist
    $('#addPartylist').on('click', function(){
        var partylistIDs = [];
        $('#partylistContainer').find('.partylist-input-group').each(function(){
            partylistIDs.push($(this).data('id'))
        });
        var dataID = partylistIDs[partylistIDs.length-1];
        if(dataID >= 0){
            dataID+=1;
        }else{
            dataID = 0;
        }
        var partylistInput = 
        '<div class="input-group mb-3 partylist-input-group" data-id="'+dataID+'">' +
            '<input type="text" class="form-control partylist-input" onchange="updatePartylistSelect()">'+
            '<div class="input-group-append">' +
                '<button type="button" class="btn btn-danger remove-partylist" onclick="removePartylist('+dataID+')" data-id="'+dataID+'">' +
                    '<i class="fa fa-minus"></i>' +
                '</button>' +
            '</div>' +
        '</div>';
        $('#partylistContainer').append(partylistInput);
        updatePartylistSelect()
    });
    
    // remove partylist
    function removePartylist(partylistID){
        console.log('remove: ' + partylistID)
        $('.partylist-input-group[data-id="'+partylistID+'"]').remove();
        updatePartylistSelect()
    }

    updatePartylistSelect()

    function updatePartylistSelect(){
        var options = "<option>--select partylist--</option>";
        $('#partylistContainer').find('.partylist-input').each(function(){
            var partylistIDs = $(this).parent().data('id')
            var value = $(this).val()
            /* if($(this).find('option[data-id="'+partylistIDs+'"]')){
                $(this).find('option[data-id="'+partylistIDs+'"]').html(value)
                $(this).find('option[data-id="'+partylistIDs+'"]').attr('value', value)
            }else{
                $('.partylist-select').prepend('<option value="'+value+'" data-id="'+partylistIDs+'">'+value+'</option>')
            } */
            if(value != ''){
                options += '<option value="'+value+'" data-id="'+partylistIDs+'">'+value+'</option>';
            }
        });
        $('.partylist-select').html(options)
    }

    function addCandidate(positionID){
        // var candidateSelectionOptions = $('.candidates-container[data-position-id="'+positionID+'"]').find('.candidate-selection[data-id="0"]').html();
        var candidateSelectionIDs = [];
        $('.candidates-container[data-position-id="'+positionID+'"]').find('.candidate-selection').each(function(){
            candidateSelectionIDs.push($(this).data('id'))
            console.log($(this).data('id'))
        });
        var dataID = candidateSelectionIDs[candidateSelectionIDs.length-1];
        if(dataID >= 0){
            dataID+=1;
        }else{
            dataID = 0;
        }

        var finalClone = 
        '<div class="row candidate-selection" data-id="'+dataID+'">'+
            '<div class="col-sm-12">' +
                '<div class="input-group mb-2">' +
                    '<div class="input-group-prepend">' +
                        '<select class="form-control candidates-select2" name="candidates['+positionID+'][]" data-id="'+dataID+'" data-position-id="'+positionID+'" onchange="updateCandidateSelection(this)">' +
                            '<option></option>' +
                            @foreach ($students as $student)
                                '<option value="{{ $student->id }}">{{ $student->getStudentNameLNF() }}</option>' +
                            @endforeach
                        '</select>' +
                    '</div>' +
                    '<select class="form-control partylist-select" name="candidate-partylist['+positionID+'][]" data-position-id="'+positionID+'" required>' +
                    '</select>' +
                    '<div class="input-group-append">' +
                        '<button type="button" class="btn btn-danger remove-candidate-btn" onclick="removeCandidate('+dataID+')">' +
                            '<i class="fa fa-minus"></i>' +
                            dataID + 
                        '</button>' +
                    '</div>' +
                '</div>' +
            '</div>' +
        '</div>';

        $('.candidates-container[data-position-id="'+positionID+'"]').append(finalClone)
        // $('.candidates-container[data-position-id="'+positionID+'"]').find('candidate-selection[data-id="'+dataID+'"]').find('.candidates-select2').val('');
        $('.candidates-container[data-position-id="'+positionID+'"] > .candidate-selection[data-id="'+dataID+'"]').find('.candidates-select2').select2({
            sorter: data => data.sort((a, b) => a.text.localeCompare(b.text)),
            theme: "bootstrap4",
            placeholder: "Select",
            allowClear: true
        });
        
        filterCandidates(positionID, dataID)
    }

    
    
    function filterCandidates(positionID, dataID){
        var selectedCandidatesOptions = [];
        var value = [];
        $('.candidates-select2[name="candidates['+positionID+'][]"]').each(function(){
            value.push($(this).val())
            console.log($(this).val())
        })
        var id = positionID;
        // removed options on other position options
        var selectedOptions = [];
        $('.candidates-select2').each(function(){
            // insert all selected candidates on array
            $('.candidates-select2[data-position-id="'+$(this).data('position-id')+'"] :selected').each(function(){
                var candidate = '<option value="' + $(this).attr('value') + '">' + $(this).html() + '</option>';
                selectedOptions.push(candidate)
            })
            if($(this).data('position-id') == id || $(this).data('data-id') == dataID) {
                for (let index = 0; index < value.length; index++) {
                    var removeCandidate = $('.candidates-select2[data-position-id="'+$(this).data('position-id')+'"][data-id="'+dataID+'"] > option[value="'+value[index]+'"]');
                    /* var candidateOption = '<option value="' + value[index] + '">' + removeCandidate.html() + '</option>';
                    if(selectedCandidatesOptions.indexOf(candidateOption) == -1 && removeCandidate.html() != undefined){
                        selectedCandidatesOptions.push(candidateOption)
                    } */
                    // remove selected candidate on other position options
                    removeCandidate.remove() 
                }
            }else{
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

    function updateCandidateSelection(select){
        $('#loader').fadeIn();
        var value = $(select).val();
        var id = $(select).data('position-id');
        var selectedCandidatesOptions = [];
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
                    // sorter: data => data.sort((a, b) => a.text.localeCompare(b.text)),
                    theme: "bootstrap4",
                    placeholder: "Select",
                    allowClear: true
                })
            }
        })
        $('#loader').fadeOut();
    }

    
    // Candidate selection
    $(function(){
        $('.candidates-select2').select2({
            // sorter: data => data.sort((a, b) => a.text.localeCompare(b.text)),
            theme: "bootstrap4",
            placeholder: "Select",
            allowClear: true
        })

        var selectedCandidatesOptions = [];

        /* $('.candidates-select2').change(function(){
            $('#loader').fadeIn();
            var value = $(this).val();
            var id = $(this).data('position-id');
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
                        // sorter: data => data.sort((a, b) => a.text.localeCompare(b.text)),
                        theme: "bootstrap4",
                        placeholder: "Select",
                        allowClear: true
                    })
                }
            })
            $('#loader').fadeOut();
        }) */
    })
</script>
@endsection