<form action="{{ route('tasks.update', $task->id) }}" method="POST" autocomplete="off">
    @csrf
    @method('PUT')
	<div class="modal fade" id="editTask" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Task</h5>
                    <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Students:</label>
                                <select class="form-control select2" name="officer">
                                    <option></option>
                                    @foreach ($officers as $officer)
                                        <option value="{{ $officer->student_id }}" @if($task->student_id == $officer->student_id) selected @endif >
                                            [{{ $officer->position->name }}] {{ $officer->student->getStudentName() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Task:</label>
                                <input class="form-control" type="text" name="task" value="{{ $task->task }}" required>
                            </div>
                            <div class="form-group">
                                <label>Description:</label>
                                <textarea name="description" rows="4" class="form-control">{{ $task->description }}</textarea>
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