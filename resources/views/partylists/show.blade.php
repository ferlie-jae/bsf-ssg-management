<div class="modal fade" id="showPartylist" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">partylist</h5>
                <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-0">
                    <label>Name: </label>
                    {{ $partylist->name }}
                </div>
                <div class="form-group mb-0">
                    <label>Color: </label>
                    <div class="alert mb-0" style="background-color: {{ $partylist->color }};color: {{ $partylist->color }}"></div>
                </div>
            </div>
            <div class="modal-footer">
                @if ($partylist->trashed())
                    @can('partylists.restore')
                    <a class="btn btn-default text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('partylists.restore', $partylist->id) }}"><i class="fad fa-download"></i> Restore</a>
                    @endcan
                @else
                    @can('partylists.destroy')
                    <a class="btn btn-default text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('partylists.destroy', $partylist->id) }}"><i class="fad fa-trash-alt"></i> Delete</a>
                    @endcan
                @endif
                @can('partylists.edit')
                    <a class="btn btn-default text-primary" href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('partylists.edit', $partylist->id) }}" data-target="#editPartylist"><i class="fad fa-edit"></i> Edit</a>
                @endcan
            </div>
        </div>
    </div>
</div>