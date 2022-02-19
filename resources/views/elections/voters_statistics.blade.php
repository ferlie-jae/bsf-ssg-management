<div class="modal fade" id="votersStatistics" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Voters Statistics</h5>
                <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div class="position-relative">
                            {!! $votersStatistics->container() !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal-ajax"> Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    var chart = new Chart('{{ $votersStatistics->id }}')
</script>
{!! $votersStatistics->script() !!}