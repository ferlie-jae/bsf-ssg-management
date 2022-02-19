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
                                <div class="row">
                                    <div class="col text-right">
                                        <a class="btn btn-primary" href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('elections.voters_statistics', $election->id) }}" data-target="#votersStatistics"><i class="fad fa-table"></i> Voters Statistics</a>
                                        <a class="btn btn-primary" href="{{ route('elections.export', ['election_id' => $election->id]) }}" target="_blank"><i class="fad fa-table"></i> Export Excel</a>
                                        @if ($election->trashed())
                                            @can('elections.restore')
                                            <a class="btn btn-default text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('elections.restore', $election->id) }}"><i class="fad fa-download"></i> Restore</a>
                                            @endcan
                                        @else
                                            @can('elections.destroy')
                                            <a class="btn btn-default text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('elections.destroy', $election->id) }}"><i class="fad fa-trash-alt"></i> Delete</a>
                                            @endcan
                                        @endif
                                        @can('elections.edit')
                                            <a class="btn btn-default text-primary" href="{{ route('elections.edit', $election->id) }}"><i class="fad fa-edit"></i> Edit</a>
                                        @endcan
                                    </div>
                                </div>
                                <hr>
                                <h3>Vote Statistics</h3>
                                <h5>Junior High School</h5>
                                <div class="row">
                                    @foreach ($gradeLevels->groupBy('grade_level') as $grade => $sections)
                                        @if($grade < 11)
                                            <div class="col-md-3">
                                                <div class="card card-success card-outline">
                                                    <div class="card-header">
                                                        <h4 class="card-title">Grade {{ $grade }}</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="position-relative">
                                                                    {!! $juniorHighVoteStatisticsChart[$election->id][$grade]->container() !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <hr>
                                <h5>Senior High School</h5>
                                <div class="row">
                                    @foreach ($gradeLevels->groupBy('grade_level') as $grade => $sections)
                                        @if($grade > 10)
                                            @foreach ($sections as $section)
                                                <div class="col-md-3">
                                                    <div class="card card-success card-outline">
                                                        <div class="card-header">
                                                            <h4 class="card-title">Grade {{ $grade }} | {{ $section->name }}</h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="position-relative">
                                                                        {!! $seniorHighVoteStatisticsChart[$election->id][$grade.'-'.$section->id]->container() !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </div>
                                <hr>
                                <div class="position-relative mb-4">
                                    <h3>Candidates</h3>
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
    {{-- {!! $juniorHighVoteStatisticsChart[1][7]->script() !!}
    {!! $juniorHighVoteStatisticsChart[1][8]->script() !!}
    {!! $juniorHighVoteStatisticsChart[1][9]->script() !!}
    {!! $juniorHighVoteStatisticsChart[1][10]->script() !!} --}}
    @foreach ($elections as $election)
        @isset($election->id)

            @foreach ($gradeLevels->groupBy('grade_level') as $grade => $sections)
                <script>
                    console.log('{{$grade}}')
                </script>
                @if($grade < 11)
                    <script>
                        var juniorHighVoteStatisticsChart = new Chart('{{ $juniorHighVoteStatisticsChart[$election->id][$grade]->id }}')
                    </script>
                    {!! $juniorHighVoteStatisticsChart[$election->id][$grade]->script() !!}
                @else
                    @foreach ($sections as $section)
                        <script>
                            var seniorHighVoteStatisticsChart = new Chart('{{ $seniorHighVoteStatisticsChart[$election->id][$grade."-".$section->id]->id }}')
                        </script>
                        {!! $seniorHighVoteStatisticsChart[$election->id][$grade."-".$section->id]->script() !!}
                    @endforeach
                @endif
            @endforeach

            @foreach ($election->candidates->groupBy('position_id') as $position => $candidates)
                <script>
                    var chart = new Chart('{{ $electionChart[$election->id][$position]->id }}')
                    var pieChart = new Chart('{{ $electionPieChart[$election->id][$position]->id }}')
                </script>
                {!! $electionChart[$election->id][$position]->script() !!}
                {!! $electionPieChart[$election->id][$position]->script() !!}
            @endforeach

        @endisset
    @endforeach
@endsection