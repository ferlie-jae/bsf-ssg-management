<form method="POST" action="{{ route('permissions.store') }}" autocomplete="off">
@csrf
	<div class="modal fade" id="addPermission" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Permission</h5>
                    <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
					{{-- <div class="form-group">
					    <label for="name">{{ __('Permission') }}:</label>
					    <input id="name" type="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>
					    @if ($errors->has('name'))
					        <span class="invalid-feedback" role="alert">
					   	        <strong>{{ $errors->first('name') }}</strong>
					        </span>
					    @endif
					</div> --}}
                    <div class="form-group">
                        <label for="name">{{ __('Routes') }}:</label>
                        <select class="form-control select2" name="name[]" multiple style="width: 100%">
                            <option></option>
                            @foreach (Route::getRoutes()->getRoutes() as $route)
                                @php
                                    $action_object = $route->getAction();
                                @endphp
                                @if (!empty($action_object['controller']))
                                    @if (is_array($action_object['middleware']))
                                        @if (in_array('auth', $action_object['middleware']))
                                            @php
                                                $permission = explode('.', $action_object['as'])[0];
                                            @endphp
                                            @if (
                                                !in_array($action_object['as'], $permissions_name)
                                                && (
                                                    $permission != 'store'
                                                    && $permission != 'update'
                                                ))
                                                <option value="{{ $action_object['as'] }}">{{ $action_object['as'] }}</option>
                                            @endif
                                        @endif
                                    @endif
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default text-success" type="submit"><i class="fad fa-save"></i> Save </button>
                </div>
            </div>
        </div>
    </div>
</form>