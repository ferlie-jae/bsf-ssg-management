<input type="hidden" name="election_id" value="{{ $election->id }}">
<div class="row">
    <div class="col-md-6">
        <label>Title: </label>
        {{ $election->title }}
        <br>
        <label>Description: </label>
        {{ $election->description }}
        <br>
        <label>Election Date: </label>
        {{ $election->election_date }}
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="partylistSelect">Vote by Partlist</label>
            <select id="partylistSelect" class="form-control">
                <option></option>
                @foreach ($election->candidates->groupBy('partylist_id') as $partylistID => $candidates)
                    @php
                        $partylist = App\Models\Partylist::find($partylistID);
                    @endphp
                    <option value="{{ $partylistID }}">{{ $partylist->name }}</option>
                @endforeach
            </select>
        </div>
    @foreach ($election->candidates->groupBy('position_id') as $position => $candidates)
        @php
            $position = App\Models\Configuration\Position::find($position);
        @endphp
        <legend>{{ $position->name }}</legend>
        @if($position->candidate_to_elect > 1)
            <p class="text-danger">Please select <strong>{{ $position->candidate_to_elect }}</strong> candidates.</p>
        @endif
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>Candidate</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($candidates as $candidate)
                <tr>
                    <td>
                        {{ $candidate->student->fullname('') }} ({{ $candidate->partylist->name }})
                    </td>
                    <td class="text-center">
                    @if($position->candidate_to_elect > 1)
                        <div class="checkbox">
                            <div class="custom-control custom-checkbox">
                                <input required type="checkbox" class="custom-control-input candidate-checkbox candidate-selection" data-position="{{ $position->id }}" data-partylist="{{ is_null($candidate->partylist_id) ? 0 : $candidate->partylist_id }}" data-elect="{{ $position->candidate_to_elect }}" name="position[{{ $position->id }}][]" value="{{ $candidate->id }}" id="candidate_{{ $candidate->id }}">
                                <label class="custom-control-label" for="candidate_{{ $candidate->id }}"></label>
                            </div>
                        </div>
                    @else
                        <div class="radio">
                            <div class="custom-control custom-radio">
                                <input required type="radio" class="custom-control-input candidate-selection" name="position[{{ $position->id }}]" value="{{ $candidate->id }}" data-partylist="{{ is_null($candidate->partylist_id) ? 0 : $candidate->partylist_id }}" id="candidate_{{ $candidate->id }}">
                                <label class="custom-control-label" for="candidate_{{ $candidate->id }}"></label>
                            </div>
                        </div>
                    @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endforeach
    </div>
</div>
<script>
    $(function(){
        $('#partylistSelect').select2({
            theme: "bootstrap4",
            placeholder: "Select",
            allowClear: true
        })
    })
    $(function(){
        $('#partylistSelect').change(function(){
            var partylistID = $(this).val();
            $('.candidate-selection').each(function(){
                if($(this).data('partylist') == partylistID){
                    $(this).prop('checked', true);
                }else{
                    $(this).prop('checked', false);
                }
            })
            
        })
        $('.candidate-checkbox').change(function(){
            var name = $(this).attr('name');
            var elect = $(this).data('elect');
            var countSelected = $('.candidate-checkbox[name="' + name + '"]:checked').length;
            console.log(countSelected)
            if(countSelected == elect){
                $('.candidate-checkbox[name="' + name + '"]:not(:checked)').prop('disabled', true);
            }else{
                $('.candidate-checkbox[name="' + name + '"]').prop('disabled', false);
            }
        })
    })
</script>
    