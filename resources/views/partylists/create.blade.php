<style>
    .colorpicker-alpha {
        display: none !important;
    }
    .colorpicker{ 
        min-width: 128px !important;
    }
</style>
<form action="{{ route('partylists.store') }}" method="POST" autocomplete="off">
    @csrf
    <div class="modal fade" id="createPartylist" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Partylist</h5>
                    <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
						        <label for="name">Name:</label>
						        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}">
						        @if ($errors->has('name'))
						            <span class="invalid-feedback" role="alert">
						                <strong>{{ $errors->first('name') }}</strong>
						            </span>
						        @endif
                            </div>
                            <div class="form-group">
						        <label for="color">Color:</label>
						        <div class="input-group partylist-color">
                                    <input id="color" type="text" class="form-control" name="color">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-square"></i></span>
                                    </div>
                                </div>
						        @if ($errors->has('candidate_to_elect'))
						            <span class="invalid-feedback" role="alert">
						                <strong>{{ $errors->first('candidate_to_elect') }}</strong>
						            </span>
						        @endif
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
<script>
    $(function(){
        $('.partylist-color').colorpicker()
        $('.partylist-color').on('colorpickerChange', function(event) {
            $('.partylist-color .input-group-text').css('background-color', event.color.toString());
            $('.partylist-color .input-group-text').css('color', event.color.toString());
        })
    })
</script>
