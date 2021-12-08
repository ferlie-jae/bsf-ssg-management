<div class="modal fade" id="showElection" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="Faculty" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
	          <h4 class="modal-title">{{ $election_show->title }}</h4>
	          <button type="button" class="close" data-dismiss="modal-ajax" aria-hidden="true">&times;</button>
	    	</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Status: </label><br>
                            {{ $election_show->status }}
                        </div>
                        <div class="form-group">
                            <label>Title: </label><br>
                            {{ $election_show->title }}
                        </div>
                        <div class="form-group">
                            <label>Description: </label><br>
                            {{ $election_show->description }}
                        </div>
                        <div class="form-group">
                            <label>Election Date: </label><br>
                            {{ date('F d, Y h:i A', strtotime($election_show->start_date)) }}
                            -
                            {{ date('F d, Y h:i A', strtotime($election_show->end_date)) }}
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <legend>Candidates:</legend>
                    @foreach ($election_show->candidates->groupBy('position_id') as $position => $candidates)
                    <div class="col-md-6">
                        <label>{{ App\Models\Configuration\Position::find($position)->name }}</label><br>
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Candidate</th>
                                    <th>Votes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($candidates as $candidate)
                                <tr class="{{ $candidate->trashed() ? 'table-danger' : ''}}">
                                    <td>
                                        {{-- {{ $candidate->student->id}} -  --}}{{ $candidate->student->getStudentName($candidate->student_id) }}
                                    </td>
                                    <td>
                                        {{ $candidate->votes->count() ?? "N/A" }}
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
					@if ($election_show->trashed())
                		@can('elections.restore')
					    <a class="btn btn-default text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('elections.restore', $election_show->id) }}"><i class="fad fa-download"></i> Restore</a>
						@endcan
					@else
						@can('elections.destroy')
					    <a class="btn btn-default text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('elections.destroy', $election_show->id) }}"><i class="fad fa-trash-alt"></i> Delete</a>
						@endcan
					@endif
					@can('elections.edit')
					   <a class="btn btn-default text-primary" href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('elections.edit', $election_show->id) }}" data-target="#editElection"><i class="fad fa-edit"></i> Edit</a>
                    @endcan
                    @can('elections.end')
					   <a class="btn btn-default text-success" href="{{ route('elections.end', $election_show->id) }}" ><i class="fad fa-stamp"></i> End</a>
                    @endcan
				</div>
				<div class="col text-right">
					<button class="btn btn-default" type="button" data-dismiss="modal-ajax"> Close</button>
				</div>
			</div>
	    </div>
	</div>
</div>