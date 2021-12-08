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
                                <input required type="checkbox" class="custom-control-input candidate-checkbox" data-position="{{ $position->id }}" data-elect="{{ $position->candidate_to_elect }}" name="position[{{ $position->id }}][]" value="{{ $candidate->id }}" id="candidate_{{ $candidate->id }}">
                                <label class="custom-control-label" for="candidate_{{ $candidate->id }}"></label>
                            </div>
                        </div>
                    @else
                        <div class="radio">
                            <div class="custom-control custom-radio">
                                <input required type="radio" class="custom-control-input" name="position[{{ $position->id }}]" value="{{ $candidate->id }}" id="candidate_{{ $candidate->id }}">
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
    