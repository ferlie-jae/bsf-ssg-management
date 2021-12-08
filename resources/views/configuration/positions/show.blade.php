<div class="modal fade" id="showPosition" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $position_show->name }}</h5>
                <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <label>Name:</label> {{ $position_show->name }}
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <table class="table-sm">
                            <thead>
                                <tr>
                                    <th>Candidate</th>
                                    <th>Vote</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($position_show->candidate as $item)
                                    
                                @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>