<div class="modal fade" id="showVote" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Vote #{{ $vote->vote_number }}</h5>
                <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="electionData">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="mb-0">Election:</label><br>
                            {{ $vote->election->title }}
                        </div>
                        <div class="form-group">
                            <label class="mb-0">Description:</label><br>
                            {{ $vote->election->description }}
                        </div>
                        <div class="form-group">
                            <label class="mb-0">Election Date:</label><br>
                            {{ date('F d, Y h:i A', strtotime($vote->election->start_date)) }}
                            -
                            {{ date('F d, Y h:i A', strtotime($vote->election->end_date)) }}
                        </div>
                        <div class="form-group">
                            <label class="mb-0">Vote Date:</label><br>
                            {{ date('F d, Y h:i A', strtotime($vote->created_at)) }}
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    @foreach ($vote->election->candidates->groupBy('position_id') as $position => $candidates)
                    <div class="col-md-6">
                        <label>{{ App\Models\Configuration\Position::find($position)->name }}</label><br>
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Candidate</th>
                                    <th>Partylist</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($candidates as $candidate)
                                <tr class="{{ $candidate->trashed() ? 'table-danger' : ''}}">
                                    <td>
                                        {{ $candidate->student->fullname('') }}
                                    </td>
                                    <td>
                                        {{ $candidate->partylist->name ?? "" }}
                                    </td>
                                    <td style="width: 10px">
                                        @if($vote->isVotedCandidate($candidate->id))
                                        <i class="fa fa-check text-success"></i>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- <hr> --}}
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <div class="col">
					@if ($vote->trashed())
                		@can('votes.restore')
					    <a class="btn btn-default text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('votes.restore', $vote->id) }}"><i class="fad fa-download"></i> Restore</a>
						@endcan
					@else
						@can('votes.destroy')
					    <a class="btn btn-default text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('votes.destroy', $vote->id) }}"><i class="fad fa-trash-alt"></i> Delete</a>
						@endcan
					@endif
					{{-- @can('votes.edit')
					   <a class="btn btn-default text-primary" href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('votes.edit', $election_show->id) }}" data-target="#editVote"><i class="fad fa-edit"></i> Edit</a>
					@endcan --}}
				</div>
				<div class="col text-right">
					<button class="btn btn-default" type="button" data-dismiss="modal-ajax"> Close</button>
				</div>
            </div>
        </div>
    </div>
</div>