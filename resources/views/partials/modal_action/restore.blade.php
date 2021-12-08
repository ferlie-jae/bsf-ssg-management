<div class="modal fade" id="restoreFromTableModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
                <h4 class="modal-title text-success">@fa('fa fa-exclamation-triangle fa-lg') Restore</h4>
                <a href="javascript:void(0)" class="close modal-restore-close" aria-hidden="true">&times;</a>
	    	</div>
			<div class="modal-body">
    			<form id="restoreLink" method="POST">
                    @csrf
                    <p class="text-left">
                    	Are you sure do you want to <strong class="text-success"><u>RESTORE</u></strong> this data?
                    </p>
                    <hr>
                    <div class="form-group text-right">
    					<button type="button" class="btn btn-primary btn-sm modal-restore-close">Cancel</button>
    					<button type="submit" class="btn btn-success btn-sm">Restore</button>
                    </div>
				</form>
			</div>
		</div>
	</div>
</div> {{-- end of modal destroy --}}