@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $election->title }}</h1>
            </div>
            <div class="col-sm-6 text-right">
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
                @can('elections.end')
                    <a class="btn btn-default text-success" href="{{ route('elections.end', $election->id) }}" ><i class="fad fa-stamp"></i> End</a>
                @endcan
                <a class="btn btn-primary" href="{{ route('elections.export', ['election_id' => $election->id]) }}" target="_blank"><i class="fad fa-table"></i> Export Excel</a>
                <a class="btn btn-default" href="{{ route('elections.index') }}" ><i class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="mb-0">Status: </label>
                    {{ $election->status }}
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
                                {{ $candidate->student->student_id}} - {{ $candidate->student->getStudentName($candidate->student_id) }}
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
    </div>
</div>
@endsection