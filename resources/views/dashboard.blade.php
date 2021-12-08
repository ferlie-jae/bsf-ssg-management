@extends('layouts.adminlte')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div>
            <!-- /.col -->
            {{-- <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard v2</li>
                </ol>
            </div> --}}
            <!-- /.col -->
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-lock"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Users</span>
                        <span class="info-box-number">
                            {{ $users }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-list"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Task Done</span>
                        <span class="info-box-number">
                            {{ $taskDone }} out of
                            {{ $tasks }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="clearfix hidden-md-up"></div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-chalkboard-teacher"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Faculties</span>
                        <span class="info-box-number">
                            {{ $faculties }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users-class"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Students</span>
                        <span class="info-box-number">
                            {{ $students }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                @isset($election->id)
                <div class="card">
                    <div class="card-header text-center">
                        <h4 class="card-title">Ongoing Election</h4>
                    </div>
                    <div class="card-body">
                        <div class="position-relative mb-4">
                            @foreach ($election->candidates->groupBy('position_id') as $position => $candidates)
                                <div class="row">
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
                                                    <div class="col-md-6">
                                                        <div class="position-relative mb-4">
                                                            {!! $electionChart[$position]->container() !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="position-relative mb-4">
                                                            {!! $electionPieChart[$position]->container() !!}
                                                        </div>
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
                @endisset
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
    <script src="{{ asset('AdminLTE-3.1.0/plugins/chart.js/Chart.min.js') }}"></script>
    @isset($election->id)
        @foreach ($election->candidates->groupBy('position_id') as $position => $candidates)
            {!! $electionChart[$position]->script() !!}
            {!! $electionPieChart[$position]->script() !!}
        @endforeach
    @endisset
@endsection