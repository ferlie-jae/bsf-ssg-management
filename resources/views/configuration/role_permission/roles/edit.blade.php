<form method="POST" action="{{ route('roles.update', $role_edit->id) }}" autocomplete="off">
@csrf
@method('PUT')
	<div class="modal fade" id="editRole" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Role</h5>
                    <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
					<div class="form-group">
					    <label for="name">{{ __('Name') }}:</label>
					    <input id="name" type="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="@if(old('name')){{ old('name') }}@else{{ $role_edit->name }}@endif" required>
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
                                <input type="checkbox" class="custom-control-input permission-type" value="store" data-type="store" id="select_all_store">
                                <label class="custom-control-label" for="select_all_store">Select *STORE</label>
                            </div>
                        </div>
                        <div class="checkbox col-md-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input permission-type" value="update" data-type="update" id="select_all_update">
                                <label class="custom-control-label" for="select_all_update">Select *UPDATE</label>
                            </div>
                        </div>
                        <div class="checkbox col-md-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input permission-type" value="delete" data-type="delete" id="select_all_delete">
                                <label class="custom-control-label" for="select_all_delete">Select *DELETE</label>
                            </div>
                        </div>
                        <div class="checkbox col-md-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input permission-type" value="restore" data-type="type" id="select_all_restore">
                                <label class="custom-control-label" for="select_all_restore">Select *RESTORE</label>
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
                                            <input type="checkbox" class="custom-control-input permission-checkbox select-permission-child" data-group="{{ $key }}" data-type="{{ explode('.', $permission->name)[1] }}" name="permission[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}" @if(in_array($permission->id, old('permission', $role_permissions_id))){{'checked'}}@endif>
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
                $(':checkbox[data-type="store"]').each(function() {
                    this.checked = true;                        
                });
                $(':checkbox[data-type="create"]').each(function() {
                    this.checked = true;                        
                });
            } else {
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

    function checkDelete(){
        $('.select-permission-child[data-type="delete"]').each(function(){
            if($('.select-permission-child[data-type="delete"]:checked').length == $('.select-permission-child[data-group="'+type+'"]').length){
                $('.permission-type[data-type="delete"]').prop('checked', true)
            }else{
                $('.permission-type[data-type="delete"]').prop('checked', false)
            }
        })
    }

    function checkGroupValidate() {
        $('.select-permission-child').each(function(){
            var group = $(this).data('group');
            var type = $(this).data('type');
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
            $('.permission-type').prop('checked', true)
        }else{
            $('#select_all').prop('checked', false)
        }
    }
</script>