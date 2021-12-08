<div class="modal fade" id="modalAjaxError" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="DoctorsNotes" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
	          <h4 class="modal-title text-danger"><i class="fad fa-exclamation-triangle"></i> Error</h4>
	          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    	</div>
			<div class="modal-body">
				{{-- <div id="ajaxOptions"></div> --}}
				<legend id="thrownError"></legend>
				<div id="xhr"></div>
			</div>
			<div class="modal-footer text-right">
				<button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
			</div>
	    </div>
	</div>
</div>