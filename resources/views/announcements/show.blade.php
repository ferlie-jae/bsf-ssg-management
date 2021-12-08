<div class="modal fade" id="showAnnouncement" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="Faculty" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
	          <h4 class="modal-title">{{ $announcement->title }}</h4>
	          <button type="button" class="close" data-dismiss="modal-ajax" aria-hidden="true">&times;</button>
	    	</div>
			<div class="modal-body">
                {!! $announcement->content !!}
                <hr>
                <label>Date: </label>{{ date('F d, Y h:i A', strtotime($announcement->created_at)) }}
            </div>
            <div class="modal-footer">
				<button class="btn btn-default" type="button" data-dismiss="modal-ajax"> Close</button>
			</div>
	    </div>
	</div>
</div>
                