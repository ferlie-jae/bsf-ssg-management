@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Election</h1>
            </div>
            <div class="col-sm-6 text-right">
                @isset($election->id)
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
                    @if($election->getStatus() == 'ongoing')
                        @can('elections.end')
                            <a class="btn btn-default text-success" href="{{ route('elections.end', $election->id) }}" ><i class="fad fa-stamp"></i> End</a>
                        @endcan
                    @endif
                @endisset
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        @isset($election->id)
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="mb-0">Status: </label>
                        {!! $election->getStatusBadge() !!}
                    </div>
                    <div class="form-group">
                        <label class="mb-0">Title: </label>
                        {{ $election->title }}
                    </div>
                    <div class="form-group">
                        <label class="mb-0">Description: </label>
                        {{ $election->description }}
                    </div>
                    <div class="form-group">
                        <label class="mb-0">Election Date: </label>
                        {{ date('F d, Y h:i A', strtotime($election->start_date)) }}
                        -
                        {{ date('F d, Y h:i A', strtotime($election->end_date)) }}
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-12" id="voteStatistics">
                    <div class="card card-success card-outline">
                        <a class="d-block" data-toggle="collapse" href="#election-{{ $election->id }}">
                            <div class="card-header text-dark">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title">
                                        Vote Statistics
                                    </h4>
                                </div>
                            </div>
                        </a>
                        <div id="election-{{ $election->id }}" class="collapse" data-parent="#voteStatistics">
                            <div class="card-body">
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
                                                                    {!! $juniorHighVoteStatisticsChart[$grade]->container() !!}
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
                                                                        {!! $seniorHighVoteStatisticsChart[$grade.'-'.$section->id]->container() !!}
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <legend>Candidates:</legend>
                @foreach ($election->candidates->groupBy('position_id') as $position => $candidates)
                <div class="col-md-6">
                    <label>{{ App\Models\Configuration\Position::find($position)->name }}</label><br>
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Candidate</th>
                                <th>Partlist</th>
                                <th>Votes</th>
                            </tr>
                        </thead>
                        <tbody>
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
                        </tbody>
                    </table>
                    {{-- <hr> --}}
                </div>
                @endforeach
            </div>
        @else
        <div class="row">
            <div class="col">
                <div class="alert alert-warning text-center">
                    No Active Elections
                </div>
                <div class="text-center">
                    @can('elections.create')
                    <a type="button" class="btn btn-primary" href="{{ route('elections.create') }}"><i class="fa fa-plus"></i> Create</a>
                    @endcan
                </div>
            </div>
        </div>
        @endisset
    </div>
</section>
@endsection
@section('script')
    @isset($election->id)
        <script src="{{ asset('AdminLTE-3.1.0/plugins/chart.js/Chart.min.js') }}"></script>
        @foreach ($gradeLevels->groupBy('grade_level') as $grade => $sections)
            @if($grade < 11)
                <script>
                    var juniorHighVoteStatisticsChart = new Chart('{{ $juniorHighVoteStatisticsChart[$grade]->id }}')
                </script>
                {!! $juniorHighVoteStatisticsChart[$grade]->script() !!}
            @else
                @foreach ($sections as $section)
                    <script>
                        var seniorHighVoteStatisticsChart = new Chart('{{ $seniorHighVoteStatisticsChart[$grade."-".$section->id]->id }}')
                    </script>
                    {!! $seniorHighVoteStatisticsChart[$grade."-".$section->id]->script() !!}
                @endforeach
            @endif
        @endforeach
    @endisset
@endsection