@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tasks</h1>
            </div>
            <div class="col-sm-6 text-right">
                @can('tasks.create')
                    <button class="btn btn-default" type="button" data-toggle="modal-ajax" data-href="{{ route('tasks.create') }}" data-target="#createTask"><i class="fa fa-plus"></i> Add</button>
                @endcan
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                @if(Auth::user()->isOfficer())
                    <div class="row">
                        <div class="col-md-8">
                            <table id="datatable" class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 50px"></th>
                                        <th>Task</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($tasks as $task)
                                    <tr {{-- class="{{ $task->is_done == 1 ? 'table-success' : '' }}" --}} @can('tasks.show') data-toggle="modal-ajax" data-target="#showTask" data-href="{{ route('tasks.show', $task->id) }}"  @endcan>
                                        <td class="text-center" style="width: 50px">
                                            @if($task->is_done == 1)
                                            <i class="fa fa-check text-lg text-success"></i>
                                            @endif
                                        </td>
                                        <td>{{ $task->task }}</td>
                                        <td>{{ $task->description }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td class="text-danger text-center" colspan="3">*** EMPTY ***</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4 text-center">
                            <legend>Progress</legend>
                            <div id="donut-chart" style="height: 300px;"></div>
                        </div>
                    </div>
                @else
                    <table id="datatable" class="table table-sm table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Status</th>
                                <th>Position</th>
                                <th>Officer</th>
                                <th>Task</th>
                                <th>Description</th>
                                @role('System Administrator')
                                <th class="text-center">Action</th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $index => $task)
                            <tr @unlessrole('System Administrator') @can('tasks.show') data-toggle="modal-ajax" data-target="#showTask" data-href="{{ route('tasks.show', $task->id) }}"  @endcan @else class="{{ $task->trashed() ? 'table-danger' : '' }}" @endunlessrole>
                                <td>{{ $index+1 }}</td>
                                <td>
                                    {{ $task->is_done ? "Done" : "Not yet done" }}
                                </td>
                                <td>{{ $task->student->getPosition() }}</td>
                                <td>{{ $task->student->getStudentName() }}</td>
                                <td>{{ $task->task }}</td>
                                <td>{{ $task->description }}</td>
                                @role('System Administrator')
                                    <td class="text-center">
                                        <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#showTask" data-href="{{ route('tasks.show',$task->id) }}"><i class="fad fa-file fa-lg"></i></a>
                                        @if ($task->trashed())
                                            <a class="text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('tasks.restore', $task->id) }}"><i class="fad fa-download fa-lg"></i></a>
                                        @else
                                            <a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('tasks.destroy', $task->id) }}"><i class="fad fa-trash-alt fa-lg"></i></a>
                                        @endif
                                    </td>
                                @endrole
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script src="{{ asset('AdminLTE-3.1.0/plugins/flot/jquery.flot.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/plugins/flot/plugins/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/plugins/flot/plugins/jquery.flot.pie.js') }}"></script>
{{-- @if($tasks) --}}
<script>
    $(function() {
        /*
        * DONUT CHART
        * -----------
        */

        var donutData = [
            @if($tasks->count() > 0)
            {
                label: 'Task Done',
                data : {{ $tasks->where('is_done', 1)->count() }},
                color: '#28a745'
            },
            {
                label: 'Remaining Task',
                data : {{ $tasks->where('is_done', 0)->count() }},
                color: '#fd7e14'
            }
            @else
            {
                label: 'No Task',
                data : 1,
                color: '#fd7e14'
            }
            @endif
        ]
        $.plot('#donut-chart', donutData, {
        series: {
            pie: {
                show       : true,
                radius     : 1,
                innerRadius: 0,
                label      : {
                    show     : true,
                    radius   : 2 / 3,
                    formatter: labelFormatter,
                    threshold: 0.1
                }
            }
        },
        legend: {
            show: false
        }
        })
        /*
        * END DONUT CHART
        */

        function labelFormatter(label, series) {
            return '<div style="font-size:13px; color: #000; font-weight: 600;">'
            + label
            + '<br>'
            + Math.round(series.percent) + '%</div>'
        }

    })
</script>
@endsection