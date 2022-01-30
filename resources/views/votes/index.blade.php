@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Votes</h1>
            </div>
            <div class="col-sm-6 text-right">
                @can('votes.create')
                    <button class="btn btn-default" type="button" data-toggle="modal-ajax" data-href="{{ route('votes.create') }}" data-target="#createVote"><i class="fa fa-plus"></i> Add</button>
                @endcan
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @hasrole('student')
                <div class="col">
                    <table id="datatable" class="table table-sm table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Election</th>
                                <th>Vote Number</th>
                                <th>Name</th>
                                @role('System Administrator')
                                <th class="text-center">Action</th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($votes as $index => $vote)
                            <tr @unlessrole('System Administrator') @can('votes.show') data-toggle="modal-ajax" data-target="#showVote" data-href="{{ route('votes.show', $vote->id) }}"  @endcan @else class="{{ $vote->trashed() ? 'table-danger' : '' }}" @endunlessrole>
                                <td>{{ $index+1 }}</td>
                                <td>{{ $vote->election->title }}</td>
                                <td>{{ $vote->vote_number }}</td>
                                <td>
                                    @if($vote->user->student)
                                    {{ $vote->user->student->student->fullname('') }}
                                    @elseif($vote->user->faculty)
                                    {{ $vote->user->faculty->student->fullname('') }}
                                    @endif
                                </td>
                                @role('System Administrator')
                                    <td class="text-center">
                                        <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#showVote" data-href="{{ route('votes.show',$vote->id) }}"><i class="fad fa-file fa-lg"></i></a>
                                        @if ($vote->trashed())
                                            <a class="text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('votes.restore', $vote->id) }}"><i class="fad fa-download fa-lg"></i></a>
                                        @else
                                            <a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('votes.destroy', $vote->id) }}"><i class="fad fa-trash-alt fa-lg"></i></a>
                                        @endif
                                    </td>
                                @endrole
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="col" id="accordion">
                    @foreach ($votes as $electionID => $votesByElection)
                        @php
                            $election = App\Models\Election::find($electionID);
                        @endphp
                        <div class="card card-primary card-outline">
                            <a class="d-block" data-toggle="collapse" href="#evaluation-{{ $electionID }}">
                                <div class="card-header d-flex p-0">
                                    <h4 class="card-title p-3 text-dark">
                                        {{ $election->title }}
                                        {!! $election->getStatusbadge() !!}
                                        |
                                        <i>
                                            <b>Date:</b>
                                            {{ date('F d, Y h:i A', strtotime($election->start_date)) }}
                                            -
                                            {{ date('F d, Y h:i A', strtotime($election->end_date)) }}
                                        </i>
                                    </h4>
                                </div>
                            </a>
                            <div id="evaluation-{{ $electionID }}" class="collapse @if($election->getStatus() == 'ongoing') show @endif" data-parent="#accordion">
                                <div class="card-body">
                                    <table class="table table-sm table-bordered table-hover datatable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Election</th>
                                                <th>Vote Number</th>
                                                <th>Name</th>
                                                @role('System Administrator')
                                                <th class="text-center">Action</th>
                                                @endrole
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($votesByElection as $index => $vote)
                                            <tr @unlessrole('System Administrator') @can('votes.show') data-toggle="modal-ajax" data-target="#showVote" data-href="{{ route('votes.show', $vote->id) }}"  @endcan @else class="{{ $vote->trashed() ? 'table-danger' : '' }}" @endunlessrole>
                                                <td>{{ $index+1 }}</td>
                                                <td>{{ $vote->election->title }}</td>
                                                <td>{{ $vote->vote_number }}</td>
                                                <td>
                                                    @if($vote->user->student)
                                                    {{ $vote->user->student->student->fullname('') }}
                                                    @elseif($vote->user->faculty)
                                                    {{ $vote->user->faculty->student->fullname('') }}
                                                    @endif
                                                </td>
                                                @role('System Administrator')
                                                    <td class="text-center">
                                                        <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#showVote" data-href="{{ route('votes.show',$vote->id) }}"><i class="fad fa-file fa-lg"></i></a>
                                                        @if ($vote->trashed())
                                                            <a class="text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('votes.restore', $vote->id) }}"><i class="fad fa-download fa-lg"></i></a>
                                                        @else
                                                            <a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('votes.destroy', $vote->id) }}"><i class="fad fa-trash-alt fa-lg"></i></a>
                                                        @endif
                                                    </td>
                                                @endrole
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @endhasrole
                @role('System Administrator')
                    @if(config('app.env') == 'local')
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                Random Vote
                            </div>
                            <div class="card-body">
                                <form class="form-horizontal" action="{{ route('votes.random_votes') }}" method="post">
                                    @csrf
                                    <hr>
                                    <div class="form-group">
                                        <label>Election: </label>
                                        <select class="form-control select2" name="election">
                                            <option></option>
                                            @foreach ($elections as $election)
                                                <option value="{{ $election->id }}">
                                                    {{ $election->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <hr>
                                    <button type="submit" class="btn btn-danger">Submit</button>					
                                </form>
                            </div>
                        </div>
                    </div>	
                    @endif
                @endrole
            </div>
        </div>
    </section>
</div>
@endsection