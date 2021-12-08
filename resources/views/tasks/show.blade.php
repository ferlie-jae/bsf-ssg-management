<div class="modal fade" id="showTask" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Task</h5>
                <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group mb-0">
                            <label>Date assigned:</label>
                            {{ date('F d, Y h:i A', strtotime($task->created_at)) }}
                        </div>
                        <div class="form-group mb-0">
                            <label>Status:</label>
                            {{ $task->is_done == 1 ? "Done" : "Not yet done" }}
                        </div>
                        <div class="form-group mb-0">
                            <label>Task:</label>
                            {{ $task->task }}
                        </div>
                        <div class="form-group mb-0">
                            <label>Description:</label>
                            {{ $task->description }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col">
					@if ($task->trashed())
                		@can('tasks.restore')
					    <a class="btn btn-default text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('tasks.restore', $task->id) }}"><i class="fad fa-download"></i> Restore</a>
						@endcan
					@else
						@can('tasks.destroy')
					    <a class="btn btn-default text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('tasks.destroy', $task->id) }}"><i class="fad fa-trash-alt"></i> Delete</a>
						@endcan
					@endif
					@can('tasks.edit')
					   <a class="btn btn-default text-primary" href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('tasks.edit', $task->id) }}" data-target="#editTask"><i class="fad fa-edit"></i> Edit</a>
                       @endcan
                    </div>
                <div class="col text-right">
                    @if(Auth::user()->isOfficer() && Auth::user()->student->student_id == $task->student_id && $task->is_done == 0)
                        <a class="btn btn-default text-success" href="{{ route('tasks.mark_as_done', $task->id) }}"><i class="fa fa-check"></i> Mark as Done</a>
                    @endif
					<button class="btn btn-default" type="button" data-dismiss="modal-ajax"> Close</button>
				</div>
                {{-- <button type="submit" class="btn btn-default text-success"><i class="fad fa-save"></i> Save</button> --}}
            </div>
        </div>
    </div>
</div>