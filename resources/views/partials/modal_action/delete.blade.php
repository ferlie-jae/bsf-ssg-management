<div class="modal fade" id="deleteFromTableModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
                <h4 class="modal-title text-danger">@fa('fa fa-exclamation-triangle fa-lg') Delete</h4>
                <a href="javascript:void(0)" class="close modal-delete-close" aria-hidden="true">&times;</a>
	    	</div>
			<div class="modal-body">
    			<form id="deleteLink" method="POST">
                    @csrf
                    @method('DELETE')
                    <p class="text-left">
                    	Are you sure do you want to <strong class="text-danger"><u>DELETE</u></strong> this data?
                    </p>
                    @if(Auth::user()->hasrole('System Administrator'))
                    <div class="checkbox">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="permanent" value="1" id="permanent">
                            <label class="custom-control-label text-danger" for="permanent">Delete permanent</label>
                        </div>
                    </div>
                    @endif
                    <hr>
                    <div class="form-group text-right">
    					<button type="button" class="btn btn-primary btn-sm modal-delete-close">Cancel</button>
    					<button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </div>
				</form>
			</div>
		</div>
	</div>
</div> {{-- end of modal destroy --}}