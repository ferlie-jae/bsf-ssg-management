<form method="POST" action="{{ route('roles.store') }}" autocomplete="off">
@csrf
	<div class="modal fade" id="addRole" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Role</h5>
                    <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
					<div class="form-group">
					    <label for="name">{{ __('Name') }}:</label>
					    <input id="name" type="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="@if(old('name')){{ old('name') }}@endif" required>
					    @if ($errors->has('name'))
					        <span class="invalid-feedback" role="alert">
					   	        <strong>{{ $errors->first('name') }}</strong>
					        </span>
					    @endif
					</div>
                    <div class="form-group row">
                        <div class="checkbox col-md-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" value="select_all" id="select_all">
                                <label class="custom-control-label" for="select_all">Select All</label>
                            </div>
                        </div>
                        <div class="checkbox col-md-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" value="delete" id="select_all_store">
                                <label class="custom-control-label" for="select_all_store">All *STORE</label>
                            </div>
                        </div>
                        <div class="checkbox col-md-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" value="update" id="select_all_update">
                                <label class="custom-control-label" for="select_all_update">All *UPDATE</label>
                            </div>
                        </div>
                        <div class="checkbox col-md-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" value="delete" id="select_all_delete">
                                <label class="custom-control-label" for="select_all_delete">All *DELETE</label>
                            </div>
                        </div>
                        <div class="checkbox col-md-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" value="restore" id="select_all_restore">
                                <label class="custom-control-label" for="select_all_restore">All *RESTORE</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Permissions:</label>
                        <hr style="margin-bottom: 0px; margin-top: 0px">
                        <div class="row">
                        @foreach($permissions as $key => $permission_data)
                            <div class="col-md-3">
                                <div class="checkbox">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input permission-checkbox select-permission-group" data-group="{{ $key }}" name="permission_group[]" id="permission_group_{{ $key }}">
                                        <label class="custom-control-label" for="permission_group_{{ $key }}">{{ $key }}:</label>
                                    </div>
                                </div>
                                {{-- <label>{{ $key }}:</label> --}}
                                @foreach ($permission_data as $permission)
                                    <div class="checkbox">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input permission-checkbox select-permission-child" data-group="{{ $key }}" data-type="{{ explode('.', $permission->name)[1] }}" name="permission[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}" @if(in_array($permission->id, old('permission', []))){{'checked'}}@endif>
                                            <label class="custom-control-label" style="font-weight: normal" for="permission_{{ $permission->id }}">{{ str_replace("_", " ", str_replace("destroy", "delete", explode('.', $permission->name)[1])) }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default text-success" type="submit"><i class="fad fa-save"></i> Save </button>
                </div>
            </div>
        </div>
    </div>
</form>
<script type="application/javascript">
    $(function(){
        $('#select_all').click(function(event) {   
            if(this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;                        
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;                       
                });
            }
        });

        $(document).on('click', '#select_all_store', function() {
            var group = $(this).data('group');
            if(this.checked) {
                // Iterate each checkbox
                $(':checkbox[data-type="store"]').each(function() {
                    this.checked = true;                        
                });
                $(':checkbox[data-type="create"]').each(function() {
                    this.checked = true;                        
                });            } else {
                $(':checkbox[data-type="store"]').each(function() {
                    this.checked = false;                       
                });
                $(':checkbox[data-type="create"]').each(function() {
                    this.checked = false;                       
                });
            }
            checkGroupValidate()
            checkAll()
        });

        $(document).on('click', '#select_all_show', function() {
            var group = $(this).data('group');
            if(this.checked) {
                // Iterate each checkbox
                $(':checkbox[data-type="show"]').each(function() {
                    this.checked = true;                        
                });
            } else {
                $(':checkbox[data-type="show"]').each(function() {
                    this.checked = false;                       
                });
            }
            checkGroupValidate()
            checkAll()
        });

        $(document).on('click', '#select_all_update', function() {
            var group = $(this).data('group');
            if(this.checked) {
                // Iterate each checkbox
                $(':checkbox[data-type="update"]').each(function() {
                    this.checked = true;                        
                });
                $(':checkbox[data-type="edit"]').each(function() {
                    this.checked = true;                        
                });
            } else {
                $(':checkbox[data-type="update"]').each(function() {
                    this.checked = false;                       
                });
                $(':checkbox[data-type="edit"]').each(function() {
                    this.checked = false;                       
                });
            }
            checkGroupValidate()
            checkAll()
        });

        $(document).on('click', '#select_all_delete', function() {
            var group = $(this).data('group');
            if(this.checked) {
                // Iterate each checkbox
                $(':checkbox[data-type="destroy"]').each(function() {
                    this.checked = true;                        
                });
            } else {
                $(':checkbox[data-type="destroy"]').each(function() {
                    this.checked = false;                       
                });
            }
            checkGroupValidate()
            checkAll()
        });

        $(document).on('click', '#select_all_restore', function() {
            var group = $(this).data('group');
            if(this.checked) {
                // Iterate each checkbox
                $(':checkbox[data-type="restore"]').each(function() {
                    this.checked = true;                        
                });
            } else {
                $(':checkbox[data-type="restore"]').each(function() {
                    this.checked = false;                       
                });
            }
            checkGroupValidate()
            checkAll()
        });

        $(document).on('click', '.select-permission-group', function() {
            var group = $(this).data('group');
            if(this.checked) {
                // Iterate each checkbox
                $(':checkbox[data-group="'+group+'"]').each(function() {
                    this.checked = true;                        
                });
            } else {
                $(':checkbox[data-group="'+group+'"]').each(function() {
                    this.checked = false;                       
                });
            }
            checkAll()
        });

        $(document).on('click', '.select-permission-child', function() {
            var group = $(this).data('group');
            if($('.select-permission-child[data-group="'+group+'"]:checked').length == $('.select-permission-child[data-group="'+group+'"]').length){
                $('.select-permission-group[data-group="'+group+'"]').prop('checked', true)
            }else{
                $('.select-permission-group[data-group="'+group+'"]').prop('checked', false)
            }
            checkAll()
        });
    })

    checkGroup()
    checkAll()

    function checkGroupValidate() {
        $('.select-permission-child').each(function(){
            var group = $(this).data('group');
            if($('.select-permission-child[data-group="'+group+'"]:checked').length == $('.select-permission-child[data-group="'+group+'"]').length){
                $('.select-permission-group[data-group="'+group+'"]').prop('checked', true)
            }else{
                $('.select-permission-group[data-group="'+group+'"]').prop('checked', false)
            }
        })
    }
    
    function checkGroup() {
        $('.select-permission-child').each(function(){
            var group = $(this).data('group');
            if(this.checked){
                $('.select-permission-group[data-group="'+group+'"]').prop('checked', true)
            }else{
                $('.select-permission-group[data-group="'+group+'"]').prop('checked', false)
            }
        })
    }

    function checkAll() {
        if($('.permission-checkbox:checked').length == $('.permission-checkbox').length){
            $('#select_all').prop('checked', true)
        }else{
            $('#select_all').prop('checked', false)
        }
    }
</script>