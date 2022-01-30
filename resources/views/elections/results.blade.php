@extends('layouts.adminlte')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    Results
                </h1>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12" id="accordion">
                @forelse ($elections as $election)
                    @isset($election->id)
                    <div class="card card-success card-outline">
                        <a class="d-block" data-toggle="collapse" href="#election-{{ $election->id }}">
                            <div class="card-header text-dark">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title">
                                        {{ $election->title }}
                                    </h4>
                                    <span>
                                        <label>Date:</label>
                                        {{ date('F d, Y', strtotime($election->end_date)) }}
                                    </span>
                                </div>
                            </div>
                        </a>
                        <div id="election-{{ $election->id }}" class="collapse @if($loop->first) show @endif" data-parent="#accordion">
                            <div class="card-body">
                                <div class="position-relative mb-4">
                                    <div class="row">
                                        @foreach ($election->candidates->groupBy('position_id') as $position => $candidates)
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-header border-0">
                                                        <div class="d-flex justify-content-between">
                                                            <h3 class="card-title">{{ App\Models\Configuration\Position::find($position)->name }}</h3>
                                                            {{-- <a href="javascript:void(0);">View Report</a> --}}
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <table class="table table-sm table-bordered">
                                                                    <tr>
                                                                        <th>Candidate</th>
                                                                        <th>partylist</th>
                                                                        <th>Vote</th>
                                                                    </tr>
                                                                    @foreach ($candidates as $candidate)
                                                                    <tr class="{{ $candidate->trashed() ? 'table-danger' : ''}}">
                                                                        <td>
                                                                            {{ $candidate->student->student_id}} - {{ $candidate->student->fullname('') }}
                                                                        </td>
                                                                        <td>
                                                                            {{ $candidate->partylist->name ?? "" }}
                                                                        </td>
                                                                        <td>
                                                                            {{ $candidate->votes->count() ?? "N/A" }}
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                                </table>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="position-relative">
                                                                    {!! $electionChart[$election->id][$position]->container() !!}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="position-relative">
                                                                    {!! $electionPieChart[$election->id][$position]->container() !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endisset
                @empty
                <h3 class="text-center text-danger">No Election Yet</h3>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
    <script src="{{ asset('AdminLTE-3.1.0/plugins/chart.js/Chart.min.js') }}"></script>
    @foreach ($elections as $election)
        @isset($election->id)
            @foreach ($election->candidates->groupBy('position_id') as $position => $candidates)
                {!! $electionChart[$election->id][$position]->script() !!}
                {!! $electionPieChart[$election->id][$position]->script() !!}
            @endforeach
        @endisset
    @endforeach
@endsection