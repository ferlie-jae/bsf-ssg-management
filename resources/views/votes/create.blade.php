<form action="{{ route('votes.store') }}" method="POST" autocomplete="off">
	@csrf
	<div class="modal fade" id="createVote" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Vote</h5>
                    <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="electionData">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="election">Election:</label>
                            <select class="form-control select2" id="election" name="election" style="width: 100%">
								@foreach ($elections as $election)
									<option value="{{ $election->id }}">{{ $election->title }}</option>
								@endforeach
                            </select>
                            <br>
                            <button type="button" class="btn btn-default text-primary" id="getElectionData">Select</button>
                        </div>
                    </div>
				</div>
				<div class="modal-footer">
                    <button type="submit" class="btn btn-default text-success" disabled id="submitVote"><i class="fad fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(function() {
		$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var base_url = '{{ URL::to('') }}';

		$('#getElectionData').on('click', function(){
			$.ajax({
                type:'GET',
                url: base_url+'/elections/get_election_data/'+$('#election').val(),
                success:function(data){
                    $('#electionData').html(data.election_data);
                    $('#submitVote').attr('disabled', false);
                    $('#createVote .modal-dialog').removeClass('modal-md');
                    $('#createVote .modal-dialog').addClass('modal-lg');
                },
                error:function (data){
                    Swal.fire({
                        // position: 'top-end',
                        type: 'error',
                        title: 'error',
                        showConfirmButton: true,
                        toast: true
                    });
                }
            });
		});
	});
</script>