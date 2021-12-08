<div class="modal fade" id="showSection" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $section->name }}</h5>
                <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <label>Year Level:</label> {{ $section->grade_level }}
                        <br>
                        <label>Name:</label> {{ $section->name }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <legend>Students: {{ $section->students->count() }}</legend>
                        <table class="table table-sm table-bordered" id="sectionStudentDatatable">
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($section->students as $student)
                                <tr>
                                    <td>
                                        {{ $student->student->student_id }}
                                    </td>
                                    <td>
                                        {{ $student->student->getStudentName($student->student_id) }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="table-danger text-danger" colspan="2">*** EMPTY ***</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col">
					@if ($section->trashed())
                		@can('sections.restore')
					    <a class="btn btn-default text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('sections.restore', $section->id) }}"><i class="fad fa-download"></i> Restore</a>
						@endcan
					@else
						@can('sections.destroy')
					    <a class="btn btn-default text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('sections.destroy', $section->id) }}"><i class="fad fa-trash-alt"></i> Delete</a>
						@endcan
					@endif
					@can('sections.edit')
					   <a class="btn btn-default text-primary" href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('sections.edit', $section->id) }}" data-target="#editSection"><i class="fad fa-edit"></i> Edit</a>
					@endcan
				</div>
				<div class="col text-right">
					<button class="btn btn-default" type="button" data-dismiss="modal-ajax"> Close</button>
				</div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('#sectionStudentDatatable').dataTable();
    })
</script>